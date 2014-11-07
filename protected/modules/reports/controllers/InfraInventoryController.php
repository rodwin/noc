<?php

class InfraInventoryController extends Controller {

   public function accessRules() {
      return array(
          array('allow', // allow all users to perform 'index' and 'view' actions
              'actions' => array('index', 'view', 'generateInfraReport', 'generateHeader', 'export'),
              'users' => array('@'),
          ),
          array('allow', // allow authenticated user to perform 'create' and 'update' actions
              'actions' => array('create', 'update', 'data'),
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

   public function actionIndex() {

      $this->layout = '//layouts/column1';
      $this->pageTitle = 'Infra Inventory Report';

      $model = new InfraReportForm;

      $brand_list = CHtml::listData(Brand::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'brand_name ASC')), 'brand_id', 'brand_name');

      $tbl_header = array();
      $warehouse = array();
      $content_data = array();
      $tbl_header_arr = array();
      $warehouse_arr = array();
      $content_data_arr = array();
      $cover_date = "";
      $brand = "";

      if (isset($_POST['InfraReportForm'])) {

         $brand = isset($_POST['brand']) ? $_POST['brand'] : "";
         $cover_date = isset($_POST['InfraReportForm']['cover_date']) ? $_POST['InfraReportForm']['cover_date'] : "";
         $last_date_time = $cover_date; //. " 23:59:59";
         $tbl_header = $model->getHeader($brand);
         $warehouse = $model->getWarehouse();
         $content_data = $model->getData($brand, $last_date_time);


         foreach ($tbl_header as $key => $value) {
            $tbl_header_arr[$value['sku_id']] = $value;
         }


         foreach ($warehouse as $key => $value) {
            $warehouse_arr[$value['default_zone_id']] = $value;
         }


         foreach ($content_data as $key => $value) {
            $content_data_arr[$value['zone_id']][$value['sku_id']] = $value;
         }

//       pr($tbl_header_arr);
//       pr($warehouse_arr);
//       pre($content_data_arr);
      }



      $this->render('index', array(
          'model' => $model,
          'brand' => $brand_list,
          'selected_brand' => $brand,
          'tbl_header' => $tbl_header_arr,
          'warehouse' => $warehouse_arr,
          'content_data' => $content_data_arr,
          'date_covered' => $cover_date,
      ));
   }

   public function actionGenerateInfraReport() {

      $model = new InfraReportForm;

      $validate = CActiveForm::validate($model);

      $output = array();
      $output['success'] = true;

      if ($validate != '[]') {

         $output['error'] = $validate;
         $output['success'] = false;
         echo json_encode($output);
         Yii::app()->end();
      }

      $brand = isset($_POST['brand']) ? $_POST['brand'] : "";
      $cover_date = isset($_POST['InfraReportForm']['cover_date']) ? $_POST['InfraReportForm']['cover_date'] : "";
      $last_date_time = $cover_date . " 23:59:59";

      $ret_data = $model->getData($brand, $last_date_time);
      pre($ret_data);
      foreach ($ret_data as $key => $value) {
         $row = array();
         $row['warehouse'] = $value['sales_office_name'];
         $row['zone'] = $value['zone_name'];
         $row['brand_category'] = $value['category_name'];
         $row['brand'] = $value['brand_name'];
         $row['mm_code'] = $value['sku_code'];
         $row['mm_description'] = $value['description'];
         $row['mm_category'] = $value['type'];
         $row['mm_sub_category'] = $value['sub_type'];
         $row['qty'] = $value['qty'];
         $row['price'] = $value['price'];
         $row['uom'] = $value['uom_name'];
         $row['total'] = $value['total'];

         $output['row_data'][] = $row;
      }

      $output['covered_date'] = date("F j, Y", strtotime($cover_date));
      $output['hidden_brand'] = $brand;
      $output['hidden_cover_date'] = $cover_date;

      echo json_encode($output);
      Yii::app()->end();
   }

   public function actionGenerateHeader() {

      $model = new InfraReportForm;

      $validate = CActiveForm::validate($model);

      $output = array();
      $output['success'] = true;

      if ($validate != '[]') {

         $output['error'] = $validate;
         $output['success'] = false;
         echo json_encode($output);
         Yii::app()->end();
      }

      $brand = isset($_POST['brand']) ? $_POST['brand'] : "";

      $ret_data = $model->getHeader($brand);

      foreach ($ret_data as $key => $value) {
         $row = array();
         $row['col'] = $value['sku_name'];


         $output['row_data'][] = $row;
      }
      echo json_encode($output);
      Yii::app()->end();
   }

   public function actionExport() {

      $model = new InfraReportForm;
      $tbl_header = array();
      $warehouse = array();
      $content_data = array();
      $tbl_header_arr = array();
      $warehouse_arr = array();
      $content_data_arr = array();
      $cover_date = "";

      if (isset($_POST)) {

         $brand = isset($_POST['brand']) ? $_POST['brand'] : "";
         $cover_date = isset($_POST['cover_date']) ? $_POST['cover_date'] : "";
         $last_date_time = $cover_date; //. " 23:59:59";
         $tbl_header = $model->getHeader($brand);
         $warehouse = $model->getWarehouse();
         $content_data = $model->getData($brand, $last_date_time);


         foreach ($tbl_header as $key => $value) {
            $tbl_header_arr[$value['sku_id']] = $value;
         }


         foreach ($warehouse as $key => $value) {
            $warehouse_arr[$value['default_zone_id']] = $value;
         }


         foreach ($content_data as $key => $value) {
            $content_data_arr[$value['zone_id']][$value['sku_id']] = $value;
         }
      } else {
         return false;
      }
      $brand = Brand::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "brand_id" => $brand));
      $brand = $brand['brand_name'];
      $objPHPExcel = Globals::createExcel();

