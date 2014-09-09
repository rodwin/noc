<?php

class RouteTransaction extends CFormModel {

   public function getValue($address) {


      $sql = "SELECT a.[id]
      ,a.[sales_order_id]
      ,LTRIM(RTRIM(a.[first_name] + ' ' + a.[last_name])) as name
      ,a.[mobile_number]
      ,a.[address1]
      ,b.longitude
      ,b.latitude
      FROM [pg_mapping_indonesia].[dbo].[route_transaction_detail_account] a
       INNER JOIN [pg_mapping_indonesia].[dbo].[nextgen_sales_order] b
      ON a.[sales_order_id] = b.[id]
      WHERE a.[address1] LIKE '%" . $address . "%'
      ORDER BY a.[id] asc";
      $command = Yii::app()->db2->createCommand($sql);
      $data = $command->queryAll();


      return $data;
   }

   public function getBInfo($id) {


      $sql = "SELECT a.[id]
      ,a.[sales_order_id]
      ,LTRIM(RTRIM(a.[first_name] + ' ' + a.[last_name])) as name
      ,a.[mobile_number]
      ,a.[address1]
      ,(SELECT [type] FROM [pg_mapping_indonesia].[dbo].[survey] WHERE [product_type] = 1 AND [sales_order_id] = a.[sales_order_id] ) as facial
      ,(SELECT [type] FROM [pg_mapping_indonesia].[dbo].[survey] WHERE [product_type] = 2 AND [sales_order_id] = a.[sales_order_id] ) as diaper
      ,(SELECT [type] FROM [pg_mapping_indonesia].[dbo].[survey] WHERE [product_type] = 3 AND [sales_order_id] = a.[sales_order_id] ) as shaver
      FROM [pg_mapping_indonesia].[dbo].[route_transaction_detail_account] a
      WHERE a.[id] = " . $id . "
      ORDER BY a.[id] asc";
      $command = Yii::app()->db2->createCommand($sql);
      $data = $command->queryAll();


      return $data;
   }

   public function getMarker($address) {


      $sql = "SELECT a.[id]
      ,a.[sales_order_id]
      ,b.longitude
      ,b.latitude
      FROM [pg_mapping_indonesia].[dbo].[route_transaction_detail_account] a
       INNER JOIN [pg_mapping_indonesia].[dbo].[nextgen_sales_order] b
      ON a.[sales_order_id] = b.[id]
      WHERE a.[address1] LIKE '%" . $address . "%'
      ORDER BY a.[id] asc";
      $command = Yii::app()->db2->createCommand($sql);
      $data = $command->queryAll();


      return $data;
   }

   public function getAddress($lat, $lon) {
      $ret = 'STRING';
      try {
         $url = 'http://reverse.geocoder.cit.api.here.com/6.2/reversegeocode.json?prox=' . $lat . ',' . $lon . '&mode=retrieveAddresses&maxresults=1&app_id=Zu92WCskAzZrStonxMQQ&app_code=DZKw6mNv7p9HBdNA-QPiWw&gen=3';
         $data = @file_get_contents($url);
         $jsondata = json_decode($data, true);
         if (is_array($jsondata)) {

            // if (isset($jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['County']) && isset($jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['City']) && isset($jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['District'])) {
            if (isset($jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['County']) && isset($jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['City']) && isset($jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['District']) && isset($jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['Street'])) {
//              $addr = $jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['County'].' '.$jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['City'];
//              $addr = $jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['District'].', '.$jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['City'].', '.$jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['County'];

               $addr = $jsondata['Response']['View'][0]['Result'][0]['Location']['Address']['Street'];
            } else {
               $addr = '';
            }
            if ($ret == 'STRING') {
               return $addr;
            } else {
               return $jsondata;
            }
         }
      } catch (Exception $e) {
         echo $e;
      }
   }

}