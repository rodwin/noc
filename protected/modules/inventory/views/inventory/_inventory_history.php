<div class="box">
    <div class="box-header">
        <h3 class="box-title">Recently Created Records</h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        <?php $fields = Inventory::model()->attributeLabels(); ?>
        <?php $skuFields = Sku::model()->attributeLabels(); ?>
        <table class="table">
            <tr>
                <th><?php echo $skuFields['sku_code']; ?></th>
                <th><?php echo $fields['qty']; ?></th>
                <th>UOM Name</th>
                <th>Zone Name</th>
                <th>Status</th>
                <th><?php echo $fields['reference_no']; ?></th>
            </tr>
            <?php foreach ($recentlyCreatedItems as $key => $value) { ?>
                <tr>
                    <td><?php echo $value->sku->sku_code; ?></td>
                    <td><?php echo $value->qty; ?></td>
                    <td><?php echo $value->uom->uom_name; ?></td>
                    <td><?php echo $value->zone->zone_name; ?></td>
                    <td><?php echo isset($value->skuStatus->status_name) ? $value->skuStatus->status_name : ''; ?></td>
                    <td><?php echo $value->reference_no; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div><!-- /.box-body -->
</div>