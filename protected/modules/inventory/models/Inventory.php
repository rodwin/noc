<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property integer $inventory_id
 * @property string $company_id
 * @property string $sku_id
 * @property integer $qty
 * @property string $uom_id
 * @property string $zone_id
 * @property string $sku_status_id
 * @property string $transaction_date
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property string $expiration_date
 * @property string $reference_no
 * @property string $cost_per_unit
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Sku $sku
 * @property SkuStatus $skuStatus
 * @property Uom $uom
 * @property Zone $zone
 * @property InventoryHistory[] $inventoryHistories
 */
class Inventory extends CActiveRecord {

    public $search_string;
    
    const INVENTORY_ACTION_TYPE_INCREASE = 'increase';
    const INVENTORY_ACTION_TYPE_DECREASE = 'decrease';
    const INVENTORY_ACTION_TYPE_MOVE = 'move';
    const INVENTORY_ACTION_TYPE_CONVERT = 'convert';
    const INVENTORY_ACTION_TYPE_UPDATE = 'update';
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, sku_id, qty, transaction_date', 'required'),
            array('qty', 'numerical', 'integerOnly' => true),
            array('company_id, sku_id, uom_id, zone_id, sku_status_id, created_by, updated_by', 'length', 'max' => 50),
            array('reference_no', 'length', 'max' => 250),
            array('cost_per_unit', 'length', 'max' => 18),
            array('cost_per_unit', 'match', 'pattern'=>'/^[0-9]{1,9}(\.[0-9]{0,3})?$/'),
            array('created_date, updated_date, expiration_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('inventory_id, company_id, sku_id, qty, uom_id, zone_id, sku_status_id, transaction_date, created_date, created_by, updated_date, updated_by, expiration_date, reference_no', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate() {
        
        if($this->cost_per_unit == ""){
           $this->cost_per_unit = null; 
        }
        
        if($this->zone_id == ""){
           $this->zone_id = null; 
        }
        
        if($this->uom_id == ""){
           $this->uom_id = null; 
        }
        
        if($this->sku_status_id == ""){
           $this->sku_status_id = null; 
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
            'sku' => array(self::BELONGS_TO, 'Sku', 'sku_id'),
            'skuStatus' => array(self::BELONGS_TO, 'SkuStatus', 'sku_status_id'),
            'uom' => array(self::BELONGS_TO, 'Uom', 'uom_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
            'inventoryHistories' => array(self::HAS_MANY, 'InventoryHistory', 'inventory_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'inventory_id' => 'Inventory',
            'company_id' => 'Company',
            'sku_id' => 'Sku',
            'qty' => 'Qty',
            'uom_id' => 'Uom',
            'zone_id' => 'Zone',
            'sku_status_id' => 'Sku Status',
            'transaction_date' => 'Transaction Date',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'expiration_date' => 'Expiration Date',
            'reference_no' => 'Reference No',
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

        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('zone_id', $this->zone_id, true);
        $criteria->compare('sku_status_id', $this->sku_status_id, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('reference_no', $this->reference_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

//            case 0:
//                $sort_column = 'inventory_id';
//                break;

            case 0:
                $sort_column = 'sku_id';
                break;

            case 1:
                $sort_column = 'qty';
                break;

            case 2:
                $sort_column = 'uom_id';
                break;

            case 3:
                $sort_column = 'zone_id';
                break;

            case 4:
                $sort_column = 'sku_status_id';
                break;

            case 5:
                $sort_column = 'transaction_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
//        $criteria->compare('inventory_id', $columns[0]['search']['value']);
        $criteria->compare('sku_id', $columns[0]['search']['value'], true);
        $criteria->compare('qty', $columns[1]['search']['value']);
        $criteria->compare('uom_id', $columns[2]['search']['value'], true);
        $criteria->compare('zone_id', $columns[3]['search']['value'], true);
        $criteria->compare('sku_status_id', $columns[4]['search']['value'], true);
        $criteria->compare('transaction_date', $columns[5]['search']['value'], true);
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
     * @return Inventory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function increase($company_id,$inventory_id,$qty,$transaction_date,$cost_per_unit){
        $model = Inventory::model()->findByAttributes(array('inventory_id' => $inventory_id, 'company_id' => $company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        $model->qty = bcadd($model->qty, $qty);
        $model->transaction_date = $transaction_date;
        $model->cost_per_unit = $cost_per_unit;
        
        if($model->validate()){
            
            try {
                
                $model->save();
                
                //InventoryHistory::model()->createHistory($company_id, $inventory_id, $qty, $model->qty, self::INVENTORY_ACTION_TYPE_INCREASE, $cost_per_unit);
                
                return true;
                
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }

            
        }
        
        return false;
        
    }
    
    public function decrease($company_id,$inventory_id,$qty,$transaction_date){
        $model = Inventory::model()->findByAttributes(array('inventory_id' => $inventory_id, 'company_id' => $company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        $model->qty = bcsub($model->qty, $qty);
        $model->transaction_date = $transaction_date;
        
        if($model->validate()){
            try {
                
                $model->save();
                $qty = $qty * -1;
                //InventoryHistory::model()->createHistory($company_id, $inventory_id, $qty, $model->qty, self::INVENTORY_ACTION_TYPE_DECREASE, 0);
                
                return true;
                
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }
        }
        
        return false;
            
    }
    
    public function move($company_id,$inventory_id,$move_qty,$move_to_zone,$move_status,$transaction_date){
        $model = Inventory::model()->findByAttributes(array('inventory_id' => $inventory_id, 'company_id' => $company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        
        $move = new Inventory;
        $move->company_id = $company_id;
        $move->qty = $move_qty;
        $move->zone_id = $move_to_zone;
        $move->sku_status_id = $move_status;
        $move->transaction_date = $transaction_date;
        $move->sku_id = $model->sku_id;
        $move->uom_id = $model->uom_id;
        
        if($move->validate()){
            try {
                
                $move->save();
                $qty = bcsub($model->qty, $move_qty);
                $move_qty = $move_qty * -1;
                
                $model->qty = $qty;
                $model->save();
                
                //InventoryHistory::model()->createHistory($company_id, $inventory_id, $move_qty, $qty, self::INVENTORY_ACTION_TYPE_MOVE);
                
                return true;
                
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }
        }
        
        return false;
            
    }
    
    
}
