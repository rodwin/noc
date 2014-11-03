
<?php
$this->breadcrumbs = array(
    OutgoingInventory::OUTGOING_LABEL . ' Inventories' => array('admin'),
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
<?php $outgoingFields = OutgoingInventory::model()->attributeLabels(); ?>
<?php $outgoingDetailFields = OutgoingInventoryDetail::model()->attributeLabels(); ?>


<div class="row">

    <div class="col-sm-6">

        <h5 class="control-label text-primary text_bold">From</h5>
        <table class="table table-bordered table-condensed">
            <tr>
                <td colspan="2"><strong class="source_name"><i class="text-muted">Not Set</i></strong></td>
            </tr>
            <tr>
                <td class="first_col_left_table"><strong>Address:</strong></td><td><span class="source_address"></span></td>
            </tr>
            <tr>
                <td><strong>Contact Person:</strong></td><td><span class="source_contact_person"></span></td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td><td><span class="source_contact_no"></span></td>
            </tr>
        </table>

        <h5 class="control-label text-primary text_bold">To</h5>
        <table class="table table-bordered table-condensed">
            <tr>
                <td colspan="2"><strong class="destination_name"></strong> <i class="destination_sales_office_name text-muted"></i></td>
            </tr>
            <tr>
                <td class="first_col_left_table"><strong>Address:</strong></td><td><span class="destination_address"></span></td>
            </tr>
            <tr>
                <td><strong>Contact Person:</strong></td><td><span class="destination_contact_person"></span></td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td><td><span class="destination_contact_no"></span></td>
            </tr>
        </table>

    </div>

    <div class="col-sm-6">
        <table class="table table-bordered table-condensed">
            <tr>
                <td class="first_col_right_table"><strong>Transaction Date:</strong></td>
                <td><span class="transaction_date"></span></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td class="first_col_right_table"><strong>Plan Delivery Date:</strong></td>
                <td><span class="plan_delivery_date"></span></td>
            </tr>
            <tr>
                <td><strong>DR Number:</strong></td>
                <td><span class="dr_no"></span></td>
            </tr>
            <tr>
                <td><strong>DR Date:</strong></td>
                <td><span class="dr_date"></span></td>
            </tr>
            <tr>
                <td><strong>RRA Number:</strong></td>
                <td><span class="rra_no"></span></td>
            </tr>
            <tr>
                <td><strong>RRA Date:</strong></td>
                <td><span class="rra_date"></span></td>
            </tr>
            <tr>
                <td><strong>PR Number(s):</strong></td>
                <td><span class="pr_nos"></span></td>
            </tr>
            <tr>
                <td><strong>Campaign Number(s):</strong></td>
                <td><span class="campaign_nos"></span></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td><span class="transaction_status"></span></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td><strong>Remarks:</strong></td>
            </tr>
            <tr>
                <td><span class="remarks"></span></td>
            </tr>
        </table>
    </div>

    <br/>

    <div class="col-xs-12">
        <div class="table-responsive">
            <h5 class="control-label text-primary text_bold">Item Details</h5>

            <table id="outgoing-inv-detail_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><?php echo $skuFields['sku_code']; ?></th>
                        <th><?php echo $skuFields['description']; ?></th>
                        <th><?php echo $skuFields['brand_id']; ?></th>
                        <th><?php echo $skuFields['type']; ?></th>
                        <th><?php echo $outgoingDetailFields['uom_id']; ?></th>
                        <th><?php echo $outgoingDetailFields['unit_price']; ?></th>
                        <th><?php echo $outgoingDetailFields['batch_no']; ?></th>
                        <th><?php echo $outgoingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $outgoingDetailFields['planned_quantity']; ?></th>
                        <th><?php echo $outgoingDetailFields['quantity_issued']; ?></th>
                        <th><?php echo $outgoingDetailFields['amount']; ?></th>
                        <th><?php echo $outgoingDetailFields['remarks']; ?></th>
                        <th><?php echo $outgoingDetailFields['status']; ?></th>
                    </tr>                                    
                </thead>
            </table>                            
        </div>
    </div>
    
    <div class="clearfix"><br/><br/></div>

    <div class="col-sm-6 pull-right">
        <table class="table table-bordered table-condensed">
            <tr>
                <td class="first_col_right_table"><strong>Total Amount: <span class="pull-right"></span></strong></td>
                <td>&#x20B1; <span class="total_amount"></span></td>
            </tr>
        </table>
    </div>

</div>


<script type="text/javascript">

    var outgoing_inv_detail_table;
    $(function() {

        outgoing_inv_detail_table = $('#outgoing-inv-detail_table').dataTable({
            "filter": false,
            "dom": 't',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "bSort": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/OutgoingInventory/getDetailsByOutgoingInvID', array("outgoing_inv_id" => $model->outgoing_inventory_id)); ?>",
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
                {"name": "quantity_issued", "data": "quantity_issued"},
                {"name": "amount", "data": "amount"},
                {"name": "remarks", "data": "remarks"},
                {"name": "status", "data": "status"},
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(10)', nRow).addClass("text-right");
            }
        });

        $.ajax({
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/OutgoingInventory/getTransactionDetailsByOutgoingInvID', array("outgoing_inv_id" => $model->outgoing_inventory_id)); ?>',
            dataType: "json",
            beforeSend: function(data) {

            },
            success: function(data) {
                $(".transaction_date").html(data.transaction_date);
                $(".dr_no").html(data.dr_no);
                $(".dr_date").html(data.dr_date);
                $(".rra_no").html(data.rra_no);
                $(".rra_date").html(data.rra_date);
                $(".plan_delivery_date").html(data.plan_delivery_date);
                $(".remarks").html(data.remarks);
                $(".destination_name").html(data.zone_name);
                $(".destination_address").html(data.address);
                $(".destination_contact_person").html(data.destination_contact_person);
                $(".destination_contact_no").html(data.destination_contact_no);
                $(".destination_sales_office_name").html("(" + data.destination_sales_office_name + ")");
                $(".transaction_status").html(data.transaction_status);
                $(".total_amount").html(data.total_amount);
                $(".pr_nos").html(data.pr_nos);
                $(".campaign_nos").html(data.campaign_nos);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    });

</script>