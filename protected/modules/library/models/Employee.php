<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property string $employee_id
 * @property string $company_id
 * @property string $employee_code
 * @property string $employee_status
 * @property string $employee_type
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $address1
 * @property string $address2
 * @property string $barangay_id
 * @property string $home_phone_number
 * @property string $work_phone_number
 * @property string $birth_date
 * @property string $date_start
 * @property string $date_termination
 * @property string $password
 * @property string $supervisor_id
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property EmployeeType $employeeType
 */
class Employee extends CActiveRecord {

   /**
    * @var string employee_id
    * @soap
    */
   public $employee_id;

   /**
    * @var string employee_code
    * @soap
    */
   public $employee_code;

   /**
    * @var EmployeeStatus employee_status_obj
    * @soap
    */
   public $employee_status_obj;

   /**
    * @var EmployeeType employee_type_obj
    * @soap
    */
   public $employee_type_obj;

   /**
    * @var string first_name
    * @soap
    */
   public $first_name;

   /**
    * @var string last_name
    * @soap
    */
   public $last_name;

   /**
    * @var string middle_name
    * @soap
    */
   public $middle_name;

   /**
    * @var string address1
    * @soap
    */
   public $address1;

   /**
    * @var string address2
    * @soap
    */
   public $address2;

   /**
    * @var string barangay_id
    * @soap
    */
   public $barangay_id;

   /**
    * @var string home_phone_number
    * @soap
    */
   public $home_phone_number;

   /**
    * @var string work_phone_number
    * @soap
    */
   public $work_phone_number;

   /**
    * @var string birth_date
    * @soap
    */
   public $birth_date;

   /**
    * @var string date_start
    * @soap
    */
   public $date_start;

   /**
    * @var string date_termination
    * @soap
    */
   public $date_termination;

   /**
    * @var string supervisor_id
    * @soap
    */
   public $supervisor_id;

   /**
    * @var SalesOffice sales_office_obj
    * @soap
    */
   public $sales_office_obj;

   /**
    * @var string default_zone_id
    * @soap
    */
   public $default_zone_id;

   /**
    * @var Company company_obj
    * @soap
    */
   public $company_obj;

