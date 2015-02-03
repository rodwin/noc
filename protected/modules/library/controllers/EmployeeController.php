<?php

class EmployeeController extends Controller {
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('data', 'getZoneByEmployeeID', 'getZoneBySalesOffice', 'search', 'loadEmployeeByDefaultZone', 'employeePOIData', 'POIIDs', 'POIIDs2', 'loadEmployeeDetailsByID'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin'),
                'expression' => "Yii::app()->user->checkAccess('Manage Employee', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => "Yii::app()->user->checkAccess('Add Employee', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => "Yii::app()->user->checkAccess('View Employee', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('update'),
                'expression' => "Yii::app()->user->checkAccess('Edit Employee', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('delete'),
                'expression' => "Yii::app()->user->checkAccess('Delete Employee', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        Employee::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Employee::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Employee::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['employee_id'] = $value->employee_id;
            $row['employee_code'] = $value->employee_code;
            $row['employee_status'] = $value->employee_status;
            $row['employee_status_code'] = isset($value->employee_status_code) ? $value->employee_status_code : null;
            $row['employee_type'] = $value->employee_type;
            $row['employee_type_code'] = isset($value->employeeType->employee_type_code) ? $value->employeeType->employee_type_code : null;

            $row['sales_office_name'] = isset($value->salesOffice->sales_office_name) ? $value->salesOffice->sales_office_name : null;
            $row['zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;

            $row['first_name'] = $value->first_name;
            $row['last_name'] = $value->last_name;
            $row['middle_name'] = $value->middle_name;
            $row['address1'] = $value->address1;
            $row['address2'] = $value->address2;
            $row['barangay_id'] = $value->barangay_id;
            $row['home_phone_number'] = $value->home_phone_number;
            $row['work_phone_number'] = $value->work_phone_number;
            $row['birth_date'] = $value->birth_date;
            $row['date_start'] = $value->date_start;
            $row['date_termination'] = $value->date_termination;
            $row['password'] = $value->password;
            $row['supervisor_id'] = $value->supervisor_id;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/employee/view', array('id' => $value->employee_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/employee/update', array('id' => $value->employee_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/employee/delete', array('id' => $value->employee_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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

        $this->pageTitle = 'View Employee ' . $model->employee_code;

        $this->menu = array(
            array('label' => 'Create Employee', 'url' => array('create')),
            array('label' => 'Update Employee', 'url' => array('update', 'id' => $model->employee_id)),
            array('label' => 'Delete Employee', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->employee_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Employee', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $employee_poi = EmployeePoi::model()->getEmployeePOI($model->employee_id);

        $this->render('view', array(
            'model' => $model,
            'employee_poi' => isset($employee_poi[0]->attributes) ? $employee_poi[0]->attributes : '',
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pageTitle = 'Create Employee';

        $this->menu = array(
            array('label' => 'Manage Employee', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Employee('create');
        $employee = new Employee();
        $employee_poi = new EmployeePoi();


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $employee_status = CHtml::listData(EmployeeStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_status_code ASC')), 'employee_status_id', 'employee_status_code');
        $employee_type = CHtml::listData(EmployeeType::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_type_code ASC')), 'employee_type_id', 'employee_type_code');
        $sales_office = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id in (' . Yii::app()->user->salesoffices . ')', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');

        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
        $criteria->condition = 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id IN (' . Yii::app()->user->salesoffices . ')';
        $criteria->order = 'employee_code ASC';
        $supervisor = CHtml::listData(Employee::model()->findAll($criteria), 'employee_id', 'fullname');

        $zone = array();

/////////////////////////
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['Employee'])) {
                    $employee->attributes = $_POST['Employee'];
                    $employee->company_id = Yii::app()->user->company_id;
                    $employee->created_by = Yii::app()->user->name;
                    $employee->employee_id = Globals::generateV4UUID();
                    unset($employee->created_date);

                    $validatedEmployee = CActiveForm::validate($employee);

                    if ($validatedEmployee != '[]') {

                        $data['error'] = $validatedEmployee;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {
                        $remove_poi = isset($_POST['remove_poi']) ? $_POST['remove_poi'] : array();
                        $employee_poi = isset($_POST['assigned_poi']) ? $_POST['assigned_poi'] : array();
                        if ($employee->create($employee_poi, $remove_poi)) {
                            $data['message'] = 'Successfully created';
                            $data['success'] = true;
                            $data['id'] = $employee->employee_id;
                        } else {
                            $data['message'] = 'Unable to process';
                            $data['success'] = false;
                            $data["type"] = "danger";
                        }
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }
///////////////////////
        $this->render('create', array(
            'model' => $model,
            'employee_status' => $employee_status,
            'employee_type' => $employee_type,
            'supervisor' => $supervisor,
            'sales_office' => $sales_office,
            'zone' => $zone,
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
            array('label' => 'Create Employee', 'url' => array('create')),
            array('label' => 'View Employee', 'url' => array('view', 'id' => $model->employee_id)),
            array('label' => 'Manage Employee', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Employee ' . $model->employee_code;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
//      if (isset($_POST['Employee'])) {
//         $model->attributes = $_POST['Employee'];
//         $model->updated_by = Yii::app()->user->name;
//         $model->updated_date = date('Y-m-d H:i:s');
//
//         if ($model->save()) {
//            Yii::app()->user->setFlash('success', "Successfully updated");
//            $this->redirect(array('view', 'id' => $model->employee_id));
//         }
//      }
        $employee_status = CHtml::listData(EmployeeStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_status_code ASC')), 'employee_status_id', 'employee_status_code');
        $employee_type = CHtml::listData(EmployeeType::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_type_code ASC')), 'employee_type_id', 'employee_type_code');
        $sales_office = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');

        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
        $criteria->condition = 'company_id = "' . Yii::app()->user->company_id . '" AND employee_id != "' . $model->employee_id . '"';
        $criteria->order = 'employee_code ASC';
        $supervisor = CHtml::listData(Employee::model()->findAll($criteria), 'employee_id', 'fullname');
        $zone = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id = "' . $model->sales_office_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');
///////////////////////////////////
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $data['success'] = false;
            $data["type"] = "success";

            if ($_POST['form'] == "transaction") {
                $data['form'] = $_POST['form'];

                if (isset($_POST['Employee'])) {
                    $model->attributes = $_POST['Employee'];
                    $model->updated_by = Yii::app()->user->name;
                    $model->updated_date = date('Y-m-d H:i:s');


                    $validatedEmployee = CActiveForm::validate($model);

                    if ($validatedEmployee != '[]') {

                        $data['error'] = $validatedEmployee;
                        $data['message'] = 'Unable to process';
                        $data['success'] = false;
                        $data["type"] = "danger";
                    } else {
                        $remove_poi = isset($_POST['remove_poi']) ? $_POST['remove_poi'] : array();
                        $employee_poi = isset($_POST['assigned_poi']) ? $_POST['assigned_poi'] : array();


                        if ($model->updateEmployee($employee_poi, $remove_poi, $model)) {
                            $data['message'] = 'Successfully created';
                            $data['success'] = true;
                            $data['id'] = $model->employee_id;
                        } else {
                            $data['message'] = 'Unable to process';
                            $data['success'] = false;
                            $data["type"] = "danger";
                        }
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }
/////////////////////////////////
        $this->render('update', array(
            'model' => $model,
            'employee_status' => $employee_status,
            'employee_type' => $employee_type,
            'supervisor' => $supervisor,
            'sales_office' => $sales_office,
            'zone' => $zone,
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
        $dataProvider = new CActiveDataProvider('Employee');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Employee';

        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee']))
            $model->attributes = $_GET['Employee'];
        $employee_status = CHtml::listData(EmployeeStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_status_code ASC')), 'employee_status_id', 'employee_status_code');
        $employee_type = CHtml::listData(EmployeeType::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_type_code ASC')), 'employee_type_code', 'employee_type_code');
        $sales_office = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_name', 'sales_office_name');
        $zone = array();
        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
        $criteria->condition = 'company_id = "' . Yii::app()->user->company_id . '"';
        $criteria->order = 'employee_code ASC';
        $supervisor = CHtml::listData(Employee::model()->findAll($criteria), 'employee_id', 'fullname');

        $this->render('admin', array(
            'model' => $model,
            'employee_status' => $employee_status,
            'employee_type' => $employee_type,
            'sales_office' => $sales_office,
            'zone' => $zone,
            'supervisor' => $supervisor,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {

        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('t.*,employee_status.employee_status_code AS employee_status_code, (SELECT CONCAT(first_name, " ",last_name) FROM employee WHERE employee_id = t.supervisor_id) AS fullname');
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.employee_id', $id);
        $criteria->join = 'left join employee_status ON employee_status.employee_status_id = t.employee_status';

        $model = Employee::model()->find($criteria);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetZoneByEmployeeID() {
        echo "<option value=''>Select Zone</option>";
        $data = Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id = "' . $_POST['sales_office_id'] . '"', 'order' => 'zone_name ASC'));

        foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['zone_id']), CHtml::encode($val['zone_name']), true);
        }
    }

    public function actionGetZoneBySalesOffice() {

        $salesoffice = SalesOffice::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sales_office_name" => $_POST['sales_office_name']));

        echo "<option value=''>Select Zone</option>";
        $data = Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id = "' . $salesoffice->sales_office_id . '"', 'order' => 'zone_name ASC'));

        foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['zone_name']), CHtml::encode($val['zone_name']), true);
        }
    }

    public function actionSearch($value) {

        $c = new CDbCriteria();
        if ($value != "") {
            $c->addSearchCondition('t.first_name', $value, true, 'OR');
            $c->addSearchCondition('t.last_name', $value, true, 'OR');
            $c->addSearchCondition('t.middle_name', $value, true, 'OR');
            $c->addSearchCondition('t.employee_code', $value, true, 'OR');
        }

        $c->select = new CDbExpression('t.*, CONCAT(t.first_name, " ",t.last_name) AS fullname');
        $c->compare('t.company_id', Yii::app()->user->company_id);
        $employee = Employee::model()->findAll($c);

        $return = array();
        foreach ($employee as $key => $val) {
            $return[$key]['employee_id'] = $val->employee_id;
            $return[$key]['employee_code'] = $val->employee_code;
            $return[$key]['fullname'] = $val->fullname;
        }

        echo json_encode($return);
        Yii::app()->end();
    }

    public function actionLoadEmployeeByDefaultZone($zone_id) {

        $c = new CDbCriteria;
        $c->select = new CDbExpression('t.*, CONCAT(t.first_name, " ",t.last_name) AS fullname');
        $c->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.default_zone_id = '" . $zone_id . "'";
        $employee = Employee::model()->find($c);

        $return = array();
        $return['employee_id'] = isset($employee) ? $employee->employee_id : "";
        $return['employee_code'] = isset($employee) ? $employee->employee_code : "";
        $return['fullname'] = isset($employee) ? $employee->fullname : "";
        $return['home_phone_number'] = isset($employee) ? $employee->home_phone_number : "";
        $return['address1'] = isset($employee) ? $employee->address1 : "";

        echo json_encode($return);
        Yii::app()->end();
    }

    public function actionEmployeePOIData($employee_id) {
//      EmployeePoi::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;
//
//      $dataProvider = EmployeePoi::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns'], $employee_id);
//
//      $count = EmployeePoi::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));
//
//      $output = array(
//          "draw" => intval($_GET['draw']),
//          "recordsTotal" => $count,
//          "recordsFiltered" => $dataProvider->totalItemCount,
//          "data" => array()
//      );

        $output = array("data" => array());
        $c = new CDbCriteria;
        $c->select = "t.*";
        $c->condition = "t.employee_id = '" . $employee_id . "'";
        $poi = EmployeePoi::model()->findAll($c);
        foreach ($poi as $key => $value) {
            $row = array();

            $row['poi_id'] = $value->poi_id;

            $c = new CDbCriteria;
            $c->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
                    . "province.province_name as province_name, region.region_name as region_name";
            $c->condition = "t.poi_id = '" . $value->poi_id . "'";
            $c->with = array('poiCategory', 'poiSubCategory');
            $c->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
            $c->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
            $c->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
            $c->join .= ' LEFT JOIN region ON region.region_code = t.region_id';



            $poi = Poi::model()->find($c);
            $row['short_name'] = $poi->short_name;
            $row['long_name'] = $poi->long_name;
            $row['primary_code'] = $poi->primary_code;
            $row['secondary_code'] = $poi->secondary_code;
            $row['barangay_id'] = $poi->barangay_id;
            $row['barangay_name'] = isset($poi->barangay_name) ? $poi->barangay_name : null;
            $row['municipal_id'] = $poi->municipal_id;
            $row['municipal_name'] = isset($poi->municipal_name) ? $poi->municipal_name : null;
            $row['province_id'] = $poi->province_id;
            $row['province_name'] = isset($poi->province_name) ? $poi->province_name : null;
            $row['region_id'] = $poi->region_id;
            $row['region_name'] = $poi->region_name;
            $row['sales_region_id'] = $poi->sales_region_id;
            $row['latitude'] = $poi->latitude;
            $row['longitude'] = $poi->longitude;
            $row['address1'] = $poi->address1;
            $row['address2'] = $poi->address2;
            $row['zip'] = $poi->zip;
            $row['landline'] = $poi->landline;
            $row['mobile'] = $poi->mobile;
            $row['poi_category_id'] = $poi->poi_category_id;
            $row['poi_category_name'] = isset($poi->poiCategory->category_name) ? $poi->poiCategory->category_name : null;
            $row['poi_sub_category_id'] = $poi->poi_sub_category_id;
            $row['poi_sub_category_name'] = isset($poi->poiSubCategory->sub_category_name) ? $poi->poiSubCategory->sub_category_name : null;
            $row['remarks'] = $poi->remarks;
            $row['status'] = $poi->status;
            $row['created_date'] = $poi->created_date;
            $row['created_by'] = $poi->created_by;
            $row['edited_date'] = $poi->edited_date;
            $row['edited_by'] = $poi->edited_by;
            $row['verified_by'] = $poi->verified_by;
            $row['verified_date'] = $poi->verified_date;
            $row['checkbox'] = '<input type="checkbox" id="assigned_chk" name="poi_row2" value="' . $poi->poi_id . '" />';


            $output['data'][] = $row;
        }
        echo json_encode($output);
    }

    public function actionPOIIDs() {
        $output = array("data" => array());
        $poi_ids = Yii::app()->request->getParam('poi_ids');
        foreach ($poi_ids as $key => $value) {

            $row = array();

            $row['poi_id'] = $value['poi_id'];

            $c = new CDbCriteria;
            $c->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
                    . "province.province_name as province_name, region.region_name as region_name";
            $c->condition = "t.poi_id = '" . $value['poi_id'] . "'";
            $c->with = array('poiCategory', 'poiSubCategory');
            $c->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
            $c->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
            $c->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
            $c->join .= ' LEFT JOIN region ON region.region_code = t.region_id';

            $poi = Poi::model()->find($c);
            $row['short_name'] = $poi->short_name;
            $row['long_name'] = $poi->long_name;
            $row['primary_code'] = $poi->primary_code;
            $row['secondary_code'] = $poi->secondary_code;
            $row['barangay_id'] = $poi->barangay_id;
            $row['barangay_name'] = isset($poi->barangay_name) ? $poi->barangay_name : null;
            $row['municipal_id'] = $poi->municipal_id;
            $row['municipal_name'] = isset($poi->municipal_name) ? $poi->municipal_name : null;
            $row['province_id'] = $poi->province_id;
            $row['province_name'] = isset($poi->province_name) ? $poi->province_name : null;
            $row['region_id'] = $poi->region_id;
            $row['region_name'] = $poi->region_name;
            $row['sales_region_id'] = $poi->sales_region_id;
            $row['latitude'] = $poi->latitude;
            $row['longitude'] = $poi->longitude;
            $row['address1'] = $poi->address1;
            $row['address2'] = $poi->address2;
            $row['zip'] = $poi->zip;
            $row['landline'] = $poi->landline;
            $row['mobile'] = $poi->mobile;
            $row['poi_category_id'] = $poi->poi_category_id;
            $row['poi_category_name'] = isset($poi->poiCategory->category_name) ? $poi->poiCategory->category_name : null;
            $row['poi_sub_category_id'] = $poi->poi_sub_category_id;
            $row['poi_sub_category_name'] = isset($poi->poiSubCategory->sub_category_name) ? $poi->poiSubCategory->sub_category_name : null;
            $row['remarks'] = $poi->remarks;
            $row['status'] = $poi->status;
            $row['created_date'] = $poi->created_date;
            $row['created_by'] = $poi->created_by;
            $row['edited_date'] = $poi->edited_date;
            $row['edited_by'] = $poi->edited_by;
            $row['verified_by'] = $poi->verified_by;
            $row['verified_date'] = $poi->verified_date;
            $row['checkbox'] = '<input type="checkbox" id="assigned_chk" name="poi_row2" value="' . $poi->poi_id . '"/>';


            $output['data'][] = $row;
        }
        echo json_encode($output);
    }

    public function actionPOIIDs2() {
        $output = array("data" => array());
        $poi_ids = Yii::app()->request->getParam('poi_ids');
        foreach ($poi_ids as $key => $value) {

            $row = array();

            $row['poi_id'] = $value['poi_id'];

            $c = new CDbCriteria;
            $c->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
                    . "province.province_name as province_name, region.region_name as region_name";
            $c->condition = "t.poi_id = '" . $value['poi_id'] . "'";
            $c->with = array('poiCategory', 'poiSubCategory');
            $c->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
            $c->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
            $c->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
            $c->join .= ' LEFT JOIN region ON region.region_code = t.region_id';

            $poi = Poi::model()->find($c);
            $row['short_name'] = $poi->short_name;
            $row['long_name'] = $poi->long_name;
            $row['primary_code'] = $poi->primary_code;
            $row['secondary_code'] = $poi->secondary_code;
            $row['barangay_id'] = $poi->barangay_id;
            $row['barangay_name'] = isset($poi->barangay_name) ? $poi->barangay_name : null;
            $row['municipal_id'] = $poi->municipal_id;
            $row['municipal_name'] = isset($poi->municipal_name) ? $poi->municipal_name : null;
            $row['province_id'] = $poi->province_id;
            $row['province_name'] = isset($poi->province_name) ? $poi->province_name : null;
            $row['region_id'] = $poi->region_id;
            $row['region_name'] = $poi->region_name;
            $row['sales_region_id'] = $poi->sales_region_id;
            $row['latitude'] = $poi->latitude;
            $row['longitude'] = $poi->longitude;
            $row['address1'] = $poi->address1;
            $row['address2'] = $poi->address2;
            $row['zip'] = $poi->zip;
            $row['landline'] = $poi->landline;
            $row['mobile'] = $poi->mobile;
            $row['poi_category_id'] = $poi->poi_category_id;
            $row['poi_category_name'] = isset($poi->poiCategory->category_name) ? $poi->poiCategory->category_name : null;
            $row['poi_sub_category_id'] = $poi->poi_sub_category_id;
            $row['poi_sub_category_name'] = isset($poi->poiSubCategory->sub_category_name) ? $poi->poiSubCategory->sub_category_name : null;
            $row['remarks'] = $poi->remarks;
            $row['status'] = $poi->status;
            $row['created_date'] = $poi->created_date;
            $row['created_by'] = $poi->created_by;
            $row['edited_date'] = $poi->edited_date;
            $row['edited_by'] = $poi->edited_by;
            $row['verified_by'] = $poi->verified_by;
            $row['verified_date'] = $poi->verified_date;
            $row['checkbox'] = '<input type="checkbox" id="available_chk" name="poi_row" value="' . $poi->poi_id . '"/>';


            $output['data'][] = $row;
        }
        echo json_encode($output);
    }

    public function actionLoadEmployeeDetailsByID($employee_id) {

        if ($employee_id == "") {
            return false;
        }

        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
        $criteria->condition = 'company_id = "' . Yii::app()->user->company_id . '" AND t.employee_id = "' . $employee_id . '"';
        $employee = Employee::model()->find($criteria);

        $return = array();

        $return['employee_id'] = $employee->employee_id;
        $return['full_name'] = $employee->fullname;
        $return['employee_code'] = $employee->employee_code;
        $return['address1'] = $employee->address1;
        $return['default_zone_name'] = isset($employee->zone->zone_name) ? $employee->zone->zone_name : "";

        echo json_encode($return);
    }

}
