
<?php
$this->breadcrumbs = array(
    'Returns' => array('admin'),
    'View',
);
?>

<style type="text/css">
    .text_bold { font-weight: bold; }

    .margin_bottom_30 { margin-bottom: 30px; }

    #return_mdse_detail_table { font-size: 13px; }

    .first_col_left_table { width: 120px; }

    .first_col_right_table { width: 150px; } 

    .text_bold { font-weight: bold; }

    sup { font-weight: bold; }
</style>

<?php $skuFields = Sku::model()->attributeLabels(); ?>
<?php $returnMdseFields = ReturnMdse::model()->attributeLabels(); ?>
<?php $returnMdseDetailFields = ReturnMdseDetail::model()->attributeLabels(); ?>

<?php $not_set = "<i class='text-muted'>Not Set</i>"; ?>

<div class="row panel panel-default">

    <div class="col-sm-6">

        <h5 class="control-label text-primary text_bold">From</h5>
        <table class="table table-bordered table-condensed">
            <tr>
                <td colspan="2"><strong><?php echo $source['source_zone_name']; ?></strong></td>
            </tr>
            <tr>
                <td class="first_col_left_table"><strong>Address:</strong></td><td><?php echo $source['address']; ?></td>
            </tr>
            <tr>
                <td><strong>Contact Person:</strong></td><td><?php echo $source['contact_person']; ?></td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td><td><?php echo $source['contact_no']; ?></td>
            </tr>
        </table>

        <h5 class="control-label text-primary text_bold">To</h5>
        <table class="table table-bordered table-condensed">
            <tr>
                <td><strong><?php echo $returnMdseFields['return_to']; ?>:</strong></td> <td><?php echo $model->return_to; ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong><?php echo $destination['destination_name']; ?></strong> <i class="text-muted">(<?php echo $destination['destination_code']; ?>)</i></td>
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
                <td class="first_col_right_table"><strong><?php echo $returnMdseFields['transaction_date']; ?>:</strong></td>
                <td><?php echo $model->transaction_date; ?></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td><strong><?php echo $returnMdseFields['reference_dr_no']; ?>:</strong></td>
                <td><?php echo $model->reference_dr_no != "" ? $model->reference_dr_no : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $returnMdseFields['date_returned']; ?>:</strong></td>
                <td><?php echo $model->date_returned; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $returnMdseDetailFields['pr_no']; ?>:</strong></td>
                <td><?php echo $nos['pr_no'] != "" ? $nos['pr_no'] : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $returnMdseDetailFields['po_no']; ?>:</strong></td>
                <td><?php echo $nos['po_no'] != "" ? $nos['po_no'] : $not_set; ?></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td><strong><?php echo $returnMdseFields['remarks']; ?>:</strong></td>
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
                <table id="return_mdse_detail_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $skuFields['type']; ?></th>
                            <th><?php echo $returnMdseDetailFields['uom_id']; ?></th>
                            <th><?php echo $returnMdseDetailFields['unit_price']; ?></th>
                            <th><?php echo $returnMdseDetailFields['batch_no']; ?></th>
                            <th><?php echo $returnMdseDetailFields['returned_quantity']; ?></th>
                            <th><?php echo $returnMdseDetailFields['amount']; ?></th>
                            <th><?php echo $returnMdseDetailFields['remarks']; ?></th>
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

    var retur_mdse_detail_table;
    $(function() {

        retur_mdse_detail_table = $('#return_mdse_detail_table').dataTable({
            "filter": false,
            "dom": 't',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "bSort": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Returns/getDetailsByReturnMdseID', array("return_mdse_id" => $model->return_mdse_id)); ?>",
            "columns": [
                {"name": "sku_code", "data": "sku_code"},
                {"name": "sku_description", "data": "sku_description"},
                {"name": "brand_name", "data": "brand_name"},
                {"name": "sku_category", "data": "sku_category"},
                {"name": "uom_name", "data": "uom_name"},
                {"name": "unit_price", "data": "unit_price"},
                {"name": "batch_no", "data": "batch_no"},
                {"name": "returned_quantity", "data": "returned_quantity"},
                {"name": "amount", "data": "amount"},
                {"name": "remarks", "data": "remarks"},
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(9)', nRow).addClass("text-right");
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
                url: '<?php echo Yii::app()->createUrl($this->module->id . '/Returns/returnMdseViewPrint', array("return_mdse_id" => $model->return_mdse_id)); ?>',
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

                        var tab = window.open(<?php echo "'" . Yii::app()->createUrl($this->module->id . '/Returns/loadReturnMdsePDF') . "'" ?> + "&id=" + data.id, "_blank", params);

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