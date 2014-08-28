<?php

class SkuController extends Controller {
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
                'actions' => array('index', 'view', 'saveSkuConvertion', 'GenerateTemplate', 'Upload', 'UploadDetails', 'search', 'skuImage', 'ajaxLoadImages', 'ajaxFilterImages', 'deleteSkuImage'),
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

    public function actionSearch($value) {

        $c = new CDbCriteria();
        if ($value != "") {
            $c->addSearchCondition('t.sku_code', $value, true, 'OR');
            $c->addSearchCondition('t.sku_name', $value, true, 'OR');
            $c->addSearchCondition('brand.brand_name', $value, true, 'OR');
        }
        $c->compare('t.company_id', Yii::app()->user->company_id);
        $c->with = array('brand', 'defaultZone', 'defaultUom');
        $sku = Sku::model()->findAll($c);

        $return = array();
        foreach ($sku as $key => $val) {
            $return[$key]['sku_id'] = $val->sku_id;
            $return[$key]['sku_code'] = $val->sku_code;
            $return[$key]['value'] = $val->sku_name;
            $return[$key]['brand'] = isset($val->brand->brand_name) ? $val->brand->brand_name : '';
            $return[$key]['uom_id'] = isset($val->defaultUom->uom_id) ? $val->defaultUom->uom_id : '';
            $return[$key]['zone_id'] = isset($val->defaultZone->zone_id) ? $val->defaultZone->zone_id : '';
            $return[$key]['cost_per_unit'] = $val->default_unit_price;
        }

        echo json_encode($return);
        Yii::app()->end();
    }

