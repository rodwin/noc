<?php
$this->breadcrumbs = array(
    'Sales Offices' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sales-office-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('SalesOffice/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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
        'model' => $model, 'distributors' => $distributors,
    ));
    ?>
</div><!-- search-form -->

<?php $fields = SalesOffice::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="sales-office_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['sales_office_id']; ?></th>-->
                <th><?php echo $fields['distributor_id']; ?></th>
                <th><?php echo $fields['sales_office_code']; ?></th>
                <th><?php echo $fields['sales_office_name']; ?></th>
                <th><?php echo $fields['address1']; ?></th>
                <th><?php echo $fields['address2']; ?></th>
                <th><?php echo $fields['barangay_id']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#sales-office_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/SalesOffice/data'); ?>",
            "columns": [
//                { "name": "sales_office_id","data": "sales_office_id"},
                {"name": "distributor_name", "data": "distributor_name"}, {"name": "sales_office_code", "data": "sales_office_code"}, {"name": "sales_office_name", "data": "sales_office_name"}, {"name": "address1", "data": "address1"}, {"name": "address2", "data": "address2"}, {"name": "barangay_id", "data": "barangay_id"}, {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
//                "sales_office_id": $("#SalesOffice_sales_office_id").val(),
                "distributor_name": $("#SalesOffice_distributor_name").val(), "sales_office_code": $("#SalesOffice_sales_office_code").val(), "sales_office_name": $("#SalesOffice_sales_office_name").val(), "address1": $("#SalesOffice_address1").val(), "address2": $("#SalesOffice_address2").val(), "barangay_id": $("#SalesOffice_barangay_id").val(), });
        });



        jQuery(document).on('click', '#sales-office_table a.delete', function() {
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