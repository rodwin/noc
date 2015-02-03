<?php

class ApiController extends Controller {

   public function actions() {
      return array(
          'webservice' => array(
              'class' => 'CWebServiceAction',
              'classMap' => array(
                  'Sku' => 'Sku', // or simply 'Post'
                  'SkuCriteria' => 'SkuCriteria', // or simply 'Post'
                  'CreateInventoryForm' => 'CreateInventoryForm', // or simply 'Post'
                  'Employee' => 'Employee',
                  'EmployeeCriteria' => 'EmployeeCriteria',
                  'InventoryCriteria' => 'InventoryCriteria',
                  'OutgoingInventory' => 'OutgoingInventory',
                  'OutgoingInventoryDetail' => 'OutgoingInventoryDetail',
                  'IncomingInventory' => 'IncomingInventory',
                  'Gcmusers' => 'Gcmusers',
              ),
          ),
      );
   }

   public function actionIndex() {

      pr("Webservice is operational");
   }

   /**
    * @param string the company_id
    * @param string the username
    * @param string the password
    * @return bool
    * @soap
    */
   public function login($company_id, $name, $password) {

      Yii::log('API call login entered', 'info', 'webservice');

      $model = new LoginForm();
      $model->company = $company_id;
      $model->username = $name;
      $model->password = $password;

      if ($model->validate() && $model->login()) {

         return true;
      } else {

         $error = "";
         foreach ($model->getErrors() as $k => $err) {
            $error .= $err[0];
         }
         throw new SoapFault("login error", $error);
      }
   }

//   /**
//    * @param CreateInventoryForm object
//    * @soap
//    */
//   public function createInventory(CreateInventoryForm $CreateInventoryForm) {
//
//      Yii::log('API call createInventory entered', 'info', 'webservice');
//
//      $model = new CreateInventoryForm();
//      $model->attributes = $CreateInventoryForm->attributes;
//      if (!$model->create()) {
//
//         $error = "";
//         foreach ($model->getErrors() as $k => $err) {
//            $error .= $err[0];
//         }
//
//         Yii::log('createInventory failed: ' . $error, 'warning', 'webservice');
//
//         throw new SoapFault("createInventory error", $error);
//      }
//
//      Yii::log('API call createInventory completed', 'info', 'webservice');
//   }

   /**
    * @param SkuCriteria object
    * @return Sku[] a list of sku
    * @soap
    */
   public function retrieveSkusByCriteria(SkuCriteria $SkuCriteria) {

      Yii::log('API call retrieveSkusByCriteria entered', 'info', 'webservice');

      $data = Sku::model()->retrieveSkusByCriteria($SkuCriteria);

      $ret = array();

      foreach ($data as $key => $val) {

         $sku = new Sku;
         $sku->attributes = $val->attributes;
         //$sku->brandObj = $val->brand->attributes;
         $sku->brandObj = isset($val->brand) ? $val->brand->attributes : null;
         $ret[] = $sku;
      }

      Yii::log('API call retrieveSkusByCriteria completed', 'info', 'webservice');
      return $ret;
   }

   /**
    * @param EmployeeCriteria object
    * @return Employee employee
    * @soap
    */
   public function retrieveEmployeeByCriteria(EmployeeCriteria $employee_criteria) {
      Yii::log('API call retrieveEmployeeByCriteria entered', 'info', 'webservice');
      $data = Employee::model()->retriveEmployeeByCriteria($employee_criteria);

      if ($data) {
         $employee = new Employee;
         $employee->attributes = $data->attributes;
         $employee->employee_type_obj = isset($data->employeeType) ? $data->employeeType->attributes : null;
         $employee->employee_status_obj = isset($data->employeeStatus) ? $data->employeeStatus->attributes : null;
         $employee->sales_office_obj = isset($data->salesOffice) ? $data->salesOffice->attributes : null;
         $employee->company_obj = isset($data->company) ? $data->company->attributes : null;
         $employee->zone_obj = isset($data->zone) ? $data->zone->attributes : null;
         return $employee;
      } else {
         throw new SoapFault("retrieveEmployeeByCriteria error", 'No employee found');
      }
      Yii::log('API call retrieveEmployeeByCriteria completed', 'info', 'webservice');
   }

