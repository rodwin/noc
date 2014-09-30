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
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'data', 'loadAllOutgoingTransactionDetailsByDRNo', 'loadInventoryDetails', 'incomingInvDetailData', 'uploadAttachment', 'preview', 'deleteByUrl', 'download'),
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
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;
            $row['pr_date'] = $value->pr_date;
            $row['dr_no'] = $value->dr_no;
            $row['rra_no'] = $value->rra_no;
            $row['zone_id'] = $value->zone_id;
            $row['zone_name'] = $value->zone->zone_name;
            $row['transaction_date'] = $value->transaction_date;
            $row['status'] = $status;
            $row['total_amount'] = $value->total_amount;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/inventory/incominginventory/view', array('id' => $value->incoming_inventory_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/inventory/incominginventory/update', array('id' => $value->incoming_inventory_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/inventory/incominginventory/delete', array('id' => $value->incoming_inventory_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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

        $this->pageTitle = 'View IncomingInventory ' . $model->incoming_inventory_id;

        $this->menu = array(
            array('label' => 'Create IncomingInventory', 'url' => array('create')),
            array('label' => 'Update IncomingInventory', 'url' => array('update', 'id' => $model->incoming_inventory_id)),
            array('label' => 'Delete IncomingInventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->incoming_inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage IncomingInventory', 'url' => array('admin')),
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

        $this->pageTitle = IncomingInventory::INCOMING_LABEL . ' Inventory';
        $this->layout = '//layouts/column1';

        $incoming = new IncomingInventory;
        $transaction_detail = new IncomingInventoryDetail;
        $sku = new Sku;
        $model = new Attachment;

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->condition = "status IN ('" . OutgoingInventory::OUTGOING_PENDING_STATUS . "','" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "') AND closed = 0";
        $c->order = "dr_no ASC";
        $outgoing_inv_dr_nos = CHtml::listData(OutgoingInventory::model()->findAll($c), "dr_no", "dr_no");
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['IncomingInventory'])) {
                    $incoming->attributes = $_POST['IncomingInventory'];
                    $incoming->company_id = Yii::app()->user->company_id;
                    $incoming->created_by = Yii::app()->user->name;
                    unset($incoming->created_date);

                    $validatedIncoming = CActiveForm::validate($incoming);

                    if ($validatedIncoming != '[]') {

                        $data['error'] = $validatedIncoming;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {

                        $incoming->outgoing_inventory_id = $_POST['IncomingInventory']['outgoing_inventory_id'];

                        $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                        if ($incoming->create($transaction_details)) {
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
                        $c->compare('t.inventory_id', $transaction_detail->inventory_id);
                        $c->with = array("sku");
                        $inventory = Inventory::model()->find($c);

                        if ($transaction_detail->quantity_received <= $inventory->qty) {
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
                                'planned_quantity' => $planned_qty,
                                'quantity_received' => $qty_received,
                                'amount' => $transaction_detail->amount != "" ? $transaction_detail->amount : 0,
                                'inventory_on_hand' => $transaction_detail->inventory_on_hand != "" ? $transaction_detail->inventory_on_hand : 0,
                                'reference_no' => isset($transaction_detail->pr_no) ? $transaction_detail->pr_no : null,
                                'return_date' => isset($transaction_detail->return_date) ? $transaction_detail->return_date : null,
                                'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                                'outgoing_inventory_detail_id' => "",
                                'status' => $status,
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

        $c = new CDbCriteria;
        $c->condition = "outgoingInventory.company_id = '" . Yii::app()->user->company_id . "' AND outgoingInventory.dr_no = '" . $dr_no . "'";
        $c->with = array("outgoingInventory");
        $outgoing_inv_details = OutgoingInventoryDetail::model()->findAll($c);


        $output = array();
        if (count($outgoing_inv_details) > 0) {
            foreach ($outgoing_inv_details as $key => $value) {
                $row = array();

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
                $row['inventory_on_hand'] = $value->inventory_on_hand;
                $row['return_date'] = $value->return_date;
                $row['remarks'] = $value->remarks;
                $row['sku_id'] = isset($value->sku->sku_id) ? $value->sku->sku_id : null;
                $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
                $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
                $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
                $row['status'] = $value->status;
                $row['uom_id'] = $value->uom_id;
                $row['sku_status_id'] = $value->sku_status_id;

                $output['transaction_details'][] = $row;
            }
        }

        $header = array(
            "campaign_no" => isset($value->outgoingInventory->campaign_no) ? $value->outgoingInventory->campaign_no : null,
            "pr_no" => isset($value->outgoingInventory->pr_no) ? $value->outgoingInventory->pr_no : null,
            "pr_date" => isset($value->outgoingInventory->pr_date) ? $value->outgoingInventory->pr_date : null,
            "zone_id" => isset($value->outgoingInventory->destination_zone_id) ? $value->outgoingInventory->destination_zone_id : null,
            "zone_name" => isset($value->outgoingInventory->zone->zone_name) ? $value->outgoingInventory->zone->zone_name : null,
            "plan_delivery_date" => isset($value->outgoingInventory->plan_delivery_date) ? $value->outgoingInventory->plan_delivery_date : null,
            "outgoing_inventory_id" => isset($value->outgoingInventory->outgoing_inventory_id) ? $value->outgoingInventory->outgoing_inventory_id : null,
            "rra_no" => isset($value->outgoingInventory->rra_no) ? $value->outgoingInventory->rra_no : null,
        );

        $output['headers'] = $header;

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
            $row['amount'] = $value->amount;
            $row['inventory_on_hand'] = $value->inventory_on_hand;
            $row['return_date'] = $value->return_date;
            $row['status'] = $status;
            $row['remarks'] = $value->remarks;

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
            array('label' => 'Create IncomingInventory', 'url' => array('create')),
            array('label' => 'View IncomingInventory', 'url' => array('view', 'id' => $model->incoming_inventory_id)),
            array('label' => 'Manage IncomingInventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update IncomingInventory ' . $model->incoming_inventory_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['IncomingInventory'])) {
            $model->attributes = $_POST['IncomingInventory'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->incoming_inventory_id));
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
            $this->deleteByUrl($id);
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

        if (isset($_FILES['Attachment']['name']) && $_FILES['Attachment']['name'] != "") {

            $file = CUploadedFile::getInstance($model, 'file');
//         $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'attachment' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR .Yii::app()->session['tid'];
            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'incoming' . DIRECTORY_SEPARATOR . Yii::app()->session['tid'];
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
//         $url = Yii::app()->getBaseUrl(true) . '/attachment/' . Yii::app()->user->company_id . '/' . Yii::app()->session['tid'] . '/' . $file_name;
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/incoming/' . Yii::app()->session['tid'] . '/' . $file_name;
            $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

            $model->attachment_id = Globals::generateV4UUID();

            $model->company_id = Yii::app()->user->company_id;
            $model->file_name = $file_name;
            $model->url = $url;
            $model->transaction_id = Yii::app()->session['tid'];
            $model->transaction_type = 'incoming';
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
            $row['links'] = '<a class="view" title="Download" data-toggle="tooltip" href="' . $this->createUrl('/inventory/incominginventory/download', array('id' => $value->attachment_id)) . '" data-original-title="Download"><button type="submit" class="btn btn-default btn-flat">
            <i class="icon-download icon-white"></i>
            <i class="glyphicon glyphicon-download"></i>
           
            </button></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/inventory/incominginventory/deletebyurl', array('id' => $value->attachment_id)) . '" data-original-title="Delete"><button type="button" class="btn btn-default btn-flat">
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

}
