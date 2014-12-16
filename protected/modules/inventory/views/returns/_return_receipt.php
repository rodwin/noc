
<?php $return_receipt_label = str_replace(" ", "_", ReturnReceipt::RETURN_RECEIPT_LABEL) . "_"; ?>

<style type="text/css">
    .<?php echo $return_receipt_label; ?>autofill_text { height: 30px; margin-top: 20px; margin-bottom: 20px; width: 200px; }
</style>

<style type="text/css">
    #sku_bg {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }
</style>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'return-receipt-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'onsubmit' => "return false;",
        'onkeypress' => " if(event.keyCode == 13) {} "
    ),));
?>

<div class="clearfix">
    <div class="col-md-6">
        <div id="input_label" class="pull-left col-md-5">

            <?php echo $form->labelEx($return_receipt, 'return_receipt_no'); ?><br/>
            <?php echo $form->labelEx($return_receipt, 'receive_return_from'); ?>

        </div>

        <div class="pull-right col-md-7">

            <?php echo $form->textFieldGroup($return_receipt, 'return_receipt_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

            <?php
            echo $form->select2Group(
                    $return_receipt, 'receive_return_from', array(
                'wrapperHtmlOptions' => array(
                    'class' => '', 'id' => 'ReturnReceipt_receive_return_from',
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
            <div id="<?php echo $return_receipt_label; ?>selected_return_from"><i class="text-muted"><center>Not Set</center></i></div>

            <div id="<?php echo $return_receipt_label; ?>outlet_fields" class="<?php echo $return_receipt_label; ?>return_source" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($return_receipt, "Outlet"); ?><br/>
                    <?php echo $form->label($return_receipt, "Outlet Code"); ?><br/>
                    <?php echo $form->label($return_receipt, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => $return_receipt_label . 'selected_outlet',
                        'data' => $poi_list,
                        'htmlOptions' => array(
                            'class' => 'span5 ignore ' . $return_receipt_label . 'return_from_select',
                            'prompt' => '--'
                        ),
                    ));
                    ?>

                    <div id="<?php echo $return_receipt_label; ?>poi_primary_code" class="<?php echo $return_receipt_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $return_receipt_label; ?>poi_address1" class="<?php echo $return_receipt_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>

            <div id="<?php echo $return_receipt_label; ?>salesoffice_fields" class="<?php echo $return_receipt_label; ?>return_source" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($return_receipt, "Salesoffice"); ?><br/>
                    <?php echo $form->label($return_receipt, "Salesoffice Code"); ?><br/>
                    <?php echo $form->label($return_receipt, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => $return_receipt_label . 'selected_salesoffice',
                        'data' => $salesoffice_list,
                        'htmlOptions' => array(
                            'class' => 'span5 ignore ' . $return_receipt_label . 'return_from_select',
                            'prompt' => '--'
                        ),
                    ));
                    ?>

                    <div id="<?php echo $return_receipt_label; ?>salesoffice_code" class="<?php echo $return_receipt_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $return_receipt_label; ?>salesoffice_address1" class="<?php echo $return_receipt_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>

            <div id="<?php echo $return_receipt_label; ?>employee_fields" class="<?php echo $return_receipt_label; ?>return_source" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($return_receipt, "Salesman"); ?><br/>
                    <?php echo $form->label($return_receipt, "Salesman Code"); ?><br/>
                    <?php echo $form->label($return_receipt, "Default Zone"); ?><br/>
                    <?php echo $form->label($return_receipt, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => $return_receipt_label . 'selected_salesman',
                        'data' => $employee,
                        'htmlOptions' => array(
                            'class' => 'span5 ignore ' . $return_receipt_label . 'return_from_select',
                            'prompt' => '--'
                        ),
                    ));
                    ?>

                    <div id="<?php echo $return_receipt_label; ?>employee_code" class="<?php echo $return_receipt_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $return_receipt_label; ?>employee_address1" class="<?php echo $return_receipt_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                    <div id="<?php echo $return_receipt_label; ?>employee_default_zone" class="<?php echo $return_receipt_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="col-md-6">
        <div id="input_label" class="pull-left col-md-5">

            <?php echo $form->labelEx($return_receipt, 'transaction_date'); ?><br/>
            <?php echo $form->labelEx($return_receipt, 'reference_dr_no'); ?><br/>
            <?php echo $form->labelEx($return_receipt, 'destination_zone_id'); ?><br/>
            <?php echo $form->labelEx($return_receipt, 'remarks'); ?>

        </div>

        <div class="pull-right col-md-7">

            <?php echo $form->textFieldGroup($return_receipt, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

            <?php echo $form->textFieldGroup($return_receipt, 'reference_dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'placeholder' => 'DR No')), 'labelOptions' => array('label' => false))); ?>

            <?php
            echo $form->select2Group(
                    $return_receipt, 'destination_zone_id', array(
                'wrapperHtmlOptions' => array(
                    'class' => '', 'id' => '',
                ),
                'widgetOptions' => array(
                    'data' => $zone_list,
                    'options' => array(),
                    'htmlOptions' => array('class' => 'ignore span5', 'prompt' => '--')),
                'labelOptions' => array('label' => false)));
            ?>

            <?php
            echo $form->textAreaGroup($return_receipt, 'remarks', array(
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

    <div id="sku_bg" class="panel panel-default col-md-12 no-padding">    
        <div class="panel-body" style="padding-top: 10px;">
            <h4 class="control-label text-primary pull-left"><b>Select <?php echo Sku::SKU_LABEL; ?> Product</b></h4>

            <?php $fields = Sku::model()->attributeLabels(); ?>
            <div class="table-responsive">
                <table id="sku_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $fields['sku_code']; ?></th>
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
                        </tr>
                    </thead>
                </table>
            </div><br/>

            <div class="col-md-6 clearfix">
                <div id="input_label" class="pull-left col-md-5">

                    <?php echo $form->labelEx($return_receipt_detail, 'batch_no'); ?><br/>
                    <?php echo $form->labelEx($return_receipt_detail, 'quantity_issued'); ?><br/>
                    <?php echo $form->labelEx($return_receipt_detail, 'returned_quantity'); ?><br/>
                    <?php echo $form->label($return_receipt_detail, 'Inventory On Hand'); ?>

                </div>
                <div class="pull-right col-md-7">

                    <?php echo $form->textFieldGroup($return_receipt_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                    <?php
                    echo $form->dropDownListGroup($return_receipt_detail, 'uom_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'span5',
                        ),
                        'widgetOptions' => array(
                            'data' => $uom,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select UOM', 'class' => 'span5', 'style' => 'display: none;'),
                        ),
                        'labelOptions' => array('label' => false)));
                    ?>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_receipt_detail, 'quantity_issued', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", "onkeypress" => "return onlyNumbers(this, event, false)")
                            ),
                            'labelOptions' => array('label' => false),
                            'append' => '<b class="sku_uom_selected"></b>'
                        ));
                        ?>
                    </div>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_receipt_detail, 'returned_quantity', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", "onkeypress" => "return onlyNumbers(this, event, false)")
                            ),
                            'labelOptions' => array('label' => false),
                            'append' => '<b class="sku_uom_selected"></b>'
                        ));
                        ?>
                    </div>

                    <?php
                    echo $form->dropDownListGroup($return_receipt_detail, 'sku_status_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => '',
                        ),
                        'widgetOptions' => array(
                            'data' => $sku_status,
                            'htmlOptions' => array('class' => 'span5', 'multiple' => false, 'prompt' => 'Select ' . Sku::SKU_LABEL . ' Status', 'style' => 'display: none;'),
                        ),
                        'labelOptions' => array('label' => false)));
                    ?>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_receipt_detail, 'inventory_on_hand', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", 'readonly' => true)
                            ),
                            'labelOptions' => array('label' => false),
                            'append' => '<b class="sku_uom_selected"></b>'
                        ));
                        ?>
                    </div>

                    <?php echo $form->textFieldGroup($return_receipt_detail, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>
                </div>
            </div>

            <div class="col-md-6 clearfix">
                <div id="input_label" class="pull-left col-md-5">

                    <?php echo $form->labelEx($return_receipt_detail, 'expiration_date'); ?><br/>
                    <?php echo $form->labelEx($return_receipt_detail, 'unit_price'); ?><br/>
                    <?php echo $form->labelEx($return_receipt_detail, 'amount'); ?><br/>
                    <?php echo $form->labelEx($return_receipt_detail, 'remarks'); ?>

                </div>
                <div class="pull-right col-md-7">

                    <?php echo $form->textFieldGroup($return_receipt_detail, 'expiration_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_receipt_detail, 'unit_price', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", "onkeypress" => "return onlyNumbers(this, event, true)")
                            ),
                            'labelOptions' => array('label' => false),
                            'prepend' => '&#8369',
                        ));
                        ?>
                    </div>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_receipt_detail, 'amount', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", 'readonly' => true)
                            ),
                            'labelOptions' => array('label' => false),
                            'prepend' => '&#8369'
                        ));
                        ?>
                    </div>

                    <?php
                    echo $form->textAreaGroup(
                            $return_receipt_detail, 'remarks', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'span5',
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('style' => 'resize: none; width: 200px;'),
                        ),
                        'labelOptions' => array('label' => false)));
                    ?>

                    <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-plus-circle"></i> Add Item', array('name' => 'add_item', 'maxlength' => 150, 'class' => 'btn btn-primary btn-sm span5', 'id' => 'btn_add_item')); ?>

                </div>
            </div>

        </div>
    </div>
