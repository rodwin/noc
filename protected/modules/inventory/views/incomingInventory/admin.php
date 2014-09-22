<?php
$this->breadcrumbs = array(
    'Incoming Inventories' => array('admin'),
    'Manage',
);
?>

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
                <!--<th><?php echo $fields['incoming_inventory_id']; ?></th>-->
                <th><?php echo $fields['campaign_no']; ?></th>
                <th><?php echo $fields['pr_no']; ?></th>
                <th><?php echo $fields['pr_date']; ?></th>
                <th><?php echo $fields['dr_no']; ?></th>
                <th><?php echo $fields['zone_id']; ?></th>
                <th><?php echo $fields['transaction_date']; ?></th>
                <!--<th>Actions</th>-->                
            </tr>
        </thead>        
    </table>
</div>

<script type="text/javascript">

    var incoming_inventory_table;
    var incoming_inventory_table_detail;
    $(function() {
        var table = $('#incoming-inventory_table').dataTable({
            "filter": true,
            "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/IncomingInventory/data'); ?>",
            "columns": [
                {"name": "campaign_no", "data": "campaign_no"},
                {"name": "pr_no", "data": "pr_no"},
                {"name": "pr_date", "data": "pr_date"},
                {"name": "dr_no", "data": "dr_no"},
                {"name": "zone_name", "data": "zone_name"},
                {"name": "transaction_date", "data": "transaction_date"},
//                {"name": "links", "data": "links", 'sortable': false}
            ]
        });
        
        $('#incoming-inventory_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadIncomingInvDetails(null);
            }
            else {
                outgoing_inventory_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = outgoing_inventory_table.fnGetData(this);
                loadIncomingInvDetails(row_data.outgoing_inventory_id);
            }
        });

        var i = 0;
        $('#incoming-inventory_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#incoming-inventory_table thead input").keyup(function() {
            outgoing_inventory_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        outgoing_inventory_table_detail = $('#incoming-inventory-details_table').dataTable({
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
            outgoing_inventory_table_detail.fnFilter(this.value, $(this).attr("colPos"));
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
</script>