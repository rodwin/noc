<?php

class EndingInventoryController extends Controller {

   public function accessRules() {
      return array(
          array('allow', // allow all users to perform 'index' and 'view' actions
              'actions' => array('index', 'view', 'getWarehouse', 'getBrandCategory', 'getBrand', 'generateEndingReport', 'export'),
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
      $this->pageTitle = 'Ending Inventory Report';

      $model = new EndingReportForm;

      $brand_category = CHtml::listData(BrandCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'brand_category_id', 'category_name');


      $this->render('index', array(
          'model' => $model,
          'brand_category' => $brand_category,
      ));
   }

   public function actionGenerateEndingReport() {

      $model = new EndingReportForm;

      $validate = CActiveForm::validate($model);

      $output = array();
      $output['success'] = true;

      if ($validate != '[]') {

         $output['error'] = $validate;
         $output['success'] = false;
         echo json_encode($output);
         Yii::app()->end();
      }

      if (!isset($_POST['so'])) {
         Yii::app()->end();
      } else {
         $so = $_POST['so'];
      }

      $brand = isset($_POST['brand']) ? $_POST['brand'] : "";
      $brand_category = isset($_POST['brand_category']) ? $_POST['brand_category'] : "";
      $cover_date = isset($_POST['EndingReportForm']['cover_date']) ? $_POST['EndingReportForm']['cover_date'] : "";

      $warehouses = "";
      foreach ($so as $key => $val) {
         $warehouses .= "'" . $key . "',";
      }

      $last_date_time = $cover_date; //. " 23:59:59";

      $ret_data = $model->getData(substr($warehouses, 0, -1), $brand_category, $brand, $last_date_time);

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
         $row['total'] = $value['qty'] * $value['price'];

         $output['row_data'][] = $row;
      }

      $output['covered_date'] = date("F j, Y", strtotime($cover_date));
      $output['hidden_warehouse'] = substr($warehouses, 0, -1);
      $output['hidden_category'] = $brand_category;
      $output['hidden_brand'] = $brand;
      $output['hidden_cover_date'] = $cover_date;

      echo json_encode($output);
      Yii::app()->end();
   }

   public function actionExport() {

      $model = new EndingReportForm;

      $sales_offices = isset($_POST['sales_office_ids']) ? $_POST['sales_office_ids'] : "";
      $brand = isset($_POST['brand']) ? $_POST['brand'] : "";
      $brand_category = isset($_POST['brand_category']) ? $_POST['brand_category'] : "";
      $cover_date = isset($_POST['cover_date']) ? $_POST['cover_date'] : "";

      $last_date_time = $cover_date; //. " 23:59:59";

      $data = $model->getData($sales_offices, $brand_category, $brand, $last_date_time);

      $objPHPExcel = Globals::createExcel();

      spl_autoload_register(array('YiiBase', 'autoload'));

      $objPHPExcel->getProperties()->setCreator("");
      $objPHPExcel->getProperties()->setLastModifiedBy("");
      $objPHPExcel->getProperties()->setTitle("Ending Report as of " . date("F j, Y", strtotime($cover_date)));
      $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
//        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'ENDING INVENTORY REPORT AS OF ' . date("F j, Y", strtotime($cover_date)));
      $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'WAREHOUSE');
      $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'ZONE');
      $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'BRAND CATEGORY');
      $objPHPExcel->getActiveSheet()->SetCellValue('E4', 'BRAND');
      $objPHPExcel->getActiveSheet()->SetCellValue('F4', 'MM CODE');
      $objPHPExcel->getActiveSheet()->SetCellValue('G4', 'MM DESCRIPTION');
      $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'MM CATEGORY');
      $objPHPExcel->getActiveSheet()->SetCellValue('I4', 'MM SUB CATEGORY');
      $objPHPExcel->getActiveSheet()->SetCellValue('J4', 'INVENTORY ON HAND');
      $objPHPExcel->getActiveSheet()->SetCellValue('K4', 'UNIT PRICE');
      $objPHPExcel->getActiveSheet()->SetCellValue('L4', 'UOM');
      $objPHPExcel->getActiveSheet()->SetCellValue('M4', 'TOTAL AMOUNT');
      $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
      $objPHPExcel->getActiveSheet()->getStyle("B3")->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->getStyle("B4:M4")->applyFromArray(array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      ));
      $objPHPExcel->getActiveSheet()->getStyle("B4:M4")->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);

      $ctr = 4;

      foreach ($data as $key => $val) {
         $ctr++;
         $objPHPExcel->getActiveSheet()->SetCellValue('B' . $ctr . '', $val['sales_office_name']);
         $objPHPExcel->getActiveSheet()->SetCellValue('C' . $ctr . '', $val['zone_name']);
         $objPHPExcel->getActiveSheet()->SetCellValue('D' . $ctr . '', $val['category_name']);
         $objPHPExcel->getActiveSheet()->SetCellValue('E' . $ctr . '', $val['brand_name']);
         $objPHPExcel->getActiveSheet()->SetCellValue('F' . $ctr . '', $val['sku_code']);
         $objPHPExcel->getActiveSheet()->SetCellValue('G' . $ctr . '', $val['description']);
         $objPHPExcel->getActiveSheet()->SetCellValue('H' . $ctr . '', $val['type']);
         $objPHPExcel->getActiveSheet()->SetCellValue('I' . $ctr . '', $val['sub_type']);
         $objPHPExcel->getActiveSheet()->SetCellValue('J' . $ctr . '', $val['qty']);
         $objPHPExcel->getActiveSheet()->SetCellValue('K' . $ctr . '', $val['price']);
         $objPHPExcel->getActiveSheet()->SetCellValue('L' . $ctr . '', $val['uom_name']);
         $objPHPExcel->getActiveSheet()->SetCellValue('M' . $ctr . '', '=J'. $ctr .'*K' .$ctr);
         
         $objPHPExcel->getActiveSheet()->getStyle('B'. $ctr . ':M'. $ctr)->applyFromArray(array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      ));
      }
      
      $objPHPExcel->getActiveSheet()->setTitle('Ending Report');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="ending-inventory-report-' . $cover_date . '.xls');
      header('Cache-Control: max-age=0');
      $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
      $objWriter->save('php://output');
   }

}
