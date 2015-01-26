<?php
$this->breadcrumbs = array(
    'Returns' => array('admin'),
    'Manage',
);
?>

<?php echo CHtml::link('Create', array('Returns/create', 'param' => array('returns_form' => 2)), array('class' => 'btn btn-primary btn-flat')); ?>
<br/>
<br/>

<style type="text/css">

    #returnable_table tbody tr, #return_receipt_table tbody tr, #return-mdse_table tbody tr { cursor: pointer }

    .hide_row { display: none; }

    #hide_textbox input { display:none; }

</style>  

<div class="nav-tabs-custom" id ="returns_tabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#returns_tab_1" data-toggle="tab"><?php echo Returnable::RETURNABLE_LABEL; ?></a></li>
        <li><a href="#returns_tab_2" data-toggle="tab"><?php echo ReturnReceipt::RETURN_RECEIPT_LABEL; ?></a></li>
        <li><a href="#returns_tab_3" data-toggle="tab"><?php echo ReturnMdse::RETURN_MDSE_LABEL; ?></a></li>
    </ul>
    <div class="tab-content" id="info">
        <div class="tab-pane active" id="returns_tab_1">

            <?php $returnableFields = Returnable::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="returnable_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $returnableFields['return_receipt_no']; ?></th>
                            <th><?php echo $returnableFields['transaction_date']; ?></th>
                            <th><?php echo $returnableFields['receive_return_from']; ?></th>
                            <th><?php echo "Source Name"; ?></th>
                            <th><?php echo "Destination Zone"; ?></th>
                            <th><?php echo $returnableFields['total_amount']; ?></th>
                            <th><?php echo $returnableFields['remarks']; ?></th>
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
                            <td class="filter" id="hide_textbox"></td>  
                        </tr>
                    </thead>
                </table>
            </div><br/><br/><br/>

            <div class="nav-tabs-custom" id="returnable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#returnable_tab_1" data-toggle="tab">Item Details Table</a></li>
                    <li><a href="#returnable_tab_2" data-toggle="tab">Documents</a></li>
                    <span id="returnable_lower_table_loader" class="pull-right margin"></span>
                </ul>
                <div class="tab-content" id ="info">
                    <div class="tab-pane active" id="returnable_tab_1">
                        <?php $skuFields = Sku::model()->attributeLabels(); ?>
                        <?php $returnableDetailFields = ReturnableDetail::model()->attributeLabels(); ?>
                        <div id="returnable_details" class="box-body table-responsive">
                            <table id="returnable_details_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo $skuFields['sku_code']; ?></th>
                                        <th><?php echo $skuFields['description']; ?></th>
                                        <th><?php echo $skuFields['brand_id']; ?></th>
                                        <th><?php echo $skuFields['type']; ?></th>
                                        <th><?php echo $skuFields['sub_type']; ?></th>
                                        <th><?php echo $returnableDetailFields['returned_quantity']; ?></th>
                                        <th><?php echo $returnableDetailFields['amount']; ?></th>
                                        <th><?php echo $returnableDetailFields['remarks']; ?></th>
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
                        </div>
                    </div>
                    <div class="tab-pane" id="returnable_tab_2">
                        <?php $attachment = Attachment::model()->attributeLabels(); ?>
                        <div id="returnable_attachments" class="box-body table-responsive">
                            <table id="returnable_attachments_table" class="table table-bordered">
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

        </div>
        <div class="tab-pane" id="returns_tab_2">

            <?php $returnReceiptFields = ReturnReceipt::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="return_receipt_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $returnReceiptFields['return_receipt_no']; ?></th>
                            <th><?php echo $returnReceiptFields['transaction_date']; ?></th>
                            <th><?php echo $returnReceiptFields['receive_return_from']; ?></th>
                            <th><?php echo "Source Name"; ?></th>
                            <th><?php echo "Destination Zone"; ?></th>
                            <th><?php echo $returnReceiptFields['total_amount']; ?></th>
                            <th><?php echo $returnReceiptFields['remarks']; ?></th>
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
                            <td class="filter" id="hide_textbox"></td>  
                        </tr>
                    </thead>        
                </table>
            </div><br/><br/><br/>

            <div class="nav-tabs-custom" id="return_receipt">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#return_receipt_tab_1" data-toggle="tab">Item Details Table</a></li>
                    <li><a href="#return_receipt_tab_2" data-toggle="tab">Documents</a></li>
                    <span id="return_receipt_lower_table_loader" class="pull-right margin"></span>
                </ul>
                <div class="tab-content" id ="info">
                    <div class="tab-pane active" id="return_receipt_tab_1">
                        <?php $returnReceiptDetailFields = ReturnReceiptDetail::model()->attributeLabels(); ?>
                        <div id="return_receipt_details" class="box-body table-responsive">
                            <table id="return_receipt_details_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo $skuFields['sku_code']; ?></th>
                                        <th><?php echo $skuFields['description']; ?></th>
                                        <th><?php echo $skuFields['brand_id']; ?></th>
                                        <th><?php echo $skuFields['type']; ?></th>
                                        <th><?php echo $skuFields['sub_type']; ?></th>
                                        <th><?php echo $returnReceiptDetailFields['returned_quantity']; ?></th>
                                        <th><?php echo $returnReceiptDetailFields['amount']; ?></th>
                                        <th><?php echo $returnReceiptDetailFields['remarks']; ?></th>
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
                        </div>
                    </div>
                    <div class="tab-pane" id="return_receipt_tab_2">
                        <div id="return_receipt_attachments" class="box-body table-responsive">
                            <table id="return_receipt_attachments_table" class="table table-bordered">
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

        </div>
        <div class="tab-pane" id="returns_tab_3">

            <?php $returnMdseFields = ReturnMdse::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="return-mdse_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $returnMdseFields['return_mdse_no']; ?></th>
                            <th><?php echo $returnMdseFields['transaction_date']; ?></th>
                            <th><?php echo $returnMdseFields['return_to']; ?></th>
                            <th><?php echo $returnMdseFields['return_to_id']; ?></th>
                            <th><?php echo $returnMdseFields['total_amount']; ?></th>
                            <th><?php echo $returnMdseFields['remarks']; ?></th>
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
                            <td class="filter" id="hide_textbox"></td>  
                        </tr>
                    </thead>
                </table>
            </div><br/><br/><br/>

            <div class="nav-tabs-custom" id="return_mdse">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#return_mdse_tab_1" data-toggle="tab">Item Details Table</a></li>
                    <li><a href="#return_mdse_tab_2" data-toggle="tab">Documents</a></li>
                    <span id="return_mdse_lower_table_loader" class="pull-right margin"></span>
                </ul>
                <div class="tab-content" id ="info">
                    <div class="tab-pane active" id="return_mdse_tab_1">
                        <?php $returnMdseDetailFields = ReturnMdseDetail::model()->attributeLabels(); ?>
                        <div id="return_mdse_details" class="box-body table-responsive">
                            <table id="return_mdse_details_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo $skuFields['sku_code']; ?></th>
                                        <th><?php echo $skuFields['description']; ?></th>
                                        <th><?php echo $skuFields['brand_id']; ?></th>
                                        <th><?php echo $skuFields['type']; ?></th>
                                        <th><?php echo $skuFields['sub_type']; ?></th>
                                        <th><?php echo $returnMdseDetailFields['returned_quantity']; ?></th>
                                        <th><?php echo $returnMdseDetailFields['amount']; ?></th>
                                        <th><?php echo $returnMdseDetailFields['remarks']; ?></th>
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
                        </div>
                    </div>
                    <div class="tab-pane" id="return_mdse_tab_2">
                        <div id="return_mdse_attachments" class="box-body table-responsive">
                            <table id="return_mdse_attachments_table" class="table table-bordered">
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

        </div>
    </div>
