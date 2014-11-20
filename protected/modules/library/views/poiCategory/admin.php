<?php
$this->breadcrumbs = array(
    Poi::POI_LABEL . ' Categories' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('poi-category-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('PoiCategory/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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

<?php $fields = PoiCategory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
   <table id="poi-category_table" class="table table-bordered">
      <thead>
         <tr>
             <!--<th><?php echo $fields['poi_category_id']; ?></th>-->
            <th><?php echo $fields['category_name']; ?></th>
            <th><?php echo $fields['created_date']; ?></th>
            <th><?php echo $fields['created_by']; ?></th>
            <th><?php echo $fields['updated_date']; ?></th>
            <th><?php echo $fields['updated_by']; ?></th>
            <th>Actions</th>

         </tr>
      </thead>

   </table>
</div>

<script type="text/javascript">
   $(function() {
      var table = $('#poi-category_table').dataTable({
         "filter": false,
         "processing": true,
         "serverSide": true,
         "bAutoWidth": false,
         "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/PoiCategory/data'); ?>",
         "columns": [
            //                { "name": "poi_category_id","data": "poi_category_id"},
            {"name": "category_name", "data": "category_name"}, {"name": "created_date", "data": "created_date"}, {"name": "created_by", "data": "created_by"}, {"name": "updated_date", "data": "updated_date"}, {"name": "updated_by", "data": "updated_by"}, {"name": "links", "data": "links", 'sortable': false}
         ]
      });

      $('#btnSearch').click(function() {
         table.fnMultiFilter({
            //                "poi_category_id": $("#PoiCategory_poi_category_id").val(),
            "category_name": $("#PoiCategory_category_name").val(), "created_date": $("#PoiCategory_created_date").val(), "created_by": $("#PoiCategory_created_by").val(), "updated_date": $("#PoiCategory_updated_date").val(), "updated_by": $("#PoiCategory_updated_by").val(), });
      });



      jQuery(document).on('click', '#poi-category_table a.delete', function() {
         if (!confirm('Are you sure you want to delete this item?'))
            return false;
         $.ajax({
            'url': jQuery(this).attr('href') + '&ajax=1',
            'type': 'POST',
            'dataType': 'text',
            'success': function(data) {
               if (data == "1451") {
                  $.growl("Unable to deleted", {
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