<?php

class CustomerItemController extends Controller {
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
                'actions' => array('create', 'update', 'data', 'loadTransactionByDRNo', 'loadInventoryDetails', 'customerItemDetailData', 'deleteCustomerItemDetail', 'uploadAttachment', 'preview', 'download', 'deleteAttachment',
                    'print', 'loadPDF'),
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

        CustomerItem::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = CustomerItem::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = CustomerItem::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['customer_item_id'] = $value->customer_item_id;
            $row['rra_no'] = $value->rra_no;
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;
            $row['pr_date'] = $value->pr_date;
            $row['dr_no'] = $value->dr_no;
            $row['source_zone_id'] = $value->source_zone_id;
            $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
            $row['poi_id'] = $value->poi_id;
            $row['poi_name'] = isset($value->poi->short_name) ? $value->poi->short_name : null;
            $row['transaction_date'] = $value->transaction_date;
            $row['total_amount'] = $value->total_amount;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/customerItem/delete', array('id' => $value->customer_item_id)) . '">
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

        $this->pageTitle = 'View CustomerItem ' . $model->customer_item_id;

        $this->menu = array(
            array('label' => 'Create CustomerItem', 'url' => array('create')),
            array('label' => 'Update CustomerItem', 'url' => array('update', 'id' => $model->customer_item_id)),
            array('label' => 'Delete CustomerItem', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->customer_item_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage CustomerItem', 'url' => array('admin')),
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

        $this->pageTitle = CustomerItem::CUSTOMER_ITEM_LABEL . ' Inventory';
        $this->layout = '//layouts/column1';

        $customer_item = new CustomerItem;
        $transaction_detail = new CustomerItemDetail;
        $sku = new Sku;
        $reference_dr_nos = CHtml::listData(IncomingInventory::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id)), "dr_no", "dr_no");
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');
        $model = new Attachment;

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";
            $data['form'] = $_POST['form'];

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {

                if (isset($_POST['CustomerItem'])) {
                    $customer_item->attributes = $_POST['CustomerItem'];
                    $customer_item->company_id = Yii::app()->user->company_id;
                    $customer_item->created_by = Yii::app()->user->name;
                    unset($customer_item->created_date);

                    $validatedCustomerItem = CActiveForm::validate($customer_item);

                    if ($validatedCustomerItem != '[]') {

                        $data['error'] = $validatedCustomerItem;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {

                        if ($data['form'] == "print") {

                            $data['print'] = $_POST;
                            $data['success'] = true;
                        } else {

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                            if ($customer_item->create($transaction_details)) {
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

                if (isset($_POST['CustomerItemDetail'])) {
                    $transaction_detail->attributes = $_POST['CustomerItemDetail'];
                    $transaction_detail->company_id = Yii::app()->user->company_id;
                    $transaction_detail->created_by = Yii::app()->user->name;
                    unset($transaction_detail->created_date);

                    $validatedCustomerItemDetail = CActiveForm::validate($transaction_detail);

                    if ($validatedCustomerItemDetail != '[]') {

                        $data['error'] = $validatedCustomerItemDetail;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {

                        $c = new CDbCriteria;
                        $c->compare('t.company_id', Yii::app()->user->company_id);
                        $c->compare('t.inventory_id', $transaction_detail->inventory_id);
                        $c->with = array("sku");
                        $inventory = Inventory::model()->find($c);

                        if ($transaction_detail->quantity_issued <= $inventory->qty) {
                            $data['success'] = true;
                            $data['message'] = 'Successfully Added Item';

                            $data['details'] = array(
                                "inventory_id" => isset($inventory->inventory_id) ? $inventory->inventory_id : null,
                                "sku_id" => isset($inventory->sku->sku_id) ? $inventory->sku->sku_id : null,
                                "sku_code" => isset($inventory->sku->sku_code) ? $inventory->sku->sku_code : null,
                                "sku_description" => isset($inventory->sku->description) ? $inventory->sku->description : null,
                                'brand_name' => isset($inventory->sku->brand->brand_name) ? $inventory->sku->brand->brand_name : null,
                                'unit_price' => isset($transaction_detail->unit_price) ? $transaction_detail->unit_price : 0,
                                'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                                'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                                'planned_quantity' => $transaction_detail->planned_quantity != "" ? $transaction_detail->planned_quantity : 0,
                                'quantity_issued' => $transaction_detail->quantity_issued != "" ? $transaction_detail->quantity_issued : 0,
                                'amount' => $transaction_detail->amount != "" ? $transaction_detail->amount : 0,
                                'inventory_on_hand' => $transaction_detail->inventory_on_hand != "" ? $transaction_detail->inventory_on_hand : 0,
                                'return_date' => isset($transaction_detail->return_date) ? $transaction_detail->return_date : null,
                                'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                                'uom_id' => isset($transaction_detail->uom_id) ? $transaction_detail->uom_id : null,
                                'sku_status_id' => isset($transaction_detail->sku_status_id) ? $transaction_detail->sku_status_id : null,
                            );
                        } else {

                            $data['message'] = 'Quantity Received greater than inventory on hand';
                            $data['success'] = false;
                            $data["type"] = "danger";
                        }
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $this->render('customerItemForm', array(
            'customer_item' => $customer_item,
            'transaction_detail' => $transaction_detail,
            'reference_dr_nos' => $reference_dr_nos,
            'sku' => $sku,
            'uom' => $uom,
            'sku_status' => $sku_status,
            'model' => $model,
        ));
    }

    public function actionLoadTransactionByDRNo($dr_no) {

        $c = new CDbCriteria;
        $c->condition = "incomingInventory.company_id = '" . Yii::app()->user->company_id . "' AND incomingInventory.dr_no = '" . $dr_no . "'";
        $c->with = array("incomingInventory");
        $incoming_inv_details = IncomingInventoryDetail::model()->findAll($c);

        $inv_ids = "";
        foreach ($incoming_inv_details as $key => $val) {

            $inventoryObj = Inventory::model()->findByAttributes(
                    array(
                        'company_id' => $val->incomingInventory->company_id,
                        'sku_id' => $val->sku_id,
                        'uom_id' => $val->uom_id,
                        'zone_id' => $val->incomingInventory->destination_zone_id,
                        'sku_status_id' => $val->sku_status_id != "" ? $val->sku_status_id : null,
                        'expiration_date' => isset($val->expiration_date) ? $val->expiration_date : null,
                        'reference_no' => $val->batch_no,
                    )
            );

            if ($inventoryObj) {
                $inv_ids .= $inventoryObj->inventory_id . ",";
            }
        }

        $c2 = new CDbCriteria;
        $c2->select = new CDbExpression('t.*, CONCAT(t.first_name, " ",t.last_name) AS fullname');
        $c2->compare('t.company_id', Yii::app()->user->company_id);
        $c2->compare('t.default_zone_id', isset($val->incomingInventory->destination_zone_id) ? $val->incomingInventory->destination_zone_id : 0);
        $employee = Employee::model()->find($c2);

        $header = array(
            "rra_no" => isset($val->incomingInventory->rra_no) ? $val->incomingInventory->rra_no : null,
            "campaign_no" => isset($val->incomingInventory->campaign_no) ? $val->incomingInventory->campaign_no : null,
            "pr_no" => isset($val->incomingInventory->pr_no) ? $val->incomingInventory->pr_no : null,
            "pr_date" => isset($val->incomingInventory->pr_date) ? $val->incomingInventory->pr_date : null,
            "source_zone_id" => isset($val->incomingInventory->destination_zone_id) ? $val->incomingInventory->destination_zone_id : null,
            "source_zone_name" => isset($val->incomingInventory->zone->zone_name) ? $val->incomingInventory->zone->zone_name : null,
        );

        $inventory = array();
        if ($inv_ids != "") {
            $c1 = new CDbCriteria;
            $c1->compare("company_id", Yii::app()->user->company_id);
            $c1->condition = "inventory_id IN (" . substr($inv_ids, 0, -1) . ")";
            $inventory = Inventory::model()->findAll($c1);
        }

        $output = array();
        foreach ($inventory as $key => $value) {
            $row = array();

            $row['inventory_id'] = $value->inventory_id;
            $row['company_id'] = $value->company_id;
            $row['sku_id'] = $value->sku_id;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['cost_per_unit'] = isset($value->cost_per_unit) ? $value->cost_per_unit : null;
            $row['inventory_on_hand'] = isset($value->qty) ? $value->qty : null;
            $row['uom_name'] = isset($value->uom->uom_name) ? $value->uom->uom_name : null;
            $row['sku_status_name'] = isset($value->skuStatus->status_name) ? $value->skuStatus->status_name : null;
            $row['expiration_date'] = isset($value->expiration_date) ? $value->expiration_date : null;
            $row['reference_no'] = isset($value->reference_no) ? $value->reference_no : null;

            $output['data'][] = $row;
        }

        $output['headers'] = $header;

        echo json_encode($output);
    }

    public function actionLoadInventoryDetails($inventory_id) {

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
            'expiration_date' => isset($inventory->expiration_date) ? $inventory->expiration_date : null,
            'inventory_on_hand' => isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0,
            'uom_id' => isset($inventory->uom_id) ? $inventory->uom_id : null,
            'sku_status_id' => isset($inventory->sku_status_id) ? $inventory->sku_status_id : null,
        );

        echo json_encode($data);
    }

    public function actionCustomerItemDetailData($customer_item_id) {

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("customer_item_id", $customer_item_id);
        $customer_item_details = CustomerItemDetail::model()->findAll($c);

        $output = array();
        foreach ($customer_item_details as $key => $value) {
            $row = array();

            $row['customer_item_detail_id'] = $value->customer_item_detail_id;
            $row['customer_item_id'] = $value->customer_item_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['planned_quantity'] = $value->planned_quantity;
            $row['quantity_issued'] = $value->quantity_issued;
            $row['amount'] = $value->amount;
            $row['inventory_on_hand'] = $value->inventory_on_hand;
            $row['return_date'] = $value->return_date;
            $row['remarks'] = $value->remarks;

            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/customerItem/deleteCustomerItemDetail', array('customer_item_detail_id' => $value->customer_item_detail_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create CustomerItem', 'url' => array('create')),
            array('label' => 'View CustomerItem', 'url' => array('view', 'id' => $model->customer_item_id)),
            array('label' => 'Manage CustomerItem', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update CustomerItem ' . $model->customer_item_id;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['CustomerItem'])) {
            $model->attributes = $_POST['CustomerItem'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->customer_item_id));
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

                // delete customer item details by customer_item_id
                CustomerItemDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND customer_item_id = " . $id);
                // delete attachment by customer_item_id as transaction_id
                $this->deleteAttachmentByCustomerItemID($id);
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

    public function actionDeleteCustomerItemDetail($customer_item_detail_id) {
        if (Yii::app()->request->isPostRequest) {
            try {

                CustomerItemDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND customer_item_detail_id = " . $customer_item_detail_id);

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

    public function deleteAttachmentByCustomerItemID($customer_item_id, $transaction_type = Attachment::CUSTOMER_ITEM_TRANSACTION_TYPE) {
        $attachment = Attachment::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "transaction_type" => $transaction_type, "transaction_id" => $customer_item_id));

        if (count($attachment) > 0) {
            $base = Yii::app()->getBaseUrl(true);
            $arr = explode("/", $base);
            $base = $arr[count($arr) - 1];

            Attachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND transaction_type = '" . $transaction_type . "' AND transaction_id = " . $customer_item_id);
            $this->delete_directory('../' . $base . "/protected/uploads/" . Yii::app()->user->company_id . "/attachments/" . $transaction_type . "/" . $customer_item_id);
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
        $dataProvider = new CActiveDataProvider('CustomerItem');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . CustomerItem::CUSTOMER_ITEM_LABEL . ' Inventory';

        $model = new CustomerItem('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerItem']))
            $model->attributes = $_GET['CustomerItem'];

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
        $model = CustomerItem::model()->findByAttributes(array('customer_item_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

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
            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . Attachment::CUSTOMER_ITEM_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . Yii::app()->session['tid'];
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/' . Attachment::CUSTOMER_ITEM_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . Yii::app()->session['tid'] . DIRECTORY_SEPARATOR . $file_name;
            $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

            $model->attachment_id = Globals::generateV4UUID();

            $model->company_id = Yii::app()->user->company_id;
            $model->file_name = $file_name;
            $model->url = $url;
            $model->transaction_id = Yii::app()->session['tid'];
            $model->transaction_type = Attachment::CUSTOMER_ITEM_TRANSACTION_TYPE;
            $model->created_by = Yii::app()->user->name;

            if ($model->save()) {

                $data[] = array(
                    'name' => $file->name,
                    'type' => $file->type,
                    'size' => $file->size,
                    'url' => $dir . DIRECTORY_SEPARATOR . $file_name,
                    'thumbnail_url' => $dir . DIRECTORY_SEPARATOR . $file_name
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
        $c->compare("transaction_type", Attachment::CUSTOMER_ITEM_TRANSACTION_TYPE);
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

            $row['links'] = '<a class="btn btn-sm btn-default" title="Delete" href="' . $this->createUrl('/inventory/customeritem/download', array('id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-download"></i>
                            </a>'
                    . '&nbsp;<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/customeritem/deleteAttachment', array('attachment_id' => $value->attachment_id)) . '">
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

        $headers = $data['CustomerItem'];
        $details = $data['transaction_details'];

        $c1 = new CDbCriteria();
        $c1->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.zone_id = "' . $headers['source_zone_id'] . '"';
        $c1->with = array("salesOffice");
        $zone = Zone::model()->find($c1);

        $c2 = new CDbCriteria();
        $c2->select = new CDbExpression('t.*, CONCAT(TRIM(barangay.barangay_name), ", ", TRIM(municipal.municipal_name), ", ", TRIM(province.province_name), ", ", TRIM(region.region_name)) AS full_address');
        $c2->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.sales_office_id = "' . $zone->salesOffice->sales_office_id . '"';
        $c2->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
        $c2->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
        $c2->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
        $c2->join .= ' LEFT JOIN region ON region.region_code = t.region_id';
        $salesoffice = Salesoffice::model()->find($c2);

        $sales_office_name = isset($salesoffice->sales_office_name) ? $salesoffice->sales_office_name : "";
        $sales_office_address = isset($salesoffice->full_address) ? $salesoffice->full_address : "";

        $transaction_date = $headers['transaction_date'];
        $plan_delivery_date = $headers['plan_delivery_date'];
        $reference_no = $headers['reference_dr_no'];
        $pr_no = $headers['pr_no'];
        $rra_no = $headers['rra_no'];
        $dr_no = $headers['dr_no'];

        $c3 = new CDbCriteria();
        $c3->select = new CDbExpression('t.*, TRIM(barangay.barangay_name) as barangay_name, TRIM(municipal.municipal_name) as municipal_name, TRIM(province.province_name) as province_name, TRIM(region.region_name) as region_name');
        $c3->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.poi_id = "' . $headers['poi_id'] . '"';
        $c3->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
        $c3->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
        $c3->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
        $c3->join .= ' LEFT JOIN region ON region.region_code = t.region_id';
        $poi = Poi::model()->find($c3);

        $poi_name = $poi->short_name;
        $poi_address = isset($poi->barangay_name) ? $poi->barangay_name . ", " : "";
        $poi_address .= isset($poi->municipal_name) ? $poi->municipal_name . ", " : "";
        $poi_address .= isset($poi->province_name) ? $poi->province_name . ", " : "";
        $poi_address .= isset($poi->region_name) ? $poi->region_name : "";

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
                .table_details { font-size: 8px; width: 100%; }
                .table_footer { font-size: 8px; width: 100%; }
                .border-bottom { border-bottom: 1px solid #333; font-size: 8px; }
                .row_label { width: 120px; }
                .row_content_sm { width: 100px; }
                .row_content_lg { width: 300px; }
                .noted { font-size: 8px; }
                .align-right { text-align: right; }z
            </style>

            <div id="header" class="text-center">
                <span class="title">ASIA BREWERY INCORPORATED</span><br/>
                <span class="sub-title">6th FLOOR ALLIED BANK CENTER, AYALA AVENUE, MAKATI CITY</span><br/>
                <span class="title-report">DELIVERY RECEIPT</span>
            </div><br/><br/>
        
            <table class="table_main">
                <tr>
                    <td clss="row_label" style="font-weight: bold;">SALES OFFICE NAME</td>
                    <td class="border-bottom row_content_lg">' . $sales_office_name . '</td>
                    <td style="width: 10px;"></td>
                    <td clss="row_label" style="font-weight: bold;">DELIVERY DATE</td>
                    <td class="border-bottom row_content_sm">' . $transaction_date . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">ADDRESS</td>
                    <td class="border-bottom">' . $sales_office_address . '</td>
                    <td></td>
                    <td style="font-weight: bold;">PLAN DATE</td>
                    <td class="border-bottom">' . $plan_delivery_date . '</td>
                </tr>
            </table><br/><br/>
            
            <table class="table_main">
                <tr>
                    <td clss="row_label" style="font-weight: bold;">REFERENCE NUMBER</td>
                    <td class="border-bottom row_content_sm">' . $reference_no . '</td>
                    <td style="width: 10px;"></td>
                    <td clss="row_label" style="font-weight: bold;">CUSTOMER NAME</td>
                    <td class="border-bottom row_content_lg">' . $poi_name . '</td>
                </tr>
                <tr>
                    <td clss="row_label" style="font-weight: bold;">PR NUMBER</td>
                    <td class="border-bottom row_content_sm">' . $pr_no . '</td>
                    <td style="width: 10px;"></td>
                    <td clss="row_label" style="font-weight: bold;">CONTACT PERSON</td>
                    <td class="border-bottom row_content_lg"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">RRA NUMBER</td>
                    <td class="border-bottom">' . $rra_no . '</td>
                    <td></td>
                    <td style="font-weight: bold;">ADDRESS</td>
                    <td class="border-bottom">' . $poi_address . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">DR NUMBER</td>
                    <td class="border-bottom">' . $dr_no . '</td>
                    <td colspan="3"></td>
                </tr>
            </table><br/><br/><br/>  
        
            <table class="table_details" border="1">
                <tr>
                    <td style="font-weight: bold;">MM CODE</td>
                    <td style="font-weight: bold; width: 100px;">MM DESCRIPTION</td>
                    <td style="font-weight: bold;">MM BRAND</td>
                    <td style="font-weight: bold;">MM CATEGORY</td>
                    <td style="font-weight: bold; width: 65px;">ALLOCATION</td>
                    <td style="font-weight: bold; width: 55px;">QUANTITY ISSUED</td>
                    <td style="font-weight: bold; width: 40px;">UOM</td>
                    <td style="font-weight: bold;">UNIT PRICE</td>
                    <td style="font-weight: bold;">AMOUNT</td>
                    <td style="font-weight: bold;">EXPIRY DATE</td>
                    <td style="font-weight: bold;">REMARKS</td>
                </tr>';

        $planned_qty = 0;
        $actual_qty = 0;
        $total_unit_price = 0;
        foreach ($details as $key => $val) {
            $sku = Sku::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sku_id" => $val['sku_id']));
            $uom = UOM::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "uom_id" => $val['uom_id']));
            $uom_name = isset($uom->uom_name) ? $uom->uom_name : "";
            
            $html .= '<tr>
                            <td>' . $sku->sku_code . '</td>
                            <td>' . $sku->description . '</td>
                            <td>' . $sku->brand->brand_name . '</td>
                            <td>' . $sku->type . '</td>
                            <td>' . $val['planned_quantity'] . '</td>
                            <td>' . $val['quantity_issued'] . '</td>
                            <td>' . $uom_name . '</td>
                            <td class="align-right">&#x20B1; ' . number_format($val['unit_price'], 2, '.', ',') . '</td>
                            <td class="align-right">&#x20B1; ' . number_format($val['amount'], 2, '.', ',') . '</td>
                            <td>' . $val['expiration_date'] . '</td>
                            <td>' . $val['remarks'] . '</td>
                        </tr>';

            $planned_qty += $val['planned_quantity'];
            $actual_qty += $val['quantity_issued'];
            $total_unit_price += $val['unit_price'];
        }

        $html .= '<tr>
                    <td colspan="11"></td>
                </tr>';

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
                        <td style="width: 180px; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; font-weight: bold;">REMARKS:</td>
                        <td style="width: 20px;"></td>
                        <td style="width: 90px; font-weight: bold;">SHIPPED VIA:</td>
                        <td class="border-bottom" style="width: 120px;"></td>
                        <td style="width: 20px;"></td>
                        <td style="width: 110px; font-weight: bold;">TRUCK NO.:</td>
                        <td class="border-bottom" style="width: 130px;"></td>
                    </tr>
                    <tr>
                        <td rowspan="5" style="border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><br/><br/>' . $headers['remarks'] . '</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;">CHECKED BY:</td>
                        <td class="border-bottom"></td>
                        <td></td>
                        <td style="font-weight: bold;">DRIVER"S NAME:</td>
                        <td class="border-bottom"></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;">AUTHORIZED BY:</td>
                        <td class="border-bottom"></td>
                        <td></td>
                        <td style="font-weight: bold;">DRIVER"S SIGNATURE:</td>
                        <td class="border-bottom"></td>
                    </tr>
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2">Received the above goods in good order and condition</td>
                    </tr>
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2" class="border-bottom"></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2" style="text-align: center;">NAME & SIGNATURE OF RECEIPIENT</td>
                    </tr>
                </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('outgoing.pdf', 'I');
    }

}
