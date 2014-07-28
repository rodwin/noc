
<h4 class="control-label text-primary"><b>Recently Created Records</b></h4>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('inventory-history-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php $fields = InventoryHistory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="inventory-history_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['inventory_history_id']; ?></th>-->
                <th><?php echo $fields['inventory_id']; ?></th>
                <th><?php echo $fields['quantity_change']; ?></th>
                <th><?php echo $fields['running_total']; ?></th>
                <th><?php echo $fields['action']; ?></th>
                <th><?php echo $fields['cost_unit']; ?></th>
                <th><?php echo $fields['ave_cost_per_unit']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#inventory-history_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/InventoryHistory/data'); ?>",
            "columns": [
//                {"name": "inventory_history_id", "data": "inventory_history_id"}, 
                {"name": "inventory_id", "data": "inventory_id"}, {"name": "quantity_change", "data": "quantity_change"}, {"name": "running_total", "data": "running_total"}, {"name": "action", "data": "action"}, {"name": "cost_unit", "data": "cost_unit"}, {"name": "ave_cost_per_unit", "data": "ave_cost_per_unit"}, {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
//                "inventory_history_id": $("#InventoryHistory_inventory_history_id").val(), 
                "inventory_id": $("#InventoryHistory_inventory_id").val(), "quantity_change": $("#InventoryHistory_quantity_change").val(), "running_total": $("#InventoryHistory_running_total").val(), "action": $("#InventoryHistory_action").val(), "cost_unit": $("#InventoryHistory_cost_unit").val(), "ave_cost_per_unit": $("#InventoryHistory_ave_cost_per_unit").val(), });
        });



        jQuery(document).on('click', '#inventory-history_table a.delete', function() {
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