<?php

class ReturnsController extends Controller {
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
                'actions' => array('create', 'update', 'data', 'loadReferenceDRNos', 'infraLoadDetailsByDRNo', 'queryInfraDetails', 'getDetailsByReturnInvID', 'createReturnable', 'infraLoadDetailsBySelectedDRNo',
                    'returnableData', 'getReturnableDetailsByReturnableID', 'preview'),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Returns';

        $returnable = new Returnable;
        $return_receipt = new ReturnReceipt;
        $return_receipt_detail = new ReturnReceiptDetail;

        $return_from_list = CHtml::listData(Returnable::model()->getListReturnFrom(), 'value', 'title');
        $zone_list = CHtml::listData(Zone::model()->findAll(array("condition" => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');
        $poi_list = CHtml::listData(Poi::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'short_name ASC')), 'poi_id', 'short_name', 'primary_code');
        $salesoffice_list = CHtml::listData(Salesoffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');

        $c = new CDbCriteria;
        $c->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
        $c->condition = 'company_id = "' . Yii::app()->user->company_id . '"';
        $c->order = 'fullname ASC';
        $employee = CHtml::listData(Employee::model()->findAll($c), 'employee_id', 'fullname', 'employee_code');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['Returnable'])) {

                    $returnable->attributes = $_POST['Returnable'];
                    $returnable->company_id = Yii::app()->user->company_id;
                    $returnable->created_by = Yii::app()->user->name;
                    $returnable->date_returned = $returnable->transaction_date;
                    unset($returnable->created_date);

                    $validatedReturnable = CActiveForm::validate($returnable);

                    $data = $this->saveReturnables($returnable, $_POST, $validatedReturnable, $data);
                } else if (isset($_POST['ReturnReceipt'])) {

                    $return_receipt->attributes = $_POST['ReturnReceipt'];
                    $return_receipt->company_id = Yii::app()->user->company_id;
                    $return_receipt->created_by = Yii::app()->user->name;
                    $return_receipt->date_returned = $return_receipt->transaction_date;
                    unset($return_receipt->created_date);

                    $validatedReturnReceipt = CActiveForm::validate($return_receipt);

                    $data = $this->saveReturnReceipt($return_receipt, $_POST, $validatedReturnReceipt, $data);
                }
            } else if ($_POST['form'] == "details") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['ReturnReceiptDetail'])) {
                    $return_receipt_detail->attributes = $_POST['ReturnReceiptDetail'];
                    $return_receipt_detail->company_id = Yii::app()->user->company_id;
                    $return_receipt_detail->created_by = Yii::app()->user->name;
                    unset($return_receipt_detail->created_date);

                    $validatedReturnReceiptDetail = CActiveForm::validate($return_receipt_detail);

                    if ($validatedReturnReceiptDetail != '[]') {

                        $data['error'] = $validatedReturnReceiptDetail;
                        $data["type"] = "danger";
                        $data['message'] = 'Unable to process';
                    } else {

                        $c = new CDbCriteria;
                        $c->compare('t.company_id', Yii::app()->user->company_id);
                        $c->compare('t.sku_id', $return_receipt_detail->sku_id);
                        $c->with = array('brand', 'company', 'defaultUom', 'defaultZone');
                        $sku_details = Sku::model()->find($c);

                        $data['message'] = 'Added Item Successfully';
                        $data['success'] = true;

                        $data['details'] = array(
                            "sku_id" => isset($sku_details->sku_id) ? $sku_details->sku_id : null,
                            "sku_code" => isset($sku_details->sku_code) ? $sku_details->sku_code : null,
                            "sku_description" => isset($sku_details->description) ? $sku_details->description : null,
                            'brand_name' => isset($sku_details->brand->brand_name) ? $sku_details->brand->brand_name : null,
                            'unit_price' => $return_receipt_detail->unit_price != "" ? number_format($return_receipt_detail->unit_price, 2, '.', '') : number_format(0, 2, '.', ''),
                            'batch_no' => isset($return_receipt_detail->batch_no) ? $return_receipt_detail->batch_no : null,
                            'expiration_date' => isset($return_receipt_detail->expiration_date) ? $return_receipt_detail->expiration_date : null,
                            'quantity_issued' => $return_receipt_detail->quantity_issued != "" ? $return_receipt_detail->quantity_issued : 0,
                            'returned_quantity' => $return_receipt_detail->returned_quantity != "" ? $return_receipt_detail->returned_quantity : 0,
                            'uom_id' => isset($return_receipt_detail->uom->uom_id) ? $return_receipt_detail->uom->uom_id : null,
                            'uom_name' => isset($return_receipt_detail->uom->uom_name) ? $return_receipt_detail->uom->uom_name : null,
                            'sku_status_id' => isset($return_receipt_detail->skuStatus->sku_status_id) ? $return_receipt_detail->skuStatus->sku_status_id : null,
                            'sku_status_name' => isset($return_receipt_detail->skuStatus->status_name) ? $return_receipt_detail->skuStatus->status_name : null,
                            'amount' => $return_receipt_detail->amount != "" ? number_format($return_receipt_detail->amount, 2, '.', '') : number_format(0, 2, '.', ''),
                            'remarks' => isset($return_receipt_detail->remarks) ? $return_receipt_detail->remarks : null,
                        );
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        $this->render('create', array(
            'returnable' => $returnable,
            'return_from_list' => $return_from_list,
            'zone_list' => $zone_list,
            'poi_list' => $poi_list,
            'salesoffice_list' => $salesoffice_list,
            'employee' => $employee,
            'return_receipt' => $return_receipt,
            'return_receipt_detail' => $return_receipt_detail,
            'uom' => $uom,
            'sku_status' => $sku_status,
            'isReturnable' => false,
            'sku_id' => ""
        ));
    }

    function saveReturnables($model, $post, $validatedModel, $data) {

        if ($post['Returnable']['receive_return_from'] != "") {
            $selected_source = $post['Returnable']['receive_return_from'];

            $returnable_label = str_replace(" ", "_", Returnable::RETURNABLE) . "_";
            $source_id = Returnable::model()->validateReturnFrom($model, $selected_source, $returnable_label);
            $model->receive_return_from_id = $source_id;
        }

        $validatedModel_arr = (array) json_decode($validatedModel);
        $model_errors = json_encode(array_merge($validatedModel_arr, $model->getErrors()));

        if ($model_errors != '[]') {

            $data['error'] = $model_errors;
            $data['message'] = 'Unable to process';
            $data['success'] = false;
            $data["type"] = "danger";
        } else {

            if ($data['form'] == "print") {

                $data['print'] = $post;
                $data['success'] = true;
            } else {

                $transaction_details = isset($post['transaction_details']) ? $post['transaction_details'] : array();

                if ($model->createReturnable($transaction_details)) {
//                    $data['returns_id'] = Yii::app()->session['returns_id_create_session'];
//                    unset(Yii::app()->session['returns_id_create_session']);
                    $data['message'] = 'Successfully created';
                    $data['success'] = true;
                } else {
                    $data['message'] = 'Unable to process';
                    $data['success'] = false;
                    $data["type"] = "danger";
                }
            }
        }

        return $data;
    }

    public function saveReturnReceipt($model, $post, $validatedModel, $data) {

        if ($post['ReturnReceipt']['receive_return_from'] != "") {
            $selected_source = $post['ReturnReceipt']['receive_return_from'];

            $return_receipt_label = str_replace(" ", "_", ReturnReceipt::RETURN_RECEIPT_LABEL) . "_";
            $source_id = Returnable::model()->validateReturnFrom($model, $selected_source, $return_receipt_label);
            $model->receive_return_from_id = $source_id;
        }

        $validatedModel_arr = (array) json_decode($validatedModel);
        $model_errors = json_encode(array_merge($validatedModel_arr, $model->getErrors()));

        if ($model_errors != '[]') {

            $data['error'] = $model_errors;
            $data['message'] = 'Unable to process';
            $data['success'] = false;
            $data["type"] = "danger";
        } else {

            if ($data['form'] == "print") {

                $data['print'] = $post;
                $data['success'] = true;
            } else {

                $transaction_details = isset($post['transaction_details']) ? $post['transaction_details'] : array();

                if ($model->createReturnReceipt($transaction_details)) {
                    $data['message'] = 'Successfully created';
                    $data['success'] = true;
                } else {
                    $data['message'] = 'Unable to process';
                    $data['success'] = false;
                    $data["type"] = "danger";
                }
            }
        }

        return $data;
    }

    public function actionGetDetailsByReturnInvID($returns_id) {

        $c = new CDbCriteria;
        $c->condition = "company_id = '" . Yii::app()->user->company_id . "' AND returns_id = '" . $returns_id . "'";
        $returns_details = ReturnableDetail::model()->findAll($c);

        $output = array();
        foreach ($returns_details as $key => $value) {
            $row = array();

            $status = Inventory::model()->status($value->status);

            $uom = Uom::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "uom_id" => $value->uom_id));

            $row['returns_detail_id'] = $value->returns_detail_id;
            $row['returns_id'] = $value->returns_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
            $row['sku_sub_category'] = isset($value->sku->sub_type) ? $value->sku->sub_type : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['quantity_issued'] = $value->quantity_issued;
            $row['returned_quantity'] = $value->returned_quantity;
            $row['amount'] = "&#x20B1;" . number_format($value->amount, 2, '.', ',');
            $row['status'] = $status;
            $row['remarks'] = $value->remarks;
            $row['po_no'] = $value->po_no;
            $row['pr_no'] = $value->pr_no;
            $row['uom_name'] = $uom->uom_name;

            $row['links'] = "";

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Returnable');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Returns';

        $model = new Returnable('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Returnable']))
            $model->attributes = $_GET['Returnable'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'returns-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function queryInfraDetails($source, $dr_no = "") {

        $source_arr = Returnable::model()->getListReturnFrom();
        $data = array();

        $c = new CDbCriteria;

        if ($source == $source_arr[0]['value']) {

            if ($dr_no != "") {
                $dr_no = " AND outgoingInventory.dr_no = '" . $dr_no . "'";
            }

            $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND sku.type = '" . Sku::INFRA . "'" . $dr_no;
            $c->with = array("outgoingInventory", "sku");
            $data["details"] = OutgoingInventoryDetail::model()->findAll($c);
            $data["header"] = $source;
        } else if ($source == $source_arr[1]['value']) {

            if ($dr_no != "") {
                $dr_no = " AND outgoingInventory.dr_no = '" . $dr_no . "'";
            }

            $c2 = new CDbCriteria;
            $c2->condition = "t.company_id = '" . Yii::app()->user->company_id . "'";
            $c2->with = array("salesOffice", "zone");
            $employee = Employee::model()->findAll($c2);

            $zones = "'',";
            foreach ($employee as $k => $v) {
                $zones .= "'" . $v->zone->zone_id . "',";
            }

            $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND outgoingInventory.destination_zone_id IN (" . substr($zones, 0, -1) . ") AND sku.type = '" . Sku::INFRA . "'" . $dr_no;
            $c->with = array("outgoingInventory", "sku");
            $data["details"] = OutgoingInventoryDetail::model()->findAll($c);
            $data["header"] = $source;
        } else if ($source == $source_arr[2]['value']) {

            if ($dr_no != "") {
                $dr_no = " AND customerItem.dr_no = '" . $dr_no . "'";
            }

            $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND sku.type = '" . Sku::INFRA . "'" . $dr_no;
            $c->with = array("customerItem", "sku");
            $data['details'] = CustomerItemDetail::model()->findAll($c);
            $data["header"] = $source;
        } else {

            $data = array();
        }

        return $data;
    }

    public function actionLoadReferenceDRNos($source) {

        $data = $this->queryInfraDetails($source);

        $source_arr = Returnable::model()->getListReturnFrom();

        $return = array();
        if (count($data) > 0) {
            $row['id'] = "";
            $row['text'] = "--";
            $return[] = $row;

            $dr_nos = "";
            $dr_nos_arr = array();
            if ($data['header'] == $source_arr[0]['value'] || $data['header'] == $source_arr[1]['value']) {
                foreach ($data['details'] as $key => $val) {
                    $row = array();

                    if (!in_array($val->outgoingInventory->dr_no, $dr_nos_arr)) {
                        array_push($dr_nos_arr, $val->outgoingInventory->dr_no);
                        $row['id'] = $val->outgoingInventory->dr_no;
                        $row['text'] = $val->outgoingInventory->dr_no;

                        $return[] = $row;
                    }
                }
            } else if ($data['header'] == $source_arr[2]['value']) {
                foreach ($data['details'] as $key => $val) {
                    $row = array();

                    if (!in_array($val->customerItem->dr_no, $dr_nos_arr)) {
                        array_push($dr_nos_arr, $val->customerItem->dr_no);
                        $row['id'] = $val->customerItem->dr_no;
                        $row['text'] = $val->customerItem->dr_no;

                        $return[] = $row;
                    }
                }
            }
        }

        echo json_encode($return);
    }

    public function actionInfraLoadDetailsByDRNo($source, $dr_no) {
        $data = array();

        if ($dr_no != "") {
            $data = $this->queryInfraDetails($source, $dr_no);
        }

        $source_arr = Returnable::model()->getListReturnFrom();

        $return = array();
        $return["id"] = "";
        if (count($data) > 0) {

            if ($data['header'] == $source_arr[0]['value']) {
                foreach ($data['details'] as $key => $value) {
                    $row = array();

                    $return["id"] = $value->outgoingInventory->zone->salesOffice->sales_office_id;

                    $row['outgoing_inventory_detail_id'] = $value->outgoing_inventory_detail_id;
                    $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
                    $row['inventory_id'] = $value->inventory_id;
                    $row['batch_no'] = $value->batch_no;
                    $row['sku_id'] = $value->sku_id;
                    $row['source_zone_id'] = $value->source_zone_id;
                    $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
                    $row['unit_price'] = $value->unit_price;
                    $row['expiration_date'] = $value->expiration_date;
                    $row['planned_quantity'] = $value->quantity_issued;
                    $row['quantity_received'] = "0";
                    $row['amount'] = $value->amount;
                    $row['return_date'] = $value->return_date;
                    $row['remarks'] = $value->remarks;
                    $row['sku_id'] = isset($value->sku->sku_id) ? $value->sku->sku_id : null;
                    $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
                    $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
                    $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
                    $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
                    $row['sku_sub_category'] = isset($value->sku->sub_type) ? $value->sku->sub_type : null;
                    $row['status'] = $value->status;
                    $row['uom_id'] = $value->uom_id;
                    $row['uom_name'] = $value->uom->uom_name;
                    $row['sku_status_id'] = $value->sku_status_id;
                    $row['po_no'] = $value->po_no;
                    $row['pr_no'] = $value->pr_no;
                    $row['pr_date'] = $value->pr_date;
                    $row['plan_arrival_date'] = $value->plan_arrival_date;

                    $return['transaction_details'][] = $row;
                }
            } else if ($data['header'] == $source_arr[1]['value']) {
                foreach ($data['details'] as $key => $value) {
                    $row = array();

                    $employee = Employee::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "default_zone_id" => $value->outgoingInventory->destination_zone_id));

                    $return["id"] = $employee->employee_id;

                    $row['outgoing_inventory_detail_id'] = $value->outgoing_inventory_detail_id;
                    $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
                    $row['inventory_id'] = $value->inventory_id;
                    $row['batch_no'] = $value->batch_no;
                    $row['sku_id'] = $value->sku_id;
                    $row['source_zone_id'] = $value->source_zone_id;
                    $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
                    $row['unit_price'] = $value->unit_price;
                    $row['expiration_date'] = $value->expiration_date;
                    $row['planned_quantity'] = $value->quantity_issued;
                    $row['quantity_received'] = "0";
                    $row['amount'] = $value->amount;
                    $row['return_date'] = $value->return_date;
                    $row['remarks'] = $value->remarks;
                    $row['sku_id'] = isset($value->sku->sku_id) ? $value->sku->sku_id : null;
                    $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
                    $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
                    $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
                    $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
                    $row['sku_sub_category'] = isset($value->sku->sub_type) ? $value->sku->sub_type : null;
                    $row['status'] = $value->status;
                    $row['uom_id'] = $value->uom_id;
                    $row['uom_name'] = $value->uom->uom_name;
                    $row['sku_status_id'] = $value->sku_status_id;
                    $row['po_no'] = $value->po_no;
                    $row['pr_no'] = $value->pr_no;
                    $row['pr_date'] = $value->pr_date;
                    $row['plan_arrival_date'] = $value->plan_arrival_date;

                    $return['transaction_details'][] = $row;
                }
            } else if ($data['header'] == $source_arr[2]['value']) {
                foreach ($data['details'] as $key => $value) {
                    $row = array();

                    $return["id"] = $value->customerItem->poi->poi_id;

                    $row['customer_item_id'] = $value->customer_item_id;
                    $row['customer_item_id'] = $value->customer_item_id;
                    $row['inventory_id'] = $value->inventory_id;
                    $row['batch_no'] = $value->batch_no;
                    $row['sku_id'] = $value->sku_id;
                    $row['source_zone_id'] = $value->source_zone_id;
                    $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
                    $row['unit_price'] = $value->unit_price;
                    $row['expiration_date'] = $value->expiration_date;
                    $row['planned_quantity'] = $value->quantity_issued;
                    $row['quantity_received'] = "0";
                    $row['amount'] = $value->amount;
                    $row['remarks'] = $value->remarks;
                    $row['sku_id'] = isset($value->sku->sku_id) ? $value->sku->sku_id : null;
                    $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
                    $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
                    $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
                    $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
                    $row['sku_sub_category'] = isset($value->sku->sub_type) ? $value->sku->sub_type : null;
                    $row['status'] = $value->status;
                    $row['uom_id'] = $value->uom_id;
                    $row['uom_name'] = $value->uom->uom_name;
                    $row['sku_status_id'] = $value->sku_status_id;
                    $row['po_no'] = $value->po_no;
                    $row['pr_no'] = $value->pr_no;
                    $row['pr_date'] = $value->pr_date;
                    $row['plan_arrival_date'] = $value->plan_arrival_date;

                    $return['transaction_details'][] = $row;
                }
            }
        }

        echo json_encode($return);
    }

    public function actionCreateReturnable($dr_no, $sku_id) {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Returns';

        $exist_dr_no = Inventory::model()->checkIfReturnableDRNoIsExists(Yii::app()->user->company_id, $dr_no, $sku_id);

        if (!$exist_dr_no) {
            throw new CHttpException(403, "You are not authorized to perform this action.");
        }

        $returnable = new Returnable;
        $return_receipt = new ReturnReceipt;
        $return_receipt_detail = new ReturnReceiptDetail;

        $return_from_list = CHtml::listData(Returnable::model()->getListReturnFrom(), 'value', 'title');
        $zone_list = CHtml::listData(Zone::model()->findAll(array("condition" => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');
        $poi_list = CHtml::listData(Poi::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'short_name ASC')), 'poi_id', 'short_name', 'primary_code');
        $salesoffice_list = CHtml::listData(Salesoffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');

        $c = new CDbCriteria;
        $c->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
        $c->condition = 'company_id = "' . Yii::app()->user->company_id . '"';
        $c->order = 'fullname ASC';
        $employee = CHtml::listData(Employee::model()->findAll($c), 'employee_id', 'fullname', 'employee_code');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['Returnable'])) {

                    $returnable->attributes = $_POST['Returnable'];
                    $returnable->company_id = Yii::app()->user->company_id;
                    $returnable->created_by = Yii::app()->user->name;
                    $returnable->date_returned = $returnable->transaction_date;
                    unset($returnable->created_date);

                    $validatedReturnable = CActiveForm::validate($returnable);

                    if ($_POST['Returnable']['receive_return_from'] != "") {
                        $selected_source = $_POST['Returnable']['receive_return_from'];

                        $returnable_label = str_replace(" ", "_", Returnable::RETURNABLE) . "_";
                        $source_id = Returnable::model()->validateReturnFrom($returnable, $selected_source, $returnable_label);
                        $returnable->receive_return_from_id = $source_id;
                    }

                    $validatedModel_arr = (array) json_decode($validatedReturnable);
                    $model_errors = json_encode(array_merge($validatedModel_arr, $returnable->getErrors()));

                    if ($model_errors != '[]') {

                        $data['error'] = $model_errors;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {

                        if ($data['form'] == "print") {

                            $data['print'] = $_POST;
                            $data['success'] = true;
                        } else {

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                            $saved = $returnable->createReturnable($transaction_details);

                            if ($saved['success']) {
                                $data['returnable_id'] = $saved['header_data']->returnable_id;
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
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        $returnable->reference_dr_no = $dr_no;

        $this->render('create', array(
            'returnable' => $returnable,
            'return_from_list' => $return_from_list,
            'zone_list' => $zone_list,
            'poi_list' => $poi_list,
            'salesoffice_list' => $salesoffice_list,
            'employee' => $employee,
            'return_receipt' => $return_receipt,
            'return_receipt_detail' => $return_receipt_detail,
            'uom' => $uom,
            'sku_status' => $sku_status,
            'isReturnable' => true,
            'sku_id' => $sku_id
        ));
    }

    public function actionInfraLoadDetailsBySelectedDRNo($dr_no, $sku_id) {

        $data = array();
        $return = array();

        $infra_details = Returnable::model()->queryReturnInfraDetails($dr_no, $sku_id);

        if ($infra_details['source_header'] == IncomingInventory::INCOMING_LABEL) {

            foreach ($infra_details['source_details'] as $key => $value) {
                $row = array();

                $row['incoming_inventory_detail_id'] = $value->incoming_inventory_detail_id;
                $row['incoming_inventory_id'] = $value->incoming_inventory_id;
                $row['inventory_id'] = $value->inventory_id;
                $row['batch_no'] = $value->batch_no;
                $row['sku_id'] = $value->sku_id;
                $row['source_zone_id'] = $value->source_zone_id;
                $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
                $row['unit_price'] = $value->unit_price;
                $row['expiration_date'] = $value->expiration_date;
                $row['quantity_received'] = $value->quantity_received;
                $row['return_quantity'] = "0";
                $row['amount'] = $value->amount;
                $row['return_date'] = $value->return_date;
                $row['remarks'] = $value->remarks;
                $row['sku_id'] = isset($value->sku->sku_id) ? $value->sku->sku_id : null;
                $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
                $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
                $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
                $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
                $row['sku_sub_category'] = isset($value->sku->sub_type) ? $value->sku->sub_type : null;
                $row['status'] = "<span></span>";
                $row['uom_id'] = $value->uom_id;
                $row['uom_name'] = $value->uom->uom_name;
                $row['sku_status_id'] = $value->sku_status_id;
                $row['po_no'] = $value->po_no;
                $row['pr_no'] = $value->pr_no;
                $row['pr_date'] = $value->pr_date;
                $row['plan_arrival_date'] = $value->plan_arrival_date;

                $return['transaction_details'][] = $row;
            }
        } else {

            foreach ($infra_details['source_details'] as $key => $value) {
                $row = array();

                $row['customer_item_id'] = $value->customer_item_id;
                $row['customer_item_id'] = $value->customer_item_id;
                $row['inventory_id'] = $value->inventory_id;
                $row['batch_no'] = $value->batch_no;
                $row['sku_id'] = $value->sku_id;
                $row['source_zone_id'] = $value->source_zone_id;
                $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
                $row['unit_price'] = $value->unit_price;
                $row['expiration_date'] = $value->expiration_date;
                $row['quantity_received'] = $value->quantity_issued;
                $row['return_quantity'] = "0";
                $row['amount'] = $value->amount;
                $row['remarks'] = $value->remarks;
                $row['sku_id'] = isset($value->sku->sku_id) ? $value->sku->sku_id : null;
                $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
                $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
                $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
                $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
                $row['sku_sub_category'] = isset($value->sku->sub_type) ? $value->sku->sub_type : null;
                $row['status'] = "<span></span>";
                $row['uom_id'] = $value->uom_id;
                $row['uom_name'] = $value->uom->uom_name;
                $row['sku_status_id'] = $value->sku_status_id;
                $row['po_no'] = $value->po_no;
                $row['pr_no'] = $value->pr_no;
                $row['pr_date'] = $value->pr_date;
                $row['plan_arrival_date'] = $value->plan_arrival_date;

                $return['transaction_details'][] = $row;
            }
        }

        echo json_encode($return);
    }

    public function actionReturnableData() {

        Returnable::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Returnable::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Returnable::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['returnable_id'] = $value->returnable_id;
            $row['return_receipt_no'] = $value->return_receipt_no;
            $row['reference_dr_no'] = $value->reference_dr_no;
            $row['receive_return_from'] = $value->receive_return_from;
            $row['receive_return_from_id'] = $value->receive_return_from_id;
            $row['transaction_date'] = $value->transaction_date;
            $row['date_returned'] = $value->date_returned;
            $row['destination_zone_id'] = $value->destination_zone_id;
            $row['remarks'] = $value->remarks;
            $row['total_amount'] = "&#x20B1;" . number_format($value->total_amount, 2, '.', ',');;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;
            $row['source_name'] = "";
            $row['destination_zone_name'] = "";

            $row['links'] = '<a class="btn btn-sm btn-default view" title="View" href="' . $this->createUrl('/inventory/returnable/view', array('id' => $value->returnable_id)) . '">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/returnable/delete', array('id' => $value->returnable_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }
    
    public function actionGetReturnableDetailsByReturnableID($returnable_id) {
        
        $c = new CDbCriteria;
        $c->condition = "company_id = '" . Yii::app()->user->company_id . "' AND returnable_id = '" . $returnable_id . "'";
        $returnable_details = ReturnableDetail::model()->findAll($c);

        $output = array();
        foreach ($returnable_details as $key => $value) {
            $row = array();

            $status = Inventory::model()->status($value->status);

            $uom = Uom::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "uom_id" => $value->uom_id));

            $row['returnable_detail_id'] = $value->returnable_detail_id;
            $row['returnable_id'] = $value->returnable_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
            $row['sku_sub_category'] = isset($value->sku->sub_type) ? $value->sku->sub_type : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['quantity_issued'] = $value->quantity_issued;
            $row['returned_quantity'] = $value->returned_quantity;
            $row['amount'] = "&#x20B1;" . number_format($value->amount, 2, '.', ',');
            $row['status'] = $status;
            $row['remarks'] = $value->remarks;
            $row['po_no'] = $value->po_no;
            $row['pr_no'] = $value->pr_no;
            $row['uom_name'] = $uom->uom_name;

            $row['links'] = "";

            $output['data'][] = $row;
        }

        echo json_encode($output);
        
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

            $row['links'] = '<a class="btn btn-sm btn-default download_attachment" title="Delete" href="' . $this->createUrl('/inventory/incomingInventory/download', array('id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-download"></i>
                            </a>'
                    . '&nbsp;<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/incomingInventory/deleteAttachment', array('attachment_id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

}
