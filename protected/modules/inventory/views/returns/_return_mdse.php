
<?php $return_mdse_label = str_replace(" ", "_", ReturnMdse::RETURN_MDSE_LABEL) . "_"; ?>

<style type="text/css">
    .<?php echo $return_mdse_label; ?>autofill_text { height: 30px; margin-top: 20px; margin-bottom: 20px; width: 200px; }
</style>

<style type="text/css">
    #inventory_bg {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

    #inventory_table tbody tr { cursor: pointer }
</style>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'return-mdse-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'onsubmit' => "return false;",
        'onkeypress' => " if(event.keyCode == 13) {} "
    ),));
?>

<div class="clearfix">
    <div class="col-md-6">
        <div id="input_label" class="pull-left col-md-5">

            <?php echo $form->labelEx($return_mdse, 'return_mdse_no'); ?><br/>
            <?php echo $form->labelEx($return_mdse, 'return_to'); ?>

        </div>

        <div class="pull-right col-md-7">

            <?php echo $form->textFieldGroup($return_mdse, 'return_mdse_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

            <?php
            echo $form->select2Group(
                    $return_mdse, 'return_to', array(
                'wrapperHtmlOptions' => array(
                    'class' => '', 'id' => 'ReturnMdse_return_to',
                ),
                'widgetOptions' => array(
                    'data' => $return_to_list,
                    'options' => array(),
                    'htmlOptions' => array('class' => 'ignore span5', 'prompt' => '--')),
                'labelOptions' => array('label' => false)));
            ?>

        </div>

        <div class="clearfix"></div>        

        <div class="well clearfix" style="padding-left: 0px!important; padding-right: 0px!important;">
            <div id="<?php echo $return_mdse_label; ?>selected_return_to"><i class="text-muted"><center>Not Set</center></i></div>

            <div id="<?php echo $return_mdse_label; ?>supplier_fields" class="<?php echo $return_mdse_label; ?>return_destination" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($return_mdse, "Supplier"); ?><br/>
                    <?php echo $form->label($return_mdse, "Supplier Code"); ?><br/>
                    <?php echo $form->label($return_mdse, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php echo CHtml::textField($return_mdse_label . 'selected_supplier', '', array('class' => 'form-control span5 ignore ' . $return_mdse_label . 'return_to_select', "placeholder" => "Select Supplier")); ?> 

                    <div id="<?php echo $return_mdse_label; ?>supplier_code" class="<?php echo $return_mdse_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $return_mdse_label; ?>supplier_address1" class="<?php echo $return_mdse_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>

            <div id="<?php echo $return_mdse_label; ?>sales_office_fields" class="<?php echo $return_mdse_label; ?>return_destination" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($return_mdse, "Salesoffice"); ?><br/>
                    <?php echo $form->label($return_mdse, "Salesoffice Code"); ?><br/>
                    <?php echo $form->label($return_mdse, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => $return_mdse_label . 'selected_salesoffice',
                        'data' => $salesoffice_list,
                        'htmlOptions' => array(
                            'class' => 'span5 ignore ' . $return_mdse_label . 'return_to_select',
                            'prompt' => '--'
                        ),
                    ));
                    ?>

                    <div id="<?php echo $return_mdse_label; ?>salesoffice_code" class="<?php echo $return_mdse_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $return_mdse_label; ?>salesoffice_address1" class="<?php echo $return_mdse_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>

            <div id="<?php echo $return_mdse_label; ?>warehouse_fields" class="<?php echo $return_mdse_label; ?>return_destination" style="display: none;">
                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->label($return_mdse, "Warehouse"); ?><br/>
                    <?php echo $form->label($return_mdse, "Warehouse Code"); ?><br/>
                    <?php echo $form->label($return_mdse, "Address"); ?>
                </div>

                <div class="pull-right col-md-7">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => $return_mdse_label . 'selected_warehouse',
                        'data' => $warehouse_list,
                        'htmlOptions' => array(
                            'class' => 'span5 ignore ' . $return_mdse_label . 'return_to_select',
                            'prompt' => '--'
                        ),
                    ));
                    ?>

                    <div id="<?php echo $return_mdse_label; ?>warehouse_code" class="<?php echo $return_mdse_label; ?>autofill_text span5"><?php echo $not_set; ?></div>
                    <div id="<?php echo $return_mdse_label; ?>warehouse_address1" class="<?php echo $return_mdse_label; ?>autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
                </div>

            </div>

        </div>

        <div class="clearfix"></div>
    </div>

    <div class="col-md-6">
        <div id="input_label" class="pull-left col-md-5">

            <?php echo $form->labelEx($return_mdse, 'transaction_date'); ?><br/>
            <?php echo $form->labelEx($return_mdse, 'reference_dr_no'); ?><br/>
            <?php echo $form->labelEx($return_mdse, 'remarks'); ?>

        </div>

        <div class="pull-right col-md-7">

            <?php echo $form->textFieldGroup($return_mdse, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

            <?php echo $form->textFieldGroup($return_mdse, 'reference_dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'placeholder' => 'DR No')), 'labelOptions' => array('label' => false))); ?>

            <?php
            echo $form->textAreaGroup($return_mdse, 'remarks', array(
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

    <div id="inventory_bg" class="panel panel-default col-md-12 no-padding">    
        <div class="panel-body" style="padding-top: 10px;">
            <h4 class="control-label text-primary pull-left"><b>Select Inventory</b></h4>

            <?php $skuFields = Sku::model()->attributeLabels(); ?>
            <?php $invFields = Inventory::model()->attributeLabels(); ?>

            <div class="table-responsive">
                <table id="inventory_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $skuFields['sku_code']; ?></th>
                            <th><?php echo $skuFields['description']; ?></th>
                            <th><?php echo $invFields['qty']; ?></th>
                            <th class="hide_row"><?php echo $invFields['uom_id']; ?></th>
                            <th class="hide_row">Action Qty <i class="fa fa-fw fa-info-circle" data-toggle="popover" content="And here's some amazing content. It's very engaging. right?"></i></th>
                            <th><?php echo $invFields['zone_id']; ?></th>
                            <th class="hide_row"><?php echo $invFields['sku_status_id']; ?></th>
                            <th><?php echo $invFields['po_no']; ?></th>
                            <th><?php echo $invFields['pr_no']; ?></th>
                            <th><?php echo $invFields['pr_date']; ?></th>
                            <th><?php echo $invFields['plan_arrival_date']; ?></th>
                            <th><?php echo $invFields['reference_no']; ?></th>
                            <th><?php echo $invFields['expiration_date']; ?></th>
                            <th><?php echo $skuFields['brand_id']; ?></th>
                            <th>Salesoffice</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr id="filter_row">
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter hide_row"></td>
                            <td class="filter hide_row"></td>
                            <td class="filter"></td>
                            <td class="filter hide_row"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter"></td>
                            <td class="filter" id="hide_textbox"></td>
                            <td class="filter" id="hide_textbox"></td>
                        </tr>
                    </thead>

                </table>
            </div><br/>

            <div class="col-md-6 clearfix">
                <div class="row panel panel-default no-padding">    
                    <div class="panel-body" style="padding-top: 20px;">

                        <div class="clearfix">
                            <div id="input_label" class="pull-left col-md-5">

                                <?php echo $form->labelEx($sku, 'type'); ?><br/>
                                <?php echo $form->labelEx($sku, 'sub_type'); ?><br/>
                                <?php echo $form->labelEx($sku, 'brand_id'); ?><br/>
                                <?php echo $form->labelEx($sku, 'sku_code'); ?><br/>
                                <?php echo $form->labelEx($sku, 'description'); ?>

                            </div>
                            <div class="pull-right col-md-7">

                                <?php echo $form->textFieldGroup($sku, 'type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                                <?php echo $form->textFieldGroup($sku, 'sub_type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                                <?php echo $form->textFieldGroup($sku, 'brand_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                                <?php echo $form->textFieldGroup($sku, 'sku_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                                <?php
                                echo $form->textAreaGroup($sku, 'description', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'span5',
                                    ),
                                    'widgetOptions' => array(
                                        'htmlOptions' => array('style' => 'resize: none; width: 200px;', 'readonly' => true),
                                    ),
                                    'labelOptions' => array('label' => false)));
                                ?>

                                <?php echo $form->textFieldGroup($return_mdse_detail, 'uom_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>
                                <?php echo $form->textFieldGroup($return_mdse_detail, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>
                                <?php echo $form->textFieldGroup($return_mdse_detail, 'inventory_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="input_label" class="pull-left col-md-5">
                    <?php echo $form->labelEx($return_mdse_detail, 'source_zone_id'); ?><br/>
                    <?php echo $form->label($return_mdse_detail, 'Inventory On Hand'); ?>
                </div>
                <div class="pull-right col-md-7">

                    <?php echo CHtml::textField('source_zone', '', array('id' => 'ReturnMdseDetail_source_zone_id', 'class' => 'typeahead form-control span5', 'placeholder' => "Source Zone", 'readonly' => true)); ?>
                    <?php echo $form->textFieldGroup($return_mdse_detail, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array("id" => "ReturnMdseDetail_source_zone", 'class' => 'span5', "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_mdse_detail, 'inventory_on_hand', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", 'readonly' => true)
                            ),
                            'labelOptions' => array('label' => false),
                            'append' => '<b class="inventory_uom_selected"></b>'
                        ));
                        ?>
                    </div>

                </div>
            </div>

            <div class="col-md-6 clearfix">
                <div id="input_label" class="pull-left col-md-5">

                    <?php echo $form->labelEx($return_mdse_detail, 'batch_no'); ?><br/>
                    <?php echo $form->labelEx($return_mdse_detail, 'expiration_date'); ?><br/>
                    <?php echo $form->labelEx($return_mdse_detail, 'returned_quantity'); ?><br/>
                    <?php echo $form->labelEx($return_mdse_detail, 'unit_price'); ?><br/>
                    <?php echo $form->labelEx($return_mdse_detail, 'amount'); ?><br/>
                    <?php echo $form->labelEx($return_mdse_detail, 'remarks'); ?>

                </div>
                <div class="pull-right col-md-7">

                    <?php echo $form->textFieldGroup($return_mdse_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                    <?php echo $form->textFieldGroup($return_mdse_detail, 'expiration_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_mdse_detail, 'returned_quantity', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", "onkeypress" => "return onlyNumbers(this, event, false)")
                            ),
                            'labelOptions' => array('label' => false),
                            'append' => '<b class="inventory_uom_selected"></b>'
                        ));
                        ?>
                    </div>

                    <div class="span5">
                        <?php
                        echo $form->textFieldGroup($return_mdse_detail, 'unit_price', array(
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
                        echo $form->textFieldGroup($return_mdse_detail, 'amount', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array("class" => "span5", 'readonly' => true)
                            ),
                            'labelOptions' => array('label' => false),
                            'prepend' => '&#8369'
                        ));
                        ?>
                    </div>

                    <?php
                    echo $form->textAreaGroup($return_mdse_detail, 'remarks', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'span5',
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('style' => 'resize: none; width: 200px;'),
                        ),
                        'labelOptions' => array('label' => false)));
                    ?>

                    <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-plus-circle"></i> Add Item', array('name' => 'add_item', 'class' => 'btn btn-primary btn-sm span5 submit_butt3', 'id' => 'btn_add_item3')); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $returnMdseDetailFields = ReturnMdseDetail::model()->attributeLabels(); ?>  
<h4 class="control-label text-primary"><b>Transaction Table</b></h4>

<div class="table-responsive x-scroll">            
    <table id="transaction_table3" class="table table-bordered ">
        <thead>
            <tr>
                <th style="text-align: center;"><button id="delete_row_btn3" class="btn btn-danger btn-sm" style="display: none;"><i class="fa fa-trash-o"></i></button></th>
                <th class="hide_row"><?php echo $skuFields['sku_id']; ?></th>
                <th><?php echo $skuFields['sku_code']; ?></th>
                <th><?php echo $skuFields['description']; ?></th>
                <th><?php echo $skuFields['brand_id']; ?></th>
                <th class="hide_row"><?php echo $returnMdseDetailFields['unit_price']; ?></th>
                <th><?php echo $returnMdseDetailFields['batch_no']; ?></th>
                <th><?php echo $returnMdseDetailFields['expiration_date']; ?></th>
                <th><?php echo $returnMdseDetailFields['returned_quantity']; ?></th>
                <th class="hide_row"><?php echo $returnMdseDetailFields['uom_id']; ?></th>
                <th><?php echo $returnMdseDetailFields['uom_id']; ?></th>
                <th class="hide_row"><?php echo $returnMdseDetailFields['sku_status_id']; ?></th>
                <th><?php echo $returnMdseDetailFields['amount']; ?></th>
                <th><?php echo $returnMdseDetailFields['remarks']; ?></th>
                <th class="hide_row">Inventory</th>
                <th class="hide_row"><?php echo $returnMdseDetailFields['source_zone_id']; ?></th>
            </tr>                                    
        </thead>
    </table>                            
</div>

<div class="pull-right col-md-4 row" style="margin-bottom: 10px; margin-top: 10px;">
    <?php echo $form->labelEx($return_mdse, 'total_amount', array("class" => "pull-left")); ?>
    <?php echo $form->textFieldGroup($return_mdse, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 pull-right', 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
</div>

<div class="clearfix row">
    <div class="col-xs-12">
        <button id="btn_print3" class="btn btn-default submit_butt3" onclick=""><i class="fa fa-print"></i> Print</button>
        <button id="btn_save3" class="btn btn-success pull-right submit_butt3" style=""><i class="glyphicon glyphicon-ok"></i> Save</button>  
    </div>
</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">

<?php $destination_arr = ReturnMdse::model()->getListReturnTo(); ?>

    var inventory_table;
    var transaction_table3;
    var headers = "transaction";
    var details = "details";
    var print = "print";
    var total_amount3 = 0;
    var return_mdse_type = <?php echo "'" . ReturnMdse::RETURN_MDSE_LABEL . "'"; ?>;
    var return_mdse_label = <?php echo "'" . $return_mdse_label . "'"; ?>;
    $(function() {
        $("[data-mask]").inputmask();

        inventory_table = $('#inventory_table').dataTable({
            "filter": true,
            "dom": '<"pull-right"i>t',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            'iDisplayLength': 3,
            "order": [[0, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/OutgoingInventory/invData'); ?>",
            "columns": [
                {"name": "sku_code", "data": "sku_code"},
                {"name": "sku_description", "data": "sku_description"},
                {"name": "qty", "data": "qty"},
                {"name": "uom_name", "data": "uom_name"},
                {"name": "action_qty", "data": "action_qty", 'sortable': false, "class": 'action_qty'},
                {"name": "zone_name", "data": "zone_name"},
                {"name": "sku_status_name", "data": "sku_status_name"},
                {"name": "po_no", "data": "po_no"},
                {"name": "pr_no", "data": "pr_no"},
                {"name": "pr_date", "data": "pr_date"},
                {"name": "plan_arrival_date", "data": "plan_arrival_date"},
                {"name": "reference_no", "data": "reference_no"},
                {"name": "expiration_date", "data": "expiration_date"},
                {"name": "brand_name", "data": "brand_name", 'sortable': false},
                {"name": "sales_office_name", "data": "sales_office_name", 'sortable': false},
                {"name": "links", "data": "links", 'sortable': false}
            ],
            "columnDefs": [{
                    "targets": [3, 4, 6, 15],
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
            $(this).html('<input type="text" class="form-control input-sm ignore" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#inventory_table thead input").keyup(function() {
            inventory_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        transaction_table3 = $('#transaction_table3').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "columnDefs": [{
                    "targets": [1, 5, 9, 11, 14, 15],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            }
        });

    });

    function loadInventoryDetails(inventory_id) {

        $("#ReturnMdseDetail_inventory_id").val(inventory_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/OutgoingInventory/loadInventoryDetails'); ?>',
            data: {"inventory_id": inventory_id},
            dataType: "json",
            success: function(data) {
                $("#Sku_type").val(data.sku_category);
                $("#Sku_sub_type").val(data.sku_sub_category);
                $("#Sku_brand_id").val(data.brand_name);
                $("#Sku_sku_code").val(data.sku_code);
                $("#Sku_description").val(data.sku_description);
                $("#ReturnMdseDetail_sku_id").val(data.sku_id);
                $("#ReturnMdseDetail_source_zone").val(data.source_zone_id);
                $("#ReturnMdseDetail_source_zone_id").val(data.source_zone_name);
                $("#ReturnMdseDetail_unit_price").val(data.unit_price);
                $(".inventory_uom_selected").html(data.inventory_uom_selected);
                $("#ReturnMdseDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#ReturnMdseDetail_batch_no").val(data.reference_no);
                $("#ReturnMdseDetail_expiration_date").val(data.expiration_date);
                $("#ReturnMdseDetail_uom_id").val(data.uom_id);
                $("#ReturnMdseDetail_sku_status_id").val(data.sku_status_id);
                $("#ReturnMdseDetail_planned_quantity, #ReturnMdseDetail_returned_quantity, #ReturnMdseDetail_amount").val("");
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function sendReturnMdse(form) {

        var data = $("#return-mdse-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable3()});

        if ($(".submit_butt3").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/Returns/create'); ?>',
                data: data,
                dataType: "json",
                beforeSend: function(data) {
                    $(".submit_butt3").attr("disabled", "disabled");
                    if (form == headers) {
                        $('#btn_save3').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting Form...');
                    } else if (form == print) {
                        $('#btn_print3').html('<i class="fa fa-print"></i>&nbsp; Loading...');
                    }
                },
                success: function(data) {
                    validateForm3(data);
                },
                error: function(data) {
                    alert("Error occured: Please try again.");
                    $(".submit_butt3").attr('disabled', false);
                    $('#btn_save3').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                    $('#btn_print3').html('<i class="fa fa-print"></i>&nbsp; Print');
                }
            });
        }
    }

    var file_upload_count = 0;
    var success_outgoing_inv_id, success_type, success_message;
    function validateForm3(data) {

        var e = $(".error");
        for (var i = 0; i < e.length; i++) {
            var $element = $(e[i]);

            $element.data("title", "")
                    .removeClass("error")
                    .tooltip("destroy");
        }

        if (data.success === true) {

            if (data.form == headers) {

                window.location = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/Returns') . '"' ?> + "/returnMdseView&id=" + data.return_mdse_id;

                growlAlert(data.type, data.message);

            } else if (data.form == details) {

                $('#transaction_table3').dataTable().fnAddData([
                    '<input type="checkbox" name="transaction_row3[]" onclick="showDeleteRowBtn2()"/>',
                    data.details.sku_id,
                    data.details.sku_code,
                    data.details.sku_description,
                    data.details.brand_name,
                    data.details.unit_price,
                    data.details.batch_no,
                    data.details.expiration_date,
                    data.details.returned_quantity,
                    data.details.uom_id,
                    data.details.uom_name,
                    data.details.sku_status_id,
                    data.details.amount,
                    data.details.remarks,
                    data.details.inventory_id,
                    data.details.source_zone_id,
                ]);

                total_amount3 = (parseFloat(total_amount3) + parseFloat(data.details.amount));
                $("#ReturnMdse_total_amount").val(parseFloat(total_amount3).toFixed(2));

                growlAlert(data.type, data.message);

                $('#return-mdse-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.inventory_uom_selected').html('');

            } else if (data.form == print && serializeTransactionTable3().length > 0) {
                printPDF(data.print);
            }

            inventory_table.fnMultiFilter();
        } else {

            growlAlert(data.type, data.message);

            $(".submit_butt3").attr('disabled', false);
            $('#btn_save3').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
            $('#btn_print3').html('<i class="fa fa-print"></i>&nbsp; Print');

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

        $(".submit_butt3").attr('disabled', false);
        $('#btn_save3').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
        $('#btn_print3').html('<i class="fa fa-print"></i>&nbsp; Print');
    }

    $('#btn_add_item3').click(function() {
        sendReturnMdse(details);
    });

    $('#btn_save3').click(function() {
        if (!confirm('Are you sure you want to submit?'))
            return false;
        sendReturnMdse(headers);
    });

    function serializeTransactionTable3() {

        var row_datas = new Array();
        var aTrs = transaction_table3.fnGetNodes();
        for (var i = 0; i < aTrs.length; i++) {
            var row_data = transaction_table3.fnGetData(aTrs[i]);

            row_datas.push({
                "sku_id": row_data[1],
                "unit_price": row_data[5],
                "batch_no": row_data[6],
                "expiration_date": row_data[7],
                "returned_quantity": row_data[8],
                "uom_id": row_data[9],
                "sku_status_id": row_data[11],
                "amount": row_data[12],
                "remarks": row_data[13],
                "inventory_id": row_data[14],
                "source_zone_id": row_data[15],
            });
        }

        return row_datas;
    }

    $("#ReturnMdseDetail_returned_quantity").keyup(function(e) {
        var unit_price = 0;
        if ($("#ReturnMdseDetail_unit_price").val() != "") {
            var unit_price = $("#ReturnMdseDetail_unit_price").val();
        }

        var amount = ($("#ReturnMdseDetail_returned_quantity").val() * unit_price);
        $("#ReturnMdseDetail_amount").val(parseFloat(amount).toFixed(2));
    });

    $("#ReturnMdseDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#ReturnMdseDetail_returned_quantity").val() != "") {
            var qty = $("#ReturnMdseDetail_returned_quantity").val();
        }

        var amount = (qty * $("#ReturnMdseDetail_unit_price").val());
        $("#ReturnMdseDetail_amount").val(parseFloat(amount).toFixed(2));
    });

    $("#delete_row_btn3").click(function() {
        deleteTransactionRow($(this), transaction_table3, total_amount3, $("#ReturnMdse_total_amount"));
    });

    function showDeleteRowBtn2() {
        var atLeastOneIsChecked = $("input[name='transaction_row3[]']").is(":checked");
        if (atLeastOneIsChecked === true) {
            $('#delete_row_btn3').fadeIn('slow');
        }
        if (atLeastOneIsChecked === false) {
            $('#delete_row_btn3').fadeOut('slow');
        }
    }

    $('#ReturnMdse_return_to').change(function() {

        var value = this.value;

        $("#" + return_mdse_label + "selected_return_to, ." + return_mdse_label + "return_destination").hide();
        $("." + return_mdse_label + "autofill_text").html(<?php echo $not_set; ?>);
        $("." + return_mdse_label + "return_to_select").select2("val", "");

        if (value == <?php echo "'" . $destination_arr[0]['value'] . "'"; ?>) {
            $("#" + return_mdse_label + "supplier_fields").show();
        } else if (value == <?php echo "'" . $destination_arr[1]['value'] . "'"; ?>) {
            $("#" + return_mdse_label + "sales_office_fields").show();
        } else if (value == <?php echo "'" . $destination_arr[2]['value'] . "'"; ?>) {
            $("#" + return_mdse_label + "warehouse_fields").show();
        } else {
            $("#" + return_mdse_label + "selected_return_to").show();
        }
    });

    $(function() {

        $("#" + return_mdse_label + "selected_supplier").select2({
            placeholder: 'Select a Supplier',
            allowClear: true,
            id: function(data) {
                return data.supplier_id;
            },
            ajax: {
                quietMillis: 10,
                cache: false,
                dataType: 'json',
                type: 'GET',
                url: '<?php echo Yii::app()->createUrl("library/supplier/select2FilterSupplier"); ?>',
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
            formatResult: FormatSupplierResult,
            formatSelection: FormatSupplierSelection,
            minimumInputLength: 1
        });

    });

    function FormatSupplierResult(item) {
        var markup = "";
        if (item.supplier_name !== undefined) {
            markup += "<option value='" + item.supplier_id + "'>" + item.supplier_name + "</option>";
        }
        return markup;
    }

    function FormatSupplierSelection(item) {
        return item.supplier_name;
    }

    $(function() {
        $('#ReturnMdse_transaction_date, #ReturnMdseDetail_expiration_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

    $('#' + return_mdse_label + 'selected_supplier').change(function() {
        loadSelect2SupplierDetailByID(this.value, return_mdse_label);
    });

    $('#' + return_mdse_label + 'selected_salesoffice').change(function() {
        loadSODetailByID(this.value, return_mdse_label);
    });

    $('#' + return_mdse_label + 'selected_warehouse').change(function() {
        loadWarehouseDetailByID(this.value, return_mdse_label);
    });

</script>