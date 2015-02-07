<?php

class IncomingInventoryController extends Controller {
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
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('data', 'loadAllOutgoingTransactionDetailsByDRNo', 'loadInventoryDetails', 'incomingInvDetailData', 'uploadAttachment', 'preview', 'download', 'print', 'loadPDF',
                    'getDetailsByIncomingInvID', 'viewPrint', 'loadIncomingDetailByID', 'loadAttachmentDownload'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin'),
                'expression' => "Yii::app()->user->checkAccess('Manage Inbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => "Yii::app()->user->checkAccess('Add Inbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => "Yii::app()->user->checkAccess('View Inbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('update'),
                'expression' => "Yii::app()->user->checkAccess('Edit Inbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('delete', 'deleteIncomingDetail', 'deleteAttachment'),
                'expression' => "Yii::app()->user->checkAccess('Delete Inbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        IncomingInventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = IncomingInventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = IncomingInventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

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

            $row['incoming_inventory_id'] = $value->incoming_inventory_id;
//            $row['campaign_no'] = $value->campaign_no;
//            $row['pr_no'] = $value->pr_no;
//            $row['pr_date'] = $value->pr_date;
            $row['dr_no'] = $value->dr_no;
            $row['dr_date'] = $value->dr_date;
            $row['rra_no'] = $value->rra_no;
            $row['rra_date'] = $value->rra_date;
            $row['destination_zone_id'] = $value->destination_zone_id;
            $row['destination_zone_name'] = $value->zone->zone_name;
            $row['transaction_date'] = $value->transaction_date;
            $row['status'] = $status;
            $row['total_amount'] = "&#x20B1;" . number_format($value->total_amount, 2, '.', ',');
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;

            $row['links'] = '<a class="btn btn-sm btn-default view" title="View" href="' . $this->createUrl('/inventory/incomingInventory/view', array('id' => $value->incoming_inventory_id)) . '">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/incomingInventory/delete', array('id' => $value->incoming_inventory_id)) . '">
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
        $attachment = new Attachment;

        $this->pageTitle = "View " . IncomingInventory::INCOMING_LABEL . ' Inventory';

        $this->menu = array(
            array('label' => "Create " . IncomingInventory::INCOMING_LABEL . ' Inventory', 'url' => array('create')),
            array('label' => "Delete " . IncomingInventory::INCOMING_LABEL . ' Inventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->incoming_inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => "Manage " . IncomingInventory::INCOMING_LABEL . ' Inventory', 'url' => array('admin')),
        );

        $c = new CDbCriteria;
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.incoming_inventory_id = '" . $model->incoming_inventory_id . "'";
        $c->with = array("zone");
        $incoming_inv = IncomingInventory::model()->find($c);

        $c1 = new CDbCriteria;
        $c1->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND zones.zone_id = '" . $incoming_inv->zone->zone_id . "'";
        $c1->with = array("zones");
        $destination_sales_office = SalesOffice::model()->find($c1);

        $c2 = new CDbCriteria;
        $c2->select = new CDbExpression('t.*, CONCAT(t.first_name, " ",t.last_name) AS fullname');
        $c2->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.default_zone_id = '" . $incoming_inv->zone->zone_id . "'";
        $employee = Employee::model()->find($c2);

        $destination = array();
        $destination['zone_name'] = $incoming_inv->zone->zone_name;
        $destination['destination_sales_office_name'] = isset($destination_sales_office->sales_office_name) ? $destination_sales_office->sales_office_name : "";
//        $destination['contact_person'] = isset($employee) ? $employee->fullname : "";
//        $destination['contact_no'] = isset($employee) ? $employee->work_phone_number : "";
        $destination['contact_person'] = $incoming_inv->contact_person != "" ? $incoming_inv->contact_person : "";
        $destination['contact_no'] = $incoming_inv->contact_no != "" ? $incoming_inv->contact_no : "";
        $destination['address'] = isset($destination_sales_office->address1) ? $destination_sales_office->address1 : "";

        $incoming_detail = IncomingInventoryDetail::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "incoming_inventory_id" => $model->incoming_inventory_id));

        $zone_ids = "";
        $pr_nos = "";
        $pr_no_arr = array();
        $po_nos = "";
        $po_no_arr = array();
        $pr_dates = "";
        $pr_dates_arr = array();
        $source_zones = "";
        $source_zones_arr = array();
        $source_address = "";
        $source_contact_person = "";
        $source_contact_no = "";
        $i = $x = $y = $z = 1;
        foreach ($incoming_detail as $key => $val) {
            $zone_ids .= "'" . $val->source_zone_id . "',";

            if (!in_array($val->pr_no, $pr_no_arr)) {
                array_push($pr_no_arr, $val->pr_no);
                $pr_nos .= $val->pr_no . ",";
            }

            if (!in_array($val->po_no, $po_no_arr)) {
                array_push($po_no_arr, $val->po_no);
                $po_nos .= $val->po_no . ",";
            }

            if (!in_array($val->pr_date, $pr_dates_arr)) {
                array_push($pr_dates_arr, $val->pr_date);
                $pr_dates .= $val->pr_date . ",";
            }

            $source_zone_id = $val->source_zone_id;

            if (!in_array($source_zone_id, $source_zones_arr)) {
                array_push($source_zones_arr, $source_zone_id);

                $inc_source_zone = Zone::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "zone_id" => $source_zone_id));
                if ($inc_source_zone) {
                    $source_zones .= "<sup>" . $i++ . ".</sup> " . $inc_source_zone->zone_name . " <i class='text-muted'>(" . $inc_source_zone->salesOffice->sales_office_name . ")</i><br/>";
                    $source_address .= isset($inc_source_zone->salesOffice->address1) ? "<sup>" . $x++ . ".</sup> " . $inc_source_zone->salesOffice->address1 . "<br/>" : "";
                }

