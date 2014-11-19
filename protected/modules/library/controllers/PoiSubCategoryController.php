<?php

class PoiSubCategoryController extends Controller {
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
            array('allow',
                'actions' => array('admin'),
                'expression' => "Yii::app()->user->checkAccess('Manage Outlet Sub Category', array('company_id' => Yii::app()->user->company_id))",
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => "Yii::app()->user->checkAccess('Add Outlet Sub Category', array('company_id' => Yii::app()->user->company_id))",
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => "Yii::app()->user->checkAccess('View Outlet Sub Category', array('company_id' => Yii::app()->user->company_id))",
            ),
            array('allow',
                'actions' => array('edit'),
                'expression' => "Yii::app()->user->checkAccess('Edit Outlet Sub Category', array('company_id' => Yii::app()->user->company_id))",
            ),
            array('allow',
                'actions' => array('delete'),
                'expression' => "Yii::app()->user->checkAccess('Delete Outlet Sub Category', array('company_id' => Yii::app()->user->company_id))",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        PoiSubCategory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = PoiSubCategory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = PoiSubCategory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['poi_sub_category_id'] = $value->poi_sub_category_id;
            $row['poi_category_id'] = $value->poi_category_id;
            $row['poi_category_name'] = $value->category_name;
            $row['sub_category_name'] = $value->sub_category_name;
            $row['description'] = $value->description;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/poisubcategory/view', array('id' => $value->poi_sub_category_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/poisubcategory/update', array('id' => $value->poi_sub_category_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/poisubcategory/delete', array('id' => $value->poi_sub_category_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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
        $poi_category = PoiCategory::model()->findByAttributes(array("poi_category_id" => $model->poi_category_id, "company_id" => Yii::app()->user->company_id));
        $model->poi_category_id = $poi_category->category_name;

        $this->pageTitle = 'View ' . Poi::POI_LABEL . ' Sub Category ' . $model->sub_category_name;

        $this->menu = array(
            array('label' => 'Create ' . Poi::POI_LABEL . ' Sub Category', 'url' => array('create')),
            array('label' => 'Update ' . Poi::POI_LABEL . ' Sub Category', 'url' => array('update', 'id' => $model->poi_sub_category_id)),
            array('label' => 'Delete ' . Poi::POI_LABEL . ' Sub Category', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->poi_sub_category_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage ' . Poi::POI_LABEL . ' Sub Category', 'url' => array('admin')),
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

        $this->pageTitle = 'Create ' . Poi::POI_LABEL . ' Sub Category';

        $this->menu = array(
            array('label' => 'Manage ' . Poi::POI_LABEL . ' Sub Category', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new PoiSubCategory('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PoiSubCategory'])) {
            $model->attributes = $_POST['PoiSubCategory'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);
            $model->poi_sub_category_id = Globals::generateV4UUID();

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully created");
                $this->redirect(array('view', 'id' => $model->poi_sub_category_id));
            }
        }

        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');

        $this->render('create', array(
            'model' => $model,
            'poi_category' => $poi_category,
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
            array('label' => 'Create ' . Poi::POI_LABEL . ' Sub Category', 'url' => array('create')),
            array('label' => 'View ' . Poi::POI_LABEL . ' Sub Category', 'url' => array('view', 'id' => $model->poi_sub_category_id)),
            array('label' => 'Manage ' . Poi::POI_LABEL . ' Sub Category', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update ' . Poi::POI_LABEL . ' Sub Category ' . $model->sub_category_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PoiSubCategory'])) {
            $model->attributes = $_POST['PoiSubCategory'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->poi_sub_category_id));
            }
        }

        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');

        $this->render('update', array(
            'model' => $model,
            'poi_category' => $poi_category,
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
        $dataProvider = new CActiveDataProvider('PoiSubCategory');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . Poi::POI_LABEL . ' Sub Category';

        $model = new PoiSubCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PoiSubCategory']))
            $model->attributes = $_GET['PoiSubCategory'];

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
        $model = PoiSubCategory::model()->findByAttributes(array('poi_sub_category_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'poi-sub-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
