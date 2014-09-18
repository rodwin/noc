
<?php

class OutgoingInventoryController extends Controller {
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
                'actions' => array('create', 'update', 'data', 'loadInventoryDetails', 'outgoingInvDetailData', 'afterDeleteTransactionRow'),
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

        OutgoingInventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = OutgoingInventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = OutgoingInventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
            $row['rra_no'] = $value->rra_no;
            $row['rra_name'] = $value->rra_name;
            $row['destination_zone_id'] = $value->destination_zone_id;
            $row['destination_zone_name'] = $value->zone->zone_name;
            $row['contact_person'] = $value->contact_person;
            $row['contact_no'] = $value->contact_no;
            $row['address'] = $value->address;
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;
            $row['pr_date'] = $value->pr_date;
            $row['plan_delivery_date'] = $value->plan_delivery_date;
            $row['revised_delivery_date'] = $value->revised_delivery_date;
            $row['actual_delivery_date'] = $value->actual_delivery_date;
            $row['plan_arrival_date'] = $value->plan_arrival_date;
            $row['transaction_date'] = $value->transaction_date;
            $row['total_amount'] = $value->total_amount;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/inventory/outgoinginventory/view', array('id' => $value->outgoing_inventory_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/inventory/outgoinginventory/update', array('id' => $value->outgoing_inventory_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/inventory/outgoinginventory/delete', array('id' => $value->outgoing_inventory_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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

        $this->pageTitle = 'View OutgoingInventory ' . $model->outgoing_inventory_id;

        $this->menu = array(
            array('label' => 'Create OutgoingInventory', 'url' => array('create')),
            array('label' => 'Update OutgoingInventory', 'url' => array('update', 'id' => $model->outgoing_inventory_id)),
            array('label' => 'Delete OutgoingInventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->outgoing_inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage OutgoingInventory', 'url' => array('admin')),
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

        $this->pageTitle = 'Create Outgoing Inventory';
        $this->layout = '//layouts/column1';

        $outgoing = new OutgoingInventory;
        $transaction_detail = new OutgoingInventoryDetail;
        $sku = new Sku;

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['OutgoingInventory'])) {
                    $outgoing->attributes = $_POST['OutgoingInventory'];
                    $outgoing->company_id = Yii::app()->user->company_id;
                    $outgoing->created_by = Yii::app()->user->name;
                    unset($outgoing->created_date);

                    $validatedOutgoing = CActiveForm::validate($outgoing);

                    if ($validatedOutgoing != '[]') {

                        $data['error'] = $validatedOutgoing;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {

                        $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                        if ($outgoing->create($transaction_details)) {
                            $data['message'] = 'Successfully created';
                            $data['success'] = true;
                        } else {
                            $data['message'] = 'Unable to process';
                            $data['success'] = false;
                            $data["type"] = "danger";
                        }
                    }
                }
            } else if ($_POST['form'] == "details") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['OutgoingInventoryDetail'])) {
                    $transaction_detail->attributes = $_POST['OutgoingInventoryDetail'];
                    $transaction_detail->company_id = Yii::app()->user->company_id;
                    $transaction_detail->created_by = Yii::app()->user->name;
                    unset($transaction_detail->created_date);

                    $validatedReceivingDetail = CActiveForm::validate($transaction_detail);

                    if ($validatedReceivingDetail != '[]') {

                        $data['error'] = $validatedReceivingDetail;
                    } else {

                        $c = new CDbCriteria;
                        $c->select = 't.*, sum(t.qty) AS inventory_on_hand';
                        $c->compare('t.company_id', Yii::app()->user->company_id);
                        $c->compare('t.inventory_id', $transaction_detail->inventory_id);
                        $c->group = "t.sku_id";
                        $c->with = array("sku");
                        $inventory = Inventory::model()->find($c);

//                        if (isset($transaction_detail->inventory_on_hand) && isset($transaction_detail->quantity_issued)) {
//                            $qty = $transaction_detail->inventory_on_hand - $transaction_detail->quantity_issued;
//                            $this->updateInvByInvID($transaction_detail->inventory_id, $transaction_detail->company_id, $qty);
//                        }

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
                            'source_zone_name' => isset($transaction_detail->zone->zone_name) ? $transaction_detail->zone->zone_name : null,
                            'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                            'planned_quantity' => isset($transaction_detail->planned_quantity) ? $transaction_detail->planned_quantity : 0,
                            'quantity_issued' => isset($transaction_detail->quantity_issued) ? $transaction_detail->quantity_issued : 0,
                            'amount' => isset($transaction_detail->amount) ? $transaction_detail->amount : 0,
                            'inventory_on_hand' => isset($transaction_detail->inventory_on_hand) ? $transaction_detail->inventory_on_hand : 0,
                            'reference_no' => isset($transaction_detail->pr_no) ? $transaction_detail->pr_no : null,
                            'return_date' => isset($transaction_detail->return_date) ? $transaction_detail->return_date : null,
                            'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                        );
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $this->render('outgoingForm', array(
            'outgoing' => $outgoing,
            'transaction_detail' => $transaction_detail,
            'sku' => $sku,
        ));
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
            "sku_id" => isset($sku->sku_id) ? $sku->sku_id : null,
            "sku_category" => isset($sku->type) ? $sku->type : null,
            "sku_sub_category" => isset($sku->sub_type) ? $sku->sub_type : null,
            'brand_name' => isset($sku->brand->brand_name) ? $sku->brand->brand_name : null,
            'sku_code' => isset($sku->sku_code) ? $sku->sku_code : null,
            'sku_description' => isset($sku->description) ? $sku->description : null,
            'inventory_uom_selected' => isset($inventory->uom->uom_name) ? $inventory->uom->uom_name : null,
            'source_zone_id' => isset($inventory->zone_id) ? $inventory->zone_id : null,
            'source_zone_name' => isset($inventory->zone->zone_name) ? $inventory->zone->zone_name : null,
            'unit_price' => isset($inventory->cost_per_unit) ? $inventory->cost_per_unit : 0,
            'reference_no' => isset($inventory->reference_no) ? $inventory->reference_no : null,
            'inventory_on_hand' => isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0,
        );

        echo json_encode($data);
    }

    public function actionOutgoingInvDetailData($outgoing_inv_id) {

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("outgoing_inventory_id", $outgoing_inv_id);
        $outgoing_inv_details = OutgoingInventoryDetail::model()->findAll($c);

        $output = array();
        foreach ($outgoing_inv_details as $key => $value) {
            $row = array();
            $row['outgoing_inventory_detail_id'] = $value->outgoing_inventory_detail_id;
            $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['source_zone_id'] = $value->source_zone_id;
            $row['source_zone_name'] = $value->zone->zone_name;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['planned_quantity'] = $value->planned_quantity;
            $row['quantity_issued'] = $value->quantity_issued;
            $row['amount'] = $value->amount;
            $row['inventory_on_hand'] = $value->inventory_on_hand;
            $row['return_date'] = $value->return_date;
            $row['remarks'] = $value->remarks;

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionAfterDeleteTransactionRow($inventory_id, $quantity) {
//        $inventory = Inventory::model()->findbyAttributes(array("company_id" => Yii::app()->user->company_id, "inventory_id" => $inventory_id));
//        $qty = ($inventory->qty + $quantity);

//        $this->updateInvByInvID($inventory_id, Yii::app()->user->company_id, $qty);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create OutgoingInventory', 'url' => array('create')),
            array('label' => 'View OutgoingInventory', 'url' => array('view', 'id' => $model->outgoing_inventory_id)),
            array('label' => 'Manage OutgoingInventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update OutgoingInventory ' . $model->outgoing_inventory_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OutgoingInventory'])) {
            $model->attributes = $_POST['OutgoingInventory'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->outgoing_inventory_id));
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
        $dataProvider = new CActiveDataProvider('OutgoingInventory');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Outgoing Inventory';

        $model = new OutgoingInventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OutgoingInventory']))
            $model->attributes = $_GET['OutgoingInventory'];

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
        $model = OutgoingInventory::model()->findByAttributes(array('outgoing_inventory_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'outgoing-inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
