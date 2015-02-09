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
    /**
    * @var string year
    * @soap
    */
    public $year;
    
    /**
    * @var string year
    * @soap
    */
    public $project;
    
    
    
    
    public function attributeLabels()
    {
            return array(
                    'agency'=>'Agency',
                    'region'=>'Region',
                    'province'=>'Province',
                    'month'=>'Month',
                    'ph'=>'Ph',
                    'quarter'=>'Quarter',
                    'brand'=>'Brand',
                    'teamlead'=>'Teamlead',
                    'year'=>'Year',
                    'project'=>'Project',

            );
    }
    
   
    public function getAllAgency($agency) 
    {
        if($agency == 0){
            $agency = 'id in (6,9)';
        }else{
            $agency = 'id='.$agency;
        }
        
      $sql ="SELECT *
                FROM [pg_mapping].[dbo].[agency] where $agency ";
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
    
    public function getAllBwsTeam($agency)
    {
        $sql =" SELECT *
                FROM [pg_mapping].[dbo].[pome_pps]                
                where team_leader = 1 and agency_id = $agency
                order by code";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data; 
    }
    
    public function getAllTeamSchool($agency)
    {
        $sql =" SELECT b.name as teamCode,b.id
                FROM [pg_mapping].[dbo].[agency_team] a
                inner join [pg_mapping].[dbo].[team] b on b.id = a.team_id
                where a.agency_id = $agency
                order by b.teamCode";
//        pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data; 
    }
    


}