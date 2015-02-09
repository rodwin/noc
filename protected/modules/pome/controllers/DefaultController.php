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
        
            if(yii::app()->user->userObj->user_type_id == 'POME Operation Youthopia'){
                $agency = 9;
            }elseif(yii::app()->user->userObj->user_type_id == 'POME Operation Berco'){
               $agency = 6; 
            }else{
                $agency = 0;
            }
      
            $model = new Attendance;
            $data = $model->getAllAgency($agency);            
            $data1 = $model->getAllRegion();       
            $data2 = $model->getAllBrand();       
            $data3 = $model->getAllBwsTeam($agency);       
            
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

            $year[0]['id']='2014';
            $year[1]['id']='2015';
            $year[2]['id']='2016';
            
            $brand[0]['id']='3';
            $brand[0]['name']='PAMPERS';
            $brand[1]['id']='6';
            $brand[1]['name']='WHISPER';
            
            $project[0]['id'] = 1;
            $project[0]['name'] = 'Pome School';
            $project[1]['id'] = 2;
            $project[1]['name'] = 'Pome Hospital';

            
                
          
            $agency = CHtml::listData($data, 'id', 'name');
            $region = CHtml::listData($data1, 'id', 'name');
            $month = CHtml::listData($month, 'id', 'name');
            $ph = CHtml::listData($ph, 'id', 'name');
            $qtr = CHtml::listData($qtr, 'name', 'name');
            $brand= CHtml::listData($brand,'id', 'name');

            $teamlead= CHtml::listData($data3,'parent_leader', 'code');
            $year= CHtml::listData($year,'id', 'id');
            $project= CHtml::listData($project,'id', 'name');

   

            
            $this->render('index', array(
                'model' => $model,
                'agency' => $agency,
                'region' => $region,
                'month' => $month,
                'ph' => $ph,
                'brand' => $brand,
                'qtr' => $qtr,
                'teamlead' => $teamlead,
                'year' => $year,
  

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
        
        public function actionGethBwsTeam()
        {
//            echo "<option value='0'>Select Bws</option>";
            $model = new Attendance;
//            $model->getAllBwsTeam();  
            $data = $model->getAllBwsTeam($_GET['agency']); 
            echo json_encode($data);
//            echo json_encode($data);
//            $data=CHtml::listData($data,'parent_leader','code');
//            foreach ($data as $key => $val) {
//                echo CHtml::tag('option', array('value' => $val['parent_leader']), CHtml::encode($val['code']), true);
//            }
////            
                    
        }
        
        public function actionGetTeamSchool()
        {
//            echo "<option value='0'>Select Bws</option>";
            $model = new Attendance;
//            $model->getAllBwsTeam();  
            $data = $model->getAllTeamSchool($_GET['agency']);  
            echo json_encode($data);
//            echo json_encode($data);
//            $data=CHtml::listData($data,'id','teamCode');
//            foreach ($data as $key => $val) {
//            echo CHtml::tag('option', array('value' => $val['id']), CHtml::encode($val['teamCode']), true);
//             }
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
            
            $current_month = date('m');
            if($month == $current_month ){
              $date1 = date($_GET['year'].'-'.$month.'-d');
              $to = date($_GET['year'].'-m-d',strtotime($date1)); 
            }else{
              $date1 = date($_GET['year'].'-'.$month.'-01');
              $to = date($_GET['year'].'-m-t',strtotime($date1));
            }

            $from = date($_GET['year'].'-'.$month.'-01');
            if($_GET['chasi'] ==1){
                $data_actual = $pome->getActualAttendance($_GET['month'],$_GET['brand'],$_GET['year']);
                $data_actual_half = $pome->getReasonHalfday($_GET['month'],$_GET['brand'],$_GET['year']);
                $data_bws = $pome->getBwsRoute($_GET['agency'],$region,$province,$_GET['month'],$_GET['brand'],$_GET['year']);
                $data_par = $pome->getParPerRegion($_GET['agency'],$from,$to,$_GET['brand'],$_GET['year'],$region);

                $rt_details = array();
                foreach($data_actual as $keya => $vala){

                    if(isset($data_actual[$keya-1])){
                        if($data_actual[$keya-1]['id'] == $vala['id']){                 
                            $rt_details[$vala['id']]['rt_reason'] =$vala['reason_code'];
                            $rt_details[$vala['id']]['rtd_reason'] =''; 
                        }else{
                            $rt_details[$vala['id']]['rt_reason'] =$vala['reason_code'];
                            $rt_details[$vala['id']]['rtd_reason'] =''; 
                        }

                    }else{
                            $rt_details[$vala['id']]['rt_reason'] =$vala['reason_code']; 
                            $rt_details[$vala['id']]['rtd_reason'] =''; 
                    }

                }

                foreach($data_par as $keyb=> $valb){
                    $par_bws[$valb['name']] = $valb['par'];
                }

                foreach($data_actual_half as $keyb => $valb){

                    if(isset($rt_details[$valb['id']])){

                       $rt_details[$valb['id']]['rtd_reason'] = $valb['reason_code'] ;  
                    }

                }
    //            pr($rt_details);
    //            exit;
                $attendance =array();
                $count = 0;
                $key_count =0;
                $bws_count = 1;
                $target_attendance = 0;
                $actual_attendance=0;
                $value =0;
                unset($data_actual);
                unset($data_actual_half);
                foreach($data_bws as $key => $val){

                     if(isset($data_bws[$key-1])){

                        if($data_bws[$key-1]['name'] == $val['name'] ){

                            $target_attendance++;
                            $attendance[$key_count]['name'] = $val['name'];
                            $attendance[$key_count]['target_attendance'] = $target_attendance;
                            if(isset($rt_details[$val['id']])){
                                if($rt_details[$val['id']]['rt_reason']== '001' && $rt_details[$val['id']]['rt_reason']!= null ){
                                    $actual_attendance =0;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }elseif($rt_details[$val['id']]['rtd_reason']== '004' && $rt_details[$val['id']]['rtd_reason']!= null ){
                                    $actual_attendance =0.5;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }else{
                                    $actual_attendance =1;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance; 
                                }
                            }
                        }else{
                            $target_attendance = 0;
                            $target_attendance++;
                            $key_count++;
                            $value = 0;
                            $attendance[$key_count]['name'] = $val['name'];
                            $attendance[$key_count]['target_attendance'] = $target_attendance;
                            $attendance[$key_count]['actual_attendance'] = 0;
                            $attendance[$key_count]['par'] = $par_bws[$val['name']] ;
                            if(isset($rt_details[$val['id']])){
                                if($rt_details[$val['id']]['rt_reason']== '001' && $rt_details[$val['id']]['rt_reason']!= null ){
                                    $actual_attendance =0;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }elseif($rt_details[$val['id']]['rtd_reason']== '004' && $rt_details[$val['id']]['rtd_reason']!= null ){
                                    $actual_attendance =0.5;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }else{
                                    $actual_attendance =1;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance; 
                                }
                            }
                        }

                    }else{

                        $target_attendance++;
                        $attendance[$key_count]['name'] = $val['name'];
                        $attendance[$key_count]['target_attendance'] = $target_attendance;
                        $attendance[$key_count]['actual_attendance'] = 0;
                        $attendance[$key_count]['par'] = $par_bws[$val['name']] ;
                        if(isset($rt_details[$val['id']])){
                            if($rt_details[$val['id']]['rt_reason']== '001' && $rt_details[$val['id']]['rt_reason']!= null ){
                                $actual_attendance =0;                      
                                $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                            }elseif($rt_details[$val['id']]['rtd_reason']== '004' && $rt_details[$val['id']]['rtd_reason']!= null ){
                                $actual_attendance =0.5;
                                $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                            }else{                          
                                $actual_attendance =1;
                                $attendance[$key_count]['actual_attendance'] += $actual_attendance; 
                            }
                        }

                    }
                }

                unset($rt_details);
    //            pr($attendance);
    //            exit;
            }else{
                $attendance =array();
                $route = $pome->getAllRouteSchoolPerAgencyDetailed($_GET['year'],$_GET['month'],$_GET['agency'],$_GET['brand']);
                
                if(count($route)>0){
                    $str_a ='';
                    foreach($route as $a=> $b){
                            $str_a .=$b['id'].',';
                    }
                    $str = substr($str_a, 0, -1);
                    $target_school = $pome->getTargetschool($str);
                }else{
                    $target_school = array();
                }
                
                if(count($target_school)>0){
                    $str_b ='';
                    foreach($target_school as $c=> $d){
                            $str_b .=$d['id'].',';
                    }
                    $strb = substr($str_b, 0, -1);
                    $bws_route = $pome->getTargetByRegionSchool($strb,$region); 
                    $bws_route_par = $pome->getTargetByRegionSchool($strb,$region);
                }else{
                    $bws_route = array();
                }
//                exit;
                if($region ==0){
                    $region_array = $pome->getAllRegion();                 
                    unset($region_array[17]);
                }else{
                   $region_array = $pome->getAllProvince($region);  
                }
                
                if(count($bws_route)>0){
                    $str='';
                    foreach($bws_route as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1); 
                    
                    $attendance_target = $pome->getAttendanceSchool($str,0,$_GET['month'],$_GET['year'],$region);
                    $attendance_par = $pome->getAttendanceSchool($str,1,$_GET['month'],$_GET['year'],$region);
                    $attendance_actual = $pome->getActualAttendanceSchool($str,0,$_GET['month'],$_GET['year'],$region);

                    $actual_attendance= array();
                    foreach($attendance_actual as $c => $d){
                        $actual_attendance[$d['region']] =$d['attendance'];
                    }
//                    pr($attendance_target);
                    $actual_attendance_par= array();
                    foreach($attendance_par as $e => $f){
                        $actual_attendance_par[$f['region']] =$f['attendance'];
                    }
                    $target_attendance= array();
                    foreach($attendance_target as $g => $h){
                        $target_attendance[$h['region']] =$h['attendance'];
                    }
//                    pr($attendance_target);
//                    pr($actual_attendance);
//                    pr($actual_attendance_par);


                    foreach($region_array as $key => $val){
                        $attendance[$key]['name'] = $val['name'];
                        $attendance[$key]['target_attendance'] =0;
                        $attendance[$key]['par'] =0;
                        if(isset($actual_attendance[$val['name']])){
                                $attendance[$key]['actual_attendance'] =$actual_attendance[$val['name']];
                        }
                        if(isset($actual_attendance_par[$val['name']])){
                                $attendance[$key]['par'] =$actual_attendance_par[$val['name']];
                        }
                        if(isset($target_attendance[$val['name']])){
                                $attendance[$key]['target_attendance'] =$target_attendance[$val['name']];
                        }
                    }
//                    pr($attendance);
                }
                
                
            }
//            exit;
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
            if($_GET['chasi'] == 1){
 
                $bws_route = $detailed->getBwsRouteDetailedReach($_GET['agency'],$region,$_GET['month'],$_GET['brand'],$_GET['year']);
                $reach = $detailed->getTargetReach($_GET['month'],$ph,$_GET['brand'],$_GET['year']);
                $bws_target = array();
                $bws_actual = array();
                $bws_par = array();          
                $detail_array =array();

                $str='';
                foreach($reach as $key => $val){
                    $bws_target[$val['id']] =$val['reach'];
                    $str .=$val['id'].",";
                }            
                $str = substr($str, 0, -1);

                $actual = $detailed->getActualReach($_GET['month'],$ph,$str);          
                foreach($actual as $keya=> $vala){
                    $bws_actual[$vala['route_id']]['reach'] = $vala['reach'];
                }

                $data_actual_par = $detailed->getParDetailedReach($_GET['agency'],$region,$_GET['month'],$_GET['brand'],$_GET['year']);
                foreach($data_actual_par as $keyb=> $valb){
                    $bws_par[$valb['name']] = $valb['par'];
                }
                
                $key_count = 0;
                $target_reach = 0;
                $actual_reach = 0;
                $target_attendance = 0;
                $actual_attendance=0;
                foreach($bws_route as $keyc=>$valc){

                     if(isset($bws_route[$keyc-1])){

                        if($bws_route[$keyc-1]['name'] == $valc['name'] ){
                            $target_attendance++;
                            $detail_array[$key_count]['name'] = $valc['name'];
                            $detail_array[$key_count]['target_attendance'] = $target_attendance;
                            if(isset($bws_target[$valc['id']])){
                                $target_reach +=$bws_target[$valc['id']];
                                $detail_array[$key_count]['target_reach'] = $target_reach ;
                            }
                            if(isset($bws_actual[$valc['id']]['reach'])){
                                $actual_reach +=$bws_actual[$valc['id']]['reach'];
                                $detail_array[$key_count]['actual_reach'] =$actual_reach ;
                            }

    //                        $actual_attendance =1;
    //                        $detail_array[$key_count]['actual_attendance'] += $actual_attendance; 
                             $detail_array[$key_count]['par'] = $bws_par[$valc['name']]; 



                        }else{
                            $key_count++;
                            $target_reach=0;
                            $actual_reach=0;
                            $target_attendance = 0;
                            $target_attendance++;
                            $detail_array[$key_count]['name'] = $valc['name'];
                            $detail_array[$key_count]['target_attendance'] = $target_attendance;
                            $detail_array[$key_count]['actual_attendance'] = 0;
                            $detail_array[$key_count]['target_reach'] = 0;
                            $detail_array[$key_count]['actual_reach'] = 0;
                            if(isset($bws_target[$valc['id']])){
                                $target_reach +=$bws_target[$valc['id']];
                                $detail_array[$key_count]['target_reach'] = $target_reach ;
                            }
                            if(isset($bws_actual[$valc['id']]['reach'])){
                                $actual_reach +=$bws_actual[$valc['id']]['reach'];
                                $detail_array[$key_count]['actual_reach'] =$actual_reach ;
                            }

    //                        $actual_attendance =1;
    //                        $detail_array[$key_count]['actual_attendance'] += $actual_attendance; 
                            $detail_array[$key_count]['par'] = $bws_par[$valc['name']]; 

                        }

                    }else{

                        $detail_array[$key_count]['name'] = $valc['name'];
                        $detail_array[$key_count]['target_attendance'] = $target_attendance;
                        $detail_array[$key_count]['actual_attendance'] = 0;
                        $detail_array[$key_count]['target_reach'] = 0;
                        $detail_array[$key_count]['actual_reach'] = 0;
                        if(isset($bws_target[$valc['id']])){
                            $target_reach =$bws_target[$valc['id']];
                            $detail_array[$key_count]['target_reach'] =$target_reach ;
                        }
                        if(isset($bws_actual[$valc['id']]['reach'])){
                            $actual_reach =$bws_actual[$valc['id']]['reach'];
                            $detail_array[$key_count]['actual_reach'] =$actual_reach ;
                        }

    //                    $actual_attendance =1;
                        $detail_array[$key_count]['par'] = $bws_par[$valc['name']]; 

                    }
                }
            }else{
                $route = $detailed->getAllRouteSchoolPerAgencyDetailed($_GET['year'],$_GET['month'],$_GET['agency'],$_GET['brand']);
               
                if(count($route)>0){
                    $str_a ='';
                    foreach($route as $a=> $b){
                            $str_a .=$b['id'].',';
                    }
                    $str = substr($str_a, 0, -1);
                    $target_school = $detailed->getTargetschool($str);
                }else{
                    $target_school = array();
                }
                
                if(count($target_school)>0){
                    $str_b ='';
                    foreach($target_school as $c=> $d){
                            $str_b .=$d['id'].',';
                    }
                    $strb = substr($str_b, 0, -1);
                    $bws_route = $detailed->getTargetByRegionSchool($strb,$region); 
                    $bws_route_par = $detailed->getTargetByRegionSchool($strb,$region);
                }else{
                    $bws_route = array();
                }
//                exit;
                if($region ==0){
                    $region_array = $detailed->getAllRegion();                 
                    unset($region_array[17]);
                }else{
                   $region_array = $detailed->getAllProvince($region);  
                }
//                pr($region_array);exit;
                $detail_array = array();
                
                if(count($bws_route)>0){
                    $str = '';
                    foreach($bws_route as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1);
                    $actual_reach = $detailed->getActualReachSchool($str,$region); 
                    $attendance = $detailed->getAttendanceSchool($str,0,$_GET['month'],$_GET['year'],$region);
                    $attendance_par = $detailed->getAttendanceSchool($str,1,$_GET['month'],$_GET['year'],$region);

                    $actual= array();               
                    foreach($actual_reach as $a => $b){
                        $actual[$b['name']] =$b['actual_reach'];
                    }
                    $attendance_target= array();
                    foreach($attendance as $c => $d){
                        $attendance_target[$d['region']] =$d['attendance'];
                    }


                    foreach($region_array as $key => $val){
                        $detail_array[$key]['name'] = $val['name'];
                        $detail_array[$key]['target_reach'] =0;
                        $detail_array[$key]['actual_reach'] =0;
                        $detail_array[$key]['target_attendance'] =0;
                        $detail_array[$key]['par'] =0;
                        if(isset($actual[$val['name']])){
                                $detail_array[$key]['actual_reach'] =$actual[$val['name']];
                        }
                        if(isset($attendance_target[$val['name']])){
                                $detail_array[$key]['target_attendance'] =$attendance_target[$val['name']];
                        }
                        foreach($bws_route as $keya => $vala){
                                if($val['id'] == $vala['region']){
                                     $detail_array[$key]['target_reach'] +=$vala['target_reach'];
                                }

                        }   
                        $par = 0;
                        foreach($bws_route_par as $keya => $vala){
                                if($val['id'] == $vala['region']){
                                    $par++;
                                     $detail_array[$key]['par'] =$par;

                                }

                        }  

                    }
                }
               
            }
          
            echo json_encode($detail_array);
            
       
        }
        
        public function ActionTotalNationalReach()
        {
            if(isset($_GET['agency'])){
                $agency = $_GET['agency'];
            }else{
                $agency = 6;
            }

            if($_GET['year'] == 2014){
                 $from = date($_GET['year'].'-07-16');
            }else{
                 $from = date($_GET['year'].'-07-01');
            }
           
            $to = date($_GET['year'].'-09-30'); 

            $total = new Pome;
            if($_GET['chasi'] ==1){
                $reach = $total->getTargetReachQTR($from,$to,$_GET['brand']);
                $bws = $total->getBwsByAgencyQTR($agency,$from,$to,$_GET['brand']);

                $actual = $total->GetActualReachQTR($from,$to,$_GET['brand'],$_GET['agency']);   

                $data_actual_par = $total->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$_GET['year']);

                $par =0;
                $bws_par = array();
                foreach($data_actual_par as $keyb=> $valb){
                     if(isset($data_actual_par[$keyb-1])){
                        $month_name_pos = date('F',strtotime($valb['date']));

                        $month_name_neg  = date('F',strtotime($data_actual_par[$keyb-1]['date']));     
                        if($month_name_neg == $month_name_pos ){ 
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }else{
                            $par = 0;
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }
                     }else{
                        $month_name_pos = date('F',strtotime($valb['date']));   
                            $par++;
                            $bws_par[$month_name_pos] = $par ;


                     }

                }


                $total = 0;
                foreach($reach as $keya => $vala){
                    $total+=$vala['reach'];
                    $bws_reach[$vala['id']] =$vala['reach'];  
                }
    //            pr($total);
    //            exit;
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
                            $target_attendance ++;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name; 
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){
                                $value +=$bws_reach[$val['id']];
                                $month_name  = date('F',strtotime($val['date']));
                                $total_array[$key_count]['target_reach'] = $value; 
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
                            $month_name  = date('F',strtotime($val['date']));
                            $target_attendance =1;
                            $total_array[$key_count]['target_reach'] =0;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name;
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){                          
                                $value =$bws_reach[$val['id']];
                                $total_array[$key_count]['target_reach'] =$value;  
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
                        $target_attendance = 1;
                        $total_array[$key_count]['target_attendance'] =$target_attendance;
                        $month_name  = date('F',strtotime($val['date']));
                        $total_array[$key_count]['name'] =$month_name;
                        $total_array[$key_count]['target_reach'] =0;
                        $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                        if(isset($bws_reach[$val['id']])){                       
                            $value =$bws_reach[$val['id']];
                            $total_array[$key_count]['target_reach'] =$value ; 
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
            }else{
                $route = $total->getAllRouteSchoolPerAgency($_GET['year'],$from,$to,$_GET['agency'],$_GET['brand']);
               
                if(count($route)>0){
                    $str_a ='';
                    foreach($route as $a=> $b){
                            $str_a .=$b['id'].',';
                    }
                    $str = substr($str_a, 0, -1);
                    $reach = $total->getTargetschool($str);
                }else{
                    $reach = array();
                }
                
                

                $total_array = array();
                $total_array[0]['name'] = 'July';
                $total_array[1]['name'] = 'August';
                $total_array[2]['name'] = 'September';
                $total_array[0]['target_reach'] =0;
                $total_array[1]['target_reach'] = 0;
                $total_array[2]['target_reach'] = 0;
                $total_array[0]['par'] =0;
                $total_array[1]['par'] = 0;
                $total_array[2]['par'] = 0;
                $total_array[0]['target_attendance'] =0;
                $total_array[1]['target_attendance'] = 0;
                $total_array[2]['target_attendance'] = 0;
                $total_array[0]['actual_reach'] =0;
                $total_array[1]['actual_reach'] = 0;
                $total_array[2]['actual_reach'] = 0;
                if(count($reach)>0){
                    $str = '';
                    foreach($reach as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1);

                    $data_par = $total->getParSchool($from,$to,$_GET['year'],$str,1);
                    $data_attendance = $total->getParSchool($from,$to,$_GET['year'],$str,0);

                    $actual_reach = $total->getQTRreachchool($str);
                    foreach($reach as $key => $val){

                            $month_name = date('F',strtotime($val['date']));

                            if($month_name == 'July' ){                          
                                $total_array[0]['target_reach'] +=$val['target_reach'];
                            }elseif($month_name == 'August'){
                                $total_array[1]['target_reach'] +=$val['target_reach'];
                            }else{
                                $total_array[2]['target_reach'] +=$val['target_reach'];
                            }                 
                    }    

                    $par =1;
                    foreach($data_par as $keya=> $vala){
                         $month_name = date('F',strtotime($vala['date']));

                            if($month_name == 'July' ){                          
                                $total_array[0]['par'] +=$par;
                            }elseif($month_name == 'August'){
                                $total_array[1]['par'] +=$par;
                            }else{
                                $total_array[2]['par'] +=$par;
                            }
                    }
                    $attendance =1;
                    foreach($data_attendance as $keyb=> $valb){
                         $month_name = date('F',strtotime($valb['date']));

                            if($month_name == 'July' ){                          
                                $total_array[0]['target_attendance'] +=$attendance;
                            }elseif($month_name == 'August'){
                                $total_array[1]['target_attendance'] +=$attendance;
                            }else{
                                $total_array[2]['target_attendance'] +=$attendance;
                            }
                    }
                    foreach($actual_reach as $keyc => $valc){

                            $month_name = date('F',strtotime($valc['date']));

                            if($month_name == 'July' ){                          
                                $total_array[0]['actual_reach'] +=$valc['actual_reach'];
                            }elseif($month_name == 'August'){
                                $total_array[1]['actual_reach'] +=$valc['actual_reach'];
                            }else{
                                $total_array[2]['actual_reach'] +=$valc['actual_reach'];
                            }                 
                    } 
                }
               
//                pr($total_array);
//                exit;
            }
//         pr($total_array);
            echo json_encode($total_array);
            
            
        }
        
        public function ActionTlReach()
        {
            if(isset($_GET['teamlead'])){
                $seller = 0;
            }else{
                $seller= $_GET['teamlead'];
            }

            $total = new Pome; 
            $detail_array = array();
            if($_GET['chasi']== 1){
                $reach = $total->getTargetReachPerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$seller,$_GET['ph'],$_GET['year']);
                $stra='';
                foreach($reach as $keya => $vala){
                    $stra .=$vala['route_id'].","; 
                }

                $stra = substr($stra, 0, -1); 
                $actual = $total->getActualReachPerLeader($_GET['agency'],$_GET['brand'],$seller,$stra,$_GET['ph']);
                $data_actual_half = $total->GetParLeaderReach($_GET['month'],$_GET['agency'],$_GET['brand'],$seller,$_GET['year']);
                $actual_reach = array();
                foreach($actual as $keyb => $valb)
                {
                    $actual_reach[$valb['id']]['reach'] = $valb['actual_reach'];
                }

                foreach($data_actual_half as $keyb=> $valb){

                    $bws_actual_half[$valb['code']] = $valb['par'];
                }



                
                $key_count = 0;
                $target_reach = 0;
                $actual_reach_ = 0;
                $target_attendance = 0;
                $actual_attendance=0;
                foreach($reach as $key => $val){
                    if(isset($reach[$key-1])){

                        if($reach[$key-1]['code'] == $val['code'] ){    
                            $target_attendance++;
                            $detail_array[$key_count]['target_reach'] +=$val['reach'] ;
                            $detail_array[$key_count]['code'] =$val['code'];
                            $detail_array[$key_count]['target_attendance'] = $target_attendance;
                            if(isset($actual_reach[$val['route_id']])){                       
                                $actual_reach_ =$actual_reach[$val['route_id']]['reach'];                   
                                $detail_array[$key_count]['actual_reach'] +=$actual_reach_;
                            }
                            $detail_array[$key_count]['par'] = $bws_actual_half[$val['code']]; 

                        }else{
                            $key_count++;
                            $target_attendance=1;
                            $actual_attendance=0;
                             $actual_reach_ = 0;
                            $detail_array[$key_count]['target_reach'] =0;
                            $detail_array[$key_count]['target_reach'] +=$val['reach'] ;
                            $detail_array[$key_count]['code'] =$val['code'];
                            $detail_array[$key_count]['actual_attendance'] = 0;
                            $detail_array[$key_count]['actual_reach'] = 0;
                            $detail_array[$key_count]['target_attendance'] = $target_attendance;
                            if(isset($actual_reach[$val['route_id']])){                       
                                $actual_reach_ =$actual_reach[$val['route_id']]['reach'];                   
                                $detail_array[$key_count]['actual_reach'] +=$actual_reach_;
                            }
                            $detail_array[$key_count]['par'] = $bws_actual_half[$val['code']]; 
                        }

                    }else{
                        $target_attendance =1;
                        $detail_array[$key_count]['target_reach'] =0;
                        $detail_array[$key_count]['target_reach'] +=$val['reach'] ;
                        $detail_array[$key_count]['code'] =$val['code'];
                        $detail_array[$key_count]['actual_attendance'] = 0;
                        $detail_array[$key_count]['target_attendance'] = 1;
                        $detail_array[$key_count]['actual_reach'] = 0;
                        if(isset($actual_reach[$val['route_id']])){                       
                            $actual_reach_ =$actual_reach[$val['route_id']]['reach'];                   
                            $detail_array[$key_count]['actual_reach'] +=$actual_reach_;
                        }

                        $detail_array[$key_count]['par'] = $bws_actual_half[$val['code']]; 




                    }
                }
            }else{
                
                $route = $total->getAllRouteSchoolPerAgencyDetailedTeam($_GET['year'],$_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead']);
//                pr($route);
                if(count($route)>0){
                    $str='';
                    foreach($route as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1);
                    $actual_reach = $total->getActualReachSchoolTeam($str); 
                    $attendance_par = $total->getAttendancePerTeamSchool($str,$_GET['month'],$_GET['year'],1);
                    $attendance_actual = $total->getAttendancePerTeamSchool($str,$_GET['month'],$_GET['year'],0);               

                    $actual= array();               
                    foreach($actual_reach as $a => $b){
                        $actual[$b['teamCode']] =$b['actual_reach'];
                    }

                    $actual_attendance= array();
                    foreach($attendance_actual as $c => $d){
                        $actual_attendance[$d['teamCode']] =$d['actual_attendance'];
                    }
                    $actual_attendance_par= array();
                    foreach($attendance_par as $e => $f){
                        $actual_attendance_par[$f['teamCode']] =$f['actual_attendance'];
                    }

                    $detail_array['0']['target_reach'] = 0;
                    $detail_array['0']['actual_reach'] = 0;
                    $detail_array['0']['actual_attendance'] = 0;
                    $detail_array['0']['target_attendance'] = 0;
                    $detail_array['0']['par'] = 0;
                    foreach($route as $key => $val){
                         $detail_array['0']['target_reach'] +=$val['target_reach'];
                         if(isset($actual[$val['teamCode']])){
                                 $detail_array['0']['actual_reach'] =$actual[$val['teamCode']];
                         }
                         if(isset($actual_attendance[$val['teamCode']])){
                                 $detail_array['0']['actual_attendance'] =$actual_attendance[$val['teamCode']];
                         }
                         if(isset($actual_attendance_par[$val['teamCode']])){
                                 $detail_array['0']['par'] =$actual_attendance_par[$val['teamCode']];
                         }
                    }
                }
                
//                pr($route);
   
            }
//            pr($detail_array);
//            exit;
            echo json_encode($detail_array);
            
            
        }
        
        public function ActionTlAttendance()
        {
            if(isset($_GET['teamlead'])){
                $seller = 0;
            }else{
                $seller= $_GET['teamlead'];
            }
            $total = new Pome;   
            $month = $_GET['month'];
            $data_actual = $total->GetRoutePerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$seller,$_GET['year']);
            $data_actual_half = $total->GetAttendanceHalfPerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$seller,$_GET['year']);
            $bws_route = $total->getBwsRoutePerLeader($_GET['agency'],$_GET['month'],$_GET['brand'],$seller,$_GET['year']);
            $data_par = $total->GetParLeaderReach($_GET['month'],$_GET['agency'],$_GET['brand'],$seller,$_GET['year']);
            $data_attendance = array();
            $attendance =array();
            if($_GET['chasi'] == 1){
                $rt_details = array();
                $par_bws = array();
                foreach($data_actual as $keya => $vala){

                    if(isset($data_actual[$keya-1])){
                        if($data_actual[$keya-1]['id'] == $vala['id']){                 
                            $rt_details[$vala['id']]['rt_reason'] =$vala['reason_code'];
                            $rt_details[$vala['id']]['rtd_reason'] =''; 
                        }else{
                            $rt_details[$vala['id']]['rt_reason'] =$vala['reason_code'];
                            $rt_details[$vala['id']]['rtd_reason'] =''; 
                        }

                    }else{
                            $rt_details[$vala['id']]['rt_reason'] =$vala['reason_code']; 
                            $rt_details[$vala['id']]['rtd_reason'] =''; 
                    }

                }
                foreach($data_par as $keyb=> $valb){
                    $par_bws[$valb['code']] = $valb['par'];
                }

                foreach($data_actual_half as $keyb => $valb){

                    if(isset($rt_details[$valb['id']])){

                       $rt_details[$valb['id']]['rtd_reason'] = $valb['reason_code'] ;  
                    }

                }

                
                $count = 0;
                $key_count =0;
                $bws_count = 1;
                $target_attendance = 0;
                $actual_attendance=0;
                $value =0;
                unset($data_actual);
                unset($data_actual_half);
                foreach($bws_route as $key => $val){

                     if(isset($bws_route[$key-1])){

                        if($bws_route[$key-1]['code'] == $val['code'] ){

                            $target_attendance++;
                            $attendance[$key_count]['code'] = $val['code'];
                            $attendance[$key_count]['target_attendance'] = $target_attendance;
                            if(isset($rt_details[$val['id']])){
                                if($rt_details[$val['id']]['rt_reason']== '001' && $rt_details[$val['id']]['rt_reason']!= null ){
                                    $actual_attendance =0;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }elseif($rt_details[$val['id']]['rtd_reason']== '004' && $rt_details[$val['id']]['rtd_reason']!= null ){
                                    $actual_attendance =0.5;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }else{
                                    $actual_attendance =1;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance; 
                                }
                            }
                        }else{
                            $target_attendance = 0;
                            $target_attendance++;
                            $key_count++;
                            $value = 0;
                            $attendance[$key_count]['code'] = $val['code'];
                            $attendance[$key_count]['target_attendance'] = $target_attendance;
                            $attendance[$key_count]['actual_attendance'] = 0;
                            $attendance[$key_count]['par'] = $par_bws[$val['code']];
                            if(isset($rt_details[$val['id']])){
                                if($rt_details[$val['id']]['rt_reason']== '001' && $rt_details[$val['id']]['rt_reason']!= null ){
                                    $actual_attendance =0;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }elseif($rt_details[$val['id']]['rtd_reason']== '004' && $rt_details[$val['id']]['rtd_reason']!= null ){
                                    $actual_attendance =0.5;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                                }else{
                                    $actual_attendance =1;
                                    $attendance[$key_count]['actual_attendance'] += $actual_attendance; 
                                }
                            }
                        }

                    }else{

                        $target_attendance++;
                        $attendance[$key_count]['code'] = $val['code'];
                        $attendance[$key_count]['target_attendance'] = $target_attendance;
                        $attendance[$key_count]['actual_attendance'] = 0;
                        $attendance[$key_count]['par'] = $par_bws[$val['code']];
                        if(isset($rt_details[$val['id']])){
                            if($rt_details[$val['id']]['rt_reason']== '001' && $rt_details[$val['id']]['rt_reason']!= null ){
                                $actual_attendance =0;
                                $value =+ $actual_attendance;
                                $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                            }elseif($rt_details[$val['id']]['rtd_reason']== '004' && $rt_details[$val['id']]['rtd_reason']!= null ){
                                $actual_attendance =0.5;
                                $value =+ $actual_attendance;
                                $attendance[$key_count]['actual_attendance'] += $actual_attendance;
                            }else{

                                $actual_attendance =1;
                                $value =+ $actual_attendance;
                                $attendance[$key_count]['actual_attendance'] += $actual_attendance; 
                            }
                        }

                    }
                }
            }else{
                $attendance =array();
                $bws_route = $total->getTargetAttendanceByTlSchool($_GET['agency'],$_GET['month'],$_GET['brand'],$_GET['year'],$_GET['teamlead']);
                
                if(count($bws_route)>0){
                    $str='';
                    foreach($bws_route as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1); 
                    
                    $attendance_par = $total->getAttendancePerTeamSchool($str,$_GET['month'],$_GET['year'],1);
                    $attendance_actual = $total->getAttendancePerTeamSchool($str,$_GET['month'],$_GET['year'],0);

                    $actual_attendance= array();
                    foreach($attendance_actual as $c => $d){
                        $actual_attendance[$d['teamCode']] =$d['actual_attendance'];
                    }
                    $actual_attendance_par= array();
                    foreach($attendance_par as $e => $f){
                        $actual_attendance_par[$f['teamCode']] =$f['actual_attendance'];
                    }
                    $target_att = 0;
                    foreach($bws_route as $key => $val){
                        $attendance[0]['name'] = $val['teamCode'];
                        $target_att++;
                        $attendance[0]['target_attendance'] =$target_att;
                        if(isset($actual_attendance[$val['teamCode']])){
                                $attendance[0]['actual_attendance'] =$actual_attendance[$val['teamCode']];
                        }
                        if(isset($actual_attendance_par[$val['teamCode']])){
                                $attendance[0]['par'] =$actual_attendance_par[$val['teamCode']];
                        }
                    }
                    
                }
            }
            
//            pr($attendance);
            echo json_encode($attendance);
        }
        
        public function ActionTotalNationalReachOND()
        {
            if(isset($_GET['agency'])){
                $agency = $_GET['agency'];
            }else{
                $agency = 6;
            }

            $from = date($_GET['year'].'-10-01');
            $to = date($_GET['year'].'-12-31'); 

            $total = new Pome;
            if($_GET['chasi']==1){
                $reach = $total->getTargetReachQTR($from,$to,$_GET['brand']);
                $bws = $total->getBwsByAgencyQTR($agency,$from,$to,$_GET['brand']);

                $actual = $total->GetActualReachQTR($from,$to,$_GET['brand'],$_GET['agency']);   

                $data_actual_par = $total->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$_GET['year']);

                $par =0;
                $bws_par = array();
                foreach($data_actual_par as $keyb=> $valb){
                     if(isset($data_actual_par[$keyb-1])){
                        $month_name_pos = date('F',strtotime($valb['date']));

                        $month_name_neg  = date('F',strtotime($data_actual_par[$keyb-1]['date']));     
                        if($month_name_neg == $month_name_pos ){ 
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }else{
                            $par = 0;
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }
                     }else{
                        $month_name_pos = date('F',strtotime($valb['date']));   
                            $par++;
                            $bws_par[$month_name_pos] = $par ;


                     }

                }

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
                            $target_attendance ++;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name; 
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){
                                $value +=$bws_reach[$val['id']];
                                $month_name  = date('F',strtotime($val['date']));
                                $total_array[$key_count]['target_reach'] = $value; 
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
                            $month_name  = date('F',strtotime($val['date']));
                            $target_attendance =1;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name;
                            $total_array[$key_count]['target_reach'] =0;
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){                          
                                $value =$bws_reach[$val['id']];
                                $total_array[$key_count]['target_reach'] =$value;  
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
                        $target_attendance = 1;
                        $total_array[$key_count]['target_attendance'] =$target_attendance;
                        $month_name  = date('F',strtotime($val['date']));
                        $total_array[$key_count]['name'] =$month_name;
                        $total_array[$key_count]['target_reach'] =0;
                        $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                        if(isset($bws_reach[$val['id']])){                       
                            $value =$bws_reach[$val['id']];
                            $total_array[$key_count]['target_reach'] =$value ; 
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
            }else{
                $route = $total->getAllRouteSchoolPerAgency($_GET['year'],$from,$to,$_GET['agency'],$_GET['brand']);
               
                if(count($route)>0){
                    $str_a ='';
                    foreach($route as $a=> $b){
                            $str_a .=$b['id'].',';
                    }
                    $str = substr($str_a, 0, -1);
                    $reach = $total->getTargetschool($str);
                }else{
                    $reach = array();
                }
                
                

                $total_array = array();
                $total_array[0]['name'] = 'October';
                $total_array[1]['name'] = 'November';
                $total_array[2]['name'] = 'December';
                $total_array[0]['target_reach'] =0;
                $total_array[1]['target_reach'] = 0;
                $total_array[2]['target_reach'] = 0;
                $total_array[0]['par'] =0;
                $total_array[1]['par'] = 0;
                $total_array[2]['par'] = 0;
                $total_array[0]['target_attendance'] =0;
                $total_array[1]['target_attendance'] = 0;
                $total_array[2]['target_attendance'] = 0;
                $total_array[0]['actual_reach'] =0;
                $total_array[1]['actual_reach'] = 0;
                $total_array[2]['actual_reach'] = 0;
                if(count($reach)>0){
                    $str = '';
                    foreach($reach as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1);

                    $data_par = $total->getParSchool($from,$to,$_GET['year'],$str,1);
                    $data_attendance = $total->getParSchool($from,$to,$_GET['year'],$str,0);

                    $actual_reach = $total->getQTRreachchool($str);
                    
                    foreach($reach as $key => $val){

                            $month_name = date('F',strtotime($val['date']));

                            if($month_name == 'October' ){                          
                                $total_array[0]['target_reach'] +=$val['target_reach'];
                            }elseif($month_name == 'November'){
                                $total_array[1]['target_reach'] +=$val['target_reach'];
                            }else{
                                $total_array[2]['target_reach'] +=$val['target_reach'];
                            }                 
                    }    

                    $par =1;
                    foreach($data_par as $keya=> $vala){
                         $month_name = date('F',strtotime($vala['date']));

                            if($month_name == 'October' ){                          
                                $total_array[0]['par'] +=$par;
                            }elseif($month_name == 'November'){
                                $total_array[1]['par'] +=$par;
                            }else{
                                $total_array[2]['par'] +=$par;
                            }
                    }
                    $attendance =1;
                    foreach($data_attendance as $keyb=> $valb){
                         $month_name = date('F',strtotime($valb['date']));

                            if($month_name == 'October' ){                          
                                $total_array[0]['target_attendance'] +=$attendance;
                            }elseif($month_name == 'November'){
                                $total_array[1]['target_attendance'] +=$attendance;
                            }else{
                                $total_array[2]['target_attendance'] +=$attendance;
                            }
                    }
                    foreach($actual_reach as $keyc => $valc){

                            $month_name = date('F',strtotime($valc['date']));

                            if($month_name == 'October' ){                          
                                $total_array[0]['actual_reach'] +=$valc['actual_reach'];
                            }elseif($month_name == 'November'){
                                $total_array[1]['actual_reach'] +=$valc['actual_reach'];
                            }else{
                                $total_array[2]['actual_reach'] +=$valc['actual_reach'];
                            }                 
                    }  
            }
               
//                pr($total_array);
//                exit;
            }
//         pr($total_array);
            echo json_encode($total_array);
            
            
        }
        
        public function ActionTotalNationalReachJFM()
        {
            if(isset($_GET['agency'])){
                $agency = $_GET['agency'];
            }else{
                $agency = 6;
            }
            $year = $_GET['year'] +1;
            $from = date($year.'-01-01');
            $to = date($year.'-03-31'); 

            $total = new Pome;
            if($_GET['chasi'] == 1){
                $reach = $total->getTargetReachQTR($from,$to,$_GET['brand']);
                $bws = $total->getBwsByAgencyQTR($agency,$from,$to,$_GET['brand']);

                $actual = $total->GetActualReachQTR($from,$to,$_GET['brand'],$_GET['agency']);   

                $data_actual_par = $total->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$year);

                $par =0;
                $bws_par = array();
                foreach($data_actual_par as $keyb=> $valb){
                     if(isset($data_actual_par[$keyb-1])){
                        $month_name_pos = date('F',strtotime($valb['date']));

                        $month_name_neg  = date('F',strtotime($data_actual_par[$keyb-1]['date']));     
                        if($month_name_neg == $month_name_pos ){ 
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }else{
                            $par = 0;
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }
                     }else{
                        $month_name_pos = date('F',strtotime($valb['date']));   
                            $par++;
                            $bws_par[$month_name_pos] = $par ;


                     }

                }

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
                            $target_attendance ++;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name; 
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){
                                $value +=$bws_reach[$val['id']];
                                $month_name  = date('F',strtotime($val['date']));
                                $total_array[$key_count]['target_reach'] = $value; 
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
                            $month_name  = date('F',strtotime($val['date']));
                            $target_attendance =1;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name;
                            $total_array[$key_count]['target_reach'] =0;
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){                          
                                $value =$bws_reach[$val['id']];
                                $total_array[$key_count]['target_reach'] =$value;  
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
                        $target_attendance = 1;
                        $total_array[$key_count]['target_attendance'] =$target_attendance;
                        $month_name  = date('F',strtotime($val['date']));
                        $total_array[$key_count]['name'] =$month_name;
                        $total_array[$key_count]['target_reach'] =0;
                        $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                        if(isset($bws_reach[$val['id']])){                       
                            $value =$bws_reach[$val['id']];
                            $total_array[$key_count]['target_reach'] =$value ; 
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
            }else{
                $route = $total->getAllRouteSchoolPerAgency($year,$from,$to,$_GET['agency'],$_GET['brand']);
               
                if(count($route)>0){
                    $str_a ='';
                    foreach($route as $a=> $b){
                            $str_a .=$b['id'].',';
                    }
                    $str = substr($str_a, 0, -1);
                    $reach = $total->getTargetschool($str);
                }else{
                    $reach = array();
                }
                
//                pr($reach);
//                exit;

                $total_array = array();
                $total_array[0]['name'] = 'January';
                $total_array[1]['name'] = 'February';
                $total_array[2]['name'] = 'March';
                $total_array[0]['target_reach'] =0;
                $total_array[1]['target_reach'] = 0;
                $total_array[2]['target_reach'] = 0;
                $total_array[0]['par'] =0;
                $total_array[1]['par'] = 0;
                $total_array[2]['par'] = 0;
                $total_array[0]['target_attendance'] =0;
                $total_array[1]['target_attendance'] = 0;
                $total_array[2]['target_attendance'] = 0;
                $total_array[0]['actual_reach'] =0;
                $total_array[1]['actual_reach'] = 0;
                $total_array[2]['actual_reach'] = 0;
                
                if(count($reach)>0){
                    $str = '';
                    foreach($reach as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1);

                    $data_par = $total->getParSchool($from,$to,$year,$str,1);
                    $data_attendance = $total->getParSchool($from,$to,$year,$str,0);

                    $actual_reach = $total->getQTRreachchool($str);
                    foreach($reach as $key => $val){

                            $month_name = date('F',strtotime($val['date']));

                            if($month_name == 'January' ){                          
                                $total_array[0]['target_reach'] +=$val['target_reach'];
                            }elseif($month_name == 'February'){
                                $total_array[1]['target_reach'] +=$val['target_reach'];
                            }else{
                                $total_array[2]['target_reach'] +=$val['target_reach'];
                            }                 
                    }    

                    $par =1;
                    foreach($data_par as $keya=> $vala){
                         $month_name = date('F',strtotime($vala['date']));

                            if($month_name == 'January' ){                          
                                $total_array[0]['par'] +=$par;
                            }elseif($month_name == 'February'){
                                $total_array[1]['par'] +=$par;
                            }else{
                                $total_array[2]['par'] +=$par;
                            }
                    }
                    $attendance =1;
                    foreach($data_attendance as $keyb=> $valb){
                         $month_name = date('F',strtotime($valb['date']));

                            if($month_name == 'January' ){                          
                                $total_array[0]['target_attendance'] +=$attendance;
                            }elseif($month_name == 'February'){
                                $total_array[1]['target_attendance'] +=$attendance;
                            }else{
                                $total_array[2]['target_attendance'] +=$attendance;
                            }
                    }
                    foreach($actual_reach as $keyc => $valc){

                            $month_name = date('F',strtotime($valc['date']));

                            if($month_name == 'January' ){                          
                                $total_array[0]['actual_reach'] +=$valc['actual_reach'];
                            }elseif($month_name == 'February'){
                                $total_array[1]['actual_reach'] +=$valc['actual_reach'];
                            }else{
                                $total_array[2]['actual_reach'] +=$valc['actual_reach'];
                            }                 
                    }   
                }
               
//                pr($total_array);
//                exit;
            }

            echo json_encode($total_array);
            
            
        }
        
        public function ActionTotalNationalReachAMJ()
        {
            if(isset($_GET['agency'])){
                $agency = $_GET['agency'];
            }else{
                $agency = 6;
            }
            $year = $_GET['year'] +1;
            $from = date($year.'-04-01');
            $to = date($year.'-06-30'); 

            $total = new Pome;
            if($_GET['chasi'] == 1){
                $reach = $total->getTargetReachQTR($from,$to,$_GET['brand']);
                $bws = $total->getBwsByAgencyQTR($agency,$from,$to,$_GET['brand']);

                $actual = $total->GetActualReachQTR($from,$to,$_GET['brand'],$_GET['agency']);   

                $data_actual_par = $total->getParTotalNational($_GET['agency'],$from,$to,$_GET['brand'],$year);

                $par =0;
                $bws_par = array();
                foreach($data_actual_par as $keyb=> $valb){
                     if(isset($data_actual_par[$keyb-1])){
                        $month_name_pos = date('F',strtotime($valb['date']));

                        $month_name_neg  = date('F',strtotime($data_actual_par[$keyb-1]['date']));     
                        if($month_name_neg == $month_name_pos ){ 
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }else{
                            $par = 0;
                            $par++;

                            $bws_par[$month_name_pos] = $par ;

                        }
                     }else{
                        $month_name_pos = date('F',strtotime($valb['date']));   
                            $par++;
                            $bws_par[$month_name_pos] = $par ;


                     }

                }

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
                            $target_attendance ++;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name; 
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){
                                $value +=$bws_reach[$val['id']];
                                $month_name  = date('F',strtotime($val['date']));
                                $total_array[$key_count]['target_reach'] = $value; 
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
                            $month_name  = date('F',strtotime($val['date']));
                            $target_attendance =1;
                            $total_array[$key_count]['target_attendance'] =$target_attendance;
                            $total_array[$key_count]['name'] =$month_name;
                            $total_array[$key_count]['target_reach'] =0;
                            $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                            if(isset($bws_reach[$val['id']])){                          
                                $value =$bws_reach[$val['id']];
                                $total_array[$key_count]['target_reach'] =$value;  
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
                        $target_attendance = 1;
                        $total_array[$key_count]['target_attendance'] =$target_attendance;
                        $month_name  = date('F',strtotime($val['date']));
                        $total_array[$key_count]['name'] =$month_name;
                        $total_array[$key_count]['target_reach'] =0;
                        $total_array[$key_count]['par'] =isset($bws_par[$month_name]) ?$bws_par[$month_name]:''; 
                        if(isset($bws_reach[$val['id']])){                       
                            $value =$bws_reach[$val['id']];
                            $total_array[$key_count]['target_reach'] =$value ; 
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
            }else{
                $route = $total->getAllRouteSchoolPerAgency($year,$from,$to,$_GET['agency'],$_GET['brand']);
               
                if(count($route)>0){
                    $str_a ='';
                    foreach($route as $a=> $b){
                            $str_a .=$b['id'].',';
                    }
                    $str = substr($str_a, 0, -1);
                    $reach = $total->getTargetschool($str);
                }else{
                    $reach = array();
                }
                
               

                $total_array = array();
                $total_array[0]['name'] = 'April';
                $total_array[1]['name'] = 'May';
                $total_array[2]['name'] = 'June';
                $total_array[0]['target_reach'] =0;
                $total_array[1]['target_reach'] = 0;
                $total_array[2]['target_reach'] = 0;
                $total_array[0]['par'] =0;
                $total_array[1]['par'] = 0;
                $total_array[2]['par'] = 0;
                $total_array[0]['target_attendance'] =0;
                $total_array[1]['target_attendance'] = 0;
                $total_array[2]['target_attendance'] = 0;
                $total_array[0]['actual_reach'] =0;
                $total_array[1]['actual_reach'] = 0;
                $total_array[2]['actual_reach'] = 0;
                
                if(count($reach)>0){
                    $str = '';
                    foreach($reach as $k => $v){
                        $str .=$v['id'].',';
                    }
                    $str = substr($str, 0, -1);

                    $data_par = $total->getParSchool($from,$to,$year,$str,1);
                    $data_attendance = $total->getParSchool($from,$to,$year,$str,0);

                    $actual_reach = $total->getQTRreachchool($str);
                    
                    foreach($reach as $key => $val){

                            $month_name = date('F',strtotime($val['date']));

                            if($month_name == 'April' ){                          
                                $total_array[0]['target_reach'] +=$val['target_reach'];
                            }elseif($month_name == 'May'){
                                $total_array[1]['target_reach'] +=$val['target_reach'];
                            }else{
                                $total_array[2]['target_reach'] +=$val['target_reach'];
                            }                 
                    }    

                    $par =1;
                    foreach($data_par as $keya=> $vala){
                         $month_name = date('F',strtotime($vala['date']));

                            if($month_name == 'April' ){                          
                                $total_array[0]['par'] +=$par;
                            }elseif($month_name == 'May'){
                                $total_array[1]['par'] +=$par;
                            }else{
                                $total_array[2]['par'] +=$par;
                            }
                    }
                    $attendance =1;
                    foreach($data_attendance as $keyb=> $valb){
                         $month_name = date('F',strtotime($valb['date']));

                            if($month_name == 'April' ){                          
                                $total_array[0]['target_attendance'] +=$attendance;
                            }elseif($month_name == 'May'){
                                $total_array[1]['target_attendance'] +=$attendance;
                            }else{
                                $total_array[2]['target_attendance'] +=$attendance;
                            }
                    }
                    foreach($actual_reach as $keyc => $valc){

                            $month_name = date('F',strtotime($valc['date']));

                            if($month_name == 'April' ){                          
                                $total_array[0]['actual_reach'] +=$valc['actual_reach'];
                            }elseif($month_name == 'May'){
                                $total_array[1]['actual_reach'] +=$valc['actual_reach'];
                            }else{
                                $total_array[2]['actual_reach'] +=$valc['actual_reach'];
                            }                 
                    }   
                }
            
               
//                pr($total_array);
//                exit;
            }
//         pr($total_array);
            echo json_encode($total_array);
            
            
        }
        
        public function actionTlQa()
        {
            $total = new Pome;   
          
            if(isset($_GET['teamlead'])){
                $seller = 0;
            }else{
                $seller= $_GET['teamlead'];
            }
            $seller = $total->getBwsPerTl($seller);
            
            $str = '';
            foreach($seller as $keyb => $valb){
                    $str .= $valb['id'].',';
            }
            $str = substr($str,0,-1);
            $survey = $total->getTotalSurvey($str,$_GET['ph'],$_GET['month'],$_GET['year']);
            
            $survey_array = array();
            $previous = '';
            foreach($survey as $keyb => $valb){
//                    $code = substr($valb['code'],5);
//                if($previous == $valb['code']){
                    $survey_array[$valb['code']]= $valb['answer'];  
//                }else{
//                    $survey_array[$valb['code']]+= $valb['answer'];
//                }
            }

            $score = 20;
            
            $seller_array = array();
            foreach($seller as $key => $val){
             
                $seller_array[$key]['bws'] = $val['code'];
                $seller_array[$key]['id'] = $val['id'];
                $seller_array[$key]['total'] = 0;
                $seller_array[$key]['score'] = $score;
                if(isset($survey_array[$val['code']])){                       
                     $seller_array[$key]['total'] =$survey_array[$val['code']] ; 
                }
                
            }
//            pr($seller_array);
//            exit;
           echo json_encode($seller_array);
            
            
        }
}