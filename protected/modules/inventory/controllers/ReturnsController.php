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
                'actions' => array('create', 'update', 'data', 'loadReferenceDRNos', 'infraLoadDetailsByDRNo', 'queryInfraDetails', 'getDetailsByReturnInvID'),
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

        Returns::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Returns::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Returns::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();

            $source_name = Returns::model()->getReturnFromIDDetail($value->receive_return_from, $value->receive_return_from_id, Yii::app()->user->company_id);
            $destination_name = Returns::model()->getReturnToIDDetail($value->return_to, $value->return_to_id, Yii::app()->user->company_id);

            $row['returns_id'] = $value->returns_id;
            $row['return_type'] = $value->return_type;
            $row['return_receipt_no'] = $value->return_receipt_no;
            $row['reference_dr_no'] = $value->reference_dr_no;
            $row['receive_return_from'] = $value->receive_return_from;
            $row['receive_return_from_id'] = $value->receive_return_from_id;
            $row['transaction_date'] = $value->transaction_date;
            $row['date_returned'] = $value->date_returned;
            $row['return_to'] = $value->return_to;
            $row['return_to_id'] = $value->return_to_id;
            $row['remarks'] = $value->remarks;
            $row['total_amount'] = $value->total_amount;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;
            $row['receive_return_from_name'] = $source_name;
            $row['return_to_name'] = $destination_name;

            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/inventory/returns/view', array('id' => $value->returns_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/inventory/returns/update', array('id' => $value->returns_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/inventory/returns/delete', array('id' => $value->returns_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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

        $this->pageTitle = 'View Returns ' . $model->returns_id;

        $this->menu = array(
            array('label' => 'Create Returns', 'url' => array('create')),
            array('label' => 'Update Returns', 'url' => array('update', 'id' => $model->returns_id)),
            array('label' => 'Delete Returns', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->returns_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Returns', 'url' => array('admin')),
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
        $this->pageTitle = 'Returns';

        $model = new Returns;

        $return_from_list = CHtml::listData(Returns::model()->getListReturnFrom(), 'value', 'title');
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

                if (isset($_POST['Returns'])) {

                    $model->attributes = $_POST['Returns'];
                    $model->company_id = Yii::app()->user->company_id;
                    $model->created_by = Yii::app()->user->name;
                    $model->date_returned = $model->transaction_date;
                    unset($model->created_date);
                    $model->return_type = $_POST['return_type'];
                    $model->return_to = $_POST['return_to'];

                    $validatedModel = CActiveForm::validate($model);

                    $data = $this->saveReturnables($model, $_POST, $validatedModel, $data);
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }

        $this->render('create', array(
            'model' => $model,
            'return_from_list' => $return_from_list,
            'zone_list' => $zone_list,
            'poi_list' => $poi_list,
            'salesoffice_list' => $salesoffice_list,
            'employee' => $employee,
        ));
    }

    function saveReturnables($model, $post, $validatedModel, $data) {

        if ($post['Returns']['receive_return_from'] != "") {
            $selected_source = $post['Returns']['receive_return_from'];

            $source_id = Returns::model()->validateReturnFrom($model, $post['Returns']['receive_return_from']);
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
                    $data['returns_id'] = Yii::app()->session['returns_id_create_session'];
                    unset(Yii::app()->session['returns_id_create_session']);
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
        $returns_details = ReturnsDetail::model()->findAll($c);

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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create Returns', 'url' => array('create')),
            array('label' => 'View Returns', 'url' => array('view', 'id' => $model->returns_id)),
            array('label' => 'Manage Returns', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Returns ' . $model->returns_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Returns'])) {
            $model->attributes = $_POST['Returns'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->returns_id));
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
        $dataProvider = new CActiveDataProvider('Returns');

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

        $model = new Returns('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Returns']))
            $model->attributes = $_GET['Returns'];

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
        $model = Returns::model()->findByAttributes(array('returns_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
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

        $source_arr = Returns::model()->getListReturnFrom();
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

        $source_arr = Returns::model()->getListReturnFrom();

        $return = array();
        if (count($data) > 0) {
            $row['id'] = "";
            $row['text'] = "--";
            $return[] = $row;

            if ($data['header'] == $source_arr[0]['value'] || $data['header'] == $source_arr[1]['value']) {
                foreach ($data['details'] as $key => $val) {
                    $row = array();

                    $row['id'] = $val->outgoingInventory->dr_no;
                    $row['text'] = $val->outgoingInventory->dr_no;

                    $return[] = $row;
                }
            } else if ($data['header'] == $source_arr[2]['value']) {
                foreach ($data['details'] as $key => $val) {
                    $row = array();

                    $row['id'] = $val->customerItem->dr_no;
                    $row['text'] = $val->customerItem->dr_no;

                    $return[] = $row;
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

        $source_arr = Returns::model()->getListReturnFrom();

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

}
