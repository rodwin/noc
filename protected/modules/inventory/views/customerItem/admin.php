<?php
$this->breadcrumbs = array(
    CustomerItem::CUSTOMER_ITEM_LABEL . ' Inventories' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('customer-item-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>
<?php echo CHtml::link('Create', array('CustomerItem/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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
</div>
<br/>
<br/>

<?php $fields = CustomerItem::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="customer-item_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['customer_item_id']; ?></th>
                <th><?php echo $fields['rra_no']; ?></th>
                <th><?php echo $fields['pr_no']; ?></th>
                <th><?php echo $fields['dr_no']; ?></th>
                <th><?php echo $fields['source_zone_id']; ?></th>
                <th><?php echo $fields['poi_id']; ?></th>
                <th><?php echo $fields['transaction_date']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#customer-item_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/CustomerItem/data'); ?>",
            "columns": [
                {"name": "customer_item_id", "data": "customer_item_id"},
                {"name": "rra_no", "data": "rra_no"},
                {"name": "pr_no", "data": "pr_no"},
                {"name": "dr_no", "data": "dr_no"},
                {"name": "source_zone_id", "data": "source_zone_id"},
                {"name": "poi_id", "data": "poi_id"},
                {"name": "transaction_date", "data": "transaction_date"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
                "customer_item_id": $("#CustomerItem_customer_item_id").val(), "name": $("#CustomerItem_name").val(), "pr_no": $("#CustomerItem_pr_no").val(), "dr_no": $("#CustomerItem_dr_no").val(), "source_zone_id": $("#CustomerItem_source_zone_id").val(), "poi_id": $("#CustomerItem_poi_id").val(), "transaction_date": $("#CustomerItem_transaction_date").val(), });
        });



        jQuery(document).on('click', '#customer-item_table a.delete', function() {
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