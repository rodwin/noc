<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{     $this->layout='//layouts/column1';
            $model = new Dtd;
            $data = $model->getAllAgency();            
            $data1 = $model->getAllRegion();       
            $data2 = $model->getAllBrand();       
            $data3 = $model->getAllBwsTeam();       
                
            
            $month[0]['id']=1;
            $month[0]['name']='January';
            $month[1]['id']=2;
            $month[1]['name']='February';
            $month[2]['id']=3;
            $month[2]['name']='March';
            $month[3]['id']=4;
            $month[3]['name']='April';
            $month[4]['id']=5;
            $month[4]['name']='May';
            $month[5]['id']=6;
            $month[5]['name']='June';
            $month[6]['id']=7;
            $month[6]['name']='July';
            $month[7]['id']=8;
            $month[7]['name']='August';
            $month[8]['id']=9;
            $month[8]['name']='September';
            $month[9]['id']=10;
            $month[9]['name']='October';
            $month[10]['id']=11;
            $month[10]['name']='November';
            $month[11]['id']=12;
            $month[11]['name']='December';           
            
            $qtr[0]['name']='JFM';
            $qtr[1]['name']='AMJ';
            $qtr[2]['name']='JAS';
            $qtr[3]['name']='OND';
            
            $year[1]['id']='2014';
            $year[2]['id']='2015';
            $year[3]['id']='2016';
            
            unset($data2[0]);

            
                
          
            $agency = CHtml::listData($data, 'id', 'name');
            $region = CHtml::listData($data1, 'id', 'name');
            $month = CHtml::listData($month, 'id', 'name');
            $qtr = CHtml::listData($qtr, 'name', 'name');
            $brand= CHtml::listData($data2,'id', 'name');
            $teamlead= CHtml::listData($data3,'parent_leader', 'code');
            $year= CHtml::listData($year,'id', 'id');
//            $team= CHtml::listData($data4,'id', 'name');

   

            
            $this->render('index', array(
                'model' => $model,
                'agency' => $agency,
                'region' => $region,
                'month' => $month,
                'brand' => $brand,
                'qtr' => $qtr,
                'teamlead' => $teamlead,
                'year' => $year,
            

            ));
		
	}
        
        
        public function actionone()
        {
            echo "<option value=''>Select Province</option>";
            $model = new Dtd;
            $data = $model->getProvincebyRegionid($_POST['region_id']);    
            
            foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['id']), CHtml::encode($val['name']), true);
             }
