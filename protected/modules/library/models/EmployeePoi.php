<?php

/**
 * This is the model class for table "employee_poi".
 *
 * The followings are the available columns in table 'employee_poi':
 * @property string $poi_id
 * @property string $employee_id
 * @property string $company_id 
 * @property string $created_date
 * @property string $created_by
 */
class EmployeePoi extends CActiveRecord {

   public $search_string;

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'employee_poi';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('poi_id, employee_id, company_id', 'required'),
          array('poi_id, employee_id, created_by', 'length', 'max' => 50),
          array('created_date', 'safe'),
          // The following rule is used by search().
          // @todo Please remove those attributes that should not be searched.
          array('poi_id, employee_id, company_id, created_date, created_by', 'safe', 'on' => 'search'),
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
          'poi' => array(self::BELONGS_TO, 'Poi', 'poi_id'),
      );
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
          'poi_id' => 'Poi',
          'employee_id' => 'Employee',
          'company_id' => 'Company',
          'created_date' => 'Created Date',
          'created_by' => 'Created By',
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

      $criteria->compare('poi_id', $this->poi_id, true);
      $criteria->compare('company_id', $this->company_id, true);
      $criteria->compare('employee_id', $this->employee_id, true);
      $criteria->compare('created_date', $this->created_date, true);
      $criteria->compare('created_by', $this->created_by, true);

      return new CActiveDataProvider($this, array(
                  'criteria' => $criteria,
              ));
   }

   public function data($col, $order_dir, $limit, $offset, $columns, $employee_id) {
      $col++;
      switch ($col) {
         case 0:
            $sort_column = 'poi.short_name';
            break;

         case 1:
            $sort_column = 'poi.long_name';
            break;

         case 2:
            $sort_column = 'poi.primary_code';
            break;

         case 3:
            $sort_column = 'poi.secondary_code';
            break;

//         case 5:
//            $sort_column = 'category_name';
//            break;
//
//         case 6:
//            $sort_column = 'sub_category_name';
//            break;
//
//         case 7:
//            $sort_column = 'barangay_name';
//            break;
//
//         case 8:
//            $sort_column = 'municipal_name';
//            break;
//
//         case 9:
//            $sort_column = 'province_name';
//            break;
//
//         case 10:
//            $sort_column = 'region_name';
//            break;
      }

      $criteria = new CDbCriteria;
//        $criteria->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
//                . "province.province_name as province_name, region.region_name as region_name, poi_category.category_name as poi_category_name";
      $criteria->condition = "t.company_id = '" . Yii::app()->user->company_id . "'"; //('t.company_id', Yii::app()->user->company_id);
//      $criteria->compare('poi_id', $columns[0]['search']['value'], true);
      $criteria->condition = "employee_id = '" . $employee_id . "' AND t.company_id = '" . Yii::app()->user->company_id . "'";
      $criteria->compare('poi.short_name', $columns[1]['search']['value'], true);
      $criteria->compare('poi.long_name', $columns[2]['search']['value'], true);
      $criteria->compare('poi.primary_code', $columns[3]['search']['value'], true);
      $criteria->compare('poi.secondary_code', $columns[4]['search']['value'], true);
//      $criteria->compare('poi_category_name', $columns[4]['search']['value']);
//      $criteria->compare('PoiSubCategory.sub_category_name', $columns[5]['search']['value']);
//      $criteria->compare('barangay_name', $columns[6]['search']['value']);
//      $criteria->compare('municipal_name', $columns[7]['search']['value']);
//      $criteria->compare('province_name', $columns[8]['search']['value']);
//      $criteria->compare('region_name', $columns[9]['search']['value']);
      $criteria->with = array('poi');
//        $criteria->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
//        $criteria->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
//        $criteria->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
//        $criteria->join .= ' LEFT JOIN region ON region.region_code = t.region_id';
//        $criteria->join .= ' LEFT JOIN poi_category ON poi_category.category_name = poi.category_name';
//      $criteria->compare('employee_id', $employee_id);
//		$criteria->compare('created_date',$columns[2]['search']['value'],true);
//		$criteria->compare('created_by',$columns[3]['search']['value'],true);
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
    * @return EmployeePoi the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   public function createEmployeePOI($poi_id, $company_id, $employee_id, $chk) {
      if ($chk == 'update') {
         $criteria = new CDbCriteria;
         $criteria->select = 't.*';
         $criteria->condition = 't.company_id = "' . Yii::app()->user->company_id . '" AND t.employee_id = "' . $employee_id . '" AND t.poi_id = "' . $poi_id . '"';

         if (count(EmployeePoi::model()->findAll($criteria)) <= 0) {
             $employee_poi = new EmployeePoi;
            $employee_poi->poi_id = $poi_id;
            $employee_poi->employee_id = $employee_id;
            $employee_poi->company_id = $company_id;
            if ($employee_poi->save(false)) {
               return true;
            } else {

               return $employee_poi->getErrors();
            }
         } 
      } else {
         $employee_poi = new EmployeePoi;
         $employee_poi->poi_id = $poi_id;
         $employee_poi->employee_id = $employee_id;
         $employee_poi->company_id = $company_id;
         if ($employee_poi->save(false)) {
            return true;
         } else {

            return $employee_poi->getErrors();
         }
      }
   }

   public function getEmployeePOI($employee_id) {
      $criteria = new CDbCriteria;
      $criteria->select = 't.*, poi.short_name as name';
      $criteria->join .= ' INNER JOIN poi ON poi.poi_id = t.poi_id';
      $criteria->condition = 't.company_id = "' . Yii::app()->user->company_id . '" AND t.employee_id = "' . $employee_id . '"';
//        $criteria->order = "poi.sort_order ASC";

      return EmployeePoi::model()->findAll($criteria);
   }

}