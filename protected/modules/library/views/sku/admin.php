<?php
$this->breadcrumbs=array(
	'Skus'=>array('admin'),
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

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create',array('Sku/create'),array('class'=>'btn btn-primary btn-flat')); ?>

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

<?php $fields = Sku::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="sku_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['sku_id']; ?></th>
<th><?php echo $fields['sku_code']; ?></th>
<th><?php echo $fields['brand_id']; ?></th>
<th><?php echo $fields['sku_name']; ?></th>
<th><?php echo $fields['description']; ?></th>
<th><?php echo $fields['default_uom_id']; ?></th>
<th><?php echo $fields['default_unit_price']; ?></th>
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
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/Sku/data');?>",
        "columns": [
            { "name": "sku_id","data": "sku_id"},{ "name": "sku_code","data": "sku_code"},{ "name": "brand_id","data": "brand_id"},{ "name": "sku_name","data": "sku_name"},{ "name": "description","data": "description"},{ "name": "default_uom_id","data": "default_uom_id"},{ "name": "default_unit_price","data": "default_unit_price"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "sku_id": $("#Sku_sku_id").val(),"sku_code": $("#Sku_sku_code").val(),"brand_id": $("#Sku_brand_id").val(),"sku_name": $("#Sku_sku_name").val(),"description": $("#Sku_description").val(),"default_uom_id": $("#Sku_default_uom_id").val(),"default_unit_price": $("#Sku_default_unit_price").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#sku_table a.delete',function() {
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