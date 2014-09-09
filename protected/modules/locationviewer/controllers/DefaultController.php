<?php

class DefaultController extends Controller {
   
   

   public function actionIndex() {
      $this->pageTitle = 'Location Viewer';
      $this->layout = '//layouts/column1';

     
      $data = array();
      //pre($data);

      $this->render('index', array('model' => $data));
   }
   public function actionGetHousehold()
   {
      $address = isset($_POST['address']) ? $_POST['address'] : "";      
      $model = new RouteTransaction;
      $data = $model->getValue($address);
      $this->renderPartial('_table', array('model' => $data));
   }
   
   public function actionGetInfo()
   {
      $id = isset($_POST['id']) ? $_POST['id'] : "";      
      $model = new RouteTransaction;
      $data = $model->getBInfo($id);
      //pre($data);
      
      $this->renderPartial('_info', array('model' => $data));
   }
   
   public function actionSetMarker()
   {
      $address = isset($_POST['address']) ? $_POST['address'] : "";      
      $model = new RouteTransaction;
      $data = $model->getMarker($address);
     echo json_encode($data);
//pr($data);
//$this->renderPartial('_marker', array('model' => $data));
   }
   
   public function actionGetAddress()
   {
      if (isset($_POST['lat']) && isset($_POST['lon']))
      {
         $lat = $_POST['lat'];
         $lon = $_POST['lon'];
      }
     else
     {
        $lat = "";
        $lon = "";
     }
      
      $model = new RouteTransaction;
       $data = $model->getAddress($lat,$lon);
       
       pr($data);
      
   }
   

}