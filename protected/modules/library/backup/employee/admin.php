<?php
$this->breadcrumbs = array(
    'Employees' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('employee-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Employee/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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

<?php $fields = Employee::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="employee_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['employee_id']; ?></th>-->
                <th><?php echo $fields['employee_code']; ?></th>
                <th><?php echo $fields['employee_status']; ?></th>
                <th><?php echo $fields['employee_type']; ?></th>
                <th><?php echo $fields['default_zone_id']; ?></th>
                <th><?php echo $fields['sales_office_id']; ?></th>
                <th><?php echo $fields['first_name']; ?></th>
                <th><?php echo $fields['middle_name']; ?></th>
                <th><?php echo $fields['last_name']; ?></th>
                <th>Actions</th>                
            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#employee_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Employee/data'); ?>",
            "columns": [
//                {"name": "employee_id", "data": "employee_id"},
                {"name": "employee_code", "data": "employee_code"},
                {"name": "employee_status_code", "data": "employee_status_code"},
                {"name": "employee_type_code", "data": "employee_type_code"},
                {"name": "default_zone_name", "data": "default_zone_name"},
                {"name": "sales_office_name", "data": "sales_office_name"},
                {"name": "first_name", "data": "first_name"},
                {"name": "middle_name", "data": "middle_name"},
                {"name": "last_name", "data": "last_name"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
//                "employee_id": $("#Employee_employee_id").val(),
                "employee_code": $("#Employee_employee_code").val(),
                "employee_status": $("#Employee_employee_status").val(),
                "employee_type": $("#Employee_employee_type").val(),
                "default_zone_id": $("#Employee_default_zone_id").val(),
                "sales_office_id": $("#Employee_sales_office_id").val(),
                "first_name": $("#Employee_first_name").val(),
            });
        });

        jQuery(document).on('click', '#employee_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    $.growl(data, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'success'
                    });

                    table.fnMultiFilter();
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });
    });
</script>