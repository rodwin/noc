
<?php
$this->breadcrumbs = array(
    OutgoingInventory::OUTGOING_LABEL . ' Inventories' => array('admin'),
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

    #transaction_table td { text-align:center; }
    #transaction_table td + td { text-align: left; }

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
        'id' => 'outgoing-inventory-form',
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

                <?php echo $form->labelEx($outgoing, 'rra_no'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'dr_no'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'destination_zone_id'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($outgoing, 'rra_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50, "value" => "")), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($outgoing, 'dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('destination_zone', '', array('id' => 'OutgoingInventory_destination_zone_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Zone")); ?>
                <?php echo $form->textFieldGroup($outgoing, 'destination_zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'OutgoingInventoryl_destination_zone', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($outgoing, 'transaction_date'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'contact_person'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'contact_no'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'address'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($outgoing, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($outgoing, 'contact_person', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($outgoing, 'contact_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($outgoing, 'address', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 200)), 'labelOptions' => array('label' => false))); ?>

            </div>
        </div>

        <div class="clearfix"></div>

        <h4 class="control-label text-primary"><b><?php echo Sku::SKU_LABEL; ?> Information</b></h4>

        <div class="col-md-6 clearfix">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($outgoing, 'campaign_no'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'pr_no'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'pr_date'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($outgoing, 'campaign_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50, "value" => "")), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($outgoing, 'pr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($outgoing, 'pr_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($outgoing, 'plan_delivery_date'); ?><br/>
                <?php echo $form->labelEx($outgoing, 'revised_delivery_date'); ?><br/>
                <?php // echo $form->labelEx($outgoing, 'actual_delivery_date'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($outgoing, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($outgoing, 'revised_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php // echo $form->textFieldGroup($outgoing, 'actual_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

            </div>
        </div>

        <div class="clearfix"></div><br/>

        <div id="inventory_bg" class="panel panel-default col-md-12 no-padding">    
            <div class="panel-body" style="padding-top: 10px;">
                <h4 class="control-label text-primary pull-left"><b>Select Inventory</b></h4>
                <button class="btn btn-default btn-sm pull-right" onclick="inventory_table.fnMultiFilter();">Reload Table</button>

                <?php $skuFields = Sku::model()->attributeLabels(); ?>
                <?php $invFields = Inventory::model()->attributeLabels(); ?>                    
                <div class="table-responsive">
                    <table id="inventory_table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo $skuFields['sku_code']; ?></th>
                                <th><?php echo $skuFields['description']; ?></th>
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
                                    'htmlOptions' => array("class" => "ignore span5", "onkeypress" => "return onlyNumbers(this, event, false)")
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
                        <?php echo $form->labelEx($transaction_detail, 'quantity_issued'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'unit_price'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'amount'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'return_date'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'remarks'); ?>

                    </div>
                    <div class="pull-right col-md-7">

                        <?php echo $form->textFieldGroup($transaction_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                        <?php echo CHtml::textField('source_zone', '', array('id' => 'OutgoingInventoryDetail_source_zone_id', 'class' => 'typeahead form-control span5', 'placeholder' => "Source Zone", 'readonly' => true)); ?>
                        <?php echo $form->textFieldGroup($transaction_detail, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array("id" => "OutgoingInventoryDetail_source_zone", 'class' => 'span5', "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                        <?php echo $form->textFieldGroup($transaction_detail, 'expiration_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                        <div class="span5">
                            <?php
                            echo $form->textFieldGroup($transaction_detail, 'quantity_issued', array(
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
                                    'htmlOptions' => array("class" => "span5", "onkeypress" => "return onlyNumbers(this, event, true)")
                                ),
                                'labelOptions' => array('label' => false),
                                'prepend' => '&#8369',
                                'append' => '<b class="inventory_uom_selected"></b>'
                            ));
                            ?>
                        </div>

                        <div class="span5">
                            <?php
                            echo $form->textFieldGroup($transaction_detail, 'amount', array(
                                'widgetOptions' => array(
                                    'htmlOptions' => array("class" => "span5", 'readonly' => true)
                                ),
                                'labelOptions' => array('label' => false),
                                'prepend' => '&#8369'
                            ));
                            ?>
                        </div>
                        
                        <?php echo $form->textFieldGroup($transaction_detail, 'return_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

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

        <?php $outgoingDetailFields = OutgoingInventoryDetail::model()->attributeLabels(); ?>
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
                        <th><?php echo $outgoingDetailFields['unit_price']; ?></th>
                        <th><?php echo $outgoingDetailFields['batch_no']; ?></th>
                        <th class="hide_row">Source Zone ID</th>
                        <th><?php echo $outgoingDetailFields['source_zone_id']; ?></th>
                        <th><?php echo $outgoingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $outgoingDetailFields['planned_quantity']; ?></th>
                        <th><?php echo $outgoingDetailFields['quantity_issued']; ?></th>
                        <th><?php echo $outgoingDetailFields['amount']; ?></th>
                        <th><?php echo $outgoingDetailFields['inventory_on_hand']; ?></th>
                        <th class=""><?php echo $outgoingDetailFields['return_date']; ?></th>
                        <th class="hide_row"><?php echo $outgoingDetailFields['remarks']; ?></th>
                        <th class="hide_row">Inventory</th>
                    </tr>                                    
                </thead>
            </table>                            
        </div>

        <div class="pull-right col-md-4 no-padding" style='margin-top: 10px;'>
            <?php echo $form->labelEx($outgoing, 'total_amount', array("class" => "pull-left")); ?>
            <?php echo $form->textFieldGroup($outgoing, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 pull-right', 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
        </div>

    </div>

    <div class="box-footer clearfix">

        <div class="row no-print">
            <div class="col-xs-12">
                <button class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn-upload" class="btn btn-primary pull-right"><i class="fa fa-fw fa-upload"></i> Upload RRA / DR</button>
                <button id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;">Save</button>  
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>
    <div id="upload">
        <?php
        $this->widget('booster.widgets.TbFileUpload', array(
            'url' => $this->createUrl('OutgoingInventory/uploadAttachment'),
            'model' => $model,
            'attribute' => 'file',
            'multiple' => true,
            'options' => array(
                'maxFileSize' => 2000000,
                'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png|pdf|doc|docx)$/i',
            ),
            'formView' => 'application.modules.inventory.views.outgoingInventory._form',
            'uploadView' => 'application.modules.inventory.views.outgoingInventory._upload',
            'downloadView' => 'application.modules.inventory.views.outgoingInventory._download',
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

<script type="text/javascript">

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
                {"name": "sku_description", "data": "sku_description"},
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
                    "targets": [1],
                    "visible": false
                }, {
                    "targets": [7],
                    "visible": false
                }, {
                    "targets": [15],
                    "visible": false
                }, {
                    "targets": [16],
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

        var data = $("#outgoing-inventory-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable()});

        if ($("#btn_save, #btn_add_item").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/OutgoingInventory/create'); ?>',
                data: data,
                dataType: "json",
                beforeSend: function(data) {
                    $("#btn_save, #btn_add_item").attr("disabled", "disabled");
                    if (form == headers) {
                        $('#btn_save').text('Submitting Form...');
                    }
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


                document.forms["outgoing-inventory-form"].reset();

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

                growlAlert(data.type, data.message);

            } else if (data.form == details) {

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
                    data.details.expiration_date,
                    data.details.planned_quantity,
                    data.details.quantity_issued,
                    data.details.amount,
                    data.details.inventory_on_hand,
                    data.details.return_date,
                    data.details.remarks,
                    data.details.inventory_id
                ]);

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#OutgoingInventory_total_amount").val(total_amount);

                growlAlert(data.type, data.message);

                $('#outgoing-inventory-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.inventory_uom_selected').html('');

//                $("#OutgoingInventoryDetail_quantity_issued, #OutgoingInventoryDetail_unit_price, #OutgoingInventoryDetail_amount").val(0);

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

    function loadInventoryDetails(inventory_id) {

        $("#OutgoingInventoryDetail_inventory_id").val(inventory_id);

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
                $("#OutgoingInventoryDetail_sku_id").val(data.sku_id);
                $("#OutgoingInventoryDetail_source_zone").val(data.source_zone_id);
                $("#OutgoingInventoryDetail_source_zone_id").val(data.source_zone_name);
                $("#OutgoingInventoryDetail_unit_price").val(data.unit_price);
                $(".inventory_uom_selected").html(data.inventory_uom_selected);
                $("#OutgoingInventoryDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#OutgoingInventoryDetail_batch_no").val(data.reference_no);
                $("#OutgoingInventoryDetail_expiration_date").val(data.expiration_date);
//                $("#OutgoingInventoryDetail_amount").val(0);
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
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[11]));
                $("#OutgoingInventory_total_amount").val(total_amount);

                transaction_table.fnDeleteRow(aTrs[i]);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('/inventory/OutgoingInventory/afterDeleteTransactionRow'); ?>' + '&inventory_id=' + row_data[16] + '&quantity=' + row_data[11],
                    success: function(data) {
                        inventory_table.fnMultiFilter();
                    },
                    error: function(data) {
                        alert("Error occured: Please try again.");
                    }
                });
            });
        }

        $("#delete_row_btn").hide();
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
                "quantity_issued": row_data[11],
                "amount": row_data[12],
                "inventory_on_hand": row_data[13],
                "return_date": row_data[14],
                "remarks": row_data[15],
                "inventory_id": row_data[16],
            });
        }

        return row_datas;
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

    $("#OutgoingInventoryDetail_quantity_issued").keyup(function(e) {
        var unit_price = 0;
        if ($("#OutgoingInventoryDetail_unit_price").val() != "") {
            var unit_price = $("#OutgoingInventoryDetail_unit_price").val();
        }

        var amount = ($("#OutgoingInventoryDetail_quantity_issued").val() * unit_price);
        $("#OutgoingInventoryDetail_amount").val(amount);
    });

    $("#OutgoingInventoryDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#OutgoingInventoryDetail_quantity_issued").val() != "") {
            var qty = $("#OutgoingInventoryDetail_quantity_issued").val();
        }

        var amount = (qty * $("#OutgoingInventoryDetail_unit_price").val());
        $("#OutgoingInventoryDetail_amount").val(amount);
    });

    $(function() {
        var zone = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('zone'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo Yii::app()->createUrl("library/zone/search", array('value' => '')) ?>',
            remote: '<?php echo Yii::app()->createUrl("library/zone/search") ?>&value=%QUERY'
        });

        zone.initialize();

        $('#OutgoingInventory_destination_zone_id').typeahead(null, {
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
            $("#OutgoingInventoryl_destination_zone").val(datum.zone_id);
        });

        jQuery('#OutgoingInventory_destination_zone_id').on('input', function() {
            var value = $("#OutgoingInventory_destination_zone_id").val();
            $("#OutgoingInventoryl_destination_zone").val(value);
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
        $('#OutgoingInventory_pr_date, #OutgoingInventory_plan_delivery_date, #OutgoingInventory_revised_delivery_date, #OutgoingInventory_actual_delivery_date, #OutgoingInventory_transaction_date, #OutgoingInventoryDetail_expiration_date, #OutgoingInventoryDetail_return_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

</script>