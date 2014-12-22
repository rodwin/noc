<?php
$this->breadcrumbs = array(
    'Inventories' => array('admin'),
    $model->inventory_id,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'qty',
            'sku.sku_code',
            'sku.sku_name',
            'zone.zone_name',
            'skuStatus.status_name',
            'expiration_date',
            'reference_no',
        ),
    ));
    ?>
    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table id="inventory_history_table" class="table table-hover">
                <thead>
                    <tr>
                        <th><?php echo $headers['created_date']; ?></th>
                        <th><?php echo $headers['quantity_change']; ?></th>
                        <th><?php echo $headers['running_total']; ?></th>
                        <th><?php echo $headers['action']; ?></th>
                        <th><?php echo $headers['transaction_date']; ?></th>
                        <th><?php echo $headers['destination_zone_id']; ?></th>
                        <th><?php echo $headers['created_by']; ?></th>
                        <th><?php echo $headers['cost_unit']; ?></th>
                        <th><?php echo $headers['ave_cost_per_unit']; ?></th>
                        <th><?php echo $headers['remarks']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $key => $value) { ?>
                        <tr>
                            <td><?php echo $value->created_date; ?></td>
                            <td><?php echo $value->quantity_change; ?></td>
                            <td><?php echo $value->running_total; ?></td>
                            <td><?php echo $value->action; ?></td>
                            <td><?php echo $value->transaction_date; ?></td>
                            <td><?php echo isset($value->zone->zone_name) ? $value->zone->zone_name : null; ?></td>
                            <td><?php echo $value->created_by; ?></td>
                            <td><?php echo $value->cost_unit; ?></td>
                            <td><?php echo $value->ave_cost_per_unit; ?></td>
                            <td><?php echo $value->remarks; ?></td>
                        </tr>  
                    <?php } ?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>
</div>

<script type="text/javascript">

    $(function() {
        $('#inventory_history_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false
        });
    });

</script>

