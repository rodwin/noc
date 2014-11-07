<?php
/* @var $this InfraInventoryController */

$this->breadcrumbs = array(
    'Infra Inventory',
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

               <label>Brand</label><br/><br/><br/>
               <label>Covered Date</label>
            </div>

            <div class="pull-right"  style="width: 70%;">

               <?php
               $this->widget(
                       'booster.widgets.TbSelect2', array(
                   'name' => 'brand',
                   'data' => $brand,
                   'options' => array(
                       'placeholder' => '',
                       'width' => '100%',
                   ),
                   'htmlOptions' => array('id' => 'brand', 'name' => 'brand', 'class' => 'form-control', 'prompt' => '--'),
               ));
               ?><br/>

               <?php echo $form->textFieldGroup($model, 'cover_date', array('widgetOptions' => array('htmlOptions' => array('class' => ' span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

               <div class="form-group">
                  <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary btn-flat')); ?>
               </div>
            </div>

         </div>

      </div>

      <?php $this->endWidget(); ?>

      <div class="clearfix" ><br/><br/></div>
      <div class="box-body table-responsive">
         <h4 class="control-label text-primary"><b>INFRA INVENTORY REPORT as of: <span id="covered_date_title"><?php echo!empty($date_covered) ? date("F j, Y", strtotime($date_covered)) : "" ?></span></b></h4>
         <?php if (empty($date_covered) || empty($tbl_header)) { ?>
            <h6 style="text-align: center;"><em>No Data Found.</em></h6>
         <?php } ?>



         <?php if (count($tbl_header) > 0 && !empty($date_covered)) { ?>

            <table id='infra-inventory_table' class='table table-bordered' style='width:100%;'>
               <thead>
                  <tr >
                     <td align = "center" colspan =<?php echo count($tbl_header) + 1 ?>>
                        <?php
                        $brand = Brand::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "brand_id" => $selected_brand));
                        $brand = $brand['brand_name'];
                        echo $brand
                        ?>
                     </td>
                  </tr>
                  <tr>
                     <td>WAREHOUSE</td>
                     <?php foreach ($tbl_header as $key_header => $v) { ?>
                        <td><?php echo $v['sku_name'] ?></td>
                     <?php } ?>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($warehouse as $warehouse_header => $val) { ?>
                     <tr>
                        <td><?php echo $val['sales_office_name'] ?></td>

                        <?php foreach ($tbl_header as $key_header => $v) { ?>


                           <?php if (isset($content_data[$val['default_zone_id']][$v['sku_id']])) { ?>
                              <?php echo '<td align = "center">' . $content_data[$warehouse_header][$key_header]['qty'] . '</td>' ?>
                           <?php } else { ?>
                              <?php echo '<td></td>' ?>
                           <?php } ?>

                        <?php } ?>

                     </tr>
                  <?php } ?>
               </tbody>
            </table>
            <?php
            $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm', array(
                'action' => $this->createUrl("infraInventory/export"),
                'method' => 'post'
                    )
            );
            ?>

            <input type="hidden" id="cover_date_hidden" name="cover_date" value=<?php echo $date_covered ?> />
      <!--        <input type="hidden" id="brand_category_hidden" name="brand_category" value="" />
            -->        <input type="hidden" id="brand_hidden" name="brand" value=<?php echo $selected_brand ?> /><!--
                    <textarea rows="4" cols="50" id="sales_office_ids_hidden" name="sales_office_ids" value="" style="display: none;"></textarea> -->
            <br/>
            <div class="form-group col-md-12">
               <?php echo CHtml::submitButton('Export', array('class' => 'btn btn-primary btn-flat', 'id' => 'btn_export')); ?>
            </div>
            <?php $this->endWidget(); ?>
         <?php } else { ?>
            <?php
            $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm', array(
                'action' => $this->createUrl("infraInventory/export"),
                'method' => 'post'
                    )
            );
            ?>

            <input type="hidden" id="cover_date_hidden" name="cover_date" value=<?php echo $date_covered ?> />
      <!--        <input type="hidden" id="brand_category_hidden" name="brand_category" value="" />
            -->        <input type="hidden" id="brand_hidden" name="brand" value=<?php echo $selected_brand ?> /><!--
                    <textarea rows="4" cols="50" id="sales_office_ids_hidden" name="sales_office_ids" value="" style="display: none;"></textarea> -->

            <div class="form-group col-md-12">
               <?php echo CHtml::submitButton('Export', array('class' => 'btn btn-primary btn-flat', 'style' => 'display: none;', 'id' => 'btn_export')); ?>
            </div>
            <?php $this->endWidget(); ?>
         <?php } ?>
      </div>





   </div>
