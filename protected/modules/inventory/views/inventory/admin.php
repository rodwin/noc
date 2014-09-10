
<style type="text/css">
   .action_qty { width: 50px; }

   .popModal .popModal_content.popModal_contentOverflow { max-height:250px; }

   #myModal .modal-body { padding-top: 0!important; padding-bottom: 0!important; }

   .bg-decrease { background-color: #990000; color: #fff; opacity: .8; }
   .text-decrease { color: #990000; }

   .bg-convert { background-color: #CC0099; color: #fff; }
   .text-convert { color: #CC0099; }

   .bg-move { background-color: #CC3300; color: #fff; opacity: .8; }
   .text-move { color: #CC3300; }

   .bg-update_status { background-color: #330099; color: #fff; opacity: .8; }
   .text-update_status { color: #330099; }

   .bg-apply { background-color: #CC9900; color: #fff; opacity: .8; }
   .text-apply { color: #CC9900; }
</style>

<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->baseUrl; ?>/js/datepicker/datepicker.js" type="text/javascript"></script>

<?php
$this->breadcrumbs = array(
    'Inventories' => array('admin'),
    'Manage',
);

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/popModal.min.js', CClientScript::POS_END);
$cs->registerCssFile($baseUrl . '/css/popModal.min.css');
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/handlebars-v1.3.0.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/typeahead.bundle.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('inventory-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Inventory/create'), array('class' => 'btn btn-primary btn-flat')); ?>

<div class="btn-group">
   <button type="button" class="btn btn-info btn-flat">More Options</button>
   <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
   </button>
   <ul class="dropdown-menu" role="menu">
      <li><a href="#">Download All Records</a></li>
      <li><a href="#">Download All Filtered Records</a></li>
      <li><a href="#">Upload</a></li>
   </ul>
</div>

<br/>
<br/>

<div class="search-form" style="display:none">
   <?php
   $this->renderPartial('_search', array(
       'model' => $model,
   ));
   ?>
</div><!-- search-form -->

<?php $fields = Inventory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
   <table id="inventory_table" class="table table-bordered">
      <thead>

<!--            <tr>
                <th><input type="text" class="form-control input-sm" id="Inv_sku_code" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_sku_name" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_qty" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_uom_name" placeholder="" name=""></th>
                <th></th>
                <th><input type="text" class="form-control input-sm" id="Inv_zone_name" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_sku_status_name" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_expiration_date" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_reference_no" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_brand_name" placeholder="" name=""></th>
                <th><input type="text" class="form-control input-sm" id="Inv_sales_office_name" placeholder="" name=""></th>
                <th><button type="button" id="btn_search" class="btn btn-default btn-flat">Search</button></th>
            </tr>-->

         <tr>
            <th><?php echo $fields['sku_code']; ?></th>
            <th><?php echo $fields['sku_name']; ?></th>
            <th><?php echo $fields['qty']; ?></th>
            <th><?php echo $fields['uom_id']; ?></th>
            <th>Action Qty <span title="Type a numeric value into a row's field below to see a list of Transaction options." data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
            <th><?php echo $fields['zone_id']; ?></th>
            <th><?php echo $fields['sku_status_id']; ?></th>
            <th><?php echo $fields['expiration_date']; ?></th>
            <th><?php echo $fields['reference_no']; ?></th>
            <th><?php echo $fields['brand_name']; ?></th>
            <th><?php echo $fields['sales_office_name']; ?></th>
            <th>Actions</th>
         </tr>
      </thead>

      <thead>
         <tr id="filter_row">
            <td class="filter"></td>
            <td class="filter"></td>
            <td class="filter"></td>
            <td class="filter"></td>
            <td class="filter" style="visibility: hidden" disabled="disabled"></td>
            <td class="filter"></td>
            <td class="filter"></td>
            <td class="filter"></td>
            <td class="filter"></td>
            
         </tr>
      </thead>

   </table>
</div>

<div style="display:none">
   <div id="content">
      <div class="box-body">

         <a class="btn btn-block btn-social btn-sm btn-default btn-flat" onclick="LoadModal('1')">
            <i class="fa fa-fw fa-plus"></i>&nbsp; Increase
         </a>
         <a class="btn btn-block btn-social btn-sm btn-default btn-flat" onclick="LoadModal('2')">
            <i class="fa fa-fw fa-minus"></i>&nbsp; Decrease
         </a>
         <a class="btn btn-block btn-social btn-sm btn-default btn-flat" onclick="LoadModal('3')">
            <i class="fa fa-fw fa-random"></i>&nbsp; Convert Unit of Measure
         </a>
         <a class="btn btn-block btn-social btn-sm btn-default btn-flat" onclick="LoadModal('4')">
            <i class="fa fa-fw fa-exchange"></i>&nbsp; Move Items
         </a>
         <a class="btn btn-social btn-block btn-sm btn-default btn-flat" onclick="LoadModal('5')">
            <i class="fa fa-fw fa-retweet"></i>&nbsp; Update Status
         </a>
         <a class="btn btn-social btn-block btn-sm btn-default btn-flat" onclick="LoadModal('6')">
            <i class="fa fa-fw fa-tag"></i>&nbsp; Apply
         </a>

         <div class="popModal_footer no-padding" style="padding: 5px!important;">
            <button type="button" data-popModalBut="cancel" class="btn btn-default btn-sm">cancel</button>
         </div>
      </div>
   </div>
</div>

<!------------Modal------------>
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div id="transactionDialogContainer"></div>
</div>

<script type="text/javascript">

   var inventory_id = null;
   var loaded = false;
   var table;
   $(function() {

      table = $('#inventory_table').dataTable({
         "filter": true,
         "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
         "processing": true,
         "serverSide": true,
         "bAutoWidth": false,
         "order": [[0, "asc"]],
         "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Inventory/data'); ?>",
         "columns": [
            {"name": "sku_code", "data": "sku_code"},
            {"name": "sku_name", "data": "sku_name"},
            {"name": "qty", "data": "qty"},
            {"name": "uom_name", "data": "uom_name"},
            {"name": "action_qty", "data": "action_qty", 'sortable': false, "class": 'action_qty'},
            {"name": "zone_name", "data": "zone_name"},
            {"name": "sku_status_name", "data": "sku_status_name"},
            {"name": "expiration_date", "data": "expiration_date"},
            {"name": "reference_no", "data": "reference_no"},
            {"name": "brand_name", "data": "brand_name"},
            {"name": "sales_office_name", "data": "sales_office_name"},
            {"name": "links", "data": "links", 'sortable': false}
         ]
      });

      var i = 0;
      $('#inventory_table thead tr#filter_row td.filter').each(function() {
         $(this).html('<input type="text" class="form-control input-sm" onclick="" placeholder="" colPos="' + i + '" />');
         i++;
      });
      $("#inventory_table thead input").keyup(function() {
         table.fnFilter(this.value, $(this).attr("colPos"));
      });
      transaction_table = $('#transaction_table').dataTable({
         "filter": false,
         "dom": 't',
         "bSort": false,
         "processing": false,
         "serverSide": false,
         "bAutoWidth": false
      });

      function searchTable() {
         table.fnMultiFilter({
            "sku_code": $("#Inv_sku_code").val(),
            "sku_name": $("#Inv_sku_name").val(),
            "qty": $("#Inv_qty").val(),
            "uom_name": $("#Inv_uom_name").val(),
            "zone_name": $("#Inv_zone_name").val(),
            "sku_status_name": $("#Inv_sku_status_name").val(),
            "expiration_date": $("#Inv_expiration_date").val(),
            "reference_no": $("#Inv_reference_no").val(),
            "brand_name": $("#Inv_brand_name").val(),
            "sales_office_name": $("#Inv_sales_office_name").val()
         });
      }

      $('#btn_search').click(function() {
         searchTable();
      });

      // Triggers the Click Event and Shows the Overlay Menu if the Input receives a digital or decimal value.
      $('table#inventory_table tbody').on('keypress', 'td.action_qty input', function(e) {

         if (fnIsQtyKeyOkay(e)) {
            if ((e.which >= 48 && e.which <= 57) || e.which == 46) {

               /*
                * TODO:
                * show context menu to increase, decrease,move, convert, apply
                */
               if (loaded === false) {

                  inventory_id = $(this).attr("data-id");
                  popModal_id =
                     $(this).popModal({
                     html: $('#content'),
                     placement: 'bottomLeft',
                     showCloseBut: false,
                     onDocumentClickClose: true,
                     onOkBut: function() {
                     },
                     onCancelBut: function() {
                     },
                     onLoad: function() {
                        loaded = true;
                     },
                     onClose: function() {
                        loaded = false;
                     }
                  });
               }
            }
         } else {
            e.preventDefault();
         }
      });

      jQuery(document).on('click', '#inventory_table a.delete', function() {
         if (!confirm('Are you sure you want to delete this item?'))
            return false;
         $.ajax({
            'url': jQuery(this).attr('href') + '&ajax=1',
            'type': 'POST',
            'dataType': 'text',
            'success': function(data) {
               if (data == "1451") {
                  $.growl("Unable to delete", {
                     icon: 'glyphicon glyphicon-warning-sign',
                     type: 'danger'
                  });
               } else {
                  $.growl(data, {
                     icon: 'glyphicon glyphicon-info-sign',
                     type: 'success'
                  });
               }

               table.fnMultiFilter();
            },
            error: function(jqXHR, exception) {
               alert('An error occured: ' + exception);
            }
         });
         return false;
      });

   });

   function LoadModal(val) {

      //        $('html').popModal("hide");

      var qty = $('#action_qty_' + inventory_id).val();

      $.ajax({
         data: {
            inventory_id: inventory_id,
            transaction_type: val,
            qty: qty
         },
         type: "get",
         dataType: "json",
         success: function(data) {
            $('#transactionDialogContainer').html(data);
            $('#myModal').modal('show');
            $('#action_qty_' + inventory_id).popModal("hide");
         },
         url: '<?php echo Yii::app()->createUrl($this->module->id . '/Inventory/Trans'); ?>',
         error: function(jqXHR, exception) {
            alert('connection error')
         }
      });

   }

</script>
