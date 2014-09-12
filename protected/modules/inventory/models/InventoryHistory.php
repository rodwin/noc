<?php

/**
 * This is the model class for table "inventory_history".
 *
 * The followings are the available columns in table 'inventory_history':
 * @property integer $inventory_history_id
 * @property string $company_id
 * @property integer $inventory_id
 * @property integer $quantity_change
 * @property integer $running_total
 * @property string $action
 * @property string $cost_unit
 * @property string $ave_cost_per_unit
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property string $transaction_date
 *
 * The followings are the available model relations:
 * @property Inventory $inventory
 */
class InventoryHistory extends CActiveRecord {

   public $search_string;
   public $selected_inventory_id;

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'inventory_history';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('inventory_id, quantity_change, running_total', 'numerical', 'integerOnly' => true),
          array('company_id, action, created_by, updated_by, destination_zone_id', 'length', 'max' => 50),
          array('cost_unit', 'length', 'max' => 18),
          array('ave_cost_per_unit', 'length', 'max' => 19),
          array('created_date, updated_date', 'safe'),
          array('transaction_date', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
          // The following rule is used by search().
          // @todo Please remove those attributes that should not be searched.
          array('inventory_history_id, company_id, inventory_id, quantity_change, running_total, action, cost_unit, ave_cost_per_unit, destination_zone_id, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
          'inventory' => array(self::BELONGS_TO, 'Inventory', 'inventory_id'),
          'zone' => array(self::BELONGS_TO, 'Zone', 'destination_zone_id'),
      );
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
          'inventory_history_id' => 'Inventory History',
          'company_id' => 'Company',
          'inventory_id' => 'Inventory',
          'quantity_change' => 'Quantity Change',
          'running_total' => 'Running Total',
          'action' => 'Action',
          'cost_unit' => 'Cost Unit',
          'ave_cost_per_unit' => 'Ave Cost Per Unit',
          'destination_zone_id' => 'Destination Zone',
          'created_date' => 'Created Date',
          'created_by' => 'Created By',
          'updated_date' => 'Updated Date',
          'updated_by' => 'Updated By',
          'transaction_date' => 'Transaction Date',
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

      $criteria->compare('inventory_history_id', $this->inventory_history_id);
      $criteria->compare('company_id', Yii::app()->user->company_id);
      $criteria->compare('inventory_id', $this->inventory_id);
      $criteria->compare('quantity_change', $this->quantity_change);
      $criteria->compare('running_total', $this->running_total);
      $criteria->compare('action', $this->action, true);
      $criteria->compare('cost_unit', $this->cost_unit, true);
      $criteria->compare('ave_cost_per_unit', $this->ave_cost_per_unit, true);
      $criteria->compare('destination_zone_id', $this->destination_zone_id, true);
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

//            case 0:
//                $sort_column = 'inventory_history_id';
//                break;

         case 0:
            $sort_column = 'inventory_id';
            break;

         case 1:
            $sort_column = 'quantity_change';
            break;

         case 2:
            $sort_column = 'running_total';
            break;

         case 3:
            $sort_column = 'action';
            break;

         case 4:
            $sort_column = 'cost_unit';
            break;

         case 5:
            $sort_column = 'ave_cost_per_unit';
            break;
      }


      $criteria = new CDbCriteria;
      $criteria->compare('company_id', Yii::app()->user->company_id);
//        $criteria->compare('inventory_history_id', $columns[0]['search']['value']);
      $criteria->compare('inventory_id', $columns[0]['search']['value']);
      $criteria->compare('quantity_change', $columns[1]['search']['value']);
      $criteria->compare('running_total', $columns[2]['search']['value']);
      $criteria->compare('action', $columns[3]['search']['value'], true);
      $criteria->compare('cost_unit', $columns[4]['search']['value'], true);
      $criteria->compare('ave_cost_per_unit', $columns[5]['search']['value'], true);
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
    * @return InventoryHistory the static model class
    */
   public static function model($className = __CLASS__) {
      return parent::model($className);
   }

   public function createHistory($company_id, $inventory_id, $transaction_date, $quantity_change, $running_total, $action, $cost_unit = 0, $created_by = null, $zone_id) {


      $inventory_history = new InventoryHistory;
      $inventory_history->company_id = $company_id;
      $inventory_history->inventory_id = $inventory_id;
      $inventory_history->quantity_change = $quantity_change;
      $inventory_history->running_total = $running_total;
      $inventory_history->action = $action;
      $inventory_history->cost_unit = $cost_unit;
      $inventory_history->transaction_date = $transaction_date;
      $inventory_history->destination_zone_id = $zone_id;
      /*
       * compute this!
       */
      if ($action == 'increase') {
         $data = $this->selectHistory($inventory_id);
         foreach ($data as $key => $value) {
            $curq = $value['running_total'];
            $curavgc = $value['ave_cost_per_unit'];
         }
         if (isset($curq)) {
            $avg = ((floatval($quantity_change) * floatval($cost_unit)) + (floatval($curq) * floatval($curavgc))) / ((floatval($quantity_change) + floatval($curq)));
         } else {
            $avg = $cost_unit;
         }
      } elseif ($action == 'apply') {
         $data = $this->selectHistory($this->selected_inventory_id);
         foreach ($data as $key => $value) {
            $curavgc = $value['ave_cost_per_unit'];
         }

         $avg = floatval($curavgc);
      } else {
         $curavgc = 0;
         $data = $this->selectHistory($inventory_id);
         foreach ($data as $key => $value) {
            $curavgc = $value['ave_cost_per_unit'];
         }

         $avg = floatval($curavgc);
      }

      $inventory_history->ave_cost_per_unit = $avg;
      $inventory_history->created_by = $created_by;
      if ($inventory_history->validate()) {
         return $inventory_history->save();
      } else {
         return $inventory_history->getErrors();
      }
   }

   public function getAllByInventoryID($id, $company_id) {

      $criteria = new CDbCriteria;
      $criteria->compare('t.company_id', $company_id);
      $criteria->compare('t.inventory_id', $id, true);
      $criteria->order = 'created_date desc';

      $history = InventoryHistory::model()->findAll($criteria);

      return $history;
   }

   public function deleteHistoryByInvID($inventory_id) {

      $sql = "DELETE FROM noc.inventory_history
                        WHERE inventory_id = :inventory_id";

      $command = Yii::app()->db->createCommand($sql);
      $command->bindParam(':inventory_id', $inventory_id, PDO::PARAM_STR);
      $command->execute();
   }

   public function selectHistory($inventory_id) {
      $sql = "SELECT * FROM noc.inventory_history WHERE inventory_id = :inventory_id ORDER BY created_date DESC LIMIT 1 ";

      $command = Yii::app()->db->createCommand($sql);
      $command->bindParam(':inventory_id', $inventory_id, PDO::PARAM_STR);
      $data = $command->queryAll();


      return $data;
   }

}