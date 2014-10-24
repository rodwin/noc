<?php
$this->breadcrumbs = array(
    CustomerItem::CUSTOMER_ITEM_LABEL . ' Inventories' => array('admin'),
    'Manage',
);
?>

<style type="text/css">

    #customer-item_table tbody tr { cursor: pointer }

    .hide_row { display: none; }

    #hide_textbox input { display:none; }

</style> 

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>
<?php echo CHtml::link('Create', array('CustomerItem/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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

<?php $fields = CustomerItem::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="customer-item_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['dr_no']; ?></th>
                <th><?php echo $fields['rra_no']; ?></th>
                <th><?php echo $fields['rra_date']; ?></th>
                <!--<th><?php // echo $fields['source_zone_id']; ?></th>-->
                <th><?php echo $fields['poi_id']; ?></th>
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
                <!--<td class="filter"></td>-->
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
            <?php $customerItemFields = CustomerItemDetail::model()->attributeLabels(); ?>
            <div class="box-body table-responsive">
                <table id="customer-item-details_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <!--<th><?php echo $customerItemFields['batch_no']; ?></th>-->
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $customerItemFields['unit_price']; ?></th>
                            <th><?php echo $customerItemFields['planned_quantity']; ?></th>
                            <th><?php echo $customerItemFields['quantity_issued']; ?></th>
                            <th><?php echo $customerItemFields['amount']; ?></th>
                            <th><?php echo $customerItemFields['remarks']; ?></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr id="filter_row">
                            <!--<td class="filter"></td>-->
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
                <table id="customer-item-attachment_table" class="table table-bordered">
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

    var customer_item_table;
    var customer_item_detail_table;
    var customer_item_attachment_table;
    var customerItem_id;
    $(function() {
        customer_item_table = $('#customer-item_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "order": [[5, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/CustomerItem/data'); ?>",
            "columns": [
                {"name": "dr_no", "data": "dr_no"},
                {"name": "rra_no", "data": "rra_no"},
                {"name": "rra_date", "data": "rra_date"},
                {"name": "poi_name", "data": "poi_name"},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "created_date", "data": "created_date"},
                {"name": "links", "data": "links", 'sortable': false}
            ],
            "columnDefs": [{
                    "targets": [5],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(5)', nRow).addClass("text-center");

            }
        });

        $('#customer-item_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadCustomItemDetails(null);
                loadAttachmentPreview(null);
            }
            else {
                customer_item_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = customer_item_table.fnGetData(this);
                loadCustomItemDetails(row_data.customer_item_id);
                loadAttachmentPreview(row_data.customer_item_id);
            }
        });

        var i = 0;
        $('#customer-item_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#customer-item_table thead input").keyup(function() {
            customer_item_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        customer_item_detail_table = $('#customer-item-details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(9)', nRow).addClass("text-center");
            }
        });

        customer_item_attachment_table = $('#customer-item-attachment_table').dataTable({
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
        $('#customer-item-details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#customer-item-details_table thead input").keyup(function() {
            customer_item_detail_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        jQuery(document).on('click', '#customer-item_table a.delete', function() {
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

                        customerItem_id = "";
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });

                        customer_item_table.fnMultiFilter();
                    }
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#customer-item-details_table a.delete', function() {
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

                    loadCustomItemDetails(customerItem_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });

        jQuery(document).on('click', '#customer-item-attachment_table a.delete', function() {
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

                    loadAttachmentPreview(customerItem_id);
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });
    });


    function loadCustomItemDetails(customer_item_id) {
        customerItem_id = customer_item_id;

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/CustomerItem/CustomerItemDetailData'); ?>' + '&customer_item_id=' + customer_item_id,
            dataType: "json",
            success: function(data) {

                var oSettings = customer_item_detail_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    customer_item_detail_table.fnDeleteRow(0, null, true);
                }

                $.each(data.data, function(i, v) {
                    customer_item_detail_table.fnAddData([
//                        v.batch_no,
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.unit_price,
                        v.planned_quantity,
                        v.quantity_issued,
                        v.amount,
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

    function loadAttachmentPreview(customerItem_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/CustomerItem/preview'); ?>' + '&id=' + customerItem_id,
            dataType: "json",
            success: function(data) {
                var oSettings = customer_item_attachment_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                var rows = 0;
                for (var i = 0; i <= iTotalRecords; i++) {
                    customer_item_attachment_table.fnDeleteRow(0, null, true);
                }

                $.each(data.data, function(i, v) {
                    rows++;
                    customer_item_attachment_table.fnAddData([
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