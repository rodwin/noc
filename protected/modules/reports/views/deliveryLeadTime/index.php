<?php
/* @var $this DeliveryLeadTimeController */

$this->breadcrumbs = array(
    'Delivery Lead Time',
);
?>

<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.date.extensions.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.extensions.js', CClientScript::POS_END);
?>

<div class="box box-primary">
   <div class="box-header">
      <h3 class="box-title"></h3>
   </div>

   <?php
   $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
       'id' => 'infra-inventory-form',
       'enableAjaxValidation' => false,
           ));
   ?>

   <div class="box-body clearfix">
      <div class="col-md-6">
         <div class="clearfix" style="margin-left: 10px; margin-right: 10px;">
            <br/>
            <div class="pull-left" style="width: 30%;">

               <label>Destination</label><br/><br/><br/>
               <label>FROM</label><br/><br/>
               <label>TO</label>
            </div>

            <div class="pull-right"  style="width: 70%;">

               <?php
               $this->widget(
                       'booster.widgets.TbSelect2', array(
                   'name' => 'destination',
                   'data' => array('SW' => 'SUPPLIER TO WAREHOUSE', 'WS' => 'WAREHOUSE TO SALES OFFICE', 'SO' => 'SALES OFFICE TO OUTLET'),
                   'options' => array(
                       'placeholder' => '',
                       'width' => '100%',
                   ),
                   'val' => array(
                       isset($_POST['destination']) ? $_POST['destination'] : ''
                   ),         
                   'htmlOptions' => array('id' => 'destination', 'name' => 'destination', 'class' => 'form-control', 'prompt' => '--'),
               ));
               ?><br/>

               <?php echo $form->textFieldGroup($model, 'from_date', array('widgetOptions' => array('htmlOptions' => array('class' => ' span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'value' =>  isset($from_date) ? $from_date : date("Y-m-d"), 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>
               <?php echo $form->textFieldGroup($model, 'to_date', array('widgetOptions' => array('htmlOptions' => array('class' => ' span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'value' => isset($to_date) ? $to_date : date("Y-m-d"), 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

               <div class="form-group">
                  <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary btn-flat')); ?>
               </div>
            </div>

         </div>

      </div>

      <?php $this->endWidget(); ?>

      <div class="clearfix" ><br/><br/></div>
      <div class="box-body table-responsive">
         <h4 class="control-label text-primary"><b>DELIVERY LEAD-TIME REPORT <span id="covered_date_title"><?php echo!empty($from_date) && !empty($to_date) ? " (" . date("F j, Y", strtotime($from_date)) . " TO " . date("F j, Y", strtotime($to_date)) . ")" : "" ?></span></b></h4>
         <?php if (empty($from_date) || empty($to_date) || empty($content_data)) { ?>
            <h6 style="text-align: center;"><em>No Data Found.</em></h6>
         <?php } ?>

         <?php
         if (count($content_data) > 0 && !empty($from_date) && !empty($to_date)) {
            switch ($destination) {
               case "SW":
                  ?>
                  <table id='delivery_lead_time_table' class='table table-bordered' style='width:100%;'>

                     <thead>
                        <tr >
                           <td align = "center" rowspan ="2">SUPPLIER</td>
                           <td align = "center" rowspan ="2">WAREHOUSE</td>
                           <td align = "center" rowspan ="2">CAMPAIGN NO.</td>
                           <td align = "center" rowspan ="2">PR NO.</td>
                           <td align = "center" rowspan ="2">PR DATE</td>
                           <td align = "center" rowspan ="2">PLAN DATE</td>
                           <td align = "center" rowspan ="2">DR NO.</td>
<!--                           <td align = "center" rowspan ="2">DR DATE</td>-->
                           <td align = "center" rowspan ="2">DR RECEIVED</td>
                           <td align = "center" colspan ="2">DELIVERY LEAD TIME</td>                     
                        </tr>
                        <tr>
                           <td>PR DATE</td>
                           <td>DR DATE</td>
                        </tr>
                     </thead>
                     <tbody> <?php $ctr = 0; ?>  
                        <?php foreach ($content_data as $key => $val) { ?>
                           <tr>
                              <td><?php echo $val['supplier_name'] ?></td>
                              <td><?php echo $val['sales_office_name'] ?></td>
                              <td><?php echo $val['campaign_no'] ?></td>
                              <td><?php echo $val['pr_no'] ?></td>
                              <td><?php echo $val['pr_date'] ?></td>
                              <td><?php echo $val['plan_delivery_date'] ?></td>
                              <td><?php echo $val['dr_no'] ?></td>
<!--                              <td><?php echo $val['dr_date'] ?></td>-->
                              <td><?php echo $val['transaction_date'] ?></td>
                              <td><?php echo round((strtotime($val['transaction_date']) - strtotime($val['pr_date'])) / (60 * 60 * 24)) ?></td>
                              <td><?php
                                 if (!empty($val['plan_delivery_date'])) {
                                    echo round((strtotime($val['transaction_date']) - strtotime($val['plan_delivery_date'])) / (60 * 60 * 24));
                                 } else {
                                    echo '--';
                                 }
                           ?></td>

                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>

                  <?php
                  break;

               case "WS":
                  ?>
                  <table id='delivery_lead_time_table' class='table table-bordered' style='width:100%;'>

                     <thead>
                        <tr >
                           <td align = "center" rowspan ="2">WAREHOUSE</td>
                           <td align = "center" rowspan ="2">SALES OFFICE</td>
                           <td align = "center" rowspan ="2">CAMPAIGN NO.</td>
                           <td align = "center" rowspan ="2">PR NO.</td>
                           <td align = "center" rowspan ="2">PR DATE</td>
                           <td align = "center" rowspan ="2">DATE PR RECEIVED</td>
                           <td align = "center" rowspan ="2">DR NO.</td>
<!--                           <td align = "center" rowspan ="2">DR DATE</td>-->
                           <td align = "center" rowspan ="2">DR RECEIVED</td>
                           <td align = "center" colspan ="2">DELIVERY LEAD TIME</td>                     
                        </tr>
                        <tr>
                           <td>PR DATE</td>
                           <td>DR DATE</td>
                        </tr>
                     </thead>
                     <tbody> <?php $ctr = 0; ?>  
                        <?php foreach ($content_data as $key => $val) { ?>
                           <tr>
                              <td><?php echo $val['warehouse'] ?></td>
                              <td><?php echo $val['sales_office_name'] ?></td>
                              <td><?php echo $val['campaign_no'] ?></td>
                              <td><?php echo $val['pr_no'] ?></td>
                              <td><?php echo $val['pr_date'] ?></td>
                              <td><?php echo $val['plan_delivery_date'] ?></td>
                              <td><?php echo $val['dr_no'] ?></td>
<!--                              <td><?php echo $val['dr_date'] ?></td>-->
                              <td><?php echo $val['transaction_date'] ?></td>
                              <td><?php
                                    if (!empty($val['pr_date'])) {
                                       echo round((strtotime($val['transaction_date']) - strtotime($val['pr_date'])) / (60 * 60 * 24));
                                    } else {
                                       echo '--';
                                    }
                              ?></td>
                              <td><?php
                                    if (!empty($val['plan_delivery_date'])) {
                                       echo round(( strtotime($val['plan_delivery_date']) - strtotime($val['transaction_date'])) / (60 * 60 * 24));
                                    } else {
                                       echo '--';
                                    }
                              ?></td>

                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>

                  <?php
                  break;
               case "SO":
                  ?>
                  <table id='delivery_lead_time_table' class='table table-bordered' style='width:100%;'>

                     <thead>
                        <tr >
                           <td align = "center" rowspan ="2">SALES OFFICE</td>
                           <td align = "center" rowspan ="2">OUTLET</td>
                           <td align = "center" rowspan ="2">CAMPAIGN NO.</td>
                           <td align = "center" rowspan ="2">PR NO.</td>
                           <td align = "center" rowspan ="2">RRA NO.</td>
                           <td align = "center" rowspan ="2">RRA DATE</td>
                           <td align = "center" rowspan ="2">DR NO.</td>
<!--                           <td align = "center" rowspan ="2">DR DATE</td>-->
                           <td align = "center" rowspan ="2">DR RECEIVED</td>
                           <td align = "center" colspan ="2">DELIVERY LEAD TIME</td>                     
                        </tr>
                        <tr>
                           <td>RRA DATE</td>
                           <td>DR DATE</td>
                        </tr>
                     </thead>
                     <tbody> <?php $ctr = 0; ?>  
                        <?php foreach ($content_data as $key => $val) { ?>
                           <tr>
                              <td><?php echo $val['sales_office_name'] ?></td>
                              <td><?php echo $val['short_name'] ?></td>
                              <td><?php echo $val['campaign_no'] ?></td>
                              <td><?php echo $val['pr_no'] ?></td>
                              <td><?php echo $val['rra_no'] ?></td>
                              <td><?php echo $val['rra_date'] ?></td>
                              <td><?php echo $val['dr_no'] ?></td>
<!--                              <td><?php echo $val['dr_date'] ?></td>-->
                              <td><?php echo $val['transaction_date'] ?></td>
                              <td><?php 
                                    if (!empty($val['rra_date'])) {
                                       echo round((strtotime($val['transaction_date']) - strtotime($val['rra_date'])) / (60 * 60 * 24)); 
                                    } else {
                                       echo '--';
                                    }
                              ?></td>
                              <td><?php
                                    if (!empty($val['dr_date'])) {
                                       echo round((strtotime($val['dr_date']) - strtotime($val['transaction_date'])) / (60 * 60 * 24));
                                    } else {
                                       echo '--';
                                    }
                           ?></td>

                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>

                  <?php
                  break;
            }
            ?>
            <?php
            $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm', array(
                'action' => $this->createUrl("deliveryLeadTime/export"),
                'method' => 'post'
                    )
            );
            ?>
            <input type="hidden" id="destination" name="destination" value=<?php echo $destination ?> />
            <input type="hidden" id="from_date" name="from_date" value=<?php echo $from_date ?> />
            <input type="hidden" id="to_date" name="to_date" value=<?php echo $to_date ?> />
            <br/>
            <div class="form-group col-md-12">
               <?php echo CHtml::submitButton('Export', array('class' => 'btn btn-primary btn-flat', 'id' => 'btn_export')); ?>
            </div>
            <?php $this->endWidget(); ?>
         <?php } else { ?>

            <?php
            $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm', array(
                'action' => $this->createUrl("deliveryLeadTime/export"),
                'method' => 'post'
                    )
            );
            ?>
            <input type="hidden" id="destination" name="destination" value=<?php echo $destination ?> />
            <input type="hidden" id="from_date" name="from_date" value=<?php echo $from_date ?> />
            <input type="hidden" id="to_date" name="to_date" value=<?php echo $to_date ?> />
            <br/>
            <div class="form-group col-md-12">
               <?php echo CHtml::submitButton('Export', array('class' => 'btn btn-primary btn-flat', 'style' => 'display: none;','id' => 'btn_export')); ?>
            </div>
            <?php $this->endWidget(); ?>

         <?php } ?>

      </div>





   </div>
</div>


<script type="text/javascript">
   var delivery_lead_time_table;
   $(function() {

      $("#DeliveryLeadTimeReportForm_from_date, #DeliveryLeadTimeReportForm_to_date").datepicker();
      $("[data-mask]").inputmask();

      

   });

</script>
