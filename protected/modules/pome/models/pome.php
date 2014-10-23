<?php

class Pome extends CFormModel {
   
    public function getReasonHalfday($month="",$brand,$year)
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
       
           $sql ="SELECT c.reason_code,a.id
                    FROM [pg_mapping].[dbo].[pome_route] a
                    inner join [pg_mapping].[dbo].[pome_route_transaction] b on b.route_id = a.id
                    inner join [pg_mapping].[dbo].[pome_route_transaction_detail] c on c.pome_route_transaction_id = b.id
                    where a.date between '$from' and '$to'  and c.reason_code = '004' $brand
                    group by c.reason_code,a.id";
//     pr($sql);
     
          $command = Yii::app()->db3->createCommand($sql);
          $data = $command->queryAll();


          return $data;
    }
    
    public function getActualAttendance($month="",$brand,$year)
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
       
           $sql ="SELECT b.reason_code,a.id
                    FROM [pg_mapping].[dbo].[pome_route] a
                    inner join [pg_mapping].[dbo].[pome_route_transaction] b on b.route_id = a.id
                    where a.date between '$from' and '$to' $brand
                    group by b.reason_code,a.id";
     
          $command = Yii::app()->db3->createCommand($sql);
          $data = $command->queryAll();


          return $data;
          
    }
  
   public function getBwsRoute($agency,$region=0,$province=0,$month="",$brand,$year)
   {
       if($region==0){
           $region = '';
           $select = 'g.name';
       }else{
           $region = 'and g.id='.$region;
           $select = 'b.name';
       }
       
       if($province==0){
           $province = '';
           
       }else{
           $province = 'and b.id='.$province;
           
       }
       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
      
//        $current_month = date('m');
//        if($month == $current_month ){
//          $date1 = date($year.'-'.$month.'-d');
//          $to = date($year.'-m-d',strtotime($date1)); 
//        }else{
          $date1 = date($year.'-'.$month.'-01');
          $to = date($year.'-m-t',strtotime($date1));
//        }

         $from = date($year.'-'.$month.'-01');

       
       if($agency != ""){
            $agency = 'and a.agency_id = '.$agency;
        }else{
            $agency = 'and a.agency_id = 6';
        }
      
       $sql ="SELECT d.id,d.pps_id,$select
                FROM  [pg_mapping].[dbo].[pome_route] d               
                inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                inner join [pg_mapping].[dbo].[province] b on b.id = a.province_id
                inner join [pg_mapping].[dbo].[region] g on g.id = b.region_id
                where d.date between '$from' and '$to' $agency  $region $province $brand
                group by d.id,d.pps_id,$select
                order by $select,d.pps_id
                ";
//       pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function getBwsRouteDetailedReach($agency,$region=0,$month="",$brand,$year)
   {
       if($region==0){
           $region = '';
           $select = 'g.name';
       }else{
           $region = 'and g.id='.$region;
           $select = 'b.name';
       }
       
       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }

         $date1 = date($year.'-'.$month.'-01');
         $to = date($year.'-m-t',strtotime($date1));
         $from = date($year.'-'.$month.'-01');

       
       if($agency != ""){
            $agency = 'and a.agency_id = '.$agency;
        }else{
            $agency = 'and a.agency_id = 6';
        }
      
       $sql ="SELECT d.id,d.pps_id,$select
                FROM  [pg_mapping].[dbo].[pome_route] d               
                inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                inner join [pg_mapping].[dbo].[province] b on b.id = a.province_id
                inner join [pg_mapping].[dbo].[region] g on g.id = b.region_id
                where d.date between '$from' and '$to' $agency $region $brand
                group by d.id,d.pps_id,$select
                order by $select,d.pps_id
                ";
//       pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   
   public function getTargetReach($month="",$ph="",$brand,$year)
   {
       $date = date($year.'-'.$month.'-01');
       $date1 = date($year.'-'.$month.'-t',strtotime($date));
       $from = date($year.'-m-d',strtotime($date));
       $to = date($year.'-m-d',strtotime($date1));
      
       if($ph != ""){
           if($ph == 'PH1PLUS'){
               $ph = "PH1+";
           }else{
                $ph = $ph;
           }
       }else{
           $ph = 'PH1';
       }
       
       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
       $sql = " SELECT a.id,a.pps_id,sum(b.reach) as reach
                FROM [pg_mapping].[dbo].[pome_route] a
                inner join [pg_mapping].[dbo].[pome_route_details] b on b.route_id = a.id
                inner join [pg_mapping].[dbo].[outlets] c on c.outlet_id = b.hospital_id
                where a.date between '$from' and '$to' and c.class = '$ph' $brand
           group by a.pps_id,a.id";
//       pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
    public function getParDetailedReach($agency,$region=0,$month="",$brand,$year)
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
         
      if($region==0){
           $region = '';
           $select = 'g.name';
       }else{
           $region = 'and g.id='.$region;
           $select = 'b.name';
       }
       
       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
           $sql ="SELECT count(d.id) as par,$select
                    FROM  [pg_mapping].[dbo].[pome_route] d               
                    inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                    inner join [pg_mapping].[dbo].[province] b on b.id = a.province_id
                    inner join [pg_mapping].[dbo].[region] g on g.id = b.region_id
                    where d.date between '$from' and '$to' and a.agency_id =  $agency $region $brand
                    group by $select
                    order by $select
                ";
//     pr($sql);
     
          $command = Yii::app()->db3->createCommand($sql);
          $data = $command->queryAll();


          return $data;
    }
   
   public function getBwsByAgency($region,$province,$agency="",$brand,$str="")
   {
//        if($month != ""){
//           $date = date('Y-'.$month.'-01');
//           $date1 = date('Y-'.$month.'-t');
//           $from = date('Y-m-d',strtotime($date));
//           $to = date('Y-m-d',strtotime($date1));
//       }else{
//           $from = date('Y-m-01');
//           $to = date('Y-m-t');
//       }
       if($agency == ""){
           $agency = 6;
       }else{
           $agency = $agency;
       }
       
       if($region==0){
           $region = '';
           $select = 'g.name';
       }else{
           $region = 'and g.id='.$region;
           $select = 'b.name';
       }
       
       if($province==0){
           $province = '';
//           $select = 'g.name';
       }else{
           $province = 'and b.id='.$province;
           
       }
       
       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       if($str ==""){
           $str = 0;
       }
       
       $sql = "SELECT d.id,d.pps_id,$select
                FROM  [pg_mapping].[dbo].[pome_route] d 
                inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                inner join [pg_mapping].[dbo].[province] b on b.id = a.province_id
                left join [pg_mapping].[dbo].[region] g on g.id = b.region_id
                where d.id in ($str) and a.agency_id =$agency $region $province $brand
                group by d.id,d.pps_id,$select
                order by $select,d.pps_id
                ";
//   pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
      
   public function getActualReach($month="",$ph="",$str="")
   {

       if($str ==""){
           $str = 0;
       }    
       
       if($ph != ""){
           if($ph == 'PH1PLUS'){
               $ph = "PH1+";
           }else{
                $ph = $ph;
           }
       }else{
           $ph = 'PH1';
       }
      
       
       
       $sql = " SELECT b.route_id,sum(c.reach) as reach
                FROM  [pg_mapping].[dbo].[pome_route_transaction] b 
                inner join [pg_mapping].[dbo].[pome_route_transaction_detail] c on c.pome_route_transaction_id = b.id
                inner join [pg_mapping].[dbo].[outlets] d on d.outlet_id = c.pome_hospital_id
                where  b.route_id in ($str) and d.class ='$ph'
                group by b.route_id
                order by b.route_id";
//pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function GetActualReachQTR($from,$to,$brand)
   {

       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
 
       $sql = " SELECT a.id,c.reach
                FROM [pg_mapping].[dbo].[pome_route] a
                inner join [pg_mapping].[dbo].[pome_route_transaction] b on b.route_id = a.id
                inner join [pg_mapping].[dbo].[pome_route_transaction_detail] c on c.pome_route_transaction_id = b.id
                inner join [pg_mapping].[dbo].[outlets] d on d.outlet_id = c.pome_hospital_id
                where a.date between '$from' and '$to' $brand
                order by a.id";
//       pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function getTargetReachQTR($from,$to,$brand)
   {
       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       $sql = " SELECT a.id,a.pps_id,sum(b.reach) as reach
                FROM [pg_mapping].[dbo].[pome_route] a
                inner join [pg_mapping].[dbo].[pome_route_details] b on b.route_id = a.id
                inner join [pg_mapping].[dbo].[outlets] c on c.outlet_id = b.hospital_id
                where a.date between '$from' and '$to' $brand
                group by a.pps_id,a.id";
//     pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function getBwsByAgencyQTR($agency="",$from,$to,$brand)
   {

       if($agency == ""){
           $agency = 6;
       }else{
           $agency = $agency;
       }
       
       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       $sql = "SELECT d.date,d.id,d.pps_id
                FROM  [pg_mapping].[dbo].[pome_route] d 
                inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                where d.date between '$from' and '$to' and a.agency_id =$agency  $brand
                group by d.date,d.id,d.pps_id
                order by d.date,d.pps_id
                ";
//    pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function getTlBws()
   {
       $sql = "SELECT *
                FROM [pg_mapping].[dbo].[pome_pps]
                where parent_leader = 404 
                ";
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function getTargetReachPerLeader($month,$agency="",$brand="",$teamlead,$ph,$year)
   {
       
       if($month != ""){
           $date = date($year.'-'.$month.'-01');
           $date1 = date($year.'-'.$month.'-t');
           $from = date($year.'-m-d',strtotime($date));
           $to = date($year.'-m-d',strtotime($date1));
       }else{
           $from = date($year.'-m-01');
           $to = date($year.'-m-t');
       }
       
       if($agency == ""){
           $agency = 'and c.agency_id = 6';
       }else{
           $agency = 'and c.agency_id = '.$agency;
       }
       
       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
       if($ph != ""){
           if($ph == 'PH1PLUS'){
               $ph = "PH1+";
           }else{
                $ph = $ph;
           }
       }else{
           $ph = 'PH1';
       }
       
       $sql = "SELECT c.id,a.id as route_id ,sum(b.reach) as reach,c.code
                FROM [pg_mapping].[dbo].[pome_route] a
                inner join [pg_mapping].[dbo].[pome_route_details] b on b.route_id = a.id
                inner join [pg_mapping].[dbo].[pome_pps] c on c.id = a.pps_id
                inner join [pg_mapping].[dbo].[outlets] d on d.outlet_id = b.hospital_id
                where c.parent_leader = $teamlead  and c.team_leader =0 and a.date between '$from' and '$to' and d.class='$ph' $brand $agency
                group by c.id,a.id,c.code
                order by c.id";
//     pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function getActualReachPerLeader($agency="",$brand="",$teamlead,$str,$ph)
   {
    
       
       if($agency == ""){
           $agency = 'and e.agency_id = 6';
       }else{
           $agency = 'and e.agency_id = '.$agency;
       }
       
       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       if($str ==""){
           $str = 0;
       }
       
       if($ph != ""){
           if($ph == 'PH1PLUS'){
               $ph = "PH1+";
           }else{
                $ph = $ph;
           }
       }else{
           $ph = 'PH1';
       }
       
       $sql = "SELECT e.id as pps_id,e.code,sum(c.reach)as actual_reach,b.reason_code,a.id
                FROM [pg_mapping].[dbo].[pome_route] a
                inner join [pg_mapping].[dbo].[pome_route_transaction] b on b.route_id = a.id
                inner join [pg_mapping].[dbo].[pome_route_transaction_detail] c on c.pome_route_transaction_id = b.id
                inner join [pg_mapping].[dbo].[pome_pps] e on e.id = a.pps_id
                inner join [pg_mapping].[dbo].[outlets] f on f.outlet_id = c.pome_hospital_id 
                where a.id in ($str)  and e.parent_leader = $teamlead  and e.team_leader =0  $brand $agency
                group by e.id,e.code,b.reason_code,a.id
                order by e.id";
//      pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }

   public function GetAttendanceHalfPerLeader($month,$agency="",$brand="",$teamlead,$year)
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
       
       if($agency == ""){
           $agency = 'and d.agency_id = 6';
       }else{
           $agency = 'and d.agency_id = '.$agency;
       }
       
       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
       $sql = "SELECT c.reason_code,a.id
                FROM [pg_mapping].[dbo].[pome_route] a
                inner join [pg_mapping].[dbo].[pome_route_transaction] b on b.route_id = a.id
                inner join [pg_mapping].[dbo].[pome_route_transaction_detail] c on c.pome_route_transaction_id = b.id
                inner join [pg_mapping].[dbo].[pome_pps] d on d.id = a.pps_id
                where a.date between '$from' and '$to'  and c.reason_code = '004'  and d.parent_leader = $teamlead  $brand $agency
                and d.team_leader =0 
                ";
//       pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function GetRoutePerLeader($month,$agency="",$brand="",$teamlead,$year)
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
       if($agency == ""){
           $agency = 'and e.agency_id = 6';
       }else{
           $agency = 'and e.agency_id = '.$agency;
       }
       
       if($brand != 0){
           $brand = 'and a.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
       $sql = "SELECT a.id,e.id as pps_id,b.reason_code,e.code
                FROM [pg_mapping].[dbo].[pome_route] a
                inner join [pg_mapping].[dbo].[pome_route_transaction] b on b.route_id = a.id
                inner join [pg_mapping].[dbo].[pome_pps] e on e.id = a.pps_id
                where a.date between '$from' and '$to'  and e.parent_leader = $teamlead  and e.team_leader =0   $brand $agency
                group by a.id,e.id ,b.reason_code,e.code
                order by e.id";
//       pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function GetAttendanceCount()
   {

       $sql = "SELECT *
                FROM [pg_mapping].[dbo].[pome_monthly_target]   ";
       
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function getBwsRoutePerLeader($agency,$month="",$brand,$team_lead,$year)
   {

       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
      
//        $current_month = date('m');
//        if($month == $current_month ){
//          $date1 = date($year.'-'.$month.'-d');
//          $to = date($year.'-m-d',strtotime($date1)); 
//        }else{
          $date1 = date($year.'-'.$month.'-01');
          $to = date($year.'-m-t',strtotime($date1));
//        }

        $from = date($year.'-'.$month.'-01');

      
        $sql ="SELECT d.id,d.pps_id,a.code
                FROM  [pg_mapping].[dbo].[pome_route] d               
                inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                where d.date between '$from' and '$to'  and a.parent_leader = $team_lead  and a.team_leader =0   $brand and a.agency_id =$agency
                group by d.id,d.pps_id,a.code
                order by a.code,d.pps_id
                ";
//       pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll(); 
      
      return $data;
   }
   
   public function GetParLeaderReach($month,$agency="",$brand="",$teamlead,$year)
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
       
       if($agency == ""){
           $agency = 'and a.agency_id = 6';
       }else{
           $agency = 'and a.agency_id = '.$agency;
       }
       
       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
       $sql = "SELECT count(d.id) as par,a.code
                FROM  [pg_mapping].[dbo].[pome_route] d               
                inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                where d.date between '$from' and '$to' and a.agency_id =  6  and a.parent_leader = $teamlead  $brand $agency
                and a.team_leader =0
       group by a.code
                ";
//       pr($sql);
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
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
           $sql ="SELECT d.date,a.id
                    FROM  [pg_mapping].[dbo].[pome_route] d               
                    inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                    where d.date between '$from' and '$to' and a.agency_id =  $agency 
                    group by d.date,a.id
                    order by d.date
                ";

          $command = Yii::app()->db3->createCommand($sql);
          $data = $command->queryAll();


          return $data;
    }
    
    public function getParPerRegion($agency,$from,$to,$brand,$year,$region)
    {
        $current_month = date('m');
        $given_date = date('m',strtotime($to));
        if(strtotime($given_date)> strtotime($to)){
            if($given_date > $current_month ){
                $to = date($year.'-m-d');
            }else{
                $to = $to;
            }
        }
                  
       if($brand != 0){
           $brand = 'and d.brand_id ='.$brand;
       }else{
           $brand= '';
       }
       
       if($region==0){
           $region = '';
           $select = 'e.name';
       }else{
           $region = 'and e.id='.$region;
           $select = 'b.name';
       }
       
           $sql ="SELECT $select,count(d.id) as par
                FROM  [pg_mapping].[dbo].[pome_route] d               
                inner join [pg_mapping].[dbo].[pome_pps] a on a.id = d.pps_id
                inner join [pg_mapping].[dbo].[province]  b on b.id = a.province_id
                left join  [pg_mapping].[dbo].[region] e on e.id = b.region_id
                where d.date between '$from' and '$to' and a.agency_id = $agency $brand $region
                group by $select
                order by $select
                ";
//pr($sql);
          $command = Yii::app()->db3->createCommand($sql);
          $data = $command->queryAll();


          return $data;
    }

}