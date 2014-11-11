<?php

class InfraReportForm extends CFormModel {

   public $brand;
   public $cover_date;

   /**
    * Declares the validation rules.
    * The rules state that username and password are required,
    * and password needs to be authenticated.
    */
   public function rules() {
      return array(
          array('cover_date', 'required'),
          array('cover_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
          array('brand', 'safe'),
      );
   }

   /**
    * Declares attribute labels.
    */
   public function attributeLabels() {
      return array(
          'brand' => 'Brand',
          'cover_date' => 'Covered Date',
      );
   }


   public function getWarehouse() {



      $sql = "SELECT a.sales_office_name, a.sales_office_id, a.default_zone_id
               FROM sales_office a
               WHERE a.company_id = '" . Yii::app()->user->company_id . "'
               ORDER BY a.sales_office_name";
     
      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();
     
      return $data;
   }

   public function getHeader($brand) {

      $qry = array();

      $sql = "SELECT a.sku_name,a.sku_id FROM sku a WHERE a.brand_id = '" . $brand . "' AND a.type = 'INFRA' ORDER BY a.sku_name";

      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();

      return $data;
   }

   public function getData($brand, $dates) {

      $qry = array();

      $sql = "SELECT a.zone_id, b.sku_id, b.sku_name, SUM(a.qty) AS qty, e.sales_office_id
               FROM inventory a
               INNER JOIN sku b ON b.sku_id = a.sku_id
               INNER JOIN brand c ON c.brand_id = b.brand_id
               INNER JOIN zone d ON d.zone_id = a.zone_id
               INNER JOIN sales_office e ON e.sales_office_id = d.sales_office_id
               WHERE c.brand_id = '" . $brand . "' 
               AND a.transaction_date BETWEEN '" . $dates . "  00:00:00' AND  '" . $dates . " 23:59:59'
               AND b.type = 'INFRA'
               GROUP BY e.sales_office_id, b.sku_id";
      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();
      return $data;
   }

}
