
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
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('data', 'loadInventoryDetails', 'outgoingInvDetailData', 'afterDeleteTransactionRow', 'invData', 'uploadAttachment', 'preview', 'download', 'searchCampaignNo', 'loadPRNos', 'loadInvByPRNo',
                    'print', 'loadPDF', 'getDetailsByOutgoingInvID', 'loadItemDetails', 'viewPrint', 'checkInvIfUpdatedActualQtyValid', 'sendDR', 'loadAttachmentDownload'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin'),
                'expression' => "Yii::app()->user->checkAccess('Manage Outbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => "Yii::app()->user->checkAccess('Add Outbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => "Yii::app()->user->checkAccess('View Outbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('update'),
                'expression' => "Yii::app()->user->checkAccess('Edit Outbound', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('delete', 'deleteOutgoingDetail', 'deleteAttachment'),
                'expression' => "Yii::app()->user->checkAccess('Delete Outbound', array('company_id' => Yii::app()->user->company_id))",
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
                            </a>' .
                    '<a class="btn btn-sm btn-default sendDR ' . $disabled . '" title="Send DR No" href="' . $this->createUrl('/inventory/outgoinginventory/sendDR', array('id' => $value->outgoing_inventory_id, 'dr_no' => $value->dr_no, 'zone_id' => $value->destination_zone_id, 'date_created' => $value->created_date, 'date_pushed' => Yii::app()->dateFormatter->formatDateTime(time(), 'short'), 'process' => 'admin')) . '">
                                <i class="glyphicon glyphicon-send"></i>
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
            $row['po_no'] = $value->po_no;
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

        $visible = $model->status == OutgoingInventory::OUTGOING_PENDING_STATUS ? true : false;

        $this->menu = array(
            array('label' => "Create " . OutgoingInventory::OUTGOING_LABEL . ' Inventory', 'url' => array('create')),
            array('label' => "Update " . OutgoingInventory::OUTGOING_LABEL . ' Inventory', 'url' => '#', 'linkOptions' => array('submit' => array('update', 'id' => $model->outgoing_inventory_id)), "visible" => $visible),
            array('label' => "Delete " . OutgoingInventory::OUTGOING_LABEL . ' Inventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->outgoing_inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => "Manage " . OutgoingInventory::OUTGOING_LABEL . ' Inventory', 'url' => array('admin')),
        );

        $c = new CDbCriteria;
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.outgoing_inventory_id = '" . $model->outgoing_inventory_id . "'";
        $c->with = array("zone");
        $outgoing_inv = OutgoingInventory::model()->find($c);

        $c1 = new CDbCriteria;
        $c1->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND zones.zone_id = '" . $outgoing_inv->zone->zone_id . "'";
        $c1->with = array("zones");
        $destination_sales_office = SalesOffice::model()->find($c1);

        $destination = array();
        $destination['zone_name'] = $outgoing_inv->zone->zone_name;
        $destination['destination_sales_office_name'] = isset($destination_sales_office->sales_office_name) ? $destination_sales_office->sales_office_name : "";
        $destination['contact_person'] = $outgoing_inv->contact_person != "" ? $outgoing_inv->contact_person : "";
        $destination['contact_no'] = $outgoing_inv->contact_no != "" ? $outgoing_inv->contact_no : "";
        $destination['address'] = $outgoing_inv->address != "" ? $outgoing_inv->address : "";

        $outgoing_detail = OutgoingInventoryDetail::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_id" => $model->outgoing_inventory_id));

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
        foreach ($outgoing_detail as $key => $val) {
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

                $out_source_zone = Zone::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "zone_id" => $source_zone_id));
                if ($out_source_zone) {
                    $source_zones .= "<sup>" . $i++ . ".</sup> " . $out_source_zone->zone_name . " <i class='text-muted'>(" . $out_source_zone->salesOffice->sales_office_name . ")</i><br/>";
                    $source_address .= isset($out_source_zone->salesOffice->address1) ? "<sup>" . $x++ . ".</sup> " . $out_source_zone->salesOffice->address1 . "<br/>" : "";
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
                    $emails = isset($_POST['emails']) ? $_POST['emails'] : array();
                    $recipients = isset($_POST['recipients']) ? $_POST['recipients'] : array();
                    $validatedEmails = ReceivingInventory::model()->validateEmails($outgoing, $emails);
                    $validatedRecipients = ReceivingInventory::model()->validateRecipients($outgoing, $recipients);

                    $validatedModel_arr = (array) json_decode($validatedOutgoing);
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

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                            $recipients_address['emails'] = CJSON::encode($emails);
                            $recipients_address['recipients'] = CJSON::encode($recipients);
                            $recipient_email_address = ReceivingInventory::model()->mergeRecipientAndEmails($emails, $recipients);

                            $outgoing->recipients = CJSON::encode($recipient_email_address);

                            $saved = $outgoing->create($transaction_details);

                            if ($saved['success']) {
                                $id = $saved['header_data']->outgoing_inventory_id;
                                $data['outgoing_inv_id'] = $id;
                                $this->actionSendDR($id, $outgoing->dr_no, $outgoing->destination_zone_id, Yii::app()->dateFormatter->formatDateTime(time(), 'short'), Yii::app()->dateFormatter->formatDateTime(time(), 'short'), 'create');
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

        $outgoing->dr_no = "TS" . date("YmdHis");

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
            $row['po_no'] = $value->po_no;
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

        if ($outgoing) {
            if ($outgoing->status != OutgoingInventory::OUTGOING_PENDING_STATUS) {
                throw new CHttpException(403, "You are not authorized to perform this action.");
            }
        }

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
                    $emails = isset($_POST['emails']) ? $_POST['emails'] : array();
                    $recipients = isset($_POST['recipients']) ? $_POST['recipients'] : array();
                    $validatedEmails = ReceivingInventory::model()->validateEmails($outgoing, $emails);
                    $validatedRecipients = ReceivingInventory::model()->validateRecipients($outgoing, $recipients);

                    $validatedModel_arr = (array) json_decode($validatedOutgoing);
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

                            $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();
                            $outgoing_inv_ids_to_be_delete = isset($_POST['outgoing_inv_ids']) ? $_POST['outgoing_inv_ids'] : "";
                            $deletedTransactionRowData = isset($_POST['deletedTransactionRowData']) ? $_POST['deletedTransactionRowData'] : array();

                            $recipients_address['emails'] = CJSON::encode($emails);
                            $recipients_address['recipients'] = CJSON::encode($recipients);
                            $recipient_email_address = ReceivingInventory::model()->mergeRecipientAndEmails($emails, $recipients);

                            $outgoing->recipients = CJSON::encode($recipient_email_address);

                            $updated = $outgoing->updateTransaction($outgoing, $outgoing_inv_ids_to_be_delete, $transaction_details, $deletedTransactionRowData);

                            if ($updated['success']) {
                                $data['outgoing_inv_id'] = $updated['header_data']->outgoing_inventory_id;
                                $data['message'] = 'Successfully updated';
                                $data['success'] = true;

                                $this->generateRecipientDetails(CJSON::decode($updated['header_data']->recipients), $updated['header_data'], $updated['detail_data']);
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
            'recipients' => CJSON::decode($outgoing->recipients),
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

        $tag_category = Yii::app()->request->getPost('inventorytype', '');
        $tag_to = Yii::app()->request->getPost('tagname', '');
        $outgoing_inv_id_attachment = Yii::app()->request->getPost('saved_outgoing_inventory_id', '');

        if (isset($_FILES['Attachment']['name']) && $_FILES['Attachment']['name'] != "") {

            $file = CUploadedFile::getInstance($model, 'file');
            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . Attachment::OUTGOING_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . $outgoing_inv_id_attachment;

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/' . Attachment::OUTGOING_TRANSACTION_TYPE . "/" . $outgoing_inv_id_attachment . "/" . $file_name;
            $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

            $model->attachment_id = Globals::generateV4UUID();
            $model->company_id = Yii::app()->user->company_id;
            $model->file_name = $file_name;
            $model->url = $url;
            $model->transaction_id = $outgoing_inv_id_attachment;
            $model->transaction_type = Attachment::OUTGOING_TRANSACTION_TYPE;
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

            $row['links'] = '<a class="btn btn-sm btn-default download_attachment" title="Delete" href="' . $this->createUrl('/inventory/outgoinginventory/download', array('id' => $value->attachment_id)) . '">
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

        $data = Yii::app()->request->getParam('post_data');

        $outgoing_inv = $data['OutgoingInventory'];
        $outgoing_inv_detail = $data['transaction_details'];

        $return = array();

        $details = array();
        $source = array();
        $destination = array();
        $headers = array();

        $pr_nos = "";
        $pr_no_arr = array();
        $po_nos = "";
        $po_no_arr = array();
        $source_zones = "";
        $source_zones_arr = array();
        $source_address = "";
        $source_contact_person = "";
        $i = $x = $y = 1;
        foreach ($outgoing_inv_detail as $key => $val) {
            $row = array();

            if ($val['outgoing_inv_detail_id'] != "") {
                $value = OutgoingInventoryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_detail_id" => $val['outgoing_inv_detail_id']));
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
                if ($value->po_no != "") {
                    if (!in_array($value->po_no, $po_no_arr)) {
                        array_push($po_no_arr, $value->po_no);
                        $po_nos .= $value->po_no . ", ";
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
            $row['quantity_issued'] = $val['quantity_issued'];
            $row['unit_price'] = $val['unit_price'];
            $row['amount'] = $val['amount'];
            $row['expiration_date'] = $val['expiration_date'];
            $row['amount'] = $val['amount'];
            $row['remarks'] = $val['remarks'];
            $row['return_date'] = $val['return_date'];

            $details[] = $row;
        }

        $c = new CDbCriteria;
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.zone_id = '" . $outgoing_inv['destination_zone_id'] . "'";
        $c->with = array("salesOffice");
        $zone = Zone::model()->find($c);

        $source['source_zone_name_so_name'] = rtrim($source_zones, "<br/>");
        $source['contact_person'] = rtrim($source_contact_person, "<br/>");
        $source['address'] = rtrim($source_address, "<br/>");

        $destination['sales_office_name'] = $zone->salesOffice->sales_office_name;
        $destination['address'] = $zone->salesOffice->address1;

        $headers['transaction_date'] = $outgoing_inv['transaction_date'];
        $headers['plan_delivery_date'] = $outgoing_inv['plan_delivery_date'];

        $headers['pr_no'] = substr(trim($pr_nos), 0, -1);
        $headers['po_no'] = substr(trim($po_nos), 0, -1);
        $headers['rra_no'] = $outgoing_inv['rra_no'];
        $headers['rra_date'] = $outgoing_inv['rra_date'];
        $headers['dr_no'] = $outgoing_inv['dr_no'];
        $headers['total_amount'] = $outgoing_inv['total_amount'];
        $headers['remarks'] = $outgoing_inv['remarks'];

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

        $headers = $data['headers'];
        $source = $data['source'];
        $destination = $data['destination'];
        $details = $data['details'];

        ob_start();

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
                <span class="title-report">TRANSFER SLIP</span>
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
                    <td style="font-weight: bold;">PO no.</td>
                    <td class="border-bottom">' . $headers['po_no'] . '</td>
                    <td></td>
                    <td style="font-weight: bold;">CONTACT PERSON</td>
                    <td class="border-bottom">' . $source['contact_person'] . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">RA no.</td>
                    <td class="border-bottom">' . $headers['rra_no'] . '</td>
                    <td></td>
                    <td style="font-weight: bold;">ADDRESS</td>
                    <td class="border-bottom">' . $source['address'] . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">RA date</td>
                    <td class="border-bottom">' . $headers['rra_date'] . '</td>
                    <td rowspan="3"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">DR no.</td>
                    <td class="border-bottom">' . $headers['dr_no'] . '</td>
                    <td rowspan="3"></td>
                </tr>
            </table><br/><br/><br/>  
        
            <table class="table_details" border="1">
                <tr>
                    <td style="font-weight: bold;">MM CODE</td>
                    <td style="font-weight: bold; width: 100px;">MM DESCRIPTION</td>
                    <td style="font-weight: bold;">MM BRAND</td>
                    <td style="font-weight: bold">MM CATEGORY</td>
                    <td style="font-weight: bold; width: 65px;">ALLOCATION</td>
                    <td style="font-weight: bold; width: 55px;">QUANTITY ISSUED</td>
                    <td style="font-weight: bold; width: 40px;">UOM</td>
                    <td style="font-weight: bold;">UNIT PRICE</td>
                    <td style="font-weight: bold;">AMOUNT</td>
                    <td style="font-weight: bold;">RETURN DATE</td>
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
                            <td>' . $val['return_date'] . '</td>
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

    public function actionViewPrint($outgoing_inventory_id) {

        $outgoing_inv = $this->loadModel($outgoing_inventory_id);

        $outgoing_inv_detail = OutgoingInventoryDetail::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_id" => $outgoing_inventory_id));

        $return = array();

        $details = array();
        $source = array();
        $destination = array();
        $headers = array();

        $pr_nos = "";
        $pr_no_arr = array();
        $po_nos = "";
        $po_no_arr = array();
        $source_zones = "";
        $source_zones_arr = array();
        $source_address = "";
        $source_contact_person = "";
        $i = $x = $y = 1;
        foreach ($outgoing_inv_detail as $key => $val) {
            $row = array();

            if ($val->pr_no != "") {
                if (!in_array($val->pr_no, $pr_no_arr)) {
                    array_push($pr_no_arr, $val->pr_no);
                    $pr_nos .= $val->pr_no . ", ";
                }
            }
            if ($val->po_no != "") {
                if (!in_array($val->po_no, $po_no_arr)) {
                    array_push($po_no_arr, $val->po_no);
                    $po_nos .= $val->po_no . ", ";
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
            $row['quantity_issued'] = $val->quantity_issued;
            $row['unit_price'] = $val->unit_price;
            $row['amount'] = $val->amount;
            $row['expiration_date'] = $val->expiration_date;
            $row['amount'] = $val->amount;
            $row['remarks'] = $val->remarks;
            $row['return_date'] = $val->return_date;

            $details[] = $row;
        }

        $c = new CDbCriteria;
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.zone_id = '" . $outgoing_inv->destination_zone_id . "'";
        $c->with = array("salesOffice");
        $zone = Zone::model()->find($c);

        $source['source_zone_name_so_name'] = rtrim($source_zones, "<br/>");
        $source['contact_person'] = rtrim($source_contact_person, "<br/>");
        $source['address'] = rtrim($source_address, "<br/>");

        $destination['sales_office_name'] = $zone->salesOffice->sales_office_name;
        $destination['address'] = $zone->salesOffice->address1;

        $headers['transaction_date'] = $outgoing_inv->transaction_date;
        $headers['plan_delivery_date'] = $outgoing_inv->plan_delivery_date;

        $headers['pr_no'] = substr(trim($pr_nos), 0, -1);
        $headers['po_no'] = substr(trim($po_nos), 0, -1);
        $headers['rra_no'] = $outgoing_inv->rra_no;
        $headers['rra_date'] = $outgoing_inv->rra_date;
        $headers['dr_no'] = $outgoing_inv->dr_no;
        $headers['total_amount'] = $outgoing_inv->total_amount;
        $headers['remarks'] = $outgoing_inv->remarks;

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

    public function actionCheckInvIfUpdatedActualQtyValid($inventory_id, $actual_qty, $new_actual_qty, $outgoing_inv_detail_id) {

        $new_qty = 0;
        $new_inv_qty = 0;

        $data['success'] = false;
        $data["type"] = "success";
        $data['actual_qty'] = $actual_qty;
        $data['qty_for_new_inventory'] = "";

        $outgoing_inv_detail = OutgoingInventoryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_detail_id" => $outgoing_inv_detail_id));

        $inventory = Inventory::model()->findByAttributes(
                array(
                    'company_id' => $outgoing_inv_detail->company_id,
                    'sku_id' => $outgoing_inv_detail->sku_id,
                    'uom_id' => $outgoing_inv_detail->uom_id,
                    'zone_id' => $outgoing_inv_detail->source_zone_id,
                    'sku_status_id' => $outgoing_inv_detail->sku_status_id != "" ? $outgoing_inv_detail->sku_status_id : null,
                    'expiration_date' => $outgoing_inv_detail->expiration_date,
                    'po_no' => $outgoing_inv_detail->po_no,
                    'pr_no' => $outgoing_inv_detail->pr_no,
                    'pr_date' => $outgoing_inv_detail->pr_date,
                    'plan_arrival_date' => $outgoing_inv_detail->plan_arrival_date,
                )
        );

        $qty_issued = $outgoing_inv_detail->quantity_issued;

        if ($outgoing_inv_detail) {

            if ($new_actual_qty == $qty_issued) {

                $data['message'] = 'Successfully updated';
                $data['success'] = true;
                $data['actual_qty'] = $new_actual_qty;
            } else if ($new_actual_qty > $qty_issued) {

                $new_qty = $new_actual_qty - $qty_issued;

                if ($inventory) {

                    $added_actual = $inventory->qty + $qty_issued;
                    $last_qty = $added_actual - $actual_qty;

                    if ($inventory->qty > $new_qty || $inventory->qty == $new_qty) {

                        $data['message'] = 'Successfully updated';
                        $data['success'] = true;
                        $data['actual_qty'] = $new_actual_qty;
                    } else {

                        if ($last_qty < 0) {
                            $value = 0;
                        } else {
                            $value = $last_qty;
                        }

                        $data['message'] = 'Source inventory has only <b>' . $value . " " . strtolower(isset($outgoing_inv_detail->uom) ? $outgoing_inv_detail->uom->uom_name : "") . '</b> inventory on hand remaining';
                        $data["type"] = "danger";
                    }
                } else {

                    $data['message'] = 'Source inventory not exist already';
                    $data["type"] = "danger";
                }
            } else {

                $new_inv_qty = $qty_issued - $new_actual_qty;

                $data['message'] = 'Successfully updated';
                $data['success'] = true;
                $data['actual_qty'] = $new_actual_qty;
                $data['qty_for_new_inventory'] = $new_inv_qty;
            }
        } else {

            $data['message'] = 'Unable to process';
            $data["type"] = "danger";
        }

        echo json_encode($data);
        Yii::app()->end();
    }

    ////start of sending of dr report
    public function actionSendDR($id, $dr_no, $zone_id, $date_created, $date_pushed, $process) {
        $sql = "SELECT gcm_regid FROM noc.gcm_users a INNER JOIN noc.employee b ON a.employee_id = b.employee_id
              WHERE b.company_id = '" . Yii::app()->user->company_id . "' AND b.default_zone_id = '" . $zone_id . "'";
        $command = Yii::app()->db->createCommand($sql);
        $gcm_reg_id = $command->queryAll();
        try {
            if (isset($gcm_reg_id[0]['gcm_regid'])) {
                $data = array();
                $data['ID'] = $id;
                $data['dr_no'] = $dr_no;
                $data['date_created'] = $date_created;
                $data['date_sent'] = $date_pushed;

                $message = json_encode($data);
//           pre($message);
                GcmUsers::model()->send_notification($gcm_reg_id[0]['gcm_regid'], $message);
                if (!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('success', "DR no successfully sent");

                    if ($process == "admin") {
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                    } elseif ($process == "create") {
                        return true;
                    }
                } else {
                    echo "Successfully sent";
                    exit;
                }
            } else {
                if ($process == "admin") {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                } elseif ($process == "create") {
                    return true;
                }

//              echo "Error sending"; exit;
            }
        } catch (CDbException $e) {

            if ($e->errorInfo[1] == 1451) {
                if (!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('danger', "Unable to send DR no");
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $id));
                } else {
                    echo "1451";
                    exit;
                }
            }
        }
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
        $header['remarks'] = $header_data->remarks;
        
        $user_details = User::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "user_name" => $header_data->created_by));
        $user = User::model()->userDetailsByID(isset($user_details) ? $user_details->user_id : "", Yii::app()->user->company_id);
        $header['sent_by'] = isset($user) ? $user->first_name." ".$user->last_name : "";

        $pr_no_arr = array();
        $pr_nos = "";
        $source_zones_arr = array();
        $source_sales_office_arr = array();
        $source_sales_offices = "";
        foreach ($detail_data as $k1 => $v1) {
            $row = array();
            $row['mm_code'] = $v1->sku->sku_code;
            $row['mm_desc'] = $v1->sku->description;
            $row['planned_qty'] = $v1->planned_quantity;
            $row['actual_qty'] = $v1->quantity_issued;

            if ($v1->pr_no != "") {
                if (!in_array($v1->pr_no, $pr_no_arr)) {
                    array_push($pr_no_arr, $v1->pr_no);
                    $pr_nos .= strtoupper($v1->pr_no) . ", ";
                }
            }

            if (!in_array($v1->source_zone_id, $source_zones_arr)) {
                array_push($source_zones_arr, $v1->source_zone_id);

                $out_source_zone = Zone::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "zone_id" => $v1->source_zone_id));
                if ($out_source_zone) {
                    if (!in_array($out_source_zone->sales_office_id, $source_sales_office_arr)) {
                        array_push($source_sales_office_arr, $out_source_zone->sales_office_id);
                        
                        $sales_office = SalesOffice::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sales_office_id" => $out_source_zone->sales_office_id));
                                            
                        $source_sales_offices .= isset($sales_office->sales_office_name) ? $sales_office->sales_office_name . ", " : "";
                    }
                }
            }

            $details[] = $row;
        }
        
        $header['source_sales_office_name'] = $source_sales_offices != "" ? substr(trim($source_sales_offices), 0, -1) : "";    
        $header['pr_nos'] = $pr_nos != "" ? "PR " . substr(trim($pr_nos), 0, -1) : "<i>(PR No not set)</i>";

        $this->sendTransactionMail($sendTo, $header, $details);
    }

    public function sendTransactionMail($sendTo, $header, $details) {

        $content = '<html>'
                . '<body>'
                . ''
                . '<p>*** This is an automatically generated email, please do not reply  ***</p><br/>'
                . '<p>Email Alert:</p>'
                . '<p>An In-Transit delivery from ' . $header['source_sales_office_name'] . ' in reference to ' . $header['ra_no'] . ' from ' . $header['pr_nos'] . '</p><br/>'
                . '<table style="font-size: 12px;" class="table-condensed">'
                . '<tr><td style="padding-right: 30px;"><b>DR NO:</b></td><td style="text-align: right;">' . $header['dr_no'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>PLAN DELIVERY DATE:</b></td><td style="text-align: right;">' . $header['plan_delivery_date'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>DELIVERY DATE:</b></td><td style="text-align: right;">' . $header['delivery_date'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>SENT BY:</b></td><td style="text-align: right;">' . $header['sent_by'] . '</td></tr>'
                . '<tr><td style="padding-right: 30px;"><b>REMARKS:</b></td><td style="text-align: right;">' . $header['remarks'] . '</td></tr>'
                . '</table><br/>'
                . ''
                . '<table border="1" style="font-size: 12px;">'
                . '<tr><th style="padding: 5px;"><b>' . Sku::SKU_LABEL . ' CODE</b></th><th style="padding: 5px;"><b>' . Sku::SKU_LABEL . ' DESCRIPTION</b></th><th style="padding: 5px;"><b>PLANNED QTY</b></th><th style="padding: 5px;"><b>ACTUAL QTY</b></th></tr>';

        foreach ($details as $k => $v) {
            $content .= "<tr><td style='padding: 5px;'>" . $v['mm_code'] . "</td><td style='padding: 5px;'>" . $v['mm_desc'] . "</td><td style='padding: 5px;'>" . $v['planned_qty'] . "</td><td style='padding: 5px;'>" . $v['actual_qty'] . "</td></tr>";
        }

        $content .= '</table>'
                . ''
                . '</body>'
                . '</html>';

        Globals::sendMail('Outbound Transaction Alert', $content, 'text/html', Yii::app()->params['swiftMailer']['username'], Yii::app()->params['swiftMailer']['accountName'], $sendTo);
    }

}
