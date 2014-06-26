<?php
$this->breadcrumbs=array(
	'Brands'=>array('admin'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('brand-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create',array('brand/create'),array('class'=>'btn btn-primary btn-flat')); ?><br/>
<br/>

<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<div class="box-body table-responsive">
    <table id="brand_table" class="table table-bordered">
        <thead>
            <tr>
                <th>brand_code</th>
<th>brand_name</th>
<th>created_date</th>
<th>created_by</th>
<th>updated_date</th>
<th>updated_by</th>
<th>deleted_date</th>
                <th>Actions</th>
                
            </tr>
        </thead>
        
        </table>
</div>

<script type="text/javascript">
$(function() {
    var table = $('#brand_table').dataTable({
        "filter": false,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/brand/data');?>",
        "columns": [
            { "name": "brand_code","data": "brand_code"},{ "name": "brand_name","data": "brand_name"},{ "name": "created_date","data": "created_date"},{ "name": "created_by","data": "created_by"},{ "name": "updated_date","data": "updated_date"},{ "name": "updated_by","data": "updated_by"},{ "name": "deleted_date","data": "deleted_date"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "brand_code": $("#Brand_brand_code").val(),"brand_name": $("#Brand_brand_name").val(),"created_date": $("#Brand_created_date").val(),"created_by": $("#Brand_created_by").val(),"updated_date": $("#Brand_updated_date").val(),"updated_by": $("#Brand_updated_by").val(),"deleted_date": $("#Brand_deleted_date").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#brand_table a.delete',function() {
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