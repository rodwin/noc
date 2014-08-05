<?php

class InventoryTest extends CDbTestCase
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
        
        public function testCreate(){

            $data = array(
		'company_id'=>'166374e5-cffe-42c6-95b3-41590826effd',
		'sku_id'=>'sku_id',
		'cost_per_unit'=>5.00,
		'qty'=>100,
		'uom_id'=>'pc(s)',
		'zone_id'=>'zone1',
		'sku_status_id'=>'in-stock',
		'transaction_date'=>date('Y-m-d'),
		'expiration_date'=>null,
		'reference_no'=>null,
            );
            
            $this->assertTrue(Inventory::model()->create($data));
            
        }
        
        public function testCreateExisting(){
            
            $data = array(
                    'company_id'=>'166374e5-cffe-42c6-95b3-41590826effd',
                    'sku_id'=>'sku_id',
                    'cost_per_unit'=>5.00,
                    'qty'=>1000,
                    'uom_id'=>'pc(s)',
                    'zone_id'=>'zone1',
                    'sku_status_id'=>'in-stock',
                    'transaction_date'=>date('Y-m-d'),
                    'expiration_date'=>null,
                    'reference_no'=>null,
            );
            $this->assertTrue(Inventory::model()->create($data));
            
            $inventory = Inventory::model()->findByAttributes(
                array(
                    'company_id'=> $data['company_id'],
                    'sku_id'=> $data['sku_id'],
                    'uom_id'=> $data['uom_id'],
                    'zone_id'=> $data['zone_id'],
                    'sku_status_id'=> $data['sku_status_id'],
                    )
                );
            
            $this->assertEquals($inventory->qty,1100);
            
        }
        
        public function testIncrease(){
            
            $ret = Inventory::model()->increase($this->company->company_id, 999999, 1000, date('Y-m-d'), 5.00);
            
            $this->assertTrue($ret);
            
            $inventory = Inventory::model()->findByPk(999999);
            
            $this->assertEquals($inventory->qty, 1100);
            
        }
        
        public function testDecrease(){
            
            $ret = Inventory::model()->decrease($this->company->company_id, 999999, 100, date('Y-m-d'));
            
            $this->assertTrue($ret);
            
            $inventory = Inventory::model()->findByPk(999999);
            
            $this->assertEquals($inventory->qty, 0);
        }
        
        public function testMove(){
            
            $ret = Inventory::model()->move($this->company->company_id, 999999, 50,'zone2','bad' ,date('Y-m-d'));
            $this->assertTrue($ret);
            
            $inventory = Inventory::model()->findByPk(999999);
            $this->assertEquals($inventory->qty, 50);
            
            $inventory = Inventory::model()->findByAttributes(
                array(
                    'company_id'=> $this->company->company_id,
                    'sku_id'=> 'sku_id',
                    'uom_id'=> 'pc(s)',
                    'zone_id'=> 'zone2',
                    'sku_status_id'=> 'bad',
                    )
                );
            
            $this->assertEquals($inventory->qty, 50);
        }
        
        public function testCovert(){
            $this->markTestIncomplete(
                'This test has not been implemented yet.'
              );
        }
        
        public function testUpdateStatus(){
            $this->markTestIncomplete(
                'This test has not been implemented yet.'
              );
        }
        
        public function testApply(){
            $this->markTestIncomplete(
                'This test has not been implemented yet.'
              );
        }
        
}
