<?php
$this->breadcrumbs=array(
	'Brand Categories'=>array('admin'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('brand-category-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create',array('BrandCategory/create'),array('class'=>'btn btn-primary btn-flat')); ?>

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
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $fields = BrandCategory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="brand-category_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['category_id']; ?></th>
<th><?php echo $fields['category_name']; ?></th>
<th><?php echo $fields['created_date']; ?></th>
<th><?php echo $fields['created_by']; ?></th>
<th><?php echo $fields['updated_by']; ?></th>
<th><?php echo $fields['updated_date']; ?></th>
                <th>Actions</th>
                
            </tr>
        </thead>
        
        </table>
</div>

<script type="text/javascript">
$(function() {
    var table = $('#brand-category_table').dataTable({
        "filter": false,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/BrandCategory/data');?>",
        "columns": [
            { "name": "category_id","data": "category_id"},{ "name": "category_name","data": "category_name"},{ "name": "created_date","data": "created_date"},{ "name": "created_by","data": "created_by"},{ "name": "updated_by","data": "updated_by"},{ "name": "updated_date","data": "updated_date"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "category_id": $("#BrandCategory_category_id").val(),"category_name": $("#BrandCategory_category_name").val(),"created_date": $("#BrandCategory_created_date").val(),"created_by": $("#BrandCategory_created_by").val(),"updated_by": $("#BrandCategory_updated_by").val(),"updated_date": $("#BrandCategory_updated_date").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#brand-category_table a.delete',function() {
            if(!confirm('Are you sure you want to delete this item?')) return false;
            $.ajax({
                'url':jQuery(this).attr('href')+'&ajax=1',
                'type':'POST',
                'dataType': 'text',
                'success':function(data) {
                   $.growl( data, { 
                        icon: 'glyphicon glyphicon-info-sign', 
                        type: 'success'
                    });
                    
                    table.fnMultiFilter();
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: '+ exception);
                }
            });  
            return false;
        });
    });
</script>