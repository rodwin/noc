<?php
$this->breadcrumbs = array(
    IncomingInventory::INCOMING_LABEL . ' Inventories' => array('admin'),
    'Manage',
);
?>

<style type="text/css">

    #incoming-inventory_table tbody tr { cursor: pointer }

    .hide_row { display: none; }

</style>  

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>
<?php echo CHtml::link('Create', array('IncomingInventory/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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

<?php $fields = IncomingInventory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="incoming-inventory_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['name']; ?></th>
                <th><?php echo $fields['campaign_no']; ?></th>
                <th><?php echo $fields['pr_no']; ?></th>
                <th><?php echo $fields['pr_date']; ?></th>
                <th><?php echo $fields['dr_no']; ?></th>
                <th><?php echo $fields['zone_id']; ?></th>
                <th><?php echo $fields['status']; ?></th>
                <th><?php echo $fields['total_amount']; ?></th>
                <th><?php echo $fields['created_date']; ?></th>
                <!--<th>Actions</th>-->                
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
            <!--         <h4 class="control-label text-primary"><b>Item Details Table</b></h4>-->
            <?php $skuFields = Sku::model()->attributeLabels(); ?>
            <?php $incomingInvFields = IncomingInventoryDetail::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="incoming-inventory-details_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $incomingInvFields['batch_no']; ?></th>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['sku_name']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $incomingInvFields['source_zone_id']; ?></th>
                            <th><?php echo $incomingInvFields['unit_price']; ?></th>
                            <th><?php echo $incomingInvFields['planned_quantity']; ?></th>
                            <th><?php echo $incomingInvFields['quantity_received']; ?></th>
                            <th><?php echo $incomingInvFields['amount']; ?></th>
                            <th><?php echo $incomingInvFields['status']; ?></th>
                            <th><?php echo $incomingInvFields['remarks']; ?></th>
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
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <?php $attachment = Attachment::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="incoming-inventory-attachment_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="90%"><?php echo 'Attachments' ?></th>
                            <th><?php echo 'Actions' ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

    var incoming_inventory_table;
    var incoming_inventory_table_detail;
    var incoming_inventory_attachment_table;
    $(function() {
        incoming_inventory_table = $('#incoming-inventory_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "order": [[8, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/IncomingInventory/data'); ?>",
            "columns": [
                {"name": "name", "data": "name"},
                {"name": "campaign_no", "data": "campaign_no"},
                {"name": "pr_no", "data": "pr_no"},
                {"name": "pr_date", "data": "pr_date"},
                {"name": "dr_no", "data": "dr_no"},
                {"name": "zone_name", "data": "zone_name"},
                {"name": "status", "data": "status"},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "created_date", "data": "created_date"}
                //                {"name": "links", "data": "links", 'sortable': false}
            ],
            "columnDefs": [{
                    "targets": [8],
                    "visible": false
                }]
        });

        $('#incoming-inventory_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadIncomingInvDetails(null);
                loadAttachmentPreview(null);
            }
            else {
                incoming_inventory_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = incoming_inventory_table.fnGetData(this);
                loadIncomingInvDetails(row_data.incoming_inventory_id);
                loadAttachmentPreview(row_data.incoming_inventory_id);
            }
        });

        var i = 0;
        $('#incoming-inventory_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#incoming-inventory_table thead input").keyup(function() {
            incoming_inventory_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        incoming_inventory_table_detail = $('#incoming-inventory-details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false
        });

        incoming_inventory_attachment_table = $('#incoming-inventory-attachment_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false
        });

        var i = 0;
        $('#incoming-inventory-details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#incoming-inventory-details_table thead input").keyup(function() {
            incoming_inventory_table_detail.fnFilter(this.value, $(this).attr("colPos"));
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
                "incoming_inventory_id": $("#IncomingInventory_incoming_inventory_id").val(), "campaign_no": $("#IncomingInventory_campaign_no").val(), "pr_no": $("#IncomingInventory_pr_no").val(), "pr_date": $("#IncomingInventory_pr_date").val(), "dr_no": $("#IncomingInventory_dr_no").val(), "zone_id": $("#IncomingInventory_zone_id").val(), "transaction_date": $("#IncomingInventory_transaction_date").val(), });
        });

        jQuery(document).on('click', '#incoming-inventory_table a.delete', function() {
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

    function loadIncomingInvDetails(incoming_inv_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/incomingInvDetailData'); ?>' + '&incoming_inv_id=' + incoming_inv_id,
            dataType: "json",
            success: function(data) {

                var oSettings = incoming_inventory_table_detail.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    incoming_inventory_table_detail.fnDeleteRow(0, null, true);
                }

                $.each(data.data, function(i, v) {
                    incoming_inventory_table_detail.fnAddData([
                        v.batch_no,
                        v.sku_code,
                        v.sku_name,
                        v.brand_name,
                        v.source_zone_name,
                        v.unit_price,
                        v.planned_quantity,
                        v.quantity_received,
                        v.amount,
                        v.status,
                        v.remarks
                    ]);
                });
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function loadAttachmentPreview(receiving_inv_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/preview'); ?>' + '&id=' + receiving_inv_id,
            dataType: "json",
            success: function(data) {
                var oSettings = incoming_inventory_attachment_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                var rows = 0;
                for (var i = 0; i <= iTotalRecords; i++) {
                    incoming_inventory_attachment_table.fnDeleteRow(0, null, true);
                }

                $.each(data.data, function(i, v) {
                    rows++;
                    incoming_inventory_attachment_table.fnAddData([
                        v.file_name,
                        v.links,
                    ]);
                });
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }
</script>