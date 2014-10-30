<?php
$this->breadcrumbs = array(
    'Proof Of Deliveries' => array('admin'),
    'Manage',
);
?>

<link href="<?php echo Yii::app()->baseUrl; ?>/css/colorbox.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.colorbox.js" type="text/javascript"></script>


<style type="text/css">

    #proof-of-delivery_table tbody tr { cursor: pointer }

    .hide_row { display: none; }

    #hide_textbox input { display:none; }

    .status-label { color: #fff; font-weight: bold; font-size: 12px; text-align: left; }
</style> 

<?php $fields = ProofOfDelivery::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="proof-of-delivery_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['dr_no']; ?></th>
                <th><?php echo $fields['dr_date']; ?></th>
                <th><?php echo $fields['rra_no']; ?></th>
                <th><?php echo $fields['source_zone_id']; ?></th>
                <th><?php echo $fields['poi_id']; ?></th>
                <th>Address</th>
                <th><?php echo $fields['status']; ?></th>
                <th><?php echo $fields['total_amount']; ?></th>
                <th><?php echo $fields['verified']; ?></th>
                <th><?php echo $fields['verified_by']; ?></th>
                <th><?php echo $fields['verified_date']; ?></th>
                <th><?php echo $fields['created_date']; ?></th>
                <th>Actions</th>
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
                <td class="filter"></td>
                <td class="filter"></td>
                <td class="filter" id="hide_textbox"></td>
            </tr>
        </thead>
    </table>
</div><br/><br/><br/>

<div class="nav-tabs-custom" id ="custTabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Item Details Table</a></li>
        <li><a href="#tab_2" data-toggle="tab">Proof of Delivery</a></li>
    </ul>
    <div class="tab-content" id ="info">
        <div class="tab-pane active" id="tab_1">
            <span id="ajax_loader_details"></span>
            <?php $skuFields = Sku::model()->attributeLabels(); ?>
            <?php $PODFields = ProofOfDeliveryDetail::model()->attributeLabels(); ?>
            <div id="pod_details" class="box-body table-responsive">
                <table id="proof-of-delivery-details_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="hide_row"><?php echo $PODFields['pod_detail_id']; ?></th>
                            <th class="hide_row"><?php echo $PODFields['pod_id']; ?></th>
                            <th><?php echo $PODFields['campaign_no']; ?></th>
                            <th><?php echo $PODFields['pr_no']; ?></th>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $PODFields['unit_price']; ?></th>
                            <th><?php echo $PODFields['planned_quantity']; ?></th>
                            <th><?php echo $PODFields['quantity_received']; ?> <span title="Click row to edit" data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
                            <th><?php echo $PODFields['amount']; ?></th>
                            <th><?php echo $PODFields['status']; ?></th>
                            <th><?php echo $PODFields['remarks']; ?> <span title="Click row to edit" data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr id="filter_row">
                            <td class="filter hide_row"></td>
                            <td class="filter hide_row"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter hide_row"></td>
                            <td class="filter" id="hide_textbox"></td>  
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="clearfix">
                <button id="btn_save_pod_details" class="btn btn-success pull-right" style="margin-top: 20px; display: none;"><i class="glyphicon glyphicon-ok"></i> Save</button>
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <span id="ajax_loader_attachment"></span>
            <div id="pod_attachment" class="box-body table-responsive">
                <table id="proof-of-delivery-attachments_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="hide_row"><?php echo $PODFields['pod_detail_id']; ?></th>
                            <th class="hide_row"><?php echo $PODFields['pod_id']; ?></th>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th>Attachment</th>
                            <th>Verification</th>
                            <th>Remarks <span title="Click row to edit" data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr id="filter_row">
                            <td class="filter hide_row"></td>
                            <td class="filter hide_row"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter" id="hide_textbox"></td>
                            <td class="filter"></td>
                            <td class="filter" id="hide_textbox"></td>  
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="clearfix">
                <button id="btn_save_pod_attachment" class="btn btn-success pull-right" style="margin-top: 20px; display: none;"><i class="glyphicon glyphicon-ok"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<!------------Modal------------>
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green clearfix no-padding small-box">
                <h4 class="modal-title pull-left margin"><span class="fa fa-upload"></span>&nbsp; Upload</h4>
                <button class="btn btn-sm btn-flat bg-green pull-right margin" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>

            <div class="modal-body">

                <?php
                $this->widget('booster.widgets.TbFileUpload', array(
                    'url' => $this->createUrl('proofOfDelivery/uploadAttachment'),
                    'model' => $PODAttachment,
                    'attribute' => 'file_name',
                    'multiple' => true,
                    'options' => array(
                        'maxFileSize' => 2000000,
                        'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png)$/i',
                    ),
                    'formView' => 'application.modules.inventory.views.proofOfDelivery._form',
                    'uploadView' => 'application.modules.inventory.views.proofOfDelivery._upload',
                    'downloadView' => 'application.modules.inventory.views.proofOfDelivery._download',
                    'callbacks' => array(
                        'done' => new CJavaScriptExpression(
                                'function(e, data) {  }'
                        ),
                        'fail' => new CJavaScriptExpression(
                                'function(e, data) {  }'
                        ),
                )));
                ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-keyboard="false" data-backdrop="static" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green clearfix no-padding small-box">
                <h4 class="modal-title pull-left margin"><span class="fa fa-paste"></span>&nbsp; Attachment</h4>
                <button class="btn btn-sm btn-flat bg-green pull-right margin" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>

            <div class="modal-body">
                <?php echo $this->renderPartial('_attached', array('pod_attachment_dp' => $pod_attachment_dp,)); ?>
            </div>
        </div>
    </div>
</div>

<div id="POD_attachments" style="display: none;">
    <div id="attached"></div>
</div>

<script type="text/javascript">

    var proof_of_delivery_table, proof_of_delivery_details_table, proof_of_delivery_attachments_table;
    var selected_pod_id, selected_pod_detail_id;
    var pod_tr_selected;
    $(function() {
        proof_of_delivery_table = $('#proof-of-delivery_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "order": [[11, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/ProofOfDelivery/data'); ?>",
            "columns": [
                {"name": "dr_no", "data": "dr_no"},
                {"name": "dr_date", "data": "dr_date"},
                {"name": "rra_no", "data": "rra_no"},
                {"name": "source_zone_id", "data": "source_zone_id"},
                {"name": "poi_name", "data": "poi_name"},
                {"name": "poi_address1", "data": "poi_address1"},
                {"name": "status", "data": "status"},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "verified", "data": "verified"},
                {"name": "verified_by", "data": "verified_by"},
                {"name": "verified_date", "data": "verified_date"},
                {"name": "created_date", "data": "created_date"},
                {"name": "links", "data": "links", 'sortable': false}
            ],
            "columnDefs": [{
                    "targets": [11],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(11)', nRow).addClass("text-center");
                $('td:eq(7)', nRow).addClass("text-right");
            },
            "fnDrawCallback": function(oSettings) {
//                pod_tr_selected.addClass('success');
            },
            "fnInitComplete": function(oSettings, json) {
            }
        });

        $('#proof-of-delivery_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadPODDetails(null);
                loadPODAttachment(null);
                pod_tr_selected = "";
            }
            else {
                proof_of_delivery_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = proof_of_delivery_table.fnGetData(this);
                loadPODDetails(row_data.pod_id);
                loadPODAttachment(row_data.pod_id);
                pod_tr_selected = $(this);
            }
        });

        var i = 0;
        $('#proof-of-delivery_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#proof-of-delivery_table thead input").keyup(function() {
            proof_of_delivery_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        proof_of_delivery_details_table = $('#proof-of-delivery-details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(5),td:eq(8)', nRow).addClass("text-right");
                $('td:eq(11)', nRow).addClass("text-center");
                $('td:eq(7),td:eq(10)', nRow).addClass("success");

                var added_status_row_value = aData[11];
                var status_td = 'td:eq(9)';
                var status_pos_col = 11;

                var pos = proof_of_delivery_details_table.fnGetPosition(nRow);

                if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_PENDING_STATUS . "'"; ?>) {
                    proof_of_delivery_details_table.fnUpdate("<span class='label label-warning'>" +<?php echo "'" . OutgoingInventory::OUTGOING_PENDING_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                } else if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?>) {
                    proof_of_delivery_details_table.fnUpdate("<span class='label label-success'>" +<?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                } else if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?>) {
                    proof_of_delivery_details_table.fnUpdate("<span class='label label-danger'>" +<?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                } else if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?>) {
                    proof_of_delivery_details_table.fnUpdate("<span class='label label-primary'>" +<?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                }
            },
            "columnDefs": [{
                    "targets": [0, 1],
                    "visible": false
                }]
        });

        var i = 0;
        $('#proof-of-delivery-details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#proof-of-delivery-details_table thead input").keyup(function() {
            proof_of_delivery_details_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        proof_of_delivery_attachments_table = $('#proof-of-delivery-attachments_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(5)', nRow).addClass("text-center");
                $('td:eq(4)', nRow).addClass("success");
            },
            "columnDefs": [{
                    "targets": [0, 1],
                    "visible": false
                }]
        });

        var i = 0;
        $('#proof-of-delivery-attachments_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#proof-of-delivery-attachments_table thead input").keyup(function() {
            proof_of_delivery_attachments_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        jQuery(document).on('click', '#proof-of-delivery_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    if (data == "1451") {
                        $.growl("Unable to delete", {
                            icon: 'glyphicon glyphicon-warning-sign',
                            type: 'danger'
                        });

                        selected_pod_id = "";
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });

                        proof_of_delivery_table.fnMultiFilter();
                    }

                    loadPODDetails(selected_pod_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#proof-of-delivery-details_table a.delete', function() {
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

                    loadPODDetails(selected_pod_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', 'a.delete_pod_attached', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {

                    viewPODAttachment(selected_pod_id, selected_pod_detail_id, false);

                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', 'a.download_pod_attached', function() {
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
        });
    });

    function loadPODDetails(pod_id) {
        selected_pod_id = pod_id;

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ProofOfDelivery/PODDetails'); ?>' + '&pod_id=' + pod_id,
            dataType: "json",
            beforeSend: function() {
                $("#pod_details").hide();
                $("#ajax_loader_details").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {

                var oSettings = proof_of_delivery_details_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    proof_of_delivery_details_table.fnDeleteRow(0, null, true);
                }

                $("#btn_save_pod_details").hide();
                $("#ajax_loader_details").html("");
                $("#pod_details").show();

                $.each(data.data, function(i, v) {
                    var addedRow = proof_of_delivery_details_table.fnAddData([
                        v.pod_detail_id,
                        v.pod_id,
                        v.campaign_no,
                        v.pr_no,
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.unit_price,
                        v.planned_quantity,
                        v.quantity_received,
                        v.amount,
                        v.status,
                        v.remarks,
                        v.links
                    ]);

                    $.editable.addInputType('numberOnly', {
                        element: $.editable.types.text.element,
                        plugin: function(settings, original) {
                            $('input', this).bind('keypress', function(event) {
                                return onlyNumbers(this, event, false);
                            });
                        }
                    });

                    var oSettings = proof_of_delivery_details_table.fnSettings();
                    $('td:eq(7)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                        var pos = proof_of_delivery_details_table.fnGetPosition(this);
                        var rowData = proof_of_delivery_details_table.fnGetData(pos);
                        var planned_qty = parseInt(rowData[8]);
                        var status_pos_col = 11;

                        if (parseInt(value) == planned_qty) {
                            proof_of_delivery_details_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                        } else if (parseInt(value) < planned_qty) {
                            proof_of_delivery_details_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                        } else if (parseInt(value) > planned_qty) {
                            proof_of_delivery_details_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?>, pos[0], status_pos_col);
                        }

                        proof_of_delivery_details_table.fnUpdate(value, pos[0], pos[2]);

                    }, {
                        type: 'numberOnly',
                        placeholder: '',
                        indicator: '',
                        tooltip: 'Click to edit',
                        submit: 'Ok',
                        width: "100%",
                        height: "30px"
                    });

                    $('td:eq(10)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                        var pos = proof_of_delivery_details_table.fnGetPosition(this);
                        proof_of_delivery_details_table.fnUpdate(value, pos[0], pos[2]);
                    }, {
                        type: 'text',
                        placeholder: '',
                        indicator: '',
                        tooltip: 'Click to edit',
                        width: "100%",
                        submit: 'Ok',
                        height: "30px"
                    });
                });

                var POD_row_details = proof_of_delivery_details_table.fnSettings().fnRecordsTotal();

                if (POD_row_details > 0) {
                    $("#btn_save_pod_details").show();
                }
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function onlyNumbers(txt, event, point) {

        var charCode = (event.which) ? event.which : event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || (point === true && charCode == 46)) {
            return true;
        }

        return false;
    }

    $("#btn_save_pod_details").click(function() {
        if (!confirm('Are you sure you want to submit?'))
            return false;
        PODDetails_Save();
    });

    $("#btn_save_pod_attachment").click(function() {
        if (!confirm('Are you sure you want to submit?'))
            return false;
        PODAttachment_Save();
    });

    function PODDetails_Save() {

        if ($("#btn_save_pod_details").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/ProofOfDelivery/savePODDetails'); ?>',
                dataType: "json",
                data: {"pod_details": serializePODDetailTable()},
                beforeSend: function(data) {
                    $("#btn_save_pod_details").attr("disabled", "disabled");
                    $('#btn_save_pod_details').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting ...');
                },
                success: function(data) {

                    if (data.success === true) {
                        $.growl("Successfully updated", {
                            icon: 'glyphicon glyphicon-warning-sign',
                            type: 'success'
                        });

                        loadPODDetails(selected_pod_id);
                        proof_of_delivery_table.fnMultiFilter();
                    } else {
                        $.growl("Unable to save", {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'danger'
                        });
                    }

                    $("#btn_save_pod_details").attr('disabled', false);
                    $('#btn_save_pod_details').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                },
                error: function(data) {
                    $("#btn_save_pod_details").attr('disabled', false);
                    $('#btn_save_pod_details').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                    alert("Error occured: Please try again.");
                }
            });
        }
    }

    function serializePODDetailTable() {

        var row_datas = new Array();
        var aTrs = proof_of_delivery_details_table.fnGetNodes();
        for (var i = 0; i < aTrs.length; i++) {
            var row_data = proof_of_delivery_details_table.fnGetData(aTrs[i]);

            var status = aTrs[i].getElementsByTagName('span')[0].innerHTML;

            row_datas.push({
                "pod_detail_id": row_data[0],
                "pod_id": row_data[1],
                "quantity_received": row_data[9],
                "status": status,
                "remarks": row_data[12],
            });
        }

        return row_datas;
    }

    function loadPODAttachment(pod_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ProofOfDelivery/PODDAttachment'); ?>' + '&pod_id=' + pod_id,
            dataType: "json",
            beforeSend: function() {
                $("#pod_attachment").hide();
                $("#ajax_loader_attachment").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {

                var oSettings = proof_of_delivery_attachments_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    proof_of_delivery_attachments_table.fnDeleteRow(0, null, true);
                }

                $("#btn_save_pod_attachment").hide();
                $("#ajax_loader_attachment").html("");
                $("#pod_attachment").show();

                $.each(data.data, function(i, v) {
                    var addedRow = proof_of_delivery_attachments_table.fnAddData([
                        v.pod_detail_id,
                        v.pod_id,
                        v.sku_code,
                        v.sku_description,
                        v.attachment,
                        '<input type="checkbox" onclick="showVerified(this, ' + i + ')" ' + v.verification + '/> <span class="verified_status">' + v.verified_status + '</span><p class="verified_value" style="display: none;">' + v.verified + '</p>',
                        v.attachment_remarks,
                        v.links
                    ]);
                    
                    var oSettings = proof_of_delivery_attachments_table.fnSettings();

                    $('td:eq(4)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                        var pos = proof_of_delivery_attachments_table.fnGetPosition(this);
                        proof_of_delivery_attachments_table.fnUpdate(value, pos[0], pos[2]);
                    }, {
                        type: 'text',
                        placeholder: '',
                        indicator: '',
                        tooltip: 'Click to edit',
                        width: "100%",
                        submit: 'Ok',
                        height: "30px"
                    });
                });

                var POD_row_attachment = proof_of_delivery_attachments_table.fnSettings().fnRecordsTotal();

                if (POD_row_attachment > 0) {
                    $("#btn_save_pod_attachment").show();
                }
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    }

    function showVerified(el, key) {

        if ($(el).is(":checked")) {
            $(el).siblings('.verified_value').html(1);
            $(el).siblings('.verified_status').html("<span class='label label-success'>VERIFIED</span>");
        } else {
            $(el).siblings('.verified_value').html(0);
            $(el).siblings('.verified_status').html("<span class='label label-danger'>UNVERIFIED</span>");
        }

    }

    function serializePODAttachmentTable() {

        var row_datas = new Array();
        var aTrs = proof_of_delivery_attachments_table.fnGetNodes();
        for (var i = 0; i < aTrs.length; i++) {
            var row_data = proof_of_delivery_attachments_table.fnGetData(aTrs[i]);

            var verified_value = aTrs[i].getElementsByClassName('verified_value')[0].innerHTML;

            row_datas.push({
                "pod_detail_id": row_data[0],
                "pod_id": row_data[1],
                "verified": verified_value,
                "attachment_remarks": row_data[6],
            });
        }

        return row_datas;
    }

    function PODAttachment_Save() {

        if ($("#btn_save_pod_attachment").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/ProofOfDelivery/savePODAttachment'); ?>',
                dataType: "json",
                data: {"pod_attachment": serializePODAttachmentTable()},
                beforeSend: function(data) {
                    $("#btn_save_pod_attachment").attr("disabled", "disabled");
                    $('#btn_save_pod_attachment').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting ...');
                },
                success: function(data) {

                    if (data.success === true) {
                        $.growl("Successfully updated", {
                            icon: 'glyphicon glyphicon-warning-sign',
                            type: 'success'
                        });

                        loadPODAttachment(selected_pod_id);
                        proof_of_delivery_table.fnMultiFilter();
                    } else {
                        $.growl("Unable to save", {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'danger'
                        });
                    }

                    $("#btn_save_pod_attachment").attr('disabled', false);
                    $('#btn_save_pod_attachment').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                },
                error: function(data) {
                    $("#btn_save_pod_attachment").attr('disabled', false);
                    $('#btn_save_pod_attachment').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                    alert("Error occured: Please try again.");
                }
            });
        }
    }

    function uploadPODAttachment(pod_id, pod_detail_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ProofOfDelivery/uploadPODAttachment'); ?>',
            dataType: "json",
            data: {
                "pod_id": pod_id,
                "pod_detail_id": pod_detail_id
            },
            beforeSend: function(data) {

            },
            success: function(data) {
                $('#uploadModal').modal('show');
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    }

    function viewPODAttachment(pod_id, pod_detail_id, view) {
        selected_pod_detail_id = pod_detail_id;

        $.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createUrl('/inventory/ProofOfDelivery/viewPODAttachment'); ?>',
            dataType: "json",
            data: {
                "pod_id": pod_id,
                "pod_detail_id": pod_detail_id
            },
            success: function(data) {

                if (view === true) {
                    $('#attachmentModal').modal('show');
                }

                $("#attached_thumbnails").html(data);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    }

</script>