   /**
    * @param string the dr_no
    * @param string the employee_code
    * @param string the sales_office_code
    * @return OutgoingInventory outgoing
    * @soap
    */
   public function retrieveOutgoing($dr_no, $employee_code, $sales_office_code) {

      Yii::log('API call retrieveOutgoing entered', 'info', 'webservice');
      Yii::log('Passing values to retrieveOutgoing, DR NO: '. $dr_no. ', EMPLOYEE CODE: '. $employee_code. ', SALES OFFICE CODE: '. $sales_office_code, 'info', 'webservice');
      $data = OutgoingInventory::model()->retrieveOutgoing($dr_no, $employee_code, $sales_office_code);
      // pre($data);
      if ($data) {
         $outgoing = new OutgoingInventory;
         $outgoing->attributes = $data->attributes;
         $outgoing['outgoing_inventory_id'] = $data['outgoing_inventory_id'];
         $ctr = 0;
         foreach ($data->outgoingInventoryDetails as $key => $value) {
            $outgoing->outgoing_inventory_detail_obj[$ctr] = $value->attributes;
            $outgoing->outgoing_inventory_detail_obj[$ctr]["sku_obj"][] = $value->sku->attributes;
            $outgoing->outgoing_inventory_detail_obj[$ctr]["sku_obj"][0]["brandObj"] = $value->sku->brand->attributes;

            $ctr++;
         }
         Yii::log('The process of retrieveOutgoing is successful', 'info', 'webservice');
         return $outgoing;
      } else {
          Yii::log('No incoming inventory found for DR NO: '. $dr_no. ', EMPLOYEE CODE: '. $employee_code. ', SALES OFFICE CODE: '. $sales_office_code , 'info', 'webservice');
         throw new SoapFault("retrieveOutgoing error", 'No incoming inventory found');
      }
      Yii::log('API call retrieveOutgoing completed', 'info', 'webservice');
   }

   /**
    * @param string outgoing_inventory_id
    * @param string outgoing_inventory_detail_id
    * @param string quantity_received
    * @return string
    * @soap
    */
   public function inventory_confirmation($outgoing_inventory_id, $outgoing_inventory_detail_id, $quantity_received) {
      Yii::log('API call inventory_confirmation entered', 'info', 'webservice');
      Yii::log('Passing values to inventory_confirmation, OUTGOING INVENTORY ID: '. $outgoing_inventory_id. ', OUTGOING INVENTORY DETAIL ID: '. $outgoing_inventory_detail_id. ', QUANTITY RECEIVED: '. $quantity_received, 'info', 'webservice');
      
      $sql = "SELECT * FROM outgoing_inventory WHERE outgoing_inventory_id =" . $outgoing_inventory_id;
      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();
      
      if (!$data)
      {
         Yii::log('INVENTORY CONFIRMATION query for header failed: '. $sql, 'info', 'webservice');
      }
      
      $model = new IncomingInventory;
      $model->outgoing_inventory_id = $data[0]['outgoing_inventory_id'];
      $model->company_id = $data[0]['company_id'];
      $model->dr_no = $data[0]['dr_no'];
      $model->dr_date = $data[0]['dr_date'];
      $model->rra_no = $data[0]['rra_no'];
      $model->rra_date = $data[0]['rra_date'];
      $model->destination_zone_id = $data[0]['destination_zone_id'];
      $model->contact_person = $data[0]['contact_person'];
      $model->contact_no = $data[0]['contact_no'];
      $model->transaction_date = $data[0]['transaction_date'];
      $model->plan_delivery_date = $data[0]['plan_delivery_date'];
      $model->remarks = $data[0]['remarks'];
      $model->total_amount = $data[0]['total_amount'];
      $model->created_by = $data[0]['created_by'];
      $model->recipients = $data[0]['recipients'];

      $sql = "SELECT * FROM outgoing_inventory_detail WHERE outgoing_inventory_detail_id IN ( " . $outgoing_inventory_detail_id . ") AND outgoing_inventory_id = " . $outgoing_inventory_id;
      $command = Yii::app()->db->createCommand($sql);
      $transaction_details = $command->queryAll();
      
      if (!$transaction_details)
      {
         Yii::log('INVENTORY CONFIRMATION query for detail failed: '. $sql, 'info', 'webservice');
      }
      
      $count = 0;
      if (strpos($quantity_received, ',')) {
         $quantity = explode(",", $quantity_received);
      }
      else{
         $quantity[0] =$quantity_received;
      }
      $count = count($transaction_details)-1;
      for ($ctr = 0; $ctr <= $count; $ctr++) {
         $transaction_details[$ctr]['quantity_received'] = trim($quantity[$ctr]);
         $transaction_details[$ctr]['planned_quantity'] = $transaction_details[$ctr]['quantity_issued'];
         
         if ($transaction_details[$ctr]['quantity_received'] > $transaction_details[$ctr]['planned_quantity']) {
            $transaction_details[$ctr]['status'] = OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS;
         } elseif ($transaction_details[$ctr]['quantity_received'] < $transaction_details[$ctr]['planned_quantity']) {
            $transaction_details[$ctr]['status'] = OutgoingInventory::OUTGOING_INCOMPLETE_STATUS;
         } else {
            $transaction_details[$ctr]['status'] = OutgoingInventory::OUTGOING_COMPLETE_STATUS;
         }
      }
      $data = $model->create($transaction_details);

      if ($data) {
         Yii::log('The process of iventory_confirmation is successful', 'info', 'webservice');
         $message = 'processed';
         return $message;
      } else {
          Yii::log('Request failed in inventory confirmation of values, OUTGOING INVENTORY ID: '. $outgoing_inventory_id. ', OUTGOING INVENTORY DETAIL ID: '. $outgoing_inventory_detail_id. ', QUANTITY RECEIVED: '. $quantity_received , 'info', 'webservice');
         throw new SoapFault("inventory_confirmation error", 'Request failed.');
      }
      Yii::log('API call iventory_confirmation completed', 'info', 'webservice');
   }

