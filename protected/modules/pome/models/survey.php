<?php

class Survey extends CFormModel {
    
    public $bws;
    /**
    * @var string bws
    * @soap
    */
    
    public $a;
    /**
    * @var string bws
    * @soap
    */
    
    public $b;
    /**
    * @var string bws
    * @soap
    */
    
    public $c;
    /**
    * @var string bws
    * @soap
    */
    
    public $d;
    /**
    * @var string bws
    * @soap
    */
    
    public $e;
    /**
    * @var string bws
    * @soap
    */
    
    public $f;
    /**
    * @var string bws
    * @soap
    */
    
    public $g;
    /**
    * @var string bws
    * @soap
    */
    
    public $h;
    /**
    * @var string bws
    * @soap
    */
    
    public $i;
    /**
    * @var string bws
    * @soap
    */
    
    public $j;
    /**
    * @var string bws
    * @soap
    */
    
    public $k;
    /**
    * @var string bws
    * @soap
    */
    
    public $l;
    /**
    * @var string bws
    * @soap
    */
    
    public $m;
    /**
    * @var string bws
    * @soap
    */
    
    public $n;
    /**
    * @var string bws
    * @soap
    */
    
    public $o;
    /**
    * @var string bws
    * @soap
    */
    
    public $p;
    /**
    * @var string bws
    * @soap
    */
    
    public $q;
    /**
    * @var string bws
    * @soap
    */
    
    public $r;
    /**
    * @var string bws
    * @soap
    */
    
    public $s;
    /**
    * @var string bws
    * @soap
    */
    
    public $t;
    /**
    * @var string bws
    * @soap
    */
    
     public $hospital;   
    /**
    * @var string qone
    * @soap
    */
     
     public $date;   
    /**
    * @var string qone
    * @soap
    */
     
     public $rater;   
    /**
    * @var string qone
    * @soap
    */
     
    public $ph;   
    /**
    * @var string qone
    * @soap
    */
    
    public $team_leader_id;   
    /**
    * @var string qone
    * @soap
    */
    
    public function attributeLabels()
    {
            return array(
                    'bws'=>'Bws',
                    'ph'=>'Ph',
                   
                 

            );
    }
    
     public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bws,hospital,ph', 'required'),
            array('a,b,c,d,e,f,g,h,i,,j,k,l,m,n,o,p,q,r,s,t', 'numerical', 'integerOnly' => true),
   
      );
    }
    
    public function getTlDetail()
    {
//        echo "asd";
        $code = Yii::app()->user->userObj->user_name;
        $sql = "SELECT *
                FROM [pg_mapping].[dbo].[pome_pps]
                where code = '$code' ";
//        pr($sql);
        $command = Yii::app()->db3->createCommand($sql);
        $leader = $command->queryRow();
//        pr($leader);
        return $leader;
    }
    
    public function getBwsPerTl($team_id = "")
    {
//      pr($this->team_leader_id);
//        exit;
        if($team_id != ""){
            $team = 'and parent_leader ='.$team_id;
        }else{
            $team = "";
        }
        $sql = "SELECT *
                FROM [pg_mapping].[dbo].[pome_pps]
                where team_leader = 0 and agency_id = 6 $team
                order by code";
//        pr($sql);
      $command = Yii::app()->db3->createCommand($sql);
      $data = $command->queryAll();


      return $data;
    }
    
    public function getBwsDetailbyId($id)
    {
         $sql = "SELECT *
                FROM [pg_mapping].[dbo].[pome_pps]
                where id = $id";
         
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryRow();


        return $data;
    }
    public function getHospitalByPh($ph)
    {
         $sql = "SELECT outlet_code+'('+ outlet_name+')' as outlet_code,outlet_id
                FROM [pg_mapping].[dbo].[outlets]
                where storetype_id = 27 and class ='$ph'";
         
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();


        return $data;
    }
    
    public function getQuestionare()
    {
        $sql ="SELECT *
                from [pg_mapping].[dbo].[question]
                ";
        
        $command = Yii::app()->db3->createCommand($sql);
        $data = $command->queryAll();


        return $data;
    }
    
