<?php
$this->breadcrumbs = array(
    'Returns' => array('admin'),
    'Manage',
);
?>

<?php echo CHtml::link('Create', array('Returns/create'), array('class' => 'btn btn-primary btn-flat')); ?>
<br/>
<br/>

<style type="text/css">

    #returns_table tbody tr { cursor: pointer }

    .hide_row { display: none; }

    #hide_textbox input { display:none; }

</style>  

<?php $fields = Returns::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="returns_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['return_type']; ?></th>
                <th>RR No./RM No.</th>
                <th><?php echo $fields['transaction_date']; ?></th>
                <th><?php echo $fields['receive_return_from']; ?></th>
                <th><?php echo $fields['receive_return_from_id']; ?></th>
                <th><?php echo $fields['return_to']; ?></th>
                <th>Destination Zone/Supplier</th>
                <th><?php echo $fields['total_amount']; ?></th>
                <th><?php echo $fields['remarks']; ?></th>
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
        <span id="lower_table_loader" class="pull-right margin"></span>
    </ul>
    <div class="tab-content" id ="info">
        <div class="tab-pane active" id="tab_1">
            <div id="ajax_loader_details"></div>
            <?php $skuFields = Sku::model()->attributeLabels(); ?>
            <?php $returnsDetail = ReturnsDetail::model()->attributeLabels(); ?>
            <div id="incoming_details" class="box-body table-responsive">
                <table id="returns-details_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th><?php echo $skuFields['type']; ?></th>
                            <th><?php echo $skuFields['sub_type']; ?></th>
                            <th><?php echo $returnsDetail['returned_quantity']; ?></th>
                            <th><?php echo $returnsDetail['amount']; ?></th>
                            <th><?php echo $returnsDetail['remarks']; ?></th>
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
        <div class="tab-pane" id="tab_2">

        </div>
    </div>
</div>

<script type="text/javascript">

    var returns_table;
    var returns_detail_table;
    var selected_returns_id;
    $(function() {
        returns_table = $('#returns_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Returns/data'); ?>",
            "columns": [
                {"name": "return_type", "data": "return_type"},
                {"name": "return_receipt_no", "data": "return_receipt_no"},
                {"name": "transaction_date", "data": "transaction_date"},
                {"name": "receive_return_from", "data": "receive_return_from"},
                {"name": "receive_return_from_name", "data": "receive_return_from_name"},
                {"name": "return_to", "data": "return_to"},
                {"name": "return_to_name", "data": "return_to_name"},
                {"name": "total_amount", "data": "total_amount"},
                {"name": "remarks", "data": "remarks"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        var i = 0;
        $('#returns_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#returns_table thead input").keyup(function() {
            returns_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        $('#returns_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadReturnsInvDetails(null);
            }
            else {
                returns_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = returns_table.fnGetData(this);
                loadReturnsInvDetails(row_data.returns_id);
            }
        });

        returns_detail_table = $('#returns-details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            iDisplayLength: -1,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            }
        });

        var i = 0;
        $('#returns-details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#returns-details_table thead input").keyup(function() {
            returns_detail_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        jQuery(document).on('click', '#returns_table a.delete', function() {
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

    var returns_details_table;
    function loadReturnsInvDetails(returns_id) {
        selected_returns_id = returns_id;

        if (typeof returns_details_table != "undefined") {
            returns_details_table.abort();
        }

        returns_details_table = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/Returns/getDetailsByReturnInvID'); ?>' + '&returns_id=' + returns_id,
            dataType: "json",
            beforeSend: function() {
                $("#lower_table_loader").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>");
            },
            success: function(data) {

                var oSettings = returns_detail_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    returns_detail_table.fnDeleteRow(0, null, true);
                }

                $("#lower_table_loader").html("");

                $.each(data.data, function(i, v) {
                    returns_detail_table.fnAddData([
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