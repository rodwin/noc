<?php

class CreateInventoryForm extends CFormModel
{
        public $company_id;
	public $sku_id;
        public $qty;
	public $default_uom_id;
	public $default_zone_id;
	public $transaction_date;
	public $cost_per_unit;
        public $sku_status_id;
        public $unique_tag;
        public $unique_date;
        


        /**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('sku_id,company_id,qty,default_uom_id,default_zone_id,transaction_date', 'required'),
                        
                        array('unique_tag', 'length', 'max' => 150),
                    
			array('sku_id', 'isValidSku'),
                    
                        array('default_uom_id', 'isValidUOM'),
                        array('default_zone_id', 'isValidZone'),
                        array('sku_status_id', 'isValidStatus'),
                    
                        array('cost_per_unit', 'length', 'max' => 18),
                        array('cost_per_unit', 'match', 'pattern'=>'/^[0-9]{1,9}(\.[0-9]{0,3})?$/'),
                    
                        array('unique_date,transaction_date', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
                    
			array('qty', 'numerical', 'integerOnly' => true,'max'=>9999999,'min'=> 0),
		);
	}
        
        public function isValidSku($attribute)
        {
            $model = Sku::model()->findbypk($this->$attribute);

            if (!Validator::isResultSetWithRows($model)) {
                $this->addError($attribute, 'Sku is invalid');
            }

            return;
        }
        
        public function isValidStatus($attribute)
        {
            if($this->$attribute == null){
                return;
            }
            $model = SkuStatus::model()->findbypk($this->$attribute);

            if (!Validator::isResultSetWithRows($model)) {
                $this->addError($attribute, 'Status is invalid');
            }

            return;
        }
        
        public function isValidZone($attribute)
        {
            $model = Zone::model()->findByPk($this->$attribute);

            if (!Validator::isResultSetWithRows($model)) {
                $this->addError($attribute, 'Zone is invalid');
            }

            return;
        }
        
        public function isValidUOM($attribute)
        {
            $model = Uom::model()->findByPk($this->$attribute);

            if (!Validator::isResultSetWithRows($model)) {
                $this->addError($attribute, 'UOM is invalid');
            }

            return;
        }
        
        public function beforeValidate() {
            
            if($this->default_uom_id == ""){
                $this->default_uom_id = null;
            }

            if($this->default_zone_id == ""){
                $this->default_zone_id = null;
            }

            if($this->cost_per_unit == ""){
                $this->cost_per_unit = 0;
            }
            
            if($this->sku_status_id == ""){
                $this->sku_status_id = null;
            }
            
            if($this->qty == ""){
                $this->qty = 0;
            }

            return parent::beforeValidate();
        }

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'sku_id'=>'Sku Code',
			'qty'=>'Quantity',
			'default_uom_id'=>'Unit of Measure',
			'default_zone_id'=>'Zone',
			'transaction_date'=>'Transaction Date',
			'cost_per_unit'=>'Cost per Unit',
			'sku_status_id'=>'Status',
			'unique_tag'=>'Unique Tag',
			'unique_date'=>'Unique Date',
		);
	}
        
        public function create() {
             
            $qty = 0;
            
            $inventoryObj = Inventory::model()->findByAttributes(
                array(
                    'company_id'=> $this->company_id,
                    'sku_id'=> $this->sku_id,
                    'uom_id'=> $this->default_uom_id,
                    'zone_id'=> $this->default_zone_id,
                    'sku_status_id'=> $this->sku_status_id,
                    )
                );
            
            if($inventoryObj){
                $inventory = $inventoryObj;
                $qty = $this->qty + $inventory->qty;
            }else{
                $inventory = new Inventory();
                $qty = $this->qty;
            }
            
            $transaction = $inventory->dbConnection->beginTransaction(); // Transaction begin
                
            try {
                
                $inventory_data = array(
                    'sku_id'=>$this->sku_id,
                    'company_id'=>$this->company_id,
                    'qty'=>$qty,
                    'uom_id'=>$this->default_uom_id,
                    'zone_id'=>$this->default_zone_id,
                    'sku_status_id'=>$this->sku_status_id,
                    'transaction_date'=>$this->transaction_date,
                    'expiration_date'=>$this->unique_date,
                    'reference_no'=>$this->unique_tag,
                );
                
                $inventory->attributes = $inventory_data;
                $inventory->save(false);
            
                $transaction->commit();
                return true;
                
            } catch (Exception $exc) {
                Yii::log($exc->getTraceAsString(), 'error');
                $transaction->rollBack();
                return false;
            }
                  
        }

	
}