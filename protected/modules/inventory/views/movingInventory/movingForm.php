
<?php
$this->breadcrumbs = array(
    'Goods Movement' => array('admin'),
    'Create',
);
?>

<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/handlebars-v1.3.0.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/typeahead.bundle.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.date.extensions.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.extensions.js', CClientScript::POS_END);
?>

<style type="text/css">
    .typeahead {
        background-color: #fff;
        width: 100%;
    }
    .tt-dropdown-menu {
        width: 200px;
        margin-top: 5px;
        padding: 8px 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }
    .tt-suggestion {
        padding: 8px 20px 8px 20px;
        font-size: 14px;
        line-height: 18px;
    }

    .tt-suggestion + .tt-suggestion {
        font-size: 14px;
        border-top: 1px solid #ccc;
    }

    .tt-suggestions .repo-language {
        float: right;
        font-style: italic;
    }

    .tt-suggestions .repo-name {
        font-size: 15px;
        font-weight: bold;
    }

    .tt-suggestions .repo-description {
        font-size: 14px;
        margin: 0;
        font-style: italic;
    }

    .twitter-typeahead .tt-suggestion.tt-cursor {
        color: #03739c;
        cursor: pointer;
    }

    #scrollable-dropdown-menu .tt-dropdown-menu {
        max-height: 150px;
        overflow-y: auto;
    }

    .process_position { text-align: center; position: absolute; }
</style>

<style type="text/css">

    #inventory_table tbody tr { cursor: pointer }

    #transaction_table td { text-align:center; }
    #transaction_table td + td { text-align: left; }

    .span5  { width: 200px; }

    .processing_bg { position: absolute; text-align: center; }

    .hide_row { display: none; }

    .sku_uom_selected { width: 20px; }

    #hide_textbox input { display:none; }

</style>   