</div>


<?php $skuFields = Sku::model()->attributeLabels(); ?>
<?php $returnReceiptDetailFields = ReturnReceiptDetail::model()->attributeLabels(); ?>  
<h4 class="control-label text-primary"><b>Transaction Table</b></h4>

<div class="table-responsive x-scroll">            
    <table id="transaction_table2" class="table table-bordered ">
        <thead>
            <tr>
                <th style="text-align: center;"><button id="delete_row_btn" class="btn btn-danger btn-sm" onclick="deleteTransactionRow()" style="display: none;"><i class="fa fa-trash-o"></i></button></th>
                <th class="hide_row"><?php echo $skuFields['sku_id']; ?></th>
                <th><?php echo $skuFields['sku_code']; ?></th>
                <th><?php echo $skuFields['description']; ?></th>
                <th><?php echo $skuFields['brand_id']; ?></th>
                <th><?php echo $returnReceiptDetailFields['unit_price']; ?></th>
                <th><?php echo $returnReceiptDetailFields['batch_no']; ?></th>
                <th><?php echo $returnReceiptDetailFields['expiration_date']; ?></th>
                <th><?php echo $returnReceiptDetailFields['quantity_issued']; ?></th>
                <th><?php echo $returnReceiptDetailFields['returned_quantity']; ?></th>
                <th class="hide_row"><?php echo $returnReceiptDetailFields['uom_id']; ?></th>
                <th class="hide_row"><?php echo $returnReceiptDetailFields['uom_id']; ?></th>
                <th class="hide_row"><?php echo $returnReceiptDetailFields['sku_status_id']; ?></th>
                <th class="hide_row"><?php echo $returnReceiptDetailFields['sku_status_id']; ?></th>
                <th><?php echo $returnReceiptDetailFields['amount']; ?></th>
                <th class="hide_row"><?php echo $returnReceiptDetailFields['remarks']; ?></th>
            </tr>                                    
        </thead>
    </table>                            
