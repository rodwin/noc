<?php

class SKUtest extends CDbTestCase
{
        public $fixtures=array(
		'sku'=>'Sku',
		'uom'=>'Uom',
		'zone'=>'Zone',
	);
        
        public $company;
        
        protected function setUp()
        {
            $this->company = Company::model()->findByAttributes(array('code'=>'vlink'));
            parent::setUp();
        }
        
        public function testUnique(){
            
            //data with invalid sku_code
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code',
		'brand_id'=>null,
		'sku_name'=>'sku_name',
		'description'=>null,
		'default_uom_id'=>null,
		'default_unit_price'=>null,
		'type'=>null,
		'default_zone_id'=>null,
		'supplier'=>null,
		'low_qty_threshold'=>0,
		'high_qty_threshold'=>0,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['sku_code'][0]));
        }
        
        public function testInvalidUOM(){
            
            //data with invalid uom
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'rodwin',
		'sku_name'=>'sku_name',
		'description'=>null,
		'default_uom_id'=>'test',
		'default_unit_price'=>null,
		'type'=>null,
		'default_zone_id'=>null,
		'supplier'=>null,
		'low_qty_threshold'=>0,
		'high_qty_threshold'=>0,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['default_uom_id'][0]));
        }
        
        public function testInvalidZone(){
            
            //data with invalid zone
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'rodwin',
		'sku_name'=>'sku_name',
		'description'=>null,
		'default_uom_id'=>null,
		'default_unit_price'=>null,
		'type'=>null,
		'default_zone_id'=>'invaidzone',
		'supplier'=>null,
		'low_qty_threshold'=>0,
		'high_qty_threshold'=>0,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['default_zone_id'][0]));
        }
        
        public function testThresholdAndUnitPrice(){
            
            //data with invalid threshold
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'rodwin',
		'sku_name'=>'sku_name',
		'description'=>null,
		'default_uom_id'=>null,
		'default_unit_price'=>'default_unit_price',
		'type'=>null,
		'default_zone_id'=>'invaidzone',
		'supplier'=>null,
		'low_qty_threshold'=>'low_qty_threshold',
		'high_qty_threshold'=>'high_qty_threshold',
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['low_qty_threshold'][0]));
            $this->assertTrue(isset($errors['default_unit_price'][0]));
            $this->assertTrue(isset($errors['high_qty_threshold'][0]));
            
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'rodwin',
		'sku_name'=>'sku_name',
		'description'=>null,
		'default_uom_id'=>null,
		'default_unit_price'=>9999999999999999999999999,
		'type'=>null,
		'default_zone_id'=>'invaidzone',
		'supplier'=>null,
		'low_qty_threshold'=>-1,
		'high_qty_threshold'=>9999999999999999,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['low_qty_threshold'][0]));
            $this->assertTrue(isset($errors['default_unit_price'][0]));
            $this->assertTrue(isset($errors['high_qty_threshold'][0]));
        }
        
        public function testBrand(){
            
            //data with invalid brand
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'test',
		'sku_name'=>'sku_name',
		'description'=>null,
		'default_uom_id'=>null,
		'default_unit_price'=>null,
		'type'=>null,
		'default_zone_id'=>null,
		'supplier'=>null,
		'low_qty_threshold'=>0,
		'high_qty_threshold'=>0,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['brand_id'][0]));
        }
        
        public function testNameAndDescription(){
            
            //data with long name
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'rodwin',
		'sku_name'=>'sku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_namesku_name',
		'description'=>null,
		'default_uom_id'=>null,
		'default_unit_price'=>null,
		'type'=>null,
		'default_zone_id'=>null,
		'supplier'=>null,
		'low_qty_threshold'=>0,
		'high_qty_threshold'=>0,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['sku_name']));
            
            //data with invalid name
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'rodwin',
		'description'=>null,
		'default_uom_id'=>null,
		'default_unit_price'=>null,
		'type'=>null,
		'default_zone_id'=>null,
		'supplier'=>null,
		'low_qty_threshold'=>0,
		'high_qty_threshold'=>0,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['sku_name']));
            
            //data with invalid desc
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code123',
		'brand_id'=>'rodwin',
                'sku_name'=>'sku_name',
		'description'=>'descriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescription',
		'default_uom_id'=>null,
		'default_unit_price'=>null,
		'type'=>null,
		'default_zone_id'=>null,
		'supplier'=>null,
		'low_qty_threshold'=>0,
		'high_qty_threshold'=>0,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertFalse($model->validate());
            $errors = $model->getErrors();
            $this->assertTrue(isset($errors['description']));
        }
        
        public function testSave(){
            
            //data with invalid sku_code
            $data = array(
		'sku_id'=>Globals::generateV4UUID(),
		'company_id'=>$this->company->company_id,
		'sku_code'=>'sku_code1',
		'brand_id'=>'brand_id',
		'sku_name'=>'sku_name1',
		'description'=>'description',
		'default_uom_id'=>'carton(s)',
		'default_unit_price'=>100.54,
		'type'=>  Sku::TYPE_CONSUMABLE,
		'default_zone_id'=>'zone1',
		'supplier'=>'supplier',
		'low_qty_threshold'=>10,
		'high_qty_threshold'=>1000,
            );
            
            $model = new Sku;
            $model->attributes = $data;
            $this->assertTrue($model->save());
            
        }
}