//            
                    
        }
        
        public function actiongetTeam()
        {
            echo "<option value=''>Select Team</option>";
            $model = new Dtd;
            $data = $model->getTeamPerAgency($_POST['id']);   
            
            foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['id']), CHtml::encode($val['name']), true);
             }
        }
        
        public function actiongetTlPerTeam()
        {
            echo "<option value=''>Select Team Leader</option>";
            $model = new Dtd;
            $data = $model->getTlPerTeam($_POST['id']);   
            
            foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['id']), CHtml::encode($val['salesman_code']), true);
             }
        }
        
         
        public function actionattendance()
        {
             $model = new Dtd;
            
           
            if(isset($_GET['region'])){
                $region = $_GET['region'];
            }else{
                $region = 0;
            }
            
            if(isset($_GET['province'])){
                $province = $_GET['province'];
            }else{
                $province = 0;
            }
            $month = $_GET['month'];
            
            $current_month = date('m');
            if($month == $current_month ){
              $date1 = date($_GET['year'].'-'.$month.'-d');
              $to = date($_GET['year'].'-m-t',strtotime($date1)); 
              $par = date($_GET['year'].'-m-d',strtotime($date1)); 
            }else{
              $date1 = date($_GET['year'].'-'.$month.'-01');
              $to = date($_GET['year'].'-m-t',strtotime($date1));
              $par = date($_GET['year'].'-m-t',strtotime($date1));
            }

            $from = date($_GET['year'].'-'.$month.'-01');
         
            $data_route = $model->getRoute($from,$to,$_GET['brand'],$_GET['agency'],$_GET['region']); 
            $data_par = $model->getRoute($from,$par,$_GET['brand'],$_GET['agency'],$_GET['region']); 
            $str = '';
//            pr($data_route);
//            pr($data_par);
//            exit;
            $par = array();
            $previous = '';
           
            foreach($data_par as $keypar => $valpar){
//                $par_count = 1;
                if($previous == $valpar['name']){
                    $par_count+=$valpar['seller'];
//                    echo $par_count;
                   $par[$valpar['name']] =$par_count ; 
                }else{
                    $par_count = $valpar['seller'];
                   $par[$valpar['name']] = $valpar['seller'] ; 
                }
                $previous = $valpar['name'];
            }
            
            $attendance = array();
            if(count($data_route)>0){
                
                foreach($data_route as $key => $val){
                    
                    if(isset($data_route[$key-1])){
                        if($data_route[$key-1]['name'] == $val['name']){ 
                            $target_attendance++;
                            $actual_attendance += $val['salesman'];
                            $seller +=$val['seller'];
                            $attendance[$key_count]['target_attendance'] =$val['seller']*$target_attendance;
                            $attendance[$key_count]['actual_attendance'] =$actual_attendance;  
                            $attendance[$key_count]['name'] =$val['name']; 
                            $attendance[$key_count]['seller'] =$seller; 
                            if(isset($par[$val['name']])){
                                 $attendance[$key_count]['par'] =$par[$val['name']];  
                            }
                          
                           
                        }else{
                            $target_attendance = 1;
                            $actual_attendance =0;
                            $key_count++;
                            $seller = 0;
                            $actual_attendance += $val['salesman'];
                            $seller =$val['seller'];
                            $attendance[$key_count]['target_attendance'] =$val['seller']*$target_attendance;
                            $attendance[$key_count]['actual_attendance'] =$actual_attendance;  
                            $attendance[$key_count]['name'] =$val['name']; 
                            $attendance[$key_count]['seller'] =$seller; 
                            if(isset($par[$val['name']])){
                                 $attendance[$key_count]['par'] =$par[$val['name']];  
                            }
                        }

                    }else{
                            $target_attendance = 1;
                            $actual_attendance =0;
                            $key_count = 0;
                            $seller = 0;
                            $actual_attendance += $val['salesman'];
                            $seller = $val['seller'];
                            $attendance[$key_count]['target_attendance'] =$val['seller']*$target_attendance;
                            $attendance[$key_count]['actual_attendance'] =$actual_attendance; 
                            $attendance[$key_count]['name'] =$val['name']; 
                            $attendance[$key_count]['seller'] =$seller; 
                            if(isset($par[$val['name']])){
                                 $attendance[$key_count]['par'] =$par[$val['name']];  
                            }
                    }
                    
                    
                    
                }

            }
            
                 echo json_encode($attendance);
//            pr($data_route);
//            exit;
        }
        
        public function actionDetailHit()
        {
            $model = new Dtd;
            
            if(isset($_GET['region'])){
                $region = $_GET['region'];
            }else{
                $region = 0;
            }
            
            if(isset($_GET['province'])){
                $province = $_GET['province'];
            }else{
                $province = 0;
            }
            $month = $_GET['month'];
            
            $current_month = date('m');
            if($month == $current_month ){
              $date1 = date($_GET['year'].'-'.$month.'-d');
              $to = date($_GET['year'].'-m-t',strtotime($date1)); 
              $par = date($_GET['year'].'-m-d',strtotime($date1)); 
            }else{
              $date1 = date($_GET['year'].'-'.$month.'-01');
              $to = date($_GET['year'].'-m-t',strtotime($date1));
              $par = date($_GET['year'].'-m-t',strtotime($date1)); 
            }

             $from = date($_GET['year'].'-'.$month.'-01');
            
            $data_a = $model->getTargetHit($from,$to,$_GET['brand'],$_GET['agency']);
            $data_b = $model->getActualHit($from,$to,$_GET['brand'],$_GET['agency']);
            $data_c = $model->getParPerArea($from,$par,$_GET['brand'],$_GET['agency']);
            
            
            $actual_hit_array = array();
            foreach($data_b as $keyb => $valb){
                $actual_hit_array[$valb['name']] = $valb['hit'];
            }
            
            $par_array = array();
            foreach($data_c as $keyc => $valc){
                $par_array[$valc['name']] = $valc['par'];
            }
            
//            pr($actual_hit_array);
//            pr($par_array);
//            exit;
            $detail_hit = array();
            
            foreach($data_a as $keya => $vala){
                
                if(isset($data_a[$keya-1])){
                        if($data_a[$keya-1]['name'] == $vala['name']){ 
                           
                            $detail_hit[$key_count]['name'] = $vala['name'];
                            $detail_hit[$key_count]['target_hit'] = $vala['target_hit'];
                            $detail_hit[$key_count]['target_attendance'] = $vala['target_attendance'];
                        }else{
                            $key_count++;
                             $detail_hit[$key_count]['actual_hit'] = 0;
                            if(isset($par_array[$vala['name']])){
                                 $detail_hit[$key_count]['par'] =$par_array[$vala['name']];  
                            }
                            if(isset($actual_hit_array[$vala['name']])){
                                 $detail_hit[$key_count]['actual_hit'] =$actual_hit_array[$vala['name']];  
                            }
                            $detail_hit[$key_count]['name'] = $vala['name'];
                            $detail_hit[$key_count]['target_hit'] = $vala['target_hit'];
                            $detail_hit[$key_count]['target_attendance'] = $vala['target_attendance'];
                        }

                    }else{
                        $key_count = 0;
                        $detail_hit[$key_count]['actual_hit'] = 0;
                        if(isset($par_array[$vala['name']])){
                                 $detail_hit[$key_count]['par'] =$par_array[$vala['name']];  
                        }
                        if(isset($actual_hit_array[$vala['name']])){
                                 $detail_hit[$key_count]['actual_hit'] =$actual_hit_array[$vala['name']];  
                        }
                        $detail_hit[$key_count]['name'] = $vala['name'];
                        $detail_hit[$key_count]['target_hit'] = $vala['target_hit'];
                        $detail_hit[$key_count]['target_attendance'] = $vala['target_attendance'];
                    }
                
            }
//            pr($detail_hit);
//            exit;
            
            echo json_encode($detail_hit);
            
        }
        
        
        public function ActionTotalNationalReachJAS()
        {
            $model = new Dtd;
            
            $from = date($_GET['year'].'-07-01');
            $to = date($_GET['year'].'-09-30'); 
            
            $route_target = $model->getRoutePerQuarter($from,$to,$_GET['brand'],$_GET['agency']);
            $route_actual = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'3');
            $route_actual_reach = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'2');
            $route_par = $model->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$_GET['year']);
            
            $ond_array = array();

            $actual_hit = array();
            $actual_reach = array();
            $previous = '';
            foreach($route_actual as $keya => $vala)
            {
                   $month_name = date('F',strtotime($vala['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$vala['hit'];
                        $actual_hit[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_hit[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            $previous = '';
            foreach($route_actual_reach as $keyz => $valz)
            {
                   $month_name = date('F',strtotime($valz['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$valz['hit'];
                        $actual_reach[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_reach[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            
            $par = array();
            $previous_par = '';
            foreach($route_par as $keyb => $valb)
            {
                   $month_name = date('F',strtotime($valb['date']));
                   
                   if($month_name == $previous_par){
                       
                        $seller +=$valb['seller'];
                        $par[$month_name]= $seller;
                       
                   }else{
                        $seller = $valb['seller'];
                        $par[$month_name] =$seller;
                       
                   }
                   
                   $previous_par = $month_name;
            }
          

            foreach($route_target as $key => $val){
                
                 if(isset($route_target[$key-1])){
  
                    $month_name_pos = date('F',strtotime($val['date']));
                    $month_name_neg  = date('F',strtotime($route_target[$key-1]['date']));
                    if($month_name_neg == $month_name_pos ){  
                        $target_attendance += $val['seller'];
                        $target_hit += $val['seller']*$val['hit'];
                        $ond_array[$key_count]['target_attendance'] =$target_attendance;
                        $ond_array[$key_count]['name'] =$month_name_pos;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        
                    }else{
                        
                        $key_count++;
                        $month_name = date('F',strtotime($val['date']));
                        $target_hit = $val['seller']*$val['hit'];
                        $target_attendance = $val['seller'];
                        $ond_array[$key_count]['actual_hit'] =0;
                        $ond_array[$key_count]['actual_reach'] =0;
                        $ond_array[$key_count]['par'] =0;
                        $ond_array[$key_count]['target_attendance'] =0;
                        $ond_array[$key_count]['name'] =$month_name;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        if(isset($actual_hit[$month_name])){
                            $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                        }
                        if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                        }
                        if(isset($par[$month_name])){
                            $ond_array[$key_count]['par'] =$par[$month_name];
                        }
                    }

                 
                }else{     
                    $key_count = 0;
                    $month_name = date('F',strtotime($val['date']));
                    $target_hit = $val['seller']*$val['hit'];
                    $target_attendance = $val['seller'];
                    $ond_array[$key_count]['actual_hit'] =0;
                    $ond_array[$key_count]['actual_reach'] =0;
                    $ond_array[$key_count]['par'] =0;
                    $ond_array[$key_count]['target_attendance'] =$target_attendance;
                  
                    $ond_array[$key_count]['name'] =$month_name;
                    $ond_array[$key_count]['target_hit'] =$target_hit;
                    if(isset($actual_hit[$month_name])){
                         $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                    }
                    if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                    }
                    if(isset($par[$month_name])){
                         $ond_array[$key_count]['par'] =$par[$month_name];
                    }
              
                } 
                
            }
//            pr($ond_array);
            
          echo  json_encode($ond_array);
            
        }
        
        public function ActionTotalNationalReachOND()
        {
            $model = new Dtd;
            
            $from = date($_GET['year'].'-10-01');
            $to = date($_GET['year'].'-12-31'); 
            
            $route_target = $model->getRoutePerQuarter($from,$to,$_GET['brand'],$_GET['agency']);
            $route_actual = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'3');
            $route_actual_reach = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'2');
            $route_par = $model->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$_GET['year']);
            
            $ond_array = array();

            $actual_hit = array();
            $actual_reach = array();
            $previous = '';
            foreach($route_actual as $keya => $vala)
            {
                   $month_name = date('F',strtotime($vala['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$vala['hit'];
                        $actual_hit[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_hit[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            $previous = '';
            foreach($route_actual_reach as $keyz => $valz)
            {
                   $month_name = date('F',strtotime($valz['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$valz['hit'];
                        $actual_reach[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_reach[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            
            $par = array();
            $previous_par = '';
            foreach($route_par as $keyb => $valb)
            {
                   $month_name = date('F',strtotime($valb['date']));
                   
                   if($month_name == $previous_par){
                       
                        $seller +=$valb['seller'];
                        $par[$month_name]= $seller;
                       
                   }else{
                        $seller = $valb['seller'];
                        $par[$month_name] =$seller;
                       
                   }
                   
                   $previous_par = $month_name;
            }
          

            foreach($route_target as $key => $val){
                
                 if(isset($route_target[$key-1])){
  
                    $month_name_pos = date('F',strtotime($val['date']));
                    $month_name_neg  = date('F',strtotime($route_target[$key-1]['date']));
                    if($month_name_neg == $month_name_pos ){  
                        $target_attendance += $val['seller'];
                        $target_hit += $val['seller']*$val['hit'];
                        $ond_array[$key_count]['target_attendance'] =$target_attendance;
                        $ond_array[$key_count]['name'] =$month_name_pos;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        
                    }else{
                        
                        $key_count++;
                        $month_name = date('F',strtotime($val['date']));
                        $target_hit = $val['seller']*$val['hit'];
                        $target_attendance = $val['seller'];
                        $ond_array[$key_count]['actual_hit'] =0;
                        $ond_array[$key_count]['actual_reach'] =0;
                        $ond_array[$key_count]['par'] =0;
                        $ond_array[$key_count]['target_attendance'] =0;
                        $ond_array[$key_count]['name'] =$month_name;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        if(isset($actual_hit[$month_name])){
                            $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                        }
                        if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                        }
                        if(isset($par[$month_name])){
                            $ond_array[$key_count]['par'] =$par[$month_name];
                        }
                    }

                 
                }else{     
                    $key_count = 0;
                    $month_name = date('F',strtotime($val['date']));
                    $target_hit = $val['seller']*$val['hit'];
                    $target_attendance = $val['seller'];
                    $ond_array[$key_count]['actual_hit'] =0;
                    $ond_array[$key_count]['actual_reach'] =0;
                    $ond_array[$key_count]['par'] =0;
                    $ond_array[$key_count]['target_attendance'] =$target_attendance;
                  
                    $ond_array[$key_count]['name'] =$month_name;
                    $ond_array[$key_count]['target_hit'] =$target_hit;
                    if(isset($actual_hit[$month_name])){
                         $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                    }
                    if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                    }
                    if(isset($par[$month_name])){
                         $ond_array[$key_count]['par'] =$par[$month_name];
                    }
              
                } 
                
            }
//            pr($ond_array);
            
          echo  json_encode($ond_array);
            
        }
        
        public function ActionTotalNationalReachJFM()
        {
            $model = new Dtd;
            
            $year = $_GET['year'] +1;
            $from = date($year.'-01-01');
            $to = date($year.'-03-31'); 
            
            $route_target = $model->getRoutePerQuarter($from,$to,$_GET['brand'],$_GET['agency']);
            $route_actual = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'3');
            $route_actual_reach = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'2');
            $route_par = $model->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$_GET['year']);
            
            $ond_array = array();

            $actual_hit = array();
            $actual_reach = array();
            $previous = '';
            foreach($route_actual as $keya => $vala)
            {
                   $month_name = date('F',strtotime($vala['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$vala['hit'];
                        $actual_hit[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_hit[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            
            $previous = '';
            foreach($route_actual_reach as $keyz => $valz)
            {
                   $month_name = date('F',strtotime($valz['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$valz['hit'];
                        $actual_reach[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_reach[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            
            $par = array();
            $previous_par = '';
            foreach($route_par as $keyb => $valb)
            {
                   $month_name = date('F',strtotime($valb['date']));
                   
                   if($month_name == $previous_par){
                       
                        $seller +=$valb['seller'];
                        $par[$month_name]= $seller;
                       
                   }else{
                        $seller = $valb['seller'];
                        $par[$month_name] =$seller;
                       
                   }
                   
                   $previous_par = $month_name;
            }
          

            foreach($route_target as $key => $val){
                
                 if(isset($route_target[$key-1])){
  
                    $month_name_pos = date('F',strtotime($val['date']));
                    $month_name_neg  = date('F',strtotime($route_target[$key-1]['date']));
                    if($month_name_neg == $month_name_pos ){  
                        $target_attendance += $val['seller'];
                        $target_hit += $val['seller']*$val['hit'];
                        $ond_array[$key_count]['target_attendance'] =$target_attendance;
                        $ond_array[$key_count]['name'] =$month_name_pos;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        
                    }else{
                        
                        $key_count++;
                        $month_name = date('F',strtotime($val['date']));
                        $target_hit = $val['seller']*$val['hit'];
                        $target_attendance = $val['seller'];
                        $ond_array[$key_count]['actual_hit'] =0;
                        $ond_array[$key_count]['actual_reach'] =0;
                        $ond_array[$key_count]['par'] =0;
                        $ond_array[$key_count]['target_attendance'] =0;
                        $ond_array[$key_count]['name'] =$month_name;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        if(isset($actual_hit[$month_name])){
                            $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                        }
                        if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                        }
                        if(isset($par[$month_name])){
                            $ond_array[$key_count]['par'] =$par[$month_name];
                        }
                    }

                 
                }else{     
                    $key_count = 0;
                    $month_name = date('F',strtotime($val['date']));
                    $target_hit = $val['seller']*$val['hit'];
                    $target_attendance = $val['seller'];
                    $ond_array[$key_count]['actual_hit'] =0;
                    $ond_array[$key_count]['actual_reach'] =0;
                    $ond_array[$key_count]['par'] =0;
                    $ond_array[$key_count]['target_attendance'] =$target_attendance;
                  
                    $ond_array[$key_count]['name'] =$month_name;
                    $ond_array[$key_count]['target_hit'] =$target_hit;
                    if(isset($actual_hit[$month_name])){
                         $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                    }
                    if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                    }
                    if(isset($par[$month_name])){
                         $ond_array[$key_count]['par'] =$par[$month_name];
                    }
              
                } 
                
            }
//            pr($ond_array);
            
          echo  json_encode($ond_array);
            
        }
        
        public function ActionTotalNationalReachAMJ()
        {
            $model = new Dtd;
            
            $year = $_GET['year'] +1;
            $from = date($year.'-04-01');
            $to = date($year.'-06-30'); 
            
            $route_target = $model->getRoutePerQuarter($from,$to,$_GET['brand'],$_GET['agency']);
            $route_actual = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'3');
            $route_actual_reach = $model->getActualHitperQuarter($from,$to,$_GET['brand'],$_GET['agency'],'2');
            $route_par = $model->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$_GET['year']);
            $ond_array = array();

            $actual_hit = array();
            $actual_reach = array();
            $previous = '';
            foreach($route_actual as $keya => $vala)
            {
                   $month_name = date('F',strtotime($vala['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$vala['hit'];
                        $actual_hit[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_hit[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            
            $previous = '';
            foreach($route_actual_reach as $keyz => $valz)
            {
                   $month_name = date('F',strtotime($valz['date']));
                   
                   if($month_name == $previous){
                       
                        $actual +=$valz['hit'];
                        $actual_reach[$month_name]= $actual;
                       
                   }else{
                        $actual = $vala['hit'];
                        $actual_reach[$month_name] =$actual;
                       
                   }
                   
                   $previous = $month_name;
            }
            
            $par = array();
            $previous_par = '';
            foreach($route_par as $keyb => $valb)
            {
                   $month_name = date('F',strtotime($valb['date']));
                   
                   if($month_name == $previous_par){
                       
                        $seller +=$valb['seller'];
                        $par[$month_name]= $seller;
                       
                   }else{
                        $seller = $valb['seller'];
                        $par[$month_name] =$seller;
                       
                   }
                   
                   $previous_par = $month_name;
            }
          

            foreach($route_target as $key => $val){
                
                 if(isset($route_target[$key-1])){
  
                    $month_name_pos = date('F',strtotime($val['date']));
                    $month_name_neg  = date('F',strtotime($route_target[$key-1]['date']));
                    if($month_name_neg == $month_name_pos ){  
                        $target_attendance += $val['seller'];
                        $target_hit += $val['seller']*$val['hit'];
                        $ond_array[$key_count]['target_attendance'] =$target_attendance;
                        $ond_array[$key_count]['name'] =$month_name_pos;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        
                    }else{
                        
                        $key_count++;
                        $month_name = date('F',strtotime($val['date']));
                        $target_hit = $val['seller']*$val['hit'];
                        $target_attendance = $val['seller'];
                        $ond_array[$key_count]['actual_hit'] =0;
                        $ond_array[$key_count]['actual_reach'] =0;
                        $ond_array[$key_count]['par'] =0;
                        $ond_array[$key_count]['target_attendance'] =0;
                        $ond_array[$key_count]['name'] =$month_name;
                        $ond_array[$key_count]['target_hit'] =$target_hit;
                        
                        if(isset($actual_hit[$month_name])){
                            $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                        }
                        if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                        }
                        if(isset($par[$month_name])){
                            $ond_array[$key_count]['par'] =$par[$month_name];
                        }
                    }

                 
                }else{     
                    $key_count = 0;
                    $month_name = date('F',strtotime($val['date']));
                    $target_hit = $val['seller']*$val['hit'];
                    $target_attendance = $val['seller'];
                    $ond_array[$key_count]['actual_hit'] =0;
                    $ond_array[$key_count]['actual_reach'] =0;
                    $ond_array[$key_count]['par'] =0;
                    $ond_array[$key_count]['target_attendance'] =$target_attendance;
                  
                    $ond_array[$key_count]['name'] =$month_name;
                    $ond_array[$key_count]['target_hit'] =$target_hit;
                    if(isset($actual_hit[$month_name])){
                         $ond_array[$key_count]['actual_hit'] =$actual_hit[$month_name];
                    }
                    if(isset($actual_reach[$month_name])){
                         $ond_array[$key_count]['actual_reach'] =$actual_reach[$month_name];
                    }
                    if(isset($par[$month_name])){
                         $ond_array[$key_count]['par'] =$par[$month_name];
                    }
              
                } 
                
            }
//            pr($ond_array);
            
          echo  json_encode($ond_array);
            
        }
        
        public function actionTlAttendance()
        {
            $model = new Dtd;
            
            if($_GET['team'] == ""){
                $team = 0;
            }else{
               $team =$_GET['team'];
            }
            
    
            
            if($_GET['teamlead'] == ""){
                $team_lead = 99999;
            }else{
               $team_lead =$_GET['teamlead'];
            }
          
            $seller = $model->getSellerPerTL($team_lead,$team);
//            pr($seller);
//            exit;
            $route_target = $model->getTargetPerTL($_GET['month'],$team,$_GET['year'],$_GET['brand']);
            $route_target_par = $model->getParTargetPerTL($_GET['month'],$team,$_GET['year'],$_GET['brand']);

            $route = '';
            foreach($route_target as $keya => $vala){
                $route .= $vala['id'].",";  
            }
            $sellers = '';
            foreach($seller as $keyb => $valb){
                $sellers .= $valb['id'].",";  
            }

            $route = substr($route, 0, -1);
            $sellers = substr($sellers, 0, -1);
            
            $tl_att_array = array();
            
            if(count($seller)>0 && count($route_target)>0){
                
                $actual_attendance = $model->getActualAttendancePerSeller($route,$sellers);

                $actual_att_array = array();
                foreach($actual_attendance as  $keyc => $valc){
                    $actual_att_array[$valc['salesman_code']]= $valc['attendance'];
                }



                foreach($seller as $key => $val){
                    $tl_att_array[$key]['salesman']=$val['salesman_code'];
                    $tl_att_array[$key]['target_attendance']=count($route_target);
                    $tl_att_array[$key]['par']=count($route_target_par);
                    if(isset($actual_att_array[$val['salesman_code']])){
                             $tl_att_array[$key]['actual_attendance'] =$actual_att_array[$val['salesman_code']];
                    }

                }  
                
            }
                
            
//            pr($tl_att_array);
            
          echo  json_encode($tl_att_array);
            
        }
        
        
        public function actionTlReach()
        {
            $model = new Dtd;
            
            if($_GET['team'] == ""){
                $team = 0;
            }else{
               $team =$_GET['team'];
            }
            
            if($_GET['teamlead'] == ""){
                $team_lead = 99999;
            }else{
               $team_lead =$_GET['teamlead'];
            }
            
            $seller = $model->getSellerPerTL($team_lead,$team);

        
            $route_target = $model->getTargetPerTL($_GET['month'],$team,$_GET['year'],$_GET['brand']);
            $route_target_par = $model->getParTargetPerTL($_GET['month'],$team,$_GET['year'],$_GET['brand']);
            

            $route = '';
            $total_hit =0;
            foreach($route_target as $keya => $vala){
                $route .= $vala['id'].","; 
                $total_hit +=$vala['hit'];
            }
            $sellers = '';
            $sellers_name = '';
            foreach($seller as $keyb => $valb){
                $sellers .= $valb['id'].",";  
                $sellers_name .= "'".$valb['salesman_code']."',";  
            }

            $route = substr($route, 0, -1);
            $sellers = substr($sellers, 0, -1);
            $sellers_name = substr($sellers_name, 0, -1);

            $tl_att_array = array();
            
            if(count($seller)>0 && count($route_target)>0){
                
                $actual_hit_array = array();
                $route_actual_hit = $model->getSellerHitPerTl($sellers_name,$_GET['month'],$_GET['brand'],$_GET['agency'],$_GET['year']);
                foreach($route_actual_hit as $keyd => $vald){
                    $actual_hit_array[$vald['seller_code']]=$vald['hit'];
                }
                
                $actual_attendance = $model->getActualAttendancePerSeller($route,$sellers);
                $actual_att_array = array();
                foreach($actual_attendance as  $keyc => $valc){
                    $actual_att_array[$valc['salesman_code']]= $valc['attendance'];
                }
                
                foreach($seller as $key => $val){
                    $tl_att_array[$key]['salesman']=$val['salesman_code'];
                    $tl_att_array[$key]['target_attendance']=count($route_target);
                    $tl_att_array[$key]['par']=count($route_target_par);
                    $tl_att_array[$key]['target_hit']=$total_hit;
                    if(isset($actual_att_array[$val['salesman_code']])){
                             $tl_att_array[$key]['actual_attendance'] =$actual_att_array[$val['salesman_code']];
                    }
                    if(isset($actual_hit_array[$val['salesman_code']])){
                             $tl_att_array[$key]['actual_hit'] =$actual_hit_array[$val['salesman_code']];
                    }

                }
                
            }
            
            echo json_encode($tl_att_array);
        }
}