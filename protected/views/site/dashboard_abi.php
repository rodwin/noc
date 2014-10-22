
<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl . '/css/morris/morris.css');
$cs->registerScriptFile($baseUrl . '/js/plugins/morris/morris.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/raphael-min-2.1.0.js', CClientScript::POS_END);
?>

<style type="text/css">

    #notification_table tbody tr { cursor: pointer }

</style>

<div class="row">
    <div class="col-md-6">
        <div id="inv_notification" class="box box-solid box-danger">
            <div class="box-header">
                <i class="fa fa-warning"></i>
                <h3 class="box-title">Notification</h3>
            </div>            
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table id="notification_table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>DR No</th>
                                <th>DR Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="loading-img" style="display: none;"></div>
        </div>        
    </div>

    <div class="col-md-6">
        <div id="inv_summary_line_chart" class="box box-solid box-info">
            <div class="box-header">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">Inventory Summary</h3>
            </div>
            <div class="box-body">
                <div class="clearfix" style="margin-left: 10px; margin-right: 10px;">
                    <div class="pull-left col-md-4">
                        <label>Brand Category</label><br/><br/>
                        <label>Brand</label>
                    </div>

                    <div class="pull-right col-md-8">
                        <?php
                        echo CHtml::dropDownList('brand_category', '', $brand_category, array(
                            'prompt' => 'All',
                            'class' => 'form-control', 'style' => 'margin-bottom: 10px;',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('library/brand/loadBrandByBrandCategory'), //or $this->createUrl('loadcities') if '$this' extends CController
                                'update' => '#brands', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                'data' => array('brand_category' => 'js:this.value'),
                        )));
                        ?>

                        <?php
                        echo CHtml::dropDownList('brands', '', array(), array(
                            'prompt' => 'Select Brand',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                </div><br/>

                <div class="chart-responsive">
                    <div class="chart" id="inventory_count" style="height: 300px;"></div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="overlay" style="display: none;"></div>
            <div class="loading-img" style="display: none;"></div>
        </div>
    </div>
</div>

<div class="box box-solid box-primary">
    <div class="box-header">
        <i class="fa fa-download"></i>
        <h3 class="box-title">Incoming / Inbound</h3>
    </div>            
    <div class="box-body">
        <div class="table-responsive">
            <table id="incoming_inbound_table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Transaction Date</th>
                        <th>Transaction Type</th>
                        <th>PR No.</th>
                        <th>DR No.</th>
                        <th>Supplier / Source Zone</th>
                        <th>Plan Arrival Date</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>   

<div class="box box-solid box-primary">
    <div class="box-header">
        <i class="fa fa-truck"></i>
        <h3 class="box-title">Outgoing / Outbound</h3>
    </div>            
    <div class="box-body">
        <table id="outgoing_outbound_table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Transaction Date</th>
                    <th>Transaction Type</th>
                    <th>PR No.</th>
                    <th>DR No.</th>
                    <th>Destination Zone</th>
                    <th>Plan Arrival Date</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>  

<div class="box box-solid box-primary">
    <div class="box-header">
        <i class="fa fa-truck"></i>
        <h3 class="box-title">Returnables</h3>
    </div>            
    <div class="box-body">
        <table id="returnables_table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Transaction Date</th>
                    <th>Transaction Type</th>
                    <th>PR No.</th>
                    <th>DR No.</th>
                    <th>MM Description</th>
                    <th>Expiration Date</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>  

<script type="text/javascript">

    var inventory_line_chart;
    var notification_table;
    var chartLineLabel = [];
    var incoming_inbound_table;
    var outgoing_outbound_table;
    var returnables_table;
    $(function() {

        $.ajax({
            url: '<?php echo Yii::app()->createUrl('inventory/inventory/loadTotalInventoryPerMonth'); ?>',
            dataType: "json",
            beforeSend: function(data) {
                $("#inv_summary_line_chart .loading-img").show();
            },
            success: function(data) {

                inventory_line_chart.setData(data);
                $("#inv_summary_line_chart .loading-img").hide();
            },
            error: function(data) {
                alert("Error occured: Please try again.");
                $("#inv_summary_line_chart .loading-img").hide();
            }
        });

        inventory_line_chart = new Morris.Line({
            element: 'inventory_count',
            data: [],
            xkey: 'month',
            ykeys: ['inventory_on_hand'],
            labels: chartLineLabel,
            hoverCallback: function(index, options, content, row) {
                return formatHoverLabel(row, options.preUnits);
            },
            xLabelFormat: function(str) {
//                return y.toFixed(2);
                return formatDate(str);
            },
//            preUnits: 'PhP',
//            xLabelAngle: 70
            resize: true
//            lineColors: ['#7BB661'],
        });

        notification_table = $('#notification_table').dataTable({
            "filter": false,
            "dom": 't<"pull-left"i><"pull-right small"p>',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            'iDisplayLength': 9
        });

        $.ajax({
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('inventory/inventory/loadNotifications'); ?>",
            beforeSend: function(data) {
            },
            success: function(data) {

                $.each(data.data, function(i, v) {
                    notification_table.fnAddData([
                        v.transaction_type,
                        v.dr_no,
                        v.dr_date,
                        v.status
                    ]);
                });
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

        incoming_inbound_table = $('#incoming_inbound_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(7)', nRow).addClass("text-right");
            }
        });

        $.ajax({
            dataType: 'json',
            url: "<?php echo Yii::app()->createUrl('inventory/inventory/loadAllTransactionInv'); ?>"
        }).done(function(data) {

            loadIncomingInbound(data.incoming_inbound);
            loadOutboundOutgoing(data.outbound_outgoing);

        }).fail(function() {
            alert("Error occured: Please try again.");
        });

        outgoing_outbound_table = $('#outgoing_outbound_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(7)', nRow).addClass("text-right");
            }
        });

        returnables_table = $('#returnables_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false
        });

    });

    var m_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    var m_long_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    function formatDate(myDate) {
        var d = new Date(myDate);
        var curr_month = d.getMonth();
        return (m_names[curr_month]);
    }

    function formatHoverLabel(row, preUnit) {
        var d = new Date(row.month);
        var curr_month = d.getMonth();
        var month = row['month'].split("-");

        chartLineLabel = m_long_names[curr_month] + " " + month[0] + "<br/>" + "<p class='text-green'>Total Inventory: " + commaSeparateNumber(row['inventory_on_hand']) + "</p>";

        return chartLineLabel;
    }

    var selected_brand_category_id, selected_brand_id;
    $('#brand_category').change(function() {
        selected_brand_category_id = this.value;
        selected_brand_id = "";

        loadLineGraphByBrand(selected_brand_category_id, selected_brand_id);
    });

    $('#brands').change(function() {
        selected_brand_id = this.value;

        loadLineGraphByBrand(selected_brand_category_id, selected_brand_id);
    });

    function loadLineGraphByBrand(brand_category_id, brand_id) {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('inventory/inventory/loadTotalInventoryPerMonthByBrandCategoryID'); ?>",
            data: {"brand_category_id": brand_category_id, "brand_id": brand_id},
            beforeSend: function(data) {
                $("#inv_summary_line_chart .loading-img").show();
            },
            success: function(data) {

                inventory_line_chart.setData(data);
                $("#inv_summary_line_chart .loading-img").hide();
            },
            error: function(data) {
                alert("Error occured: Please try again.");
                $("#inv_summary_line_chart .loading-img").hide();
            }
        });

    }

    function loadIncomingInbound(data) {

        $.each(data, function(i, v) {
            incoming_inbound_table.fnAddData([
                v.transaction_date,
                v.transaction_type,
                v.pr_no,
                v.dr_no,
                v.source,
                v.plan_arrival_date,
                v.qty,
                v.amount,
                v.status
            ]);
        });

    }

    function loadOutboundOutgoing(data) {

        $.each(data, function(i, v) {
            outgoing_outbound_table.fnAddData([
                v.transaction_date,
                v.transaction_type,
                v.pr_no,
                v.dr_no,
                v.source,
                v.plan_arrival_date,
                v.qty,
                v.amount,
                v.status
            ]);
        });

    }

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }

</script>
