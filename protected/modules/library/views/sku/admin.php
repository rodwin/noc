<?php
$this->breadcrumbs = array(
    Sku::SKU_LABEL => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sku-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Sku/create'), array('class' => 'btn btn-primary btn-flat')); ?>

<div class="btn-group">
   <button type="button" class="btn btn-info btn-flat">More Options</button>
   <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
   </button>
   <ul class="dropdown-menu" role="menu">
      <li><a href="#">Download All Records</a></li>
      <li><a href="#">Download All Filtered Records</a></li>
      <li><a href="<?php echo Yii::app()->createUrl($this->module->id . '/sku/upload'); ?>">Upload</a></li>
   </ul>
</div>

<br/>
<br/>

<div class="search-form" style="display:none">
   <?php
   $this->renderPartial('_search', array(
       'model' => $model,
       'brand' => $brand,
       'uom' => $uom,
       'zone' => $zone,
       'sku_category' => $sku_category,
       'infra_sub_category' => $infra_sub_category,
   ));
   ?>
</div><!-- search-form -->

<?php $fields = Sku::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
   <table id="sku_table" class="table table-bordered">
      <thead>
         <tr>
            <th><?php echo $fields['sku_code']; ?></th>
            <th><?php echo $fields['sku_name']; ?></th>
            <th><?php echo $fields['description']; ?></th>
            <th><?php echo $fields['brand_id']; ?></th>
            <th>Brand Category</th>
            <th><?php echo $fields['type']; ?></th>
            <th><?php echo $fields['sub_type']; ?></th>
            <th><?php echo $fields['default_uom_id']; ?></th>
            <!--<th><?php echo $fields['supplier']; ?></th>-->
            <!--<th><?php echo $fields['default_zone_id']; ?></th>-->
            <th>Actions</th>

         </tr>
      </thead>

   </table>
</div>

<script type="text/javascript">
   $(function() {
      var table = $('#sku_table').dataTable({
         "filter": false,
         "processing": true,
         "serverSide": true,
         "bAutoWidth": false,
         "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Sku/data'); ?>",
         "columns": [
            //                { "name": "sku_id","data": "sku_id"},
            {"name": "sku_code", "data": "sku_code"},
            {"name": "sku_name", "data": "sku_name"},
            {"name": "description", "data": "description"},
            {"name": "brand_name", "data": "brand_name"},
            {"name": "brand_category", "data": "brand_category", 'sortable': false},
            {"name": "type", "data": "type"},
            {"name": "sub_type", "data": "sub_type"},
            {"name": "default_uom_name", "data": "default_uom_name"},
            //                {"name": "supplier", "data": "supplier"},
            //                {"name": "default_zone_name", "data": "default_zone_name"},
            {"name": "links", "data": "links", 'sortable': false}
         ]
      });

      $('#btnSearch').click(function() {
         table.fnMultiFilter({
            //                "sku_id": $("#Sku_sku_id").val(),
            "sku_code": $("#Sku_sku_code").val(),
            "brand_name": $("#Sku_brand_name").val(),
            "sku_name": $("#Sku_sku_name").val(),
            "description": $("#Sku_description").val(),
            "default_uom_name": $("#Sku_default_uom_name").val(),
            "type": $("#Sku_type").val(),
            "sub_type": $("#Sku_sub_type").val(),
            "supplier": $("#Sku_supplier").val(),
            "default_zone_name": $("#Sku_default_zone_name").val(),
         });
      });



      jQuery(document).on('click', '#sku_table a.delete', function() {
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
            error: function(status, exception) {
               alert(status.responseText);
            }
         });
         return false;
      });
   });
</script>