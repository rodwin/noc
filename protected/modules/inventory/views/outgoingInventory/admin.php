<?php
$this->breadcrumbs = array(
    OutgoingInventory::OUTGOING_LABEL . ' Inventories' => array('admin'),
    'Manage',
);
?>

<style type="text/css">

    #outgoing-inventory_table tbody tr { cursor: pointer }

    .hide_row { display: none; }

    #hide_textbox input { display:none; }

</style>  

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat'));  ?>
<?php echo CHtml::link('Create', array('OutgoingInventory/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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

<?php $fields = OutgoingInventory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="outgoing-inventory_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['rra_no']; ?></th>
                <th><?php echo $fields['dr_no']; ?></th>
                <th><?php echo $fields['dr_date']; ?></th>
                <th><?php echo $fields['destination_zone_id']; ?></th>
                <th><?php echo $fields['campaign_no']; ?></th>
                <th><?php echo $fields['pr_no']; ?></th>
                <th><?php echo $fields['status']; ?></th>
                <th><?php echo $fields['contact_person']; ?></th>
                <th><?php echo $fields['total_amount']; ?></th>
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
                <td class="filter" id="hide_textbox"></td>  
            </tr>
        </thead>
    </table>
</div><br/><br/><br/>

<div class="nav-tabs-custom" id ="custTabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Item Details Table</a></li>
        <li><a href="#tab_2" data-toggle="tab">Documents</a></li>
    </ul>
    <div class="tab-content" id ="info">
        <div class="tab-pane active" id="tab_1">
            <?php $skuFields = Sku::model()->attributeLabels(); ?>
            <?php $outgoingInvFields = OutgoingInventoryDetail::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="outgoing-inventory-details_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $outgoingInvFields['batch_no']; ?></th>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $outgoingInvFields['source_zone_id']; ?></th>
                            <th><?php echo $outgoingInvFields['unit_price']; ?></th>
                            <th><?php echo $outgoingInvFields['planned_quantity']; ?></th>
                            <th><?php echo $outgoingInvFields['quantity_issued']; ?></th>
                            <th><?php echo $outgoingInvFields['amount']; ?></th>
                            <th><?php echo $outgoingInvFields['status']; ?></th>
                            <th><?php echo $outgoingInvFields['remarks']; ?></th>
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
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <?php $attachment = Attachment::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="outgoing-inventory-attachment_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th style="width: 80px;"><?php echo 'Actions' ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var outgoing_inventory_table;
    var outgoing_inventory_table_detail;
    var outgoing_inventory_attachment_table;
    var outgoing_inventory_id;
    $(function() {
        outgoing_inventory_table = $('#outgoing-inventory_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "order": [[9, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/OutgoingInventory/data'); ?>",
            "columns": [
                {"name": "rra_no", "data": "rra_no"},
                {"name": "dr_no", "data": "dr_no"},
                {"name": "dr_date", "data": "dr_date"},
                {"name": "destination_zone_name", "data": "destination_zone_name"},
                {"name": "campaign_no", "data": "campaign_no"},
                {"name": "pr_no", "data": "pr_no"},
                {"name": "status", "data": "status"},
                {"name": "contact_person", "data": "contact_person"},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "created_date", "data": "created_date"},
                {"name": "links", "data": "links", 'sortable': false}
            ],
            "columnDefs": [{
                    "targets": [9],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(9)', nRow).addClass("text-center");

            }
        });

        $('#outgoing-inventory_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadOutgoingInvDetails(null);
                loadAttachmentPreview(null);
            }
            else {
                outgoing_inventory_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = outgoing_inventory_table.fnGetData(this);
                loadOutgoingInvDetails(row_data.outgoing_inventory_id);
                loadAttachmentPreview(row_data.outgoing_inventory_id);
            }
        });

        var i = 0;
        $('#outgoing-inventory_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#outgoing-inventory_table thead input").keyup(function() {
            outgoing_inventory_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        outgoing_inventory_table_detail = $('#outgoing-inventory-details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(11)', nRow).addClass("text-center");
            }
        });

        outgoing_inventory_attachment_table = $('#outgoing-inventory-attachment_table').dataTable({
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

        var i = 0;
        $('#outgoing-inventory-details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#outgoing-inventory-details_table thead input").keyup(function() {
            outgoing_inventory_table_detail.fnFilter(this.value, $(this).attr("colPos"));
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
                "outgoing_inventory_id": $("#OutgoingInventory_outgoing_inventory_id").val(), "rra_no": $("#OutgoingInventory_rra_no").val(), "rra_name": $("#OutgoingInventory_rra_name").val(), "destination_zone_id": $("#OutgoingInventory_destination_zone_id").val(), "contact_person": $("#OutgoingInventory_contact_person").val(), "contact_no": $("#OutgoingInventory_contact_no").val(), "address": $("#OutgoingInventory_address").val(), });
        });

        jQuery(document).on('click', '#outgoing-inventory_table a.delete', function() {
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

                        outgoing_inventory_id = "";
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });

                        outgoing_inventory_table.fnMultiFilter();
                    }

                    loadOutgoingInvDetails(outgoing_inventory_id);
                    loadAttachmentPreview(outgoing_inventory_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#outgoing-inventory-details_table a.delete', function() {
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

                    loadOutgoingInvDetails(outgoing_inventory_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#outgoing-inventory-attachment_table a.delete', function() {
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

                    loadAttachmentPreview(outgoing_inventory_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });
    });

    function loadOutgoingInvDetails(outgoing_inv_id) {
        outgoing_inventory_id = outgoing_inv_id;

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/OutgoingInventory/outgoingInvDetailData'); ?>' + '&outgoing_inv_id=' + outgoing_inv_id,
            dataType: "json",
            success: function(data) {

                var oSettings = outgoing_inventory_table_detail.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    outgoing_inventory_table_detail.fnDeleteRow(0, null, true);
                }

                $.each(data.data, function(i, v) {
                    outgoing_inventory_table_detail.fnAddData([
                        v.batch_no,
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.source_zone_name,
                        v.unit_price,
                        v.planned_quantity,
                        v.quantity_issued,
                        v.amount,
                        v.status,
                        v.remarks,
                        v.links
                    ]);
                });
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function loadAttachmentPreview(outgoing_inv_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/OutgoingInventory/preview'); ?>' + '&id=' + outgoing_inv_id,
            dataType: "json",
            success: function(data) {
                var oSettings = outgoing_inventory_attachment_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                var rows = 0;
                for (var i = 0; i <= iTotalRecords; i++) {
                    outgoing_inventory_attachment_table.fnDeleteRow(0, null, true);
                }

                $.each(data.data, function(i, v) {
                    rows++;
                    outgoing_inventory_attachment_table.fnAddData([
                        v.file_name,
                        v.links
                    ]);
                });
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

</script>