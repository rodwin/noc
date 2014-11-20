<?php
$this->breadcrumbs=array(
	'Employee Statuses'=>array('admin'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('employee-status-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create',array('EmployeeStatus/create'),array('class'=>'btn btn-primary btn-flat')); ?>

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

<?php $fields = EmployeeStatus::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="employee-status_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['employee_status_id']; ?></th>
<th><?php echo $fields['employee_status_code']; ?></th>
<th><?php echo $fields['description']; ?></th>
<th><?php echo $fields['available']; ?></th>
<th><?php echo $fields['created_date']; ?></th>
<th><?php echo $fields['created_by']; ?></th>
<th><?php echo $fields['updated_date']; ?></th>
                <th>Actions</th>
                
            </tr>
        </thead>
        
        </table>
</div>

<script type="text/javascript">
$(function() {
    var table = $('#employee-status_table').dataTable({
        "filter": false,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/EmployeeStatus/data');?>",
        "columns": [
            { "name": "employee_status_id","data": "employee_status_id"},{ "name": "employee_status_code","data": "employee_status_code"},{ "name": "description","data": "description"},{ "name": "available","data": "available"},{ "name": "created_date","data": "created_date"},{ "name": "created_by","data": "created_by"},{ "name": "updated_date","data": "updated_date"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "employee_status_id": $("#EmployeeStatus_employee_status_id").val(),"employee_status_code": $("#EmployeeStatus_employee_status_code").val(),"description": $("#EmployeeStatus_description").val(),"available": $("#EmployeeStatus_available").val(),"created_date": $("#EmployeeStatus_created_date").val(),"created_by": $("#EmployeeStatus_created_by").val(),"updated_date": $("#EmployeeStatus_updated_date").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#employee-status_table a.delete',function() {
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
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });  
            return false;
        });
    });
</script>