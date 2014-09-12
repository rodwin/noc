<?php

class IncreaseTest extends CDbTestCase
{
        public $fixtures=array(
		'sku'=>'Sku',
		'uom'=>'Uom',
		'zone'=>'Zone',
		'skustatus'=>'SkuStatus',
                'inventory'=> 'Inventory',
                'inventory_history'=> 'InventoryHistory',
	);
        
        public $company;
        
        protected function setUp()
        {
            $this->company = Company::model()->findByAttributes(array('code'=>'vlink'));
            parent::setUp();
        }
        
        public function testIncreaseWithInvalidData(){

            $data = array(
                        'inventory_id'=>'',
			'qty'=>'Quantity',
			'transaction_date'=>'Transaction Date',
		);
            
            $model = new IncreaseInventoryForm();
            $model->attributes = $data;
            $model->validate();
            $errors = $model->getErrors();
            
            $this->assertTrue(isset($errors['inventory_id']));
            $this->assertTrue(isset($errors['qty']));
            $this->assertTrue(isset($errors['transaction_date']));
            
        }
        
        public function testIncreaseWithValidData(){

            $data = array(
                        'inventory_id'=>999999,
			'qty'=>100,
			'transaction_date'=>date('Y-m-d'),
			'created_by'=>'rodwin'
		);
            
            $model = new IncreaseInventoryForm();
            $model->attributes = $data;
//            $model->validate();
//            pre($model->getErrors());
            $this->assertTrue($model->increase());
            
            $inventoryObj = Inventory::model()->findBypk(999999);
            
            $this->assertTrue($inventoryObj instanceof Inventory);
            $this->assertEquals(200,$inventoryObj->qty);
            
        }
        
}