</div>


<script type="text/javascript">
   var infra_inventory_table;
   $(function() {

      $("#InfraReportForm_cover_date").datepicker();
      $("[data-mask]").inputmask();

      

   });

   $('#btn_submit').click(function() {
      //generateHeader();
      //        generatePreviewReport();
   });
    
   function generateHeader(){
      var data = $("#infra-inventory-form").serialize();
      
      $.ajax({
         type: 'POST',
         url: '<?php echo Yii::app()->createUrl($this->module->id . '/infraInventory/generateHeader'); ?>',
         data: data,
         dataType: "json",
         success: function(data) {
                
            var e = $(".error");
            for (var i = 0; i < e.length; i++) {
               var $element = $(e[i]);

               $element.data("title", "")
               .removeClass("error")
               .tooltip("destroy");
            }

            if (data.success === false) {
               document.getElementById("covered_date_title").innerHTML = data['covered_date'];
               $.each(JSON.parse(data.error), function(i, v) {
                  var element = document.getElementById(i);

                  var $element = $(element);
                  $element.data("title", v)
                  .addClass("error")
                  .tooltip();
               });
            } else {
               var str = "cobra";
               $('#infra-inventory_table').dataTable().fnDestroy();
               $('#infra-inventory_table').remove();
               var content = "<table id='infra-inventory_table' class='table table-bordered' style='width:100%;'>";
               //               content +='<tr colspan="10">';
               //               content += '<td>' + str + '</td>';
               //               content +=' </tr></thead>';
               
               content +='<thead><tr>';
               content += '<td>WAREHOUSE</td>';
               $.each(data.row_data, function(i, v) {
                  content += '<td>' + v.col  + '</td>';
               });
               content +=' </tr></thead>';
               content +='<tbody></tbody>'
               content += "</table>";
               
               $('#div_tbl').append(content);
               
               var settings = {
                  "filter": false,
                  "processing": false,
                  "serverSide": false,
                  "bAutoWidth": false
               };

               $('#infra-inventory_table').dataTable().fnDestroy();
               $('#infra-inventory_table').dataTable(settings);
               //               $('#infra-inventory_table').dataTable().fnReloadAjax();
            }

            generatePreviewReport();

         },
         error: function(data) {
            alert("Error occured: Please try again.");
         }
      });
       
   }

   function generatePreviewReport() {

      var data = $("#infra-inventory-form").serialize();
       
      $.ajax({
         type: 'POST',
         url: '<?php echo Yii::app()->createUrl($this->module->id . '/infraInventory/generateInfraReport'); ?>',
         data: data,
         dataType: "json",
         success: function(data) {
                
            var e = $(".error");
            for (var i = 0; i < e.length; i++) {
               var $element = $(e[i]);

               $element.data("title", "")
               .removeClass("error")
               .tooltip("destroy");
            }

            if (data.success === false) {

               $.each(JSON.parse(data.error), function(i, v) {
                  var element = document.getElementById(i);

                  var $element = $(element);
                  $element.data("title", v)
                  .addClass("error")
                  .tooltip();
               });
            } else {

               $("#cover_date_title, #sales_office_ids_hidden").html("");
               $("#cover_date_hidden, #brand_category_hidden, #brand_hidden").val("");

               $("#cover_date_title").html(data.covered_date);
               $("#cover_date_hidden").val(data.hidden_cover_date);
               $("#brand_category_hidden").val(data.hidden_category);
               $("#brand_hidden").val(data.hidden_brand);
               $("#sales_office_ids_hidden").html(data.hidden_warehouse);
                    
               $("#btn_export").show();

               ending_inventory_table.fnDeleteRow();
               $.each(data.row_data, function(i, v) {
                  ending_inventory_table.fnAddData([
                     v.warehouse,
                     v.zone,
                     v.brand_category,
                     v.brand,
                     v.mm_code,
                     v.mm_description,
                     v.mm_category,
                     v.mm_sub_category,
                     v.qty,
                     v.price,
                     v.uom,
                     v.total
                  ]);
               });
            }



            //                    document.getElementById("labels").innerHTML = data['covered_date'];
            //                    document.getElementById("txtso").innerHTML = data['hidden_warehouse'];
            //                    document.getElementById("txtcategory").innerHTML = data['hidden_category'];
            //                    document.getElementById("txtbrand").innerHTML = data['hidden_brand'];
            //                    document.getElementById("txtdate").innerHTML = data['date'];
         },
         error: function(data) {
            alert("Error occured: Please try again.");
         }
      });
   }

</script>