</div>

<div class="pull-right col-md-4 row" style="margin-bottom: 10px; margin-top: 10px;">
    <?php echo $form->labelEx($return_receipt, 'total_amount', array("class" => "pull-left")); ?>
    <?php echo $form->textFieldGroup($return_receipt, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 pull-right', 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
</div>

<div class="clearfix row">
    <div class="col-xs-12">
        <button id="btn_print2" class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
        <button id="btn_save2" class="btn btn-success pull-right" style=""><i class="glyphicon glyphicon-ok"></i> Save</button>  
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

<?php $destination_arr = Returns::model()->getListReturnFrom(); ?>

    var transaction_table2;
    var sku_table;
    var headers = "transaction";
    var details = "details";
    var print = "print";
    var total_amount = 0;
    var return_receipt_type = <?php echo "'" . ReturnReceipt::RETURN_RECEIPT_LABEL . "'"; ?>;
    var return_to = <?php echo "'" . $destination_arr[0]['value'] . "'"; ?>;
    var return_receipt_label = <?php echo "'" . $return_receipt_label . "'"; ?>;
    $(function() {

        $("[data-mask]").inputmask();

        transaction_table2 = $('#transaction_table2').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "columnDefs": [{
                    "targets": [1, 10, 11, 12, 13, 15],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            }
        });

        sku_table = $('#sku_table').dataTable({
            "filter": true,
            "dom": '<"pull-right"i>t',
            "bSort": true,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            'iDisplayLength': 3,
            "order": [[0, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/ReceivingInventory/skuData'); ?>",
            "columns": [
                {"name": "sku_code", "data": "sku_code"},
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
            $(this).html('<input type="text" class="form-control input-sm ignore" onclick="stopPropagation(event);" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#sku_table thead input").keyup(function() {
            sku_table.fnFilter(this.value, $(this).attr("colPos"));
        });
    });

    function loadSkuDetails(sku_id) {

        $("#ReturnReceiptDetail_sku_id").val(sku_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ReceivingInventory/loadSkuDetails'); ?>',
            data: {"sku_id": sku_id},
            dataType: "json",
            success: function(data) {
                $("#ReturnReceiptDetail_unit_price").val(data.default_unit_price);
                $("#ReturnReceiptDetail_uom_id").val(data.sku_default_uom_id);
                $(".sku_uom_selected").html(data.sku_default_uom_name);
                $("#ReturnReceiptDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#ReturnReceiptDetail_quantity_issued, #ReturnReceiptDetail_returned_quantity, #ReturnReceiptDetail_amount").val("");
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

<?php $source_arr = Returns::model()->getListReturnFrom(); ?>

    $('#ReturnReceipt_receive_return_from').change(function() {

        var value = this.value;

        $("#" + return_receipt_label + "selected_return_from, ." + return_receipt_label + "return_source").hide();
        $("." + return_receipt_label + "autofill_text").html(<?php echo $not_set; ?>);
        $("." + return_receipt_label + "return_from_select").select2("val", "");

        if (value == <?php echo "'" . $source_arr[0]['value'] . "'"; ?>) {
            $("#" + return_receipt_label + "salesoffice_fields").show();
        } else if (value == <?php echo "'" . $source_arr[1]['value'] . "'"; ?>) {
            $("#" + return_receipt_label + "employee_fields").show();
        } else if (value == <?php echo "'" . $source_arr[2]['value'] . "'"; ?>) {
            $("#" + return_receipt_label + "outlet_fields").show();
        } else {
            $("#" + return_receipt_label + "selected_return_from").show();
        }
    });

    function sendReturnReceipt(form) {

        var data = $("#return-receipt-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable2()});

        if ($("#btn_save2, #btn_add_item, #btn_print2").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/Returns/create'); ?>',
                data: data,
                dataType: "json",
                beforeSend: function(data) {
                    $("#btn_save2, #btn_add_item, #btn_print2").attr("disabled", "disabled");
                    if (form == headers) {
                        $('#btn_save2').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting Form...');
                    } else if (form == print) {
                        $('#btn_print2').html('<i class="fa fa-print"></i>&nbsp; Loading...');
                    }
                },
                success: function(data) {
                    validateForm2(data);
                },
                error: function(data) {
                    alert("Error occured: Please try again.");
                    $("#btn_save2, #btn_add_item, #btn_print2").attr('disabled', false);
                    $('#btn_save2').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                    $('#btn_print2').html('<i class="fa fa-print"></i>&nbsp; Print');
                }
            });
        }
    }

    function validateForm2(data) {

        var e = $(".error");
        for (var i = 0; i < e.length; i++) {
            var $element = $(e[i]);

            $element.data("title", "")
                    .removeClass("error")
                    .tooltip("destroy");
        }

        if (data.success === true) {

            if (data.form == headers) {

                growlAlert(data.type, data.message);
            } else if (data.form == details) {

                transaction_table2.fnAddData([
                    '<input type="checkbox" name="transaction_row2[]" onclick="showDeleteRowBtn()"/>',
                    data.details.sku_id,
                    data.details.sku_code,
                    data.details.sku_description,
                    data.details.brand_name,
                    data.details.unit_price,
                    data.details.batch_no,
                    data.details.expiration_date,
                    data.details.quantity_issued,
                    data.details.returned_quantity,
                    data.details.uom_id,
                    data.details.uom_name,
                    data.details.sku_status_id,
                    data.details.sku_status_name,
                    data.details.amount,
                    data.details.remarks
                ]);

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#ReturnReceipt_total_amount").val(parseFloat(total_amount).toFixed(2));

                growlAlert(data.type, data.message);

                $('#return-receipt-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.sku_uom_selected').html('');

            } else if (data.form == print && serializeTransactionTable2().length > 0) {
                printPDF(data.print);
            }

            sku_table.fnMultiFilter();
        } else {

            growlAlert(data.type, data.message);

            $("#btn_save2, #btn_add_item, #btn_print2").attr('disabled', false);
            $('#btn_save2').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
            $('#btn_print2').html('<i class="fa fa-print"></i>&nbsp; Print');

            var error_count = 0;
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

                error_count++;
            });
        }

        $("#btn_save2, #btn_add_item, #btn_print2").attr('disabled', false);
        $('#btn_save2').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
        $('#btn_print2').html('<i class="fa fa-print"></i>&nbsp; Print');
    }

   function serializeTransactionTable2() {

      var row_datas = new Array();
      var aTrs = transaction_table2.fnGetNodes();
      for (var i = 0; i < aTrs.length; i++) {
         var row_data = transaction_table2.fnGetData(aTrs[i]);

         row_datas.push({
            "sku_id": row_data[1],
            "unit_price": row_data[5],
            "batch_no": row_data[6],
            "expiration_date": row_data[7],
            "quantity_issued": row_data[8],
            "returned_quantity": row_data[9],
            "uom_id": row_data[10],
            "sku_status_id": row_data[12],
            "amount": row_data[14],
            "remarks": row_data[15],
         });
      }

      return row_datas;
   }

    function growlAlert(type, message) {
        $.growl(message, {
            icon: 'glyphicon glyphicon-info-sign',
            type: type
        });
    }

    $("#ReturnReceiptDetail_returned_quantity").keyup(function(e) {
        var unit_price = 0;
        if ($("#ReturnReceiptDetail_unit_price").val() != "") {
            var unit_price = $("#ReturnReceiptDetail_unit_price").val();
        }

        var amount = ($("#ReturnReceiptDetail_returned_quantity").val() * unit_price);
        $("#ReturnReceiptDetail_amount").val(parseFloat(amount).toFixed(2));
    });

    $("#ReturnReceiptDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#ReturnReceiptDetail_returned_quantity").val() != "") {
            var qty = $("#ReturnReceiptDetail_returned_quantity").val();
        }

        var amount = (qty * $("#ReturnReceiptDetail_unit_price").val());
        $("#ReturnReceiptDetail_amount").val(parseFloat(amount).toFixed(2));
    });

    $('#btn_save2').click(function() {
        if (!confirm('Are you sure you want to submit?'))
            return false;
        sendReturnReceipt(headers);
    });

    $('#btn_add_item').click(function() {
        sendReturnReceipt(details);
    });

    $(function() {
        $('#ReturnReceipt_transaction_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

    $('#' + return_receipt_label + 'selected_salesoffice').change(function() {
        loadSODetailByID(this.value, return_receipt_label);
    });

    $('#' + return_receipt_label + 'selected_salesman').change(function() {
        loadSalesmanDetailByID(this.value, return_receipt_label);
    });

    $('#' + return_receipt_label + 'selected_outlet').change(function() {
        loadPOIDetailsByID(this.value, return_receipt_label);
    });

</script>