//    public function saveSurvey($data)
//    {
//     pr($data);
//     exit;
//            $sql = "INSERT INTO [pg_mapping].[dbo].[pome_qa]
//                            ([pps_id]
//                            ,[hospital]
//                            ,[date_checked]
//                            ,[name_of_rater]
//                            ,[ph_class]
//                            ,[added_by]
//                            ,[q1]
//                            ,[q2]
//                            ,[q3]
//                            ,[q4]
//                            ,[q5]
//                            ,[q6]
//                            ,[q7]
//                            ,[q8]
//                            ,[q9]
//                            ,[q10]
//                            ,[q11]
//                            ,[q12]
//                            ,[q13]
//                            ,[q14]
//                            ,[q15]
//                            ,[q16]
//                            ,[q17]
//                            ,[q18]
//                            ,[q19]
//                            ,[q20]
//   
//                            )
//                      VALUES
//                            (:bws
//                            ,:hospital
//                            ,:date
//                            ,:rater
//                            ,:ph
//                            ,:added_by
//                            ,:a
//                            ,:b
//                            ,:c
//                            ,:d
//                            ,:e
//                            ,:f
//                            ,:g
//                            ,:h
//                            ,:i
//                            ,:j
//                            ,:k
//                            ,:l
//                            ,:m
//                            ,:n
//                            ,:o
//                            ,:p
//                            ,:q
//                            ,:r
//                            ,:s
//                            ,:t
//            
//
//                            )";
//
//            $command = Yii::app()->db3->createCommand($sql);
//            $command->bindParam(':bws', $data['bws'], PDO::PARAM_INT);
//            $command->bindParam(':hospital', $data['hospital'], PDO::PARAM_STR);
//            $command->bindParam(':date', $data['date'], PDO::PARAM_STR);
//            $command->bindParam(':rater', $data['rater'], PDO::PARAM_STR);
//            $command->bindParam(':ph', $data['ph'], PDO::PARAM_STR);
//            $command->bindParam(':added_by', $data['team_id'], PDO::PARAM_INT);
//            $command->bindParam(':a', $data['a'], PDO::PARAM_INT);
//            $command->bindParam(':b', $data['b'], PDO::PARAM_INT);
//            $command->bindParam(':c', $data['c'], PDO::PARAM_INT);
//            $command->bindParam(':d', $data['d'], PDO::PARAM_INT);
//            $command->bindParam(':e', $data['e'], PDO::PARAM_INT);
//            $command->bindParam(':f', $data['f'], PDO::PARAM_INT);
//            $command->bindParam(':g', $data['g'], PDO::PARAM_INT);
//            $command->bindParam(':h', $data['h'], PDO::PARAM_INT);
//            $command->bindParam(':i', $data['i'], PDO::PARAM_INT);
//            $command->bindParam(':j', $data['j'], PDO::PARAM_INT);
//            $command->bindParam(':k', $data['k'], PDO::PARAM_INT);
//            $command->bindParam(':l', $data['l'], PDO::PARAM_INT);
//            $command->bindParam(':m', $data['m'], PDO::PARAM_INT);
//            $command->bindParam(':n', $data['n'], PDO::PARAM_INT);
//            $command->bindParam(':o', $data['o'], PDO::PARAM_INT);
//            $command->bindParam(':p', $data['p'], PDO::PARAM_INT);
//            $command->bindParam(':q', $data['q'], PDO::PARAM_INT);
//            $command->bindParam(':r', $data['r'], PDO::PARAM_INT);
//            $command->bindParam(':s', $data['s'], PDO::PARAM_INT);
//            $command->bindParam(':t', $data['t'], PDO::PARAM_INT);
//
//            $command->execute();
//        
//    }
    
    public function saveSurvey($data)
    {
        $code = Yii::app()->user->userObj->user_name;
        if($data['Survey']['team_id'] ==''){
            $sql ="SELECT *
                from [pg_mapping].[dbo].[user] where user_name = '$code'
                ";

            $command = Yii::app()->db3->createCommand($sql);
            $user = $command->queryRow();
            $team_id = $user['id']; 
        }else{
            $team_id = $data['Survey']['team_id'];
        }
//        pr($team_id);
//        exit;
        foreach($data['question'] as $key => $val){
                    $sql = "INSERT INTO [pg_mapping].[dbo].[pome_qachecklist]
                            ([pps_id]
                            ,[hospital]
                            ,[date_checked]
                            ,[name_of_rater]
                            ,[ph_class]
                            ,[added_by]
                            ,[question]
                            ,[answer]
 
                            )
                      VALUES
                            (:bws
                            ,:hospital
                            ,:date
                            ,:rater
                            ,:ph
                            ,:added_by
                            ,:question
                            ,:answer
                           
            

                            )";

            $command = Yii::app()->db3->createCommand($sql);
            $command->bindParam(':bws', $data['Survey']['bws'], PDO::PARAM_INT);
            $command->bindParam(':hospital', $data['Survey']['hospital'], PDO::PARAM_STR);
            $command->bindParam(':date', $data['Survey']['date'], PDO::PARAM_STR);
            $command->bindParam(':rater', $code, PDO::PARAM_STR);
            $command->bindParam(':ph', $data['Survey']['ph'], PDO::PARAM_STR);
            $command->bindParam(':added_by', $team_id, PDO::PARAM_INT);
            $command->bindParam(':question', $data['question'][$key], PDO::PARAM_STR);
            $command->bindParam(':answer', $data['answer'][$key], PDO::PARAM_STR);
     

            $command->execute();
        }
    }
    
    public function getTlDetailForTL()
    {
//        echo "asd";
        $code = Yii::app()->user->userObj->user_name;
        $sql = "SELECT *
                FROM [pg_mapping].[dbo].[pome_pps]
                where code = '$code' ";
//        pr($sql);
        $command = Yii::app()->db3->createCommand($sql);
        $leader = $command->queryAll();
//        pr($leader);
        return $leader;
    }
    
  
}

?>