<?php

class PoiCustomDataController extends Controller {
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
                'actions' => array('index', 'data'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin'),
                'expression' => "Yii::app()->user->checkAccess('Manage Outlet Custom Data', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => "Yii::app()->user->checkAccess('Add Outlet Custom Data', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => "Yii::app()->user->checkAccess('View Outlet Custom Data', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('update'),
                'expression' => "Yii::app()->user->checkAccess('Edit Outlet Custom Data', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('delete'),
                'expression' => "Yii::app()->user->checkAccess('Delete Outlet Custom Data', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        PoiCustomData::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = PoiCustomData::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = PoiCustomData::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['custom_data_id'] = $value->custom_data_id;
            $row['name'] = $value->name;
            $row['type'] = $value->type;
            $row['poi_category_name'] = $value->category_name;
            $row['data_type'] = $value->data_type;
            $row['description'] = $value->description;
            $row['required'] = $value->required;
            $row['sort_order'] = $value->sort_order;
            $row['attribute'] = $value->attribute;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/poicustomdata/view', array('id' => $value->custom_data_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/poicustomdata/update', array('id' => $value->custom_data_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/poicustomdata/delete', array('id' => $value->custom_data_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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
        $poi_category = PoiCategory::model()->findByAttributes(array("poi_category_id" => $model->type, "company_id" => Yii::app()->user->company_id));
        $model->type = $poi_category->category_name;

        $this->pageTitle = 'View ' . Poi::POI_LABEL . ' Custom Data ' . $model->name;

        $this->menu = array(
            array('label' => 'Create ' . Poi::POI_LABEL . ' Custom Data', 'url' => array('create')),
            array('label' => 'Update ' . Poi::POI_LABEL . ' Custom Data', 'url' => array('update', 'id' => $model->custom_data_id)),
            array('label' => 'Delete ' . Poi::POI_LABEL . ' Custom Data', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->custom_data_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage ' . Poi::POI_LABEL . ' Custom Data', 'url' => array('admin')),
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

        $this->pageTitle = 'Create ' . Poi::POI_LABEL . ' Custom Data';

        $this->menu = array(
            array('label' => 'Manage ' . Poi::POI_LABEL . ' Custom Data', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new PoiCustomData('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $customDataForm = new CustomDataItemForm;
        $poi_custom_data = new PoiCustomData;

        $data_type_list = CHtml::listData(PoiCustomData::model()->getAllDataType(), 'id', 'title');
        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');

        if (isset($_POST['CustomDataItemForm'])) {

            $customDataForm->attributes = $_POST['CustomDataItemForm'];

            if ($customDataForm->validate()) {

                $model->name = $customDataForm->customItemName;
                $model->type = $customDataForm->type;
                $model->data_type = $customDataForm->customDataType;

                Yii::app()->session['name'] = $customDataForm->customItemName;
                Yii::app()->session['type'] = $customDataForm->type;
                Yii::app()->session['data_type'] = $customDataForm->customDataType;

                $attributes = PoiCustomData::model()->getAttributeByDataType($customDataForm->customItemName, $customDataForm->customDataType);

                $this->render('create_form', array('model' => $model, 'unserialize_attribute' => $attributes, 'poi_category' => $poi_category, 'poi_custom_data' => $poi_custom_data,));
            } else {

                $this->render('create', array('customDataForm' => $customDataForm, 'data_type_list' => $data_type_list, 'poi_category' => $poi_category,));
            }
        } else if (isset($_POST['PoiCustomData'])) {

            $model->name = Yii::app()->session['name'];
            $model->type = Yii::app()->session['type'];
            $model->data_type = Yii::app()->session['data_type'];

            $model->attributes = $_POST['PoiCustomData'];

            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);
            $model->custom_data_id = Globals::generateV4UUID();

            $attributes = PoiCustomData::model()->getAttributeByDataType($model->name, $model->data_type);

            foreach ($attributes as $key => $val) {
                PoiCustomData::model()->validateAllDatatypeRequiredField($poi_custom_data, $key);
            }

            if ($model->validate() && count($poi_custom_data->getErrors()) == 0) {

                $serialize_attribute = CJSON::encode($attributes);
                $model->attribute = $serialize_attribute;
                $model->save();

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully created");
                    $this->redirect(array('view', 'id' => $model->custom_data_id));
                }

                unset(Yii::app()->session['name']);
                unset(Yii::app()->session['type']);
                unset(Yii::app()->session['data_type']);

                $this->redirect(array('view', 'id' => $model->custom_data_id));
            } else {

                $attributes = PoiCustomData::model()->getAttributeByDataType($model->name, $model->data_type);

                $this->render('create_form', array('model' => $model, 'unserialize_attribute' => $attributes, 'poi_category' => $poi_category, 'poi_custom_data' => $poi_custom_data,));
            }
        } else {

            $this->render('create', array('model' => $model, 'customDataForm' => $customDataForm, 'data_type_list' => $data_type_list, 'poi_category' => $poi_category,));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create ' . Poi::POI_LABEL . ' Custom Data', 'url' => array('create')),
            array('label' => 'View ' . Poi::POI_LABEL . ' Custom Data', 'url' => array('view', 'id' => $model->custom_data_id)),
            array('label' => 'Manage ' . Poi::POI_LABEL . ' Custom Data', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update ' . Poi::POI_LABEL . ' CustomData ' . $model->name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $poi_custom_data = new PoiCustomData;
        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');
        $unserialize_attribute = CJSON::decode($model->attribute);

        if (isset($_POST['PoiCustomData'])) {

            $model->attributes = $_POST['PoiCustomData'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            $attributes = PoiCustomData::model()->getAttributeByDataType($model->name, $model->data_type);
            foreach ($attributes as $key => $val) {
                PoiCustomData::model()->validateAllDatatypeRequiredField($poi_custom_data, $key);
            }

            if ($model->validate() && count($poi_custom_data->getErrors()) == 0) {

                $serialize_attribute = CJSON::encode($attributes);
                $model->attributes = $_POST['PoiCustomData'];
                $model->attribute = $serialize_attribute;

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully updated");
                    $this->redirect(array('view', 'id' => $model->custom_data_id));
                }
            } else {

                $attributes = PoiCustomData::model()->getAttributeByDataType($model->name, $model->data_type);

                $this->render('update', array(
                    'model' => $model,
                    'poi_category' => $poi_category,
                    'unserialize_attribute' => $attributes,
                    'poi_custom_data' => $poi_custom_data,
                ));
            }
        } else {

            $this->render('update', array(
                'model' => $model,
                'poi_category' => $poi_category,
                'unserialize_attribute' => $unserialize_attribute,
                'poi_custom_data' => $poi_custom_data,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {

            // delete poi custom data value by custom_data_id
            PoiCustomDataValue::model()->deletePoiCustomDataValueByCustomDataID($id);

            try {
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
                        Yii::app()->user->setFlash('danger', "Unable to deleted");
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
        $dataProvider = new CActiveDataProvider('PoiCustomData');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . Poi::POI_LABEL . ' Custom Data';

        $model = new PoiCustomData('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PoiCustomData']))
            $model->attributes = $_GET['PoiCustomData'];

        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'category_name', 'category_name');

        $data_type_list = CHtml::listData(PoiCustomData::model()->getAllDataType(), 'id', 'title');

        $this->render('admin', array(
            'model' => $model,
            'poi_category' => $poi_category,
            'data_type_list' => $data_type_list,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PoiCustomData::model()->findByAttributes(array('custom_data_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'poi-custom-data-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
