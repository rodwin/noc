<?php

class PoiController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';
    public $category;

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
                'actions' => array('index', 'view', 'getAllSubCategoryByCategoryID', 'getAllCustomDataByCategoryID', 'getAllSubCategoryByCategoryName', 'getProvinceByRegionCode',
                    'getMunicipalByProvinceCode', 'getBarangayByMunicipalCode', 'upload', 'uploadDetails', 'search'),
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

    public function actionData() {

        Poi::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Poi::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Poi::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['poi_id'] = $value->poi_id;
            $row['short_name'] = $value->short_name;
            $row['long_name'] = $value->long_name;
            $row['primary_code'] = $value->primary_code;
            $row['secondary_code'] = $value->secondary_code;
            $row['barangay_id'] = $value->barangay_id;
            $row['barangay_name'] = isset($value->barangay_name) ? $value->barangay_name : null;
            $row['municipal_id'] = $value->municipal_id;
            $row['municipal_name'] = isset($value->municipal_name) ? $value->municipal_name : null;
            $row['province_id'] = $value->province_id;
            $row['province_name'] = isset($value->province_name) ? $value->province_name : null;
            $row['region_id'] = $value->region_id;
            $row['region_name'] = $value->region_name;
            $row['sales_region_id'] = $value->sales_region_id;
            $row['latitude'] = $value->latitude;
            $row['longitude'] = $value->longitude;
            $row['address1'] = $value->address1;
            $row['address2'] = $value->address2;
            $row['zip'] = $value->zip;
            $row['landline'] = $value->landline;
            $row['mobile'] = $value->mobile;
            $row['poi_category_id'] = $value->poi_category_id;
            $row['poi_category_name'] = isset($value->poiCategory->category_name) ? $value->poiCategory->category_name : null;
            $row['poi_sub_category_id'] = $value->poi_sub_category_id;
            $row['poi_sub_category_name'] = isset($value->poiSubCategory->sub_category_name) ? $value->poiSubCategory->sub_category_name : null;
            $row['remarks'] = $value->remarks;
            $row['status'] = $value->status;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['edited_date'] = $value->edited_date;
            $row['edited_by'] = $value->edited_by;
            $row['verified_by'] = $value->verified_by;
            $row['verified_date'] = $value->verified_date;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/poi/view', array('id' => $value->poi_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/poi/update', array('id' => $value->poi_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/poi/delete', array('id' => $value->poi_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function generateTemplate($poi_category_id) {

        Poi::model()->generateTemplate($poi_category_id);
    }

    public function actionUploadDetails($id) {

        $this->pageTitle = 'Upload ' . Poi::POI_LABEL . ' Details';

        $this->menu = array(
            array('label' => 'Upload ' . Poi::POI_LABEL, 'url' => array('upload')),
            array('label' => 'Create ' . Poi::POI_LABEL, 'url' => array('create')),
            array('label' => 'Manage ' . Poi::POI_LABEL, 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = BatchUpload::model()->findByAttributes(array('id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $uploads = BatchUploadDetail::model()->findAllByAttributes(array('batch_upload_id' => $id, 'company_id' => Yii::app()->user->company_id));

        $this->render('upload_details', array('model' => $model, 'uploads' => $uploads));
    }

    public function actionUpload() {

        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Upload ' . Poi::POI_LABEL;

        $model = new POIImportForm();
        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');

        if (isset($_POST) && count($_POST) > 0) {

            if (isset($_POST['generate_template'])) {

                if ($_POST['poi_category_id'] != "") {

                    $this->generateTemplate($_POST['poi_category_id']);
                }
            } else {

                $model->attributes = $_POST['POIImportForm'];

                if ($model->validate()) {
//                    pre($_FILES);
                    if (isset($_FILES['POIImportForm']['name']) && $_FILES['POIImportForm']['name'] != "") {

                        $dir = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'poi';

                        if (!is_dir($dir)) {
                            mkdir($dir, 0777, true);
                        }

                        $file = CUploadedFile::getInstance($model, 'doc_file');
                        $file_name = str_replace(' ', '_', strtolower($file->name));
                        $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

                        $batch_upload = new BatchUpload;
                        $batch_upload->company_id = Yii::app()->user->company_id;
                        $batch_upload->status = 'PENDING';
                        $batch_upload->file_name = $file_name;
                        $batch_upload->file = $dir . DIRECTORY_SEPARATOR . $file_name;
                        $batch_upload->total_rows = 0;
                        $batch_upload->failed_rows = 0;
                        $batch_upload->type = 'poi';
                        $batch_upload->notify = $_POST['POIImportForm']['notify'];
                        $batch_upload->module = 'inventory';
                        $batch_upload->created_by = Yii::app()->user->name;
                        if ($batch_upload->validate()) {

                            $batch_upload->save();

                            $data = array(
                                'task' => "import_poi",
                                'details' => array(
                                    'batch_id' => $batch_upload->id,
                                    'company_id' => Yii::app()->user->company_id,
                                )
                            );

                            Globals::queue(json_encode($data));
//                            Poi::model()->processBatchUpload($batch_upload->id, Yii::app()->user->company_id);

                            Yii::app()->user->setFlash('success', "Successfully uploaded data. Please wait for the checking to finish!");
                        } else {
                            Yii::app()->user->setFlash('danger', "Failed to create batch upload.");
                        }

                        $this->redirect(array('upload'));
                    }
                }
            }
        }

        $headers = Poi::model()->requiredHeaders(Yii::app()->user->company_id);

        $uploads = BatchUpload::model()->getByTypeAndCompanyID('poi', Yii::app()->user->company_id);

        $this->render('upload', array('model' => $model, 'headers' => $headers, 'uploads' => $uploads, 'poi_category' => $poi_category,));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'View ' . Poi::POI_LABEL . ' ' . $model->short_name;

        $this->menu = array(
            array('label' => 'Create ' . Poi::POI_LABEL, 'url' => array('create')),
            array('label' => 'Update ' . Poi::POI_LABEL, 'url' => array('update', 'id' => $model->poi_id)),
            array('label' => 'Delete ' . Poi::POI_LABEL, 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->poi_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage ' . Poi::POI_LABEL, 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $poi_custom_data_value = PoiCustomDataValue::model()->getPoiCustomDataValue($model->poi_id, $model->poi_category_id);

        $this->render('view', array(
            'model' => $model,
            'poi_custom_data_value' => $poi_custom_data_value,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pageTitle = 'Create ' . Poi::POI_LABEL;

        $this->menu = array(
            array('label' => 'Manage ' . Poi::POI_LABEL, 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Poi('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $poi_custom_data = new PoiCustomData;

        $region = CHtml::listData(Region::model()->findAll(array('order' => 'region_name ASC')), 'region_code', 'region_name');
        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');

        if (isset($_POST['Poi'])) {

            $model->attributes = $_POST['Poi'];
            $model->poi_id = Globals::generateV4UUID();
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;

            $province = CHtml::listData(Province::model()->findAll(array('condition' => 'region_code = "' . $model->region_id . '"', 'order' => 'province_name ASC')), 'province_code', 'province_name');
            $municipal = CHtml::listData(Municipal::model()->findAll(array('condition' => 'province_code = "' . $model->province_id . '"', 'order' => 'municipal_name ASC')), 'municipal_code', 'municipal_name');
            $barangay = CHtml::listData(Barangay::model()->findAll(array('condition' => 'municipal_code = "' . $model->municipal_id . '"', 'order' => 'barangay_name ASC')), 'barangay_code', 'barangay_name');
            $poi_sub_category = PoiSubCategory::model()->getSubCategoryOptionListByCategoryID($model->poi_category_id);
            $custom_datas = PoiCustomData::model()->getPoiCustomData($model->poi_id, $model->poi_category_id);

            foreach ($custom_datas as $key => $val) {
                $post_name = str_replace(' ', '_', strtolower($val['category_name'])) . "_" . str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                $post_data = isset($_POST[$post_name]) ? trim($_POST[$post_name]) : "";
                PoiCustomData::model()->validateAllCustomDataValue($poi_custom_data, Yii::app()->user->company_id, $val['name'], $post_data);
            }

            if ($model->validate() && count($poi_custom_data->getErrors()) == 0) {

                $model->save();

                foreach ($custom_datas as $key => $val) {
                    $custom_data_value = new PoiCustomDataValue;

                    $custom_data_value->id = Globals::generateV4UUID();
                    $custom_data_value->poi_id = $model->poi_id;
                    $custom_data_value->custom_data_id = $val['custom_data_id'];

                    $post_name = str_replace(' ', '_', strtolower($val['category_name'])) . "_" . str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                    $custom_data_value->value = $_POST[$post_name];
                    $custom_data_value->save();
                }

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully created");
                    $this->redirect(array('view', 'id' => $model->poi_id));
                }
            }
        } else {
            $province = array();
            $municipal = array();
            $barangay = array();
            $poi_sub_category = array();
            $custom_datas = array();
        }

        $this->render('create', array(
            'model' => $model,
            'region' => $region,
            'province' => $province,
            'municipal' => $municipal,
            'barangay' => $barangay,
            'poi_category' => $poi_category,
            'poi_sub_category' => $poi_sub_category,
            'custom_datas' => $custom_datas,
            'poi_custom_data' => $poi_custom_data,
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
            array('label' => 'Create ' . Poi::POI_LABEL, 'url' => array('create')),
            array('label' => 'View ' . Poi::POI_LABEL, 'url' => array('view', 'id' => $model->poi_id)),
            array('label' => 'Manage ' . Poi::POI_LABEL, 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update ' . Poi::POI_LABEL . ' ' . $model->short_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $poi_custom_data = new PoiCustomData;

        $region = CHtml::listData(Region::model()->findAll(array('order' => 'region_name ASC')), 'region_code', 'region_name');
        $province = CHtml::listData(Province::model()->findAll(array('order' => 'province_name ASC')), 'province_code', 'province_name');
        $municipal = CHtml::listData(Municipal::model()->findAll(array('order' => 'municipal_name ASC')), 'municipal_code', 'municipal_name');
        $barangay = CHtml::listData(Barangay::model()->findAll(array('order' => 'barangay_name ASC')), 'barangay_code', 'barangay_name');
        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');
        $poi_sub_category = PoiSubCategory::model()->getSubCategoryOptionListByCategoryID($model->poi_category_id);

        if (isset($_POST['Poi'])) {

            $model->attributes = $_POST['Poi'];
            $model->edited_by = Yii::app()->user->name;

//            $province = CHtml::listData(Province::model()->findAll(array('condition' => 'region_code = "' . $model->region_id . '"', 'order' => 'province_name ASC')), 'province_code', 'province_name');
//            $municipal = CHtml::listData(Municipal::model()->findAll(array('condition' => 'province_code = "' . $model->province_id . '"', 'order' => 'municipal_name ASC')), 'municipal_code', 'municipal_name');
//            $barangay = CHtml::listData(Barangay::model()->findAll(array('condition' => 'municipal_code = "' . $model->municipal_id . '"', 'order' => 'barangay_name ASC')), 'barangay_code', 'barangay_name');
            $poi_sub_category = PoiSubCategory::model()->getSubCategoryOptionListByCategoryID($model->poi_category_id);
            $custom_datas = PoiCustomData::model()->getPoiCustomData($model->poi_id, $model->poi_category_id);

            foreach ($custom_datas as $key => $val) {
                $post_name = str_replace(' ', '_', strtolower($val['category_name'])) . "_" . str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                $post_data = isset($_POST[$post_name]) ? trim($_POST[$post_name]) : "";
                PoiCustomData::model()->validateAllCustomDataValue($poi_custom_data, Yii::app()->user->company_id, $val['name'], $post_data);
            }

            if ($model->validate() && count($poi_custom_data->getErrors()) == 0) {

                PoiCustomDataValue::model()->deletePoiCustomDataValueByPoiID($model->poi_id);

                foreach ($custom_datas as $key => $val) {
                    $custom_data_value = new PoiCustomDataValue;

                    $custom_data_value->id = Globals::generateV4UUID();
                    $custom_data_value->poi_id = $model->poi_id;
                    $custom_data_value->custom_data_id = $val['custom_data_id'];

                    $post_name = str_replace(' ', '_', strtolower($val['category_name'])) . "_" . str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                    $custom_data_value->value = $_POST[$post_name];
                    $custom_data_value->save();
                }

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully updated");
                    $this->redirect(array('view', 'id' => $model->poi_id));
                }
            }
        } else {
            $custom_datas = PoiCustomData::model()->getPoiCustomData($model->poi_id, $model->poi_category_id);
        }

        $this->render('update', array(
            'model' => $model,
            'region' => $region,
            'province' => $province,
            'municipal' => $municipal,
            'barangay' => $barangay,
            'poi_category' => $poi_category,
            'poi_sub_category' => $poi_sub_category,
            'custom_datas' => $custom_datas,
            'poi_custom_data' => $poi_custom_data,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {

            // delete poi custom data value by poi_id
            PoiCustomDataValue::model()->deletePoiCustomDataValueByPoiID($id);
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
        $dataProvider = new CActiveDataProvider('Poi');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . Poi::POI_LABEL;

        $model = new Poi('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Poi']))
            $model->attributes = $_GET['Poi'];

        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'category_name', 'category_name');

        $this->render('admin', array(
            'model' => $model,
            'poi_category' => $poi_category,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Poi::model()->findByAttributes(array('poi_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'poi-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetAllSubCategoryByCategoryID() {

        echo "<option value=''>Select Sub Category</option>";
        $data = PoiSubCategory::model()->getSubCategoryOptionListByCategoryID($_POST['poi_category_id']);

        foreach ($data as $value => $sub_category_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($sub_category_name), true);
    }

    public function actionGetAllSubCategoryByCategoryName() {

        echo "<option value=''>Select Sub Category</option>";
        $data = PoiSubCategory::model()->getSubCategoryOptionListByCategoryName($_POST['poi_category_name']);

        foreach ($data as $value => $sub_category_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($sub_category_name), true);
    }

    public function actionGetAllCustomDataByCategoryID() {

        $custom_datas = PoiCustomData::model()->getPoiCustomData($_POST['poi_id'], $_POST['category_id']);
        $poi_custom_data = new PoiCustomData;

        if ($_POST['poi_id'] == "") {
            echo $this->renderPartial('_customItems', array('custom_datas' => $custom_datas, 'poi_custom_data' => $poi_custom_data,));
        } else {
            echo $this->renderPartial('_customItems_update', array('custom_datas' => $custom_datas, 'poi_custom_data' => $poi_custom_data,));
        }
    }

    public function actionGetProvinceByRegionCode() {

        echo "<option value=''>Select Province</option>";
        $data = Province::model()->findAll(array('condition' => 'region_code = "' . $_POST['region_code'] . '"', 'order' => 'province_name ASC'));

        foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['province_code']), CHtml::encode($val['province_name']), true);
        }
    }

    public function actionGetMunicipalByProvinceCode() {

        echo "<option value=''>Select Municipal</option>";
        $data = Municipal::model()->findAll(array('condition' => 'province_code = "' . $_POST['province_code'] . '"', 'order' => 'municipal_name ASC'));

        foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['municipal_code']), CHtml::encode($val['municipal_name']), true);
        }
    }

    public function actionGetBarangayByMunicipalCode() {

        echo "<option value=''>Select Barangay</option>";
        $data = Barangay::model()->findAll(array('condition' => 'municipal_code = "' . $_POST['municipal_code'] . '"', 'order' => 'barangay_name ASC'));

        foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['barangay_code']), CHtml::encode($val['barangay_name']), true);
        }
    }

    public function actionSearch($value) {

        $c = new CDbCriteria();
        if ($value != "") {
            $c->addSearchCondition('t.short_name', $value, true, 'OR');
            $c->addSearchCondition('t.primary_code', $value, true, 'OR');
        }
        $c->compare('t.company_id', Yii::app()->user->company_id);
        $poi = Poi::model()->findAll($c);
        
        $return = array();
        foreach ($poi as $key => $val) {
            $return[$key]['poi_id'] = $val->poi_id;
            $return[$key]['short_name'] = $val->short_name;
            $return[$key]['primary_code'] = $val->primary_code;
            $return[$key]['address1'] = $val->address1;
        }

        echo json_encode($return);
        Yii::app()->end();
    }

}
