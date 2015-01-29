
<?php
$this->breadcrumbs = array(
    ReceivingInventory::RECEIVING_LABEL . ' Inventories' => array('admin'),
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

    #progress_bar_col { display: none; }  
</style>

<?php $skuFields = Sku::model()->attributeLabels(); ?>
<?php $receivingFields = ReceivingInventory::model()->attributeLabels(); ?>
<?php $receivingDetailFields = ReceivingInventoryDetail::model()->attributeLabels(); ?>

<?php $not_set = "<i class='text-muted'>Not Set</i>"; ?>

<div class="row panel panel-default">

    <div class="col-sm-6">

        <h5 class="control-label text-primary text_bold">From</h5>
        <table class="table table-bordered table-condensed">
            <tr>
                <td colspan="2"><strong><?php echo $supplier->supplier_name; ?></strong></td>
            </tr>
            <tr>
                <td class="first_col_left_table"><strong>Address:</strong></td><td><?php echo $supplier->address1; ?></td>
            </tr>
            <tr>
                <td><strong>Contact Person:</strong></td><td><?php echo $supplier->contact_person1; ?></td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td><td><?php echo $supplier->telephone; ?></td>
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
                <td class="first_col_right_table"><strong><?php echo $receivingFields['transaction_date']; ?>:</strong></td>
                <td><?php echo $model->transaction_date; ?></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td class="first_col_right_table"><strong><?php echo $receivingFields['plan_delivery_date']; ?>:</strong></td>
                <td><?php echo $model->plan_delivery_date != "" ? $model->plan_delivery_date : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $receivingFields['pr_no']; ?>:</strong></td>
                <td><?php echo $model->pr_no != "" ? $model->pr_no : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $receivingFields['pr_date']; ?>:</strong></td>
                <td><?php echo $model->pr_date != "" ? $model->pr_date : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $receivingFields['po_no']; ?>:</strong></td>
                <td><?php echo $model->po_no != "" ? $model->po_no : $not_set; ?></td>
            </tr>
            <td><strong><?php echo $receivingFields['po_date']; ?>:</strong></td>
            <td><?php echo $model->po_date != "" ? $model->po_date : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $receivingFields['rra_no']; ?>:</strong></td>
                <td><?php echo $model->rra_no != "" ? $model->rra_no : $not_set; ?></td>
            </tr>
            <td><strong><?php echo $receivingFields['rra_date']; ?>:</strong></td>
            <td><?php echo $model->rra_date != "" ? $model->rra_date : $not_set; ?></td>
            </tr>
            <tr>
                <td><strong><?php echo $receivingFields['dr_no']; ?>:</strong></td>
                <td><?php echo $model->dr_no != "" ? $model->dr_no : $not_set; ?></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed">
            <tr>
                <td><strong><?php echo $receivingFields['delivery_remarks']; ?>:</strong></td>
            </tr>
            <tr>
                <td><?php echo $model->delivery_remarks != "" ? $model->delivery_remarks : $not_set; ?></td>
            </tr>
        </table>
    </div>

    <br/>

    <div class="col-xs-12">
        <div class="nav-tabs-custom" id="">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Item Details</a></li>
                <li><a href="#tab_2" data-toggle="tab">Documents</a></li>
                <span id="lower_table_loader" class="pull-right margin"></span>
            </ul>
            <div class="tab-content" id ="info">
                <div class="tab-pane active" id="tab_1">
                    <div class="table-responsive">
                        <div  style="overflow-x: scroll;">
                            <table id="receiving-inv-detail_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo $skuFields['sku_code']; ?></th>
                                        <th><?php echo $skuFields['description']; ?></th>
                                        <th><?php echo $skuFields['brand_id']; ?></th>
                                        <th><?php echo $skuFields['type']; ?></th>
                                        <th><?php echo $receivingDetailFields['uom_id']; ?></th>
                                        <th><?php echo $receivingDetailFields['unit_price']; ?></th>
                                        <th><?php echo $receivingDetailFields['batch_no']; ?></th>
                                        <th><?php echo $receivingDetailFields['expiration_date']; ?></th>
                                        <th><?php echo $receivingDetailFields['planned_quantity']; ?></th>
                                        <th><?php echo $receivingDetailFields['quantity_received']; ?></th>
                                        <th><?php echo $receivingDetailFields['amount']; ?></th>
                                        <th><?php echo $receivingDetailFields['remarks']; ?></th>
                                    </tr>                                    
                                </thead>
                            </table>     
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php $attachment = Attachment::model()->attributeLabels(); ?>
                    <div id="receiving_attachments" class="box-body table-responsive">
                        <table id="receiving-inventory-attachment_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th style="width: 80px;"><?php echo 'Actions' ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div> 

                    <div class="clearfix" style="">
                        <span id="btn_attach" class="btn btn-success fileinput-button btn-sm btn-flat submit_butt">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Add files...</span>
                        </span>

                        <button type="submit" class="btn btn-primary btn-sm btn-flat start submit_butt" id="btn_upload">
                            <i class="icon-upload icon-white"></i>
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>Start upload</span>
                        </button>
                    </div>

                    <?php
                    $this->widget('booster.widgets.TbFileUpload', array(
                        'url' => $this->createUrl('ReceivingInventory/uploadAttachment'),
                        'model' => $attachment_model,
                        'attribute' => 'file',
                        'multiple' => true,
                        'options' => array(
                            'maxFileSize' => 5000000,
                            'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png|pdf|doc|docx|xls|xlsx)$/i',
                            'submit' => "js:function (e, data) {
                                var inputs = data.context.find('.tagValues');
                                data.formData = inputs.serializeArray();
                                return true;
                       }"
                        ),
                        'formView' => 'application.modules.inventory.views.receivingInventory._form',
                        'uploadView' => 'application.modules.inventory.views.receivingInventory._upload',
                        'downloadView' => 'application.modules.inventory.views.receivingInventory._download',
                        'callbacks' => array(
                            'done' => new CJavaScriptExpression(
                                    'function(e, data) {
                                        file_upload_count--;
                                        
                                        if(file_upload_count == 0) {
                                            files = [];
                                            
                                            growlAlert("success", "Successfully Uploaded");
                                            $("#tbl tbody tr").remove();
                                            loadAttachmentPreview(' . $model->receiving_inventory_id . ');
                                        }
                                }'
                            ),
                            'fail' => new CJavaScriptExpression(
                                    'function(e, data) { console.log("fail"); file_upload_count--; }'
                            ),
                    )));
                    ?>

                </div>

            </div>

        </div>
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

    var receiving_inv_detail_table;
    var receiving_inv_attachment_table;
    var receiving_inventory_id = <?php echo "'" . $model->receiving_inventory_id . "'"; ?>;
    $(function() {

        receiving_inv_detail_table = $('#receiving-inv-detail_table').dataTable({
            "filter": false,
            "dom": 't',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "bSort": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/ReceivingInventory/getDetailsByReceivingInvID', array("receiving_inventory_id" => $model->receiving_inventory_id)); ?>",
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
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
//                $('td:eq(10)', nRow).addClass("text-right");
            }
        });
        
        loadAttachmentPreview(receiving_inventory_id);
        
        receiving_inv_attachment_table = $('#receiving-inventory-attachment_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(1)', nRow).addClass("text-center");

            }
        });

        jQuery(document).on('click', '#receiving-inventory-attachment_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    growlAlert("success", data);
                    
                    loadAttachmentPreview(receiving_inventory_id);
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

        jQuery(document).on('click', 'a.download_attachment', function() {
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'json',
                'success': function(data) {
                    if (data.success === true) {
                        window.location.href = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/outgoingInventory') . '"' ?> + "/loadAttachmentDownload&name=" + data.name + "&src=" + data.src;
                    }                    
                    
                    growlAlert(data.type, data.message);
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
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
                url: '<?php echo Yii::app()->createUrl($this->module->id . '/ReceivingInventory/viewPrint', array("receiving_inventory_id" => $model->receiving_inventory_id)); ?>',
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

                        var tab = window.open(<?php echo "'" . Yii::app()->createUrl($this->module->id . '/ReceivingInventory/loadPDF') . "'" ?> + "&id=" + data.id, "_blank", params);

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

    $('#btn_attach').click(function() {
        $('#file_uploads').click();
    });

    var ctr = 0;
    var file_upload_count = 0;
    var files = new Array();
    function removebyID($id) {
        files.splice($id - 1, 1);
    }

    function selectchange(el) {

        var tag_textbox = $(el).closest("tr").find("input[name=tagname]");
        tag_textbox.val("");

        var selected = $(el).val();
        if (selected != "OTHERS") {
            tag_textbox.attr('disabled', true);
        }
        else {
            tag_textbox.attr('disabled', false);
        }

    }

    $('#btn_upload').click(function() {
        if (!confirm('Are you sure you want to submit?'))
            return false;
        
        if (files !== "") {
            file_upload_count = files.length;
            $('[id=saved_receiving_inventory_id]').val(<?php echo "'" . $model->receiving_inventory_id . "'"; ?>);

            $('#uploading').click();
        }
        return false;
    });

    function growlAlert(type, message) {
        $.growl(message, {
            icon: 'glyphicon glyphicon-info-sign',
            type: type
        });
    }
    
    var receiving_attachments_table;
    function loadAttachmentPreview(receiving_inv_id) {

        if (typeof receiving_attachments_table != "undefined") {
            receiving_attachments_table.abort();
        }

        receiving_attachments_table = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ReceivingInventory/preview'); ?>' + '&id=' + receiving_inv_id,
            dataType: "json",
            beforeSend: function() {
                $("#lower_table_loader").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {
                var oSettings = receiving_inv_attachment_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                var rows = 0;
                for (var i = 0; i <= iTotalRecords; i++) {
                    receiving_inv_attachment_table.fnDeleteRow(0, null, true);
                }

                $("#lower_table_loader").html("");

                $.each(data.data, function(i, v) {
                    rows++;
                    receiving_inv_attachment_table.fnAddData([
                        v.file_name,
                        v.links
                    ]);
                });
            },
            error: function(status, exception) {
                if (exception !== "abort") {
                    alert("Error occured: Please try again.");
                }
            }
        });
    }

</script>