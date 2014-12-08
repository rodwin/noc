<?php

class SurveyController extends Controller
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
	{     
            $this->layout='//layouts/column1';
            
            $survey = new Survey;
            
            $data_a =  $survey->getHospitalByPh('PH1');
            $data_b =  $survey->getTlDetail();
           
            $question =  $survey->getQuestionare();
            $survey->team_leader_id = $data_b['id'];
//            pr($survey->team_leader_id);
            
            $data =  $survey->getBwsPerTl($survey->team_leader_id);
//            pr($data);
//            exit;
            $ph[0]['id']='PH1';
            $ph[0]['name']='PH1';
            $ph[2]['id']='PH2';
            $ph[2]['name']='PH2';
            
            $bws = CHtml::listData($data, 'id', 'code');
            $ph = CHtml::listData($ph, 'id', 'name');
            $hospital = CHtml::listData($data_a, 'outlet_id', 'outlet_code');
            
            
            if(isset($_POST['Survey'])){
   
               $survey->attributes =$_POST['Survey'];
                $_POST['Survey']['team_id'] = $survey->team_leader_id;
//                pr($_POST);
//             exit;
                if($survey->validate()){
                   $survey->saveSurvey($_POST);
                    Yii::app()->user->setFlash('success', "Successfully created"); 
                } 
                
            }
            $question_array = array();
            $previous = '';
            foreach($question as $key => $val){
     
                    $question_array[$val['header']][] =$val['question']; 

            }
//            pr($question_array);
//            exit;
            $this->render('survey', array(
              'model' => $survey,
                'bws' => $bws,
                'ph' => $ph,
                'hospital' => $hospital,
                'question' => $question_array,

            ));
        }
        
        public function actiongetBwsDetail()
        {
            
            $survey = new Survey;
            $data = $survey->getBwsDetailbyId($_GET['bws_id']);    
            
           echo json_encode($data);
            
        }
        
        public function actiongetHospitalByPh()
        {
            echo "<option value=''>Select Hospital</option>";
            $model = new survey;
            $data = $model->getHospitalByPh($_GET['id']);    
            
            foreach ($data as $key => $val) {
            echo CHtml::tag('option', array('value' => $val['outlet_id']), CHtml::encode($val['outlet_code']), true);
             }
//            
                    
        }
        
        
}