<?php

class ReceivingInventoryController extends Controller {
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
                'actions' => array('create', 'update', 'data', 'oldCreate', 'loadSkuDetails', 'skuData', 'receivingInvDetailData', 'uploadAttachment', 'preview', 'deleteByUrl', 'download'),
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

        ReceivingInventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = ReceivingInventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = ReceivingInventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {

            $c = new CDbCriteria;
            $c->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
            $c->condition = 'company_id = "' . Yii::app()->user->company_id . '" AND employee_id = "' . $value->requestor . '"';
            $employee = Employee::model()->find($c);

            $row = array();
            $row['receiving_inventory_id'] = $value->receiving_inventory_id;
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;
            $row['pr_date'] = $value->pr_date;
            $row['dr_no'] = $value->dr_no;
            $row['requestor'] = $value->requestor;
            $row['requestor_name'] = isset($employee->fullname) ? $employee->fullname : null;
            $row['supplier_id'] = $value->supplier_id;
            $row['supplier_name'] = isset($value->supplier->supplier_name) ? $value->supplier->supplier_name : null;
            $row['zone_id'] = $value->zone_id;
            $row['zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
            $row['plan_delivery_date'] = $value->plan_delivery_date;
            $row['revised_delivery_date'] = $value->revised_delivery_date;
            $row['actual_delivery_date'] = $value->actual_delivery_date;
            $row['plan_arrival_date'] = $value->plan_arrival_date;
            $row['transaction_date'] = $value->transaction_date;
            $row['delivery_remarks'] = $value->delivery_remarks;
            $row['total_amount'] = $value->total_amount;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/inventory/receivinginventory/view', array('id' => $value->receiving_inventory_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/inventory/receivinginventory/update', array('id' => $value->receiving_inventory_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/inventory/receivinginventory/delete', array('id' => $value->receiving_inventory_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionSkuData() {

        ini_set('memory_limit', '-1');

        ReceivingInventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = ReceivingInventory::model()->skuData($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Sku::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['sku_id'] = $value->sku_id;
            $row['sku_code'] = $value->sku_code;
            $row['brand_id'] = $value->brand_id;
            $row['brand_name'] = isset($value->brand->brand_name) ? $value->brand->brand_name : null;
            $row['brand_category'] = isset($value->brand->brandCategory->category_name) ? $value->brand->brandCategory->category_name : null;
            $row['sku_name'] = $value->sku_name;
            $row['description'] = $value->description;
            $row['default_uom_id'] = $value->default_uom_id;
            $row['default_uom_name'] = isset($value->defaultUom->uom_name) ? $value->defaultUom->uom_name : null;
            $row['default_unit_price'] = $value->default_unit_price;
            $row['type'] = $value->type;
            $row['sub_type'] = $value->sub_type;
            $row['default_zone_id'] = $value->default_zone_id;
            $row['default_zone_name'] = isset($value->defaultZone->zone_name) ? $value->defaultZone->zone_name : null;
            $row['supplier'] = $value->supplier;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;
            $row['low_qty_threshold'] = $value->low_qty_threshold;
            $row['high_qty_threshold'] = $value->high_qty_threshold;

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionReceivingInvDetailData($receiving_inv_id) {

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("receiving_inventory_id", $receiving_inv_id);
        $receiving_inv_details = ReceivingInventoryDetail::model()->findAll($c);

        $output = array();
        foreach ($receiving_inv_details as $key => $value) {
            $row = array();
            $row['receiving_inventory_detail_id'] = $value->receiving_inventory_detail_id;
            $row['receiving_inventory_id'] = $value->receiving_inventory_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['quantity_received'] = $value->quantity_received;
            $row['uom_name'] = isset($value->uom->uom_name) ? $value->uom->uom_name : null;
            $row['sku_status_name'] = isset($value->skuStatus->status_name) ? $value->skuStatus->status_name : null;
            $row['planned_quantity'] = $value->planned_quantity;
            $row['quantity_received'] = $value->quantity_received;
            $row['amount'] = $value->amount;
            $row['inventory_on_hand'] = $value->inventory_on_hand;
            $row['remarks'] = $value->remarks;

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

        $this->pageTitle = 'View ReceivingInventory ' . $model->receiving_inventory_id;

        $this->menu = array(
            array('label' => 'Create ReceivingInventory', 'url' => array('create')),
            array('label' => 'Update ReceivingInventory', 'url' => array('update', 'id' => $model->receiving_inventory_id)),
            array('label' => 'Delete ReceivingInventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->receiving_inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage ReceivingInventory', 'url' => array('admin')),
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
    public function actionOldCreate() {

        $this->pageTitle = 'Create ReceivingInventory';

        $this->menu = array(
            array('label' => 'Manage ReceivingInventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new ReceivingInventory('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ReceivingInventory'])) {
            $model->attributes = $_POST['ReceivingInventory'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);

            $model->receiving_inventory_id = Globals::generateV4UUID();

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully created");
                $this->redirect(array('view', 'id' => $model->receiving_inventory_id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        $this->pageTitle = ReceivingInventory::RECEIVING_LABEL . ' Inventory';
        $this->layout = '//layouts/column1';

        $receiving = new ReceivingInventory;
        $transaction_detail = new ReceivingInventoryDetail;
        $sku = new Sku;
        $model = new Attachment;

        $c = new CDbCriteria;
        $c->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
        $c->condition = 'company_id = "' . Yii::app()->user->company_id . '"';
        $c->order = 'fullname ASC';
        $employee = CHtml::listData(Employee::model()->findAll($c), 'employee_id', 'fullname');

        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $supplier_list = CHtml::listData(Supplier::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'supplier_name ASC')), 'supplier_id', 'supplier_name');
        $delivery_remarks = CHtml::listData(ReceivingInventory::model()->getDeliveryRemarks(), 'id', 'title');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['ReceivingInventory'])) {
                    $receiving->attributes = $_POST['ReceivingInventory'];
                    $receiving->company_id = Yii::app()->user->company_id;
                    $receiving->created_by = Yii::app()->user->name;
                    unset($receiving->created_date);

                    $validatedReceiving = CActiveForm::validate($receiving);

                    if ($validatedReceiving != '[]') {

                        $data['error'] = $validatedReceiving;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {

                        $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                        if ($receiving->create($transaction_details)) {
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

                if (isset($_POST['ReceivingInventoryDetail'])) {
                    $transaction_detail->attributes = $_POST['ReceivingInventoryDetail'];
                    $transaction_detail->company_id = Yii::app()->user->company_id;
                    $transaction_detail->created_by = Yii::app()->user->name;
                    unset($transaction_detail->created_date);

                    $validatedReceivingDetail = CActiveForm::validate($transaction_detail);

                    if ($validatedReceivingDetail != '[]') {

                        $data['error'] = $validatedReceivingDetail;
                    } else {

                        $c = new CDbCriteria;
                        $c->compare('t.company_id', Yii::app()->user->company_id);
                        $c->compare('t.sku_id', $transaction_detail->sku_id);
                        $c->with = array('brand', 'company', 'defaultUom', 'defaultZone');
                        $sku_details = Sku::model()->find($c);

                        $data['message'] = 'Added Item Successfully';
                        $data['success'] = true;

                        $data['details'] = array(
                            "sku_id" => isset($sku_details->sku_id) ? $sku_details->sku_id : null,
                            "sku_code" => isset($sku_details->sku_code) ? $sku_details->sku_code : null,
                            "sku_description" => isset($sku_details->description) ? $sku_details->description : null,
                            'brand_name' => isset($sku_details->brand->brand_name) ? $sku_details->brand->brand_name : null,
                            'unit_price' => $transaction_detail->unit_price != "" ? $transaction_detail->unit_price : 0,
                            'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                            'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                            'planned_quantity' => $transaction_detail->planned_quantity != "" ? $transaction_detail->planned_quantity : 0,
                            'quantity_received' => $transaction_detail->quantity_received != "" ? $transaction_detail->quantity_received : 0,
                            'uom_id' => isset($transaction_detail->uom->uom_id) ? $transaction_detail->uom->uom_id : null,
                            'uom_name' => isset($transaction_detail->uom->uom_name) ? $transaction_detail->uom->uom_name : null,
                            'sku_status_id' => isset($transaction_detail->skuStatus->sku_status_id) ? $transaction_detail->skuStatus->sku_status_id : null,
                            'sku_status_name' => isset($transaction_detail->skuStatus->status_name) ? $transaction_detail->skuStatus->status_name : null,
                            'amount' => $transaction_detail->amount != "" ? $transaction_detail->amount : 0,
                            'inventory_on_hand' => $transaction_detail->inventory_on_hand != "" ? $transaction_detail->inventory_on_hand : 0,
                            'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                        );
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $this->render('receivingForm', array(
            'receiving' => $receiving,
            'supplier_list' => $supplier_list,
            'delivery_remarks' => $delivery_remarks,
            'transaction_detail' => $transaction_detail,
            'sku' => $sku,
            'uom' => $uom,
            'employee' => $employee,
            'sku_status' => $sku_status,
            'model' => $model,
        ));
    }

    public function actionLoadSkuDetails() {

        $sku_id = Yii::app()->request->getParam('sku_id');

        if ($sku_id != "") {
            $c = new CDbCriteria;
            $c->select = 't.*, sum(t.qty) AS inventory_on_hand';
            $c->compare('t.company_id', Yii::app()->user->company_id);
            $c->compare('t.sku_id', $sku_id);
            $c->group = "t.sku_id";
            $inventory = Inventory::model()->find($c);

            $sku = Sku::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sku_id" => $sku_id));
        }

        $data = array(
            "sku_category" => isset($sku->type) ? $sku->type : null,
            "sku_sub_category" => isset($sku->sub_type) ? $sku->sub_type : null,
            'brand_name' => isset($sku->brand->brand_name) ? $sku->brand->brand_name : null,
            'sku_code' => isset($sku->sku_code) ? $sku->sku_code : null,
            'sku_description' => isset($sku->description) ? $sku->description : null,
            'sku_default_uom_id' => isset($sku->defaultUom->uom_id) ? $sku->defaultUom->uom_id : null,
            'sku_default_uom_name' => isset($sku->defaultUom->uom_name) ? $sku->defaultUom->uom_name : null,
            'default_unit_price' => isset($sku->default_unit_price) ? $sku->default_unit_price : 0,
            'inventory_on_hand' => isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0,
        );

        echo json_encode($data);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create ReceivingInventory', 'url' => array('create')),
            array('label' => 'View ReceivingInventory', 'url' => array('view', 'id' => $model->receiving_inventory_id)),
            array('label' => 'Manage ReceivingInventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update ReceivingInventory ' . $model->receiving_inventory_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ReceivingInventory'])) {
            $model->attributes = $_POST['ReceivingInventory'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->receiving_inventory_id));
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
            $this->deleteByUrl($id); ///julius code
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
        $dataProvider = new CActiveDataProvider('ReceivingInventory');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . ReceivingInventory::RECEIVING_LABEL . ' Inventory';

        $model = new ReceivingInventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ReceivingInventory']))
            $model->attributes = $_GET['ReceivingInventory'];

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
        $model = ReceivingInventory::model()->findByAttributes(array('receiving_inventory_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'receiving-inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

//julius code
    public function actionUploadAttachment() {
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        $data = array();
        $model = new Attachment;

        if (isset($_FILES['Attachment']['name']) && $_FILES['Attachment']['name'] != "") {

            $file = CUploadedFile::getInstance($model, 'file');
//         $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'attachment' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR .Yii::app()->session['tid'];
            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'receiving' . DIRECTORY_SEPARATOR . Yii::app()->session['tid'];
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
//         $url = Yii::app()->getBaseUrl(true) . '/attachment/' . Yii::app()->user->company_id . '/' . Yii::app()->session['tid'] . '/' . $file_name;
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/receiving/' . Yii::app()->session['tid'] . '/' . $file_name;
            $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

            $model->attachment_id = Globals::generateV4UUID();

            $model->company_id = Yii::app()->user->company_id;
            $model->file_name = $file_name;
            $model->url = $url;
            $model->transaction_id = Yii::app()->session['tid'];
            $model->transaction_type = 'receiving';
            $model->created_by = Yii::app()->user->name;

            if ($model->save()) {

                $data[] = array(
                    'name' => $file->name,
                    'type' => $file->type,
                    'size' => $file->size,
                    'url' => $dir . DIRECTORY_SEPARATOR . $file_name,
                    'thumbnail_url' => $dir . DIRECTORY_SEPARATOR . $file_name,
//                    'delete_url' => $this->createUrl('my/delete', array('id' => 1, 'method' => 'uploader')),
//                    'delete_type' => 'POST',
                );
            } else {

                if ($model->hasErrors()) {

                    $data[] = array('error', $model->getErrors());
                }
            }
        } else {

            throw new CHttpException(500, "Could not upload file " . CHtml::errorSummary($model));
        }


        echo json_encode($data);
    }

    function actionPreview($id) {
        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("transaction_id", $id);
        $attachment = Attachment::model()->findAll($c);

        $output = array();
        foreach ($attachment as $key => $value) {
            $row = array();
            $row['file_name'] = $value->file_name;
            $row['links'] = '<a class="view" title="Download" data-toggle="tooltip" href="' . $this->createUrl('/inventory/receivinginventory/download', array('id' => $value->attachment_id)) . '" data-original-title="Download"><button type="submit" class="btn btn-default btn-flat">
            <i class="icon-download icon-white"></i>
            <i class="glyphicon glyphicon-download"></i>
           
            </button></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/inventory/receivinginventory/deletebyurl', array('id' => $value->attachment_id)) . '" data-original-title="Delete"><button type="button" class="btn btn-default btn-flat">
            <i class="glyphicon glyphicon-trash"></i>
            
            </button></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    function actionDeleteByUrl($id) {

        $sql = "SELECT url FROM noc.attachment WHERE attachment_id = :attachment_id AND company_id = '" . Yii::app()->user->company_id . "'";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':attachment_id', $id, PDO::PARAM_STR);
        $data = $command->queryAll();
        foreach ($data as $key => $value) {
            $url = $value['url'];
        }
        //$url = substr($url, 16);
        $base = Yii::app()->getBaseUrl(true);
        $arr = explode("/", $base);
        $base = $arr[count($arr) - 1];
        $url = str_replace(Yii::app()->getBaseUrl(true), "", $url);
        //pre('../' .$base . $url);
        unlink('../' . $base . $url);

        $sql = "DELETE FROM noc.attachment WHERE attachment_id = :attachment_id AND company_id = '" . Yii::app()->user->company_id . "'";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':attachment_id', $id, PDO::PARAM_STR);
        $data = $command->query();

        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDownload($id) {

        $sql = "SELECT url, file_name FROM noc.attachment WHERE attachment_id = :attachment_id AND company_id = '" . Yii::app()->user->company_id . "'";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':attachment_id', $id, PDO::PARAM_STR);
        $data = $command->queryAll();
        foreach ($data as $key => $value) {
            $url = $value['url'];
            $name = $value['file_name'];
        }
        $model = new ReceivingInventory;


//      $name = $_GET['file'];
//      $upload_path = Yii::app()->params['uploadPath'];
        $base = Yii::app()->getBaseUrl(true);
        $arr = explode("/", $base);
        $base = $arr[count($arr) - 1];
        $url = str_replace(Yii::app()->getBaseUrl(true), "", $url);

        if (file_exists('../' . $base . $url)) {
            Yii::app()->getRequest()->sendFile($name, file_get_contents('../' . $base . $url));
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else {
            
        }
    }

    ///////////////////////
}
