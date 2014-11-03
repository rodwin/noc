
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
                'actions' => array('create', 'update', 'data', 'loadInventoryDetails', 'outgoingInvDetailData', 'afterDeleteTransactionRow', 'invData', 'uploadAttachment', 'preview', 'download', 'searchCampaignNo', 'loadPRNos', 'loadInvByPRNo',
                    'deleteOutgoingDetail', 'deleteAttachment', 'print', 'loadPDF', 'getDetailsByOutgoingInvID', 'getTransactionDetailsByOutgoingInvID', 'loadItemDetails'),
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

            $status = "";
            switch ($value->status) {
                case OutgoingInventory::OUTGOING_PENDING_STATUS:
                    $status = '<span class="label label-warning">' . OutgoingInventory::OUTGOING_PENDING_STATUS . '</span>';
                    break;
                case OutgoingInventory::OUTGOING_COMPLETE_STATUS:
                    $status = '<span class="label label-success">' . OutgoingInventory::OUTGOING_COMPLETE_STATUS . '</span>';
                    break;
                case OutgoingInventory::OUTGOING_INCOMPLETE_STATUS:
                    $status = '<span class="label label-danger">' . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . '</span>';
                    break;
                case OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS:
                    $status = '<span class="label label-primary">' . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . '</span>';
                    break;
                default:
                    break;
            }

            $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
            $row['rra_no'] = $value->rra_no;
            $row['dr_no'] = $value->dr_no;
            $row['dr_date'] = $value->dr_date;
            $row['rra_date'] = $value->rra_date;
            $row['destination_zone_id'] = $value->destination_zone_id;
            $row['destination_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
            $row['contact_person'] = $value->contact_person;
            $row['contact_no'] = $value->contact_no;
            $row['address'] = $value->address;
//            $row['campaign_no'] = $value->campaign_no;
//            $row['pr_no'] = $value->pr_no;
//            $row['pr_date'] = $value->pr_date;
            $row['plan_delivery_date'] = $value->plan_delivery_date;
//            $row['revised_delivery_date'] = $value->revised_delivery_date;
//            $row['actual_delivery_date'] = $value->actual_delivery_date;
//            $row['plan_arrival_date'] = $value->plan_arrival_date;
            $row['transaction_date'] = $value->transaction_date;
            $row['status'] = $status;
            $row['total_amount'] = "&#x20B1;" . number_format($value->total_amount, 2, '.', ',');
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;

            $disabled = $value->status == OutgoingInventory::OUTGOING_PENDING_STATUS ? "" : "disabled";

            $row['links'] = '<a class="btn btn-sm btn-default view" title="View" href="' . $this->createUrl('/inventory/outgoingInventory/view', array('id' => $value->outgoing_inventory_id)) . '">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a class="btn btn-sm btn-default update ' . $disabled . '" title="Update" href="' . $this->createUrl('/inventory/outgoingInventory/update', array('id' => $value->outgoing_inventory_id)) . '">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            <a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/outgoingInventory/delete', array('id' => $value->outgoing_inventory_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionInvData() {

        Inventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Inventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Inventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['DT_RowId'] = $value->inventory_id; // Add an ID to the TR element
            $row['inventory_id'] = $value->inventory_id;
            $row['sku_code'] = $value->sku->sku_code;
            $row['sku_id'] = $value->sku_id;
            $row['sku_name'] = $value->sku->sku_name;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['qty'] = $value->qty;
            $row['uom_id'] = $value->uom_id;
            $row['uom_name'] = isset($value->uom->uom_name) ? $value->uom->uom_name : null;
            $row['action_qty'] = '';
            $row['zone_id'] = $value->zone_id;
            $row['zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
            $row['sku_status_id'] = $value->sku_status_id;
            $row['sku_status_name'] = isset($value->skuStatus->status_name) ? $value->skuStatus->status_name : '';
            $row['sales_office_name'] = isset($value->zone->salesOffice->sales_office_name) ? $value->zone->salesOffice->sales_office_name : '';
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : '';
            $row['transaction_date'] = $value->transaction_date;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;
            $row['expiration_date'] = $value->expiration_date;
            $row['reference_no'] = $value->reference_no;
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;
            $row['pr_date'] = $value->pr_date;
            $row['plan_arrival_date'] = $value->plan_arrival_date;
            $row['revised_delivery_date'] = $value->revised_delivery_date;


            $row['links'] = '<a class="btn btn-sm btn-default" title="Inventory Record History" href="' . $this->createUrl('/inventory/inventory/history', array('inventory_id' => $value->inventory_id)) . '">
                                <i class="glyphicon glyphicon-time"></i>
                            </a>
                            <a class="btn btn-sm btn-default" title="Item Detail" href="' . $this->createUrl('/library/sku/update', array('id' => $value->sku_id)) . '">
                                <i class="glyphicon glyphicon-wrench"></i>
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

        $this->pageTitle = "View " . OutgoingInventory::OUTGOING_LABEL . ' Inventory';
        $this->layout = '//layouts/column1';


        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pageTitle = "Create " . OutgoingInventory::OUTGOING_LABEL . ' Inventory';
        $this->layout = '//layouts/column1';

        $outgoing = new OutgoingInventory;
        $transaction_detail = new OutgoingInventoryDetail;
        $sku = new Sku;
        $attachment = new Attachment;
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');
        $zone_list = CHtml::listData(Zone::model()->findAll(array("condition" => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {
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

                        if ($data['form'] == "print") {

                            $data['print'] = $_POST;
                            $data['success'] = true;
                        } else {

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                            if ($outgoing->create($transaction_details)) {
                                $data['outgoing_inv_id'] = Yii::app()->session['outgoing_inv_id_create_session'];
                                unset(Yii::app()->session['outgoing_inv_id_create_session']);
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

                if (isset($_POST['OutgoingInventoryDetail'])) {
                    $transaction_detail->attributes = $_POST['OutgoingInventoryDetail'];
                    $transaction_detail->company_id = Yii::app()->user->company_id;
                    $transaction_detail->created_by = Yii::app()->user->name;
                    unset($transaction_detail->created_date);

                    $validatedReceivingDetail = CActiveForm::validate($transaction_detail);

                    if ($validatedReceivingDetail != '[]') {

                        $data['error'] = $validatedReceivingDetail;
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
                            $data['message'] = 'Successfully Added Item';
                            $data['success'] = true;

                            $data['details'] = array(
                                "inventory_id" => isset($inventory->inventory_id) ? $inventory->inventory_id : null,
                                "sku_id" => isset($inventory->sku->sku_id) ? $inventory->sku->sku_id : null,
                                "sku_code" => isset($inventory->sku->sku_code) ? $inventory->sku->sku_code : null,
                                "sku_description" => isset($inventory->sku->description) ? $inventory->sku->description : null,
                                'brand_name' => isset($inventory->sku->brand->brand_name) ? $inventory->sku->brand->brand_name : null,
                                'unit_price' => isset($transaction_detail->unit_price) && $transaction_detail->unit_price != "" ? number_format($transaction_detail->unit_price, 2, '.', '') : number_format(0, 2, '.', ''),
                                'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                                'source_zone_id' => isset($transaction_detail->source_zone_id) ? $transaction_detail->source_zone_id : null,
                                'source_zone_name' => isset($transaction_detail->zone->zone_name) ? $transaction_detail->zone->zone_name : null,
                                'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                                'planned_quantity' => $transaction_detail->planned_quantity != "" ? $transaction_detail->planned_quantity : 0,
                                'quantity_issued' => $transaction_detail->quantity_issued != "" ? $transaction_detail->quantity_issued : 0,
                                'amount' => $transaction_detail->amount != "" ? number_format($transaction_detail->amount, 2, '.', '') : number_format(0, 2, '.', ''),
                                'inventory_on_hand' => $transaction_detail->inventory_on_hand != "" ? $transaction_detail->inventory_on_hand : 0,
                                'reference_no' => isset($transaction_detail->pr_no) ? $transaction_detail->pr_no : null,
                                'return_date' => isset($transaction_detail->return_date) ? $transaction_detail->return_date : null,
                                'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                                'uom_id' => isset($transaction_detail->uom_id) ? $transaction_detail->uom_id : null,
                                'sku_status_id' => isset($transaction_detail->sku_status_id) ? $transaction_detail->sku_status_id : null,
                            );
                        } else {

                            $data['message'] = 'Quantity Issued greater than inventory on hand';
                            $data['success'] = false;
                            $data["type"] = "danger";
                        }
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
            'attachment' => $attachment,
            'uom' => $uom,
            'sku_status' => $sku_status,
            'zone_list' => $zone_list,
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
            'expiration_date' => isset($inventory->expiration_date) ? $inventory->expiration_date : null,
            'inventory_on_hand' => isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0,
            'uom_id' => isset($inventory->uom_id) ? $inventory->uom_id : null,
            'sku_status_id' => isset($inventory->sku_status_id) ? $inventory->sku_status_id : null,
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

            $status = "";
            switch ($value->status) {
                case OutgoingInventory::OUTGOING_PENDING_STATUS:
                    $status = '<span class="label label-warning">' . OutgoingInventory::OUTGOING_PENDING_STATUS . '</span>';
                    break;
                case OutgoingInventory::OUTGOING_COMPLETE_STATUS:
                    $status = '<span class="label label-success">' . OutgoingInventory::OUTGOING_COMPLETE_STATUS . '</span>';
                    break;
                case OutgoingInventory::OUTGOING_INCOMPLETE_STATUS:
                    $status = '<span class="label label-danger">' . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . '</span>';
                    break;
                case OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS:
                    $status = '<span class="label label-primary">' . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . '</span>';
                    break;
                default:
                    break;
            }

            $row['outgoing_inventory_detail_id'] = $value->outgoing_inventory_detail_id;
            $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['source_zone_id'] = $value->source_zone_id;
            $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['planned_quantity'] = $value->planned_quantity;
            $row['quantity_issued'] = $value->quantity_issued;
            $row['amount'] = "&#x20B1;" . number_format($value->amount, 2, '.', ',');
            $row['inventory_on_hand'] = $value->inventory_on_hand;
            $row['return_date'] = $value->return_date;
            $row['status'] = $status;
            $row['remarks'] = $value->remarks;
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;

            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/outgoingInventory/deleteOutgoingDetail', array('outgoing_inv_detail_id' => $value->outgoing_inventory_detail_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

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
        $outgoing = $this->loadModel($id);

        $this->pageTitle = "Update " . OutgoingInventory::OUTGOING_LABEL . ' Inventory';
        $this->layout = '//layouts/column1';

//        $outgoing = new OutgoingInventory;
        $transaction_detail = new OutgoingInventoryDetail;
        $sku = new Sku;
        $attachment = new Attachment;
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');
        $zone_list = CHtml::listData(Zone::model()->findAll(array("condition" => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['OutgoingInventory'])) {
                    $outgoing->attributes = $_POST['OutgoingInventory'];
                    $outgoing->updated_by = Yii::app()->user->name;
                    $outgoing->updated_date = date('Y-m-d H:i:s');

                    $validatedOutgoing = CActiveForm::validate($outgoing);

                    if ($validatedOutgoing != '[]') {

                        $data['error'] = $validatedOutgoing;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {

                        if ($data['form'] == "print") {

                            $data['print'] = $_POST;
                            $data['success'] = true;
                        } else {

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();
                            $outgoing_inv_ids_to_be_delete = isset($_POST['outgoing_inv_ids']) ? $_POST['outgoing_inv_ids'] : "";

                            if ($outgoing->updateTransaction($outgoing, $outgoing_inv_ids_to_be_delete, $transaction_details)) {
                                $data['outgoing_inv_id'] = Yii::app()->session['outgoing_inv_id_update_session'];
                                unset(Yii::app()->session['outgoing_inv_id_update_session']);
                                $data['message'] = 'Successfully updated';
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

        $this->render('outgoingForm', array(
            'outgoing' => $outgoing,
            'transaction_detail' => $transaction_detail,
            'sku' => $sku,
            'attachment' => $attachment,
            'uom' => $uom,
            'sku_status' => $sku_status,
            'zone_list' => $zone_list,
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

                // delete outgoing details by receiving_inventory_id
                OutgoingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND outgoing_inventory_id = " . $id);
                // delete attachment by outgoing_inventory_id as transaction_id
                $this->deleteAttachmentByOutgoingInvID($id);

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

    public function actionDeleteOutgoingDetail($outgoing_inv_detail_id) {
        if (Yii::app()->request->isPostRequest) {
            try {

                OutgoingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND outgoing_inventory_detail_id = " . $outgoing_inv_detail_id);

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

    public function deleteAttachmentByOutgoingInvID($outgoing_inv_id, $transaction_type = Attachment::OUTGOING_TRANSACTION_TYPE) {
        $attachment = Attachment::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "transaction_type" => $transaction_type, "transaction_id" => $outgoing_inv_id));

        if (count($attachment) > 0) {
            $base = Yii::app()->getBaseUrl(true);
            $arr = explode("/", $base);
            $base = $arr[count($arr) - 1];

            Attachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND transaction_type = '" . $transaction_type . "' AND transaction_id = " . $outgoing_inv_id);
            $this->delete_directory('../' . $base . "/protected/uploads/" . Yii::app()->user->company_id . "/attachments/" . $transaction_type . "/" . $outgoing_inv_id);
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
        $this->pageTitle = 'Manage ' . OutgoingInventory::OUTGOING_LABEL . ' Inventory';

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
            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . Attachment::OUTGOING_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . Yii::app()->session['tid'];

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/' . Attachment::OUTGOING_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . Yii::app()->session['tid'] . DIRECTORY_SEPARATOR . $file_name;
            $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

            $model->attachment_id = Globals::generateV4UUID();
            $model->company_id = Yii::app()->user->company_id;
            $model->file_name = $file_name;
            $model->url = $url;
            $model->transaction_id = Yii::app()->session['tid'];
            $model->transaction_type = Attachment::OUTGOING_TRANSACTION_TYPE;
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

            $row['links'] = '<a class="btn btn-sm btn-default" title="Delete" href="' . $this->createUrl('/inventory/outgoinginventory/download', array('id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-download"></i>
                            </a>'
                    . '&nbsp;<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/outgoinginventory/deleteAttachment', array('attachment_id' => $value->attachment_id)) . '">
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

    public function actionSearchCampaignNo($value) {

        $c = new CDbCriteria();
        if ($value != "") {
            $c->addSearchCondition('t.campaign_no', $value, true);
        }
        $c->compare('t.company_id', Yii::app()->user->company_id);
        $c->group = "t.campaign_no";
        $receiving = ReceivingInventory::model()->findAll($c);
        $incoming = IncomingInventory::model()->findAll($c);

        $receiving_arr = array();
        $incoming_arr = array();
        foreach ($receiving as $k1 => $v1) {
            $receiving_arr[$k1]['transaction'] = ReceivingInventory::RECEIVING_LABEL;
            $receiving_arr[$k1]['campaign_no'] = $v1->campaign_no;
            $receiving_arr[$k1]['pr_no'] = $v1->pr_no;
            $receiving_arr[$k1]['pr_date'] = $v1->pr_date;
            $receiving_arr[$k1]['source_zone_id'] = $v1->zone_id;
        }

        foreach ($incoming as $k2 => $v2) {
            $incoming_arr[$k2]['transaction'] = IncomingInventory::INCOMING_LABEL;
            $incoming_arr[$k2]['campaign_no'] = $v2->campaign_no;
            $incoming_arr[$k2]['pr_no'] = $v2->pr_no;
            $incoming_arr[$k2]['pr_date'] = $v2->pr_date;
            $incoming_arr[$k2]['source_zone_id'] = $v2->source_zone_id;
        }

        $return = array_merge($receiving_arr, $incoming_arr);

        echo json_encode($return);
        Yii::app()->end();
    }

    public function actionLoadPRNos($campaign_no, $transaction) {

        $data = array();
        $pr_nos = array();

        if ($transaction == ReceivingInventory::RECEIVING_LABEL) {

            $c = new CDbCriteria;
            $c->condition = "receivingInventory.company_id = '" . Yii::app()->user->company_id . "' AND receivingInventory.campaign_no = '" . $campaign_no . "'";
            $c->with = array("receivingInventory");
            $receiving = ReceivingInventoryDetail::model()->findAll($c);

            foreach ($receiving as $key => $val) {

                array_push($pr_nos, $val->receivingInventory->pr_no);
            }
        } else {

            $c1 = new CDbCriteria;
            $c1->condition = "incomingInventory.company_id = '" . Yii::app()->user->company_id . "' AND incomingInventory.campaign_no = '" . $campaign_no . "'";
            $c1->with = array("incomingInventory");
            $incoming = IncomingInventoryDetail::model()->findAll($c1);

            foreach ($incoming as $key => $val) {

                array_push($pr_nos, $val->incomingInventory->pr_no);
            }
        }

        foreach ($pr_nos as $key => $val) {
            $data["pr_no"][$val] = $val;
        }

        echo json_encode($data);
        Yii::app()->end();
    }

    public function actionLoadInvByPRNo($campaign_no, $pr_no, $transaction) {

        $data = array();
        $header = array();
        $inv_ids = "";

        if ($transaction == ReceivingInventory::RECEIVING_LABEL) {

            $c = new CDbCriteria;
            $c->condition = "receivingInventory.company_id = '" . Yii::app()->user->company_id . "' AND receivingInventory.campaign_no = '" . $campaign_no . "' AND receivingInventory.pr_no = '" . $pr_no . "'";
            $c->with = array("receivingInventory");
            $receiving = ReceivingInventoryDetail::model()->findAll($c);

            foreach ($receiving as $key => $val) {

                $inventoryObj = Inventory::model()->findByAttributes(
                        array(
                            'company_id' => $val->receivingInventory->company_id,
                            'sku_id' => $val->sku_id,
                            'uom_id' => $val->uom_id,
                            'zone_id' => $val->receivingInventory->zone_id,
                            'sku_status_id' => $val->sku_status_id != "" ? $val->sku_status_id : null,
                            'expiration_date' => isset($val->expiration_date) ? $val->expiration_date : null,
                            'reference_no' => $val->batch_no,
                        )
                );

                if ($inventoryObj) {
                    $inv_ids .= $inventoryObj->inventory_id . ",";
                }
            }

            $header = array(
                "pr_date" => isset($val->receivingInventory->pr_date) ? $val->receivingInventory->pr_date : null,
            );
        } else {

            $c1 = new CDbCriteria;
            $c1->condition = "incomingInventory.company_id = '" . Yii::app()->user->company_id . "' AND incomingInventory.campaign_no = '" . $campaign_no . "' AND incomingInventory.pr_no = '" . $pr_no . "'";
            $c1->with = array("incomingInventory");
            $incoming = IncomingInventoryDetail::model()->findAll($c1);

            foreach ($incoming as $key => $val) {

                $inventoryObj = Inventory::model()->findByAttributes(
                        array(
                            'company_id' => $val->incomingInventory->company_id,
                            'sku_id' => $val->sku_id,
                            'uom_id' => $val->uom_id,
                            'zone_id' => $val->incomingInventory->zone_id,
                            'sku_status_id' => $val->sku_status_id != "" ? $val->sku_status_id : null,
                            'expiration_date' => isset($val->expiration_date) ? $val->expiration_date : null,
                            'reference_no' => $val->batch_no,
                        )
                );

                if ($inventoryObj) {
                    $inv_ids .= $inventoryObj->inventory_id . ",";
                }
            }

            $header = array(
                "pr_date" => isset($val->incomingInventory->pr_date) ? $val->incomingInventory->pr_date : null,
            );
        }

        $inventory = array();
        if ($inv_ids != "") {
            $c1 = new CDbCriteria;
            $c1->compare("company_id", Yii::app()->user->company_id);
            $c1->condition = "inventory_id IN (" . substr($inv_ids, 0, -1) . ")";
            $inventory = Inventory::model()->findAll($c1);
        }

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

            $data['inv'][] = $row;
        }

        $data['headers'] = $header;

        echo json_encode($data);
        Yii::app()->end();
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

        $headers = $data['OutgoingInventory'];
        $details = $data['transaction_details'];

        $c1 = new CDbCriteria();
        $c1->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.zone_id = "' . $headers['destination_zone_id'] . '"';
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

        $c5 = new CDbCriteria;
        $c5->select = "t.*, zone.*";
        $c5->condition = 't.company_id = "' . Yii::app()->user->company_id . '"';
        $c5->with = array("zone");
        $employee = Employee::model()->find($c5);

        if ($employee && $employee->default_zone_id == $zone->zone_id) {
            $sales_office_name = isset($employee->zone->zone_name) ? $employee->zone->zone_name : "";
            $sales_office_address = isset($employee->address1) ? $employee->address1 : "";
        } else {
            $sales_office_name = isset($salesoffice->sales_office_name) ? $salesoffice->sales_office_name : "";
            $sales_office_address = isset($salesoffice->full_address) ? $salesoffice->full_address : "";
        }

        $transaction_date = $headers['transaction_date'];
        $plan_delivery_date = $headers['plan_delivery_date'];

        $pr_nos = "";
        $pr_no_arr = array();
        foreach ($details as $key => $val) {
            if ($val['outgoing_inv_detail_id'] != "") {
                $value = OutgoingInventoryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_detail_id" => $val['outgoing_inv_detail_id']));
            } else {
                $value = Inventory::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "inventory_id" => $val['inventory_id']));
            }

            if ($value) {
                if (!in_array($value->pr_no, $pr_no_arr)) {
                    array_push($pr_no_arr, $value->pr_no);
                    $pr_nos .= $value->pr_no . ",";
                }
            }
        }

        $pr_no = substr($pr_nos, 0, -1);
        $rra_no = $headers['rra_no'];
        $rra_date = $headers['rra_date'];
        $dr_no = $headers['dr_no'];

        $c3 = new CDbCriteria();
        $c3->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.zone_id = "' . $headers['source_zone_id'] . '"';
        $c3->with = array("salesOffice");
        $souce_zone = Zone::model()->find($c3);

        $c4 = new CDbCriteria();
        $c4->select = new CDbExpression('t.*, CONCAT(TRIM(barangay.barangay_name), ", ", TRIM(municipal.municipal_name), ", ", TRIM(province.province_name), ", ", TRIM(region.region_name)) AS full_address');
        $c4->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.sales_office_id = ""';
        $c4->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
        $c4->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
        $c4->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
        $c4->join .= ' LEFT JOIN region ON region.region_code = t.region_id';
        $source_salesoffice = Salesoffice::model()->find($c4);

        $source_sales_office_name = isset($source_salesoffice->sales_office_name) ? $source_salesoffice->sales_office_name : "";
        $source_sales_office_contact_person = "";
        $source_sales_office_address = isset($source_salesoffice->full_address) ? $source_salesoffice->full_address : "";


        $pdf = Globals::pdf();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('DejaVu Sans', '', 10);

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
                .align-right { text-align: right; }
            </style>

            <div id="header" class="text-center">
                <span class="title">ASIA BREWERY INCORPORATED</span><br/>
                <span class="sub-title">6th FLOOR ALLIED BANK CENTER, AYALA AVENUE, MAKATI CITY</span><br/>
                <span class="title-report">DELIVERY RECEIPT</span>
            </div><br/><br/>

            <table class="table_main">
                <tr>
                    <td clss="row_label" style="font-weight: bold;">SALES OFFICE / SALESMAN</td>
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
                    <td clss="row_label" style="font-weight: bold;">PR NUMBER</td>
                    <td class="border-bottom row_content_sm">' . $pr_no . '</td>
                    <td style="width: 10px;"></td>
                    <td clss="row_label" style="font-weight: bold;">WAREHOUSE NAME</td>
                    <td class="border-bottom row_content_lg">' . $source_sales_office_name . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">RRA NUMBER</td>
                    <td class="border-bottom">' . $rra_no . '</td>
                    <td></td>
                    <td style="font-weight: bold;">CONTACT PERSON</td>
                    <td class="border-bottom">' . $source_sales_office_contact_person . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">RRA DATE</td>
                    <td class="border-bottom">' . $rra_date . '</td>
                    <td></td>
                    <td style="font-weight: bold;">ADDRESS</td>
                    <td class="border-bottom">' . $source_sales_office_address . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">DR NUMBER</td>
                    <td class="border-bottom">' . $dr_no . '</td>
                    <td></td>
                    <td></td>
                    <td class="border-bottom"></td>
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

            $html .= '<tr>
                            <td>' . $sku->sku_code . '</td>
                            <td>' . $sku->description . '</td>
                            <td>' . $sku->brand->brand_name . '</td>
                            <td>' . $sku->type . '</td>
                            <td>' . $val['planned_quantity'] . '</td>
                            <td>' . $val['quantity_issued'] . '</td>
                            <td>' . $uom->uom_name . '</td>
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
                    <td style="font-weight: bold;">DRIVER' . "'" . 'S NAME:</td>
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
                    <td style="font-weight: bold;">DRIVER' . "'" . 'S SIGNATURE:</td>
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

        $pdf->Output('outbound.pdf', 'I');
    }

    public function actionGetDetailsByOutgoingInvID($outgoing_inv_id) {

        $c = new CDbCriteria;
        $c->condition = "company_id = '" . Yii::app()->user->company_id . "' AND outgoing_inventory_id = '" . $outgoing_inv_id . "'";
        $outgoing_inv_details = OutgoingInventoryDetail::model()->findAll($c);

        $output = array();
        foreach ($outgoing_inv_details as $key => $value) {
            $row = array();

            $status = Inventory::model()->status($value->status);

            $uom = Uom::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "uom_id" => $value->uom_id));

            $row['outgoing_inventory_detail_id'] = $value->outgoing_inventory_detail_id;
            $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['sku_category'] = isset($value->sku->type) ? $value->sku->type : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['source_zone_id'] = $value->source_zone_id;
            $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['planned_quantity'] = $value->planned_quantity;
            $row['quantity_issued'] = $value->quantity_issued;
            $row['amount'] = "&#x20B1;" . number_format($value->amount, 2, '.', ',');
            $row['inventory_on_hand'] = $value->inventory_on_hand;
            $row['return_date'] = $value->return_date;
            $row['status'] = $status;
            $row['remarks'] = $value->remarks;
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;
            $row['uom_name'] = $uom->uom_name;

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionGetTransactionDetailsByOutgoingInvID($outgoing_inv_id) {

        $c = new CDbCriteria;
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.outgoing_inventory_id = '" . $outgoing_inv_id . "'";
        $c->with = array("zone");
        $outgoing_inv = OutgoingInventory::model()->find($c);

        $c1 = new CDbCriteria;
        $c1->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND zones.zone_id = '" . $outgoing_inv->zone->zone_id . "'";
        $c1->with = array("zones");
        $destination_sales_office = SalesOffice::model()->find($c1);

        $outgoing_detail = OutgoingInventoryDetail::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_id" => $outgoing_inv->outgoing_inventory_id));

        $zone_ids = "";
        $pr_nos = "";
        $pr_no_arr = array();
        $campaign_nos = "";
        $campaign_no_arr = array();
        $pr_dates = "";
        $pr_dates_arr = array();
        foreach ($outgoing_detail as $key => $val) {
            $zone_ids .= "'" . $val->source_zone_id . "',";

            if (!in_array($val->pr_no, $pr_no_arr)) {
                array_push($pr_no_arr, $val->pr_no);
                $pr_nos .= $val->pr_no . ",";
            }

            if (!in_array($val->campaign_no, $campaign_no_arr)) {
                array_push($campaign_no_arr, $val->campaign_no);
                $campaign_nos .= $val->campaign_no . ",";
            }

            if (!in_array($val->pr_date, $pr_dates_arr)) {
                array_push($pr_dates_arr, $val->pr_date);
                $pr_dates .= $val->pr_date . ",";
            }
        }

        $pr_nos = substr($pr_nos, 0, -1);
        $pr_dates = substr($pr_dates, 0, -1);
        $campaign_nos = substr($campaign_nos, 0, -1);

        $c2 = new CDbCriteria;
        $c2->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND zones.zone_id IN(" . substr($zone_ids, 0, -1) . ")";
        $c2->with = array("zones");
        $c2->order = "t.sales_office_name ASC";
        $sales_office = SalesOffice::model()->findAll($c2);

        $status = Inventory::model()->status($outgoing_inv->status);

        $not_set = "<i class='text-muted'>Not Set</i>";

        $output = array();
        $output['dr_no'] = $outgoing_inv->dr_no;
        $output['dr_date'] = $outgoing_inv->dr_date;
        $output['rra_no'] = $outgoing_inv->rra_no != "" ? $outgoing_inv->rra_no : $not_set;
        $output['rra_date'] = isset($outgoing_inv->rra_date) ? $outgoing_inv->rra_date : $not_set;
        $output['destination_contact_person'] = $outgoing_inv->contact_person != "" ? $outgoing_inv->contact_person : $not_set;
        $output['destination_contact_no'] = $outgoing_inv->contact_no != "" ? $outgoing_inv->contact_no : $not_set;
        $output['address'] = $outgoing_inv->address != "" ? $outgoing_inv->address : $not_set;
        $output['plan_delivery_date'] = isset($outgoing_inv->plan_delivery_date) ? $outgoing_inv->plan_delivery_date : $not_set;
        $output['transaction_date'] = $outgoing_inv->transaction_date;
        $output['status'] = $outgoing_inv->status;
        $output['remarks'] = $outgoing_inv->remarks != "" ? $outgoing_inv->remarks : $not_set;
        $output['total_amount'] = number_format($outgoing_inv->total_amount, 2, '.', ',');
        $output['zone_name'] = $outgoing_inv->zone->zone_name;
        $output['destination_sales_office_name'] = isset($destination_sales_office->sales_office_name) ? $destination_sales_office->sales_office_name : "";
        $output['transaction_status'] = $status;
        $output['pr_nos'] = $pr_nos;
        $output['pr_date'] = $pr_dates;
        $output['campaign_nos'] = $campaign_nos;

        echo json_encode($output);
    }

    public function actionLoadItemDetails($outgoing_inv_id) {

        $outgoing_inv_details = OutgoingInventoryDetail::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_id" => $outgoing_inv_id));

        $output = array();
        foreach ($outgoing_inv_details as $key => $val) {
            $row = array();

            $row["inventory_id"] = isset($val->inventory_id) ? $val->inventory_id : null;
            $row["sku_id"] = isset($val->sku->sku_id) ? $val->sku->sku_id : null;
            $row["sku_code"] = isset($val->sku->sku_code) ? $val->sku->sku_code : null;
            $row["sku_description"] = isset($val->sku->description) ? $val->sku->description : null;
            $row["brand_name"] = isset($val->sku->brand->brand_name) ? $val->sku->brand->brand_name : null;
            $row["unit_price"] = isset($val->unit_price) && $val->unit_price != "" ? number_format($val->unit_price, 2, '.', '') : number_format(0, 2, '.', '');
            $row["batch_no"] = isset($val->batch_no) ? $val->batch_no : null;
            $row["source_zone_id"] = isset($val->source_zone_id) ? $val->source_zone_id : null;
            $row["source_zone_name"] = isset($val->zone->zone_name) ? $val->zone->zone_name : null;
            $row["expiration_date"] = isset($val->expiration_date) ? $val->expiration_date : null;
            $row["planned_quantity"] = $val->planned_quantity != "" ? $val->planned_quantity : 0;
            $row["quantity_issued"] = $val->quantity_issued != "" ? $val->quantity_issued : 0;
            $row["amount"] = $val->amount != "" ? number_format($val->amount, 2, '.', '') : number_format(0, 2, '.', '');
            $row["return_date"] = isset($val->return_date) ? $val->return_date : null;
            $row["remarks"] = isset($val->remarks) ? $val->remarks : null;
            $row["uom_id"] = isset($val->uom_id) ? $val->uom_id : null;
            $row["sku_status_id"] = isset($val->sku_status_id) ? $val->sku_status_id : null;
            $row['outgoing_inv_detail_id'] = $val->outgoing_inventory_detail_id;

            $output[] = $row;
        }

        echo json_encode($output);
    }

}
