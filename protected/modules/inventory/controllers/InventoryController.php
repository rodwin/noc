<?php

class InventoryController extends Controller {
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
                'actions' => array('index', 'view', 'trans', 'test', 'increase', 'history', 'decrease', 'convert', 'move', 'updateStatus', 'apply', 'loadTotalInventoryPerMonth',
                    'loadTotalInventoryPerMonthByBrandCategoryID', 'loadNotifications', 'loadAllTransactionInv'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'data'),
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

    public function actionHistory($inventory_id) {

        $model = $this->loadModel($inventory_id);

        $history = InventoryHistory::model()->getAllByInventoryID($inventory_id, Yii::app()->user->company_id);

        $this->pageTitle = 'Inventory Record History';

        $this->menu = array(
            array('label' => 'Create Inventory', 'url' => array('create')),
            array('label' => 'Manage Inventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $headers = InventoryHistory::model()->attributeLabels();

        $this->render('history', array(
            'model' => $model,
            'history' => $history,
            'headers' => $headers,
        ));
    }

    public function actionTest($inventory_id, $transaction_type, $qty) {
        $this->layout = '//layouts/column1';

        $inventoryObj = $this->loadModel($inventory_id);
        $model = new IncreaseInventoryForm();
        $this->render('_increase', array(
            'inventoryObj' => $inventoryObj,
            'model' => $model,
            'qty' => $qty,
        ));
    }

    public function actionIncrease() {

        $model = new IncreaseInventoryForm();

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_POST['IncreaseInventoryForm'];
            $model->created_by = Yii::app()->user->name;

            if (!$model->validate()) {
                $data = array();
                foreach ($model->getErrors() as $key => $val) {
                    $model->addError($key, $val[0]);
                    $data['error'][] = $val[0] . "</br>";
                }
                echo json_encode($data);
                Yii::app()->end();
            }

            $data['success'] = false;

            if ($model->increase(false)) {
                $data['message'] = 'Successfully increased';
                $data['success'] = true;
            } else {
                $data['message'] = 'An error occured!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionDecrease() {

        $model = new DecreaseInventoryForm();

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_POST['DecreaseInventoryForm'];
            $model->created_by = Yii::app()->user->name;

            if (!$model->validate()) {
                $data = array();
                foreach ($model->getErrors() as $key => $val) {
                    $model->addError($key, $val[0]);
                    $data['error'][] = $val[0] . "</br>";
                }
                echo json_encode($data);
                Yii::app()->end();
            }

            $data['success'] = false;

            if ($model->decrease(false)) {
                $data['message'] = 'Successfully decreased';
                $data['success'] = true;
            } else {
                $data['message'] = 'An error occured!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionConvert() {

        $model = new ConvertInventoryForm();

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_POST['ConvertInventoryForm'];
            $model->created_by = Yii::app()->user->name;

            if (!$model->validate()) {
                $data = array();
                foreach ($model->getErrors() as $key => $val) {
                    $model->addError($key, $val[0]);
                    $data['error'][] = $val[0] . "</br>";
                }
                echo json_encode($data);
                Yii::app()->end();
            }

            $data['success'] = false;

            if ($model->convert(false)) {
                $data['message'] = 'Successfully converted';
                $data['success'] = true;
            } else {
                $data['message'] = 'An error occured!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionMove() {

        $model = new MoveInventoryForm();

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_POST['MoveInventoryForm'];
            $model->created_by = Yii::app()->user->name;

            if (!$model->validate()) {
                $data = array();
                foreach ($model->getErrors() as $key => $val) {
                    $model->addError($key, $val[0]);
                    $data['error'][] = $val[0] . "</br>";
                }
                echo json_encode($data);
                Yii::app()->end();
            }

            $data['success'] = false;

            if ($model->move(false)) {
                $data['message'] = 'Successfully moved';
                $data['success'] = true;
            } else {
                $data['message'] = 'An error occured!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionUpdateStatus() {

        $model = new UpdateStatusInventoryForm();

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_POST['UpdateStatusInventoryForm'];
            $model->created_by = Yii::app()->user->name;

            if (!$model->validate()) {
                $data = array();
                foreach ($model->getErrors() as $key => $val) {
                    $model->addError($key, $val[0]);
                    $data['error'][] = $val[0] . "</br>";
                }
                echo json_encode($data);
                Yii::app()->end();
            }

            $data['success'] = false;

            if ($model->updateStatus(false)) {
                $data['message'] = 'Successfully updated status';
                $data['success'] = true;
            } else {
                $data['message'] = 'An error occured!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionApply() {

        $model = new ApplyInventoryForm();

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_POST['ApplyInventoryForm'];
            $model->created_by = Yii::app()->user->name;

            if (!$model->validate()) {
                $data = array();
                foreach ($model->getErrors() as $key => $val) {
                    $model->addError($key, $val[0]);
                    $data['error'][] = $val[0] . "</br>";
                }
                echo json_encode($data);
                Yii::app()->end();
            }

            $data['success'] = false;

            if ($model->apply(false)) {
                $data['message'] = 'Successfully apply';
                $data['success'] = true;
            } else {
                $data['message'] = 'An error occured!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionTrans() {

        $inventory_id = Yii::app()->request->getParam('inventory_id');
        $transaction_type = Yii::app()->request->getParam('transaction_type');
        $qty = Yii::app()->request->getParam('qty');

        $inventoryObj = $this->loadModel($inventory_id);

        $title = "";
        $body = "";
        switch ($transaction_type) {
            case 1:
                $model = new IncreaseInventoryForm();
                echo CJSON::encode(array($this->renderPartial('_increase', array(
                        'inventoryObj' => $inventoryObj,
                        'model' => $model,
                        'qty' => $qty,
                            ), true)));

                Yii::app()->end();

                break;
            case 2:
                $model = new DecreaseInventoryForm();
                echo CJSON::encode(array($this->renderPartial('_decrease', array(
                        'inventoryObj' => $inventoryObj,
                        'model' => $model,
                        'qty' => $qty,
                            ), true)));

                Yii::app()->end();

                break;
            case 3:
                $model = new ConvertInventoryForm();
                $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
                echo CJSON::encode(array($this->renderPartial('_convert', array(
                        'inventoryObj' => $inventoryObj,
                        'model' => $model,
                        'qty' => $qty,
                        'uom' => $uom,
                            ), true)));

                Yii::app()->end();

                break;
            case 4:
                $model = new MoveInventoryForm();
                $status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');
                echo CJSON::encode(array($this->renderPartial('_move', array(
                        'inventoryObj' => $inventoryObj,
                        'model' => $model,
                        'qty' => $qty,
                        'status' => $status,
                            ), true)));

                Yii::app()->end();

                break;
            case 5:
                $model = new UpdateStatusInventoryForm();
                $status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');
                echo CJSON::encode(array($this->renderPartial('_update_status', array(
                        'inventoryObj' => $inventoryObj,
                        'model' => $model,
                        'qty' => $qty,
                        'status' => $status,
                            ), true)));

                Yii::app()->end();

                break;
            case 6:
                $model = new ApplyInventoryForm();
                echo CJSON::encode(array($this->renderPartial('_apply', array(
                        'inventoryObj' => $inventoryObj,
                        'model' => $model,
                        'qty' => $qty,
                            ), true)));

                Yii::app()->end();

                break;

            default:
                break;
        }

        Yii::app()->end();
    }

    public function actionData() {

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
            $row['qty'] = $value->qty == 0 ?
                    '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/inventory/delete', array('id' => $value->inventory_id)) . '">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a><br/>
                    <p class="text-center">' . $value->qty . '</p>' : $value->qty;
            $row['uom_id'] = $value->uom_id;
            $row['uom_name'] = isset($value->uom->uom_name) ? $value->uom->uom_name : null;
            $row['action_qty'] = '<input type="text" data-id="' . $value->inventory_id . '" name="action_qty" id="action_qty_' . $value->inventory_id . '" onclick="openTransactionOptions(this)" onkeypress="return onlyNumbers(this, event, false)"/>';
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

        $this->pageTitle = 'View Inventory ' . $model->inventory_id;

        $this->menu = array(
            array('label' => 'Create Inventory', 'url' => array('create')),
            array('label' => 'Update Inventory', 'url' => array('update', 'id' => $model->inventory_id)),
            array('label' => 'Delete Inventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Inventory', 'url' => array('admin')),
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

        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Inventory';

        $this->menu = array(
            array('label' => 'Manage Inventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new CreateInventoryForm();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $selectedSkuname = "";
        $selectedSkuBrand = "";
        if (isset($_POST['CreateInventoryForm'])) {

            $model->attributes = $_POST['CreateInventoryForm'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            if ($model->create()) {

                Yii::app()->user->setFlash('success', "Successfully created");

                if (isset($_POST['create'])) {
                    $this->redirect(array('/inventory/Inventory/create'));
                } else if (isset($_POST['save'])) {
                    $this->redirect(array('/inventory/inventory/admin'));
                }
            }

            if (isset($_POST['CreateInventoryForm']['sku_code'])) {
                $selectedSku = Sku::model()->findByAttributes(array('sku_code' => $model->sku_code, 'company_id' => Yii::app()->user->company_id));
                if ($selectedSku) {
                    $selectedSkuname = $selectedSku->sku_name;
                    $selectedSkuBrand = isset($selectedSku->brand->brand_name) ? $selectedSku->brand->brand_name : '';
                }
            }
        }

        $sku = CHtml::listData(Sku::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sku_name ASC')), 'sku_id', 'sku_name', 'brand.brand_name');
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $zone = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        //top 20 new created item
        $recentlyCreatedItems = Inventory::model()->recentlyCreatedItems(Yii::app()->user->company_id);
//        foreach ($recentlyCreatedItems as $key => $value) {
//            pr($value);
//        }

        $this->render('create', array(
            'model' => $model,
            'sku' => $sku,
            'uom' => $uom,
            'zone' => $zone,
            'sku_status' => $sku_status,
            'selectedSkuname' => $selectedSkuname,
            'selectedSkuBrand' => $selectedSkuBrand,
            'recentlyCreatedItems' => $recentlyCreatedItems,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create Inventory', 'url' => array('create')),
            array('label' => 'View Inventory', 'url' => array('view', 'id' => $model->inventory_id)),
            array('label' => 'Manage Inventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Inventory ' . $model->inventory_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Inventory'])) {
            $model->attributes = $_POST['Inventory'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->inventory_id));
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

                // delete inventory history by inventory_id
                InventoryHistory::model()->deleteHistoryByInvID($id);
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

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Inventory');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Inventory';

        $model = new Inventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Inventory']))
            $model->attributes = $_GET['Inventory'];

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
        $model = Inventory::model()->findByPk($id);
        if ($model === null || $model->company_id != Yii::app()->user->company_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoadTotalInventoryPerMonth() {

        $months = array();
        for ($i = 0; $i < 6; $i++) {
            $row = array();

            $year = date('Y', strtotime(date('Y-m') . " -" . $i . " month"));
            $month = date('m', strtotime(date('Y-m') . " -" . $i . " month"));

            $inventory = Inventory::model()->getTotalInventoryOnHandByMonth($year, $month);

            $row["month"] = $year . "-" . $month;
            $row["inventory_on_hand"] = isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0;
            $row["inventory"] = 0;

            $months[] = $row;
        }

        echo json_encode($months);
        Yii::app()->end();
    }

    public function actionLoadTotalInventoryPerMonthByBrandCategoryID() {

        $brand_category_id = Yii::app()->request->getParam("brand_category_id");
        $brand_id = Yii::app()->request->getParam("brand_id");

        $months = array();
        for ($i = 0; $i < 6; $i++) {
            $row = array();

            $year = date('Y', strtotime(date('Y-m') . " -" . $i . " month"));
            $month = date('m', strtotime(date('Y-m') . " -" . $i . " month"));

            $inventory = Inventory::model()->getTotalInventoryOnHandByMonthAndByBrand($year, $month, $brand_category_id, $brand_id);

            $row["month"] = $year . "-" . $month;
            $row["inventory_on_hand"] = isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0;
            $row["inventory"] = 0;

            $months[] = $row;
        }

        echo json_encode($months);
        Yii::app()->end();
    }

    public function actionLoadNotifications() {

        $c = new CDbCriteria;
        $c->condition = "t.closed = 0";
        $outbound = OutgoingInventory::model()->findAll($c);

        $outbound_arr = array();
        foreach ($outbound as $key => $val) {
            $row = array();

            $status = Inventory::model()->status($val->status);

            $row['transaction_type'] = '<a href="#" title="Click to view" data-toggle="tooltip"><b>' . strtoupper(OutgoingInventory::OUTGOING_LABEL) . '</b></a>';
            $row['dr_no'] = $val->dr_no;
            $row['dr_date'] = date("d-M", strtotime($val->dr_date));
            $row['status'] = $status;

            $outbound_arr['data'][] = $row;
        }

        $output = array_merge($outbound_arr);

        echo json_encode($output);
        Yii::app()->end();
    }

    public function actionLoadAllTransactionInv() {

        $c1 = new CDbCriteria;
        $c1->select = "t.*, SUM(receiving_inventory_detail.quantity_received) as total_quantity";
        $c1->join = "INNER JOIN receiving_inventory_detail ON receiving_inventory_detail.receiving_inventory_id = t.receiving_inventory_id";
        $c1->order = "t.created_date DESC";
        $c1->limit = 3;
        $c1->group = "t.receiving_inventory_id";
        $receiving = ReceivingInventory::model()->findAll($c1);

        $receiving_arr = array();
        foreach ($receiving as $k1 => $v1) {
            $row = array();

            $status = ReceivingInventory::model()->getDeliveryRemarksLabel($v1->delivery_remarks);

            $row['transaction_date'] = date("d-M", strtotime($v1->transaction_date));
            $row['transaction_type'] = strtoupper(ReceivingInventory::RECEIVING_LABEL);
            $row['pr_no'] = $v1->pr_no;
            $row['dr_no'] = $v1->dr_no;
            $row['source'] = "";
            $row['plan_delivery_date'] = isset($v1->plan_delivery_date) ? date("d-M", strtotime($v1->plan_delivery_date)) : "";
            $row['qty'] = number_format($v1->total_quantity);
            $row['amount'] = "&#x20B1;" . number_format($v1->total_amount, 2, '.', ',');
            $row['status'] = $status;
            $row['created_date'] = $v1->created_date;

            $receiving_arr[] = $row;
        }

        $c2 = new CDbCriteria;
        $c2->select = "t.*, SUM(incoming_inventory_detail.quantity_received) as total_quantity";
        $c2->join = "INNER JOIN incoming_inventory_detail ON incoming_inventory_detail.incoming_inventory_id = t.incoming_inventory_id";
        $c2->order = "t.created_date DESC";
        $c2->limit = 3;
        $c2->group = "t.incoming_inventory_id";
        $incoming = IncomingInventory::model()->findAll($c2);

        $incoming_arr = array();
        $incoming_pr_nos = "";
        $incoming_pr_nos_arr = array();
        foreach ($incoming as $k1 => $v2) {
            $row = array();

            $status = Inventory::model()->status($v2->status);

            $incoming_details = IncomingInventoryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "incoming_inventory_id" => $v2->incoming_inventory_id));

            if (!in_array($incoming_details->pr_no, $incoming_pr_nos_arr)) {
                array_push($incoming_pr_nos_arr, $incoming_details->pr_no);
                $incoming_pr_nos .= $incoming_details->pr_no . ", ";
            }

            $row['transaction_date'] = date("d-M", strtotime($v2->transaction_date));
            $row['transaction_type'] = strtoupper(IncomingInventory::INCOMING_LABEL);
            $row['pr_no'] = substr(trim($incoming_pr_nos), 0, -1);
            $row['dr_no'] = $v2->dr_no;
            $row['source'] = "";
            $row['plan_delivery_date'] = isset($v2->plan_delivery_date) ? date("d-M", strtotime($v2->plan_delivery_date)) : "";
            $row['qty'] = number_format($v2->total_quantity);
            $row['amount'] = "&#x20B1;" . number_format($v2->total_amount, 2, '.', ',');
            $row['status'] = $status;
            $row['created_date'] = $v2->created_date;

            $incoming_arr[] = $row;
        }

        $incoming_inbound = array_merge($receiving_arr, $incoming_arr);

        $sort1['sort'] = array();
        foreach ($incoming_inbound as $key1 => $val1) {
            $sort1['sort'][$key1] = $val1['created_date'];
        }

        array_multisort($sort1['sort'], SORT_DESC, $incoming_inbound);
        $new_incoming_inbound_arr = array_slice($incoming_inbound, 0, 3);

        $c3 = new CDbCriteria;
        $c3->select = "t.*, SUM(outgoing_inventory_detail.quantity_issued) as total_quantity";
        $c3->join = "INNER JOIN outgoing_inventory_detail ON outgoing_inventory_detail.outgoing_inventory_id = t.outgoing_inventory_id";
        $c3->order = "t.created_date DESC";
        $c3->limit = 3;
        $c3->group = "t.outgoing_inventory_id";
        $outbound = OutgoingInventory::model()->findAll($c3);

        $outbound_arr = array();
        $outbound_pr_nos = "";
        $outbound_pr_nos_arr = array();
        foreach ($outbound as $k3 => $v3) {
            $row = array();

            $status = Inventory::model()->status($v3->status);

            $outbound_details = OutgoingInventoryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "outgoing_inventory_id" => $v3->outgoing_inventory_id));

            if (!in_array($outbound_details->pr_no, $outbound_pr_nos_arr)) {
                array_push($outbound_pr_nos_arr, $outbound_details->pr_no);
                $outbound_pr_nos .= $outbound_details->pr_no . ", ";
            }

            $row['transaction_date'] = date("d-M", strtotime($v3->transaction_date));
            $row['transaction_type'] = strtoupper(OutgoingInventory::OUTGOING_LABEL);
            $row['pr_no'] = substr(trim($outbound_pr_nos), 0, -1);
            $row['dr_no'] = $v3->dr_no;
            $row['source'] = "";
            $row['plan_delivery_date'] = isset($v3->plan_delivery_date) ? date("d-M", strtotime($v3->plan_delivery_date)) : "";
            $row['qty'] = number_format($v3->total_quantity);
            $row['amount'] = "&#x20B1;" . number_format($v3->total_amount, 2, '.', ',');
            $row['status'] = $status;
            $row['created_date'] = $v3->created_date;

            $outbound_arr[] = $row;
        }

        $c4 = new CDbCriteria;
        $c4->select = "t.*, SUM(customer_item_detail.quantity_issued) as total_quantity";
        $c4->join = "INNER JOIN customer_item_detail ON customer_item_detail.customer_item_id = t.customer_item_id";
        $c4->order = "t.created_date DESC";
        $c4->limit = 3;
        $c4->group = "t.customer_item_id";
        $outgoing = CustomerItem::model()->findAll($c4);

        $outgoing_arr = array();
        $outgoing_pr_nos = "";
        $outgoing_pr_nos_arr = array();
        foreach ($outgoing as $k4 => $v4) {
            $row = array();

            $status = Inventory::model()->status($v4->status);

            $outgoing_details = CustomerItemDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "customer_item_id" => $v4->customer_item_id));

            if (!in_array($outgoing_details->pr_no, $outgoing_pr_nos_arr)) {
                array_push($outgoing_pr_nos_arr, $outgoing_details->pr_no);
                $outgoing_pr_nos .= $outgoing_details->pr_no . ", ";
            }

            $row['transaction_date'] = date("d-M", strtotime($v4->transaction_date));
            $row['transaction_type'] = strtoupper(CustomerItem::CUSTOMER_ITEM_LABEL);
            $row['pr_no'] = substr(trim($outgoing_pr_nos), 0, -1);
            $row['dr_no'] = $v4->dr_no;
            $row['source'] = "";
            $row['plan_delivery_date'] = isset($v4->plan_delivery_date) ? date("d-M", strtotime($v4->plan_delivery_date)) : "";
            $row['qty'] = number_format($v4->total_quantity);
            $row['amount'] = "&#x20B1;" . number_format($v4->total_amount, 2, '.', ',');
            $row['status'] = $status;
            $row['created_date'] = $v4->created_date;

            $outgoing_arr[] = $row;
        }

        $outbound_outgoing = array_merge($outbound_arr, $outgoing_arr);

        $sort2['sort'] = array();
        foreach ($outbound_outgoing as $key2 => $val2) {
            $sort2['sort'][$key2] = $val2['created_date'];
        }

        array_multisort($sort2['sort'], SORT_DESC, $outbound_outgoing);
        $new_outbound_outgoing_arr = array_slice($outbound_outgoing, 0, 3);

        $output = array(
            'incoming_inbound' => $new_incoming_inbound_arr,
            'outbound_outgoing' => $new_outbound_outgoing_arr
        );

        echo json_encode($output);
        Yii::app()->end();
    }

}
