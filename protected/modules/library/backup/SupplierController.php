<?php

class SupplierController extends Controller {
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

        Supplier::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Supplier::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Supplier::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['supplier_id'] = $value->supplier_id;
            $row['supplier_code'] = $value->supplier_code;
            $row['supplier_name'] = $value->supplier_name;
            $row['contact_person1'] = $value->contact_person1;
            $row['contact_person2'] = $value->contact_person2;
            $row['telephone'] = $value->telephone;
            $row['cellphone'] = $value->cellphone;
            $row['fax_number'] = $value->fax_number;
            $row['address1'] = $value->address1;
            $row['address2'] = $value->address2;
            $row['barangay_id'] = $value->barangay_id;
            $row['barangay_name'] = $value->barangay_name;
            $row['municipal_id'] = $value->municipal_id;
            $row['municipal_name'] = $value->municipal_name;
            $row['province_id'] = $value->province_id;
            $row['province_name'] = $value->province_name;
            $row['region_id'] = $value->region_id;
            $row['region_name'] = $value->region_name;
            $row['latitude'] = $value->latitude;
            $row['longitude'] = $value->longitude;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/supplier/view', array('id' => $value->supplier_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/supplier/update', array('id' => $value->supplier_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/supplier/delete', array('id' => $value->supplier_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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

        $this->pageTitle = 'View Supplier ' . $model->supplier_name;

        $this->menu = array(
            array('label' => 'Create Supplier', 'url' => array('create')),
            array('label' => 'Update Supplier', 'url' => array('update', 'id' => $model->supplier_id)),
            array('label' => 'Delete Supplier', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->supplier_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Supplier', 'url' => array('admin')),
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

        $this->pageTitle = 'Create Supplier';

        $this->menu = array(
            array('label' => 'Manage Supplier', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Supplier('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $region = CHtml::listData(Region::model()->findAll(array('order' => 'region_name ASC')), 'region_code', 'region_name');

        if (isset($_POST['Supplier'])) {
            $model->attributes = $_POST['Supplier'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);
            $model->supplier_id = Globals::generateV4UUID();

            $province = CHtml::listData(Province::model()->findAll(array('condition' => 'region_code = "' . $model->region_id . '"', 'order' => 'province_name ASC')), 'province_code', 'province_name');
            $municipal = CHtml::listData(Municipal::model()->findAll(array('condition' => 'province_code = "' . $model->province_id . '"', 'order' => 'municipal_name ASC')), 'municipal_code', 'municipal_name');
            $barangay = CHtml::listData(Barangay::model()->findAll(array('condition' => 'municipal_code = "' . $model->municipal_id . '"', 'order' => 'barangay_name ASC')), 'barangay_code', 'barangay_name');

            if ($model->validate()) {

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully created");
                    $this->redirect(array('view', 'id' => $model->supplier_id));
                }
            }
        } else {
            $province = array();
            $municipal = array();
            $barangay = array();
        }

        $this->render('create', array(
            'model' => $model,
            'region' => $region,
            'province' => $province,
            'municipal' => $municipal,
            'barangay' => $barangay,
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
            array('label' => 'Create Supplier', 'url' => array('create')),
            array('label' => 'View Supplier', 'url' => array('view', 'id' => $model->supplier_id)),
            array('label' => 'Manage Supplier', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Supplier ' . $model->supplier_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $region = CHtml::listData(Region::model()->findAll(array('order' => 'region_name ASC')), 'region_code', 'region_name');
        $province = CHtml::listData(Province::model()->findAll(array('order' => 'province_name ASC')), 'province_code', 'province_name');
        $municipal = CHtml::listData(Municipal::model()->findAll(array('order' => 'municipal_name ASC')), 'municipal_code', 'municipal_name');
        $barangay = CHtml::listData(Barangay::model()->findAll(array('order' => 'barangay_name ASC')), 'barangay_code', 'barangay_name');

        if (isset($_POST['Supplier'])) {
            $model->attributes = $_POST['Supplier'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->supplier_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'region' => $region,
            'province' => $province,
            'municipal' => $municipal,
            'barangay' => $barangay,
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
        $dataProvider = new CActiveDataProvider('Supplier');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Supplier';

        $model = new Supplier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier']))
            $model->attributes = $_GET['Supplier'];

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
        $c = new CDbCriteria;
        $c->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
                . "province.province_name as province_name, region.region_name as region_name";
        $c->compare('t.supplier_id', $id);
        $c->compare('t.company_id', Yii::app()->user->company_id);
        $c->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
        $c->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
        $c->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
        $c->join .= ' LEFT JOIN region ON region.region_code = t.region_id';

        $model = Supplier::model()->find($c);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'supplier-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
