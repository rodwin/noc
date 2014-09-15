<?php

class MovingInventoryController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'data', 'loadFormDetails', 'loadInventoryDetails', 'addItem'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        MovingInventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = MovingInventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = MovingInventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['moving_inventory_id'] = $value->moving_inventory_id;
            $row['transaction_date'] = $value->transaction_date;
            $row['total_amount'] = $value->total_amount;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


//            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/inventory/movinginventory/view', array('id' => $value->moving_inventory_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
//                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/inventory/movinginventory/update', array('id' => $value->moving_inventory_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
//                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/inventory/movinginventory/delete', array('id' => $value->moving_inventory_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'View MovingInventory ' . $model->moving_inventory_id;

        $this->menu = array(
            array('label' => 'Create MovingInventory', 'url' => array('create')),
            array('label' => 'Update MovingInventory', 'url' => array('update', 'id' => $model->moving_inventory_id)),
            array('label' => 'Delete MovingInventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->moving_inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage MovingInventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pageTitle = 'Create Goods Movement Inventory';
        $this->layout = '//layouts/column1';

        $moving = new MovingInventory;
        $transaction_detail = new MovingInventoryDetail;
        $sku = new Sku;

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data['type'] = "success";

            if ($_POST['form'] == "transaction") {

                if (isset($_POST['MovingInventory'])) {
                    $moving->attributes = $_POST['MovingInventory'];
                    $moving->company_id = Yii::app()->user->company_id;
                    $moving->created_by = Yii::app()->user->name;
                    unset($moving->created_date);

                    $validatedOutgoing = CActiveForm::validate($moving);

                    if ($validatedOutgoing != '[]') {

                        $data['error'] = $validatedOutgoing;
                    } else {

                        $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                        if ($moving->create($transaction_details)) {
                            $data['form'] = "transaction";
                            $data['message'] = 'Successfully moved items';
                            $data['success'] = true;
                        } else {
                            $data['form'] = "transaction";
                            $data['message'] = 'Unable to process';
                            $data['success'] = false;
                            $data["type"] = "danger";
                        }
                    }
                }
            } else {

                if (isset($_POST['MovingInventoryDetail'])) {
                    $transaction_detail->attributes = $_POST['MovingInventoryDetail'];
                    $transaction_detail->company_id = Yii::app()->user->company_id;
                    $transaction_detail->created_by = Yii::app()->user->name;
                    unset($transaction_detail->created_date);

                    $validatedIncomingDetail = CActiveForm::validate($transaction_detail);

                    if ($validatedIncomingDetail != '[]') {

                        $data['error'] = $validatedIncomingDetail;
                    } else {

                        $c = new CDbCriteria;
                        $c->select = 't.*, sum(t.qty) AS inventory_on_hand';
                        $c->compare('t.company_id', Yii::app()->user->company_id);
                        $c->compare('t.inventory_id', $transaction_detail->inventory_id);
                        $c->group = "t.sku_id";
                        $c->with = array("sku");
                        $inventory = Inventory::model()->find($c);
                        
                        $data['form'] = "details";
                        $data['message'] = 'Successfully Added Item';
                        $data['success'] = true;

                        $data['details'] = array(
                            "inventory_id" => isset($inventory->inventory_id) ? $inventory->inventory_id : null,
                            "sku_id" => isset($inventory->sku->sku_id) ? $inventory->sku->sku_id : null,
                            "sku_code" => isset($inventory->sku->sku_code) ? $inventory->sku->sku_code : null,
                            "sku_description" => isset($inventory->sku->description) ? $inventory->sku->description : null,
                            'brand_name' => isset($inventory->sku->brand->brand_name) ? $inventory->sku->brand->brand_name : null,
                            'unit_price' => isset($transaction_detail->unit_price) ? $transaction_detail->unit_price : 0,
                            'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                            'source_zone_id' => isset($transaction_detail->source_zone_id) ? $transaction_detail->source_zone_id : null,
                            'source_zone_name' => isset($transaction_detail->sourceZone->zone_name) ? $transaction_detail->sourceZone->zone_name : null,
                            'destination_zone_id' => isset($transaction_detail->destination_zone_id) ? $transaction_detail->destination_zone_id : null,
                            'destination_zone_name' => isset($transaction_detail->destinationZone->zone_name) ? $transaction_detail->destinationZone->zone_name : null,
                            'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                            'quantity' => isset($transaction_detail->quantity) ? $transaction_detail->quantity : 0,
                            'amount' => isset($transaction_detail->amount) ? $transaction_detail->amount : 0,
                            'inventory_on_hand' => isset($transaction_detail->inventory_on_hand) ? $transaction_detail->inventory_on_hand : 0,
                            'reference_no' => isset($transaction_detail->pr_no) ? $transaction_detail->pr_no : null,
                            'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                        );
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $this->render('movingForm', array(
            'moving' => $moving,
            'transaction_detail' => $transaction_detail,
            'sku' => $sku,
        ));
    }

    public function actionLoadFormDetails() {
        $transaction_detail = new MovingInventoryDetail;
        $sku = new Sku;

        echo CJSON::encode(array($this->renderPartial('_movingInventoryDetails', array(
                'transaction_detail' => $transaction_detail,
                'sku' => $sku,
                    ), true)));

        Yii::app()->end();
    }

    public function actionLoadInventoryDetails() {

        $inventory_id = Yii::app()->request->getParam('inventory_id');

        if ($inventory_id != "") {
            $c = new CDbCriteria;
            $c->select = 't.*, sum(t.qty) AS inventory_on_hand';
            $c->compare('t.company_id', Yii::app()->user->company_id);
            $c->compare('t.inventory_id', $inventory_id);
            $c->group = "t.sku_id";
            $inventory = Inventory::model()->find($c);

            $sku = Sku::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sku_id" => $inventory->sku_id));
        }

        $data = array(
            "inventory_id" => $inventory_id != "" ? $inventory_id : null,
            "sku_id" => isset($sku->sku_id) ? $sku->sku_id : null,
            "sku_category" => isset($sku->type) ? $sku->type : null,
            "sku_sub_category" => isset($sku->sub_type) ? $sku->sub_type : null,
            'brand_name' => isset($sku->brand->brand_name) ? $sku->brand->brand_name : null,
            'sku_code' => isset($sku->sku_code) ? $sku->sku_code : null,
            'sku_description' => isset($sku->description) ? $sku->description : null,
            'inventory_uom_selected' => isset($inventory->uom->uom_name) ? $inventory->uom->uom_name : null,
            'source_zone_id' => isset($inventory->zone_id) ? $inventory->zone_id : null,
            'source_zone_name' => isset($inventory->zone->zone_name) ? $inventory->zone->zone_name : null,
            'unit_price' => isset($inventory->cost_per_unit) ? $inventory->cost_per_unit : null,
            'reference_no' => isset($inventory->reference_no) ? $inventory->reference_no : null,
            'inventory_on_hand' => isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0,
        );

        echo json_encode($data);
    }

    public function actionAddItem() {
        $transaction_detail = new MovingInventoryDetail;

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;

            if (isset($_POST['MovingInventoryDetail'])) {
                $transaction_detail->attributes = $_POST['MovingInventoryDetail'];
                $transaction_detail->company_id = Yii::app()->user->company_id;
                $transaction_detail->created_by = Yii::app()->user->name;
                unset($transaction_detail->created_date);

                $validatedIncomingDetail = CActiveForm::validate($transaction_detail);

                if ($validatedIncomingDetail != '[]') {

                    $data['error'] = $validatedIncomingDetail;
                } else {

                    $c = new CDbCriteria;
                    $c->compare('t.company_id', Yii::app()->user->company_id);
                    $c->compare('t.sku_id', $transaction_detail->sku_id);
                    $c->with = array('brand', 'company', 'defaultUom', 'defaultZone');
                    $sku_details = Sku::model()->find($c);

                    $data['form'] = "details";
                    $data['message'] = 'Successfully Added Item';
                    $data['success'] = true;

                    $data['details'] = array(
                        "sku_id" => isset($sku_details->sku_id) ? $sku_details->sku_id : null,
                        "sku_code" => isset($sku_details->sku_code) ? $sku_details->sku_code : null,
                        "sku_description" => isset($sku_details->description) ? $sku_details->description : null,
                        'brand_name' => isset($sku_details->brand->brand_name) ? $sku_details->brand->brand_name : null,
                        'unit_price' => isset($transaction_detail->unit_price) ? $transaction_detail->unit_price : null,
                        'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                        'source_zone_id' => isset($transaction_detail->source_zone_id) ? $transaction_detail->source_zone_id : null,
                        'source_zone_name' => isset($transaction_detail->sourceZone->zone_name) ? $transaction_detail->sourceZone->zone_name : null,
                        'destination_zone_id' => isset($transaction_detail->destination_zone_id) ? $transaction_detail->destination_zone_id : null,
                        'destination_zone_name' => isset($transaction_detail->destinationZone->zone_name) ? $transaction_detail->destinationZone->zone_name : null,
                        'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                        'quantity_received' => isset($transaction_detail->quantity_received) ? $transaction_detail->quantity_received : null,
                        'amount' => isset($transaction_detail->amount) ? $transaction_detail->amount : null,
                        'inventory_on_hand' => isset($transaction_detail->inventory_on_hand) ? $transaction_detail->inventory_on_hand : null,
                        'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                    );
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create MovingInventory', 'url' => array('create')),
            array('label' => 'View MovingInventory', 'url' => array('view', 'id' => $model->moving_inventory_id)),
            array('label' => 'Manage MovingInventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update MovingInventory ' . $model->moving_inventory_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MovingInventory'])) {
            $model->attributes = $_POST['MovingInventory'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->moving_inventory_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('success', "Successfully deleted");
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else {

                echo "Successfully deleted";
                exit;
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('MovingInventory');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Moved Inventory';

        $model = new MovingInventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MovingInventory']))
            $model->attributes = $_GET['MovingInventory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = MovingInventory::model()->findByAttributes(array('moving_inventory_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'moving-inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