                $c3 = new CDbCriteria;
                $c3->select = new CDbExpression('t.*, CONCAT(t.first_name, " ",t.last_name) AS fullname');
                $c3->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.default_zone_id = '" . $source_zone_id . "'";
                $source_employee = Employee::model()->find($c3);
                $source_contact_person .= isset($source_employee) ? "<sup>" . $y++ . ".</sup> " . $source_employee->fullname . "<br/>" : "";
                $source_contact_no .= isset($source_employee) ? "<sup>" . $z++ . ".</sup> " . $source_employee->work_phone_number . "<br/>" : "";
            }
        }

        $pr_nos = substr($pr_nos, 0, -1);
        $pr_dates = substr($pr_dates, 0, -1);
        $po_nos = substr($po_nos, 0, -1);

        $source = array();
        $source['source_zone_name_so_name'] = $source_zones;
        $source['contact_person'] = $source_contact_person;
        $source['contact_no'] = $source_contact_no;
        $source['address'] = $source_address;

        $this->render('view', array(
            'model' => $model,
            'destination' => $destination,
            'pr_nos' => $pr_nos,
            'pr_dates' => $pr_dates,
            'po_nos' => $po_nos,
            'source' => $source,
            'attachment_model' => $attachment,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pageTitle = IncomingInventory::INCOMING_LABEL . ' Inventory';
        $this->layout = '//layouts/column1';

        $incoming = new IncomingInventory;
        $transaction_detail = new IncomingInventoryDetail;
        $sku = new Sku;
        $model = new Attachment;

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->condition = "closed != 2 AND destination_zone_id IN (" . Yii::app()->user->zones . ")";
        $c->order = "dr_no ASC";
        $outgoing_inv_dr_nos = CHtml::listData(OutgoingInventory::model()->findAll($c), "dr_no", "dr_no");
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['IncomingInventory'])) {
                    $incoming->attributes = $_POST['IncomingInventory'];
                    $incoming->company_id = Yii::app()->user->company_id;
                    $incoming->created_by = Yii::app()->user->name;
                    unset($incoming->created_date);

                    $validatedIncoming = CActiveForm::validate($incoming);
                    $emails = isset($_POST['emails']) ? $_POST['emails'] : array();
                    $recipients = isset($_POST['recipients']) ? $_POST['recipients'] : array();
                    $validatedEmails = ReceivingInventory::model()->validateEmails($incoming, $emails);
                    $validatedRecipients = ReceivingInventory::model()->validateRecipients($incoming, $recipients);

                    $validatedModel_arr = (array) json_decode($validatedIncoming);
                    $model_errors = json_encode(array_merge($validatedModel_arr, $validatedEmails, $validatedRecipients));

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

                            $incoming->outgoing_inventory_id = $_POST['IncomingInventory']['outgoing_inventory_id'];

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                            $recipients_address['emails'] = CJSON::encode($emails);
                            $recipients_address['recipients'] = CJSON::encode($recipients);
                            $recipient_email_address = ReceivingInventory::model()->mergeRecipientAndEmails($emails, $recipients);

                            $incoming->recipients = CJSON::encode($recipient_email_address);

                            $saved = $incoming->create($transaction_details);

                            if ($saved['success']) {
                                $data['incoming_inv_id'] = $saved['header_data']->incoming_inventory_id;
                                $data['message'] = 'Successfully created';
                                $data['success'] = true;

                                $this->generateRecipientDetails(CJSON::decode($saved['header_data']->recipients), $saved['header_data'], $saved['detail_data']);
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

                if (isset($_POST['IncomingInventoryDetail'])) {
                    $transaction_detail->attributes = $_POST['IncomingInventoryDetail'];
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
                        $c->compare('t.sku_id', $transaction_detail->sku_id);
                        $c->with = array('brand', 'company', 'defaultUom', 'defaultZone');
                        $sku_details = Sku::model()->find($c);

                        $data['success'] = true;
                        $data['message'] = 'Successfully Added Item';

                        $status = "";
                        $qty_received = $transaction_detail->quantity_received != "" ? $transaction_detail->quantity_received : 0;
                        $planned_qty = $transaction_detail->planned_quantity != "" ? $transaction_detail->planned_quantity : 0;

                        if ($qty_received == $planned_qty) {
                            $status = OutgoingInventory::OUTGOING_COMPLETE_STATUS;
                        } else if ($qty_received < $planned_qty) {
                            $status = OutgoingInventory::OUTGOING_INCOMPLETE_STATUS;
                        } else if ($qty_received > $planned_qty) {
                            $status = OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS;
                        }

                        $data['details'] = array(
                            "inventory_id" => "",
                            "sku_id" => isset($sku_details->sku_id) ? $sku_details->sku_id : null,
                            "sku_code" => isset($sku_details->sku_code) ? $sku_details->sku_code : null,
                            "sku_description" => isset($sku_details->description) ? $sku_details->description : null,
                            'brand_name' => isset($sku_details->brand->brand_name) ? $sku_details->brand->brand_name : null,
                            'unit_price' => isset($transaction_detail->unit_price) ? number_format($transaction_detail->unit_price, 2, '.', '') : number_format(0, 2, '.', ''),
                            'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                            'source_zone_id' => isset($transaction_detail->source_zone_id) ? $transaction_detail->source_zone_id : null,
                            'source_zone_name' => isset($transaction_detail->zone->zone_name) ? $transaction_detail->zone->zone_name : null,
                            'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                            'planned_quantity' => $planned_qty,
                            'quantity_received' => $qty_received,
                            'amount' => $transaction_detail->amount != "" ? number_format($transaction_detail->amount, 2, '.', '') : number_format(0, 2, '.', ''),
                            'inventory_on_hand' => $transaction_detail->inventory_on_hand != "" ? $transaction_detail->inventory_on_hand : 0,
                            'reference_no' => isset($transaction_detail->pr_no) ? $transaction_detail->pr_no : null,
                            'return_date' => isset($transaction_detail->return_date) ? $transaction_detail->return_date : null,
                            'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                            'outgoing_inventory_detail_id' => "",
                            'status' => $status,
                            'uom_id' => isset($transaction_detail->uom_id) ? $transaction_detail->uom_id : null,
                            'sku_status_id' => isset($transaction_detail->sku_status_id) ? $transaction_detail->sku_status_id : null,
                        );
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $this->render('incomingForm', array(
            'incoming' => $incoming,
            'transaction_detail' => $transaction_detail,
            'sku' => $sku,
            'outgoing_inv_dr_nos' => $outgoing_inv_dr_nos,
            'model' => $model,
            'uom' => $uom,
            'sku_status' => $sku_status,
        ));
    }

    public function actionLoadAllOutgoingTransactionDetailsByDRNo($dr_no) {

//        $c = new CDbCriteria;
//        $c->condition = "outgoingInventory.company_id = '" . Yii::app()->user->company_id . "' AND outgoingInventory.dr_no = '" . $dr_no . "'";
//        $c->with = array("outgoingInventory");
//        $outgoing_inv_details = OutgoingInventoryDetail::model()->findAll($c);

        $data = IncomingInventory::model()->loadAllOutgoingTransactionDetailsByDRNo(Yii::app()->user->company_id, $dr_no);
//        pre($data); exit;
        $output = array();
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $row = array();

                $row['outgoing_inventory_detail_id'] = $value['outgoing_inventory_detail_id'];
                $row['outgoing_inventory_id'] = $value['outgoing_inventory_id'];
                $row['inventory_id'] = $value['inventory_id'];
                $row['batch_no'] = $value['batch_no'];
                $row['sku_id'] = $value['sku_id'];
                $row['source_zone_id'] = $value['source_zone_id'];
                $row['source_zone_name'] = $value['source_zone_name'];
                $row['unit_price'] = $value['unit_price'];
                $row['expiration_date'] = $value['expiration_date'];
                $row['planned_quantity'] = $value['quantity_issued'];
                $row['quantity_received'] = "0";
                $row['amount'] = $value['amount'];
//                $row['inventory_on_hand'] = $value->inventory_on_hand;
                $row['return_date'] = $value['return_date'];
                $row['remarks'] = $value['remarks'];
                $row['sku_id'] = $value['sku_id'];
                $row['sku_code'] = $value['sku_code'];
                $row['sku_description'] = $value['description'];
                $row['brand_name'] = $value['brand_name'];
                $row['status'] = $value['status'];
                $row['uom_id'] = $value['uom_id'];
                $row['sku_status_id'] = $value['sku_status_id'];
                
                if ($value['remaining_qty'] == "") {

                    $row['remaining_qty'] = $value['quantity_issued'];
                } else {

                    $row['remaining_qty'] = $value['remaining_qty'];
                }
                
                $row['incoming_inventory_detail_id'] = isset($value['incoming_inventory_detail_id']) ? $value['incoming_inventory_detail_id'] : "";
                
                $output['transaction_details'][] = $row;
            }
        }

        $header = array(
            "rra_date" => isset($value['rra_date']) ? $value['rra_date'] : null,
//            "campaign_no" => isset($value->outgoingInventory->campaign_no) ? $value->outgoingInventory->campaign_no : null,
//            "pr_no" => isset($value->outgoingInventory->pr_no) ? $value->outgoingInventory->pr_no : null,
            "dr_date" => isset($value['transaction_date']) ? $value['transaction_date'] : null,
            "source_zone_id" => "",
            "destination_zone_id" => isset($value['destination_zone_id']) ? $value['destination_zone_id'] : "",
            "destination_zone_name" => isset($value['destination_zone_name']) ? $value['destination_zone_name'] : "",
            "plan_delivery_date" => isset($value['plan_delivery_date']) ? $value['plan_delivery_date'] : null,
//            "plan_arrival_date" => isset($value->outgoingInventory->plan_arrival_date) ? $value->outgoingInventory->plan_arrival_date : null,
            "outgoing_inventory_id" => isset($value['outgoing_inventory_id']) ? $value['outgoing_inventory_id'] : "",
            "rra_no" => isset($value['rra_no']) ? $value['rra_no'] : "",
            "contact_person" => isset($value['contact_person']) ? $value['contact_person'] : "",
            "contact_no" => isset($value['contact_no']) ? $value['contact_no'] : "",
            "contact_no" => isset($value['contact_no']) ? $value['contact_no'] : "",
            "incoming_inventory_id" => isset($value['incoming_inventory_id']) ? $value['incoming_inventory_id'] : "",
        );
        
        $output['headers'] = $header;
        
        $closed_status = isset($value['closed_status']) ? $value['closed_status'] : "";
        
        $for_update = false;
        if ($closed_status != 0) {
            $for_update = true;
        }
        
        $output['for_update'] = $for_update;

        echo json_encode($output);
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

    public function actionIncomingInvDetailData($incoming_inv_id) {

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("incoming_inventory_id", $incoming_inv_id);
        $incoming_inv_details = IncomingInventoryDetail::model()->findAll($c);

        $output = array();
        foreach ($incoming_inv_details as $key => $value) {
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

            $row['incoming_inventory_detail_id'] = $value->incoming_inventory_detail_id;
            $row['incoming_inventory_id'] = $value->incoming_inventory_id;
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
            $row['quantity_received'] = $value->quantity_received;
            $row['amount'] = "&#x20B1;" . number_format($value->amount, 2, '.', ',');
            $row['inventory_on_hand'] = $value->inventory_on_hand;
            $row['return_date'] = $value->return_date;
            $row['status'] = $status;
            $row['remarks'] = $value->remarks;
            $row['po_no'] = $value->po_no;
            $row['pr_no'] = $value->pr_no;

            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/incomingInventory/deleteIncomingDetail', array('incoming_inv_detail_id' => $value->incoming_inventory_detail_id)) . '">
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
        
        $incoming = $this->loadModel($id);
        $transaction_detail = new IncomingInventoryDetail;
        $sku = new Sku;
        $model = new Attachment;

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->condition = "closed = 0 AND destination_zone_id IN (" . Yii::app()->user->zones . ")";
        $c->order = "dr_no ASC";
        $outgoing_inv_dr_nos = CHtml::listData(OutgoingInventory::model()->findAll($c), "dr_no", "dr_no");
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction" || $_POST['form'] == "print") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['IncomingInventory'])) {
                    $incoming->attributes = $_POST['IncomingInventory'];
                    $incoming->company_id = Yii::app()->user->company_id;
                    $incoming->updated_by = Yii::app()->user->name;
                    $incoming->updated_date = date("Y-m-d H:i:s");

                    $validatedIncoming = CActiveForm::validate($incoming);
                    $emails = isset($_POST['emails']) ? $_POST['emails'] : array();
                    $recipients = isset($_POST['recipients']) ? $_POST['recipients'] : array();
                    $validatedEmails = ReceivingInventory::model()->validateEmails($incoming, $emails);
                    $validatedRecipients = ReceivingInventory::model()->validateRecipients($incoming, $recipients);

                    $validatedModel_arr = (array) json_decode($validatedIncoming);
                    $model_errors = json_encode(array_merge($validatedModel_arr, $validatedEmails, $validatedRecipients));

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

                            $incoming->outgoing_inventory_id = $_POST['IncomingInventory']['outgoing_inventory_id'];

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                            $recipients_address['emails'] = CJSON::encode($emails);
                            $recipients_address['recipients'] = CJSON::encode($recipients);
                            $recipient_email_address = ReceivingInventory::model()->mergeRecipientAndEmails($emails, $recipients);

                            $incoming->recipients = CJSON::encode($recipient_email_address);

                            $saved = $incoming->updateTransaction($transaction_details);

                            if ($saved['success']) {
                                $data['incoming_inv_id'] = $saved['header_data']->incoming_inventory_id;
                                $data['message'] = 'Successfully created';
                                $data['success'] = true;

//                                $this->generateRecipientDetails(CJSON::decode($saved['header_data']->recipients), $saved['header_data'], $saved['detail_data']);
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

                if (isset($_POST['IncomingInventoryDetail'])) {
                    $transaction_detail->attributes = $_POST['IncomingInventoryDetail'];
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
                        $c->compare('t.sku_id', $transaction_detail->sku_id);
                        $c->with = array('brand', 'company', 'defaultUom', 'defaultZone');
                        $sku_details = Sku::model()->find($c);

                        $data['success'] = true;
                        $data['message'] = 'Successfully Added Item';

                        $status = "";
                        $qty_received = $transaction_detail->quantity_received != "" ? $transaction_detail->quantity_received : 0;
                        $planned_qty = $transaction_detail->planned_quantity != "" ? $transaction_detail->planned_quantity : 0;

                        if ($qty_received == $planned_qty) {
                            $status = OutgoingInventory::OUTGOING_COMPLETE_STATUS;
                        } else if ($qty_received < $planned_qty) {
                            $status = OutgoingInventory::OUTGOING_INCOMPLETE_STATUS;
                        } else if ($qty_received > $planned_qty) {
                            $status = OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS;
                        }

                        $data['details'] = array(
                            "inventory_id" => "",
                            "sku_id" => isset($sku_details->sku_id) ? $sku_details->sku_id : null,
                            "sku_code" => isset($sku_details->sku_code) ? $sku_details->sku_code : null,
                            "sku_description" => isset($sku_details->description) ? $sku_details->description : null,
                            'brand_name' => isset($sku_details->brand->brand_name) ? $sku_details->brand->brand_name : null,
                            'unit_price' => isset($transaction_detail->unit_price) ? number_format($transaction_detail->unit_price, 2, '.', '') : number_format(0, 2, '.', ''),
                            'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                            'source_zone_id' => isset($transaction_detail->source_zone_id) ? $transaction_detail->source_zone_id : null,
                            'source_zone_name' => isset($transaction_detail->zone->zone_name) ? $transaction_detail->zone->zone_name : null,
                            'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                            'planned_quantity' => $planned_qty,
                            'quantity_received' => $qty_received,
                            'amount' => $transaction_detail->amount != "" ? number_format($transaction_detail->amount, 2, '.', '') : number_format(0, 2, '.', ''),
//                            'inventory_on_hand' => $transaction_detail->inventory_on_hand != "" ? $transaction_detail->inventory_on_hand : 0,
                            'reference_no' => isset($transaction_detail->pr_no) ? $transaction_detail->pr_no : null,
                            'return_date' => isset($transaction_detail->return_date) ? $transaction_detail->return_date : null,
                            'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                            'outgoing_inventory_detail_id' => "",
                            'status' => $status,
                            'uom_id' => isset($transaction_detail->uom_id) ? $transaction_detail->uom_id : null,
                            'sku_status_id' => isset($transaction_detail->sku_status_id) ? $transaction_detail->sku_status_id : null,
                        );
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $this->render('incomingForm', array(
            'incoming' => $incoming,
            'transaction_detail' => $transaction_detail,
            'sku' => $sku,
            'outgoing_inv_dr_nos' => $outgoing_inv_dr_nos,
            'model' => $model,
            'uom' => $uom,
            'sku_status' => $sku_status,
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

                // delete incoming details by receiving_inventory_id
                IncomingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND incoming_inventory_id = " . $id);
                // delete attachment by incoming_inventory_id as transaction_id
                $this->deleteAttachmentByIncomingInvID($id);

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

    public function actionDeleteIncomingDetail($incoming_inv_detail_id) {
        if (Yii::app()->request->isPostRequest) {
            try {

                IncomingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND incoming_inventory_detail_id = " . $incoming_inv_detail_id);

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

    public function deleteAttachmentByIncomingInvID($incoming_inv_id, $transaction_type = Attachment::INCOMING_TRANSACTION_TYPE) {
        $attachment = Attachment::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "transaction_type" => $transaction_type, "transaction_id" => $incoming_inv_id));

        if (count($attachment) > 0) {
            $base = Yii::app()->getBaseUrl(true);
            $arr = explode("/", $base);
            $base = $arr[count($arr) - 1];

            Attachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND transaction_type = '" . $transaction_type . "' AND transaction_id = " . $incoming_inv_id);
            $this->delete_directory('../' . $base . "/protected/uploads/" . Yii::app()->user->company_id . "/attachments/" . $transaction_type . "/" . $incoming_inv_id);
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
                    $delete_link = '../' . $base . $url;

                    if (file_exists($delete_link)) {
                        unlink($delete_link);
                    }
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
        $dataProvider = new CActiveDataProvider('IncomingInventory');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . IncomingInventory::INCOMING_LABEL . ' Inventory';

        $model = new IncomingInventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['IncomingInventory']))
            $model->attributes = $_GET['IncomingInventory'];

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
        $model = IncomingInventory::model()->findByAttributes(array('incoming_inventory_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'incoming-inventory-form') {
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

        $tag_category = Yii::app()->request->getPost('inventorytype', '');
        $tag_to = Yii::app()->request->getPost('tagname', '');
        $incoming_inv_id_attachment = Yii::app()->request->getPost('saved_incoming_inventory_id', '');

        if (isset($_FILES['Attachment']['name']) && $_FILES['Attachment']['name'] != "") {

            $file = CUploadedFile::getInstance($model, 'file');
            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . Attachment::INCOMING_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . $incoming_inv_id_attachment;

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/' . Attachment::INCOMING_TRANSACTION_TYPE . "/" . $incoming_inv_id_attachment . "/" . $file_name;

            if (@fopen($url, "r")) {

                throw new CHttpException(409, "Could not upload file. File already exist " . CHtml::errorSummary($model));
            } else {

                $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

                $model->attachment_id = Globals::generateV4UUID();

                $model->company_id = Yii::app()->user->company_id;
                $model->file_name = $file_name;
                $model->url = $url;
                $model->transaction_id = $incoming_inv_id_attachment;
                $model->transaction_type = Attachment::INCOMING_TRANSACTION_TYPE;
                $model->created_by = Yii::app()->user->name;
                if ($tag_category != "OTHERS") {
                    $model->tag_category = $tag_category;
                } else {
                    $model->tag_category = $tag_to;
                }

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
        $c->compare("transaction_type", Attachment::INCOMING_TRANSACTION_TYPE);
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

    public function actionDownload($id) {

        $attachment = Attachment::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "attachment_id" => $id));

        $url = $attachment->url;
        $name = $attachment->file_name;

        $base = Yii::app()->getBaseUrl(true);
        $arr = explode("/", $base);
        $base = $arr[count($arr) - 1];
        $url = str_replace(Yii::app()->getBaseUrl(true), "", $url);
        $src = '../' . $base . $url;

        $data = array();
        $data['success'] = false;
        $data['type'] = "success";

        if (file_exists($src)) {

            $data['name'] = $name;
            $data['src'] = $src;
            $data['success'] = true;
            $data['message'] = "Successfully downloaded";
        } else {

            $data['type'] = "danger";
            $data['message'] = "Could not download file";
        }

        echo json_encode($data);
    }

    public function actionLoadAttachmentDownload($name, $src) {
        ob_clean();
        Yii::app()->getRequest()->sendFile($name, file_get_contents($src));
    }

    public function actionPrint() {

        $data = Yii::app()->request->getParam('post_data');

        $incoming_inv = $data['IncomingInventory'];
        $incoming_inv_detail = $data['transaction_details'];

        $return = array();

        $details = array();
        $source = array();
        $destination = array();
        $headers = array();

        $pr_nos = "";
        $pr_no_arr = array();
        $source_zones = "";
        $source_zones_arr = array();
        $source_address = "";
        $source_contact_person = "";
        $i = $x = $y = 1;
        foreach ($incoming_inv_detail as $key => $val) {
            $row = array();

            if ($val['outgoing_inventory_detail_id'] != "") {
                $value = OutgoingInventoryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_detail_id" => $val['outgoing_inventory_detail_id']));
            } else {
                $value = Inventory::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "inventory_id" => $val['inventory_id']));
            }

            if ($value) {
                if ($value->pr_no != "") {
                    if (!in_array($value->pr_no, $pr_no_arr)) {
                        array_push($pr_no_arr, $value->pr_no);
                        $pr_nos .= $value->pr_no . ", ";
                    }
                }
            }

            $source_zone_id = trim($val['source_zone_id']);

            if (!in_array($source_zone_id, $source_zones_arr)) {
                array_push($source_zones_arr, $source_zone_id);

                $inc_source_zone = Zone::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "zone_id" => $source_zone_id));
                $source_zones .= isset($inc_source_zone->salesOffice->sales_office_name) ? "<sup>" . $i++ . ".</sup> " . $inc_source_zone->salesOffice->sales_office_name . "<br/>" : "";
                $source_address .= isset($inc_source_zone->salesOffice->address1) ? "<sup>" . $x++ . ".</sup> " . $inc_source_zone->salesOffice->address1 . "<br/>" : "";

                $c3 = new CDbCriteria;
                $c3->select = new CDbExpression('t.*, CONCAT(t.first_name, " ",t.last_name) AS fullname');
                $c3->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.default_zone_id = '" . $source_zone_id . "'";
                $source_employee = Employee::model()->find($c3);
                $source_contact_person .= isset($source_employee) ? "<sup>" . $y++ . ".</sup> " . $source_employee->fullname . "<br/>" : "";
            }

            $row['sku_id'] = $val['sku_id'];
            $row['uom_id'] = $val['uom_id'];
            $row['planned_quantity'] = $val['planned_quantity'];
            $row['quantity_received'] = $val['quantity_received'];
            $row['unit_price'] = $val['unit_price'];
            $row['amount'] = $val['amount'];
            $row['expiration_date'] = $val['expiration_date'];
            $row['amount'] = $val['amount'];
            $row['remarks'] = $val['remarks'];
            $row['status'] = $val['status'];

            $details[] = $row;
        }

        $c = new CDbCriteria;
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.zone_id = '" . $incoming_inv['destination_zone_id'] . "'";
        $c->with = array("salesOffice");
        $zone = Zone::model()->find($c);

        $source['source_zone_name_so_name'] = rtrim($source_zones, "<br/>");
        $source['contact_person'] = $incoming_inv['contact_person'];
        $source['address'] = rtrim($source_address, "<br/>");

        $destination['sales_office_name'] = $zone->salesOffice->sales_office_name;
        $destination['address'] = $zone->salesOffice->address1;

        $headers['transaction_date'] = $incoming_inv['transaction_date'];
        $headers['plan_delivery_date'] = $incoming_inv['plan_delivery_date'];

        $headers['pr_no'] = substr(trim($pr_nos), 0, -1);
        $headers['rra_no'] = $incoming_inv['rra_no'];
        $headers['rra_date'] = $incoming_inv['rra_date'];
        $headers['dr_no'] = $incoming_inv['dr_no'];
        $headers['dr_date'] = $incoming_inv['dr_date'];
        $headers['total_amount'] = $incoming_inv['total_amount'];
        $headers['remarks'] = $incoming_inv['remarks'];

        $return['headers'] = $headers;
        $return['source'] = $source;
        $return['destination'] = $destination;
        $return['details'] = $details;

        unset(Yii::app()->session["post_pdf_data_id"]);

        sleep(1);

        Yii::app()->session["post_pdf_data_id"] = 'post-pdf-data-' . Globals::generateV4UUID();
        Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] = $return;

        $output = array();
        if (Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] == "") {
            $output["success"] = false;
            return false;
        }

        $output["success"] = true;
        $output["id"] = Yii::app()->session["post_pdf_data_id"];

        echo json_encode($output);
        Yii::app()->end();
    }

    public function actionLoadPDF($id) {

        $data = Yii::app()->session[$id];

        if ($data == "") {
            echo "Error: Please close and try again.";
            return false;
        }

        ob_start();

        $headers = $data['headers'];
        $source = $data['source'];
        $destination = $data['destination'];
        $details = $data['details'];

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
            .align-right { text-align: right; }
        </style>

        <div id="header" class="text-center">
            <span class="title-report"> RECEIVING REPORT</span>
        </div><br/><br/>

        <table class="table_main">
            <tr>
                <td style="font-weight: bold; width: 130px;">SALES OFFICE / SALESMAN</td>
                <td class="border-bottom" style="width: 370px;">' . $destination['sales_office_name'] . '</td>
                <td style="width: 10px;"></td>
                <td style="font-weight: bold; width: 110px;">DELIVERY DATE</td>
                <td class="border-bottom" style="width: 60px;">' . $headers['transaction_date'] . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">ADDRESS</td>
                <td class="border-bottom">' . $destination['address'] . '</td>
                <td></td>
                <td style="font-weight: bold;">PLAN DELIVERY DATE</td>
                <td class="border-bottom">' . $headers['plan_delivery_date'] . '</td>
            </tr>
        </table><br/><br/>

        <table class="table_main">
            <tr>
                <td style="font-weight: bold; width: 50px;">PR no.</td>
                <td class="border-bottom" style="130px;">' . $headers['pr_no'] . '</td>
                <td style="width: 10px;"></td>
                <td style="font-weight: bold; width: 100px;">WAREHOUSE NAME</td>
                <td class="border-bottom" style="width: 390px;">' . $source['source_zone_name_so_name'] . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">RA no.</td>
                <td class="border-bottom">' . $headers['rra_no'] . '</td>
                <td></td>
                <td style="font-weight: bold;">CONTACT PERSON</td>
                <td class="border-bottom">' . $source['contact_person'] . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">DR no.</td>
                <td class="border-bottom">' . $headers['dr_no'] . '</td>
                <td></td>
                <td style="font-weight: bold;">ADDRESS</td>
                <td class="border-bottom">' . $source['address'] . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">DR date</td>
                <td class="border-bottom">' . $headers['dr_date'] . '</td>
            </tr>
        </table><br/><br/><br/>

        <table class="table_details" border="1">
            <tr>
                <td style="font-weight: bold;">MM CODE</td>
                <td style="font-weight: bold; width: 100px;">MM DESCRIPTION</td>
                <td style="font-weight: bold;">MM BRAND</td>
                <td style="font-weight: bold;">MM CATEGORY</td>
                <td style="font-weight: bold; width: 65px;">ALLOCATION</td>
                <td style="font-weight: bold; width: 55px;">QUANTITY RECEIVED</td>
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
                        <td>' . $val['quantity_received'] . '</td>
                        <td>' . $uom->uom_name . '</td>
                        <td class="align-right">&#x20B1; ' . number_format($val['unit_price'], 2, '.', ',') . '</td>
                        <td class="align-right">&#x20B1; ' . number_format($val['amount'], 2, '.', ',') . '</td>
                        <td>' . $val['expiration_date'] . '</td>
                        <td>' . $val['status'] . '</td>
                    </tr>';

            $planned_qty += $val['planned_quantity'];
            $actual_qty += $val['quantity_received'];
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
                        <td style="width: 100px;"></td>
                        <td style="width: 150px; font-weight: bold;">DELIVERED BY:</td>
                        <td style="width: 100px;"></td>
                        <td style="width: 150px; font-weight: bold;">RECEIVED BY:</td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; min-height: 50px; height: 50px;"><br/><br/>' . $headers['remarks'] . '</td>
                        <td></td>
                        <td class="border-bottom"></td>
                        <td></td>
                        <td class="border-bottom"></td>
                    </tr>
                </table>';


        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('inbound.pdf', 'I');
    }

    public function actionGetDetailsByIncomingInvID($incoming_inventory_id) {

        $c = new CDbCriteria;
        $c->condition = "company_id = '" . Yii::app()->user->company_id . "' AND incoming_inventory_id = '" . $incoming_inventory_id . "'";
        $incoming_inv_details = IncomingInventoryDetail::model()->findAll($c);

        $output = array();
        foreach ($incoming_inv_details as $key => $value) {
            $row = array();

            $status = Inventory::model()->status($value->status);

            $uom = Uom::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "uom_id" => $value->uom_id));

            $row['incoming_inventory_detail_id'] = $value->incoming_inventory_detail_id;
            $row['incoming_inventory_id'] = $value->incoming_inventory_id;
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
            $row['quantity_received'] = $value->quantity_received;
            $row['amount'] = "&#x20B1;" . number_format($value->amount, 2, '.', ',');
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

    public function actionViewPrint($incoming_inventory_id) {

        $incoming_inv = $this->loadModel($incoming_inventory_id);

        $incoming_inv_detail = IncomingInventoryDetail::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "incoming_inventory_id" => $incoming_inventory_id));

        $return = array();

        $details = array();
        $source = array();
        $destination = array();
        $headers = array();

        $pr_nos = "";
        $pr_no_arr = array();
        $source_zones = "";
        $source_zones_arr = array();
        $source_address = "";
        $source_contact_person = "";
        $i = $x = $y = 1;
        foreach ($incoming_inv_detail as $key => $val) {
            $row = array();

            if ($val->pr_no != "") {
                if (!in_array($val->pr_no, $pr_no_arr)) {
                    array_push($pr_no_arr, $val->pr_no);
                    $pr_nos .= $val->pr_no . ", ";
                }
            }

            $source_zone_id = $val->source_zone_id;

            if (!in_array($source_zone_id, $source_zones_arr)) {
                array_push($source_zones_arr, $source_zone_id);

                $inc_source_zone = Zone::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "zone_id" => $source_zone_id));
                $source_zones .= isset($inc_source_zone->salesOffice->sales_office_name) ? "<sup>" . $i++ . ".</sup> " . $inc_source_zone->salesOffice->sales_office_name . "<br/>" : "";
                $source_address .= isset($inc_source_zone->salesOffice->address1) ? "<sup>" . $x++ . ".</sup> " . $inc_source_zone->salesOffice->address1 . "<br/>" : "";

                $c3 = new CDbCriteria;
                $c3->select = new CDbExpression('t.*, CONCAT(t.first_name, " ",t.last_name) AS fullname');
                $c3->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.default_zone_id = '" . $source_zone_id . "'";
                $source_employee = Employee::model()->find($c3);
                $source_contact_person .= isset($source_employee) ? "<sup>" . $y++ . ".</sup> " . $source_employee->fullname . "<br/>" : "";
            }

            $row['sku_id'] = $val->sku_id;
            $row['uom_id'] = $val->uom_id;
            $row['planned_quantity'] = $val->planned_quantity;
            $row['quantity_received'] = $val->quantity_received;
            $row['unit_price'] = $val->unit_price;
            $row['amount'] = $val->amount;
            $row['expiration_date'] = $val->expiration_date;
            $row['amount'] = $val->amount;
            $row['remarks'] = $val->remarks;
            $row['status'] = $val->status;

            $details[] = $row;
        }

        $c = new CDbCriteria;
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.zone_id = '" . $incoming_inv->destination_zone_id . "'";
        $c->with = array("salesOffice");
        $zone = Zone::model()->find($c);

        $source['source_zone_name_so_name'] = rtrim($source_zones, "<br/>");
        $source['contact_person'] = $incoming_inv->contact_person;
        $source['address'] = rtrim($source_address, "<br/>");

        $destination['sales_office_name'] = $zone->salesOffice->sales_office_name;
        $destination['address'] = $zone->salesOffice->address1;

        $headers['transaction_date'] = $incoming_inv->transaction_date;
        $headers['plan_delivery_date'] = $incoming_inv->plan_delivery_date;

        $headers['pr_no'] = substr(trim($pr_nos), 0, -1);
        $headers['rra_no'] = $incoming_inv->rra_no;
        $headers['rra_date'] = $incoming_inv->rra_date;
        $headers['dr_no'] = $incoming_inv->dr_no;
        $headers['dr_date'] = $incoming_inv->dr_date;
        $headers['total_amount'] = $incoming_inv->total_amount;
        $headers['remarks'] = $incoming_inv->remarks;

        $return['headers'] = $headers;
        $return['source'] = $source;
        $return['destination'] = $destination;
        $return['details'] = $details;

        unset(Yii::app()->session["post_pdf_data_id"]);

        Yii::app()->session["post_pdf_data_id"] = 'post-pdf-data-' . Globals::generateV4UUID();
        Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] = $return;

        $output = array();
        if (Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] == "") {
            $output["success"] = false;
            return false;
        }

        $output["success"] = true;
        $output["id"] = Yii::app()->session["post_pdf_data_id"];

        echo json_encode($output);
        Yii::app()->end();
    }

    public function generateRecipientDetails($sendTo, $header_data, $detail_data) {

        $recipient = array();
        foreach ($sendTo as $k => $v) {
            array_push($recipient, $v);
        }

        $header = array();
        $details = array();

        $header['ra_no'] = $header_data->rra_no != "" ? "RA " . strtoupper($header_data->rra_no) : "<i>(RA No not set)</i>";
        $header['dr_no'] = "DR " . strtoupper($header_data->dr_no);
        $header['plan_delivery_date'] = $header_data->plan_delivery_date != "" ? strtoupper(date('M d Y', strtotime($header_data->plan_delivery_date))) : "";
        $header['delivery_date'] = $header_data->transaction_date != "" ? strtoupper(date('M d Y', strtotime($header_data->transaction_date))) : "";
        $header['dr_date'] = $header_data->dr_date != "" ? strtoupper(date('M d Y', strtotime($header_data->dr_date))) : "";
        $header['remarks'] = $header_data->remarks;

        $user_details = User::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "user_name" => $header_data->created_by));
        $user = User::model()->userDetailsByID(isset($user_details) ? $user_details->user_id : "", Yii::app()->user->company_id);
        $header['received_by'] = isset($user) ? $user->first_name . " " . $user->last_name : "";

        $pr_no_arr = array();
        $pr_nos = "";
        foreach ($detail_data as $k1 => $v1) {
            $row = array();
            $row['mm_code'] = $v1->sku->sku_code;
            $row['mm_desc'] = $v1->sku->description;
            $row['planned_qty'] = $v1->planned_quantity;
            $row['actual_qty'] = $v1->quantity_received;
            $row['status'] = $v1->status;

            if ($v1->pr_no != "") {
                if (!in_array($v1->pr_no, $pr_no_arr)) {
                    array_push($pr_no_arr, $v1->pr_no);
                    $pr_nos .= strtoupper($v1->pr_no) . ", ";
                }
            }

            $details[] = $row;
        }

        $header['pr_nos'] = $pr_nos != "" ? "PR " . substr(trim($pr_nos), 0, -1) : "<i>(PR No not set)</i>";

        $this->sendTransactionMail($sendTo, $header, $details);
    }

    public function sendTransactionMail($sendTo, $header, $details) {

        $content = '<html>'
                . '<body>'
                . ''
                . '<p>*** This is an automatically generated email, please do not reply  ***</p><br/>'
                . '<p>Merchandsing Materials delivered last ' . $header['dr_date'] . ' with ' . $header['dr_no'] . ' in reference to ' . $header['pr_nos'] . ' and ' . $header['ra_no'] . ' has been received.</p><br/>'
                . '<table style="font-size: 12px;" class="table-condensed">'
                . '<tr><td style="padding-right: 30px;"><b>DR NO:</b></td><td style="text-align: right;">' . $header['dr_no'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>PLAN DELIVERY DATE:</b></td><td style="text-align: right;">' . $header['plan_delivery_date'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>DELIVERY DATE:</b></td><td style="text-align: right;">' . $header['delivery_date'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>RECEIVED BY:</b></td><td style="text-align: right;">' . $header['received_by'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>REMARKS:</b></td><td style="text-align: right;">' . $header['remarks'] . '</td></tr>'
                . '</table><br/>'
                . ''
                . '<table border="1" style="font-size: 12px;">'
                . '<tr><th style="padding: 5px;"><b>' . Sku::SKU_LABEL . ' CODE</b></th><th style="padding: 5px;"><b>' . Sku::SKU_LABEL . ' DESCRIPTION</b></th><th style="padding: 5px;"><b>PLANNED QTY</b></th><th style="padding: 5px;"><b>ACTUAL QTY</b></th><th style="padding: 5px;"><b>STATUS</b></th></tr>';

        foreach ($details as $k => $v) {
            $content .= "<tr><td style='padding: 5px;'>" . $v['mm_code'] . "</td><td style='padding: 5px;'>" . $v['mm_desc'] . "</td><td style='padding: 5px;'>" . $v['planned_qty'] . "</td><td style='padding: 5px;'>" . $v['actual_qty'] . "</td><td style='padding: 5px;'>" . $v['status'] . "</td></tr>";
        }

        $content .= '</table>'
                . ''
                . '</body>'
                . '</html>';

        Globals::sendMail('Inbound Receipt', $content, 'text/html', Yii::app()->params['swiftMailer']['username'], Yii::app()->params['swiftMailer']['accountName'], $sendTo);
    }

    public function actionLoadIncomingDetailByID($detail_id) {

        $c = new CDbCriteria;
        $c->condition = "incomingInventory.company_id = '" . Yii::app()->user->company_id . "' AND t.incoming_inventory_detail_id = '" . $detail_id . "'";
        $c->with = array('incomingInventory');
        $incoming_inv_details = IncomingInventoryDetail::model()->find($c);

        $output = array();
        $output['incoming_inventory_detail_id'] = $incoming_inv_details->incoming_inventory_detail_id;
        $output['incoming_inventory_id'] = $incoming_inv_details->incoming_inventory_id;
        $output['batch_no'] = $incoming_inv_details->batch_no;
        $output['sku_code'] = isset($incoming_inv_details->sku->sku_code) ? $incoming_inv_details->sku->sku_code : null;
        $output['sku_name'] = isset($incoming_inv_details->sku->sku_name) ? $incoming_inv_details->sku->sku_name : null;
        $output['sku_description'] = isset($incoming_inv_details->sku->description) ? $incoming_inv_details->sku->description : null;
        $output['sku_category'] = isset($incoming_inv_details->sku->type) ? $incoming_inv_details->sku->type : null;
        $output['brand_name'] = isset($incoming_inv_details->sku->brand->brand_name) ? $incoming_inv_details->sku->brand->brand_name : null;
        $output['source_zone_id'] = $incoming_inv_details->source_zone_id;
        $output['source_zone_name'] = isset($incoming_inv_details->zone->zone_name) ? $incoming_inv_details->zone->zone_name : null;
        $output['unit_price'] = $incoming_inv_details->unit_price;
        $output['expiration_date'] = $incoming_inv_details->expiration_date;
        $output['planned_quantity'] = $incoming_inv_details->planned_quantity;
        $output['quantity_received'] = $incoming_inv_details->quantity_received;
        $output['amount'] = "&#x20B1;" . number_format($incoming_inv_details->amount, 2, '.', ',');
        $output['return_date'] = $incoming_inv_details->return_date;
        $output['status'] = $incoming_inv_details->status;
        $output['remarks'] = $incoming_inv_details->remarks;
        $output['campaign_no'] = $incoming_inv_details->campaign_no;
        $output['po_no'] = $incoming_inv_details->po_no;
        $output['pr_no'] = $incoming_inv_details->pr_no;
        $output['pr_date'] = $incoming_inv_details->pr_date;
        $output['plan_arrival_date'] = $incoming_inv_details->plan_arrival_date;
        $output['uom_name'] = $incoming_inv_details->uom->uom_name;
        $output['destination_zone_name'] = isset($incoming_inv_details->incomingInventory->zone->zone_name) ? trim($incoming_inv_details->incomingInventory->zone->zone_name) : "";
        $output['sku_status_name'] = isset($incoming_inv_details->skuStatus->status_name) ? $incoming_inv_details->skuStatus->status_name : "";

        echo json_encode($output);
    }

}
