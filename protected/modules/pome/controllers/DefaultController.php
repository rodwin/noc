<?php

class DefaultController extends Controller
{
    /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','data'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete','profile'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionIndex()
	{     $this->layout='//layouts/column1';
            $model = new Attendance;
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
            
            $ph[0]['id']='PH1';
            $ph[0]['name']='PH1';
            $ph[1]['id']='PH1PLUS';
            $ph[1]['name']='PH1+';
            $ph[2]['id']='PH2';
            $ph[2]['name']='PH2';
            
            $qtr[0]['name']='JFM';
            $qtr[1]['name']='AMJ';
            $qtr[2]['name']='JAS';
            $qtr[3]['name']='OND';

            
                
          
            $agency = CHtml::listData($data, 'id', 'name');
            $region = CHtml::listData($data1, 'id', 'name');
            $month = CHtml::listData($month, 'id', 'name');
            $ph = CHtml::listData($ph, 'id', 'name');
            $qtr = CHtml::listData($qtr, 'name', 'name');
            $brand= CHtml::listData($data2,'id', 'name');
            $teamlead= CHtml::listData($data3,'parent_leader', 'code');

   

            
            $this->render('index', array(
                'model' => $model,
                'agency' => $agency,
                'region' => $region,
                'month' => $month,
                'ph' => $ph,
                'brand' => $brand,
                'qtr' => $qtr,
                'teamlead' => $teamlead,

            ));
		
	}
        
        
        public function actionone()
        {
            echo "<option value=''>Select Province</option>";
            $model = new Attendance;
            $data = $model->getProvincebyRegionid($_POST['region_id']);    
            
            foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['id']), CHtml::encode($val['name']), true);
             }
