<?php

class SalesOfficeController extends Controller {
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

        SalesOffice::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = SalesOffice::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = SalesOffice::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {

            $sales_office = Salesoffice::model()->find(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id = "' . $value->distributor_id . '"'));
            $zone = Zone::model()->find(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND zone_id = "' . $value->default_zone_id . '"'));

            $row = array();
            $row['sales_office_id'] = $value->sales_office_id;
            $row['distributor_id'] = $value->distributor_id;
            $row['distributor_code'] = $value->distributor_id != "" ? $sales_office->sales_office_code : null;
            $row['distributor_name'] = $value->distributor_id != "" ? $sales_office->sales_office_name : null;
            $row['sales_office_code'] = $value->sales_office_code;
            $row['sales_office_name'] = $value->sales_office_name;
            $row['default_zone_name'] = isset($value->default_zone_id) ? $zone->zone_name : null;
            $row['address1'] = $value->address1;
            $row['address2'] = $value->address2;
            $row['barangay_id'] = $value->barangay_id;
            $row['municipal_id'] = $value->municipal_id;
            $row['province_id'] = $value->province_id;
            $row['region_id'] = $value->region_id;
            $row['latitude'] = $value->latitude;
            $row['longitude'] = $value->longitude;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/salesoffice/view', array('id' => $value->sales_office_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/salesoffice/update', array('id' => $value->sales_office_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/salesoffice/delete', array('id' => $value->sales_office_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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
        
        $zone = Zone::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'zone_id' => $model->default_zone_id));

        $this->pageTitle = 'View SalesOffice ' . $model->sales_office_name;

        $this->menu = array(
            array('label' => 'Create SalesOffice', 'url' => array('create')),
            array('label' => 'Update SalesOffice', 'url' => array('update', 'id' => $model->sales_office_id)),
            array('label' => 'Delete SalesOffice', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->sales_office_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage SalesOffice', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->render('view', array(
            'model' => $model,
            'zone' => $zone,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pageTitle = 'Create SalesOffice';

        $this->menu = array(
            array('label' => 'Manage SalesOffice', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new SalesOffice('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $region = CHtml::listData(Region::model()->findAll(array('order' => 'region_name ASC')), 'region_code', 'region_name');

        if (isset($_POST['SalesOffice'])) {

            $model->attributes = $_POST['SalesOffice'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);
            $model->sales_office_id = Globals::generateV4UUID();

            $province = CHtml::listData(Province::model()->findAll(array('condition' => 'region_code = "' . $model->region_id . '"', 'order' => 'province_name ASC')), 'province_code', 'province_name');
            $municipal = CHtml::listData(Municipal::model()->findAll(array('condition' => 'province_code = "' . $model->province_id . '"', 'order' => 'municipal_name ASC')), 'municipal_code', 'municipal_name');
            $barangay = CHtml::listData(Barangay::model()->findAll(array('condition' => 'municipal_code = "' . $model->municipal_id . '"', 'order' => 'barangay_name ASC')), 'barangay_code', 'barangay_name');

            if ($model->validate()) {

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully created");
                    $this->redirect(array('view', 'id' => $model->sales_office_id));
                }
            }
        } else {
            $province = array();
            $municipal = array();
            $barangay = array();
        }

        $distributors = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND distributor_id = ""', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');
        
        $this->render('create', array(
            'model' => $model,
            'distributors' => $distributors,
            'region' => $region,
            'province' => $province,
            'municipal' => $municipal,
            'barangay' => $barangay,
            'zones' => array(),
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
            array('label' => 'Create SalesOffice', 'url' => array('create')),
            array('label' => 'View SalesOffice', 'url' => array('view', 'id' => $model->sales_office_id)),
            array('label' => 'Manage SalesOffice', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update SalesOffice ' . $model->sales_office_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $region = CHtml::listData(Region::model()->findAll(array('order' => 'region_name ASC')), 'region_code', 'region_name');
        $province = CHtml::listData(Province::model()->findAll(array('order' => 'province_name ASC')), 'province_code', 'province_name');
        $municipal = CHtml::listData(Municipal::model()->findAll(array('order' => 'municipal_name ASC')), 'municipal_code', 'municipal_name');
        $barangay = CHtml::listData(Barangay::model()->findAll(array('order' => 'barangay_name ASC')), 'barangay_code', 'barangay_name');

        if (isset($_POST['SalesOffice'])) {

            $model->attributes = $_POST['SalesOffice'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->sales_office_id));
            }
        }

        $distributors = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND distributor_id = ""', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');
        $zones = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id = "'.$model->sales_office_id.'"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');

        $this->render('update', array(
            'model' => $model,
            'distributors' => $distributors,
            'region' => $region,
            'province' => $province,
            'municipal' => $municipal,
            'barangay' => $barangay,
            'zones' => $zones,
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
        $dataProvider = new CActiveDataProvider('SalesOffice');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage SalesOffice';

        $model = new SalesOffice('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalesOffice']))
            $model->attributes = $_GET['SalesOffice'];

        $distributors = CHtml::listData(Distributor::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'distributor_name ASC')), 'distributor_name', 'distributor_name');
        $zones = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_name', 'zone_name');
        
        $this->render('admin', array(
            'model' => $model,
            'distributors' => $distributors,
            'zones' => $zones,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SalesOffice::model()->findByAttributes(array('sales_office_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sales-office-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
