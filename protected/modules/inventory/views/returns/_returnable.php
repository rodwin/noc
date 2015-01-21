
<?php $returnable_label = str_replace(" ", "_", Returnable::RETURNABLE_LABEL) . "_"; ?>

<style type="text/css">
    .<?php echo $returnable_label; ?>autofill_text { height: 30px; margin-top: 20px; margin-bottom: 20px; width: 200px; }
</style>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'returnable-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'onsubmit' => "return false;",
        'onkeypress' => " if(event.keyCode == 13) {} "
    ),));
?>

<div class="clearfix">
    <div class="col-md-6">
        <div id="input_label" class="pull-left col-md-5">

            <?php echo $form->labelEx($returnable, 'return_receipt_no'); ?><br/>
            <?php echo $form->labelEx($returnable, 'receive_return_from'); ?>

        </div>

        <div class="pull-right col-md-7">

            <?php echo $form->textFieldGroup($returnable, 'return_receipt_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

            <?php
            echo $form->select2Group(
                    $returnable, 'receive_return_from', array(
                'wrapperHtmlOptions' => array(
                    'class' => '', 'id' => 'Returnable_receive_return_from',
                ),
                'widgetOptions' => array(
                    'data' => $return_from_list,
                    'options' => array(),
                    'htmlOptions' => array('class' => 'ignore span5', 'prompt' => '--')),
                'labelOptions' => array('label' => false)));
            ?>

        </div>

        <div class="clearfix"></div>

        <div class="well clearfix" style="padding-left: 0px!important; padding-right: 0px!important;">
            <div id="<?php echo $returnable_label; ?>selected_return_from"><i class="text-muted"><center>Not Set</center></i></div>

            <div id="<?php echo $returnable_label; ?>outlet_fields" class="return_source" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($returnable, "Outlet"); ?><br/>
                    <?php echo $form->label($returnable, "Outlet Code"); ?><br/>
                    <?php echo $form->label($returnable, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
//                    $this->widget(
//                            'booster.widgets.TbSelect2', array(
//                        'name' => $returnable_label . 'selected_outlet',
//                        'data' => $poi_list,
//                        'htmlOptions' => array(
//                            'class' => 'span5 ' . $returnable_label . 'return_from_select',
//                            'prompt' => '--'
//                        ),
//                    ));
                    ?>

                    <?php echo CHtml::textField($returnable_label . 'selected_outlet', '', array('class' => 'form-control span5 ignore ' . $returnable_label . 'return_from_select', "placeholder" => "Select Outlet")); ?> 

                    <div id="<?php echo $returnable_label; ?>poi_primary_code" class="<?php echo $returnable_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $returnable_label; ?>poi_address1" class="<?php echo $returnable_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>

            <div id="<?php echo $returnable_label; ?>salesoffice_fields" class="return_source" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($returnable, "Salesoffice"); ?><br/>
                    <?php echo $form->label($returnable, "Salesoffice Code"); ?><br/>
                    <?php echo $form->label($returnable, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => $returnable_label . 'selected_salesoffice',
                        'data' => $salesoffice_list,
                        'htmlOptions' => array(
                            'class' => 'span5 ' . $returnable_label . 'return_from_select',
                            'prompt' => '--'
                        ),
                    ));
                    ?>

                    <div id="<?php echo $returnable_label; ?>salesoffice_code" class="<?php echo $returnable_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $returnable_label; ?>salesoffice_address1" class="<?php echo $returnable_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>

            <div id="<?php echo $returnable_label; ?>employee_fields" class="return_source" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($returnable, "Salesman"); ?><br/>
                    <?php echo $form->label($returnable, "Salesman Code"); ?><br/>
                    <?php echo $form->label($returnable, "Default Zone"); ?><br/>
                    <?php echo $form->label($returnable, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => $returnable_label . 'selected_salesman',
                        'data' => $employee,
                        'htmlOptions' => array(
                            'class' => 'span5 ' . $returnable_label . 'return_from_select',
                            'prompt' => '--'
                        ),
                    ));
                    ?>

                    <div id="<?php echo $returnable_label; ?>employee_code" class="<?php echo $returnable_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $returnable_label; ?>employee_address1" class="<?php echo $returnable_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                    <div id="<?php echo $returnable_label; ?>employee_default_zone" class="<?php echo $returnable_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="col-md-6">
        <div id="input_label" class="pull-left col-md-5">

            <?php echo $form->labelEx($returnable, 'transaction_date'); ?><br/>
            <?php echo $form->labelEx($returnable, 'reference_dr_no'); ?><br/>
            <?php echo $form->labelEx($returnable, 'destination_zone_id'); ?><br/>
            <?php echo $form->labelEx($returnable, 'remarks'); ?>

        </div>

        <div class="pull-right col-md-7">

            <?php echo $form->textFieldGroup($returnable, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

            <?php echo $form->textFieldGroup($returnable, 'reference_dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'readonly' => $isReturnable)), 'labelOptions' => array('label' => false))); ?>

            <?php
            echo $form->select2Group(
                    $returnable, 'destination_zone_id', array(
                'wrapperHtmlOptions' => array(
                    'class' => '', 'id' => 'Returnable_destination_zone_id',
                ),
                'widgetOptions' => array(
                    'data' => $zone_list,
                    'options' => array(
                    ),
                    'htmlOptions' => array('class' => 'ignore span5', 'prompt' => '--')),
                'labelOptions' => array('label' => false)));
            ?>

            <?php
            echo $form->textAreaGroup($returnable, 'remarks', array(
                'wrapperHtmlOptions' => array(
                    'class' => 'span5',
                ),
                'widgetOptions' => array(
                    'htmlOptions' => array('class' => 'ignore', 'style' => 'resize: none; width: 200px;', 'maxlength' => 150),
                ),
                'labelOptions' => array('label' => false)));
            ?>
        </div>
    </div>
</div>

<?php $skuFields = Sku::model()->attributeLabels(); ?>
<?php $returnsDetailFields = ReturnableDetail::model()->attributeLabels(); ?>
<h4 class="control-label text-primary"><b>Transaction Table</b></h4>

<div class="table-responsive x-scroll">           
    <table id="transaction_table" class="table table-bordered">
        <thead>                         
            <tr>
                <th class="hide_col"><?php echo $skuFields['sku_id']; ?></th>
                <th><?php echo $skuFields['sku_code']; ?></th>
                <th><?php echo $skuFields['description']; ?></th>
                <th><?php echo $skuFields['brand_id']; ?></th>
                <th><?php echo $skuFields['type']; ?></th>
                <th><?php echo $skuFields['sub_type']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['unit_price']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['batch_no']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['expiration_date']; ?></th>
                <th><?php echo $returnsDetailFields['quantity_issued']; ?></th>
                <th><?php echo $returnsDetailFields['returned_quantity']; ?> <span title="Click green cell to edit" data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
                <th class="hide_col"><?php echo $returnsDetailFields['uom_id']; ?></th>
                <th><?php echo $returnsDetailFields['uom_id']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['sku_status_id']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['sku_status_id']; ?></th>
                <th><?php echo $returnsDetailFields['amount']; ?></th>
                <th><?php echo $returnsDetailFields['remarks']; ?> <span title="Click green cell to edit" data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
                <th class="hide_col"><?php echo $returnsDetailFields['source_zone_id']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['source_zone_id']; ?></th>
                <th><?php echo $returnsDetailFields['status']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['po_no']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['pr_no']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['pr_date']; ?></th>
                <th class="hide_col"><?php echo $returnsDetailFields['plan_arrival_date']; ?></th>
            </tr>  
        </thead>
    </table>
</div>

<div class="pull-right col-md-4 row" style="margin-bottom: 10px; margin-top: 10px;">
    <?php echo $form->labelEx($returnable, 'total_amount', array("class" => "pull-left")); ?>
    <?php echo $form->textFieldGroup($returnable, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 pull-right', 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
</div>

<div class="clearfix row">
    <div class="col-xs-12">
        <button id="btn_print" class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
        <button id="btn_save" class="btn btn-success pull-right" style=""><i class="glyphicon glyphicon-ok"></i> Save</button>  
    </div>
</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">

<?php $destination_arr = Returnable::model()->getListReturnFrom(); ?>

    var transaction_table;
    var headers = "transaction";
    var print = "print";
    var total_amount = 0;
    var returnable_label = <?php echo "'" . $returnable_label . "'"; ?>;
    var return_type = <?php echo "'" . Returnable::RETURNABLE_LABEL . "'"; ?>;
    $(function() {

        $("[data-mask]").inputmask();

        transaction_table = $('#transaction_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "columnDefs": [{
                    "targets": [0, 6, 7, 8, 11, 13, 14, 17, 18, 20, 21, 22, 23],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var added_status_row_value = aData[19];
                var status_pos_col = 19;

                var pos = transaction_table.fnGetPosition(nRow);

                if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_PENDING_STATUS . "'"; ?>) {
                    transaction_table.fnUpdate("<span class='label label-warning'>" +<?php echo "'" . OutgoingInventory::OUTGOING_PENDING_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                } else if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?>) {
                    transaction_table.fnUpdate("<span class='label label-success'>" +<?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                } else if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?>) {
                    transaction_table.fnUpdate("<span class='label label-danger'>" +<?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                } else if (added_status_row_value == <?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?>) {
                    transaction_table.fnUpdate("<span class='label label-primary'>" +<?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?> + "</span>", pos, status_pos_col);
                }
            }
        });

//        $('#Returnable_reference_dr_no').select2({data: []});
    });

<?php $source_arr = Returnable::model()->getListReturnFrom(); ?>

    $('#Returnable_receive_return_from').change(function() {        
        loadReceivedFrom(this.value);     
    });
    
    $(function() {
        <?php if ($isReturnable === true) { ?>
        loadReceivedFrom(<?php echo "'" . $returnable->receive_return_from . "'"; ?>);
        
        if (<?php echo "'" . $returnable->receive_return_from . "'"; ?> == <?php echo "'" . $source_arr[0]['value'] . "'"; ?>) {
            loadSODetailByID(<?php echo "'" . $returnable->receive_return_from_id . "'"; ?>, returnable_label);
        } else if (<?php echo "'" . $returnable->receive_return_from . "'"; ?> == <?php echo "'" . $source_arr[1]['value'] . "'"; ?>) {
            loadSalesmanDetailByID(<?php echo "'" . $returnable->receive_return_from_id . "'"; ?>, returnable_label);
        } else if (<?php echo "'" . $returnable->receive_return_from . "'"; ?> == <?php echo "'" . $source_arr[2]['value'] . "'"; ?>) {
            loadSelect2POIDetailsByID(<?php echo "'" . $returnable->receive_return_from_id . "'"; ?>, returnable_label);
        }
        <?php } ?>
    });
    
    function loadReceivedFrom(value) {
        
        $("#" + returnable_label + "selected_return_from, .return_source").hide();
        $("." + returnable_label + "autofill_text").html(<?php echo $not_set; ?>);
        $("." + returnable_label + "return_from_select").select2("val", "");

        if (value == <?php echo "'" . $source_arr[0]['value'] . "'"; ?>) {
            $("#" + returnable_label + "salesoffice_fields").show();
        } else if (value == <?php echo "'" . $source_arr[1]['value'] . "'"; ?>) {
            $("#" + returnable_label + "employee_fields").show();
        } else if (value == <?php echo "'" . $source_arr[2]['value'] . "'"; ?>) {
            $("#" + returnable_label + "outlet_fields").show();
        } else {
            $("#" + returnable_label + "selected_return_from").show();
        }
        
    }

    var source_from;
    function loadReferenceDRNos(source) {

        $("#Returnable_reference_dr_no").select2("val", "");

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/returns/loadReferenceDRNos'); ?>' + '&source=' + source,
            dataType: "json",
            success: function(data) {

                source_from = source;

                $('#Returnable_reference_dr_no').select2({
                    placeholder: "--",
                    data: function() {
                        return {results: data};
                    }
                });
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    }

    $("#Returnable_reference_dr_no").change(function() {

        if (source_from == "undefined") {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/returns/infraLoadDetailsByDRNo'); ?>' + "&source=" + source_from + '&dr_no=' + this.value,
            dataType: "json",
            success: function(data) {

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

                if (source_from == <?php echo "'" . $source_arr[0]['value'] . "'"; ?>) {
                    loadSODetailByID(data.id, returnable_label);
                } else if (source_from == <?php echo "'" . $source_arr[1]['value'] . "'"; ?>) {
                    loadSalesmanDetailByID(data.id, returnable_label);
                } else if (source_from == <?php echo "'" . $source_arr[2]['value'] . "'"; ?>) {
                    loadSelect2POIDetailsByID(data.id, returnable_label);
                }

                if (data.transaction_details.length > 0) {

                    $.each(data.transaction_details, function(i, v) {

                        total_amount = (parseFloat(total_amount) + parseFloat(v.amount));

                        var addedRow = transaction_table.fnAddData([
                            v.sku_id,
                            v.sku_code,
                            v.sku_description,
                            v.brand_name,
                            v.sku_category,
                            v.sku_sub_category,
                            v.unit_price,
                            v.batch_no,
                            v.expiration_date,
                            v.planned_quantity,
                            "",
                            v.uom_id,
                            v.uom_name,
                            "",
                            "",
                            v.amount,
                            v.remarks,
                            v.source_zone_id,
                            "",
                            v.status,
                            v.po_no,
                            v.pr_no,
                            v.pr_date,
                            v.plan_arrival_date,
                        ]);

                        var nTr = transaction_table.fnSettings().aoData[addedRow[0]].nTr;
                        $('td:eq(6), td:eq(9)', nTr).addClass("success");

                        $.editable.addInputType('numberOnly', {
                            element: $.editable.types.text.element,
                            plugin: function(settings, original) {
                                $('input', this).bind('keypress', function(event) {
                                    return onlyNumbers(this, event, false);
                                });
                            }
                        });

                        var oSettings = transaction_table.fnSettings();
                        $('td:eq(6)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                            var pos = transaction_table.fnGetPosition(this);
                            var rowData = transaction_table.fnGetData(pos);
                            var planned_qty = parseInt(rowData[9]);
                            var status_pos_col = 19;

                            if (parseInt(value) == planned_qty) {
                                transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                            } else if (parseInt(value) < planned_qty) {
                                transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                            } else if (parseInt(value) > planned_qty) {
                                transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?>, pos[0], status_pos_col);
                            }

                            transaction_table.fnUpdate(value, pos[0], pos[2]);

                        }, {
                            type: 'numberOnly',
                            placeholder: '',
                            indicator: '',
                            tooltip: 'Click to edit',
                            submit: 'Ok',
                            width: "100%",
                            height: "30px"
                        });

                        $('td:eq(9)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                            var pos = transaction_table.fnGetPosition(this);
                            transaction_table.fnUpdate(value, pos[0], pos[2]);
                        }, {
                            type: 'textarea',
                            placeholder: '',
                            indicator: '',
                            tooltip: 'Click to edit',
                            width: "100%",
                            submit: 'Ok',
                            height: "50px"
                        });
                    });

                }

            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    });

    $(function() {
<?php if ($isReturnable === true) { ?>
            loadTransactionDetailByDRNo(<?php echo "'" . $returnable->reference_dr_no . "', '" . $sku_id . "'"; ?>);
<?php }
?>
    });

    function loadTransactionDetailByDRNo(dr_no, sku_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/returns/infraLoadDetailsBySelectedDRNo'); ?>' + '&dr_no=' + dr_no + "&sku_id=" + sku_id,
            dataType: "json",
            success: function(data) {

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

                if (data.transaction_details.length > 0) {

                    $.each(data.transaction_details, function(i, v) {

                        total_amount = (parseFloat(total_amount) + parseFloat(v.amount));

                        var addedRow = transaction_table.fnAddData([
                            v.sku_id,
                            v.sku_code,
                            v.sku_description,
                            v.brand_name,
                            v.sku_category,
                            v.sku_sub_category,
                            v.unit_price,
                            v.batch_no,
                            v.expiration_date,
                            v.remaining_qty,
                            "",
                            v.uom_id,
                            v.uom_name,
                            "",
                            "",
                            v.amount,
                            v.remarks,
                            v.source_zone_id,
                            "",
                            v.status,
                            v.po_no,
                            v.pr_no,
                            v.pr_date,
                            v.plan_arrival_date,
                        ]);

                        var nTr = transaction_table.fnSettings().aoData[addedRow[0]].nTr;
                        $('td:eq(6), td:eq(9)', nTr).addClass("success");

                        $.editable.addInputType('numberOnly', {
                            element: $.editable.types.text.element,
                            plugin: function(settings, original) {
                                $('input', this).bind('keypress', function(event) {
                                    return onlyNumbers(this, event, false);
                                });
                            }
                        });

                        var oSettings = transaction_table.fnSettings();
                        $('td:eq(6)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                            var pos = transaction_table.fnGetPosition(this);
                            var rowData = transaction_table.fnGetData(pos);
                            var planned_qty = parseInt(rowData[9]);
                            var status_pos_col = 19;

                            if (parseInt(value) == planned_qty) {
                                transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                            } else if (parseInt(value) < planned_qty) {
                                transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                            } else if (parseInt(value) > planned_qty) {
                                transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?>, pos[0], status_pos_col);
                            } else {
                                transaction_table.fnUpdate("", pos[0], status_pos_col);
                            }

                            transaction_table.fnUpdate(value, pos[0], pos[2]);

                        }, {
                            type: 'numberOnly',
                            placeholder: '',
                            indicator: '',
                            tooltip: 'Click to edit',
                            submit: 'Ok',
                            width: "100%",
                            height: "30px"
                        });

                        $('td:eq(9)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                            var pos = transaction_table.fnGetPosition(this);
                            transaction_table.fnUpdate(value, pos[0], pos[2]);
                        }, {
                            type: 'textarea',
                            placeholder: '',
                            indicator: '',
                            tooltip: 'Click to edit',
                            width: "100%",
                            submit: 'Ok',
                            height: "50px"
                        });
                    });

                }

                $("#Returnable_total_amount").val(parseFloat(total_amount).toFixed(2));

            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    }

    function serializeTransactionTable() {

        var row_datas = new Array();
        var aTrs = transaction_table.fnGetNodes();
        for (var i = 0; i < aTrs.length; i++) {
            var row_data = transaction_table.fnGetData(aTrs[i]);

            var status = aTrs[i].getElementsByTagName('span')[0].innerHTML;

            row_datas.push({
                "sku_id": row_data[0],
                "unit_price": row_data[6],
                "batch_no": row_data[7],
                "expiration_date": row_data[8],
                "quantity_issued": row_data[9],
                "returned_quantity": row_data[10],
                "uom_id": row_data[11],
                "sku_status_id": row_data[13],
                "amount": row_data[15],
                "remarks": row_data[16],
                "source_zone_id": row_data[17],
                "status": status,
                "po_no": row_data[20],
                "pr_no": row_data[21],
                "pr_date": row_data[22],
                "plan_arrival_date": row_data[23],
            });
        }

        return row_datas;
    }

    $('#' + returnable_label + 'selected_salesoffice').change(function() {
        loadSODetailByID(this.value, returnable_label);
    });

    $('#' + returnable_label + 'selected_salesman').change(function() {
        loadSalesmanDetailByID(this.value, returnable_label);
    });

    $('#' + returnable_label + 'selected_outlet').change(function() {
        loadSelect2POIDetailsByID(this.value, returnable_label);
    });

    function sendReturnable(form, dr_no, sku_id) {

        var data = $("#returnable-form").serialize() + "&form=" + form + "&return_type=" + return_type + "&" + $.param({"transaction_details": serializeTransactionTable()});

        if ($("#btn_save, #btn_print").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl($this->module->id . '/Returns/createReturnable'); ?>' + "&dr_no=" + dr_no + "&sku_id=" + sku_id,
                data: data,
                dataType: "json",
                beforeSend: function(data) {
                    $("#btn_save, #btn_print").attr("disabled", "disabled");
                    if (form == headers) {
                        $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting Form...');
                    } else if (form == print) {
                        $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Loading...');
                    }
                },
                success: function(data) {
                    validateForm(data);
                },
                error: function(status, exception) {
                    alert(status.responseText);
                    $("#btn_save, #btn_print").attr('disabled', false);
                    $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                    $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');
                }
            });
        }
    }

    var success_type, success_message;
    function validateForm(data) {

        var e = $(".error");
        for (var i = 0; i < e.length; i++) {
            var $element = $(e[i]);

            $element.data("title", "")
                    .removeClass("error")
                    .tooltip("destroy");
        }

        if (data.success === true) {

            if (data.form == headers) {
                
                window.location = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/Returns') . '"' ?> + "/returnableView&id=" + data.returnable_id;
                
                growlAlert(data.type, data.message);
            } else if (data.form == print && serializeTransactionTable().length > 0) {
                printPDF(data.print);
            }

        } else {

            growlAlert(data.type, data.message);

            $("#btn_save, #btn_print").attr('disabled', false);
            $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
            $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');
            
            $.each(JSON.parse(data.error), function(i, v) {
                var element = document.getElementById(i);
                var element2 = document.getElementById("s2id_" + i);

                var $element = $(element);
                $element.data("title", v)
                        .addClass("error")
                        .tooltip();

                var $element2 = $(element2);
                $element2.data("title", v)
                        .addClass("error_border")
                        .tooltip();
            });
        }

        $("#btn_save, #btn_print").attr('disabled', false);
        $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
        $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');
    }

    function loadToView() {

//        window.location = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/incomingInventory') . '"' ?> + "/view&id=" + success_incoming_inv_id;

        growlAlert(success_type, success_message);
    }

    $("#btn_save").click(function() {
        if (!confirm('Are you sure you want to submit?'))
            return false;
        sendReturnable(headers, <?php echo "'" . $returnable->reference_dr_no . "', '" . $sku_id . "'"; ?>);
    });

    $(function() {
        $('#Returnable_transaction_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

    $(function() {

        $('#' + returnable_label + 'selected_outlet').select2({
            placeholder: 'Select a Outlet',
            allowClear: true,
            id: function(data) {
                return data.poi_id;
            },
            ajax: {
                quietMillis: 10,
                cache: false,
                dataType: 'json',
                type: 'GET',
                url: '<?php echo Yii::app()->createUrl("library/poi/select2FilterPOI"); ?>',
                data: function(value, page) {
                    return {
                        page: page,
                        pageSize: 10,
                        value: value
                    };
                },
                results: function(data, page) {
                    return {results: data.dataItems};
                }
            },
            formatResult: FormatPOIResult,
            formatSelection: FormatPOISelection,
            minimumInputLength: 1
        });
    });

</script>