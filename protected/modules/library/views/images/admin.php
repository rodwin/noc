<?php
$this->breadcrumbs = array(
    'Images' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('images-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Upload', array('Images/upload'), array('class' => 'btn btn-primary btn-flat')); ?>

<div class="btn-group">
   <button type="button" class="btn btn-info btn-flat">More Options</button>
   <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
   </button>
   <ul class="dropdown-menu" role="menu">
      <li><a href="#">Download All Records</a></li>
      <li><a href="#">Download All Filtered Records</a></li>
      <!--<li><a href="#">Upload</a></li>-->
   </ul>
</div><br/><br/>

<div class="search-form" style="display:none">
   <?php
   $this->renderPartial('_search', array(
       'model' => $model,
   ));
   ?>
</div><!-- search-form -->

<?php $fields = Images::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
   <table id="images_table" class="table table-bordered">
      <thead>
         <tr>
            <th><?php echo $fields['image_id']; ?></th>
            <th><?php echo $fields['file_name']; ?></th>
            <!--<th><?php echo $fields['url']; ?></th>-->
            <th><?php echo $fields['created_date']; ?></th>
            <th><?php echo $fields['created_by']; ?></th>
            <!--<th><?php echo $fields['updated_date']; ?></th>-->
            <!--<th><?php echo $fields['updated_by']; ?></th>-->
            <th>Actions</th>
         </tr>
      </thead>
   </table>
</div>

<script type="text/javascript">
   $(function() {
      var table = $('#images_table').dataTable({
         "filter": false,
         "processing": true,
         "serverSide": true,
         "bAutoWidth": false,
         "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Images/data'); ?>",
         "columns": [
            {"name": "image", "data": "image", 'sortable': false},
            {"name": "file_name", "data": "file_name"},
            //                {"name": "url", "data": "url"},
            {"name": "created_date", "data": "created_date"},
            {"name": "created_by", "data": "created_by"},
            //                {"name": "updated_date", "data": "updated_date"},
            //                {"name": "updated_by", "data": "updated_by"},
            {"name": "links", "data": "links", 'sortable': false}
         ]
      });

      $('#btnSearch').click(function() {
         table.fnMultiFilter({
            //                "image_id": $("#Images_image_id").val(),
            "file_name": $("#Images_file_name").val(),
            //                "url": $("#Images_url").val(),
            "created_date": $("#Images_created_date").val(),
            "created_by": $("#Images_created_by").val(),
            //                "updated_date": $("#Images_updated_date").val(),
            //                "updated_by": $("#Images_updated_by").val(),
         });
      });



      jQuery(document).on('click', '#images_table a.delete', function() {
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