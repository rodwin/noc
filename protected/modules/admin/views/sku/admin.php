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

<?php echo CHtml::link('<i class="fa fa-search"> Advanced Search</i>','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('<i class="fa fa-plus"> Create</i>',array('sku/create'),array('class'=>'btn btn-primary btn-flat')); ?>


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
                <th><?php echo $fields['code']; ?></th>
<th><?php echo $fields['brand_code']; ?></th>
<th><?php echo $fields['name']; ?></th>
<th><?php echo $fields['description']; ?></th>
<th><?php echo $fields['uom']; ?></th>
<th><?php echo $fields['unit_price']; ?></th>
<th><?php echo $fields['type']; ?></th>
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
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/sku/data');?>",
        "columns": [
            { "name": "code","data": "code"},{ "name": "brand_code","data": "brand_code"},{ "name": "name","data": "name"},{ "name": "description","data": "description"},{ "name": "uom","data": "uom"},{ "name": "unit_price","data": "unit_price"},{ "name": "type","data": "type"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "code": $("#Sku_code").val(),"brand_code": $("#Sku_brand_code").val(),"name": $("#Sku_name").val(),"description": $("#Sku_description").val(),"uom": $("#Sku_uom").val(),"unit_price": $("#Sku_unit_price").val(),"type": $("#Sku_type").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#sku_table a.delete',function() {
            if(!confirm('Are you sure you want to delete this item?')) return false;
            $.ajax({
                'url':jQuery(this).attr('href')+'&ajax=1',
                'type':'POST',
                'dataType': 'text',
                'success':function(data) {
                   $.growl( { 
                        icon: 'glyphicon glyphicon-info-sign', 
                        message: data 
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