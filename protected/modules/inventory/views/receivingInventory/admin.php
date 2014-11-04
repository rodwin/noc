<?php
$this->breadcrumbs = array(
    ReceivingInventory::RECEIVING_LABEL . ' Inventories' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('receiving-inventory-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<style type="text/css">

    #receiving-inventory_table tbody tr { cursor: pointer }

    .hide_row { display: none; }

    #hide_textbox input { display:none; }

</style>  

<?php // echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>
<?php echo CHtml::link('Create', array('receivingInventory/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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


<?php $fields = ReceivingInventory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="receiving-inventory_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['campaign_no']; ?></th>
                <th><?php echo $fields['pr_no']; ?></th>
                <th><?php echo $fields['pr_date']; ?></th>
                <th><?php echo $fields['dr_no']; ?></th>
                <th><?php echo $fields['requestor']; ?></th>
                <th><?php echo $fields['supplier_id']; ?></th>
                <th><?php echo $fields['zone_id']; ?></th>
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
                <td class="filter" id="hide_textbox"></td>  
            </tr>
        </thead>
    </table>
</div><br/><br/><br/>
<!--julius code-->
<div class="nav-tabs-custom" id ="custTabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Item Details Table</a></li>
        <li><a href="#tab_2" data-toggle="tab">Documents</a></li>
    </ul>
    <div class="tab-content" id ="info">
        <div class="tab-pane active" id="tab_1">
            <div id="ajax_loader_details"></div>
            <?php $skuFields = Sku::model()->attributeLabels(); ?>
            <?php $receivingInvFields = ReceivingInventoryDetail::model()->attributeLabels(); ?>
            <div id="receiving_details" class="box-body table-responsive">
                <table id="receiving-inventory-details_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $receivingInvFields['batch_no']; ?></th>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $receivingInvFields['unit_price']; ?></th>
                            <th><?php echo $receivingInvFields['planned_quantity']; ?></th>
                            <th><?php echo $receivingInvFields['quantity_received']; ?></th>
                            <th><?php echo $receivingInvFields['uom_id']; ?></th>
                            <th><?php echo $receivingInvFields['amount']; ?></th>
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
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <div id="ajax_loader_attachments"></div>
            <?php $attachment = Attachment::model()->attributeLabels(); ?>
            <div id="receiving_attachments" class="box-body table-responsive">
                <table id="receiving-inventory-attachment_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>File Name</th>
                            <th style="width: 80px;"><?php echo 'Actions' ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- -->

<script type="text/javascript">

    var receiving_inventory_table;
    var receiving_inv_detail_table;
    var receiving_inv_attachment_table; //julius code
    var receiving_id;
    $(function() {
        receiving_inventory_table = $('#receiving-inventory_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "order": [[8, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/ReceivingInventory/data'); ?>",
            "columns": [
                {"name": "campaign_no", "data": "campaign_no"},
                {"name": "pr_no", "data": "pr_no"},
                {"name": "pr_date", "data": "pr_date"},
                {"name": "dr_no", "data": "dr_no"},
                {"name": "requestor_name", "data": "requestor_name"},
                {"name": "supplier_name", "data": "supplier_name"},
                {"name": "zone_name", "data": "zone_name"},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "created_date", "data": "created_date"},
                {"name": "links", "data": "links", 'sortable': false}
            ],
            "columnDefs": [{
                    "targets": [8],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(8)', nRow).addClass("text-center");

            }
        });

        $('#receiving-inventory_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadReceivingInvDetails(null);
                loadAttachmentPreview(null);
            }
            else {
                receiving_inventory_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = receiving_inventory_table.fnGetData(this);
                loadReceivingInvDetails(row_data.receiving_inventory_id);
                loadAttachmentPreview(row_data.receiving_inventory_id);
            }
        });

        var i = 0;
        $('#receiving-inventory_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#receiving-inventory_table thead input").keyup(function() {
            receiving_inventory_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        receiving_inv_detail_table = $('#receiving-inventory-details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(9)', nRow).addClass("text-center");
                $('td:eq(4),td:eq(8)', nRow).addClass("text-right");

            }
        });
        // julius code
        receiving_inv_attachment_table = $('#receiving-inventory-attachment_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0), td:eq(2)', nRow).addClass("text-center");

            }
        }); //////

        var i = 0;
        $('#receiving-inventory-details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#receiving-inventory-details_table thead input").keyup(function() {
            receiving_inv_detail_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
                "receiving_inventory_id": $("#ReceivingInventory_receiving_inventory_id").val(), "campaign_no": $("#ReceivingInventory_campaign_no").val(), "pr_no": $("#ReceivingInventory_pr_no").val(), "pr_date": $("#ReceivingInventory_pr_date").val(), "dr_no": $("#ReceivingInventory_dr_no").val(), "requestor": $("#ReceivingInventory_requestor").val(), "supplier_id": $("#ReceivingInventory_supplier_id").val(), });
        });

        jQuery(document).on('click', '#receiving-inventory_table a.delete', function() {
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

                        receiving_id = "";
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });

                        receiving_inventory_table.fnMultiFilter();
                    }

                    loadReceivingInvDetails(receiving_id);
                    loadAttachmentPreview(receiving_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#receiving-inventory-details_table a.delete', function() {
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

                    loadReceivingInvDetails(receiving_id);
                    loadAttachmentPreview(receiving_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#receiving-inventory-attachment_table a.delete', function() {
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

                    loadReceivingInvDetails(receiving_id);
                    loadAttachmentPreview(receiving_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });
    });

    var receiving_details_table, receiving_attachments_table;
    function loadReceivingInvDetails(receiving_inv_id) {
        receiving_id = receiving_inv_id;

        if (typeof receiving_details_table != "undefined") {
            receiving_details_table.abort();
        }

        receiving_details_table = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ReceivingInventory/receivingInvDetailData'); ?>' + '&receiving_inv_id=' + receiving_inv_id,
            dataType: "json",
            beforeSend: function() {
                $("#receiving_details").hide();
                $("#ajax_loader_details").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {

                var oSettings = receiving_inv_detail_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    receiving_inv_detail_table.fnDeleteRow(0, null, true);
                }

                $("#ajax_loader_details").html("");
                $("#receiving_details").show();

                $.each(data.data, function(i, v) {
                    receiving_inv_detail_table.fnAddData([
                        v.batch_no,
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.unit_price,
                        v.planned_quantity,
                        v.quantity_received,
                        v.uom_name,
                        v.amount,
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
    /// julius code
    function loadAttachmentPreview(receiving_inv_id) {

        if (typeof receiving_attachments_table != "undefined") {
            receiving_attachments_table.abort();
        }

        receiving_attachments_table = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ReceivingInventory/preview'); ?>' + '&id=' + receiving_inv_id,
            dataType: "json",
            beforeSend: function() {
                $("#receiving_attachments").hide();
                $("#ajax_loader_attachments").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {
                var oSettings = receiving_inv_attachment_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                var rows = 0;
                for (var i = 0; i <= iTotalRecords; i++) {
                    receiving_inv_attachment_table.fnDeleteRow(0, null, true);
                }

                $("#ajax_loader_attachments").html("");
                $("#receiving_attachments").show();

                $.each(data.data, function(i, v) {
                    rows++;
                    receiving_inv_attachment_table.fnAddData([
                        v.icon,
                        v.file_name,
                        v.links,
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