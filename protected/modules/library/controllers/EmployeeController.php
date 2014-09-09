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
              'actions' => array('index', 'view'),
              'users' => array('@'),
          ),
          array('allow', // allow authenticated user to perform 'create' and 'update' actions
              'actions' => array('create', 'update', 'data', 'getZoneByEmployeeID', 'getZoneBySalesOffice'),
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

      $this->render('view', array(
          'model' => $model,
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

      // Uncomment the following line if AJAX validation is needed
      // $this->performAjaxValidation($model);

      if (isset($_POST['Employee'])) {
         $model->attributes = $_POST['Employee'];
         $model->company_id = Yii::app()->user->company_id;
         $model->created_by = Yii::app()->user->name;
         unset($model->created_date);

         $model->employee_id = Globals::generateV4UUID();

         if ($model->save()) {
            Yii::app()->user->setFlash('success', "Successfully created");
            $this->redirect(array('view', 'id' => $model->employee_id));
         }
      }

      $employee_status = CHtml::listData(EmployeeStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_status_code ASC')), 'employee_status_id', 'employee_status_code');
      $employee_type = CHtml::listData(EmployeeType::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_type_code ASC')), 'employee_type_id', 'employee_type_code');
      $sales_office = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');

      $criteria = new CDbCriteria;
      $criteria->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
      $criteria->condition = 'company_id = "' . Yii::app()->user->company_id . '"';
      $criteria->order = 'employee_code ASC';
      $supervisor = CHtml::listData(Employee::model()->findAll($criteria), 'employee_id', 'fullname');

      $zone = array();


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

      if (isset($_POST['Employee'])) {
         $model->attributes = $_POST['Employee'];
         $model->updated_by = Yii::app()->user->name;
         $model->updated_date = date('Y-m-d H:i:s');

         if ($model->save()) {
            Yii::app()->user->setFlash('success', "Successfully updated");
            $this->redirect(array('view', 'id' => $model->employee_id));
         }
      }
      $employee_status = CHtml::listData(EmployeeStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_status_code ASC')), 'employee_status_id', 'employee_status_code');
      $employee_type = CHtml::listData(EmployeeType::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'employee_type_code ASC')), 'employee_type_id', 'employee_type_code');
      $sales_office = CHtml::listData(SalesOffice::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sales_office_name ASC')), 'sales_office_id', 'sales_office_name');
      $criteria = new CDbCriteria;
      $criteria->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
      $criteria->condition = 'company_id = "' . Yii::app()->user->company_id . '" AND employee_id != "' . $model->employee_id . '"';
      $criteria->order = 'employee_code ASC';
      $supervisor = CHtml::listData(Employee::model()->findAll($criteria), 'employee_id', 'fullname');
      $zone = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id = "' . $model->sales_office_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');

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
      }
      else
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
      
      $salesoffice = SalesOffice::model()->findByAttributes(array("company_id"=>Yii::app()->user->company_id, "sales_office_name"=>$_POST['sales_office_name']));
      
      echo "<option value=''>Select Zone</option>";
      $data = Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '" AND sales_office_id = "' . $salesoffice->sales_office_id . '"', 'order' => 'zone_name ASC'));

      foreach ($data as $key => $val) {
         echo CHtml::tag('option', array('value' => $val['zone_name']), CHtml::encode($val['zone_name']), true);
      }
   }

}
