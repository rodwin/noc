<?php

/**
 * This is the model class for table "employee_status".
 *
 * The followings are the available columns in table 'employee_status':
 * @property string $employee_status_id
 * @property string $company_id
 * @property string $employee_status_code
 * @property string $description
 * @property string $available
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class EmployeeStatus extends CActiveRecord {

   /**
    * @var string employee_status_code
    * @soap
    */
   public $employee_status_code;
   
   /**
    * @var string description
    * @soap
    */
   public $description;
   
   public $search_string;

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'employee_status';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('employee_status_id, company_id, employee_status_code', 'required'),
          array('employee_status_id, company_id, employee_status_code, description, created_by, updated_date, updated_by', 'length', 'max' => 50),
          array('available', 'length', 'max' => 1),
          array('created_date', 'safe'),
          // The following rule is used by search().
          // @todo Please remove those attributes that should not be searched.
          array('employee_status_id, company_id, employee_status_code, description, available, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
      );
   }

   public function beforeValidate() {
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
      );
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
          'employee_status_id' => 'Employee Status',
          'company_id' => 'Company',
          'employee_status_code' => 'Employee Status Code',
          'description' => 'Description',
          'available' => 'Available',
          'created_date' => 'Created Date',
          'created_by' => 'Created By',
          'updated_date' => 'Updated Date',
          'updated_by' => 'Updated By',
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

      $criteria->compare('employee_status_id', $this->employee_status_id, true);
      $criteria->compare('company_id', Yii::app()->user->company_id);
      $criteria->compare('employee_status_code', $this->employee_status_code, true);
      $criteria->compare('description', $this->description, true);
      $criteria->compare('available', $this->available, true);
      $criteria->compare('created_date', $this->created_date, true);
      $criteria->compare('created_by', $this->created_by, true);
      $criteria->compare('updated_date', $this->updated_date, true);
      $criteria->compare('updated_by', $this->updated_by, true);

      return new CActiveDataProvider($this, array(
                  'criteria' => $criteria,
              ));
   }

   public function data($col, $order_dir, $limit, $offset, $columns) {
      switch ($col) {

         case 0:
            $sort_column = 'employee_status_id';
            break;

         case 1:
            $sort_column = 'employee_status_code';
            break;

         case 2:
            $sort_column = 'description';
            break;

         case 3:
            $sort_column = 'available';
            break;

         case 4:
            $sort_column = 'created_date';
            break;

         case 5:
            $sort_column = 'created_by';
            break;

         case 6:
            $sort_column = 'updated_date';
            break;
      }


      $criteria = new CDbCriteria;
      $criteria->compare('company_id', Yii::app()->user->company_id);
      $criteria->compare('employee_status_id', $columns[0]['search']['value'], true);
      $criteria->compare('employee_status_code', $columns[1]['search']['value'], true);
      $criteria->compare('description', $columns[2]['search']['value'], true);
      $criteria->compare('available', $columns[3]['search']['value'], true);
      $criteria->compare('created_date', $columns[4]['search']['value'], true);
      $criteria->compare('created_by', $columns[5]['search']['value'], true);
      $criteria->compare('updated_date', $columns[6]['search']['value'], true);
      $criteria->order = "$sort_column $order_dir";
      $criteria->limit = $limit;
      $criteria->offset = $offset;

      return new CActiveDataProvider($this, array(
                  'criteria' => $criteria,
                  'pagination' => false,
              ));
   }

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return EmployeeStatus the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

}