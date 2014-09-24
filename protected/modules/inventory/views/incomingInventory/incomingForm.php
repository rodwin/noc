<?php
$this->breadcrumbs = array(
    'Incoming Inventories' => array('admin'),
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
        width: auto;
        min-width: 200px;
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

    #transaction_table td, th { text-align:center; }
    #transaction_table td + td, th + th { text-align: left; }

    .span5  { width: 200px; }

    .hide_row { display: none; }

    .inventory_uom_selected { width: 20px; }

    #input_label label { margin-bottom: 20px; padding: 5px; }

    #inventory_bg {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

    #hide_textbox input {display:none;}

</style>  

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
            'onkeypress' => " if(event.keyCode == 13) {} "
        ),
    ));
    ?>

    <div class="box-body clearfix">

        <div class="col-md-6 clearfix">
            <div id="input_label" class="pull-left col-md-5">
                <?php echo $form->labelEx($incoming, 'name'); ?><br/>
                <?php echo $form->labelEx($incoming, 'dr_no'); ?>
            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($incoming, 'name', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->dropDownListGroup($incoming, 'dr_no', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => $outgoing_inv_dr_nos,
                        'htmlOptions' => array('class' => 'ignore span5', 'multiple' => false, 'prompt' => 'Select DR No'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">
                <?php echo $form->labelEx($incoming, 'transaction_date'); ?>
            </div>
            <div class="pull-right col-md-7">
                <?php echo $form->textFieldGroup($incoming, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <h4 class="control-label text-primary"><b><?php echo Sku::SKU_LABEL; ?> Information</b></h4>

        <div class="col-md-6 clearfix">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($incoming, 'campaign_no'); ?><br/>
                <?php echo $form->labelEx($incoming, 'pr_no'); ?><br/>
                <?php echo $form->labelEx($incoming, 'pr_date'); ?><br/>
                <?php echo $form->labelEx($incoming, 'zone_id'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($incoming, 'campaign_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'pr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'pr_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('zone_id', '', array('id' => 'IncomingInventory_zone_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Zone", 'readonly' => true)); ?>
                <?php echo $form->textFieldGroup($incoming, 'zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'IncomingInventory_zone', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($incoming, 'plan_delivery_date'); ?><br/>
                <?php echo $form->labelEx($incoming, 'revised_delivery_date'); ?><br/>
                <?php echo $form->labelEx($incoming, 'remarks'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($incoming, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'revised_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->textAreaGroup($incoming, 'remarks', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'span5',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('style' => 'resize: none; width: 200px;'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo $form->textFieldGroup($incoming, 'outgoing_inventory_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'style' => "display: none;")), 'labelOptions' => array('label' => false))); ?>
            </div>
        </div>

        <div class="clearfix"></div><br/>

        <div id="inventory_bg" class="panel panel-default col-md-12 no-padding">    
            <div class="panel-body" style="padding-top: 10px;">
                <h4 class="control-label text-primary pull-left"><b>Select Inventory</b></h4>
                <button class="btn btn-default btn-sm pull-right" onclick="inventory_table.fnMultiFilter();">Reload Table</button>

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
                            </tr>
                        </thead>

                    </table>
                </div><br/><br/><br/>

                <div class="col-md-6 clearfix">
                    <div class="panel panel-default no-padding">    
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

                                    <?php echo $form->textFieldGroup($transaction_detail, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>
                                    <?php echo $form->textFieldGroup($transaction_detail, 'inventory_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="input_label" class="pull-left col-md-5">
                        <?php echo $form->labelEx($sku, 'planned_quantity'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'inventory_on_hand'); ?>
                    </div>
                    <div class="pull-right col-md-7">

                        <div class="span5">
                            <?php
                            echo $form->textFieldGroup($transaction_detail, 'planned_quantity', array(
                                'widgetOptions' => array(
                                    'htmlOptions' => array("class" => "ignore span5", "onkeypress" => "return onlyNumbers(this, event, false)", "value" => 0)
                                ),
                                'labelOptions' => array('label' => false),
                                'append' => '<b class="inventory_uom_selected"></b>'
                            ));
                            ?>
                        </div>


                        <div class="span5">
                            <?php
                            echo $form->textFieldGroup($transaction_detail, 'inventory_on_hand', array(
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

                        <?php echo $form->labelEx($transaction_detail, 'batch_no'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'source_zone_id'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'expiration_date'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'quantity_received'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'unit_price'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'amount'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'remarks'); ?>

                    </div>
                    <div class="pull-right col-md-7">

                        <?php echo $form->textFieldGroup($transaction_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                        <?php echo CHtml::textField('source_zone', '', array('id' => 'IncomingInventoryDetail_source_zone_id', 'class' => 'typeahead form-control span5', 'placeholder' => "Source Zone", 'readonly' => true)); ?>
                        <?php echo $form->textFieldGroup($transaction_detail, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array("id" => "IncomingInventoryDetail_source_zone", 'class' => 'span5', "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                        <?php echo $form->textFieldGroup($transaction_detail, 'expiration_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                        <div class="span5">
                            <?php
                            echo $form->textFieldGroup($transaction_detail, 'quantity_received', array(
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
                            echo $form->textFieldGroup($transaction_detail, 'unit_price', array(
                                'widgetOptions' => array(
                                    'htmlOptions' => array("class" => "span5", 'value' => 0, "onkeypress" => "return onlyNumbers(this, event, true)")
                                ),
                                'labelOptions' => array('label' => false),
                                'append' => '<b class="inventory_uom_selected"></b>'
                            ));
                            ?>
                        </div>

                        <?php echo $form->textFieldGroup($transaction_detail, 'amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'readonly' => true, 'value' => 0)), 'labelOptions' => array('label' => false))); ?>

                        <?php
                        echo $form->textAreaGroup($transaction_detail, 'remarks', array(
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

            </div>
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
                        <th class="hide_row"><?php echo $skuFields['description']; ?></th>
                        <th class="hide_row"><?php echo $skuFields['brand_id']; ?></th>
                        <th><?php echo $incomingDetailFields['unit_price']; ?></th>
                        <th><?php echo $incomingDetailFields['batch_no']; ?></th>
                        <th class="hide_row">Source Zone ID</th>
                        <th class="hide_row"><?php echo $incomingDetailFields['source_zone_id']; ?></th>
                        <th><?php echo $incomingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $incomingDetailFields['planned_quantity']; ?></th>
                        <th><?php echo $incomingDetailFields['quantity_received']; ?></th>
                        <th><?php echo $incomingDetailFields['amount']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['inventory_on_hand']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['return_date']; ?></th>
                        <th><?php echo $incomingDetailFields['status']; ?></th>
                        <th><?php echo $incomingDetailFields['remarks']; ?></th>
                        <th class="hide_row">Inventory</th>
                        <th class="hide_row">Outgoing Inventory Detail</th>
                    </tr>                                    
                </thead>
            </table>                            
        </div>

        <div class="pull-right col-md-4 no-padding" style='margin-top: 10px;'>
            <?php echo $form->labelEx($incoming, 'total_amount', array("class" => "pull-left")); ?>
            <?php echo $form->textFieldGroup($incoming, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 pull-right', 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
        </div>

    </div>

    <div class="box-footer clearfix">

        <div class="row no-print">
            <div class="col-xs-12">
                <button class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn-upload" class="btn btn-primary pull-right"><i class="fa fa-fw fa-upload"></i> Upload</button>
                <button id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;">Save</button>  
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>   

    <div id="upload">
        <?php
        $this->widget('booster.widgets.TbFileUpload', array(
            'url' => $this->createUrl('IncomingInventory/uploadAttachment'),
            'model' => $model,
            'attribute' => 'file',
            'multiple' => true,
            'options' => array(
                'maxFileSize' => 2000000,
                'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png|pdf|doc|docx)$/i',
            ),
            'formView' => 'application.modules.inventory.views.incomingInventory._form',
            'uploadView' => 'application.modules.inventory.views.incomingInventory._upload',
            'downloadView' => 'application.modules.inventory.views.incomingInventory._download',
            'callbacks' => array(
                'done' => new CJavaScriptExpression(
                        'function(e, data) { 
                         file_upload_count--;
                         console.log(file_upload_count);
                         
                         if(file_upload_count == 0) {$("#tbl tr").remove();}
                     }'
                ),
                'fail' => new CJavaScriptExpression(
                        'function(e, data) { console.log("fail"); }'
                ),
        )));
        ?>
    </div>
</div>


<script type='text/javascript'>

    var inventory_table;
    var transaction_table;
    var headers = "transaction";
    var details = "details";
    var total_amount = 0;
    $(function() {

        $("[data-mask]").inputmask();

        inventory_table = $('#inventory_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t<"pull-left"i><"pull-right"p>',
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            'iDisplayLength': 5,
            "order": [[0, "asc"]],
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/OutgoingInventory/invData'); ?>",
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
                {"name": "sales_office_name", "data": "sales_office_name"}
            ],
            "columnDefs": [{
                    "targets": [4],
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
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
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
                    "targets": [1, 3, 4, 7, 8, 13, 14, 17, 18],
                    "visible": false
                }]
        });
    });

    var files = new Array();
    var ctr;
    function removebyID($id) {
        files.splice($id - 1, 1);
    }

    function send(form) {

        var data = $("#incoming-inventory-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable()});

        if ($("#btn_save, #btn_add_item").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/create'); ?>',
                data: data,
                dataType: "json",
                beforeSend: function(data) {
                    $("#btn_save, #btn_add_item").attr("disabled", "disabled");
                    $('#btn_save').text('Submitting Form...');
                },
                success: function(data) {
                    validateForm(data);
                },
                error: function(data) {
                    alert("Error occured: Please try again.");
                    $("#btn_save, #btn_add_item").attr('disabled', false);
                    $('#btn_save').text('Save');
                }
            });
        }
    }

    var file_upload_count = 0;
    function validateForm(data) {

        var e = $(".error");
        for (var i = 0; i < e.length; i++) {
            $(e[i]).removeClass('error');
        }

        if (data.success === true) {

            if (data.form == headers) {

                if (files != "") {
                    file_upload_count = files.length;

                    $('#uploading').click();
                }
                document.forms["incoming-inventory-form"].reset();

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

                growlAlert(data.type, data.message);

            } else if (data.form == details) {

                var addedRow = transaction_table.fnAddData([
                    '<input type="checkbox" name="transaction_row[]" onclick="showDeleteRowBtn()"/>',
                    data.details.sku_id,
                    data.details.sku_code,
                    data.details.sku_description,
                    data.details.brand_name,
                    data.details.unit_price,
                    data.details.batch_no,
                    data.details.source_zone_id,
                    data.details.source_zone_name,
                    data.details.expiration_date,
                    data.details.planned_quantity,
                    data.details.quantity_received,
                    data.details.amount,
                    data.details.inventory_on_hand,
                    data.details.return_date,
                    data.details.status,
                    data.details.remarks,
                    data.details.inventory_id,
                    data.details.outgoing_inventory_detail_id
                ]);

                var oSettings = transaction_table.fnSettings();
                $('td:eq(6), td:eq(9)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                    var pos = transaction_table.fnGetPosition(this);

                    transaction_table.fnUpdate(value, pos[0], pos[2]);
                }, {
                    placeholder: '',
                    indicator: '',
                    tooltip: 'Click to edit',
                    onblur: 'submit',
                    width: "100%",
                    height: "30px"
                });

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#IncomingInventory_total_amount").val(total_amount);

                growlAlert(data.type, data.message);

                $('#incoming-inventory-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.inventory_uom_selected').html('');

                $("#IncomingInventoryDetail_quantity_received, #IncomingInventoryDetail_unit_price, #IncomingInventoryDetail_amount").val(0);

            }

            inventory_table.fnMultiFilter();
        } else {

            growlAlert(data.type, data.message);

            $("#btn_save, #btn_add_item").attr('disabled', false);
            $('#btn_save').text('Save');

            $.each(JSON.parse(data.error), function(i, v) {
                var element = document.getElementById(i);
                element.classList.add("error");
            });
        }

        $("#btn_save, #btn_add_item").attr('disabled', false);
        $('#btn_save').text('Save');
    }

    function growlAlert(type, message) {
        $.growl(message, {
            icon: 'glyphicon glyphicon-info-sign',
            type: type
        });
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
                "source_zone_id": row_data[7],
                "expiration_date": row_data[9],
                "planned_quantity": row_data[10],
                "quantity_received": row_data[11],
                "amount": row_data[12],
                "inventory_on_hand": row_data[13],
                "return_date": row_data[14],
                "status": row_data[15],
                "remarks": row_data[16],
                "inventory_id": row_data[17],
                "outgoing_inventory_detail_id": row_data[18]
            });
        }

        return row_datas;
    }

    function loadInventoryDetails(inventory_id) {

        $("#IncomingInventoryDetail_inventory_id").val(inventory_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/loadInventoryDetails'); ?>',
            data: {"inventory_id": inventory_id},
            dataType: "json",
            success: function(data) {
                $("#Sku_type").val(data.sku_category);
                $("#Sku_sub_type").val(data.sku_sub_category);
                $("#Sku_brand_id").val(data.brand_name);
                $("#Sku_sku_code").val(data.sku_code);
                $("#Sku_description").val(data.sku_description);
                $("#IncomingInventoryDetail_sku_id").val(data.sku_id);
                $("#IncomingInventoryDetail_source_zone").val(data.source_zone_id);
                $("#IncomingInventoryDetail_source_zone_id").val(data.source_zone_name);
                $("#IncomingInventoryDetail_unit_price").val(data.unit_price);
                $(".inventory_uom_selected").html(data.inventory_uom_selected);
                $("#IncomingInventoryDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#IncomingInventoryDetail_batch_no").val(data.reference_no);
                $("#IncomingInventoryDetail_amount").val(0);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    $('#btn_save').click(function() {
        if (!confirm('Are you sure you want to submit?'))
            return false;
        send(headers);
    });

    $('#btn_add_item').click(function() {
        send(details);
    });

    $('#btn-upload').click(function() {
        $('#file_uploads').click();
    });

    $("#IncomingInventoryDetail_quantity_issued").keyup(function(e) {
        var unit_price = 0;
        if ($("#IncomingInventoryDetail_unit_price").val() != "") {
            var unit_price = $("#IncomingInventoryDetail_unit_price").val();
        }

        var amount = ($("#IncomingInventoryDetail_quantity_received").val() * unit_price);
        $("#IncomingInventoryDetail_amount").val(amount);
    });

    $("#IncomingInventoryDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#IncomingInventoryDetail_quantity_received").val() != "") {
            var qty = $("#IncomingInventoryDetail_quantity_received").val();
        }

        var amount = (qty * $("#IncomingInventoryDetail_unit_price").val());
        $("#IncomingInventoryDetail_amount").val(amount);
    });

    $('#IncomingInventory_dr_no').change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/loadAllOutgoingTransactionDetailsByDRNo'); ?>' + '&dr_no=' + this.value,
            dataType: "json",
            success: function(data) {

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

                $("#IncomingInventory_campaign_no").val(data.headers.campaign_no);
                $("#IncomingInventory_pr_no").val(data.headers.pr_no);
                $("#IncomingInventory_pr_date").val(data.headers.pr_date);
                $("#IncomingInventory_zone_id").val(data.headers.zone_name);
                $("#IncomingInventory_zone").val(data.headers.zone_id);
                $("#IncomingInventory_plan_delivery_date").val(data.headers.plan_delivery_date);
                $("#IncomingInventory_outgoing_inventory_id").val(data.headers.outgoing_inventory_id);

                total_amount = 0;
                $("#IncomingInventory_total_amount").val(total_amount);
                $('#delete_row_btn').fadeOut('slow');

                if (data.transaction_details.length > 0) {

                    $.each(data.transaction_details, function(i, v) {

                        total_amount = (parseFloat(total_amount) + parseFloat(v.amount));

                        var addedRow = transaction_table.fnAddData([
                            "",
                            v.sku_id,
                            v.sku_code,
                            v.sku_description,
                            v.brand_name,
                            v.unit_price,
                            v.batch_no,
                            v.source_zone_id,
                            v.source_zone_name,
                            v.expiration_date,
                            v.planned_quantity,
                            v.quantity_received,
                            v.amount,
                            v.inventory_on_hand,
                            v.return_date,
                            v.status,
                            v.remarks,
                            v.inventory_id,
                            v.outgoing_inventory_detail_id
                        ]);

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

                            if (value >= rowData[10]) {
                                transaction_table.fnUpdate("COMPLETE", pos[0], pos[2] + 4);
                            } else {
                                transaction_table.fnUpdate("INCOMPLETE", pos[0], pos[2] + 4);
                            }

                            transaction_table.fnUpdate(value, pos[0], pos[2]);

                        }, {
                            type: 'numberOnly',
                            placeholder: '',
                            indicator: '',
                            tooltip: 'Click to edit',
//                            onblur: 'submit',
                            submit: 'Ok',
                            width: "100%",
                            height: "30px"
                        });

                        $('td:eq(9)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                            var pos = transaction_table.fnGetPosition(this);
                            transaction_table.fnUpdate(value, pos[0], pos[2]);
                        }, {
                            type: 'text',
                            placeholder: '',
                            indicator: '',
                            tooltip: 'Click to edit',
                            width: "100%",
                            submit: 'Ok',
                            height: "30px"
                        });
                    });

                }

                $("#IncomingInventory_total_amount").val(total_amount);

            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    });

    function actualQtyRow(el, event, point, row) {

        var numberOnly = onlyNumbers(el, event, point);

        if (numberOnly === true) {
            return true;
        }
        return false;
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

    function deleteTransactionRow() {

        var aTrs = transaction_table.fnGetNodes();

        for (var i = 0; i < aTrs.length; i++) {
            $(aTrs[i]).find('input:checkbox:checked').each(function() {
                var row_data = transaction_table.fnGetData(aTrs[i]);
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[12]));
                $("#IncomingInventory_total_amount").val(total_amount);

                transaction_table.fnDeleteRow(aTrs[i]);
            });
        }

        $("#delete_row_btn").hide();
    }

    function onlyNumbers(txt, event, point) {

        var charCode = (event.which) ? event.which : event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || (point === true && charCode == 46)) {
            return true;
        }

        return false;
    }

    $(function() {
        $('#IncomingInventory_transaction_date, #IncomingInventory_pr_date, #IncomingInventory_plan_delivery_date, #IncomingInventory_revised_delivery_date, #IncomingInventoryDetail_expiration_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

</script>