//            
                    
        }
        
        public function ActionAttendance()
        {
            $pome = new Pome;
            
           
      
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
            $data_ = $pome->getAttendance($region,$province,$_GET['month'],$_GET['brand']);
            $data_bws = $pome->getBwsRoute($_GET['agency'],$region,$province,$_GET['month'],$_GET['brand']);
            $ac = $pome->GetAttendanceCount();
            $attendance_count = array();
            foreach($ac as $keyac => $valac){
                $attendance_count[$valac['monthly_id']] = $valac['target'];
            }

            $data_attendance = $pome->getAttendance($_GET['agency'],$region,$province,$_GET['month'],$_GET['brand']);
            
            $rt_details = array();
            foreach($data_attendance as $keya => $vala){
                
                if(isset($data_attendance[$keya-1])){
                    if($data_attendance[$keya-1]['name'] == $vala['name']){                 
                        $rt_details[$vala['id']] =$vala['reason_code'];
                    }else{
                        $rt_details[$vala['id']] =$vala['reason_code']; 
                    }
                    
                }else{
                        $rt_details[$vala['id']] =$vala['reason_code']; 
                }
                
            }
          
            $attendance =array();
            $count = 0;
            $key_count =0;
            $bws_count = 1;
            foreach($data_bws as $key => $val){
                
                 if(isset($data_bws[$key-1])){
                
                    if($data_bws[$key-1]['name'] == $val['name'] ){
                        
                    
                        if($val['reason_code'] == '001'){
                          $count+=0;
                          $attendance[$key_count]['attendance'] = $count;  
                          $attendance[$key_count]['name'] = $val['name'];     
                        }else{
                            if(isset($rt_details[$val['id']])){
                               $count+=0.5; 
                            }else{
                               $count+=1;
                            }
                          
                          $attendance[$key_count]['attendance'] = $count;  
                          $attendance[$key_count]['name'] = $val['name'];  
                          
                        }
                        
                        if($data_bws[$key-1]['pps_id'] == $val['pps_id'] ){
                            $bws_count +=0; 
                        }else{
                            $bws_count +=1;
                        }
                        $attendance[$key_count]['count'] = $bws_count;
                       
                    }else{
                        $bws_count =1;
                        $key_count++;
                        $count =0;
                        if($val['reason_code'] == '001'){
                          $count+=0;
                          $attendance[$key_count]['attendance'] = $count;  
                          $attendance[$key_count]['name'] = $val['name'];     
                        }else{
                            if(isset($rt_details[$val['id']])){
                               $count+=0.5; 
                            }else{
                               $count+=1;
                            }
                        
                          $attendance[$key_count]['attendance'] = $count;  
                          $attendance[$key_count]['name'] = $val['name']; 
                          $attendance[$key_count]['ac_count'] = $attendance_count[$month];  
                        }
                        
                        if($data_bws[$key-1]['pps_id'] == $val['pps_id'] ){
                           $bws_count +0; 
                        }else{
                            $bws_count +1;
                        }
                        $attendance[$key_count]['count'] = $bws_count;
                        $attendance[$key_count]['ac_count'] = $attendance_count[$month];  
                    }
                 
                }else{
                        if($val['reason_code'] == '001'){
                          $count+=0;
                          $attendance[$key_count]['attendance'] = $count;  
                          $attendance[$key_count]['name'] = $val['name'];   
                        }else{
                            if(isset($rt_details[$val['id']])){
                                $count+=0.5; 
                            }else{
                                $count+=1; 
                            }
                            
                          $attendance[$key_count]['attendance'] = $count;  
                          $attendance[$key_count]['name'] = $val['name'];  
                         
                        }  
                         
                           $bws_count +1;
                          
                           $attendance[$key_count]['count'] = $bws_count;  
                           $attendance[$key_count]['ac_count'] = $attendance_count[$month];  
                   
                }
            }
            unset($attendance_count);
            unset($rt_details);
//            pr($attendance);
            echo json_encode($attendance);
       

        }
        
         
        public function ActionDetailedReach()
        {
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

            if(isset($_GET['ph'])){
                $ph = $_GET['ph'];
            }else{
                $ph = 'ph1';
               
            }
            
           
            $detailed = new Pome;
            $reach = $detailed->getTargetReach($_GET['month'],$ph,$_GET['brand']);
            
            $bws_reach = array();
            $str = '';
            foreach($reach as $keya => $vala){
                $str .=$vala['id'].",";
                $bws_reach[$vala['id']] =$vala['reach'];  
            }

            $str = substr($str, 0, -1); 
            $bws = $detailed->getBwsByAgency($region,$province,$_GET['agency'],$_GET['brand'],$str);
          
            $actual = $detailed->getActualReach($_GET['month'],$ph,$str);
            
            $actual_array = array();
            $value_actual = 0;
            $key_count_actual = 0;
            foreach($actual as $keyb => $valb){
                
                if(isset($actual[$keyb-1])){
                
                    if($actual[$keyb-1]['route_id'] == $valb['route_id'] ){   
                        
                        $value_actual +=$valb['reach'];
                        $actual_array[$valb['route_id']]=$value_actual;
                                           
                    }else{
                   
                        $value_actual =0;
                        
                        $value_actual =$valb['reach'];
                        $actual_array[$valb['route_id']] =$value_actual;
                        
                    }
                 
                }else{                 
                        $value_actual =$valb['reach'];
                        $actual_array[$valb['route_id']] =$value_actual;
                } 
            }
            
            $detail_array = array();
            $key_count = 0;
            $value = 0;
            $values =0;
            foreach($bws as $key => $val){
                if(isset($bws[$key-1])){
                
                    if($bws[$key-1]['name'] == $val['name'] ){  
                        
                        $detail_array[$key_count]['name'] =$val['name']; 
                        $detail_array[$key_count]['id'] =$val['id'];
                        if(isset($bws_reach[$val['id']])){
                            $value +=$bws_reach[$val['id']];
                            $detail_array[$key_count]['target_reach'] = $value; 
                        }else{
                            $detail_array[$key_count]['target_reach'] = 0; 
                        }   
                        if(isset($actual_array[$val['id']])){
                             $values +=$actual_array[$val['id']];
                             $detail_array[$key_count]['actual_reach'] =$values;  
                        }
                    }else{
                        $key_count++;
                        $value =0;
                        $values =0;
                        $detail_array[$key_count]['name'] =$val['name'];
                        $detail_array[$key_count]['id'] =$val['id'];
                        if(isset($bws_reach[$val['id']])){
                            $value =$bws_reach[$val['id']];
                            $detail_array[$key_count]['target_reach'] =$value;  
                        }else{
                            $detail_array[$key_count]['target_reach'] = 0; 
                        }
                        if(isset($actual_array[$val['id']])){
                             $values =$actual_array[$val['id']];
                             $detail_array[$key_count]['actual_reach'] =$values;  
                        }
                    }
                 
                }else{
                    $detail_array[$key_count]['name'] =$val['name'];
                    $detail_array[$key_count]['id'] =$val['id'];
                    if(isset($bws_reach[$val['id']])){                       
                        $value =$bws_reach[$val['id']];
                        $detail_array[$key_count]['target_reach'] =$value ; 
                    }else{
                            $detail_array[$key_count]['target_reach'] = 0; 
                        }
                    if(isset($actual_array[$val['id']])){
                             $values =$actual_array[$val['id']];
                             $detail_array[$key_count]['actual_reach'] =$values;  
                    }
                    
                   
                }
            }
//            pr($detail_array);
            echo json_encode($detail_array);
       
        }
        
        public function ActionTotalNationalReach()
        {
            if(isset($_GET['agency'])){
                $agency = $_GET['agency'];
            }else{
                $agency = 6;
            }
            
            if(!isset($_GET['qtr'])){
                $from = '2014-07-01';
//                $month = date('m');
//                $m  = $month+ 2;
                $to = '2014-09-30';
               
            }elseif($_GET['qtr'] == 'JFM'){
                $from = date('Y-01-01');
                $to = date('Y-03-t');
                
               
            }elseif($_GET['qtr'] == 'AMJ'){
                $from = date('Y-04-01');
                $to = date('Y-06-t');
            }elseif($_GET['qtr'] == 'JAS'){
                $from = date('Y-07-01');
                $to = date('Y-09-t'); 
            }elseif($_GET['qtr'] == 'OND'){
                 $from = date('Y-10-01');
                $to = date('Y-12-t'); 
            }
      
            $total = new Pome;
            $reach = $total->getTargetReachQTR($from,$to,$_GET['brand']);
            $bws = $total->getBwsByAgencyQTR($agency,$from,$to,$_GET['brand']);
            $actual = $total->GetActualReachQTR($from,$to,$_GET['brand']);           
            
            foreach($reach as $keya => $vala){
                
                $bws_reach[$vala['id']] =$vala['reach'];  
            }
            
            $actual_array = array();
            $value_actual = 0;
            $key_count_actual = 0;
            foreach($actual as $keyb => $valb){
                
                if(isset($actual[$keyb-1])){
                
                    if($actual[$keyb-1]['id'] == $valb['id'] ){   
                        
                        $value_actual +=$valb['reach'];
                        $actual_array[$valb['id']]=$value_actual;
                                           
                    }else{
                   
                        $value_actual =0;
                        
                        $value_actual =$valb['reach'];
                        $actual_array[$valb['id']] =$value_actual;
                        
                    }
                 
                }else{                 
                        $value_actual =$valb['reach'];
                        $actual_array[$valb['id']] =$value_actual;
                } 
            }
            
            $total_array = array();
            $key_count = 0;
            $value = 0;
            $values =0;
            foreach($bws as $key => $val){
                if(isset($bws[$key-1])){
                    $month_name_pos = date('F',strtotime($val['date']));
                    $month_name_neg  = date('F',strtotime($bws[$key-1]['date']));
                    if($month_name_neg == $month_name_pos ){            
                        if(isset($bws_reach[$val['id']])){
                        $value +=$bws_reach[$val['id']];
                        $month_name  = date('F',strtotime($val['date']));
                        $total_array[$key_count]['target_reach'] = $value; 
                        $total_array[$key_count]['name'] =$month_name; 
                   
                      
                        }   
                        if(isset($actual_array[$val['id']])){
                             $values +=$actual_array[$val['id']];
                             $total_array[$key_count]['actual_reach'] =$values;  
                        }else{
                           $values +=0;
                            $total_array[$key_count]['actual_reach'] =$values;   
                        }
                    }else{
                        $key_count++;
                        $value =0;
                        $values =0;
                        if(isset($bws_reach[$val['id']])){
                            $month_name  = date('F',strtotime($val['date']));
                            $value =$bws_reach[$val['id']];
                            $total_array[$key_count]['target_reach'] =$value; 
                            $total_array[$key_count]['name'] =$month_name;
                          
                        }
                        if(isset($actual_array[$val['id']])){
                             $values =$actual_array[$val['id']];
                             $total_array[$key_count]['actual_reach'] =$values;  
                        }else{
                           $values +=0;
                            $total_array[$key_count]['actual_reach'] =$values;   
                        }
                    }
                 
                }else{
                    $month_name  = date('F',strtotime($val['date']));
                    if(isset($bws_reach[$val['id']])){                       
                        $value =$bws_reach[$val['id']];
                        $total_array[$key_count]['target_reach'] =$value ; 
                        $total_array[$key_count]['name'] =$month_name;
                    
                    }
                    if(isset($actual_array[$val['id']])){
                             $values =$actual_array[$val['id']];
                             $total_array[$key_count]['actual_reach'] =$values;  
                    }else{
                           $values +=0;
                            $total_array[$key_count]['actual_reach'] =$values;   
                        }
                    
                   
                }
            }
//         pr($total_array);
            echo json_encode($total_array);
            
            
        }
        
        public function ActionTlReach()
        {

            $total = new Pome;           
            $reach = $total->getTargetReachPerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead']);
            $str='';
            foreach($reach as $keya => $vala){
                $str .=$vala['id'].",";
                $bws_reach[$vala['id']] =$vala['reach'];  
            }
            $str = substr($str, 0, -1); 
            $actual = $total->getActualReachPerLeader($_GET['agency'],$_GET['brand'],$_GET['teamlead'],$str);
            
            
            $detail_array = array();
            $key_count = 0;
            $value = 0;
            $actual_val = 0;
            foreach($actual as $key => $val){
                if(isset($actual[$key-1])){
                
                    if($actual[$key-1]['code'] == $val['code'] ){            
                        if(isset($bws_reach[$val['pps_id']])){
                        $value +=$bws_reach[$val['pps_id']];
                        $actual_val +=$val['actual_reach'];
                        $detail_array[$key_count]['target_reach'] = $value; 
                        $detail_array[$key_count]['code'] =$val['code']; 
                        $detail_array[$key_count]['pps_id'] =$val['pps_id'];
                        $detail_array[$key_count]['actual_reach'] = $actual_val;
                      
                        }   
                       
                    }else{
                        $key_count++;
                        $value =0;
                        $actual_val = 0;
                        if(isset($bws_reach[$val['pps_id']])){
                            $value =$bws_reach[$val['pps_id']];
                            $actual_val =$val['actual_reach'];
                            $detail_array[$key_count]['target_reach'] =$value; 
                            $detail_array[$key_count]['code'] =$val['code'];
                            $detail_array[$key_count]['pps_id'] =$val['pps_id'];
                            $detail_array[$key_count]['actual_reach'] =$actual_val;
                        }
                       
                    }
                 
                }else{
                    if(isset($bws_reach[$val['pps_id']])){                       
                        $value =$bws_reach[$val['pps_id']];
                        $actual_val =$val['actual_reach'];
                        $detail_array[$key_count]['target_reach'] =$value ; 
                        $detail_array[$key_count]['code'] =$val['code'];
                        $detail_array[$key_count]['pps_id'] =$val['pps_id'];
                        $detail_array[$key_count]['actual_reach'] =$actual_val;
                    }
                   
                    
                   
                }
            }
//            pr($detail_array);
            echo json_encode($detail_array);
            
            
        }
        
        public function ActionTlAttendance()
        {
            
            $total = new Pome;   
            $month = $_GET['month'];
            $actual = $total->GetRoutePerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead']);
            $attendance = $total->GetAttendancePerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead']);
            $data_attendance = array();
            $ac = $total->GetAttendanceCount();
            $attendance_count = array();
            foreach($ac as $keyac => $valac){
                $attendance_count[$valac['monthly_id']] = $valac['target'];
            }
            
            
            foreach($attendance as $keya => $vala){
                
                if(isset($attendance[$keya-1])){
                    if($attendance[$keya-1]['name'] == $vala['name']){                 
                        $data_attendance[$vala['id']] =$vala['reason_code'];
                    }else{
                        $data_attendance[$vala['id']] =$vala['reason_code']; 
                    }
                    
                }else{
                        $data_attendance[$vala['id']] =$vala['reason_code']; 
                }
                
            }
            
            $attendance1 =array();
            $count = 0;
            $key_count =0;
//            $bws_count = 1;
            foreach($actual as $key => $val){
                
                 if(isset($actual[$key-1])){
                
                    if($actual[$key-1]['code'] == $val['code'] ){
                        
                    
                        if($val['reason_code'] == '001'){
                          $count+=0;
                          $attendance1[$key_count]['attendance'] = $count;  
                          $attendance1[$key_count]['code'] = $val['code'];     
                        }else{
                            if(isset($data_attendance[$val['id']])){
                               $count+=0.5; 
                            }else{
                               $count+=1;
                            }
                          
                          $attendance1[$key_count]['attendance'] = $count;  
                          $attendance1[$key_count]['code'] = $val['code'];  
                          
                        }
                        $attendance1[$key_count]['count'] = $attendance_count[$month];  
//                        if($actual[$key-1]['pps_id'] == $val['pps_id'] ){
//                            $bws_count +=0; 
//                        }else{
//                            $bws_count +=1;
//                        }
//                        $attendance1[$key_count]['count'] = $bws_count;
                       
                    }else{
//                        $bws_count =1;
                        $key_count++;
                        $count =0;
                        if($val['reason_code'] == '001'){
                          $count+=0;
                          $attendance1[$key_count]['attendance'] = $count;  
                          $attendance1[$key_count]['code'] = $val['code'];     
                        }else{
                            if(isset($data_attendance[$val['id']])){
                               $count+=0.5; 
                            }else{
                               $count+=1;
                            }
                        
                          $attendance1[$key_count]['attendance'] = $count;  
                          $attendance1[$key_count]['code'] = $val['code']; 
                        }
                        $attendance1[$key_count]['count'] = $attendance_count[$month];  
//                        if($actual[$key-1]['pps_id'] == $val['pps_id'] ){
//                           $bws_count +0; 
//                        }else{
//                            $bws_count +1;
//                        }
//                        $attendance1[$key_count]['count'] = $bws_count;
                    }
                 
                }else{
                        if($val['reason_code'] == '001'){
                          $count+=0;
                          $attendance1[$key_count]['attendance'] = $count;  
                          $attendance1[$key_count]['code'] = $val['code'];   
                        }else{
                            if(isset($data_attendance[$val['id']])){
                                $count+=0.5; 
                            }else{
                                $count+=1; 
                            }
                            
                          $attendance1[$key_count]['attendance'] = $count;  
                          $attendance1[$key_count]['code'] = $val['code'];  
                         
                        }  
                         
//                           $bws_count +1;
//                          
                           $attendance1[$key_count]['count'] = $attendance_count[$month];  
//                   
                }
            }
            

            echo json_encode($attendance1);
        }
}