<?php
class Dtd extends CFormModel {

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
    * @var string team
    * @soap
    */
    public $team;
    
    
    
    
    
    public function attributeLabels()
    {
            return array(
                    'agency'=>'Agency',
                    'region'=>'Region',
                    'province'=>'Province',
                    'month'=>'Month',
                    'quarter'=>'Quarter',
                    'brand'=>'Brand',
                    'teamlead'=>'Teamlead',
                    'year'=>'Year',
                    'team'=>'Team',

            );
    }
    
   
    public function getAllAgency() {


      $sql ="SELECT *
                FROM [pg_mapping].[dbo].[agency] ";
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
                where team_leader = 1
                order by code";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data; 
    }
    
    public function getRoute($from,$to,$brand,$agency,$region)
    {
           if($region==0){
               $region = '';
               $select = 'e.name';
           }else{
               $region = 'and e.id='.$region;
               $select = 'd.name';
           }

           if($brand != 0){
               $brand = 'and a.brand_id ='.$brand;
           }else{
               $brand= '';
           }
        $sql ="SELECT a.id,$select,f.seller,
                (
                SELECT count(salesman_id) as salesman
                FROM [pg_mapping].[dbo].[salesman_route_transaction] 
                where route_id  = a.id
                ) as salesman
                FROM [pg_mapping].[dbo].[route] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                inner join [pg_mapping].[dbo].[municipal] c on c.id =a.municipal_id
                inner join [pg_mapping].[dbo].[province] d on d.id = c.province_id
                inner join [pg_mapping].[dbo].[region] e on e.id = d.region_id
                inner join [pg_mapping].[dbo].[brand_target] f on f.brand_id = a.brand_id
                --where date between  '2013-11-01' and '2014-11-30'
                where date between '$from' and '$to' $brand and b.agency_id = $agency $region
                order by $select
            ";
//        pr($sql);
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();


        return $data; 
    }
    
    public function getActualAttendance($str)
    {
        $sql = "SELECT route_id,count(salesman_id) as salesman
                FROM [pg_mapping].[dbo].[salesman_route_transaction] 
                where route_id in ($str)
                group by route_id";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();
        return $data; 
    }
    
    public function getActualHit($from,$to,$brand,$agency)
    {
        $sql ="SELECT e.name,count(h.id) as hit
                FROM [pg_mapping].[dbo].[route] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                inner join [pg_mapping].[dbo].[municipal] c on c.id =a.municipal_id
                inner join [pg_mapping].[dbo].[province] d on d.id = c.province_id
                inner join [pg_mapping].[dbo].[region] e on e.id = d.region_id
                inner join [pg_mapping].[dbo].[route_transaction] f on f.route_id = a.id
                inner join [pg_mapping].[dbo].[route_transaction_detail] g on g.route_transaction_id = f.id
                inner join [pg_mapping].[dbo].nextgen_sales_order h on h.route_transaction_detail_id = g.id
                where date between '$from' and '$to' and a.brand_id = $brand and b.agency_id = $agency and h.transaction_type = 3
                group by e.name
                order by e.name";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();
        return $data; 
    }
    
    public function getTargetHit($from,$to,$brand,$agency)
    {
        $sql ="SELECT e.name,sum(f.hit * f.seller) as target_hit,sum(f.seller) as target_attendance
                FROM [pg_mapping].[dbo].[route] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                inner join [pg_mapping].[dbo].[municipal] c on c.id =a.municipal_id
                inner join [pg_mapping].[dbo].[province] d on d.id = c.province_id
                inner join [pg_mapping].[dbo].[region] e on e.id = d.region_id
                inner join [pg_mapping].[dbo].[brand_target] f on f.brand_id = a.brand_id
                --where date between  '2013-11-01' and '2014-11-30'
                where date between '$from' and '$to' and a.brand_id = $brand and b.agency_id = $agency
                group by e.name
                order by e.name";
//        pr($sql);
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();
        return $data; 
    }
    
    public function getParPerArea($from,$to,$brand,$agency)
    {
        $sql ="SELECT e.name,f.seller * count(a.id) as par
                FROM [pg_mapping].[dbo].[route] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                inner join [pg_mapping].[dbo].[municipal] c on c.id =a.municipal_id
                inner join [pg_mapping].[dbo].[province] d on d.id = c.province_id
                inner join [pg_mapping].[dbo].[region] e on e.id = d.region_id
                inner join [pg_mapping].[dbo].[brand_target] f on f.brand_id = a.brand_id
                where date between '$from' and '$to' and a.brand_id = $brand and b.agency_id = $agency
                group by e.name,f.seller
                order by e.name";
//        pr($sql);
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();
        return $data; 
    }
    
    public function getRoutePerQuarter($from,$to,$brand,$agency)
    {
        if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
        }else{
           $brand= '';
        }
        