   /**
    * @param InventoryCriteria object
    * @param string the outlet_id
    * @param string the salesman_id
    * @return string
    * @soap
    */
   public function customerItem(InventoryCriteria $inventory_criteria, $outlet_code, $sales_office_code) {
      Yii::log('API call customerItem entered', 'info', 'webservice');
      $flag = 'soap'; //soap or web
      $arr = (array) $inventory_criteria;

      $arr['source_zone_id'] = $arr['zone_id'];
      unset($arr['zone_id']);
      $arr['quantity_issued'] = $arr['quantity_received'];
      unset($arr['quantity_received']);
      $arr['sku_status_id'] = $arr['status_id'];
      unset($arr['status_id']);
      $arr['batch_no'] = $arr['reference_no'];
      unset($arr['reference_no']);


      $sql = "SELECT a.poi_id FROM poi a
               INNER JOIN poi_custom_data_value b ON a.poi_id = b.poi_id 
               WHERE primary_code = '" . $outlet_code . "' AND b.custom_data_id = '620c7353-fa2f-4e7d-8eb3-4765114f6786'
               AND b.value = '" . $sales_office_code . "'";
      $command = Yii::app()->db->createCommand($sql);
      $data = $command->queryAll();

      $count = count($arr['company_id']);

      for ($ctr = 0; $ctr <= $count - 1; $ctr++) {
         if ($count > 1) {
            $inventoryObj = Inventory::model()->findByAttributes(
                    array(
                        'company_id' => $arr['company_id'][$ctr],
                        'sku_id' => $arr['sku_id'][$ctr],
                        'uom_id' => $arr['uom_id'][$ctr],
                        'zone_id' => $arr['source_zone_id'][$ctr],
                        'sku_status_id' => $arr['sku_status_id'][$ctr] != "" ? $arr['sku_status_id'][$ctr] : null,
                        'expiration_date' => $arr['expiration_date'][$ctr] != "" ? $arr['expiration_date'][$ctr] : null, //nageerror dito
                        'po_no' => $arr['po_no'][$ctr],
                        'pr_no' => $arr['pr_no'][$ctr],
                        'pr_date' => $arr['pr_date'][$ctr] != "" ? $arr['pr_date'][$ctr] : null,
                        'plan_arrival_date' => $arr['plan_arrival_date'][$ctr] != "" ? $arr['plan_arrival_date'][$ctr] : null,
                        'reference_no' => $arr['batch_no'][$ctr],
                    )
            );
         } else {
            $inventoryObj = Inventory::model()->findByAttributes(
                    array(
                        'company_id' => $arr['company_id'],
                        'sku_id' => $arr['sku_id'],
                        'uom_id' => $arr['uom_id'],
                        'zone_id' => $arr['source_zone_id'],
                        'sku_status_id' => $arr['sku_status_id'] != "" ? $arr['sku_status_id'] : null,
                        'expiration_date' => $arr['expiration_date'] != "" ? $arr['expiration_date'] : null, //nageerror dito
                        'po_no' => $arr['po_no'],
                        'pr_no' => $arr['pr_no'],
                        'pr_date' => $arr['pr_date'] != "" ? $arr['pr_date'] : null,
                        'plan_arrival_date' => $arr['plan_arrival_date'] != "" ? $arr['plan_arrival_date'] : null,
                        'reference_no' => $arr['batch_no'],
                    )
            );
         }
         if ($flag == 'web') {
            $arr['inventory_id'][$ctr] = $inventoryObj['inventory_id'];
            $arr['return_date'][$ctr] = null;
            $arr['planned_quantity'][$ctr] = 0;
            $arr['remarks'][$ctr] = "";
            $arr['amount'][$ctr] = $inventoryObj['cost_per_unit'] != "" ? $inventoryObj['cost_per_unit'] : 0;
         } else {
            $arr['inventory_id'] = $inventoryObj['inventory_id'];
            $arr['return_date'] = null;
            $arr['planned_quantity'] = 0;
            $arr['remarks'] = "";
            $arr['amount'] = $inventoryObj['cost_per_unit'] != "" ? $inventoryObj['cost_per_unit'] : 0;
         }
      }

      $model = new CustomerItem;
      $model->dr_no = "AS" . date("YmdHis");
      $model->poi_id = $data[0]['poi_id'];
      $model->dr_date = date("Y-m-d");
      $model->transaction_date = date("Y-m-d");
      if ($flag == 'web') {
         $model->company_id = $arr['company_id'][0];
         $model->created_by = $arr['created_by'][0];
      } else {
         $model->company_id = $arr['company_id'];
         $model->created_by = $arr['created_by'];
      }

      $new_arr = array();
      $row = array();
      for ($ctr = 0; $ctr <= count($arr['company_id']) - 1; $ctr++) {
         if (count($arr['company_id']) > 1) {
            foreach ($arr as $k => $v) {
               $row[$k] = isset($v[$ctr]) ? $v[$ctr] : "";
            }
         } else {
            foreach ($arr as $k => $v) {
               $row[$k] = isset($v) ? $v : "";
            }
         }
         $new_arr[$ctr] = $row;
      }
      $data = $model->create($new_arr);
      
      $pod_id = $data['pod_data']['pod_header_data']->pod_id; 
      $pod_detail_id = array();
      $c = 0;
      foreach ($data['pod_data']['pod_detail_data'] as $key => $val) {
         $pod_detail_id[$c] = $val['pod_detail_id'];
         $c++;
      }
      $pods = $pod_id;
      foreach ($pod_detail_id as $pod) {
         $pods .= "-" . $pod;
      }
      if ($data) {
         return $pods;
      } else {
         throw new SoapFault("customerItem error", 'Request failed.');
      }
      Yii::log('API call customerItem completed', 'info', 'webservice');
   }

