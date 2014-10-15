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
                'actions' => array('create', 'update', 'data', 'oldCreate', 'loadSkuDetails', 'skuData', 'receivingInvDetailData', 'uploadAttachment', 'preview', 'download', 'deleteReceivingDetail', 'deleteAttachment', 'print', 'loadPDF'),
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

            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/receivinginventory/delete', array('id' => $value->receiving_inventory_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

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

            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/receivinginventory/deleteReceivingDetail', array('receiving_inv_detail_id' => $value->receiving_inventory_detail_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';


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
        $attachment = new Attachment;

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

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {
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

                        if ($data['form'] == "print") {

                            $data['print'] = $_POST;
                            $data['success'] = true;
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
                            'unit_price' => $transaction_detail->unit_price != "" ? number_format($transaction_detail->unit_price, 2, '.', '') : number_format(0, 2, '.', ''),
                            'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                            'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                            'planned_quantity' => $transaction_detail->planned_quantity != "" ? $transaction_detail->planned_quantity : 0,
                            'quantity_received' => $transaction_detail->quantity_received != "" ? $transaction_detail->quantity_received : 0,
                            'uom_id' => isset($transaction_detail->uom->uom_id) ? $transaction_detail->uom->uom_id : null,
                            'uom_name' => isset($transaction_detail->uom->uom_name) ? $transaction_detail->uom->uom_name : null,
                            'sku_status_id' => isset($transaction_detail->skuStatus->sku_status_id) ? $transaction_detail->skuStatus->sku_status_id : null,
                            'sku_status_name' => isset($transaction_detail->skuStatus->status_name) ? $transaction_detail->skuStatus->status_name : null,
                            'amount' => $transaction_detail->amount != "" ? number_format($transaction_detail->amount, 2, '.', '') : number_format(0, 2, '.', ''),
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
            'attachment' => $attachment,
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
            try {

                // delete receiving details by receiving_inventory_id
                ReceivingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND receiving_inventory_id = " . $id);
                // delete attachment by receiving_inventory_id as transaction_id
                $this->deleteAttachmentByReceivingInvID($id);

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
            } catch (CDbException $e) {
                if ($e->errorInfo[1] == 1451) {
                    if (!isset($_GET['ajax'])) {
                        Yii::app()->user->setFlash('danger', "Unable to delete");
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $id));
                    } else {
                        echo "1451";
                        exit;
                    }
                }
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteReceivingDetail($receiving_inv_detail_id) {
        if (Yii::app()->request->isPostRequest) {
            try {

                ReceivingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND receiving_inventory_detail_id = " . $receiving_inv_detail_id);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('success', "Successfully deleted");
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                } else {

                    echo "Successfully deleted";
                    exit;
                }
            } catch (CDbException $e) {
                if ($e->errorInfo[1] == 1451) {
                    echo "1451";
                    exit;
                }
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function deleteAttachmentByReceivingInvID($receiving_inv_id, $transaction_type = Attachment::RECEIVING_TRANSACTION_TYPE) {
        $attachment = Attachment::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "transaction_type" => $transaction_type, "transaction_id" => $receiving_inv_id));

        if (count($attachment) > 0) {
            $base = Yii::app()->getBaseUrl(true);
            $arr = explode("/", $base);
            $base = $arr[count($arr) - 1];

            Attachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND transaction_type = '" . $transaction_type . "' AND transaction_id = " . $receiving_inv_id);
            $this->delete_directory('../' . $base . "/protected/uploads/" . Yii::app()->user->company_id . "/attachments/" . $transaction_type . "/" . $receiving_inv_id);
        } else {
            return false;
        }
    }

    function delete_directory($dirname) {
        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
        } else {
            return false;
        }

        if (!$dir_handle) {
            return false;
        }

        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    delete_directory($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }

    public function actionDeleteAttachment($attachment_id) {
        if (Yii::app()->request->isPostRequest) {
            try {

                $attachment = Attachment::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "attachment_id" => $attachment_id));

                if ($attachment) {
                    Attachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND attachment_id = '" . $attachment->attachment_id . "'");

                    $base = Yii::app()->getBaseUrl(true);
                    $arr = explode("/", $base);
                    $base = $arr[count($arr) - 1];
                    $url = str_replace(Yii::app()->getBaseUrl(true), "", $attachment->url);
                    unlink('../' . $base . $url);
                } else {
                    throw new CHttpException(404, 'The requested page does not exist.');
                }

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('success', "Successfully deleted");
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                } else {

                    echo "Successfully deleted";
                    exit;
                }
            } catch (CDbException $e) {
                if ($e->errorInfo[1] == 1451) {
                    echo "1451";
                    exit;
                }
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
            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . Attachment::RECEIVING_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . Yii::app()->session['tid'];

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/' . Attachment::RECEIVING_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . Yii::app()->session['tid'] . DIRECTORY_SEPARATOR . $file_name;
            $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

            $model->attachment_id = Globals::generateV4UUID();
            $model->company_id = Yii::app()->user->company_id;
            $model->file_name = $file_name;
            $model->url = $url;
            $model->transaction_id = Yii::app()->session['tid'];
            $model->transaction_type = Attachment::RECEIVING_TRANSACTION_TYPE;
            $model->created_by = Yii::app()->user->name;

            if ($model->save()) {

                $data[] = array(
                    'name' => $file->name,
                    'type' => $file->type,
                    'size' => $file->size,
                    'url' => $dir . DIRECTORY_SEPARATOR . $file_name,
                    'thumbnail_url' => $dir . DIRECTORY_SEPARATOR . $file_name,
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

    public function actionPreview($id) {
        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("transaction_id", $id);
        $attachment = Attachment::model()->findAll($c);

        $output = array();
        foreach ($attachment as $key => $value) {
            $ext = new SplFileInfo($value->file_name);

            $icon = "";
            if ($ext->getExtension() == "jpg" || $ext->getExtension() == "jpeg" || $ext->getExtension() == "gif" || $ext->getExtension() == "png") {
                $icon = CHtml::image('images' . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . "picture.png", "Image", array("width" => 30));
            } else if ($ext->getExtension() == "pdf") {
                $icon = CHtml::image('images' . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . "pdf.png", "Image", array("width" => 30));
            } else if ($ext->getExtension() == "docx" || $ext->getExtension() == "doc") {
                $icon = CHtml::image('images' . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . "doc.png", "Image", array("width" => 30));
            } else if ($ext->getExtension() == "xls" || $ext->getExtension() == "xlsx") {
                $icon = CHtml::image('images' . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . "xls.png", "Image", array("width" => 30));
            }

            $row = array();
            $row['file_name'] = $icon . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $value->file_name;

            $row['links'] = '<a class="btn btn-sm btn-default" title="Delete" href="' . $this->createUrl('/inventory/receivinginventory/download', array('id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-download"></i>
                            </a>'
                    . '&nbsp;<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/receivinginventory/deleteAttachment', array('attachment_id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionDownload($id) {

        $attachment = Attachment::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "attachment_id" => $id));

        $url = $attachment->url;
        $name = $attachment->file_name;

        $base = Yii::app()->getBaseUrl(true);
        $arr = explode("/", $base);
        $base = $arr[count($arr) - 1];
        $url = str_replace(Yii::app()->getBaseUrl(true), "", $url);

        if (file_exists('../' . $base . $url)) {

            Yii::app()->getRequest()->sendFile($name, file_get_contents('../' . $base . $url));
        } else {

            throw new CHttpException(500, "Could not download file.");
        }
    }

    public function actionPrint() {

        unset(Yii::app()->session["post_pdf_data_id"]);

        Yii::app()->session["post_pdf_data_id"] = 'post-pdf-data-' . Globals::generateV4UUID();
        Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] = Yii::app()->request->getParam('post_data');

        $return = array();
        if (Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] == "") {
            $return["success"] = false;
            return false;
        }

        $return["success"] = true;
        $return["id"] = Yii::app()->session["post_pdf_data_id"];

        echo json_encode($return);
        Yii::app()->end();
    }

    public function actionLoadPDF($id) {

        $data = Yii::app()->session[$id];
        
        ob_start();

        $headers = $data['ReceivingInventory'];
        $details = $data['transaction_details'];

        $c1 = new CDbCriteria();
        $c1->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.zone_id = "' . $headers['zone_id'] . '"';
        $c1->with = array("salesOffice");
        $zone = Zone::model()->find($c1);

        $c3 = new CDbCriteria();
        $c3->select = new CDbExpression('t.*, CONCAT(TRIM(barangay.barangay_name), ", ", TRIM(municipal.municipal_name), ", ", TRIM(province.province_name), ", ", TRIM(region.region_name)) AS full_address');
        $c3->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.sales_office_id = "' . $headers['sales_office_id'] . '"';
        $c3->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
        $c3->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
        $c3->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
        $c3->join .= ' LEFT JOIN region ON region.region_code = t.region_id';
        $salesoffice = Salesoffice::model()->find($c3);

        $warehouse_name = isset($salesoffice->sales_office_name) ? $salesoffice->sales_office_name : "";
        $warehouse_address = isset($salesoffice->full_address) ? $salesoffice->full_address : "";
        $destination_zone = isset($zone->zone_name) ? $zone->zone_name : "";

        $campaign_no = $headers['campaign_no'];
        $pr_no = $headers['pr_no'];
        $pr_date = $headers['pr_date'];
        $dr_no = $headers['dr_no'];

        $c2 = new CDbCriteria();
        $c2->select = new CDbExpression('t.*, CONCAT(barangay.barangay_name, ", ", municipal.municipal_name, ", ", province.province_name, ", ", region.region_name) AS full_address');
        $c2->condition = 'company_id = "' . Yii::app()->user->company_id . '" AND supplier_id = "' . $headers['supplier_id'] . '"';
        $c2->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay';
        $c2->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal';
        $c2->join .= ' LEFT JOIN province ON province.province_code = t.province';
        $c2->join .= ' LEFT JOIN region ON region.region_code = t.region';
        $supplier = Supplier::model()->find($c2);
        $supplier_name = $supplier->supplier_name;
        $contact_person = $supplier->contact_person1;
        $address = isset($supplier->full_address) ? $supplier->full_address : "";

        $transaction_date = $headers['transaction_date'];
        $plan_delivery_date = $headers['plan_delivery_date'];


        $pdf = Globals::pdf();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('DejaVu Sans', '#000', 10);

        $pdf->AddPage();

        $html = '
        <style type="text/css">
            .text-center { text-align: center; }
            .title { font-size: 12px; }
            .sub-title { font-size: 10px; }
            .title-report { font-size: 15px; font-weight: bold; } 
            .table_main { font-size: 8px; }
            .table_details { font-size: 8px; }
            .table_footer { font-size: 8px; width: 100%; }
            .border-bottom { border-bottom: 1px solid #333; font-size: 8px; }
            .row_label { width: 120px; }
            .row_content_sm { width: 100px; }
            .row_content_lg { width: 300px; }
            .align-right { text-align: right; }
        </style>
                
        <div id="header" class="text-center">
            <span class="title">ASIA BREWERY INCORPORATED</span><br/>
            <span class="sub-title">6th FLOOR ALLIED BANK CENTER, AYALA AVENUE, MAKATI CITY</span><br/>
            <span class="title-report">WAREHOUSE RECEIVING REPORT</span>
        </div>   
        
        <br/><br/>
        <table class="table_main">
            <tr>
                <td clss="row_label" style="font-weight: bold;">WAREHOUSE NAME</td>
                <td class="border-bottom row_content_lg">' . $warehouse_name . '</td>
                <td style="width: 10px;"></td>
                <td clss="row_label" style="font-weight: bold;">DELIVERY DATE</td>
                <td class="border-bottom row_content_sm">' . $transaction_date . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">ADDRESS</td>
                <td class="border-bottom">' . $warehouse_address . '</td>
                <td></td>
                <td style="font-weight: bold;">PLAN DELIVERY DATE</td>
                <td class="border-bottom">' . $plan_delivery_date . '</td>
            </tr>
        </table><br/><br/>
                
        <table class="table_main">
            <tr>
                <td clss="row_label" style="font-weight: bold;">CAMPAIGN NUMBER</td>
                <td class="border-bottom row_content_sm">' . $campaign_no . '</td>
                <td style="width: 10px;"></td>
                <td clss="row_label" style="font-weight: bold;">DESTINATION ZONE</td>
                <td class="border-bottom row_content_lg">' . $destination_zone . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">PR NUMBER</td>
                <td class="border-bottom">' . $pr_no . '</td>
                <td></td>
                <td style="font-weight: bold;">SUPPLIER NAME</td>
                <td class="border-bottom">' . $supplier_name . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">PR DATE</td>
                <td class="border-bottom">' . $pr_date . '</td>
                <td></td>
                <td style="font-weight: bold;">CONTACT PERSON</td>
                <td class="border-bottom">' . $contact_person . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">DR NUMBER</td>
                <td class="border-bottom">' . $dr_no . '</td>
                <td></td>
                <td style="font-weight: bold;">ADDRESS</td>
                <td class="border-bottom">' . $address . '</td>
            </tr>
        </table><br/><br/><br/>  
        
        <table class="table_details" border="1">
            <tr>
                <td style="font-weight: bold;">MM CODE</td>
                <td style="font-weight: bold; width: 100px;">MM DESCRIPTION</td>
                <td style="font-weight: bold;">MM BRAND</td>
                <td style="font-weight: bold;">MM CATEGORY</td>
                <td style="font-weight: bold; width: 55px;">PLAN QUANTITY</td>
                <td style="font-weight: bold; width: 55px;">QUANTITY RECEIVED</td>
                <td style="font-weight: bold; width: 40px;">UOM</td>
                <td style="font-weight: bold;">UNIT PRICE</td>
                <td style="font-weight: bold;">AMOUNT</td>
                <td style="font-weight: bold;">MM STATUS</td>
                <td style="font-weight: bold;">MM REMARKS</td>
            </tr>';

        $planned_qty = 0;
        $actual_qty = 0;
        $total_unit_price = 0;
        foreach ($details as $key => $val) {
            $sku = Sku::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sku_id" => $val['sku_id']));
            $uom = UOM::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "uom_id" => $val['uom_id']));
            $sku_status = SkuStatus::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sku_status_id" => $val['sku_status_id']));
            $status = isset($sku_status->status_name) ? $sku_status->status_name : "";

            $html .= '<tr>
                        <td>' . $sku->sku_code . '</td>
                        <td>' . $sku->description . '</td>
                        <td>' . $sku->brand->brand_name . '</td>
                        <td>' . $sku->type . '</td>
                        <td>' . $val['planned_quantity'] . '</td>
                        <td>' . $val['qty_received'] . '</td>
                        <td>' . $uom->uom_name . '</td>
                        <td class="align-right">&#x20B1; ' . number_format($val['unit_price'], 2, '.', ',') . '</td>
                        <td class="align-right">&#x20B1; ' . number_format($val['amount'], 2, '.', ',') . '</td>
                        <td>' . $status . '</td>
                        <td>' . $val['remarks'] . '</td>
                    </tr>';

            $planned_qty += $val['planned_quantity'];
            $actual_qty += $val['qty_received'];
            $total_unit_price += $val['unit_price'];
        }

        $html .= '<tr>
                    <td colspan="11"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">GRAND TOTAL</td>
                    <td>' . $planned_qty . '</td>
                    <td>' . $actual_qty . '</td>
                    <td></td>
                    <td class="align-right">&#x20B1; ' . number_format($total_unit_price, 2, '.', ',') . '</td>
                    <td class="align-right">&#x20B1; ' . number_format($headers['total_amount'], 2, '.', ',') . '</td>
                    <td colspan="2"></td>
                </tr>';

        $html .= '</table><br/><br/><br/>  
            
        <table class="table_footer">
            <tr>
                <td style="width: 180px; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; font-weight: bold;">DELIVERY REMARKS:</td>
                <td style="width: 100px;"></td>
                <td style="width: 150px; font-weight: bold;">DELIVERED BY:</td>
                <td style="width: 100px;"></td>
                <td style="width: 150px; font-weight: bold;">RECEIVED BY:</td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; min-height: 50px; height: 50px;"><br/><br/><br/><br/><br/>' . $headers['delivery_remarks'] . '</td>
                <td style="width: 100px;"></td>
                <td class="border-bottom"></td>
                <td style="width: 100px;"></td>
                <td class="border-bottom"></td>
            </tr>
        </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('incoming.pdf', 'I');
    }

}
