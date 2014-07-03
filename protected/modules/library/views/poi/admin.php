<?php
$this->breadcrumbs=array(
	'Pois'=>array('admin'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('poi-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create',array('Poi/create'),array('class'=>'btn btn-primary btn-flat')); ?>

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

<?php $fields = Poi::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="poi_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['poi_id']; ?></th>
<th><?php echo $fields['short_name']; ?></th>
<th><?php echo $fields['long_name']; ?></th>
<th><?php echo $fields['primary_code']; ?></th>
<th><?php echo $fields['secondary_code']; ?></th>
<th><?php echo $fields['barangay_id']; ?></th>
<th><?php echo $fields['municipal_id']; ?></th>
                <th>Actions</th>
                
            </tr>
        </thead>
        
        </table>
</div>

<script type="text/javascript">
$(function() {
    var table = $('#poi_table').dataTable({
        "filter": false,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/Poi/data');?>",
        "columns": [
            { "name": "poi_id","data": "poi_id"},{ "name": "short_name","data": "short_name"},{ "name": "long_name","data": "long_name"},{ "name": "primary_code","data": "primary_code"},{ "name": "secondary_code","data": "secondary_code"},{ "name": "barangay_id","data": "barangay_id"},{ "name": "municipal_id","data": "municipal_id"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "poi_id": $("#Poi_poi_id").val(),"short_name": $("#Poi_short_name").val(),"long_name": $("#Poi_long_name").val(),"primary_code": $("#Poi_primary_code").val(),"secondary_code": $("#Poi_secondary_code").val(),"barangay_id": $("#Poi_barangay_id").val(),"municipal_id": $("#Poi_municipal_id").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#poi_table a.delete',function() {
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