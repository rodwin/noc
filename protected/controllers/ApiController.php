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
         } //pre($outgoing);
         return $outgoing;
      } else {
         throw new SoapFault("retrieveOutgoing error", 'No incoming inventory found');
      }
      Yii::log('API call retrieveOutgoing completed', 'info', 'webservice');
   }

   /**
    * @param InventoryCriteria object
    * @return string
    * @soap
    */
   public function inventory_confirmation(InventoryCriteria $inventory_criteria) {

      Yii::log('API call inventory_confirmation entered', 'info', 'webservice');
      $arr['object'] = (array) $inventory_criteria;
      foreach ($arr as $key => $val) {
         //$data = $val['company_id'] . ', ' . $val['sku_id'] . ', ' . $val['uom_id'] . ', ' . $val['unit_price'] . ', ' . $val['quantity_received'] . ', ' . $val['zone_id'] . ', ' . $val['created_by'] . ', ' . $val['expiration_date'] . ', ' . $val['reference_no'] . ', ' . $val['status_id'] . ', ' . $val['campaign_no'] . ', ' . $val['pr_no'] . ', ' . $val['pr_date'] . ', ' . $val['plan_arrival_date'] . ', ' . $val['revised_delivery_date'];
         $count = count($val['company_id']);
         for ($ctr = 0; $ctr <= $count - 1; $ctr++) {
//         pr($val['company_id'][$ctr] . ', ' . $val['sku_id'][$ctr] . ', ' . $val['uom_id'][$ctr] . ', ' . $val['unit_price'][$ctr] . ', ' . $val['quantity_received'][$ctr] . ', ' . $val['zone_id'][$ctr] . ', ' . date("Y-m-d") . ', ' . $val['created_by'][$ctr] . ', ' . $val['expiration_date'][$ctr] . ', ' . $val['reference_no'][$ctr] . ', ' . isset($val['status_id'][$ctr]) ? $val['status_id'][$ctr] : null . ', ' . $val['pr_no'][$ctr] . ', ' . $val['pr_date'][$ctr] . ', ' . $val['plan_arrival_date'][$ctr] . ', ' . $val['po_no'][$ctr]);
            $data = ReceivingInventoryDetail::model()->createInventory($val['company_id'], $val['sku_id'], $val['uom_id'], $val['unit_price'], $val['quantity_received'], $val['zone_id'], $val['transaction_date'], $val['created_by'], $val['expiration_date'], $val['reference_no'], $val['status_id'], $val['pr_no'], $val['pr_date'], $val['plan_arrival_date'], $val['po_no']);
         }
      }
      if ($data) {
         $message = 'processed';
         return $message;
      } else {
         throw new SoapFault("inventory_confirmation error", 'Request failed.');
      }
      Yii::log('API call iventory_confirmation completed', 'info', 'webservice');
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

      $inventory_criteria = new InventoryCriteria();
      $inventory_criteria->company_id[0] = "166374e5-cffe-42c6-95b3-41590826effd";
      $inventory_criteria->sku_id[0] = "a20ab41c-2c7e-493f-bf53-332aecce057f";
      $inventory_criteria->uom_id[0] = "0c54f440-11e2-4f9d-95fd-ec538b6df195";
      $inventory_criteria->unit_price[0] = "0.00";
      $inventory_criteria->quantity_received[0] = 5;
      $inventory_criteria->zone_id[0] = "211c4e0a-3f80-49a0-ac98-d365c71c3a33";
      $inventory_criteria->created_by[0] = 'salesman 1';
      $inventory_criteria->expiration_date[0] = "";
      $inventory_criteria->reference_no[0] = "";
      $inventory_criteria->status_id[0] = null;
      $inventory_criteria->po_no[0] = "CM11";
      $inventory_criteria->pr_no[0] = "PR11";
      $inventory_criteria->pr_date[0] = "2014-10-23";
      $inventory_criteria->plan_arrival_date[0] = "";

      $inventory_criteria->company_id[1] = "166374e5-cffe-42c6-95b3-41590826effd";
      $inventory_criteria->sku_id[1] = "a20ab41c-2c7e-493f-bf53-332aecce057f";
      $inventory_criteria->uom_id[1] = "0c54f440-11e2-4f9d-95fd-ec538b6df195";
      $inventory_criteria->unit_price[1] = "0.00";
      $inventory_criteria->quantity_received[1] = 10;
      $inventory_criteria->zone_id[1] = "211c4e0a-3f80-49a0-ac98-d365c71c3a33";
      $inventory_criteria->created_by[1] = 'salesman 1';
      $inventory_criteria->expiration_date[1] = "";
      $inventory_criteria->reference_no[1] = "";
      $inventory_criteria->status_id[1] = null;
      $inventory_criteria->po_no[1] = "CM11";
      $inventory_criteria->pr_no[1] = "PR11";
      $inventory_criteria->pr_date[1] = "2014-10-23";
      $inventory_criteria->plan_arrival_date[1] = "";
      pr($this->inventory_confirmation($inventory_criteria));
//      $this->register('B2205 - BAESA', 'JUAN DELA CRUZ', '710200','APA91bFNzTkziaKnNzUrg1gTdKXJf4gVmKqQBtIXsef-2G2YMI9ac_prg1t15VOpmNGC7cdBggw5F4cC05CKfmGQTwGnZNlHC14ik8dW0NgiubheYqPr4rpNbMOeCaXKzUpcpGSaB5bdiyMynePjJzM4UqSA8uhPNQ');// 'APA91bFYiWsDaTNXwktcrULVArXIdqJ9YRgEW0uYPcX1ErAEky5nGUusSX6ux5Vud4pMZUaAyqLevqXn2UyosQX7-A6p5nXZq-IHYfyOSYuShJkR7Bt7qIAXD2tMYmKf6yXJPMqyGrC-tmUopUTyZ3dx4zrB42tJG0cEPIDbLnWIuDFzeStxXiU');
//pr($this->retrieveOutgoing('DR111', 'B2205 - BAESA', '710200'));  // jcvalin@in1go.com
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

