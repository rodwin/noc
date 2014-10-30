<?php

class ProofOfDeliveryController extends Controller {
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
                'actions' => array('create', 'update', 'data', 'PODDetails', 'savePODDetails', 'deletePODDetail', 'PODDAttachment', 'savePODAttachment', 'uploadPODAttachment', 'uploadAttachment', 'viewPODAttachment', 'deletePODAttachment', 'downloadPODAttachment'),
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

        ProofOfDelivery::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = ProofOfDelivery::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = ProofOfDelivery::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();

            $status = Inventory::model()->status($value->status);

            if ($value->verified == "1") {
                $verified_status = '<span class="label label-success">VERIFIED</span>';
            } else if ($value->verified == "0") {
                $verified_status = '<span class="label label-danger">UNVERIFIED</span>';
            } else {
                $verified_status = "";
            }

            $c = new CDbCriteria;
            $c->select = new CDbExpression('CONCAT(first_name, " ",last_name) AS fullname');
            $c->condition = "company_id = '" . Yii::app()->user->company_id . "' AND user_name = '" . trim($value->verified_by) . "'";
            $user = User::model()->find($c);

            $row['pod_id'] = $value->pod_id;
            $row['dr_no'] = $value->dr_no;
            $row['dr_date'] = $value->dr_date;
            $row['rra_no'] = $value->rra_no;
            $row['rra_date'] = $value->rra_date;
            $row['source_zone_id'] = $value->source_zone_id;
            $row['poi_id'] = $value->poi_id;
            $row['poi_name'] = $value->poi->short_name;
            $row['poi_address1'] = $value->poi->address1;
            $row['status'] = $status;
            $row['total_amount'] = "&#x20B1;" . number_format($value->total_amount, 2, '.', ',');
            $row['created_by'] = $value->created_by;
            $row['created_date'] = $value->created_date;
            $row['updated_by'] = $value->updated_by;
            $row['updated_date'] = $value->updated_date;
            $row['verified'] = $verified_status;
            $row['verified_by'] = isset($user->fullname) ? $user->fullname : "";
            $row['verified_date'] = $value->verified_date;

            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/ProofOfDelivery/delete', array('id' => $value->pod_id)) . '">
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

        $this->pageTitle = 'View ProofOfDelivery ' . $model->pod_id;

