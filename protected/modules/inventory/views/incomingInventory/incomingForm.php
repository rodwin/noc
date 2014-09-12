
<?php
$this->breadcrumbs = array(
    'Incoming Inventories' => array('admin'),
    'Create',
);
?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/handlebars-v1.3.0.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/typeahead.bundle.js', CClientScript::POS_END);
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
</style>

<style type="text/css">

    #sku_table tbody tr { cursor: pointer }

    .span5  { width: 200px; }

    .processing_bg { position: absolute; text-align: center; }

    .hide_row { display: none; }

    .sku_uom_selected { width: 20px; }

    /*    #IncomingInventoryDetail_unit_price { width: 100px!important; }*/

</style>   

<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.date.extensions.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.extensions.js', CClientScript::POS_END);
?>

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"></h3>
    </div>

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'incoming-inventory-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'onsubmit' => "return false;",
            'onkeypress' => " if(event.keyCode == 13){ send(); } "
        ),
    ));
    ?>

    <div class="box-body clearfix">

        <div class="col-md-6 clearfix">
            <div class="pull-left col-md-5">

                <?php echo $form->labelEx($incoming, 'campaign_no'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'pr_no'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'pr_date'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'requestor'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'plan_delivery_date'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'revised_delivery_date'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'actual_delivery_date'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($incoming, 'campaign_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'pr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'pr_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->dropDownListGroup(
                        $incoming, 'requestor', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => array(),
                        'htmlOptions' => array('class' => 'span5 input-sm', 'multiple' => false, 'prompt' => 'Select Requestor'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo $form->textFieldGroup($incoming, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'revised_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'actual_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>


            </div>
        </div>

        <div class="col-md-6">
            <div class="pull-left col-md-5">

                <?php echo $form->labelEx($incoming, 'transaction_date'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'dr_no'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'zone_id'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'plan_arrival_date'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'supplier_id'); ?><br/><br/>
                <?php echo $form->labelEx($incoming, 'delivery_remarks'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($incoming, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'value' => date('Y-m-d'), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('zone_name', '', array('id' => 'IncomingInventory_zone_id', 'class' => 'typeahead form-control span5 input-sm', 'placeholder' => "Zone")); ?>
                <?php echo $form->textFieldGroup($incoming, 'zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'incomingInventory_zone_id', 'class' => 'span5 input-sm', 'maxlength' => 50, 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'plan_arrival_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->dropDownListGroup(
                        $incoming, 'supplier_id', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => $supplier_list,
                        'htmlOptions' => array('class' => 'span5 input-sm', 'multiple' => false, 'prompt' => 'Select Supplier'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php
                echo $form->dropDownListGroup(
                        $incoming, 'delivery_remarks', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => $delivery_remarks,
                        'htmlOptions' => array('class' => 'span5 input-sm', 'multiple' => false, 'prompt' => 'Select Delivery Remarks'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

            </div>
        </div>

        <div class="clearfix"></div><br/>

        <a class="btn btn-primary btn-sm" onclick="openFormModal()"><i class="fa fa-fw fa-plus-circle"></i> ADD ITEM</a>&nbsp;&nbsp;
        <button id="delete_row_btn" class="btn btn-danger btn-sm" onclick="deleteTransactionRow()" style="display: none;"><i class="fa fa-trash-o"></i> DELETE</button><br/><br/>

        <?php $fields = Sku::model()->attributeLabels(); ?>
        <?php $incomingDetailFields = IncomingInventoryDetail::model()->attributeLabels(); ?>
        <h4 class="control-label text-primary"><b>Transaction Table</b></h4>

        <div class="table-responsive">            
            <table id="transaction_table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="hide_row"><?php echo $fields['sku_id']; ?></th>
                        <th><?php echo $fields['sku_code']; ?></th>
                        <th><?php echo $fields['description']; ?></th>
                        <th><?php echo $fields['brand_id']; ?></th>
                        <th><?php echo $incomingDetailFields['unit_price']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['batch_no']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $incomingDetailFields['quantity_received']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['uom_id']; ?></th>
                        <th><?php echo $incomingDetailFields['uom_id']; ?></th>
                        <th><?php echo $incomingDetailFields['amount']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['inventory_on_hand']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['remarks']; ?></th>
                    </tr>                                    
                </thead>
            </table>                            
        </div>

        <div class="pull-right col-md-4">
            <?php echo $form->labelEx($incoming, 'total_amount', array("class" => "pull-left")); ?>
            <?php echo $form->textFieldGroup($incoming, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm pull-right', 'maxlength' => 50, 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
        </div>

    </div>

    <div class="box-footer clearfix">

        <div class="row no-print">
            <div class="col-xs-12">
                <button class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn-upload" class="btn btn-primary pull-right"><i class="fa fa-fw fa-upload"></i> Upload PR/DR</button>
                <button id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-fw fa-check"></i> Save</button>  
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>
</div>

<!-----------Form Modal--------------------------------------------------------------->
<div class="modal fade" id="formModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 80%;">
        <div class="modal-body">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Select <?php echo Sku::SKU_LABEL; ?> Product</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" onclick="confirmModal()"><i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="modal-body clearfix">

                    <div class="table-responsive">
                        <table id="sku_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo $fields['sku_code']; ?></th>
                                    <th><?php echo $fields['sku_name']; ?></th>
                                    <th><?php echo $fields['description']; ?></th>
                                    <th><?php echo $fields['brand_id']; ?></th>
                                    <th>Brand Category</th>
                                    <th><?php echo $fields['type']; ?></th>
                                    <th><?php echo $fields['sub_type']; ?></th>
                                    <th><?php echo $fields['default_unit_price']; ?></th>
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

                    <div id="transactionDetailsContainer"></div>

                </div>

                <div class="modal-footer">
                    <div class="pull-left">
                        <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-plus-circle"></i> Add Item', array('name' => 'save', 'class' => 'btn btn-primary', 'id' => 'btn_add_item')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!------------Confirm if Modal close----------->
<div class="modal fade" id="confirmModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix">
                <h5 class="modal-title pull-left">Are you sure you want to close?</h5>

                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" onclick="closeModal()">Yes</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var sku_table;
    var transaction_table;
    $(function() {
        $("[data-mask]").inputmask();

        sku_table = $('#sku_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "bSort": true,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            'iDisplayLength': 5,
            "order": [[0, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/IncomingInventory/skuData'); ?>",
            "columns": [
                {"name": "sku_code", "data": "sku_code"},
                {"name": "sku_name", "data": "sku_name"},
                {"name": "description", "data": "description"},
                {"name": "brand_name", "data": "brand_name"},
                {"name": "brand_category", "data": "brand_category", 'sortable': false},
                {"name": "type", "data": "type"},
                {"name": "sub_type", "data": "sub_type"},
                {"name": "default_unit_price", "data": "default_unit_price"}
            ]
        });
        $('#sku_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadSkuDetails(null);
            }
            else {
                sku_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = sku_table.fnGetData(this);
                loadSkuDetails(row_data.sku_id);
            }
        });

        var i = 0;
        $('#sku_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" onclick="stopPropagation(event);" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#sku_table thead input").keyup(function() {
            sku_table.fnFilter(this.value, $(this).attr("colPos"));
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
                    "targets": [12],
                    "visible": false
                }, {
                    "targets": [13],
                    "visible": false
                }]
        });
    });

    function send() {

        var data = $("#incoming-inventory-form").serialize() + '&' + $.param({"transaction_details": serializeTransactionTable()});

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/create'); ?>',
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

    var total_amount = 0;
    function addItem() {

        var data = $("#add-item-form").serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/addItem'); ?>',
            data: data,
            dataType: "json",
            success: function(data) {
                validateForm(data);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            },
        });
    }

    function validateForm(data) {

        var e = $(".error");
        for (var i = 0; i < e.length; i++) {
            $(e[i]).removeClass('error');
        }

        if (data.success === true) {

            if (data.form == "transaction") {

                document.forms["incoming-inventory-form"].reset();

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

            } else if (data.form == "details") {
                $('#formModal').modal('hide');

                $('#transaction_table').dataTable().fnAddData([
                    '<input type="checkbox" name="transaction_row[]" onclick="showDeleteRowBtn()"/>',
                    data.details.sku_id,
                    data.details.sku_code,
                    data.details.sku_description,
                    data.details.brand_name,
                    data.details.unit_price,
                    data.details.batch_no,
                    data.details.expiration_date,
                    data.details.quantity_received,
                    data.details.uom_id,
                    data.details.uom_name,
                    data.details.amount,
                    data.details.inventory_on_hand,
                    data.details.remarks
                ]);
//                console.log(transaction_table.fnGetData());

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#IncomingInventory_total_amount").val(total_amount);
            }
        } else {

            $.each(JSON.parse(data.error), function(i, v) {
                var element = document.getElementById(i);
                element.classList.add("error");
            });
        }

        if (data.error.length == 0) {
            $.growl(data.message, {
                icon: 'glyphicon glyphicon-info-sign',
                type: data.type
            });
        }
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
                "sku_id": row_data[1],
                "unit_price": row_data[5],
                "batch_no": row_data[6],
                "expiration_date": row_data[7],
                "qty_received": row_data[8],
                "uom_id": row_data[9],
                "amount": row_data[11],
                "inventory_on_hand": row_data[12],
                "remarks": row_data[13],
            });
        }

        return row_datas;
    }

    function deleteTransactionRow() {

//        var row_data = transaction_table.fnGetData(aTrs[i]);
//        var sData = jQuery('input:checked', transaction_table.fnGetNodes()).serialize();
        var aTrs = transaction_table.fnGetNodes();

        for (var i = 0; i < aTrs.length; i++) {
            $(aTrs[i]).find('input:checkbox:checked').each(function() {
                var row_data = transaction_table.fnGetData(aTrs[i]);
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[11]));
                $("#IncomingInventory_total_amount").val(total_amount);

                transaction_table.fnDeleteRow(aTrs[i]);
            });
        }

        $("#delete_row_btn").hide();
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

    $('#btn_save').click(function() {
        send();
    });

    $('#btn_add_item').click(function() {
        addItem();
    });

    function openFormModal() {

        $.ajax({
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/loadFormDetails'); ?>',
            dataType: "json",
            success: function(data) {
                $('#transactionDetailsContainer').html(data);
                sku_table.fnMultiFilter();
                $('#formModal').modal('show');
            },
            error: function(jqXHR, exception) {
                alert('connection error')
            }
        });
    }

    function confirmModal() {
        $('#confirmModal').modal('show');
    }

    function closeModal() {
        $('#confirmModal').modal('hide');
        $('#formModal').modal('hide');
    }

//    window.onbeforeunload = function() {
//        return ""
//    }

    $(function() {
        var zone = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('zone'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo Yii::app()->createUrl("library/zone/search", array('value' => '')) ?>',
            remote: '<?php echo Yii::app()->createUrl("library/zone/search") ?>&value=%QUERY'
        });

        zone.initialize();

        $('#IncomingInventory_zone_id').typeahead(null, {
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
            $("#incomingInventory_zone_id").val(datum.zone_id);
        });

        jQuery('#IncomingInventory_zone_id').on('input', function() {
            var value = $("#IncomingInventory_zone_id").val();
            $("#incomingInventory_zone_id").val(value);
        });
    });

    function onlyNumbers(txt, event) {

        var charCode = (event.which) ? event.which : event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || charCode == 46) {
            return true;
        }

        return false;
    }

    $(function() {
        $('#IncomingInventory_pr_date, #IncomingInventory_plan_delivery_date, #IncomingInventory_revised_delivery_date, #IncomingInventory_actual_delivery_date, #IncomingInventory_plan_arrival_date, #IncomingInventory_transaction_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'
        });
    });

</script>