<?php

class CreateTest extends CDbTestCase
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
        
        public function testCreateWithInvalidData(){

            $data = array(
                        'company_id'=>'',
                        'sku_id'=>'',
			'qty'=>'Quantity',
			'default_uom_id'=>'Unit of Measure',
			'default_zone_id'=>'Zone',
			'transaction_date'=>'Transaction Date',
			'cost_per_unit'=>'Cost per Unit',
			'sku_status_id'=>'Status',
			'unique_tag'=>'Unique Tag',
			'unique_date'=>'Unique Date',
		);
            
            $model = new CreateInventoryForm();
            $model->attributes = $data;
            $model->validate();
            $errors = $model->getErrors();
            
            $this->assertTrue(isset($errors['company_id']));
            $this->assertTrue(isset($errors['sku_id']));
            $this->assertTrue(isset($errors['qty']));
            $this->assertTrue(isset($errors['default_uom_id']));
            $this->assertTrue(isset($errors['default_zone_id']));
            $this->assertTrue(isset($errors['transaction_date']));
            $this->assertTrue(isset($errors['cost_per_unit']));
            $this->assertTrue(isset($errors['sku_status_id']));
            $this->assertTrue(isset($errors['unique_date']));
            
            $data['default_uom_id'] = null;
            $data['default_zone_id'] = null;
            $model->validate();
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['default_uom_id']));
            $this->assertTrue(isset($errors['default_zone_id']));
            
        }
        
        public function testCreateWithMinimumValidData(){

            $data = array(
                        'company_id'=>$this->company->company_id,
                        'sku_id'=>  'sku_id',
			'qty'=>1,
			'default_uom_id'=>'pc(s)',
			'default_zone_id'=>'zone1',
			'transaction_date'=>date('Y-m-d'),
			'cost_per_unit'=>null,
			'sku_status_id'=>null,
			'unique_tag'=>null,
			'unique_date'=>null,
		);
            
            $model = new CreateInventoryForm();
            $model->attributes = $data;
            $this->assertTrue($model->validate());
            $this->assertTrue($model->create());
            
        }
        
        public function testCreateWithExistingInventory(){

            $data = array(
                        'company_id'=>$this->company->company_id,
                        'sku_id'=>  'sku_id',
			'qty'=>100,
			'default_uom_id'=>'pc(s)',
			'default_zone_id'=>'zone1',
			'transaction_date'=>date('Y-m-d'),
			'cost_per_unit'=>null,
			'sku_status_id'=>'in-stock',
			'unique_tag'=>null,
			'unique_date'=>null,
		);
            
            $model = new CreateInventoryForm();
            $model->attributes = $data;
            $this->assertTrue($model->validate());
            $this->assertTrue($model->create());
            
            $inventoryObj = Inventory::model()->findByAttributes(
                array(
                    'company_id'=> $data['company_id'],
                    'sku_id'=> $data['sku_id'],
                    'uom_id'=> $data['default_uom_id'],
                    'zone_id'=> $data['default_zone_id'],
                    'sku_status_id'=> $data['sku_status_id'],
                    )
                );
            
            $this->assertTrue($inventoryObj instanceof Inventory);
            $this->assertEquals(200,$inventoryObj->qty);
            
        }
        
        
        
}