        $sql ="SELECT a.date,f.seller,f.hit
                FROM [pg_mapping].[dbo].[route] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                inner join [pg_mapping].[dbo].[brand_target] f on f.brand_id = a.brand_id
                where date between '$from' and '$to' $brand and b.agency_id = $agency
                order by a.date asc";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();
        return $data; 
    }
    
    public function getActualHitperQuarter($from,$to,$brand,$agency,$trans_type)
    {
        if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
        }else{
           $brand= '';
        }
        
        $sql = "SELECT a.date,count(h.id) as hit
                FROM [pg_mapping].[dbo].[route] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                inner join [pg_mapping].[dbo].[route_transaction] f on f.route_id = a.id
                inner join [pg_mapping].[dbo].[route_transaction_detail] g on g.route_transaction_id = f.id
                inner join [pg_mapping].[dbo].nextgen_sales_order h on h.route_transaction_detail_id = g.id
                where date between '$from' and '$to' $brand and b.agency_id = $agency and h.transaction_type = $trans_type
                group by a.date
                order by a.date asc
                ";
//        pr($sql);
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();
        return $data; 
    }
    
    public function getParTotalNational($agency,$from,$to,$brand,$year)
    {

        $current_date = date('Y-m-d');
        $given_date = date('Y-m-d',strtotime($to));


        if($given_date > $current_date){

                $to = date($year.'-m-d');

        }else{
             $to = $to;
        }
                  
       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
           $sql ="SELECT a.date,f.seller 
                    FROM [pg_mapping].[dbo].[route] a
                    inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                    inner join [pg_mapping].[dbo].[brand_target] f on f.brand_id = a.brand_id
                    where date between '$from' and '$to'  $brand and b.agency_id = $agency
                    order by a.date asc
                ";

          $command = Yii::app()->db3->createCommand($sql);
          $data = $command->queryAll();


          return $data;
    }
    public function getTeamPerAgency($agency)
    {
        $sql = "SELECT a.*
                FROM [pg_mapping].[dbo].[team] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.id
                where b.agency_id = $agency
                order by a.name";
//        pr()
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();
         return $data;
        
    }
    
    public function getTlPerTeam($team_id)
    {
        $sql = "SELECT *
                from [pg_mapping].[dbo].[salesman]
                where team_id = $team_id and team_leader = 1
                order by salesman_code";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();

        return $data;
        
    }
    
    
    public function getSellerPerTL($team_leader_id)
    {
        $sql = "SELECT *
                from [pg_mapping].[dbo].[salesman]
                where parent_leader = $team_leader_id and team_leader = 0";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();

        return $data;
    }
    
    public function getTargetPerTL($month,$team,$year,$brand)
    {

        $date1 = date($year.'-'.$month.'-01');
        $to = date($year.'-m-t',strtotime($date1));
        $from = date($year.'-'.$month.'-01');
        
        
        $sql = "SELECT a.id,f.hit
            FROM [pg_mapping].[dbo].[route] a
            inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
            inner join [pg_mapping].[dbo].[brand_target] f on f.brand_id = a.brand_id
            where a.team_id = $team and a.date between '$from' and '$to' and a.brand_id = $brand
            ";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();

        return $data;
    }
    
     public function getParTargetPerTL($month,$team,$year,$brand)
    {
        
        $current_month = date('m');
        if($month == $current_month){
          $date1 = date($year.'-'.$month.'-d');
          $to = date($year.'-m-d',strtotime($date1)); 
        }else{
          $date1 = date($year.'-'.$month.'-01');
          $to = date($year.'-m-t',strtotime($date1));
        }

        $from = date($year.'-'.$month.'-01');

        
        $sql = "SELECT a.id,f.hit
            FROM [pg_mapping].[dbo].[route] a
            inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
            inner join [pg_mapping].[dbo].[brand_target] f on f.brand_id = a.brand_id
            where a.team_id = $team and a.date between '$from' and '$to' and a.brand_id = $brand
            ";
 
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();

        return $data;
    }
    
    public function getSellerHitPerTl($seller,$month,$brand,$agency,$year)
    {
        $current_month = date('m');
        if($month == $current_month ){
          $date1 = date($year.'-'.$month.'-d');
          $to = date($year.'-m-d',strtotime($date1)); 
        }else{
          $date1 = date($year.'-'.$month.'-01');
          $to = date($year.'-m-t',strtotime($date1));
        }
        $from = date($year.'-'.$month.'-01');
        
        if($brand != 0){
            $brand = 'and a.brand_id ='.$brand;
        }else{
            $brand= '';
        }
        
        $sql = "SELECT h.seller_code,count(h.id) as hit
                FROM [pg_mapping].[dbo].[route] a
                inner join [pg_mapping].[dbo].[agency_team] b on b.team_id = a.team_id
                inner join [pg_mapping].[dbo].[route_transaction] f on f.route_id = a.id
                inner join [pg_mapping].[dbo].[route_transaction_detail] g on g.route_transaction_id = f.id
                inner join [pg_mapping].[dbo].nextgen_sales_order h on h.route_transaction_detail_id = g.id
                where date between '$from' and '$to' $brand and b.agency_id = $agency and h.transaction_type = 3
                and h.seller_code in ($seller)
                group by h.seller_code
                order by h.seller_code asc";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();

        return $data;
    }
    
    
    public function getActualAttendancePerSeller($route,$salesman)
    {
        $sql = "
            SELECT b.salesman_code,b.id,count(a.route_id) as attendance
            FROM [pg_mapping].[dbo].[salesman_route_transaction] a
            inner join [pg_mapping].[dbo].[salesman]  b on b.id = a.salesman_id
            where route_id in ($route) and salesman_id in ($salesman)
            group by b.salesman_code,b.id";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();

        return $data;
    }
    


}
?>
