<?php

class DeliveryLeadTimeController extends Controller {

   public function accessRules() {
      return array(
          array('allow', // allow all users to perform 'index' and 'view' actions
              'actions' => array('index', 'view', 'Export'),
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
      $this->pageTitle = 'Delivery Lead-Time Report';

      $model = new DeliveryLeadTimeReportForm;
      $destination = "";
      $from_date = "";
      $to_date = "";
      $content_data = array();


      if (isset($_POST['DeliveryLeadTimeReportForm'])) {
         $destination = isset($_POST['destination']) ? $_POST['destination'] : "";
         $from_date = isset($_POST['DeliveryLeadTimeReportForm']['from_date']) ? $_POST['DeliveryLeadTimeReportForm']['from_date'] : "";
         $to_date = isset($_POST['DeliveryLeadTimeReportForm']['to_date']) ? $_POST['DeliveryLeadTimeReportForm']['to_date'] : "";
         $content_data = $model->getData($destination, $from_date, $to_date);
      }



      $this->render('index', array(
          'model' => $model,
          'destination' => $destination,
          'from_date' => $from_date,
          'to_date' => $to_date,
          'content_data' => $content_data,
      ));
   }

   public function actionExport() {

      $model = new DeliveryLeadTimeReportForm;
      $content_data = array();

      if (isset($_POST)) {

         $destination = isset($_POST['destination']) ? $_POST['destination'] : "";
         $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : "";
         $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : "";
         $content_data = $model->getData($destination, $from_date, $to_date);
      } else {
         return false;
      }

      $objPHPExcel = Globals::createExcel();

      spl_autoload_register(array('YiiBase', 'autoload'));

      $objPHPExcel->getProperties()->setCreator("");
      $objPHPExcel->getProperties()->setLastModifiedBy("");
      $objPHPExcel->getProperties()->setTitle("Delivery Lead-Time Report " . date("F j, Y", strtotime($from_date)) . " to " . date("F j, Y", strtotime($to_date)));
      $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
//      $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'DELIVERY LEAD-TIME REPORT ' . date("F j, Y", strtotime($from_date)) . " to " . date("F j, Y", strtotime($to_date)));
      $objPHPExcel->getActiveSheet()->mergeCells('B2:J2');
      $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'MARKETING');
      $objPHPExcel->getActiveSheet()->mergeCells('D4:G4');
      $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      switch ($destination) {
         case "SW":
            $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'SUPPLIER');
            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->SetCellValue('I4', 'WAREHOUSE');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'SUPPLIER');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("B5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'WAREHOUSE');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
            $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C5")->getFont()->setBold(true);

            break;
         case "WS":
            $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'WAREHOUSE');
            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->SetCellValue('I4', 'SALES OFFICE');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'WAREHOUSE');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("B5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'SALES OFFICE');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
            $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C5")->getFont()->setBold(true);
            break;
         case "SO":
            $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'SALES OFFICE');
            $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->SetCellValue('I4', 'OUTLET');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'SALES OFFICE');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("B5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'OUTLET');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
            $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C5")->getFont()->setBold(true);
            break;
         default:
            return false;
            break;
      }
      $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'PO NO.');
      $objPHPExcel->getActiveSheet()->mergeCells('D5:D6');
      $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle("D5")->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'PR NO.');
      $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
      $objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle("E5")->getFont()->setBold(true);
      if ($destination == "SO") {
         $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'RA NO.');
         $objPHPExcel->getActiveSheet()->mergeCells('F5:F6');
         $objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("F5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'RA DATE');
         $objPHPExcel->getActiveSheet()->mergeCells('G5:G6');
         $objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("G5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'PLAN DELIVERY DATE');
         $objPHPExcel->getActiveSheet()->mergeCells('H5:H6');
         $objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("H5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'DR RECEIVED');
         $objPHPExcel->getActiveSheet()->mergeCells('I5:I6');
         $objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("I5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'DELIVERY LEAD TIME');
         $objPHPExcel->getActiveSheet()->mergeCells('J5:K5');
         $objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("J5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('J6', 'RA DATE');
         $objPHPExcel->getActiveSheet()->getStyle('J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("J6")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'PLAN DELIVERY DATE');
         $objPHPExcel->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("K6")->getFont()->setBold(true);
      } else {
         $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'PR DATE');
         $objPHPExcel->getActiveSheet()->mergeCells('F5:F6');
         $objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("F5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'PLAN DELIVERY DATE');
         $objPHPExcel->getActiveSheet()->mergeCells('G5:G6');
         $objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("G5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'DR NO.');
         $objPHPExcel->getActiveSheet()->mergeCells('H5:H6');
         $objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("H5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'DR RECEIVED');
         $objPHPExcel->getActiveSheet()->mergeCells('I5:I6');
         $objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("I5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'DELIVERY LEAD TIME');
         $objPHPExcel->getActiveSheet()->mergeCells('J5:K5');
         $objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("J5")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('J6', 'PR DATE');
         $objPHPExcel->getActiveSheet()->getStyle('J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("J6")->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'PLAN DELIVERY DATE');
         $objPHPExcel->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle("K6")->getFont()->setBold(true);
      }



      $objPHPExcel->getActiveSheet()->getStyle("B7:K8")->applyFromArray(array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      ));
      for ($i = 1; $i <= 10; $i++) {
         $objPHPExcel->getActiveSheet()->getColumnDimension('' . $this->getletter($i) . '')->setAutoSize(true);
      }

      switch ($destination) {
         case "SW":
            $row = 6;
            foreach ($content_data as $key => $val) {
               $row++;
               $objPHPExcel->getActiveSheet()->SetCellValue("B" . $row, $val['supplier_name']);
               $objPHPExcel->getActiveSheet()->SetCellValue("C" . $row, $val['sales_office_name']);
               $objPHPExcel->getActiveSheet()->SetCellValue("D" . $row, $val['campaign_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("E" . $row, $val['pr_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("F" . $row, $val['pr_date']);
               $objPHPExcel->getActiveSheet()->SetCellValue("G" . $row, $val['plan_delivery_date']);
               $objPHPExcel->getActiveSheet()->SetCellValue("H" . $row, $val['dr_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("I" . $row, $val['transaction_date']);
               if (!empty($val['pr_date'])) {
                   $objPHPExcel->getActiveSheet()->SetCellValue("J" . $row, "=I" . $row . "-F" . $row);
                }
                else{
                    $objPHPExcel->getActiveSheet()->SetCellValue("J" . $row, '--');
                }
                if (!empty($val['plan_delivery_date'])) {
                  $objPHPExcel->getActiveSheet()->SetCellValue("K" . $row, "=G" . $row . "-I" . $row);
               }
               else{
                  $objPHPExcel->getActiveSheet()->SetCellValue("K" . $row, '--');
               }
            }
            break;
         case "WS":
            $row = 6;
            foreach ($content_data as $key => $val) {
               $row++;
               $objPHPExcel->getActiveSheet()->SetCellValue("B" . $row, $val['warehouse']);
               $objPHPExcel->getActiveSheet()->SetCellValue("C" . $row, $val['sales_office_name']);
               $objPHPExcel->getActiveSheet()->SetCellValue("D" . $row, $val['campaign_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("E" . $row, $val['pr_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("F" . $row, $val['pr_date']);
               $objPHPExcel->getActiveSheet()->SetCellValue("G" . $row, $val['plan_delivery_date']);
               $objPHPExcel->getActiveSheet()->SetCellValue("H" . $row, $val['dr_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("I" . $row, $val['transaction_date']);
                if (!empty($val['pr_date'])) {
                   $objPHPExcel->getActiveSheet()->SetCellValue("J" . $row, "=I" . $row . "-F" . $row);
                }
                else{
                    $objPHPExcel->getActiveSheet()->SetCellValue("J" . $row, '--');
                }
                if (!empty($val['plan_delivery_date'])) {
                  $objPHPExcel->getActiveSheet()->SetCellValue("K" . $row, "=G" . $row . "-I" . $row);
               }
               else{
                  $objPHPExcel->getActiveSheet()->SetCellValue("K" . $row, '--');
               }
               
            }
            break;
         case "SO":
            $row = 6;
            foreach ($content_data as $key => $val) {
               $row++;
               $objPHPExcel->getActiveSheet()->SetCellValue("B" . $row, $val['sales_office_name']);
               $objPHPExcel->getActiveSheet()->SetCellValue("C" . $row, $val['short_name']);
               $objPHPExcel->getActiveSheet()->SetCellValue("D" . $row, $val['campaign_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("E" . $row, $val['pr_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("F" . $row, $val['rra_no']);
               $objPHPExcel->getActiveSheet()->SetCellValue("G" . $row, $val['rra_date']);
               $objPHPExcel->getActiveSheet()->SetCellValue("H" . $row, $val['plan_arrival_date']);
               $objPHPExcel->getActiveSheet()->SetCellValue("I" . $row, $val['transaction_date']);
               if (!empty($val['rra_date'])) {
                   $objPHPExcel->getActiveSheet()->SetCellValue("J" . $row, "=I" . $row . "-G" . $row);
                }
                else{
                    $objPHPExcel->getActiveSheet()->SetCellValue("J" . $row, '--');
                }
                if (!empty($val['plan_arrival_date'])) {
                  $objPHPExcel->getActiveSheet()->SetCellValue("K" . $row, "=H" . $row . "-I" . $row);
               }
               else{
                  $objPHPExcel->getActiveSheet()->SetCellValue("K" . $row, '--');
               }
            }
            break;
         default:
            return false;
            break;
      }

      $objPHPExcel->getActiveSheet()->getStyle("B5:K" . $row)->applyFromArray(array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      ));


      $objPHPExcel->getActiveSheet()->setTitle('DELIVERY LEAD-TIME REPORT');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="delivery-lead-time-report-' . $from_date . ' to ' . $to_date . '.xls');
      header('Cache-Control: max-age=0');
      $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
      $objWriter->save('php://output');
   }

   public function getletter($id) {
      $alphas = range('A', 'Z');
      return $alphas[$id];
   }

}