   /**
    * @param integer the pod_id
    * @param integer the pod_detail_id
    * @param string the attachment
    * @return string
    * @soap
    */
   public function pod_attachment($pod_id, $pod_detail_id, $attachment) {
      $urldec = urldecode($attachment);
      $imageData = base64_decode($urldec);
      $source = imagecreatefromstring($imageData);
      $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . '166374e5-cffe-42c6-95b3-41590826effd' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'PROOF OF DELIVERY' . DIRECTORY_SEPARATOR . $pod_id . DIRECTORY_SEPARATOR;
      if (!is_dir($dir)) {
         mkdir($dir, 0777, true);
      }
      $filename = 'pod-detail-' . $pod_detail_id . '.jpg';
      $fullpath = $dir . $filename;
      imagejpeg($source, $dir . $filename, 100); // <-- **Change is here**
      //$message = '' . $pod_id . ' - ' . $pod_detail_id . ' - ' . $fullpath;
      $message = $fullpath;
      $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . '166374e5-cffe-42c6-95b3-41590826effd' . '/attachments/' . 'PROOF OF DELIVERY' . "/" . $pod_id . "/" . $filename;

//    kulang saving sa database base pa sa output

      $dt = date("Y-m-d H:i:s");
      $sql = "INSERT INTO proof_of_delivery_attachment(company_id, pod_id, pod_detail_id, file_name, url, created_date) VALUES ('166374e5-cffe-42c6-95b3-41590826effd','" . $pod_id . "' , '" . $pod_detail_id . "', '" . $filename . "', '" . $url . "','" . $dt . "')";
      Yii::app()->db->createCommand($sql)->execute();


      return $message;
   }

