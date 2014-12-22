<?php

class TlController extends Controller
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
            $survey = new Survey;
            $data = $model->getAllAgency();            
            $data1 = $model->getAllRegion();       
            $data2 = $model->getAllBrand();       
//            $data_b = $model->getAllBwsTeam(); 
            $data_3 =  $survey->getTlDetailForTL();    

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

            
                
          
            $agency = CHtml::listData($data, 'id', 'name');
            $region = CHtml::listData($data1, 'id', 'name');
            $month = CHtml::listData($month, 'id', 'name');
            $ph = CHtml::listData($ph, 'id', 'name');
            $qtr = CHtml::listData($qtr, 'name', 'name');
            $brand= CHtml::listData($brand,'id', 'name');
       
            $teamlead= CHtml::listData($data_3,'id','code');

            
            $year= CHtml::listData($year,'id', 'id');

   

            
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
//                'bws' => $bws,

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
         
        public function ActionTlReach()
        {

            $total = new Pome;           
            $reach = $total->getTargetReachPerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead'],$_GET['ph'],$_GET['year']);
            $stra='';
            foreach($reach as $keya => $vala){
                $stra .=$vala['route_id'].","; 
            }

            $stra = substr($stra, 0, -1); 
            $actual = $total->getActualReachPerLeader($_GET['agency'],$_GET['brand'],$_GET['teamlead'],$stra,$_GET['ph']);
            $data_actual_half = $total->GetParLeaderReach($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead'],$_GET['year']);
            $actual_reach = array();
            foreach($actual as $keyb => $valb)
            {
                $actual_reach[$valb['id']]['reach'] = $valb['actual_reach'];
            }
           
            foreach($data_actual_half as $keyb=> $valb){
                
                $bws_actual_half[$valb['code']] = $valb['par'];
            }
            
    
            
            $detail_array = array();
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
//            pr($detail_array);
//            exit;
            echo json_encode($detail_array);
            
            
        }
        
        public function ActionTlAttendance()
        {
           
            $total = new Pome;   
            $month = $_GET['month'];
            $data_actual = $total->GetRoutePerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead'],$_GET['year']);
            $data_actual_half = $total->GetAttendanceHalfPerLeader($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead'],$_GET['year']);
            $bws_route = $total->getBwsRoutePerLeader($_GET['agency'],$_GET['month'],$_GET['brand'],$_GET['teamlead'],$_GET['year']);
            $data_par = $total->GetParLeaderReach($_GET['month'],$_GET['agency'],$_GET['brand'],$_GET['teamlead'],$_GET['year']);
            $data_attendance = array();
 
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
            
            $attendance =array();
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
            
//            pr($attendance);
            echo json_encode($attendance);
        }
  
        
  
        
        public function actionTlQa()
        {
            $total = new Pome;   
          
            $seller = $total->getBwsPerTl($_GET['teamlead']);
//            pr($seller);
//            exit;
            
           
            $str = '';
            foreach($seller as $keyb => $valb){
                    $str .= $valb['id'].',';
            }
//            pr($seller);
            $str = substr($str,0,-1);
            
            $survey = $total->getTotalSurvey($str,$_GET['ph'],$_GET['month'],$_GET['year']);
//            pr($survey);
//            exit;
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