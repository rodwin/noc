<?php

class ZoneController extends Controller {
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
                'actions' => array('index', 'view', 'search', 'searchByWarehouse'),
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

        Zone::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Zone::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Zone::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['zone_id'] = $value->zone_id;
            $row['zone_name'] = $value->zone_name;
            $row['sales_office_id'] = $value->sales_office_id;
            $row['sales_office_name'] = isset($value->salesOffice->sales_office_name) ? $value->salesOffice->sales_office_name : null;
            $row['description'] = $value->description;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/zone/view', array('id' => $value->zone_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/zone/update', array('id' => $value->zone_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/zone/delete', array('id' => $value->zone_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionSearch($value) {

        $c = new CDbCriteria();
        if ($value != "") {
            $c->addSearchCondition('t.zone_name', $value, true);
        }
        $c->compare('t.company_id', Yii::app()->user->company_id);
        $c->with = array('salesOffice');
        $zone = Zone::model()->findAll($c);

        $return = array();
        foreach ($zone as $key => $val) {
            $return[$key]['zone_id'] = $val->zone_id;
            $return[$key]['zone_name'] = $val->zone_name;
            $return[$key]['sales_office'] = isset($val->salesOffice->sales_office_name) ? $val->salesOffice->sales_office_name : '';
        }

        echo json_encode($return);
        Yii::app()->end();
    }

    public function actionSearchByWarehouse($value) {

        $c = new CDbCriteria();
        if ($value != "") {
            $c->condition = 'salesOffice.distributor_id = :distributor_id AND t.zone_name LIKE :zone_name';
            $c->params = array(':distributor_id' => "", ":zone_name" => '%' . $value . '%');
        }
        $c->compare('t.company_id', Yii::app()->user->company_id);
        $c->with = array('salesOffice');
        $zone = Zone::model()->findAll($c);

        $return = array();
        foreach ($zone as $key => $val) {
            $return[$key]['zone_id'] = $val->zone_id;
            $return[$key]['zone_name'] = $val->zone_name;
            $return[$key]['sales_office'] = isset($val->salesOffice->sales_office_name) ? $val->salesOffice->sales_office_name : '';
        }

        echo json_encode($return);
        Yii::app()->end();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'View Zone ' . $model->zone_name;

        $this->menu = array(
            array('label' => 'Create Zone', 'url' => array('create')),
            array('label' => 'Update Zone', 'url' => array('update', 'id' => $model->zone_id)),
            array('label' => 'Delete Zone', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->zone_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Zone', 'url' => array('admin')),
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

        $this->pageTitle = 'Create Zone';

        $this->menu = array(
            array('label' => 'Manage Zone', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Zone('create');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Zone'])) {

            $model->attributes = $_POST['Zone'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);
            $model->zone_id = Globals::generateV4UUID();

            if ($model->validate()) {

                if ($model->save()) {

                    if ($_POST['Zone']['default_zone'] == 1) {

                        $sales_office = SalesOffice::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'sales_office_id' => $model->sales_office_id));
                        $sales_office->default_zone_id = $model->zone_id;
                        $sales_office->save();
                    }

                    Yii::app()->user->setFlash('success', "Successfully created");
                    $this->redirect(array('view', 'id' => $model->zone_id));
                }
            }
        }

        $sales_office_list = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');

        $this->render('create', array(
            'model' => $model,
            'sales_office_list' => $sales_office_list,
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
            array('label' => 'Create Zone', 'url' => array('create')),
            array('label' => 'View Zone', 'url' => array('view', 'id' => $model->zone_id)),
            array('label' => 'Manage Zone', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Zone ' . $model->zone_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $sales_office = SalesOffice::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'sales_office_id' => $model->sales_office_id, 'default_zone_id' => $model->zone_id));
        $model->default_zone = isset($sales_office->default_zone_id) ? 1 : 0;

        if (isset($_POST['Zone'])) {

            $model->attributes = $_POST['Zone'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->validate()) {

                $sales_office = SalesOffice::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'sales_office_id' => $model->sales_office_id));

                if ($_POST['Zone']['default_zone'] == 1) {

                    $sales_office->default_zone_id = $model->zone_id;
                } else if (isset($sales_office->default_zone_id) && $_POST['Zone']['default_zone'] == 0) {

                    $sales_office->default_zone_id = null;
                }

                if ($model->save() && $sales_office->save()) {
                    Yii::app()->user->setFlash('success', "Successfully updated");
                    $this->redirect(array('view', 'id' => $model->zone_id));
                }
            }
        }

        $sales_office_list = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');

        $this->render('update', array(
            'model' => $model,
            'sales_office_list' => $sales_office_list,
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
        $dataProvider = new CActiveDataProvider('Zone');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Zone';

        $model = new Zone('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Zone']))
            $model->attributes = $_GET['Zone'];

        $sales_office = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_name', 'sales_office_name');

        $this->render('admin', array(
            'model' => $model,
            'sales_office' => $sales_office,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Zone::model()->findByAttributes(array('zone_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'zone-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