   /**
    * @var Zone zone_obj
    * @soap
    */
   public $zone_obj;
   public $search_string;
   public $fullname;
   public $employee_status_code;

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'employee';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('company_id, employee_code, employee_status, employee_type, first_name, last_name, sales_office_id, default_zone_id', 'required'),
          array('employee_id, company_id, employee_code, employee_status, employee_type, first_name, last_name, middle_name, address1, address2, barangay_id, password, supervisor_id, created_by, updated_by, sales_office_id, default_zone_id', 'length', 'max' => 50),
          array('home_phone_number, work_phone_number', 'length', 'max' => 20),
          array('employee_code', 'uniqueEmployeeCode'),
          array('birth_date, date_start, date_termination, created_date, updated_date', 'safe'),
          // The following rule is used by search().
          // @todo Please remove those attributes that should not be searched.
          array('employee_id, company_id, employee_code, employee_status, employee_type, first_name, last_name, middle_name, address1, address2, barangay_id, home_phone_number, work_phone_number, birth_date, date_start, date_termination, password, supervisor_id, created_date, created_by, updated_date, updated_by, sales_office_id, default_zone_id', 'safe', 'on' => 'search'),
      );
   }

   public function uniqueEmployeeCode($attribute, $params) {

      $model = Employee::model()->findByAttributes(array('company_id' => $this->company_id, 'employee_code' => $this->$attribute));
      if ($model && $model->employee_id != $this->employee_id) {
         $this->addError($attribute, 'Employee code selected already taken.');
      }
      return;
   }

   public function beforeValidate() {
      if ($this->birth_date == "") {
         $this->birth_date = null;
      }
      if ($this->date_start == "") {
         $this->date_start = null;
      }
      if ($this->date_termination == "") {
         $this->date_termination = null;
      }
      return parent::beforeValidate();
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      // NOTE: you may need to adjust the relation name and the related
      // class name for the relations automatically generated below.
      return array(
          'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
          'employeeType' => array(self::BELONGS_TO, 'EmployeeType', 'employee_type'),
          'salesOffice' => array(self::BELONGS_TO, 'SalesOffice', 'sales_office_id'),
          'zone' => array(self::BELONGS_TO, 'Zone', 'default_zone_id'),
          'employeeStatus' => array(self::BELONGS_TO, 'EmployeeStatus', 'employee_status'),
      );
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
          'employee_id' => 'Employee',
          'company_id' => 'Company',
          'employee_code' => 'Employee Code',
          'employee_status' => 'Employee Status',
          'employee_type' => 'Employee Type',
          'first_name' => 'First Name',
          'last_name' => 'Last Name',
          'middle_name' => 'Middle Name',
          'address1' => 'Address1',
          'address2' => 'Address2',
          'barangay_id' => 'Barangay',
          'home_phone_number' => 'Home Phone Number',
          'work_phone_number' => 'Work Phone Number',
          'birth_date' => 'Birth Date',
          'date_start' => 'Date Start',
          'date_termination' => 'Date Termination',
          'password' => 'Password',
          'supervisor_id' => 'Supervisor',
          'created_date' => 'Created Date',
          'created_by' => 'Created By',
          'updated_date' => 'Updated Date',
          'updated_by' => 'Updated By',
          'sales_office_id' => 'Sales Office',
          'default_zone_id' => 'Zone',
      );
   }

   /**
    * Retrieves a list of models based on the current search/filter conditions.
    *
    * Typical usecase:
    * - Initialize the model fields with values from filter form.
    * - Execute this method to get CActiveDataProvider instance which will filter
    * models according to data in model fields.
    * - Pass data provider to CGridView, CListView or any similar widget.
    *
    * @return CActiveDataProvider the data provider that can return the models
    * based on the search/filter conditions.
    */
   public function search() {
      // @todo Please modify the following code to remove attributes that should not be searched.

      $criteria = new CDbCriteria;

      $criteria->compare('employee_id', $this->employee_id, true);
      $criteria->compare('company_id', Yii::app()->user->company_id);
      $criteria->compare('employee_code', $this->employee_code, true);
      $criteria->compare('employee_status', $this->employee_status, true);
      $criteria->compare('employee_type', $this->employee_type, true);
      $criteria->compare('first_name', $this->first_name, true);
      $criteria->compare('last_name', $this->last_name, true);
      $criteria->compare('middle_name', $this->middle_name, true);
      $criteria->compare('address1', $this->address1, true);
      $criteria->compare('address2', $this->address2, true);
      $criteria->compare('barangay_id', $this->barangay_id, true);
      $criteria->compare('home_phone_number', $this->home_phone_number, true);
      $criteria->compare('work_phone_number', $this->work_phone_number, true);
      $criteria->compare('birth_date', $this->birth_date, true);
      $criteria->compare('date_start', $this->date_start, true);
      $criteria->compare('date_termination', $this->date_termination, true);
      $criteria->compare('password', $this->password, true);
      $criteria->compare('supervisor_id', $this->supervisor_id, true);
      $criteria->compare('created_date', $this->created_date, true);
      $criteria->compare('created_by', $this->created_by, true);
      $criteria->compare('updated_date', $this->updated_date, true);
      $criteria->compare('updated_by', $this->updated_by, true);

      $criteria->compare('default_zone_id', $this->zone, true);
      $criteria->compare('sales_office_id', $this->sales_office, true);


      return new CActiveDataProvider($this, array(
                  'criteria' => $criteria,
              ));
   }

   public function data($col, $order_dir, $limit, $offset, $columns) {
      switch ($col) {

         case 0:
            $sort_column = 't.employee_id';
            break;

         case 0:
            $sort_column = 't.employee_code';
            break;

         case 1:
            $sort_column = 't.employee_status';
            break;

         case 2:
            $sort_column = 'employeeType.employee_type_code';
            break;

         case 3:
            $sort_column = 'salesOffice.sales_office_name';
            break;

         case 4:
            $sort_column = 'zone.zone_name';
            break;

         case 5:
            $sort_column = 't.first_name';
            break;

         case 6:
            $sort_column = 't.last_name';
            break;

         case 7:
            $sort_column = 't.middle_name';
            break;

         case 8:
            $sort_column = 't.supervisor_id';
            break;
      }


      $criteria = new CDbCriteria;
      $criteria->select = "t.*,employee_status.employee_status_code AS employee_status_code";
      $criteria->compare('t.company_id', Yii::app()->user->company_id);
      //$criteria->compare('employee_id', $columns[0]['search']['value'], true);
      $criteria->compare('t.employee_code', $columns[0]['search']['value'], true);
      $criteria->compare('t.employee_status', $columns[1]['search']['value'], true);
      $criteria->compare('employeeType.employee_type_code', $columns[2]['search']['value'], true);
      $criteria->compare('salesOffice.sales_office_name', $columns[3]['search']['value'], true);
      $criteria->compare('zone.zone_name', $columns[4]['search']['value'], true);
      $criteria->compare('t.first_name', $columns[5]['search']['value'], true);
      $criteria->compare('t.last_name', $columns[6]['search']['value'], true);
      $criteria->compare('t.middle_name', $columns[7]['search']['value'], true);
      $criteria->order = "$sort_column $order_dir";
      $criteria->limit = $limit;
      $criteria->offset = $offset;
      $criteria->with = array('employeeType', 'salesOffice', 'zone');
      $criteria->join = 'left join employee_status ON employee_status.employee_status_id = t.employee_status';

      return new CActiveDataProvider($this, array(
                  'criteria' => $criteria,
                  'pagination' => false,
              ));
   }

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Employee the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   public function retriveEmployeeByCriteria(EmployeeCriteria $employee_criteria) {
      $cdbcriteria = new CDbCriteria();
      //$cdbcriteria->select = "t.*, employee_status.employee_status_code AS employee_status_code";
      $cdbcriteria->with = array('salesOffice', 'employeeType', 'employeeStatus', 'company', 'zone');
      $cdbcriteria->compare('company.code', $employee_criteria->company_code);
      $cdbcriteria->compare('t.employee_code', $employee_criteria->employee_code);
      $cdbcriteria->compare('salesOffice.sales_office_code', $employee_criteria->sales_office_code);
      $cdbcriteria->compare('t.password', $employee_criteria->password);
//       pr($cdbcriteria);
//       pr('____________________________________________________________________________________');
//      pre(Employee::model()->find($cdbcriteria));
      return Employee::model()->find($cdbcriteria);
   }

   public function create($assigned_poi, $remove_poi, $validate = true) {

      if ($validate) {
         if (!$this->validate()) {
            return false;
         }
      }

      $employee = new Employee;

      try {
         $employee_data = array(
             'company_id' => $this->company_id,
             'employee_id' => $this->employee_id,
             'employee_code' => $this->employee_code,
             'employee_status' => $this->employee_status,
             'employee_type' => $this->employee_type,
             'default_zone_id' => $this->default_zone_id,
             'sales_office_id' => $this->sales_office_id,
             'first_name' => $this->first_name,
             'last_name' => $this->last_name,
             'middle_name' => $this->middle_name,
             'address1' => $this->address1,
             'address2' => $this->address2,
             'barangay_id' => $this->barangay_id,
             'home_phone_number' => $this->home_phone_number,
             'work_phone_number' => $this->work_phone_number,
             '$birth_date' => $this->birth_date,
             'date_start' => $this->date_start,
             'date_termination' => $this->date_termination,
             'password' => $this->password,
             'supervisor_id' => $this->supervisor_id,
         );

         $employee->attributes = $employee_data;
         if (count($remove_poi) > 0) {
            for ($i = 0; $i < count($remove_poi); $i++) {
               EmployeePoi::model()->removeEmployeePOI($remove_poi[$i]['poi_id'], $employee->employee_id);
            }
         }
         if (count($assigned_poi) > 0) {
            if ($employee->save(false)) {
               for ($i = 0; $i < count($assigned_poi); $i++) {
                  EmployeePoi::model()->createEmployeePOI($assigned_poi[$i]['poi_id'], $employee->company_id, $employee->employee_id, 'create');
               }
            }

//                return true;
         } else {
            return false;
         }
         return true;
      } catch (Exception $exc) {
         Yii::log($exc->getTraceAsString(), 'error');
         return false;
      }
   }

   public function updateEmployee($assigned_poi, $remove_poi, $model, $validate = true) {
      if ($validate) {
         if (!$this->validate()) {
            return false;
         }
      }

      $employee = $model;

      try {
         $employee_data = array(
             'company_id' => $this->company_id,
             'employee_id' => $this->employee_id,
             'employee_code' => $this->employee_code,
             'employee_status' => $this->employee_status,
             'employee_type' => $this->employee_type,
             'default_zone_id' => $this->default_zone_id,
             'sales_office_id' => $this->sales_office_id,
             'first_name' => $this->first_name,
             'last_name' => $this->last_name,
             'middle_name' => $this->middle_name,
             'address1' => $this->address1,
             'address2' => $this->address2,
             'barangay_id' => $this->barangay_id,
             'home_phone_number' => $this->home_phone_number,
             'work_phone_number' => $this->work_phone_number,
             '$birth_date' => $this->birth_date,
             'date_start' => $this->date_start,
             'date_termination' => $this->date_termination,
             'password' => $this->password,
             'supervisor_id' => $this->supervisor_id,
         );

         $employee->attributes = $employee_data; 
         if (count($remove_poi) > 0) {
            for ($i = 0; $i < count($remove_poi); $i++) {
               EmployeePoi::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND employee_id = '" . $this->employee_id . "' AND poi_id = '" . $remove_poi[$i]['poi_id'] . "'");
            }
         }
         if ($employee->save(false)) { 
            if (count($assigned_poi) > 0) {
               for ($i = 0; $i < count($assigned_poi); $i++) {
                  EmployeePoi::model()->createEmployeePOI($assigned_poi[$i]['poi_id'], $employee->company_id, $employee->employee_id, 'update');
               }
            }
         }
//                return true;
          else {
            return false;
         }
         return true;
      } catch (Exception $exc) {
         Yii::log($exc->getTraceAsString(), 'error');
         return false;
      }
   }

}