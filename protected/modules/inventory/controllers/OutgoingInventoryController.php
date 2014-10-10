
<?php

class OutgoingInventoryController extends Controller {
   /**
    * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
//public $layout='//layouts/column2';

   /**
    * @return array action filters
    */
   public function filters() {
      return array(
          'accessControl', // perform access control for CRUD operations
          'postOnly + delete', // we only allow deletion via POST request
      );
   }

   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(
          array('allow', // allow all users to perform 'index' and 'view' actions
              'actions' => array('index', 'view'),
              'users' => array('@'),
          ),
          array('allow', // allow authenticated user to perform 'create' and 'update' actions
              'actions' => array('create', 'update', 'data', 'loadInventoryDetails', 'outgoingInvDetailData', 'afterDeleteTransactionRow', 'invData', 'uploadAttachment', 'preview', 'deleteByUrl', 'download', 'deleteOutgoingDetail', 'deleteAttachment', 'sendDR', 'searchCampaignNo', 'loadPRNos', 'loadInvByPRNo', 'print', 'loadPDF'),
              'users' => array('@'),
          ),
          array('allow', // allow admin user to perform 'admin' and 'delete' actions
              'actions' => array('admin', 'delete'),
              'users' => array('@'),
          ),
          array('deny', // deny all users
              'users' => array('*'),
          ),
      );
   }

   public function actionData() {

      OutgoingInventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

      $dataProvider = OutgoingInventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

      $count = OutgoingInventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

      $output = array(
          "draw" => intval($_GET['draw']),
          "recordsTotal" => $count,
          "recordsFiltered" => $dataProvider->totalItemCount,
          "data" => array()
      );

      foreach ($dataProvider->getData() as $key => $value) {
         $row = array();

         $status = "";
         switch ($value->status) {
            case OutgoingInventory::OUTGOING_PENDING_STATUS:
               $status = '<span class="label label-warning">' . OutgoingInventory::OUTGOING_PENDING_STATUS . '</span>';
               break;
            case OutgoingInventory::OUTGOING_COMPLETE_STATUS:
               $status = '<span class="label label-success">' . OutgoingInventory::OUTGOING_COMPLETE_STATUS . '</span>';
               break;
            case OutgoingInventory::OUTGOING_INCOMPLETE_STATUS:
               $status = '<span class="label label-danger">' . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . '</span>';
               break;
            case OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS:
               $status = '<span class="label label-primary">' . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . '</span>';
               break;
            default:
               break;
         }

         $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
         $row['rra_no'] = $value->rra_no;
         $row['dr_no'] = $value->dr_no;
         $row['dr_date'] = $value->dr_date;
         $row['destination_zone_id'] = $value->destination_zone_id;
         $row['destination_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
         $row['contact_person'] = $value->contact_person;
         $row['contact_no'] = $value->contact_no;
         $row['address'] = $value->address;
         $row['campaign_no'] = $value->campaign_no;
         $row['pr_no'] = $value->pr_no;
         $row['pr_date'] = $value->pr_date;
         $row['plan_delivery_date'] = $value->plan_delivery_date;
         $row['revised_delivery_date'] = $value->revised_delivery_date;
         $row['actual_delivery_date'] = $value->actual_delivery_date;
         $row['plan_arrival_date'] = $value->plan_arrival_date;
         $row['transaction_date'] = $value->transaction_date;
         $row['status'] = $status;
         $row['total_amount'] = $value->total_amount;
         $row['created_date'] = $value->created_date;
         $row['created_by'] = $value->created_by;
         $row['updated_date'] = $value->updated_date;
         $row['updated_by'] = $value->updated_by;

         $row['links'] =   '<a class="btn btn-sm btn-default" title="Send DR No" href="' . $this->createUrl('/inventory/outgoinginventory/sendDR', array('dr_no' => $value->dr_no, 'zone_id' => $value->destination_zone_id)) . '">
                                <i class="glyphicon glyphicon-send"></i>
                            </a>'
                           .'<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/outgoinginventory/delete', array('id' => $value->outgoing_inventory_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

         $output['data'][] = $row;
      }

      echo json_encode($output);
   }

   public function actionInvData() {

      Inventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

      $dataProvider = Inventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

      $count = Inventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

      $output = array(
          "draw" => intval($_GET['draw']),
          "recordsTotal" => $count,
          "recordsFiltered" => $dataProvider->totalItemCount,
          "data" => array()
      );

      foreach ($dataProvider->getData() as $key => $value) {
         $row = array();
         $row['DT_RowId'] = $value->inventory_id; // Add an ID to the TR element
         $row['inventory_id'] = $value->inventory_id;
         $row['sku_code'] = $value->sku->sku_code;
         $row['sku_id'] = $value->sku_id;
         $row['sku_name'] = $value->sku->sku_name;
         $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
         $row['qty'] = $value->qty;
         $row['uom_id'] = $value->uom_id;
         $row['uom_name'] = isset($value->uom->uom_name) ? $value->uom->uom_name : null;
         $row['action_qty'] = '';
         $row['zone_id'] = $value->zone_id;
         $row['zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
         $row['sku_status_id'] = $value->sku_status_id;
         $row['sku_status_name'] = isset($value->skuStatus->status_name) ? $value->skuStatus->status_name : '';
         $row['sales_office_name'] = isset($value->zone->salesOffice->sales_office_name) ? $value->zone->salesOffice->sales_office_name : '';
         $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : '';
         $row['transaction_date'] = $value->transaction_date;
         $row['created_date'] = $value->created_date;
         $row['created_by'] = $value->created_by;
         $row['updated_date'] = $value->updated_date;
         $row['updated_by'] = $value->updated_by;
         $row['expiration_date'] = $value->expiration_date;
         $row['reference_no'] = $value->reference_no;

         $output['data'][] = $row;
      }

      echo json_encode($output);
   }

   /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
   public function actionView($id) {
      $model = $this->loadModel($id);

      $this->pageTitle = 'View OutgoingInventory ' . $model->outgoing_inventory_id;

      $this->menu = array(
          array('label' => 'Create OutgoingInventory', 'url' => array('create')),
          array('label' => 'Update OutgoingInventory', 'url' => array('update', 'id' => $model->outgoing_inventory_id)),
          array('label' => 'Delete OutgoingInventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->outgoing_inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
          array('label' => 'Manage OutgoingInventory', 'url' => array('admin')),
          '',
          array('label' => 'Help', 'url' => '#'),
      );

      $this->render('view', array(
          'model' => $model,
      ));
   }

   /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
   public function actionCreate() {

      $this->pageTitle = OutgoingInventory::OUTGOING_LABEL . ' Inventory';
      $this->layout = '//layouts/column1';

      $outgoing = new OutgoingInventory;
      $transaction_detail = new OutgoingInventoryDetail;
      $sku = new Sku;
      $model = new Attachment;
      $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
      $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

      if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

         $data = array();
         $data['success'] = false;
         $data["type"] = "success";

         if ($_POST['form'] == "transaction") {
            $data['form'] = $_POST['form'];

            if (isset($_POST['OutgoingInventory'])) {
               $outgoing->attributes = $_POST['OutgoingInventory'];
               $outgoing->company_id = Yii::app()->user->company_id;
               $outgoing->created_by = Yii::app()->user->name;
               unset($outgoing->created_date);

               $validatedOutgoing = CActiveForm::validate($outgoing);

               if ($validatedOutgoing != '[]') {

                  $data['error'] = $validatedOutgoing;
                  $data['message'] = 'Unable to process';
                  $data['success'] = false;
                  $data["type"] = "danger";
               } else {

                  $transaction_details = isset($_POST['transaction_details']) ? $_POST['transaction_details'] : array();

                  if ($outgoing->create($transaction_details)) {
                     $data['message'] = 'Successfully created';
                     $data['success'] = true;
                     $this->actionSendDR($outgoing->dr_no, $outgoing->destination_zone_id);
                  } else {
                     $data['message'] = 'Unable to process';
                     $data['success'] = false;
                     $data["type"] = "danger";
                  }
               }
            }
         } else if ($_POST['form'] == "details") {
            $data['form'] = $_POST['form'];

            if (isset($_POST['OutgoingInventoryDetail'])) {
               $transaction_detail->attributes = $_POST['OutgoingInventoryDetail'];
               $transaction_detail->company_id = Yii::app()->user->company_id;
               $transaction_detail->created_by = Yii::app()->user->name;
               unset($transaction_detail->created_date);

               $validatedReceivingDetail = CActiveForm::validate($transaction_detail);

               if ($validatedReceivingDetail != '[]') {

                  $data['error'] = $validatedReceivingDetail;
                  $data['message'] = 'Unable to process';
                  $data['success'] = false;
                  $data["type"] = "danger";
               } else {

                  $c = new CDbCriteria;
                  $c->compare('t.company_id', Yii::app()->user->company_id);
                  $c->compare('t.inventory_id', $transaction_detail->inventory_id);
                  $c->with = array("sku");
                  $inventory = Inventory::model()->find($c);

                  if ($transaction_detail->quantity_issued <= $inventory->qty) {
                     $data['message'] = 'Successfully Added Item';
                     $data['success'] = true;

                     $data['details'] = array(
                         "inventory_id" => isset($inventory->inventory_id) ? $inventory->inventory_id : null,
                         "sku_id" => isset($inventory->sku->sku_id) ? $inventory->sku->sku_id : null,
                         "sku_code" => isset($inventory->sku->sku_code) ? $inventory->sku->sku_code : null,
                         "sku_description" => isset($inventory->sku->description) ? $inventory->sku->description : null,
                         'brand_name' => isset($inventory->sku->brand->brand_name) ? $inventory->sku->brand->brand_name : null,
                         'unit_price' => isset($transaction_detail->unit_price) ? $transaction_detail->unit_price : 0,
                         'batch_no' => isset($transaction_detail->batch_no) ? $transaction_detail->batch_no : null,
                         'source_zone_id' => isset($transaction_detail->source_zone_id) ? $transaction_detail->source_zone_id : null,
                         'source_zone_name' => isset($transaction_detail->zone->zone_name) ? $transaction_detail->zone->zone_name : null,
                         'expiration_date' => isset($transaction_detail->expiration_date) ? $transaction_detail->expiration_date : null,
                         'planned_quantity' => $transaction_detail->planned_quantity != "" ? $transaction_detail->planned_quantity : 0,
                         'quantity_issued' => $transaction_detail->quantity_issued != "" ? $transaction_detail->quantity_issued : 0,
                         'amount' => $transaction_detail->amount != "" ? $transaction_detail->amount : 0,
                         'inventory_on_hand' => $transaction_detail->inventory_on_hand != "" ? $transaction_detail->inventory_on_hand : 0,
                         'reference_no' => isset($transaction_detail->pr_no) ? $transaction_detail->pr_no : null,
                         'return_date' => isset($transaction_detail->return_date) ? $transaction_detail->return_date : null,
                         'remarks' => isset($transaction_detail->remarks) ? $transaction_detail->remarks : null,
                         'uom_id' => isset($transaction_detail->uom_id) ? $transaction_detail->uom_id : null,
                         'sku_status_id' => isset($transaction_detail->sku_status_id) ? $transaction_detail->sku_status_id : null,
                     );
                  } else {

                     $data['message'] = 'Quantity Issued greater than inventory on hand';
                     $data['success'] = false;
                     $data["type"] = "danger";
                  }
               }
            }
         }

         echo json_encode($data);
         Yii::app()->end();
      }

      $this->render('outgoingForm', array(
          'outgoing' => $outgoing,
          'transaction_detail' => $transaction_detail,
          'sku' => $sku,
          'model' => $model,
          'uom' => $uom,
          'sku_status' => $sku_status,
      ));
   }

   public function actionLoadInventoryDetails() {

      $inventory_id = Yii::app()->request->getParam('inventory_id');

      if ($inventory_id != "") {
         $c = new CDbCriteria;
         $c->select = 't.*, sum(t.qty) AS inventory_on_hand';
         $c->compare('t.company_id', Yii::app()->user->company_id);
         $c->compare('t.inventory_id', $inventory_id);
         $c->group = "t.sku_id";
         $inventory = Inventory::model()->find($c);

         $sku = Sku::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sku_id" => $inventory->sku_id));
      }

      $data = array(
          "sku_id" => isset($sku->sku_id) ? $sku->sku_id : null,
          "sku_category" => isset($sku->type) ? $sku->type : null,
          "sku_sub_category" => isset($sku->sub_type) ? $sku->sub_type : null,
          'brand_name' => isset($sku->brand->brand_name) ? $sku->brand->brand_name : null,
          'sku_code' => isset($sku->sku_code) ? $sku->sku_code : null,
          'sku_description' => isset($sku->description) ? $sku->description : null,
          'inventory_uom_selected' => isset($inventory->uom->uom_name) ? $inventory->uom->uom_name : null,
          'source_zone_id' => isset($inventory->zone_id) ? $inventory->zone_id : null,
          'source_zone_name' => isset($inventory->zone->zone_name) ? $inventory->zone->zone_name : null,
          'unit_price' => isset($inventory->cost_per_unit) ? $inventory->cost_per_unit : 0,
          'reference_no' => isset($inventory->reference_no) ? $inventory->reference_no : null,
          'expiration_date' => isset($inventory->expiration_date) ? $inventory->expiration_date : null,
          'inventory_on_hand' => isset($inventory->inventory_on_hand) ? $inventory->inventory_on_hand : 0,
          'uom_id' => isset($inventory->uom_id) ? $inventory->uom_id : null,
          'sku_status_id' => isset($inventory->sku_status_id) ? $inventory->sku_status_id : null,
      );

      echo json_encode($data);
   }

   public function actionOutgoingInvDetailData($outgoing_inv_id) {

      $c = new CDbCriteria;
      $c->compare("company_id", Yii::app()->user->company_id);
      $c->compare("outgoing_inventory_id", $outgoing_inv_id);
      $outgoing_inv_details = OutgoingInventoryDetail::model()->findAll($c);

      $output = array();
      foreach ($outgoing_inv_details as $key => $value) {
         $row = array();

         $status = "";
         switch ($value->status) {
            case OutgoingInventory::OUTGOING_PENDING_STATUS:
               $status = '<span class="label label-warning">' . OutgoingInventory::OUTGOING_PENDING_STATUS . '</span>';
               break;
            case OutgoingInventory::OUTGOING_COMPLETE_STATUS:
               $status = '<span class="label label-success">' . OutgoingInventory::OUTGOING_COMPLETE_STATUS . '</span>';
               break;
            case OutgoingInventory::OUTGOING_INCOMPLETE_STATUS:
               $status = '<span class="label label-danger">' . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . '</span>';
               break;
            case OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS:
               $status = '<span class="label label-primary">' . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . '</span>';
               break;
            default:
               break;
         }

         $row['outgoing_inventory_detail_id'] = $value->outgoing_inventory_detail_id;
         $row['outgoing_inventory_id'] = $value->outgoing_inventory_id;
         $row['batch_no'] = $value->batch_no;
         $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
         $row['sku_name'] = isset($value->sku->sku_name) ? $value->sku->sku_name : null;
         $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
         $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
         $row['source_zone_id'] = $value->source_zone_id;
         $row['source_zone_name'] = isset($value->zone->zone_name) ? $value->zone->zone_name : null;
         $row['unit_price'] = $value->unit_price;
         $row['expiration_date'] = $value->expiration_date;
         $row['planned_quantity'] = $value->planned_quantity;
         $row['quantity_issued'] = $value->quantity_issued;
         $row['amount'] = $value->amount;
         $row['inventory_on_hand'] = $value->inventory_on_hand;
         $row['return_date'] = $value->return_date;
         $row['status'] = $status;
         $row['remarks'] = $value->remarks;

         $row['links'] = '<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/outgoinginventory/deleteOutgoingDetail', array('outgoing_inv_detail_id' => $value->outgoing_inventory_detail_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

         $output['data'][] = $row;
      }

      echo json_encode($output);
   }

   public function actionAfterDeleteTransactionRow($inventory_id, $quantity) {
//        $inventory = Inventory::model()->findbyAttributes(array("company_id" => Yii::app()->user->company_id, "inventory_id" => $inventory_id));
//        $qty = ($inventory->qty + $quantity);
//        $this->updateInvByInvID($inventory_id, Yii::app()->user->company_id, $qty);
   }

   /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
   public function actionUpdate($id) {
      $model = $this->loadModel($id);

      $this->menu = array(
          array('label' => 'Create OutgoingInventory', 'url' => array('create')),
          array('label' => 'View OutgoingInventory', 'url' => array('view', 'id' => $model->outgoing_inventory_id)),
          array('label' => 'Manage OutgoingInventory', 'url' => array('admin')),
          '',
          array('label' => 'Help', 'url' => '#'),
      );

      $this->pageTitle = 'Update OutgoingInventory ' . $model->outgoing_inventory_id;

      // Uncomment the following line if AJAX validation is needed
      // $this->performAjaxValidation($model);

      if (isset($_POST['OutgoingInventory'])) {
         $model->attributes = $_POST['OutgoingInventory'];
         $model->updated_by = Yii::app()->user->name;
         $model->updated_date = date('Y-m-d H:i:s');

         if ($model->save()) {
            Yii::app()->user->setFlash('success', "Successfully updated");
            $this->redirect(array('view', 'id' => $model->outgoing_inventory_id));
         }
      }

      $this->render('update', array(
          'model' => $model,
      ));
   }

   /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
   public function actionDelete($id) {
      if (Yii::app()->request->isPostRequest) {
         try {

            // delete receiving details by outgoing_inventory_id
            OutgoingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND outgoing_inventory_id = " . $id);
            // delete attachment by outgoing_inventory_id as transaction_id
            $this->deleteAttachmenntByOutgoingInvID($id);

            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
               Yii::app()->user->setFlash('success', "Successfully deleted");
               $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else {

               echo "Successfully deleted";
               exit;
            }
         } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451) {
               if (!isset($_GET['ajax'])) {
                  Yii::app()->user->setFlash('danger', "Unable to delete");
                  $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $id));
               } else {
                  echo "1451";
                  exit;
               }
            }
         }
      } else
         throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
   }

   public function actionDeleteOutgoingDetail($outgoing_inv_detail_id) {
      if (Yii::app()->request->isPostRequest) {
         try {

            OutgoingInventoryDetail::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND outgoing_inventory_detail_id = " . $outgoing_inv_detail_id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
               Yii::app()->user->setFlash('success', "Successfully deleted");
               $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else {

               echo "Successfully deleted";
               exit;
            }
         } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451) {
               echo "1451";
               exit;
            }
         }
      } else
         throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
   }

   public function deleteAttachmenntByOutgoingInvID($outgoing_inv_id, $transaction_type = "outgoing") {
      $attachment = Attachment::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "transaction_type" => $transaction_type, "transaction_id" => $outgoing_inv_id));

      if (count($attachment) > 0) {
         $base = Yii::app()->getBaseUrl(true);
         $arr = explode("/", $base);
         $base = $arr[count($arr) - 1];

         Attachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND transaction_type = '" . $transaction_type . "' AND transaction_id = " . $outgoing_inv_id);
         $this->delete_directory('../' . $base . "/protected/uploads/" . Yii::app()->user->company_id . "/attachments/" . $transaction_type . "/" . $outgoing_inv_id);
      } else {
         return false;
      }
   }

   function delete_directory($dirname) {
      if (is_dir($dirname)) {
         $dir_handle = opendir($dirname);
      } else {
         return false;
      }

      if (!$dir_handle) {
         return false;
      }

      while ($file = readdir($dir_handle)) {
         if ($file != "." && $file != "..") {
            if (!is_dir($dirname . "/" . $file))
               unlink($dirname . "/" . $file);
            else
               delete_directory($dirname . '/' . $file);
         }
      }
      closedir($dir_handle);
      rmdir($dirname);
      return true;
   }

   public function actionDeleteAttachment($attachment_id) {
      if (Yii::app()->request->isPostRequest) {
         try {

            $attachment = Attachment::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "attachment_id" => $attachment_id));

            if ($attachment) {
               Attachment::model()->deleteAll("company_id = '" . Yii::app()->user->company_id . "' AND attachment_id = '" . $attachment->attachment_id . "'");

               $base = Yii::app()->getBaseUrl(true);
               $arr = explode("/", $base);
               $base = $arr[count($arr) - 1];
               $url = str_replace(Yii::app()->getBaseUrl(true), "", $attachment->url);
               unlink('../' . $base . $url);
            } else {
               throw new CHttpException(404, 'The requested page does not exist.');
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
               Yii::app()->user->setFlash('success', "Successfully deleted");
               $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else {

               echo "Successfully deleted";
               exit;
            }
         } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451) {
               echo "1451";
               exit;
            }
         }
      } else
         throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
   }

   /**
    * Lists all models.
    */
   public function actionIndex() {
      $dataProvider = new CActiveDataProvider('OutgoingInventory');

      $this->render('index', array(
          'dataProvider' => $dataProvider,
      ));
   }

   /**
    * Manages all models.
    */
   public function actionAdmin() {
      $this->layout = '//layouts/column1';
      $this->pageTitle = 'Manage ' . OutgoingInventory::OUTGOING_LABEL . ' Inventory';

      $model = new OutgoingInventory('search');
      $model->unsetAttributes();  // clear any default values
      if (isset($_GET['OutgoingInventory']))
         $model->attributes = $_GET['OutgoingInventory'];

      $this->render('admin', array(
          'model' => $model,
      ));
   }

   /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
   public function loadModel($id) {
      $model = OutgoingInventory::model()->findByAttributes(array('outgoing_inventory_id' => $id, 'company_id' => Yii::app()->user->company_id));
      if ($model === null)
         throw new CHttpException(404, 'The requested page does not exist.');

      return $model;
   }

   /**
    * Performs the AJAX validation.
    * @param CModel the model to be validated
    */
   protected function performAjaxValidation($model) {
      if (isset($_POST['ajax']) && $_POST['ajax'] === 'outgoing-inventory-form') {
         echo CActiveForm::validate($model);
         Yii::app()->end();
      }
   }

   public function actionUploadAttachment() {
      header('Vary: Accept');
      if (isset($_SERVER['HTTP_ACCEPT']) &&
              (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
         header('Content-type: application/json');
      } else {
         header('Content-type: text/plain');
      }

      $data = array();
      $model = new Attachment;

      if (isset($_FILES['Attachment']['name']) && $_FILES['Attachment']['name'] != "") {

         $file = CUploadedFile::getInstance($model, 'file');
//         $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'attachment' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR .Yii::app()->session['tid'];
         $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'outgoing' . DIRECTORY_SEPARATOR . Yii::app()->session['tid'];
         if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
         }

         $file_name = str_replace(' ', '_', strtolower($file->name));
//         $url = Yii::app()->getBaseUrl(true) . '/attachment/' . Yii::app()->user->company_id . '/' . Yii::app()->session['tid'] . '/' . $file_name;
         $url = Yii::app()->getBaseUrl(true) . '/protected/uploads/' . Yii::app()->user->company_id . '/attachments/outgoing/' . Yii::app()->session['tid'] . '/' . $file_name;
         $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

         $model->attachment_id = Globals::generateV4UUID();

         $model->company_id = Yii::app()->user->company_id;
         $model->file_name = $file_name;
         $model->url = $url;
         $model->transaction_id = Yii::app()->session['tid'];
         $model->transaction_type = 'outgoing';
         $model->created_by = Yii::app()->user->name;

         if ($model->save()) {

            $data[] = array(
                'name' => $file->name,
                'type' => $file->type,
                'size' => $file->size,
                'url' => $dir . DIRECTORY_SEPARATOR . $file_name,
                'thumbnail_url' => $dir . DIRECTORY_SEPARATOR . $file_name,
//                    'delete_url' => $this->createUrl('my/delete', array('id' => 1, 'method' => 'uploader')),
//                    'delete_type' => 'POST',
            );
         } else {

            if ($model->hasErrors()) {

               $data[] = array('error', $model->getErrors());
            }
         }
      } else {

         throw new CHttpException(500, "Could not upload file " . CHtml::errorSummary($model));
      }


      echo json_encode($data);
   }

   function actionPreview($id) {
      $c = new CDbCriteria;
      $c->compare("company_id", Yii::app()->user->company_id);
      $c->compare("transaction_id", $id);
      $c->compare("transaction_type", "outgoing");
      $attachment = Attachment::model()->findAll($c);

      $output = array();
      foreach ($attachment as $key => $value) {
         $ext = new SplFileInfo($value->file_name);

         $icon = "";
         if ($ext->getExtension() == "jpg" || $ext->getExtension() == "jpeg" || $ext->getExtension() == "gif" || $ext->getExtension() == "png") {
            $icon = CHtml::image('images' . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . "picture.png", "Image", array("width" => 30));
         } else if ($ext->getExtension() == "pdf") {
            $icon = CHtml::image('images' . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . "pdf.png", "Image", array("width" => 30));
         } else if ($ext->getExtension() == "docx" || $ext->getExtension() == "doc") {
            $icon = CHtml::image('images' . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . "doc.png", "Image", array("width" => 30));
         }
         $row = array();
         $row['icon'] = $icon;
         $row['file_name'] = $value->file_name;

         $row['links'] = '<a class="btn btn-sm btn-default" title="Delete" href="' . $this->createUrl('/inventory/outgoinginventory/download', array('id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-download"></i>
                            </a>'
                 . '&nbsp;<a class="btn btn-sm btn-default delete" title="Delete" href="' . $this->createUrl('/inventory/outgoinginventory/deleteAttachment', array('attachment_id' => $value->attachment_id)) . '">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>';

         $output['data'][] = $row;
      }

      echo json_encode($output);
   }

   function actionDeleteByUrl($id) {

      $sql = "SELECT url FROM noc.attachment WHERE attachment_id = :attachment_id AND company_id = '" . Yii::app()->user->company_id . "'";

      $command = Yii::app()->db->createCommand($sql);
      $command->bindParam(':attachment_id', $id, PDO::PARAM_STR);
      $data = $command->queryAll();
      foreach ($data as $key => $value) {
         $url = $value['url'];
      }
      //$url = substr($url, 16);
      $base = Yii::app()->getBaseUrl(true);
      $arr = explode("/", $base);
      $base = $arr[count($arr) - 1];
      $url = str_replace(Yii::app()->getBaseUrl(true), "", $url);
      //pre('../' .$base . $url);
      unlink('../' . $base . $url);

      $sql = "DELETE FROM noc.attachment WHERE attachment_id = :attachment_id AND company_id = '" . Yii::app()->user->company_id . "'";

      $command = Yii::app()->db->createCommand($sql);
      $command->bindParam(':attachment_id', $id, PDO::PARAM_STR);
      $data = $command->query();

      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
   }

   public function actionDownload($id) {

      $sql = "SELECT url, file_name FROM noc.attachment WHERE attachment_id = :attachment_id AND company_id = '" . Yii::app()->user->company_id . "'";

      $command = Yii::app()->db->createCommand($sql);
      $command->bindParam(':attachment_id', $id, PDO::PARAM_STR);
      $data = $command->queryAll();
      foreach ($data as $key => $value) {
         $url = $value['url'];
         $name = $value['file_name'];
      }
      $model = new ReceivingInventory;


//      $name = $_GET['file'];
//      $upload_path = Yii::app()->params['uploadPath'];
      $base = Yii::app()->getBaseUrl(true);
      $arr = explode("/", $base);
      $base = $arr[count($arr) - 1];
      $url = str_replace(Yii::app()->getBaseUrl(true), "", $url);

      if (file_exists('../' . $base . $url)) {
         Yii::app()->getRequest()->sendFile($name, file_get_contents('../' . $base . $url));
         $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      } else {
         
      }
   }

   public function actionSearchCampaignNo($value) {

      $c = new CDbCriteria();
      if ($value != "") {
         $c->addSearchCondition('t.campaign_no', $value, true);
      }
      $c->compare('t.company_id', Yii::app()->user->company_id);
      $c->group = "t.campaign_no";
      $receiving = ReceivingInventory::model()->findAll($c);
      $incoming = IncomingInventory::model()->findAll($c);

      $receiving_arr = array();
      $incoming_arr = array();
      foreach ($receiving as $k1 => $v1) {
         $receiving_arr[$k1]['transaction'] = ReceivingInventory::RECEIVING_LABEL;
         $receiving_arr[$k1]['campaign_no'] = $v1->campaign_no;
         $receiving_arr[$k1]['pr_no'] = $v1->pr_no;
         $receiving_arr[$k1]['pr_date'] = $v1->pr_date;
      }

      foreach ($incoming as $k2 => $v2) {
         $incoming_arr[$k2]['transaction'] = IncomingInventory::INCOMING_LABEL;
         $incoming_arr[$k2]['campaign_no'] = $v2->campaign_no;
         $incoming_arr[$k2]['pr_no'] = $v2->pr_no;
         $incoming_arr[$k2]['pr_date'] = $v2->pr_date;
      }

      $return = array_merge($receiving_arr, $incoming_arr);

      echo json_encode($return);
      Yii::app()->end();
   }

   public function actionLoadPRNos($campaign_no, $transaction) {

      $data = array();
      $pr_nos = array();

      if ($transaction == ReceivingInventory::RECEIVING_LABEL) {

         $c = new CDbCriteria;
         $c->condition = "receivingInventory.company_id = '" . Yii::app()->user->company_id . "' AND receivingInventory.campaign_no = '" . $campaign_no . "'";
         $c->with = array("receivingInventory");
         $receiving = ReceivingInventoryDetail::model()->findAll($c);

         foreach ($receiving as $key => $val) {

            array_push($pr_nos, $val->receivingInventory->pr_no);
         }
      } else {

         $c1 = new CDbCriteria;
         $c1->condition = "incomingInventory.company_id = '" . Yii::app()->user->company_id . "' AND incomingInventory.campaign_no = '" . $campaign_no . "'";
         $c1->with = array("incomingInventory");
         $incoming = IncomingInventoryDetail::model()->findAll($c1);

         foreach ($incoming as $key => $val) {

            array_push($pr_nos, $val->incomingInventory->pr_no);
         }
      }

      foreach ($pr_nos as $key => $val) {
         $data["pr_no"][$val] = $val;
      }

      echo json_encode($data);
      Yii::app()->end();
   }

   public function actionLoadInvByPRNo($campaign_no, $pr_no, $transaction) {

      $data = array();
      $header = array();
      $inv_ids = "";

      if ($transaction == ReceivingInventory::RECEIVING_LABEL) {

         $c = new CDbCriteria;
         $c->condition = "receivingInventory.company_id = '" . Yii::app()->user->company_id . "' AND receivingInventory.campaign_no = '" . $campaign_no . "' AND receivingInventory.pr_no = '" . $pr_no . "'";
         $c->with = array("receivingInventory");
         $receiving = ReceivingInventoryDetail::model()->findAll($c);

         foreach ($receiving as $key => $val) {

            $inventoryObj = Inventory::model()->findByAttributes(
                    array(
                        'company_id' => $val->receivingInventory->company_id,
                        'sku_id' => $val->sku_id,
                        'uom_id' => $val->uom_id,
                        'zone_id' => $val->receivingInventory->zone_id,
                        'sku_status_id' => $val->sku_status_id != "" ? $val->sku_status_id : null,
                        'expiration_date' => isset($val->expiration_date) ? $val->expiration_date : null,
                        'reference_no' => $val->batch_no,
                    )
            );

            if ($inventoryObj) {
               $inv_ids .= $inventoryObj->inventory_id . ",";
            }
         }

         $header = array(
             "pr_date" => isset($val->receivingInventory->pr_date) ? $val->receivingInventory->pr_date : null,
         );
      } else {

         $c1 = new CDbCriteria;
         $c1->condition = "incomingInventory.company_id = '" . Yii::app()->user->company_id . "' AND incomingInventory.campaign_no = '" . $campaign_no . "' AND incomingInventory.pr_no = '" . $pr_no . "'";
         $c1->with = array("incomingInventory");
         $incoming = IncomingInventoryDetail::model()->findAll($c1);

         foreach ($incoming as $key => $val) {

            $inventoryObj = Inventory::model()->findByAttributes(
                    array(
                        'company_id' => $val->incomingInventory->company_id,
                        'sku_id' => $val->sku_id,
                        'uom_id' => $val->uom_id,
                        'zone_id' => $val->incomingInventory->zone_id,
                        'sku_status_id' => $val->sku_status_id != "" ? $val->sku_status_id : null,
                        'expiration_date' => isset($val->expiration_date) ? $val->expiration_date : null,
                        'reference_no' => $val->batch_no,
                    )
            );

            if ($inventoryObj) {
               $inv_ids .= $inventoryObj->inventory_id . ",";
            }
         }

         $header = array(
             "pr_date" => isset($val->incomingInventory->pr_date) ? $val->incomingInventory->pr_date : null,
         );
      }

      $inventory = array();
      if ($inv_ids != "") {
         $c1 = new CDbCriteria;
         $c1->compare("company_id", Yii::app()->user->company_id);
         $c1->condition = "inventory_id IN (" . substr($inv_ids, 0, -1) . ")";
         $inventory = Inventory::model()->findAll($c1);
      }

      foreach ($inventory as $key => $value) {
         $row = array();

         $row['inventory_id'] = $value->inventory_id;
         $row['company_id'] = $value->company_id;
         $row['sku_id'] = $value->sku_id;
         $row['sku_code'] = isset($value->sku->sku_code) ? $value->sku->sku_code : null;
         $row['sku_description'] = isset($value->sku->description) ? $value->sku->description : null;
         $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name : null;
         $row['cost_per_unit'] = isset($value->cost_per_unit) ? $value->cost_per_unit : null;
         $row['inventory_on_hand'] = isset($value->qty) ? $value->qty : null;
         $row['uom_name'] = isset($value->uom->uom_name) ? $value->uom->uom_name : null;
         $row['sku_status_name'] = isset($value->skuStatus->status_name) ? $value->skuStatus->status_name : null;
         $row['expiration_date'] = isset($value->expiration_date) ? $value->expiration_date : null;
         $row['reference_no'] = isset($value->reference_no) ? $value->reference_no : null;

         $data['inv'][] = $row;
      }

      $data['headers'] = $header;

      echo json_encode($data);
      Yii::app()->end();
   }
   
    public function actionSendDR($dr_no, $zone_id) {
      $sql = "SELECT gcm_regid FROM noc.gcm_users a INNER JOIN noc.employee b ON a.employee_id = b.employee_id
              WHERE b.company_id = '" . Yii::app()->user->company_id . "' AND b.default_zone_id = '" . $zone_id . "'";
      $command = Yii::app()->db->createCommand($sql);
      $gcm_reg_id = $command->queryAll();
      try {
         if (isset($gcm_reg_id[0]['gcm_regid'])) {
            $message = 'You have a new inventory assigned to you. The DR number is: ' . $dr_no;
            GcmUsers::model()->send_notification($gcm_reg_id[0]['gcm_regid'], $message);
            if (!isset($_GET['ajax'])) {
               Yii::app()->user->setFlash('success', "DR no successfully sent");
               $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else {

               echo "Successfully sent";
               exit;
            }
         } else {
            Yii::app()->user->setFlash('danger', "Unable to send DR no");
            //  $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
         }
      } catch (CDbException $e) {
         if ($e->errorInfo[1] == 1451) {
            echo "1451";
            exit;
         }
      }
   }
   
   public function actionPrint() {

        unset(Yii::app()->session["post_pdf_data_id"]);

        Yii::app()->session["post_pdf_data_id"] = 'post_pdf_data_' . Globals::generateV4UUID();
        Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] = Yii::app()->request->getParam('post_data');

        $return = array();
        if (Yii::app()->session[Yii::app()->session["post_pdf_data_id"]] == "") {
            $return["success"] = false;
            return false;
        }

        $return["success"] = true;
        $return["id"] = Yii::app()->session["post_pdf_data_id"];

        echo json_encode($return);
        Yii::app()->end();
    }

    public function actionLoadPDF($id) {

        $data = Yii::app()->session[$id];

        ob_start();

        $headers = $data['OutgoingInventory'];
        $details = $data['transaction_details'];

        $c1 = new CDbCriteria();
        $c1->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.zone_id = "' . $headers['destination_zone_id'] . '"';
        $c1->with = array("salesOffice");
        $zone = Zone::model()->find($c1);

        $c2 = new CDbCriteria();
        $c2->select = new CDbExpression('t.*, CONCAT(TRIM(barangay.barangay_name), ", ", TRIM(municipal.municipal_name), ", ", TRIM(province.province_name), ", ", TRIM(region.region_name)) AS full_address');
        $c2->condition = 't.company_id = "' . Yii::app()->user->company_id . '"  AND t.sales_office_id = "' . $zone->salesOffice->sales_office_id . '"';
        $c2->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
        $c2->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
        $c2->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
        $c2->join .= ' LEFT JOIN region ON region.region_code = t.region_id';
        $salesoffice = Salesoffice::model()->find($c2);

        $sales_office_name = isset($salesoffice->sales_office_name) ? $salesoffice->sales_office_name : "";
        $sales_office_address = isset($salesoffice->full_address) ? $salesoffice->full_address : "";

        $transaction_date = $headers['transaction_date'];
        $plan_delivery_date = $headers['plan_delivery_date'];
        $pr_no = $headers['pr_no'];
        $rra_no = $headers['rra_no'];
        $rra_date = $headers['pr_date'];
        $dr_no = $headers['dr_no'];


        $pdf = Globals::pdf();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('DejaVu Sans', '', 10);

        $pdf->AddPage();

        $html = '
            <style type="text/css">
                .text-center { text-align: center; }
                .title { font-size: 12px; }
                .sub-title { font-size: 10px; }
                .title-report { font-size: 15px; font-weight: bold; } 
                .table_main { font-size: 8px; }
                .table_details { font-size: 8px; width: 100%; }
                .table_footer { font-size: 8px; width: 100%; }
                .border-bottom { border-bottom: 1px solid #333; font-size: 8px; }
                .row_label { width: 120px; }
                .row_content_sm { width: 100px; }
                .row_content_lg { width: 300px; }
                .noted { font-size: 8px; }
            </style>

            <div id="header" class="text-center">
                <span class="title">ASIA BREWERY INCORPORATED</span><br/>
                <span class="sub-title">6th FLOOR ALLIED BANK CENTER, AYALA AVENUE, MAKATI CITY</span><br/>
                <span class="title-report">DELIVERY RECEIPT</span>
            </div><br/><br/>

            <table class="table_main">
                <tr>
                    <td clss="row_label">SALES OFFICE NAME</td>
                    <td class="border-bottom row_content_lg">' . $sales_office_name . '</td>
                    <td style="width: 10px;"></td>
                    <td clss="row_label">DELIVERY DATE</td>
                    <td class="border-bottom row_content_sm">' . $transaction_date . '</td>
                </tr>
                <tr>
                    <td>ADDRESS</td>
                    <td class="border-bottom">' . $sales_office_address . '</td>
                    <td></td>
                    <td>PLAN DATE</td>
                    <td class="border-bottom">' . $plan_delivery_date . '</td>
                </tr>
            </table><br/><br/>

            <table class="table_main">
                <tr>
                    <td clss="row_label">PR NUMBER</td>
                    <td class="border-bottom row_content_sm">' . $pr_no . '</td>
                    <td style="width: 10px;"></td>
                    <td clss="row_label">WAREHOUSE NAME</td>
                    <td class="border-bottom row_content_lg"></td>
                </tr>
                <tr>
                    <td>RRA NUMBER</td>
                    <td class="border-bottom">' . $rra_no . '</td>
                    <td></td>
                    <td>CONTACT PERSON</td>
                    <td class="border-bottom"></td>
                </tr>
                <tr>
                    <td>RRA DATE</td>
                    <td class="border-bottom">' . $rra_date . '</td>
                    <td></td>
                    <td>ADDRESS</td>
                    <td class="border-bottom"></td>
                </tr>
                <tr>
                    <td>DR NUMBER</td>
                    <td class="border-bottom">' . $dr_no . '</td>
                    <td></td>
                    <td></td>
                    <td class="border-bottom"></td>
                </tr>
            </table><br/><br/><br/>  
        
            <table class="table_details" border="1">
                <tr>
                    <td>MM CODE</td>
                    <td>MM DESCRIPTION</td>
                    <td>MM BRAND</td>
                    <td>MM CATEGORY</td>
                    <td>ALLOCATION</td>
                    <td>QUANTITY ISSUED</td>
                    <td>UOM</td>
                    <td>UNIT PRICE</td>
                    <td>AMOUNT</td>
                    <td>EXPIRY DATE</td>
                    <td>REMARKS</td>
                </tr>';

        $planned_qty = 0;
        $actual_qty = 0;
        $total_unit_price = 0;
        foreach ($details as $key => $val) {
            $sku = Sku::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "sku_id" => $val['sku_id']));
            $uom = UOM::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "uom_id" => $val['uom_id']));

            $html .= '<tr>
                            <td>' . $sku->sku_code . '</td>
                            <td>' . $sku->description . '</td>
                            <td>' . $sku->brand->brand_name . '</td>
                            <td>' . $sku->type . '</td>
                            <td>' . $val['planned_quantity'] . '</td>
                            <td>' . $val['quantity_issued'] . '</td>
                            <td>' . $uom->uom_name . '</td>
                            <td>&#x20B1; ' . number_format($val['unit_price'], 2, '.', ',') . '</td>
                            <td>&#x20B1; ' . number_format($val['amount'], 2, '.', ',') . '</td>
                            <td>' . $val['expiration_date'] . '</td>
                            <td>' . $val['remarks'] . '</td>
                        </tr>';

            $planned_qty += $val['planned_quantity'];
            $actual_qty += $val['quantity_issued'];
            $total_unit_price += $val['unit_price'];
        }

        $html .= '<tr>
                    <td colspan="11"></td>
                </tr>';

        $html .= '<tr>
                    <td colspan="11"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">GRAND TOTAL</td>
                    <td>' . $planned_qty . '</td>
                    <td>' . $actual_qty . '</td>
                    <td></td>
                    <td>&#x20B1; ' . number_format($total_unit_price, 2, '.', ',') . '</td>
                    <td>&#x20B1; ' . number_format($headers['total_amount'], 2, '.', ',') . '</td>
                    <td colspan="2"></td>
                </tr>';

        $html .= '</table><br/><br/><br/>
            
            <table class="table_footer">
                <tr>
                    <td style="width: 180px; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">REMARKS</td>
                    <td style="width: 30px;"></td>
                    <td style="width: 80px;">SHIPPED VIA:</td>
                    <td class="border-bottom" style="width: 120px;"></td>
                    <td style="width: 30px;"></td>
                    <td style="width: 100px;">TRUCK NO.:</td>
                    <td class="border-bottom" style="width: 130px;"></td>
                </tr>
                <tr>
                    <td rowspan="5" style="border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>CHECKED BY:</td>
                    <td class="border-bottom"></td>
                    <td></td>
                    <td>DRIVER"S NAME:</td>
                    <td class="border-bottom"></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>AUTHORIZED BY:</td>
                    <td class="border-bottom"></td>
                    <td></td>
                    <td>DRIVER"S SIGNATURE:</td>
                    <td class="border-bottom"></td>
                </tr>
                <tr><td colspan="6"></td></tr>
                <tr><td colspan="6"></td></tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">Received the above goods in good order and condition</td>
                </tr>
                <tr><td colspan="6"></td></tr>
                <tr><td colspan="6"></td></tr>
                <tr><td colspan="6"></td></tr>
                <tr><td colspan="6"></td></tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2" class="border-bottom"></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2" style="text-align: center;">NAME & SIGNATURE OF RECEIPIENT</td>
                </tr>
            </table><br/><br/><br/><br/><br/>';
        
        $html .= '<table class="noted" style="border-style: dashed dashed dashed dashed;">
                    <tr>
                        <td>Noted:</td>
                        <td colspan="11"></td>
                    </tr> 
                    <tr>
                        <td></td>
                        <td colspan="2"><b>TERM</b></td>
                        <td colspan="2"><b>DEEFINITION</b></td>
                        <td colspan="6"></td>
                    </tr>  
                    <tr><td colspan="11"></td></tr>
                    <tr>
                        <td></td>
                        <td colspan="2">Allocation</td>
                        <td colspan="2">Planned QTY</td>
                        <td colspan="6"></td>
                    </tr>    
                    <tr>
                        <td></td>
                        <td colspan="2">Qty Issued</td>
                        <td colspan="2">Actual QTY</td>
                        <td colspan="6"></td>
                    </tr>  
                    <tr><td colspan="11"></td></tr>              
                </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('outbound.pdf', 'I');
    }
   

}
