<?php
$this->breadcrumbs = array(
    'Salesmen' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('salesman-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Salesman/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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
        'sales_office' => $sales_office,
    ));
    ?>
</div><!-- search-form -->

<?php $fields = Salesman::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="salesman_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['salesman_id']; ?></th>-->
                <th><?php echo $fields['team_leader_id']; ?></th>
                <th><?php echo $fields['salesman_name']; ?></th>
                <th><?php echo $fields['salesman_code']; ?></th>
                <th><?php echo $fields['sales_office_id']; ?></th>
                <th><?php echo $fields['zone_id']; ?></th>
                <th><?php echo $fields['mobile_number']; ?></th>
                <th><?php echo $fields['device_no']; ?></th>
                <th><?php echo $fields['other_fields_1']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#salesman_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Salesman/data'); ?>",
            "columns": [
//                 "name": "salesman_id","data": "salesman_id"},
                {"name": "team_leader_id", "data": "team_leader_id"},
                {"name": "salesman_name", "data": "salesman_name"},
                {"name": "salesman_code", "data": "salesman_code"},
                {"name": "sales_office_name", "data": "sales_office_name"},
                {"name": "zone_name", "data": "zone_name"},
                {"name": "mobile_number", "data": "mobile_number"},
                {"name": "device_no", "data": "device_no"},
                {"name": "other_fields_1", "data": "other_fields_1"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
//                "salesman_id": $("#Salesman_salesman_id").val(),
                "team_leader_id": $("#Salesman_team_leader_id").val(),
                "salesman_name": $("#Salesman_salesman_name").val(),
                "salesman_code": $("#Salesman_salesman_code").val(),
                "sales_office_name": $("#Salesman_sales_office_name").val(),
                "mobile_number": $("#Salesman_mobile_number").val(),
                "device_no": $("#Salesman_device_no").val(),
                "other_fields_1": $("#Salesman_other_fields_1").val(),
            });
        });



        jQuery(document).on('click', '#salesman_table a.delete', function() {
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