</div>


<script type="text/javascript">

    var returnable_table;
    var returnable_detail_table;
    var returnable_attachment_table;
    var selected_returnable_id;
    var returnable_attachments_table_loaded;
    var return_receipt_table;
    var return_receipt_detail_table;
    var return_receipt_attachment_table;
    var selected_return_receipt_id;
    var return_receipt_attachments_table_loaded;
    var return_mdse_table;
    var return_mdse_detail_table;
    var return_mdse_attachment_table;
    var selected_return_mdse_id;
    var return_mdse_attachments_table_loaded;
    $(function() {
        returnable_table = $('#returnable_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            //            "order": [[7, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Returns/returnableData'); ?>",
            "columns": [
                {"name": "return_receipt_no", "data": "return_receipt_no"},
                {"name": "transaction_date", "data": "transaction_date"},
                {"name": "receive_return_from", "data": "receive_return_from"},
                {"name": "source_name", "data": "source_name", 'sortable': false},
                {"name": "destination_zone_name", "data": "destination_zone_name", 'sortable': false},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "remarks", "data": "remarks"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#returnable_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadReturnableDetails(null);
                loadAttachmentPreview(returnable_attachment_table, returnable_attachments_table_loaded, null, $("#returnable_lower_table_loader"));
            }
            else {
                returnable_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = returnable_table.fnGetData(this);
                loadReturnableDetails(row_data.returnable_id);
                loadAttachmentPreview(returnable_attachment_table, returnable_attachments_table_loaded, row_data.returnable_id, $("#returnable_lower_table_loader"));
            }
        });

        var i = 0;
        $('#returnable_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#returnable_table thead input").keyup(function() {
            returnable_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        returnable_detail_table = $('#returnable_details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(8)', nRow).addClass("text-center");
                $('td:eq(6)', nRow).addClass("text-right");
            }
        });

        var i = 0;
        $('#returnable_details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#returnable_details_table thead input").keyup(function() {
            returnable_detail_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        returnable_attachment_table = $('#returnable_attachments_table').dataTable({
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

        jQuery(document).on('click', '#returnable_table a.delete', function() {
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

                        selected_returnable_id = "";
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });

                        returnable_table.fnMultiFilter();
                    }

                    loadReturnableDetails(selected_returnable_id);
                    loadAttachmentPreview(returnable_attachment_table, returnable_attachments_table_loaded, selected_returnable_id, $("#returnable_lower_table_loader"));
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#returnable_table a.view', function() {

            if (typeof returnable_detail_table_loaded != "undefined") {
                returnable_detail_table_loaded.abort();
            }

            if (typeof returnable_attachments_table_loaded != "undefined") {
                returnable_attachments_table_loaded.abort();
            }

        });

        jQuery(document).on('click', '#returnable_details_table a.delete', function() {
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

                    loadReturnableDetails(selected_returnable_id);
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

//----- RETURN RECEIPT

        return_receipt_table = $('#return_receipt_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            //            "order": [[7, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Returns/returnReceiptData'); ?>",
            "columns": [
                {"name": "return_receipt_no", "data": "return_receipt_no"},
                {"name": "transaction_date", "data": "transaction_date"},
                {"name": "receive_return_from", "data": "receive_return_from"},
                {"name": "source_name", "data": "source_name", 'sortable': false},
                {"name": "destination_zone_name", "data": "destination_zone_name", 'sortable': false},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "remarks", "data": "remarks"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#return_receipt_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadReturnReceiptDetails(null);
                loadAttachmentPreview(return_receipt_attachment_table, return_receipt_attachments_table_loaded, null, $("#return_receipt_lower_table_loader"));
            }
            else {
                return_receipt_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = return_receipt_table.fnGetData(this);
                loadReturnReceiptDetails(row_data.return_receipt_id);
                loadAttachmentPreview(return_receipt_attachment_table, return_receipt_attachments_table_loaded, row_data.return_receipt_id, $("#return_receipt_lower_table_loader"));
            }
        });

        var i = 0;
        $('#return_receipt_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#return_receipt_table thead input").keyup(function() {
            return_receipt_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        return_receipt_detail_table = $('#return_receipt_details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false, "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(8)', nRow).addClass("text-center");
                $('td:eq(6)', nRow).addClass("text-right");
            }
        });

        var i = 0;
        $('#return_receipt_details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#return_receipt_details_table thead input").keyup(function() {
            return_receipt_detail_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        return_receipt_attachment_table = $('#return_receipt_attachments_table').dataTable({
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

        jQuery(document).on('click', '#return_receipt_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1', 'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    if (data == "1451") {
                        $.growl("Unable to delete", {
                            icon: 'glyphicon glyphicon-warning-sign',
                            type: 'danger'});

                        selected_return_receipt_id = "";
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });

                        return_receipt_table.fnMultiFilter();
                    }

                    loadReturnReceiptDetails(selected_return_receipt_id);
                    loadAttachmentPreview(return_receipt_attachment_table, return_receipt_attachments_table_loaded, selected_return_receipt_id, $("#return_receipt_lower_table_loader"));
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#return_receipt_table a.view', function() {

            if (typeof return_receipt_detail_table_loaded != "undefined") {
                return_receipt_detail_table_loaded.abort();
            }

            if (typeof return_receipt_attachments_table_loaded != "undefined") {
                return_receipt_attachments_table_loaded.abort();
            }

        });

        jQuery(document).on('click', '#return_receipt_details_table a.delete', function() {
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

                    loadReturnReceiptDetails(selected_return_receipt_id);
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#return_receipt_attachments_table a.delete_attachment', function() {
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

                    loadAttachmentPreview(return_receipt_attachment_table, return_receipt_attachments_table_loaded, selected_return_receipt_id, $("#return_receipt_lower_table_loader"));
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

//----- RETURN MSDE

        return_mdse_table = $('#return-mdse_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Returns/returnMdseData'); ?>",
            "columns": [
                {"name": "return_mdse_no", "data": "return_mdse_no"},
                {"name": "transaction_date", "data": "transaction_date"},
                {"name": "return_to", "data": "return_to"},
                {"name": "destination_name", "data": "destination_name", 'sortable': false},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "remarks", "data": "remarks"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#return-mdse_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadReturnMdseDetails(null);
                loadAttachmentPreview(return_mdse_attachment_table, return_mdse_attachments_table_loaded, null, $("#return_mdse_lower_table_loader"));
            }
            else {
                return_mdse_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = return_mdse_table.fnGetData(this);
                loadReturnMdseDetails(row_data.return_mdse_id);
                loadAttachmentPreview(return_mdse_attachment_table, return_mdse_attachments_table_loaded, row_data.return_mdse_id, $("#return_mdse_lower_table_loader"));
            }
        });

        var i = 0;
        $('#return-mdse_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#return-mdse_table thead input").keyup(function() {
            return_mdse_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        return_mdse_detail_table = $('#return_mdse_details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false, "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(8)', nRow).addClass("text-center");
                $('td:eq(6)', nRow).addClass("text-right");
            }
        });

        var i = 0;
        $('#return_mdse_details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#return_mdse_details_table thead input").keyup(function() {
            return_mdse_detail_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        return_mdse_attachment_table = $('#return_mdse_attachments_table').dataTable({
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

        jQuery(document).on('click', '#return-mdse_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1', 'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    if (data == "1451") {
                        $.growl("Unable to delete", {
                            icon: 'glyphicon glyphicon-warning-sign',
                            type: 'danger'});

                        selected_return_mdse_id = "";
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });

                        return_mdse_table.fnMultiFilter();
                    }
                    
                    loadReturnMdseDetails(selected_return_mdse_id);
                    loadAttachmentPreview(return_mdse_attachment_table, return_mdse_attachments_table_loaded, selected_return_mdse_id, $("#return_mdse_lower_table_loader"));
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#return-mdse_table a.view', function() {

            if (typeof return_mdse_detail_table_loaded != "undefined") {
                return_mdse_detail_table_loaded.abort();
            }

            if (typeof return_mdse_attachments_table_loaded != "undefined") {
                return_mdse_attachments_table_loaded.abort();
            }

        });

        jQuery(document).on('click', 'a.download_attachment', function() {
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'json',
                'success': function(data) {
                    if (data.success === true) {
                        window.location.href = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/Returns') . '"' ?> + "/loadAttachmentDownload&name=" + data.name + "&src=" + data.src;
                    }

                    $.growl(data.message, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: data.type
                    });
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#return_mdse_details_table a.delete', function() {
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

                    loadReturnMdseDetails(selected_return_mdse_id);
                },
                error: function(status, exception) {
                    alert(status.responseText);
                }
            });
            return false;
        });

    });

    var returnable_detail_table_loaded;
    function loadReturnableDetails(returnable_id) {
        selected_returnable_id = returnable_id;

        if (typeof returnable_detail_table_loaded != "undefined") {
            returnable_detail_table_loaded.abort();
        }

        returnable_detail_table_loaded = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/Returns/getReturnableDetailsByReturnableID'); ?>' + '&returnable_id=' + returnable_id,
            dataType: "json",
            beforeSend: function() {
                $("#returnable_lower_table_loader").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {

                var oSettings = returnable_detail_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    returnable_detail_table.fnDeleteRow(0, null, true);
                }

                $("#returnable_lower_table_loader").html("");

                $.each(data.data, function(i, v) {
                    returnable_detail_table.fnAddData([
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.sku_category,
                        v.sku_sub_category,
                        v.returned_quantity,
                        v.amount,
                        v.remarks,
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

    function loadAttachmentPreview(table, ajax_table_var, id, loader_id) {

        if (typeof ajax_table_var !== "undefined") {
            ajax_table_var.abort();
        }

        ajax_table_var = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/Returns/attachmentPreview'); ?>' + '&id=' + id,
            dataType: "json",
            beforeSend: function() {
                loader_id.html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {
                var oSettings = table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                var rows = 0;
                for (var i = 0; i <= iTotalRecords; i++) {
                    table.fnDeleteRow(0, null, true);
                }

                loader_id.html("");

                $.each(data.data, function(i, v) {
                    rows++;
                    table.fnAddData([
                        v.file_name,
                        v.links, ]);
                });
            },
            error: function(status, exception) {
                if (exception !== "abort") {
                    alert("Error occured: Please try again.");
                }
            }
        });
    }

    var return_receipt_detail_table_loaded;
    function loadReturnReceiptDetails(return_receipt_id) {
        selected_return_receipt_id = return_receipt_id;

        if (typeof return_receipt_detail_table_loaded != "undefined") {
            return_receipt_detail_table_loaded.abort();
        }

        return_receipt_detail_table_loaded = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/Returns/getReturnReceiptDetailsByReturnReceiptID'); ?>' + '&return_receipt_id=' + return_receipt_id,
            dataType: "json",
            beforeSend: function() {
                $("#return_receipt_lower_table_loader").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {

                var oSettings = returnable_detail_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    return_receipt_detail_table.fnDeleteRow(0, null, true);
                }

                $("#return_receipt_lower_table_loader").html("");

                $.each(data.data, function(i, v) {
                    return_receipt_detail_table.fnAddData([
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.sku_category,
                        v.sku_sub_category,
                        v.returned_quantity,
                        v.amount,
                        v.remarks,
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

    var return_mdse_detail_table_loaded;
    function loadReturnMdseDetails(return_mdse_id) {
        selected_return_mdse_id = return_mdse_id;

        if (typeof return_mdse_detail_table_loaded != "undefined") {
            return_mdse_detail_table_loaded.abort();
        }

        return_mdse_detail_table_loaded = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/Returns/getReturnMdseDetailsByReturnMdseID'); ?>' + '&return_mdse_id=' + return_mdse_id,
            dataType: "json",
            beforeSend: function() {
                $("#return_mdse_lower_table_loader").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {

                var oSettings = return_mdse_detail_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    return_mdse_detail_table.fnDeleteRow(0, null, true);
                }

                $("#return_mdse_lower_table_loader").html("");

                $.each(data.data, function(i, v) {
                    return_mdse_detail_table.fnAddData([
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.sku_category,
                        v.sku_sub_category,
                        v.returned_quantity,
                        v.amount,
                        v.remarks,
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