<div class="box box-primary">
    <div class="box-header no-padding">
        <h3 class="box-title text-primary">Select Inventory</h3>
    </div>

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'moving-inventory-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'onsubmit' => "return false;",
//            'onkeypress' => " if(event.keyCode == 13){ send(); } "
        ),
    ));
    ?>

    <div class="box-body clearfix">

        <?php $invFields = Inventory::model()->attributeLabels(); ?>                    
        <div class="table-responsive">
            <table id="inventory_table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo $invFields['sku_code']; ?></th>
                        <th><?php echo $invFields['sku_name']; ?></th>
                        <th><?php echo $invFields['qty']; ?></th>
                        <th><?php echo $invFields['uom_id']; ?></th>
                        <th>Action Qty <i class="fa fa-fw fa-info-circle" data-toggle="popover" content="And here's some amazing content. It's very engaging. right?"></i></th>
                        <th><?php echo $invFields['zone_id']; ?></th>
                        <th><?php echo $invFields['sku_status_id']; ?></th>
                        <th><?php echo $invFields['expiration_date']; ?></th>
                        <th><?php echo $invFields['reference_no']; ?></th>
                        <th><?php echo $invFields['brand_name']; ?></th>
                        <th><?php echo $invFields['sales_office_name']; ?></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <thead>
                    <tr id="filter_row">
                        <td class="filter"></td>
                        <td class="filter"></td>
                        <td class="filter"></td>
                        <td class="filter"></td>
                        <td class="filter hide_row"></td>
                        <td class="filter"></td>
                        <td class="filter"></td>
                        <td class="filter"></td>
                        <td class="filter"></td>
                        <td class="filter" id="hide_textbox"></td>
                        <td class="filter" id="hide_textbox"></td>
                        <td class="filter hide_row"></td>
                    </tr>
                </thead>

            </table>
        </div><br/><br/><br/>

        <div class="panel panel-default col-md-6 no-padding">    
            <div class="panel-body" style="padding-top: 20px;">

                <div class="clearfix">
                    <div class="pull-left col-md-5">

                        <?php echo $form->labelEx($sku, 'type'); ?><br/><br/>
                        <?php echo $form->labelEx($sku, 'sub_type'); ?><br/><br/>
                        <?php echo $form->labelEx($sku, 'brand_id'); ?><br/><br/>
                        <?php echo $form->labelEx($sku, 'sku_code'); ?><br/><br/>
                        <?php echo $form->labelEx($sku, 'description'); ?><br/><br/><br/><br/>

                    </div>
                    <div class="pull-right col-md-7">

                        <?php echo $form->textFieldGroup($sku, 'type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                        <?php echo $form->textFieldGroup($sku, 'sub_type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                        <?php echo $form->textFieldGroup($sku, 'brand_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                        <?php echo $form->textFieldGroup($sku, 'sku_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                        <?php
                        echo $form->textAreaGroup(
                                $sku, 'description', array(
                            'wrapperHtmlOptions' => array(
                                'class' => 'span5',
                            ),
                            'widgetOptions' => array(
                                'htmlOptions' => array('style' => 'resize: none; width: 200px;', 'readonly' => true),
                            ),
                            'labelOptions' => array('label' => false)));
                        ?>

                        <?php echo $form->textFieldGroup($transaction_detail, 'pr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'readonly' => true, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                        <?php echo $form->textFieldGroup($transaction_detail, 'inventory_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'readonly' => true, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                    </div>
                </div>
            </div>
        </div>

        <?php echo $form->textFieldGroup($transaction_detail, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

        <div class="col-md-6 clearfix">
            <div class="pull-left col-md-5">

                <?php echo $form->labelEx($transaction_detail, 'batch_no'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'source_zone_id'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'destination_zone_id'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'expiration_date'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'quantity'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'unit_price'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'amount'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'inventory_on_hand'); ?><br/><br/>
                <?php echo $form->labelEx($transaction_detail, 'remarks'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($transaction_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('source_zone', '', array('id' => 'MovingInventoryDetail_source_zone_id', 'class' => 'typeahead form-control span5 input-sm', 'placeholder' => "Source Zone", 'readonly' => true)); ?>
                <?php echo $form->textFieldGroup($transaction_detail, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array("id" => "MovingInventoryDetail_source_zone", 'class' => 'span5 input-sm', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('destination_zone', '', array('id' => 'MovingInventoryDetail_destination_zone_id', 'class' => 'typeahead form-control span5 input-sm', 'placeholder' => "Zone")); ?>
                <?php echo $form->textFieldGroup($transaction_detail, 'destination_zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'MovingInventoryDetail_destination_zone', 'class' => 'span5 input-sm', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($transaction_detail, 'expiration_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <div class="span5">
                    <?php
                    echo $form->textFieldGroup($transaction_detail, 'quantity', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'span5'
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('class' => 'span5 input-sm', "onkeypress" => "return onlyNumbers(this, event, false)"),
                        ),
                        'labelOptions' => array('label' => false),
                        'append' => '<b class="inventory_uom_selected"></b>'
                    ));
                    ?>
                </div>

                <div class="span5">
                    <?php
                    echo $form->textFieldGroup($transaction_detail, 'unit_price', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'span5'
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('class' => 'span5 input-sm', "onkeypress" => "return onlyNumbers(this, event, true)", "value" => 0),
                        ),
                        'labelOptions' => array('label' => false),
                        'prepend' => '&#8369',
                        'append' => '<b class="inventory_uom_selected"></b>'
                    ));
                    ?>
                </div>

                <?php echo $form->textFieldGroup($transaction_detail, 'amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true, "value" => 0)), 'labelOptions' => array('label' => false))); ?>

                <div class="span5">
                    <?php
                    echo $form->textFieldGroup($transaction_detail, 'inventory_on_hand', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'span5'
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('class' => 'span5 input-sm', 'readonly' => true),
                        ),
                        'labelOptions' => array('label' => false),
                        'append' => '<b class="inventory_uom_selected"></b>'
                    ));
                    ?>
                </div>

                <?php
                echo $form->textAreaGroup(
                        $transaction_detail, 'remarks', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'span5',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('style' => 'resize: none; width: 200px;'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-plus-circle"></i> Add Item', array('name' => 'add_item', 'class' => 'btn btn-primary btn-sm span5', 'id' => 'btn_add_item')); ?>

            </div>
        </div>

        <div class="pull-right col-md-4 no-padding" style="margin-top: 40px;">
            <?php echo $form->labelEx($moving, 'transaction_date', array("class" => "pull-left")); ?>
            <?php echo $form->textFieldGroup($moving, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 input-sm pull-right', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>
        </div>

        <div class="clearfix"></div>

        <?php $skuFields = Sku::model()->attributeLabels(); ?>
        <?php $incomingDetailFields = IncomingInventoryDetail::model()->attributeLabels(); ?>
        <h4 class="control-label text-primary"><b>Transaction Table</b></h4>

        <div class="table-responsive">            
            <table id="transaction_table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th><button id="delete_row_btn" class="btn btn-danger btn-sm" onclick="deleteTransactionRow()" style="display: none;"><i class="fa fa-trash-o"></i></button></th>
                        <th class="hide_row"><?php echo $skuFields['sku_id']; ?></th>
                        <th><?php echo $skuFields['sku_code']; ?></th>
                        <th><?php echo $skuFields['description']; ?></th>
                        <th><?php echo $skuFields['brand_id']; ?></th>
                        <th>Unit Price</th>
                        <th class="hide_row">Batch No</th>
                        <th class="hide_row">Source Zone ID</th>
                        <th>Source Zone</th>
                        <th class="hide_row">Destination Zone ID</th>
                        <th>Destination Zone</th>
                        <th>Expiration Date</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Inventory On Hand</th>
                        <th class="hide_row">Reference no</th>
                        <th class="hide_row">Remarks</th>
                        <th class="hide_row">Inventory</th>
                    </tr>                                    
                </thead>
            </table>                            
        </div>

        <div class="pull-right col-md-4 no-padding">
            <?php echo $form->labelEx($moving, 'total_amount', array("class" => "pull-left")); ?>
            <?php echo $form->textFieldGroup($moving, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 input-sm pull-right', 'maxlength' => 50, 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
        </div>

    </div>

    <div class="box-footer clearfix">

        <div class="row no-print">
            <div class="col-xs-12">
                <button class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn_move" class="btn btn-success pull-right"><i class="fa fa-fw fa-exchange"></i> Move</button>  
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>
</div>


<script type="text/javascript">

    var inventory_table;
    var transaction_table;
    var total_amount = 0;
    $(function() {
        $("[data-mask]").inputmask();

        inventory_table = $('#inventory_table').dataTable({
            "filter": true,
            "dom": '<"process_position"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            'iDisplayLength': 5,
            "order": [[0, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Inventory/data'); ?>",
            "columns": [
                {"name": "sku_code", "data": "sku_code"},
                {"name": "sku_name", "data": "sku_name"},
                {"name": "qty", "data": "qty"},
                {"name": "uom_name", "data": "uom_name"},
                {"name": "action_qty", "data": "action_qty", 'sortable': false, "class": 'action_qty'},
                {"name": "zone_name", "data": "zone_name"},
                {"name": "sku_status_name", "data": "sku_status_name"},
                {"name": "expiration_date", "data": "expiration_date"},
                {"name": "reference_no", "data": "reference_no"},
                {"name": "brand_name", "data": "brand_name"},
                {"name": "sales_office_name", "data": "sales_office_name"},
                {"name": "links", "data": "links", 'sortable': false}
            ],
            "columnDefs": [{
                    "targets": [4],
                    "visible": false
                }, {
                    "targets": [11],
                    "visible": false
                }]
        });

        $('#inventory_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadInventoryDetails(null);
            }
            else {
                inventory_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = inventory_table.fnGetData(this);
                loadInventoryDetails(row_data.DT_RowId);
            }
        });

        var i = 0;
        $('#inventory_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" onclick="stopPropagation(event);" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#inventory_table thead input").keyup(function() {
            inventory_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        transaction_table = $('#transaction_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "columnDefs": [{
                    "targets": [1],
                    "visible": false
                }, {
                    "targets": [6],
                    "visible": false
                }, {
                    "targets": [7],
                    "visible": false
                }, {
                    "targets": [9],
                    "visible": false
                }, {
                    "targets": [15],
                    "visible": false
                }, {
                    "targets": [16],
                    "visible": false
                }, {
                    "targets": [17],
                    "visible": false
                }]
        });
    });

    function send(form) {

        var data = $("#moving-inventory-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable()});
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/MovingInventory/create'); ?>',
            data: data,
            dataType: "json",
            success: function(data) {
                validateForm(data);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function validateForm(data) {

        var e = $(".error");
        for (var i = 0; i < e.length; i++) {
            $(e[i]).removeClass('error');
        }

        if (data.success === true) {

            if (data.form == "transaction") {

                document.forms["moving-inventory-form"].reset();

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

                growlAlert(data.type, data.message);
                inventory_table.fnMultiFilter();

            } else if (data.form == "details") {

                $('#transaction_table').dataTable().fnAddData([
                    '<input type="checkbox" name="transaction_row[]" onclick="showDeleteRowBtn()"/>',
                    data.details.sku_id,
                    data.details.sku_code,
                    data.details.sku_description,
                    data.details.brand_name,
                    data.details.unit_price,
                    data.details.batch_no,
                    data.details.source_zone_id,
                    data.details.source_zone_name,
                    data.details.destination_zone_id,
                    data.details.destination_zone_name,
                    data.details.expiration_date,
                    data.details.quantity,
                    data.details.amount,
                    data.details.inventory_on_hand,
                    data.details.reference_no,
                    data.details.remarks,
                    data.details.inventory_id
                ]);

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#MovingInventory_total_amount").val(total_amount);

                $('#moving-inventory-form > input:text:not(".ignore")').val('');

                growlAlert(data.type, data.message);
                inventory_table.fnMultiFilter();
                $('#moving-inventory-form input:not(.ignore)').val('');
                $('.inventory_uom_selected').html('');
                
            }
        } else {

            if (data.form == "transaction") {
                growlAlert(data.type, data.message);
            }

            $.each(JSON.parse(data.error), function(i, v) {
                var element = document.getElementById(i);
                element.classList.add("error");
            });
        }
    }

    function loadInventoryDetails(inventory_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/MovingInventory/loadInventoryDetails'); ?>',
            data: {"inventory_id": inventory_id},
            dataType: "json",
            success: function(data) {
                $("#Selected_inventory_id").val(data.inventory_id);
                $("#Sku_type").val(data.sku_category);
                $("#Sku_sub_type").val(data.sku_sub_category);
                $("#Sku_brand_id").val(data.brand_name);
                $("#Sku_sku_code").val(data.sku_code);
                $("#Sku_description").val(data.sku_description);
                $("#MovingInventoryDetail_inventory_id").val(data.inventory_id);
                $("#MovingInventoryDetail_sku_id").val(data.sku_id);
                $("#MovingInventoryDetail_source_zone").val(data.source_zone_id);
                $("#MovingInventoryDetail_source_zone_id").val(data.source_zone_name);
                $("#MovingInventoryDetail_unit_price").val(data.unit_price);
                $(".inventory_uom_selected").html(data.inventory_uom_selected);
                $("#MovingInventoryDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#MovingInventoryDetail_pr_no").val(data.reference_no);
                $("#MovingInventoryDetail_quantity").val(0);
                $("#MovingInventoryDetail_amount").val(0);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function growlAlert(type, message) {
        $.growl(message, {
            icon: 'glyphicon glyphicon-info-sign',
            type: type
        });
    }

    function showDeleteRowBtn() {
        var atLeastOneIsChecked = $("input[name='transaction_row[]']").is(":checked");
        if (atLeastOneIsChecked === true) {
            $("#delete_row_btn").show();
        }
        if (atLeastOneIsChecked === false) {
            $("#delete_row_btn").hide();
        }

    }

    function serializeTransactionTable() {

        var row_datas = new Array();
        var aTrs = transaction_table.fnGetNodes();
        for (var i = 0; i < aTrs.length; i++) {
            var row_data = transaction_table.fnGetData(aTrs[i]);

            row_datas.push({
                "pr_no": row_data[15],
                "batch_no": row_data[6],
                "sku_id": row_data[1],
                "source_zone_id": row_data[7],
                "destination_zone_id": row_data[9],
                "unit_price": row_data[5],
                "expiration_date": row_data[11],
                "quantity": row_data[12],
                "amount": row_data[13],
                "inventory_on_hand": row_data[14],
                "remarks": row_data[16],
                "inventory_id": row_data[17],
            });
        }

        return row_datas;
    }

    function deleteTransactionRow() {

        var aTrs = transaction_table.fnGetNodes();

        for (var i = 0; i < aTrs.length; i++) {
            $(aTrs[i]).find('input:checkbox:checked').each(function() {
                var row_data = transaction_table.fnGetData(aTrs[i]);
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[13]));
                $("#MovingInventory_total_amount").val(total_amount);

                transaction_table.fnDeleteRow(aTrs[i]);
            });
        }

        $("#delete_row_btn").hide();
    }

    function showDeleteRowBtn() {
        var atLeastOneIsChecked = $("input[name='transaction_row[]']").is(":checked");
        if (atLeastOneIsChecked === true) {
            $('#delete_row_btn').fadeIn('slow');
        }
        if (atLeastOneIsChecked === false) {
            $('#delete_row_btn').fadeOut('slow');
        }
    }

    $('#btn_move').click(function() {
        send("transaction");
    });

    $('#btn_add_item').click(function() {
        send("details");
    });

    $("#MovingInventoryDetail_quantity").keyup(function(e) {
        var unit_price = 0;
        if ($("#MovingInventoryDetail_unit_price").val() != "") {
            var unit_price = $("#MovingInventoryDetail_unit_price").val();
        }

        var amount = ($("#MovingInventoryDetail_quantity").val() * unit_price);
        $("#MovingInventoryDetail_amount").val(amount);
    });

    $("#MovingInventoryDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#MovingInventoryDetail_quantity").val() != "") {
            var qty = $("#MovingInventoryDetail_quantity").val();
        }

        var amount = (qty * $("#MovingInventoryDetail_unit_price").val());
        $("#MovingInventoryDetail_amount").val(amount);
    });

    $(function() {
        var zone = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('zone'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo Yii::app()->createUrl("library/zone/search", array('value' => '')) ?>',
            remote: '<?php echo Yii::app()->createUrl("library/zone/search") ?>&value=%QUERY'
        });

        zone.initialize();

        $('#MovingInventoryDetail_destination_zone_id').typeahead(null, {
            name: 'zones',
            displayKey: 'zone_name',
            source: zone.ttAdapter(),
            templates: {
                suggestion: Handlebars.compile([
                    '<p class="repo-name">{{zone_name}}</p>',
                    '<p class="repo-description">{{sales_office}}</p>'
                ].join(''))
            }

        }).on('typeahead:selected', function(obj, datum) {
            $("#MovingInventoryDetail_destination_zone").val(datum.zone_id);
        });

        jQuery('#MovingInventoryDetail_destination_zone_id').on('input', function() {
            var value = $("#MovingInventoryDetail_destination_zone_id").val();
            $("#MovingInventoryDetail_destination_zone").val(value);
        });
    });

    function onlyNumbers(txt, event, point) {

        var charCode = (event.which) ? event.which : event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || (point === true && charCode == 46)) {
            return true;
        }

        return false;
    }

    $(function() {
        $('#MovingInventory_transaction_date, #MovingInventoryDetail_expiration_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'
        });
    });

</script>