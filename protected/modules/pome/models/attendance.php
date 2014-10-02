<?php

class Attendance extends CFormModel {

    /**
    * @var string agency
    * @soap
    */
    public $agency;

    /**
    * @var string region
    * @soap
    */
    public $region;
    
     /**
    * @var string province
    * @soap
    */
    public $province;
    
     /**
    * @var string region_id
    * @soap
    */
    public $region_id;
    
     /**
    * @var string month
    * @soap
    */
    public $month;
    
      /**
    * @var string ph
    * @soap
    */
    public $ph;
    
        /**
    * @var string quarter
    * @soap
    */
    public $quarter;
    
    /**
    * @var string brand
    * @soap
    */
    public $brand;
    
    /**
    * @var string teamlead
    * @soap
    */
    public $teamlead;
    
    
    
    
    public function attributeLabels()
    {
            return array(
                    'agency'=>'Agency',
                    'region'=>'Region',
                    'province'=>'Province',
                    'month'=>'Month',
                    'ph'=>'ph',
                    'quarter'=>'quarter',
                    'brand'=>'brand',
                    'teamlead'=>'teamlead',

            );
    }
    
   
    public function getAllAgency() {


      $sql ="SELECT *
                FROM [pg_mapping].[dbo].[agency] where id = 6 ";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data;
    }
    
     public function getAllBrand() {


      $sql ="SELECT *
                FROM [pg_mapping].[dbo].[brand] ";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data;
    }
    
    public function getAllRegion() {


      $sql ="SELECT *
                FROM [pg_mapping].[dbo].[region] ";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data;
    }
    
    public function getProvincebyRegionid($id)
    {
        $sql ="SELECT *
                FROM [pg_mapping].[dbo].[province]
                where region_id = $id";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data; 
    }
    
    public function getAllBwsTeam()
    {
        $sql =" SELECT *
                FROM [pg_mapping].[dbo].[pome_pps]
                where team_leader = 1";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data; 
    }
    


}