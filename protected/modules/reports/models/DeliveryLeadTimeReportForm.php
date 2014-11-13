<?php

class DeliveryLeadTimeReportForm extends CFormModel {

   public $destination;
   public $from_date;
   public $to_date;

   /**
    * Declares the validation rules.
    * The rules state that username and password are required,
    * and password needs to be authenticated.
    */
   public function rules() {
      return array(
          array('from_date, to_date', 'required'),
          array('from_date, to_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
          array('destination', 'safe'),
      );
   }

   /**
    * Declares attribute labels.
    */
   public function attributeLabels() {
      return array(
          'destination' => 'Destination',
          'from_date' => 'From Date',
          'to_date' => 'To Date',
      );
   }

   public function getWarehouse() {



      $sql = "SELECT a.sales_office_name, a.sales_office_id,a.default_zone_id
               FROM sales_office a
               INNER JOIN zone b ON b.zone_id = a.default_zone_id
               WHERE a.company_id = '" . Yii::app()->user->company_id . "'
               ORDER BY a.sales_office_name";

      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();

      return $data;
   }

   public function getHeader($brand) {

      $qry = array();

      $sql = "SELECT a.sku_name,a.sku_id FROM sku a WHERE a.brand_id = '" . $brand . "' AND a.type = 'INFRA'ORDER BY a.sku_name";

      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();

      return $data;
   }

   public function getData($destination, $from_date, $to_date) {

      $qry = array();
     
      switch ($destination) {
         case "SW":
            $sql = "SELECT b.supplier_name, c.sales_office_name, a.campaign_no, a.pr_no, a.pr_date, a.plan_delivery_date, a.dr_no, a.dr_date, a.transaction_date
               FROM receiving_inventory a
               INNER JOIN supplier b ON b.supplier_id = a.supplier_id
               LEFT JOIN sales_office c ON c.default_zone_id = a.zone_id
               WHERE a.transaction_date BETWEEN '" . $from_date . " 00:00:00' AND '" . $to_date . " 23:59:59'
               ";
            break;
         case "WS":
            $sql = "SELECT (SELECT sales_office_name FROM sales_office WHERE sales_office_id = b.distributor_id ) AS warehouse, b.sales_office_name, c.campaign_no, c.pr_no, c.pr_date, a.plan_delivery_date, a.dr_no, a.dr_date, a.transaction_date
               FROM incoming_inventory a
               INNER JOIN zone d ON d.zone_id = a.destination_zone_id 
               INNER JOIN sales_office b ON b.sales_office_id = d.sales_office_id
               INNER JOIN incoming_inventory_detail c ON c.incoming_inventory_id = a.incoming_inventory_id
               WHERE a.transaction_date BETWEEN '" . $from_date . " 00:00:00' AND '" . $to_date . " 23:59:59'
               ";
            break;
         case "SO":
            $sql = "SELECT d.sales_office_name, e.short_name, b.campaign_no, b.pr_no, a.rra_no, a.rra_date, a.dr_no, a.dr_date, b.plan_arrival_date, a.transaction_date
               FROM  customer_item a
               INNER JOIN customer_item_detail b ON b.customer_item_id = a.customer_item_id 
               INNER JOIN zone c ON c.zone_id = b.source_zone_id
               INNER JOIN sales_office d ON d.sales_office_id = c.sales_office_id
               INNER JOIN poi e ON e.poi_id = a.poi_id
               WHERE a.transaction_date BETWEEN '" . $from_date . " 00:00:00' AND '" . $to_date . " 23:59:59'
               ";
            break;
         default:
            $sql = "";
            break;
      }
      if ($sql == "" ){
         return false;
      }
      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();// pr($sql); pre($data);
      return $data;
   }

}
