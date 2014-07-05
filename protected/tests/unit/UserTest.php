<?php

class UserTest extends CDbTestCase
{
        public $fixtures=array(
		'user'=>'User',
	);
        
        public $company;
        
        protected function setUp()
        {
            $this->company = Company::model()->findByAttributes(array('code'=>'vlink'));
            parent::setUp();
        }
        
        public function testLogin(){
            
            $model=new LoginForm();
            $model->attributes= array(
                    'username'=>'rodwin',
                    'password'=>'winrod',
                    'company'=>'vlink',
            );

            $this->assertTrue($model->validate());
            
            $model->attributes= array(
                    'username'=>'rodwin',
                    'password'=>'winrod',
                    'company'=>'not exisiting company',
            );
            
            $this->assertFalse($model->validate());
            
        }
        
        public function testCreateuser(){
            
            $data = array(
                    'user_id'=>  Globals::generateV4UUID(),
                    'company_id'=>  $this->company->company_id,
                    'user_type_id'=>'none',
                    'user_name'=>'rodwin'.Globals::generateRandomString('5'),
//                    'user_name'=>'rodwintest',
                    'password'=>'winrod1',
                    'password2'=>'winrod1',
                    'status'=>'1',
                    'first_name'=>'rodwin1',
                    'last_name'=>'lising1',
                    'email'=>'rblising@vitalink.com.ph',
                    'created_by'=>'rodwin',
            );
            $model = new User();
            $model->attributes = $data;
            unset($model->created_date);
            
            $this->assertTrue($model->save());
        }
        
        public function testUpdateUser(){
            
            
            $data = array(
                    'user_type_id'=>'test',
                    'user_name'=>'rodwin_test',
                    'password'=>'winrod_test',
                    'password2'=>'winrod_test',
                    'status'=>'0',
                    'first_name'=>'rodwin_test_update',
                    'last_name'=>'lising_test_update',
                    'email'=>'rodwinlising@gmail.com',
                    'updated_by'=>'rodwin',
                    'updated_date'=>date('Y-m-d H:i:s'),
            );
            
            
            $model = User::model()->findByAttributes(array('company_id'=>$this->company->company_id,'user_name'=>'rodwintest'));
            $model->attributes = $data;
            $model->save();
            
            $model = User::model()->findByPk($model->user_id);
                    
            $this->assertEquals($model->user_type_id,'test');
            $this->assertEquals($model->user_name,'rodwin_test');
            $this->assertTrue(CPasswordHelper::verifyPassword('winrod_test', $model->password));
            $this->assertEquals($model->status,0);
            $this->assertEquals($model->first_name,'rodwin_test_update');
            $this->assertEquals($model->last_name,'lising_test_update');
            $this->assertEquals($model->email,'rodwinlising@gmail.com');
        }
        
        public function testDeleteUser(){
            
            $model = User::model()->findByAttributes(array('company_id'=>$this->company->company_id,'user_name'=>'anothertest'));
            $this->assertTrue($model->delete());
            
        }
        
}