    public function actionData() {

        Sku::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Sku::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Sku::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['sku_id'] = $value->sku_id;
            $row['sku_code'] = $value->sku_code;
            $row['brand_id'] = $value->brand_id;
            $row['brand_name'] = isset($value->brand->brand_name) ? $value->brand->brand_name : null;
            $row['brand_category'] = "";
            $row['sku_name'] = $value->sku_name;
            $row['description'] = $value->description;
            $row['default_uom_id'] = $value->default_uom_id;
            $row['default_uom_name'] = isset($value->defaultUom->uom_name) ? $value->defaultUom->uom_name : null;
            $row['default_unit_price'] = $value->default_unit_price;
            $row['type'] = $value->type;
            $row['sub_type'] = $value->sub_type;
            $row['default_zone_id'] = $value->default_zone_id;
            $row['default_zone_name'] = isset($value->defaultZone->zone_name) ? $value->defaultZone->zone_name : null;
            $row['supplier'] = $value->supplier;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;
            $row['low_qty_threshold'] = $value->low_qty_threshold;
            $row['high_qty_threshold'] = $value->high_qty_threshold;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/sku/view', array('id' => $value->sku_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/sku/update', array('id' => $value->sku_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/sku/delete', array('id' => $value->sku_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionGenerateTemplate() {

        Sku::model()->generateTemplate();
    }

    public function actionUploadDetails($id) {

        $this->pageTitle = 'Upload ' . Sku::SKU_LABEL . ' Details';

        $this->menu = array(
            array('label' => 'Upload ' . Sku::SKU_LABEL, 'url' => array('upload')),
            array('label' => 'Create ' . Sku::SKU_LABEL, 'url' => array('create')),
            array('label' => 'Manage ' . Sku::SKU_LABEL, 'url' => array('admin')),
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
        $this->pageTitle = 'Upload ' . Sku::SKU_LABEL;

        $model = new SKUImportForm();

        if (isset($_POST) && count($_POST) > 0) {
            $model->attributes = $_POST['SKUImportForm'];
            if ($model->validate()) {

                if (isset($_FILES['SKUImportForm']['name']) && $_FILES['SKUImportForm']['name'] != "") {

                    $file = CUploadedFile::getInstance($model, 'doc_file');

                    $dir = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'sku';

                    if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }

                    $file_name = str_replace(' ', '_', strtolower($file->name));
                    $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

                    $batch_upload = new BatchUpload;
                    $batch_upload->company_id = Yii::app()->user->company_id;
                    $batch_upload->status = 'PENDING';
                    $batch_upload->file_name = $file_name;
                    $batch_upload->file = $dir . DIRECTORY_SEPARATOR . $file_name;
                    $batch_upload->total_rows = 0;
                    $batch_upload->failed_rows = 0;
                    $batch_upload->type = 'sku';
                    $batch_upload->notify = $_POST['SKUImportForm']['notify'];
                    $batch_upload->module = 'inventory';
                    $batch_upload->created_by = Yii::app()->user->name;
                    if ($batch_upload->validate()) {

                        $batch_upload->save();

                        $data = array(
                            'task' => "import_sku",
                            'details' => array(
                                'batch_id' => $batch_upload->id,
                                'company_id' => Yii::app()->user->company_id,
                            )
                        );

                        Globals::queue(json_encode($data));
//                        Sku::model()->processBatchUpload($batch_upload->id, Yii::app()->user->company_id);

                        Yii::app()->user->setFlash('success', "Successfully uploaded data. Please wait for the checking to finish!");
                    } else {
                        Yii::app()->user->setFlash('danger', "Failed to create batch upload.");
                    }

                    $this->redirect(array('upload'));
                }
            }
        }

        $headers = Sku::model()->requiredHeaders(Yii::app()->user->company_id);

        $uploads = BatchUpload::model()->getByTypeAndCompanyID('sku', Yii::app()->user->company_id);

        $this->render('upload', array('model' => $model, 'headers' => $headers, 'uploads' => $uploads));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'View ' . Sku::SKU_LABEL . ' ' . $model->sku_name;

        $this->menu = array(
            array('label' => 'Create ' . Sku::SKU_LABEL, 'url' => array('create')),
            array('label' => 'Update ' . Sku::SKU_LABEL, 'url' => array('update', 'id' => $model->sku_id)),
            array('label' => 'Delete ' . Sku::SKU_LABEL, 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->sku_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage ' . Sku::SKU_LABEL, 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $sku_custom_data_value = SkuCustomDataValue::model()->getSkuCustomDataValue($model->sku_id);

        $this->render('view', array(
            'model' => $model,
            'sku_custom_data_value' => $sku_custom_data_value,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pageTitle = 'Create ' . Sku::SKU_LABEL;

        $this->menu = array(
            array('label' => 'Manage ' . Sku::SKU_LABEL, 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Sku('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $custom_datas = SkuCustomData::model()->getAllSkuCustomData($model->sku_id);
        $sku_custom_data = new SkuCustomData;

        $brand = CHtml::listData(Brand::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'brand_name ASC')), 'brand_id', 'brand_name');
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $zone = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');
        $sku_category = Sku::model()->skuAllTypeList();
        $infra_sub_category = Sku::model()->skuAllSubTypeList();

        if (isset($_POST['Sku'])) {

            $model->attributes = $_POST['Sku'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);
            $model->sku_id = Globals::generateV4UUID();
            $model->default_unit_price = !empty($_POST['Sku']['default_unit_price']) ? $_POST['Sku']['default_unit_price'] : 0;
            $model->sub_type = isset($model->type) && $model->type != Sku::INFRA ? "" : $model->sub_type;

            foreach ($custom_datas as $key => $val) {
                $attr_name = str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                $post_data = isset($_POST[$attr_name]) ? trim($_POST[$attr_name]) : "";
                SkuCustomData::model()->validateAllCustomDataValue($sku_custom_data, Yii::app()->user->company_id, $val['name'], $post_data);
            }

            if ($model->validate() && count($sku_custom_data->getErrors()) == 0) {

                $model->save();

                foreach ($custom_datas as $key => $val) {
                    $sku_custom_data_value = new SkuCustomDataValue;

                    $sku_custom_data_value->id = Globals::generateV4UUID();
                    $sku_custom_data_value->sku_id = $model->sku_id;
                    $sku_custom_data_value->custom_data_id = $val['custom_data_id'];

                    $post_name = str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                    $sku_custom_data_value->value = $_POST[$post_name];
                    $sku_custom_data_value->save();
                }

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully created");
                    $this->redirect(array('view', 'id' => $model->sku_id));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'brand' => $brand,
            'uom' => $uom,
            'zone' => $zone,
            'custom_datas' => $custom_datas,
            'sku_custom_data' => $sku_custom_data,
            'sku_category' => $sku_category,
            'infra_sub_category' => $infra_sub_category,
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
            array('label' => 'Create ' . Sku::SKU_LABEL, 'url' => array('create')),
            array('label' => 'View ' . Sku::SKU_LABEL, 'url' => array('view', 'id' => $model->sku_id)),
            array('label' => 'Manage ' . Sku::SKU_LABEL, 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update ' . Sku::SKU_LABEL . ' ' . $model->sku_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $custom_datas = SkuCustomData::model()->getAllSkuCustomData($model->sku_id);
        $sku_custom_data = new SkuCustomData;
        $sku_convertion = new SkuConvertion;
        $sku_location_restock = new SkuLocationRestock;

        $brand = CHtml::listData(Brand::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'brand_name ASC')), 'brand_id', 'brand_name');
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $zone = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');
        $sku_convertion_uom = CHtml::listData(Uom::model()->getAllUOMNotInSkuConvertion(), 'uom_id', 'uom_name');
        $sku_category = Sku::model()->skuAllTypeList();
        $infra_sub_category = Sku::model()->skuAllSubTypeList();

        if (isset($_POST['Sku'])) {

            $model->attributes = $_POST['Sku'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');
            $model->default_unit_price = !empty($_POST['Sku']['default_unit_price']) ? $_POST['Sku']['default_unit_price'] : 0;
            $model->sub_type = isset($model->type) && $model->type != Sku::INFRA ? "" : $model->sub_type;

            foreach ($custom_datas as $key => $val) {
                $attr_name = str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                $post_data = isset($_POST[$attr_name]) ? trim($_POST[$attr_name]) : "";
                SkuCustomData::model()->validateAllCustomDataValue($sku_custom_data, Yii::app()->user->company_id, $val['name'], $post_data);
            }

            if ($model->validate() && count($sku_custom_data->getErrors()) == 0) {

                SkuCustomDataValue::model()->deleteSkuCustomDataValueBySkuID($model->sku_id);

                foreach ($custom_datas as $key => $val) {
                    $sku_custom_data_value = new SkuCustomDataValue;

                    $sku_custom_data_value->id = Globals::generateV4UUID();
                    $sku_custom_data_value->sku_id = $model->sku_id;
                    $sku_custom_data_value->custom_data_id = $val['custom_data_id'];

                    $post_name = str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));
                    $sku_custom_data_value->value = $_POST[$post_name];
                    $sku_custom_data_value->save();
                }

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully updated");
//                    $this->redirect(array('view', 'id' => $model->sku_id));
                    $custom_datas = SkuCustomData::model()->getAllSkuCustomData($model->sku_id);
                }
            }
        } else if (isset($_POST['SkuConvertion'])) {

            $sku_convertion->attributes = $_POST['SkuConvertion'];
            $sku_convertion->company_id = Yii::app()->user->company_id;
            $sku_convertion->created_by = Yii::app()->user->name;
            unset($sku_convertion->created_date);

            $sku_convertion->id = Globals::generateV4UUID();

            if ($sku_convertion->save()) {
                Yii::app()->user->setFlash('success', "Sku Convertion Successfully created");
            }
        } else if (isset($_POST['SkuLocationRestock'])) {

            $sku_location_restock->attributes = $_POST['SkuLocationRestock'];
            $sku_location_restock->company_id = Yii::app()->user->company_id;
            $sku_location_restock->created_by = Yii::app()->user->name;
            unset($sku_location_restock->created_date);
            $sku_location_restock->id = Globals::generateV4UUID();

            if ($sku_location_restock->save()) {
                Yii::app()->user->setFlash('success', "Sku Location Restock Successfully created");
            }
        }

        $imgs_dp = new CActiveDataProvider('Images', array(
            'pagination' => array('pageSize' => 6),
        ));

        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.sku_id', $id, true);
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $sku_imgs_dp = new CActiveDataProvider('SkuImage', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 3),
        ));

        $this->render('update', array(
            'model' => $model,
            'brand' => $brand,
            'uom' => $uom,
            'zone' => $zone,
            'custom_datas' => $custom_datas,
            'sku_convertion' => $sku_convertion,
            'sku_convertion_uom' => $sku_convertion_uom,
            'sku_location_restock' => $sku_location_restock,
            'sku_custom_data' => $sku_custom_data,
            'sku_category' => $sku_category,
            'infra_sub_category' => $infra_sub_category,
            'imgs_dp' => $imgs_dp,
            'sku_imgs_dp' => $sku_imgs_dp,
        ));
    }

    public function actionAjaxLoadImages($sku_id) {
        $imgs_dp = new CActiveDataProvider('Images', array(
            'pagination' => array('pageSize' => 6),
        ));

        $this->renderPartial('_images', array('imgs_dp' => $imgs_dp, 'sku_id' => $sku_id), false, true);
    }

    public function actionAjaxFilterImages($sku_id) {
        if (Yii::app()->request->isPostRequest) {

            if (isset($_POST['file_name'])) {

                $file_name = $_POST['file_name'];

                $criteria = new CDbCriteria();
                $criteria->addSearchCondition('t.file_name', $file_name, true);
                $criteria->compare('t.company_id', Yii::app()->user->company_id);

                $imgs_dp = new CActiveDataProvider('Images', array(
                    'criteria' => $criteria,
                    'pagination' => array('pageSize' => 6),
                ));

                $this->renderPartial('_images', array('imgs_dp' => $imgs_dp, 'sku_id' => $sku_id,), false, true);
            }
        }
    }

    public function actionSkuImage($sku_id) {

        if (Yii::app()->request->isPostRequest) {

            $img_id = isset($_POST['img_id']) ? $_POST['img_id'] : null;

            $sku_image = new SkuImage;
            $sku_image->company_id = Yii::app()->user->company_id;
            $sku_image->sku_id = $sku_id;
            $sku_image->image_id = $img_id;
            $sku_image->created_by = Yii::app()->user->name;

            if ($sku_image->save()) {

                $image = Images::model()->findByAttributes(array("image_id" => $img_id));
                $image->updated_by = Yii::app()->user->name;
                $image->updated_date = date('Y-m-d H:i:s');
                $image->save();

                Yii::app()->user->setFlash('success', "Sku Image Successfully assign.");
            }
        }

        $this->loadSkuImagesBySkuID($sku_id);
    }

    public function actionDeleteSkuImage($sku_id) {

        if (Yii::app()->request->isPostRequest) {

            $sku_img_id = isset($_POST['sku_img_id']) ? $_POST['sku_img_id'] : null;

            $model = SkuImage::model()->findByAttributes(array('sku_image_id' => $sku_img_id, 'company_id' => Yii::app()->user->company_id));

            $model->delete();
        }

        $this->loadSkuImagesBySkuID($sku_id);
    }

    public function loadSkuImagesBySkuID($sku_id) {

        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.sku_id', $sku_id, true);
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $sku_imgs_dp = new CActiveDataProvider('SkuImage', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 3),
        ));

        $this->renderPartial('_sku_images', array('sku_imgs_dp' => $sku_imgs_dp, 'sku_id' => $sku_id,), false, true);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            try {
                // delete sku custom data value by sku_id
//            SkuCustomDataValue::model()->deleteSkuCustomDataValueBySkuID($id);
//            `
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
        $dataProvider = new CActiveDataProvider('Sku');

        $this->render('index', array
            (
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Merchandising Material';

        $model = new Sku('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sku']))
            $model->attributes = $_GET['Sku'];

        $brand = CHtml::listData(Brand::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'brand_name ASC')), 'brand_name', 'brand_name');
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_name', 'uom_name');
        $zone = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_name', 'zone_name');
        $sku_category = Sku::model()->skuAllTypeList();
        $infra_sub_category = Sku::model()->skuAllSubTypeList();

        $this->render('admin', array(
            'model' => $model,
            'brand' => $brand,
            'uom' => $uom,
            'zone' => $zone,
            'sku_category' => $sku_category,
            'infra_sub_category' => $infra_sub_category,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Sku::model()->findByAttributes(array('sku_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sku-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
