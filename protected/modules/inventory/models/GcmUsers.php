<?php

/**
 * This is the model class for table "gcm_users".
 *
 * The followings are the available columns in table 'gcm_users':
 * @property integer $id
 * @property string $company_id
 * @property string $employee_id
 * @property string $gcm_regid
 * @property string $name
 * @property string $sales_office_id
 * @property string $created_at
 */
class GcmUsers extends CActiveRecord {

   /**
    * @var integer id
    * @soap
    */
   public $id;
   
   /**
    * @var string company_id
    * @soap
    */
   public $company_id;

   /**
    * @var string gcm_regid
    * @soap
    */
   public $gcm_regid;

   /**
    * @var string name
    * @soap
    */
   public $name;

   /**
    * @var string sales_office_id
    * @soap
    */
   public $sales_office_id;

   /**
    * @var string created_at
    * @soap
    */
   public $created_at;
   public $search_string;

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'gcm_users';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('employee_id, name', 'required'),
          array('employee_id, name', 'length', 'max' => 50),
          array('sales_office_id', 'length', 'max' => 255),
          array('gcm_regid', 'safe'),
          // The following rule is used by search().
          // @todo Please remove those attributes that should not be searched.
          array('id, employee_id, gcm_regid, name, sales_office_id, created_at', 'safe', 'on' => 'search'),
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
      );
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
          'id' => 'ID',
          'employee_id' => 'Employee',
          'gcm_regid' => 'Gcm Regid',
          'name' => 'Name',
          'sales_office_id' => 'Sales Office ID',
          'created_at' => 'Created At',
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

      $criteria->compare('id', $this->id);
      $criteria->compare('employee_id', $this->employee_id, true);
      $criteria->compare('gcm_regid', $this->gcm_regid, true);
      $criteria->compare('name', $this->name, true);
      $criteria->compare('sales_office_id', $this->sales_office_id, true);
      $criteria->compare('created_at', $this->created_at, true);

      return new CActiveDataProvider($this, array(
                  'criteria' => $criteria,
              ));
   }

   public function data($col, $order_dir, $limit, $offset, $columns) {
      switch ($col) {

         case 0:
            $sort_column = 'id';
            break;

         case 1:
            $sort_column = 'employee_id';
            break;

         case 2:
            $sort_column = 'gcm_regid';
            break;

         case 3:
            $sort_column = 'name';
            break;

         case 4:
            $sort_column = 'sales_office_id';
            break;

         case 5:
            $sort_column = 'created_at';
            break;
      }


      $criteria = new CDbCriteria;
      $criteria->compare('company_id', Yii::app()->user->company_id);
      $criteria->compare('id', $columns[0]['search']['value']);
      $criteria->compare('employee_id', $columns[1]['search']['value'], true);
      $criteria->compare('gcm_regid', $columns[2]['search']['value'], true);
      $criteria->compare('name', $columns[3]['search']['value'], true);
      $criteria->compare('sales_office_id', $columns[4]['search']['value'], true);
      $criteria->compare('created_at', $columns[5]['search']['value'], true);
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
    * @return GcmUsers the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   /**
    * Storing new user
    * returns user details
    */
   public function storeUser($emp_id, $name, $sales_office_id, $gcm_regid, $company_id) {
     
      $gcm = new GcmUsers();
      $gcm->employee_id = $emp_id;
      $gcm->name = $name;
      $gcm->sales_office_id = $sales_office_id;
      $gcm->gcm_regid = $gcm_regid;
      $gcm->company_id = $company_id;
      if ($gcm->validate()) {
         $gcm->save();
         return true;
         //return $gcm;
      } else {
         return $gcm->getErrors();
      }
   }

   /**
    * Get user by email and password
    */
   public function getUserByEmail($email) {
      $result = mysql_query("SELECT * FROM gcm_users WHERE email = '$email' LIMIT 1");
      return $result;
   }

   /**
    * Getting all users
    */
   public function getAllUsers() {
      $result = mysql_query("select * FROM gcm_users");
      return $result;
   }

   /**
    * Check user is existed or not
    */
   public function isUserExisted($email, $emp_id, $gcm_id, $name) {
      $sql = "SELECT count(*) as ctr from gcm_users WHERE employee_id = '" . $emp_id . "' AND gcm_regid = '" . $gcm_id . "' AND name = '" . $name . "'  AND gcm_regid != ''";
      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();
      if ($data[0]['ctr'] > 0) {
         // user existed
         return true;
      } else {
         // user not existed
         return false;
      }
   }

   /**
    * Sending Push Notification
    */
   public function send_notification($registatoin_ids, $message) {

      // Set POST variables
      $url = 'https://android.googleapis.com/gcm/send';
      $fields = array(
          'registration_ids' => array($registatoin_ids),
          'data' => array("price" => $message),
      );
      // pre(json_encode($fields));


      $headers = array(
          'Authorization: key=' . Yii::app()->params['GOOGLE_API_KEY'],
          'Content-Type: application/json'
      );


      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Disabling SSL Certificate support temporarly
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

      // Execute post
      $result = curl_exec($ch);


      if ($result === FALSE) {
         die('Curl failed: ' . curl_error($ch));
      }

      // Close connection
      curl_close($ch);
      //echo $result;
      return $result;
   }

//   public function register($emp_id, $name, $email, $gcm_regid) {
//      if (isset($emp_id) && isset($name) && isset($gcm_regid)) {
//        $sql = "SELECT count(*) as ctr from gcm_users WHERE employee_id = '". $emp_id ."' AND gcm_regid = '". $gcm_regid ."' AND name = '". $name ."'  AND gcm_regid != ''";
//        $command = Yii::app()->db->createCommand($sql);
//        $data = $command->queryAll();
//        if ($data[0]['ctr'] == 0) {
//         // user existed
//         $res = $this->storeUser($emp_id, $name, $email, $gcm_regid);
//         }
//         $registatoin_ids = array($gcm_regid);
//         $message = array("product" => "shirt");
//
//
//         $result = $this->send_notification($registatoin_ids, $message);
//
//         echo $result;
//      } else {
//         // user details missing
//      }
//   }

   public function register($emp_code, $name, $sales_office_code, $gcm_regid) {
      if (isset($emp_code) && isset($name) && isset($gcm_regid) && isset($sales_office_code)) {
         $sql = "SELECT employee_id, company_id FROM employee WHERE employee_code = '" . $emp_code . "'";
         $command = Yii::app()->db->createCommand($sql);
         $emp_id = $command->queryAll();
         $sql = "SELECT sales_office_id FROM sales_office WHERE sales_office_code = '" . $sales_office_code . "'";
         $command = Yii::app()->db->createCommand($sql);
         $data2 = $command->queryAll(); 
         if ($emp_id[0]['employee_id'] && $data2[0]['sales_office_id']) {
            $sql = "SELECT count(*) as ctr from gcm_users WHERE company_id = '". $emp_id[0]['company_id'] ."' AND employee_id = '" . $emp_id[0]['employee_id'] . "' AND gcm_regid = '" . $gcm_regid . "' AND name = '" . $name . "'  AND gcm_regid != ''";
            $command = Yii::app()->db->createCommand($sql);
            $data = $command->queryAll();
            if ($data[0]['ctr'] == 0) {
               $res = $this->storeUser($emp_id[0]['employee_id'], $name, $data2[0]['sales_office_id'], $gcm_regid, $emp_id[0]['company_id']);
            }
            $registatoin_ids = array($gcm_regid);
            $message = array("product" => "shirt");


            $result = $this->send_notification($registatoin_ids, $message);

            echo $result;
         }
      } else {
         // user details missing
      }
   }

}