      spl_autoload_register(array('YiiBase', 'autoload'));

      $objPHPExcel->getProperties()->setCreator("");
      $objPHPExcel->getProperties()->setLastModifiedBy("");
      $objPHPExcel->getProperties()->setTitle("Infra Inventory Report as of " . date("F j, Y", strtotime($cover_date)));
      $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
//      $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'INFRA INVENTORY REPORT AS OF ' . date("F j, Y", strtotime($cover_date)));
      $objPHPExcel->getActiveSheet()->mergeCells('B4:H4');
      $objPHPExcel->getActiveSheet()->getStyle("B4")->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->SetCellValue('B6', $brand);
      $letter = $this->getletter(count($tbl_header) + 1);
      $objPHPExcel->getActiveSheet()->mergeCells('B6:' . $letter . '6');
      $objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->getStyle("B6:" . $letter . "6")->applyFromArray(array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      ));

      $objPHPExcel->getActiveSheet()->SetCellValue('B7', 'WAREHOUSE');
      $objPHPExcel->getActiveSheet()->getStyle("B7")->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
      $col = 1; $row = 7;

      foreach ($tbl_header as $key => $val) {
         $col++;
         $letter = $this->getletter($col);
        $objPHPExcel->getActiveSheet()->SetCellValue($letter.$row, $val['sku_name']);
        $objPHPExcel->getActiveSheet()->getStyle($letter.$row)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
      }
      $objPHPExcel->getActiveSheet()->getStyle("B7:" . $letter . "7")->applyFromArray(array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      ));
      $col = 1; $row = 7;
      foreach ($warehouse_arr as $warehouse_header => $val){
         $row++;
         $objPHPExcel->getActiveSheet()->SetCellValue("B".$row, $val['sales_office_name']);
         foreach ($tbl_header_arr as $key_header => $v) { 
            $col++;
            if (isset($content_data_arr[$val['default_zone_id']][$v['sku_id']])) { 
               
               $letter = $this->getletter($col);
              $objPHPExcel->getActiveSheet()->SetCellValue($letter.$row,  $content_data_arr[$warehouse_header][$key_header]['qty']); 
            }
         }
          $col = 1;
         
      }
      
      $letter = $this->getletter(count($tbl_header) + 1);
       $objPHPExcel->getActiveSheet()->getStyle("B8:" . $letter.$row)->applyFromArray(array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      ));


      $objPHPExcel->getActiveSheet()->setTitle('Infra Report');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="infra-inventory-report-' . $cover_date . '.xls');
      header('Cache-Control: max-age=0');
      $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
      $objWriter->save('php://output');
   }
   public function getletter ($id){
         $alphas = range('A', 'Z');
      return $alphas[$id];
      }
}