   /**
    * @param string the sales_office_code
    * @param string the employee_code
    * @param string the gcm_regid
    * @param string the name
    * @return string
    * @soap
    */
   public function register($sales_office_code, $emp_code, $gcm_regid, $name) {
      $data = GcmUsers::model()->register($emp_code, $name, $sales_office_code, $gcm_regid);
      $message = 'processed';
      return $message;
   }

   public function actiontest() {
//      pr($this->pod_attachment("", "", ""));
//      $inventory_criteria = new InventoryCriteria();
//      for ($ctr = 0; $ctr < 1; $ctr++) {
//
//         $inventory_criteria->company_id[$ctr] = "166374e5-cffe-42c6-95b3-41590826effd";
//         $inventory_criteria->sku_id[$ctr] = "a20ab41c-2c7e-493f-bf53-332aecce057f";
//         $inventory_criteria->uom_id[$ctr] = "0c54f440-11e2-4f9d-95fd-ec538b6df195";
//         $inventory_criteria->unit_price[$ctr] = "0.00";
//         $inventory_criteria->quantity_received[$ctr] = 1;
//         $inventory_criteria->zone_id[$ctr] = "211c4e0a-3f80-49a0-ac98-d365c71c3a33";
//         $inventory_criteria->created_by[$ctr] = 'salesman 1';
//         $inventory_criteria->expiration_date[$ctr] = "";
//         $inventory_criteria->reference_no[$ctr] = "";
//         $inventory_criteria->status_id[$ctr] = null;
//         $inventory_criteria->po_no[$ctr] = "CM11";
//         $inventory_criteria->pr_no[$ctr] = "PR11";
//         $inventory_criteria->pr_date[$ctr] = "2014-10-23";
//         $inventory_criteria->plan_arrival_date[$ctr] = "";
//      }
//      $outlet_code = "750200-B200099543";
//      $sales_office_code = "750200";
      pr($this->inventory_confirmation('60', '97,98', '20, 2'));
//      pr($this->customerItem($inventory_criteria, $outlet_code, $sales_office_code));
//      $this->register('B2205 - BAESA', 'JUAN DELA CRUZ', '710200','APA91bFNzTkziaKnNzUrg1gTdKXJf4gVmKqQBtIXsef-2G2YMI9ac_prg1t15VOpmNGC7cdBggw5F4cC05CKfmGQTwGnZNlHC14ik8dW0NgiubheYqPr4rpNbMOeCaXKzUpcpGSaB5bdiyMynePjJzM4UqSA8uhPNQ');// 'APA91bFYiWsDaTNXwktcrULVArXIdqJ9YRgEW0uYPcX1ErAEky5nGUusSX6ux5Vud4pMZUaAyqLevqXn2UyosQX7-A6p5nXZq-IHYfyOSYuShJkR7Bt7qIAXD2tMYmKf6yXJPMqyGrC-tmUopUTyZ3dx4zrB42tJG0cEPIDbLnWIuDFzeStxXiU');
//      pr($this->retrieveOutgoing('DR111', 'B2205 - BAESA', '710200'));  // jcvalin@in1go.com
//pr($this->retrieveOutgoing('166374e5-cffe-42c6-95b3-41590826effd', 'DR111', '211c4e0a-3f80-49a0-ac98-d365c71c3a33'));  // jcvalin@in1go.com
//      $employee_criteria = new EmployeeCriteria();
//      $employee_criteria->company_code = 'vlink';//'166374e5-cffe-42c6-95b3-41590826effd';
//      $employee_criteria->sales_office_code = '610200';
//      $employee_criteria->employee_code = 'salesman1';
//      $employee_criteria->password = '';
//
//
//      pr($this->retrieveEmployeeByCriteria($employee_criteria));
   }

///////end of api controller  
}
