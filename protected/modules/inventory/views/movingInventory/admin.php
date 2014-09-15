<?php
$this->breadcrumbs = array(
    'Moved Inventories' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('moving-inventory-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Create', array('MovingInventory/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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

<?php $fields = MovingInventory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="moving-inventory_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['transaction_date']; ?></th>
                <th><?php echo $fields['total_amount']; ?></th>
            </tr>
        </thead>
        <thead>
            <tr id="filter_row">
                <td class="filter"></td>
                <td class="filter"></td>
            </tr>
        </thead>
    </table>
</div><br/><br/><br/>

<h4 class="control-label text-primary"><b>Item Details Table</b></h4>
<?php $skuFields = Sku::model()->attributeLabels(); ?>
<?php $movingInvFields = MovingInventoryDetail::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="incoming-inventory-details_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $movingInvFields['batch_no']; ?></th>
                <th><?php echo $skuFields['sku_code']; ?></th>
                <th><?php echo $skuFields['sku_name']; ?></th>
                <th><?php echo $skuFields['brand_id']; ?></th>
                <th><?php echo $movingInvFields['source_zone_id']; ?></th>
                <th><?php echo $movingInvFields['destination_zone_id']; ?></th>
                <th><?php echo $movingInvFields['unit_price']; ?></th>
                <th><?php echo $movingInvFields['quantity']; ?></th>
                <th><?php echo $movingInvFields['amount']; ?></th>
            </tr>
        </thead>
        <thead>
            <tr id="filter_row">
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter"></td>
            </tr>
        </thead>
    </table>
</div>

<script type="text/javascript">
    
    var moving_table;
    $(function() {
        moving_table = $('#moving-inventory_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "order": [[0, "desc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/MovingInventory/data'); ?>",
            "columns": [
                {"name": "transaction_date", "data": "transaction_date"},
                {"name": "total_amount", "data": "total_amount"}
            ]
        });

        $('#moving-inventory_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadMovingInvDetails(null);
            }
            else {
                moving_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = moving_table.fnGetData(this);
                console.log(row_data);
                loadMovingInvDetails(row_data.incoming_inventory_id);
            }
        });

        var i = 0;
        $('#moving-inventory_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#moving-inventory_table thead input").keyup(function() {
            moving_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
                "moving_inventory_id": $("#MovingInventory_moving_inventory_id").val(), "campaign_no": $("#MovingInventory_campaign_no").val(), "pr_no": $("#MovingInventory_pr_no").val(), "pr_date": $("#MovingInventory_pr_date").val(), "plan_delivery_date": $("#MovingInventory_plan_delivery_date").val(), "revised_delivery_date": $("#MovingInventory_revised_delivery_date").val(), "actual_delivery_date": $("#MovingInventory_actual_delivery_date").val(), });
        });



        jQuery(document).on('click', '#moving-inventory_table a.delete', function() {
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