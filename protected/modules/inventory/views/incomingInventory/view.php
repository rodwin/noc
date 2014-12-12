
<?php
$this->breadcrumbs = array(
    IncomingInventory::INCOMING_LABEL . ' Inventories' => array('admin'),
    'View',
);
?>

<style type="text/css">
    .text_bold { font-weight: bold; }

    .margin_bottom_30 { margin-bottom: 30px; }

    #outgoing-inv-detail_table { font-size: 13px; }

    .first_col_left_table { width: 120px; }

    .first_col_right_table { width: 150px; } 

    .text_bold { font-weight: bold; }
</style>

<?php $skuFields = Sku::model()->attributeLabels(); ?>
<?php $incomingFields = IncomingInventory::model()->attributeLabels(); ?>
<?php $incomingDetailFields = IncomingInventoryDetail::model()->attributeLabels(); ?>

<?php $not_set = "<i class='text-muted'>Not Set</i>"; ?>

<div class="row panel panel-default">

    <div class="col-sm-6">

        <h5 class="control-label text-primary text_bold">From</h5>
        <table class="table table-bordered table-condensed">
            <tr>
                <td colspan="2"><strong><?php echo $source['source_zone_name_so_name']; ?></strong></td>
            </tr>
            <tr>
                <td class="first_col_left_table"><strong>Address:</strong></td><td><strong><?php echo $source['address']; ?></strong></td>
            </tr>
            <tr>
                <td><strong>Contact Person:</strong></td><td><strong><?php echo $source['contact_person']; ?></strong></td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td><td><strong><?php echo $source['contact_no']; ?></strong></td>
            </tr>
        </table>

        <h5 class="control-label text-primary text_bold">To</h5>
        <table class="table table-bordered table-condensed">
            <tr>
                <td colspan="2"><strong><?php echo $destination['zone_name']; ?></strong> <i class="text-muted">(<?php echo $destination['destination_sales_office_name']; ?>)</i></td>
            </tr>
            <tr>
                <td class="first_col_left_table"><strong>Address:</strong></td><td><?php echo $destination['address']; ?></td>
            </tr>
            <tr>
                <td><strong>Contact Person:</strong></td><td><?php echo $destination['contact_person']; ?></td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td><td><?php echo $destination['contact_no']; ?></td>
            </tr>
        </table>

    </div>

    <div class="col-sm-6"><br/>
        <table class="table table-bordered table-condensed">
            <tr>
                <td class="first_col_right_table"><strong><?php echo $incomingFields['transaction_date'] ?>:</strong></td>
                <td><?php echo $model->transaction_date; ?></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td class="first_col_right_table"><strong><?php echo $incomingFields['plan_delivery_date'] ?>:</strong></td>
                <td><?php echo $model->plan_delivery_date != "" ? $model->plan_delivery_date : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $incomingDetailFields['pr_no'] ?>:</strong></td>
                <td><?php echo $pr_nos != "" ? $pr_nos : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $incomingDetailFields['po_no'] ?>:</strong></td>
                <td><?php echo $po_nos != "" ? $po_nos : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $incomingFields['rra_no'] ?>:</strong></td>
                <td><?php echo $model->rra_no != "" ? $model->rra_no : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $incomingFields['rra_date'] ?>:</strong></td>
                <td><?php echo $model->rra_date != "" ? $model->rra_date : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $incomingFields['dr_no'] ?>:</strong></td>
                <td><?php echo $model->dr_no; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $incomingFields['dr_date']; ?>:</strong></td>
                <td><?php echo $model->dr_date; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $incomingDetailFields['status'] ?>:</strong></td>
                <td><?php echo Inventory::model()->status($model->status); ?></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td><strong><?php echo $incomingFields['remarks'] ?>:</strong></td>
            </tr>
            <tr>
                <td><?php echo $model->remarks != "" ? $model->remarks : $not_set; ?></td>
            </tr>
        </table>
    </div>

    <br/>

    <div class="col-xs-12">
        <div class="table-responsive">
            <h5 class="control-label text-primary text_bold">Item Details</h5>
            <div  style="overflow-x: scroll;">
                <table id="incoming-inv-detail_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $skuFields['type']; ?></th>
                            <th><?php echo $incomingDetailFields['uom_id']; ?></th>
                            <th><?php echo $incomingDetailFields['unit_price']; ?></th>
                            <th><?php echo $incomingDetailFields['batch_no']; ?></th>
                            <th><?php echo $incomingDetailFields['expiration_date']; ?></th>
                            <th><?php echo $incomingDetailFields['planned_quantity']; ?></th>
                            <th><?php echo $incomingDetailFields['quantity_received']; ?></th>
                            <th><?php echo $incomingDetailFields['amount']; ?></th>
                            <th><?php echo $incomingDetailFields['remarks']; ?></th>
                            <th><?php echo $incomingDetailFields['status']; ?></th>
                        </tr>                                    
                    </thead>
                </table>  
            </div>
        </div><br/>
    </div>

    <div class="col-md12">

        <div class="col-md-6 pull-right">
            <p class="lead big text-right">Total Amount: &nbsp;&nbsp; &#x20B1; <?php echo number_format($model->total_amount, 2, '.', ','); ?></p>
        </div>

        <div class="col-md-6 pull-left">
            <button id="btn_print" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>

</div>

<script type="text/javascript">

    var incoming_inv_detail_table;
    $(function() {

        incoming_inv_detail_table = $('#incoming-inv-detail_table').dataTable({
            "filter": false,
            "dom": 't',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "bSort": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/IncomingInventory/getDetailsByIncomingInvID', array("incoming_inventory_id" => $model->incoming_inventory_id)); ?>",
            "columns": [
                {"name": "sku_code", "data": "sku_code"},
                {"name": "sku_description", "data": "sku_description"},
                {"name": "brand_name", "data": "brand_name"},
                {"name": "sku_category", "data": "sku_category"},
                {"name": "uom_name", "data": "uom_name"},
                {"name": "unit_price", "data": "unit_price"},
                {"name": "batch_no", "data": "batch_no"},
                {"name": "expiration_date", "data": "expiration_date"},
                {"name": "planned_quantity", "data": "planned_quantity"},
                {"name": "quantity_received", "data": "quantity_received"},
                {"name": "amount", "data": "amount"},
                {"name": "remarks", "data": "remarks"},
                {"name": "status", "data": "status"},
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(10)', nRow).addClass("text-right");
            }
        });

    });

    $('#btn_print').click(function() {
        print();
    });

    function print() {

        if ($("#btn_print").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl($this->module->id . '/IncomingInventory/viewPrint', array("incoming_inventory_id" => $model->incoming_inventory_id)); ?>',
                dataType: "json",
                beforeSend: function(data) {
                    $("#btn_print").attr('disabled', true);
                    $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Loading...');
                },
                success: function(data) {
                    if (data.success === true) {
                        var params = [
                            'height=' + screen.height,
                            'width=' + screen.width,
                            'fullscreen=yes'
                        ].join(',');

                        var tab = window.open(<?php echo "'" . Yii::app()->createUrl($this->module->id . '/IncomingInventory/loadPDF') . "'" ?> + "&id=" + data.id, "_blank", params);

                        $("#btn_print").attr('disabled', false);
                        $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');

                        if (tab) {
                            tab.focus();
                            tab.moveTo(0, 0);
                        } else {
                            alert('Please allow popups for this site');
                        }
                    }

                    return false;
                },
                error: function(data) {
                    alert("Error occured: Please try again.");
                    $("#btn_print").attr('disabled', false);
                    $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');
                }
            });
        }

    }

</script>