        $this->menu = array(
            array('label' => 'Create ProofOfDelivery', 'url' => array('create')),
            array('label' => 'Update ProofOfDelivery', 'url' => array('update', 'id' => $model->pod_id)),
            array('label' => 'Delete ProofOfDelivery', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->pod_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage ProofOfDelivery', 'url' => array('admin')),
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

        $this->pageTitle = ProofOfDelivery::PROOF_OF_DELIVERY_LABEL;

        $this->menu = array(
            array('label' => 'Manage ProofOfDelivery', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new ProofOfDelivery('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProofOfDelivery'])) {
            $model->attributes = $_POST['ProofOfDelivery'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);

            $model->pod_id = Globals::generateV4UUID();

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully created");
                $this->redirect(array('view', 'id' => $model->pod_id));
            }
        }

        $this->render('create', array(
            'model' => $model,
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
            array('label' => 'Create ProofOfDelivery', 'url' => array('create')),
            array('label' => 'View ProofOfDelivery', 'url' => array('view', 'id' => $model->pod_id)),
            array('label' => 'Manage ProofOfDelivery', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update ProofOfDelivery ' . $model->pod_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProofOfDelivery'])) {
            $model->attributes = $_POST['ProofOfDelivery'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->pod_id));
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

                // delete proof of delivery details by pod_id
                ProofOfDeliveryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND pod_id = " . $id);
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
        $dataProvider = new CActiveDataProvider('ProofOfDelivery');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionDeletePODDetail($pod_detail_id) {
        if (Yii::app()->request->isPostRequest) {
            try {

                ProofOfDeliveryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND pod_detail_id = " . $pod_detail_id);

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
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . ProofOfDelivery::PROOF_OF_DELIVERY_LABEL;

        $model = new ProofOfDelivery('search');
        $PODAttachment = new ProofOfDeliveryAttachment;

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProofOfDelivery']))
            $model->attributes = $_GET['ProofOfDelivery'];


        $pod_attachment_dp = new CActiveDataProvider('ProofOfDeliveryAttachment', array());

        $this->render('admin', array(
            'model' => $model,
            'PODAttachment' => $PODAttachment,
            'pod_attachment_dp' => $pod_attachment_dp,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = ProofOfDelivery::model()->findByAttributes(array('pod_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'proof-of-delivery-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPODDetails($pod_id) {

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("pod_id", $pod_id);
        $pod_details = ProofOfDeliveryDetail::model()->findAll($c);

        $output = array();
        foreach ($pod_details as $key => $value) {
            $row = array();

            $row['pod_detail_id'] = $value->pod_detail_id;
            $row['pod_id'] = $value->pod_id;
            $row['batch_no'] = $value->batch_no;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
            $row['unit_price'] = $value->unit_price;
            $row['expiration_date'] = $value->expiration_date;
            $row['planned_quantity'] = $value->planned_quantity;
            $row['quantity_received'] = $value->quantity_received;
            $row['amount'] = "&#x20B1;" . number_format($value->amount, 2, '.', ',');
            $row['return_date'] = $value->return_date;
            $row['remarks'] = $value->remarks;
            $row['campaign_no'] = $value->campaign_no;
            $row['pr_no'] = $value->pr_no;
            $row['status'] = $value->status;

            $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/proofOfDelivery/deletePODDetail', array('pod_detail_id' => $value->pod_detail_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionSavePODDetails() {

        $pod_details_arr = Yii::app()->request->getParam("pod_details");

        $output = array();

        if (count($pod_details_arr) > 0) {

            $pod_id = "";
            $item_status = array();
            $pod_status = "";

            $output['success'] = false;

            foreach ($pod_details_arr as $k => $v) {

                $pod_detail = ProofOfDeliveryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "pod_detail_id" => $v['pod_detail_id'], "pod_id" => $v['pod_id']));

                if ($pod_detail) {
                    $pod_id = $v['pod_id'];
                    $item_status[$v['status']][] = $v['status'];

                    $pod_detail->quantity_received = $v['quantity_received'];
                    $pod_detail->status = $v['status'];
                    $pod_detail->remarks = $v['remarks'];
                    $pod_detail->updated_by = Yii::app()->user->name;
                    $pod_detail->updated_date = date('Y-m-d H:i:s');

                    if ($pod_detail->save(false)) {

                        $customer_item_detail = CustomerItemDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "customer_item_detail_id" => $pod_detail->customer_item_detail_id));

                        $customer_item_detail->status = $pod_detail->status;
                        $customer_item_detail->remarks = $pod_detail->remarks;
                        $customer_item_detail->updated_by = Yii::app()->user->name;
                        $customer_item_detail->updated_date = date('Y-m-d H:i:s');
                        $customer_item_detail->save(false);
                    }
                }
            }

            if (array_key_exists(OutgoingInventory::OUTGOING_PENDING_STATUS, $item_status)) {
                $pod_status = OutgoingInventory::OUTGOING_PENDING_STATUS;
            } else if (array_key_exists(OutgoingInventory::OUTGOING_INCOMPLETE_STATUS, $item_status)) {
                $pod_status = OutgoingInventory::OUTGOING_INCOMPLETE_STATUS;
            } else if (array_key_exists(OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS, $item_status)) {
                $pod_status = OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS;
            } else {
                $pod_status = OutgoingInventory::OUTGOING_COMPLETE_STATUS;
            }

            $pod = ProofOfDelivery::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "pod_id" => $pod_id));

            if ($pod) {
                $pod->status = $pod_status;

                if ($pod->save()) {

                    $customer_item = CustomerItem::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "customer_item_id" => $pod->customer_item_id));
                    $customer_item->status = $pod_status;
                    $customer_item->updated_by = Yii::app()->user->name;
                    $customer_item->updated_date = date('Y-m-d H:i:s');
                    $customer_item->save(false);

                    $output['success'] = true;
                }
            }
        }

        echo json_encode($output);
    }

    public function actionPODDAttachment($pod_id) {

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("pod_id", $pod_id);
        $pod_details = ProofOfDeliveryDetail::model()->findAll($c);

        $output = array();
        foreach ($pod_details as $key => $value) {
            $row = array();

            $pod_attachment = ProofOfDeliveryAttachment::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "pod_id" => $value->pod_id, "pod_detail_id" => $value->pod_detail_id));

            $row['pod_detail_id'] = $value->pod_detail_id;
            $row['pod_id'] = $value->pod_id;
            $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
            $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
            $row['verified'] = $value->verified;
            $row['attachment'] = count($pod_attachment) > 0 ? "<b>" . count($pod_attachment) . " attachment(s)</b>" : "<b>no attachment</b>";
            $row['verification'] = $value->verified == 0 ? '' : 'checked';
            $row['verified_status'] = $value->verified == 0 ? "<span class='label label-danger'>UNVERIFIED</span>" : "<span class='label label-success'>VERIFIED</span>";
            $row['attachment_remarks'] = $value->attachment_remarks;

            $row['links'] = '<a class="btn btn-sm btn-default view_attachment" title="View" onclick="viewPODAttachment(' . $value->pod_id . ',' . $value->pod_detail_id . ', true)">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>&nbsp;
                            <a class="btn btn-sm btn-default upload_attachment" title="Upload" onclick="uploadPODAttachment(' . $value->pod_id . ',' . $value->pod_detail_id . ')">
                                <i class="glyphicon glyphicon-upload"></i>
                            </a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionSavePODAttachment() {

        $pod_attachment_arr = Yii::app()->request->getParam("pod_attachment");

        $output = array();

        if (count($pod_attachment_arr) > 0) {

            $pod_id = "";
            $verified_status = array();
            $pod_verified = "";

            $output['success'] = false;

            foreach ($pod_attachment_arr as $k => $v) {

                $pod_detail = ProofOfDeliveryDetail::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "pod_detail_id" => $v['pod_detail_id'], "pod_id" => $v['pod_id']));

                if ($pod_detail) {
                    $pod_id = $v['pod_id'];
                    $verified_status[$v['verified']][] = $v['verified'];

                    $pod_detail->updated_by = Yii::app()->user->name;
                    $pod_detail->updated_date = date('Y-m-d H:i:s');
                    $pod_detail->verified = $v['verified'];
                    $pod_detail->verified_by = Yii::app()->user->name;
                    $pod_detail->attachment_remarks = $v['attachment_remarks'];

                    $pod_detail->save(false);
                }
            }

            if (array_key_exists(0, $verified_status)) {
                $pod_verified = 0;
            } else {
                $pod_verified = 1;
            }

            $pod = ProofOfDelivery::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "pod_id" => $pod_id));

            if ($pod) {
                $pod->updated_by = Yii::app()->user->name;
                $pod->updated_date = date('Y-m-d H:i:s');
                $pod->verified = $pod_verified;
                $pod->verified_by = Yii::app()->user->name;
                $pod->verified_date = date('Y-m-d H:i:s');

                if ($pod->save()) {
                    $output['success'] = true;
                }
            }
        }

        echo json_encode($output);
    }

    public function actionUploadPODAttachment() {

        $pod_id = Yii::app()->request->getParam("pod_id");
        $pod_detail_id = Yii::app()->request->getParam("pod_detail_id");

        $model = new ProofOfDeliveryAttachment;

        unset(Yii::app()->session["selected_pod_id"]);
        unset(Yii::app()->session["selected_pod_detail_id"]);
        Yii::app()->session["selected_pod_id"] = $pod_id;
        Yii::app()->session["selected_pod_detail_id"] = $pod_detail_id;

        echo CJSON::encode(array($this->renderPartial('_uploadAttachment', array(
                'model' => $model,
                    ), true)));

        Yii::app()->end();
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
        $model = new ProofOfDeliveryAttachment;

        if (isset($_FILES['ProofOfDeliveryAttachment']['name']) && $_FILES['ProofOfDeliveryAttachment']['name'] != "") {

            $file = CUploadedFile::getInstance($model, 'file_name');
            $selected_pod_id = Yii::app()->session['selected_pod_id'];

            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . ProofOfDeliveryAttachment::POD_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . $selected_pod_id;

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
            $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/' . ProofOfDeliveryAttachment::POD_TRANSACTION_TYPE . DIRECTORY_SEPARATOR . $selected_pod_id . DIRECTORY_SEPARATOR . $file_name;

            if (@fopen($url, "r")) {

                throw new CHttpException(409, "Could not upload file. File already exist " . CHtml::errorSummary($model));
            } else {

                $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

                $model->company_id = Yii::app()->user->company_id;
                $model->pod_id = $selected_pod_id;
                $model->pod_detail_id = Yii::app()->session["selected_pod_detail_id"];
                $model->file_name = $file_name;
                $model->url = $url;
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
            }
        } else {

            throw new CHttpException(500, "Could not upload file " . CHtml::errorSummary($model));
        }


        echo json_encode($data);
    }

    public function actionViewPODAttachment() {

        $pod_id = Yii::app()->request->getParam("pod_id");
        $pod_detail_id = Yii::app()->request->getParam("pod_detail_id");

        $c = new CDbCriteria;
        $c->compare("company_id", Yii::app()->user->company_id);
        $c->compare("pod_id", $pod_id);
        $c->compare("pod_detail_id", $pod_detail_id);

        $pod_attachment_dp = new CActiveDataProvider("ProofOfDeliveryAttachment", array(
            'criteria' => $c,
            'pagination' => array('pageSize' => 1)
        ));

        if (isset($_GET['ajax'])) {
            $this->render('_attached', array('pod_attachment_dp' => $pod_attachment_dp));
        } else {
            echo CJSON::encode(array($this->renderPartial('_attached', array('pod_attachment_dp' => $pod_attachment_dp), true)));
        }
    }

    public function actionDeletePODAttachment($pod_attachment_id) {
        if (Yii::app()->request->isPostRequest) {

            $output['success'] = false;

            $pod_attachment = ProofOfDeliveryAttachment::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "pod_attachment_id" => $pod_attachment_id));

            if ($pod_attachment) {
                ProofOfDeliveryAttachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND pod_attachment_id = '" . $pod_attachment->pod_attachment_id . "'");

                $base = Yii::app()->getBaseUrl(true);
                $arr = explode("/", $base);
                $base = $arr[count($arr) - 1];
                $url = str_replace(Yii::app()->getBaseUrl(true), "", $pod_attachment->url);
                unlink('../' . $base . $url);

                echo "Successfully deleted";
                exit;
            } else {

                throw new CHttpException(404, 'The requested page does not exist.');
            }

            echo "Unable to delete";
            exit;
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDownloadPODAttachment($pod_attachment_id) {

        $pod_attachment = ProofOfDeliveryAttachment::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "pod_attachment_id" => $pod_attachment_id));

        $url = $pod_attachment->url;
        $name = $pod_attachment->file_name;

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

}
