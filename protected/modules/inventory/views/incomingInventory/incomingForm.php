<?php
$this->breadcrumbs = array(
    IncomingInventory::INCOMING_LABEL . ' Inventories' => array('admin'),
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

<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.js" type="text/javascript"></script>

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

    #sku_table tbody tr { cursor: pointer }

    #transaction_table td, th { text-align:center; }
    #transaction_table td + td, th + th { text-align: left; }

    .span5  { width: 200px; }

    .hide_row { display: none; }

    .inventory_uom_selected { width: 20px; }

    #input_label label { margin-bottom: 20px; padding: 5px; }

    #sku_bg {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

    #hide_textbox input {display:none;}

    .status-label { color: #fff; font-weight: bold; font-size: 12px; text-align: center; }

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
                <?php echo $form->labelEx($incoming, 'dr_no'); ?><br/>
                <?php echo $form->labelEx($incoming, 'dr_date'); ?><br/>
                <?php echo $form->labelEx($incoming, 'rra_no'); ?><br/>
                <?php echo $form->labelEx($incoming, 'rra_date'); ?><br/>
                <?php echo $form->labelEx($incoming, 'destination_zone_id'); ?>
            </div>

            <div class="pull-right col-md-7">

                <?php
//                echo $form->dropDownListGroup($incoming, 'dr_no', array(
//                    'wrapperHtmlOptions' => array(
//                        'class' => '',
//                    ),
//                    'widgetOptions' => array(
//                        'data' => $outgoing_inv_dr_nos,
//                        'htmlOptions' => array('class' => 'ignore span5', 'multiple' => false, 'prompt' => 'Select DR No'),
//                    ),
//                    'labelOptions' => array('label' => false)));
                ?>

                <?php
                echo $form->select2Group(
                        $incoming, 'dr_no', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '', 'id' => 'IncomingInventory_dr_no',
                    ),
                    'widgetOptions' => array(
                        'data' => $outgoing_inv_dr_nos,
                        'options' => array(),
                        'htmlOptions' => array('class' => 'ignore span5', 'id' => 'IncomingInventory_dr_no', 'prompt' => '--')),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo $form->textFieldGroup($incoming, 'dr_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'rra_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'rra_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->textAreaGroup($incoming, 'destination_zone_id', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'span5',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('id' => 'IncomingInventory_destination_zone_id', 'class' => 'ignore', 'style' => 'resize: none; width: 200px;', 'maxlength' => 150, 'readonly' => true),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php // echo CHtml::textField('destination_zone_id', '', array('id' => 'IncomingInventory_destination_zone_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Zone", 'readonly' => true)); ?>
                <?php echo $form->textFieldGroup($incoming, 'destination_zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'IncomingInventory_destination_zone', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">
                <?php echo $form->labelEx($incoming, 'transaction_date'); ?><br/>
                <?php echo $form->labelEx($incoming, 'plan_delivery_date'); ?><br/>
                <?php echo $form->labelEx($incoming, 'remarks'); ?>
            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($incoming, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($incoming, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->textAreaGroup($incoming, 'remarks', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'span5',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('class' => 'ignore', 'style' => 'resize: none; width: 200px;', 'maxlength' => 150),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo $form->textFieldGroup($incoming, 'outgoing_inventory_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'style' => "display: none;")), 'labelOptions' => array('label' => false))); ?>

            </div>
        </div>

        <div class="clearfix"></div><br/>

        <div id="sku_bg" class="panel panel-default col-md-12 no-padding">    
            <div class="panel-body" style="padding-top: 10px;">
                <h4 class="control-label text-primary pull-left"><b>Select <?php echo Sku::SKU_LABEL; ?> Product</b></h4>
                <!--<button class="btn btn-default btn-sm pull-right" onclick="sku_table.fnMultiFilter();">Reload Table</button>-->

                <?php $skuFields = Sku::model()->attributeLabels(); ?>
                <div class="table-responsive">
                    <table id="sku_table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo $skuFields['sku_code']; ?></th>
                                <th><?php echo $skuFields['description']; ?></th>
                                <th><?php echo $skuFields['brand_id']; ?></th>
                                <th>Brand Category</th>
                                <th><?php echo $skuFields['type']; ?></th>
                                <th><?php echo $skuFields['sub_type']; ?></th>
                                <th><?php echo $skuFields['default_unit_price']; ?></th>
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

                        <?php echo $form->labelEx($transaction_detail, 'batch_no'); ?><br/>
                        <?php // echo $form->labelEx($transaction_detail, 'uom_id'); ?>
                        <?php echo $form->labelEx($transaction_detail, 'planned_quantity'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'quantity_received'); ?><br/>
                        <?php echo $form->label($transaction_detail, 'Inventory On Hand'); ?>
                        <?php // echo $form->labelEx($transaction_detail, 'sku_status_id'); ?>

                    </div>
                    <div class="pull-right col-md-7">

                        <?php echo $form->textFieldGroup($transaction_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                        <?php
                        echo $form->dropDownListGroup($transaction_detail, 'uom_id', array(
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
                            echo $form->textFieldGroup($transaction_detail, 'planned_quantity', array(
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
                            echo $form->textFieldGroup($transaction_detail, 'quantity_received', array(
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
                            echo $form->textFieldGroup($transaction_detail, 'inventory_on_hand', array(
                                'widgetOptions' => array(
                                    'htmlOptions' => array("class" => "span5", 'readonly' => true)
                                ),
                                'labelOptions' => array('label' => false),
                                'append' => '<b class="sku_uom_selected"></b>'
                            ));
                            ?>
                        </div>

                        <?php
                        echo $form->dropDownListGroup($transaction_detail, 'sku_status_id', array(
                            'wrapperHtmlOptions' => array(
                                'class' => '',
                            ),
                            'widgetOptions' => array(
                                'data' => $sku_status,
                                'htmlOptions' => array('class' => 'span5', 'multiple' => false, 'prompt' => 'Select ' . Sku::SKU_LABEL . ' Status', 'style' => 'display: none;'),
                            ),
                            'labelOptions' => array('label' => false)));
                        ?>

                        <?php echo $form->textFieldGroup($transaction_detail, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>
                    </div>
                </div>

                <div class="col-md-6 clearfix">
                    <div id="input_label" class="pull-left col-md-5">

                        <?php echo $form->labelEx($transaction_detail, 'expiration_date'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'unit_price'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'amount'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'remarks'); ?>

                    </div>
                    <div class="pull-right col-md-7">

                        <?php echo $form->textFieldGroup($transaction_detail, 'expiration_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                        <div class="span5">
                            <?php
                            echo $form->textFieldGroup($transaction_detail, 'unit_price', array(
                                'widgetOptions' => array(
                                    'htmlOptions' => array("class" => "span5", "onkeypress" => "return onlyNumbers(this, event, true)")
                                ),
                                'labelOptions' => array('label' => false),
                                'prepend' => '&#8369',
//                                'append' => '<b class="sku_uom_selected"></b>'
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

                        <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-plus-circle"></i> Add Item', array('name' => 'add_item', 'maxlength' => 150, 'class' => 'btn btn-primary btn-sm span5', 'id' => 'btn_add_item')); ?>

                    </div>
                </div>

            </div>
        </div>

        <div class="clearfix"></div>

        <?php $incomingDetailFields = IncomingInventoryDetail::model()->attributeLabels(); ?>
        <h4 class="control-label text-primary"><b>Transaction Table</b></h4>

        <div class="table-responsive">           
            <table id="transaction_table" class="table table-bordered">
                <thead>                         
                    <tr>
                        <th style="text-align: center;"><button id="delete_row_btn" class="btn btn-danger btn-sm" onclick="deleteTransactionRow()" style="display: none;"><i class="fa fa-trash-o"></i></button></th>
                        <th class="hide_row"><?php echo $skuFields['sku_id']; ?></th>
                        <th><?php echo $skuFields['sku_code']; ?></th>
                        <th><?php echo $skuFields['description']; ?></th>
                        <th><?php echo $skuFields['brand_id']; ?></th>
                        <th><?php echo $incomingDetailFields['unit_price']; ?></th>
                        <th><?php echo $incomingDetailFields['batch_no']; ?></th>
                        <th><?php echo $incomingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $incomingDetailFields['planned_quantity']; ?></th>
                        <th><?php echo $incomingDetailFields['quantity_received']; ?> <span title="Click green cell to edit" data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['uom_id']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['uom_id']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['sku_status_id']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['sku_status_id']; ?></th>
                        <th><?php echo $incomingDetailFields['amount']; ?></th>
                        <th><?php echo $incomingDetailFields['remarks']; ?> <span title="Click green cell to edit" data-toggle="tooltip" data-original-title=""><i class="fa fa-fw fa-info-circle"></i></span></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['return_date']; ?></th>
                        <th class="hide_row">Inventory</th>
                        <th class="hide_row"><?php echo $incomingDetailFields['source_zone_id']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['source_zone_id']; ?></th>
                        <th class="hide_row">Outgoing Inventory</th>
                        <th><?php echo $incomingDetailFields['status']; ?></th>
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
                <button id="btn_print" class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn-upload" class="btn btn-primary pull-right"><i class="fa fa-fw fa-upload"></i> Upload RRA / DR</button>
                <button id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="glyphicon glyphicon-ok"></i> Save</button>  
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
                'maxFileSize' => 5000000,
                'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png|pdf|doc|docx|xls|xlsx)$/i',
                'submit' => "js:function (e, data) {
              var inputs = data.context.find('.tagValues');
              data.formData = inputs.serializeArray();
              return true;
           }"
            ),
            'formView' => 'application.modules.inventory.views.incomingInventory._form',
            'uploadView' => 'application.modules.inventory.views.incomingInventory._upload',
            'downloadView' => 'application.modules.inventory.views.incomingInventory._download',
            'callbacks' => array(
                'done' => new CJavaScriptExpression(
                        'function(e, data) { 
                         file_upload_count--;
                         
                         if(file_upload_count == 0) {$("#tbl tr").remove(); loadToView(); }
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

    var transaction_table;
    var sku_table;
    var headers = "transaction";
    var details = "details";
    var print = "print";
    var total_amount = 0;
    $(function() {

        $("[data-mask]").inputmask();

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


        transaction_table = $('#transaction_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "columnDefs": [{
                    "targets": [1, 10, 11, 12, 13, 16, 17, 18, 19, 20],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                //                $('td:eq(8), td:eq(10)', nRow).addClass("success");

                var added_status_row_value = aData[21];
                var status_pos_col = 21;

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
    });

    var files = new Array();
    var ctr;
    function removebyID($id) {
        files.splice($id - 1, 1);
    }

    function selectchange(el) {

        var tag_textbox = $(el).closest("tr").find("input[name=tagname]");
        tag_textbox.val("");

        var selected = $(el).val();
        if (selected != "OTHERS") {
            tag_textbox.attr('disabled', true);
        }
        else {
            tag_textbox.attr('disabled', false);
        }

    }

    function send(form) {

        var data = $("#incoming-inventory-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable()});

        if ($("#btn_save, #btn_add_item, #btn_print").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/create'); ?>',
                data: data,
                dataType: "json",
                beforeSend: function(data) {
                    $("#btn_save, #btn_add_item, #btn_print").attr("disabled", "disabled");
                    if (form == headers) {
                        $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting Form...');
                    } else if (form == print) {
                        $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Loading...');
                    }
                },
                success: function(data) {
                    validateForm(data);
                },
                error: function(data) {
                    alert("Error occured: Please try again.");
                    $("#btn_save, #btn_add_item, #btn_print").attr('disabled', false);
                    $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
                    $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');
                }
            });
        }
    }

    var file_upload_count = 0;
    var success_incoming_inv_id, success_type, success_message;
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

                success_incoming_inv_id = data.incoming_inv_id;
                success_type = data.type;
                success_message = data.message;

                if (files != "") {
                    file_upload_count = files.length;

                    $('#uploading').click();
                } else {

                    loadToView();
                }

            } else if (data.form == details) {

                var addedRow = transaction_table.fnAddData([
                    '<input type="checkbox" name="transaction_row[]" onclick="showDeleteRowBtn()"/>',
                    data.details.sku_id,
                    data.details.sku_code,
                    data.details.sku_description,
                    data.details.brand_name,
                    data.details.unit_price,
                    data.details.batch_no,
                    data.details.expiration_date,
                    data.details.planned_quantity,
                    data.details.quantity_received,
                    data.details.uom_id,
                    "",
                    data.details.sku_status_id,
                    "",
                    data.details.amount,
                    data.details.remarks,
                    "",
                    "",
                    "",
                    "",
                    "",
                    data.details.status,
                ]);

                //                $.editable.addInputType('numberOnly', {
                //                    element: $.editable.types.text.element,
                //                    plugin: function(settings, original) {
                //                        $('input', this).bind('keypress', function(event) {
                //                            return onlyNumbers(this, event, false);
                //                        });
                //                    }
                //                });
                //
                //                var oSettings = transaction_table.fnSettings();
                //                $('td:eq(8)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                //                    var pos = transaction_table.fnGetPosition(this);
                //                    var rowData = transaction_table.fnGetData(pos);
                //                    var planned_qty = parseInt(rowData[8]);
                //                    var status_pos_col = 21;
                //
                //                    if (parseInt(value) == planned_qty) {
                //                        transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_COMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                //                    } else if (parseInt(value) < planned_qty) {
                //                        transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . "'"; ?>, pos[0], status_pos_col);
                //                    } else if (parseInt(value) > planned_qty) {
                //                        transaction_table.fnUpdate(<?php echo "'" . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . "'"; ?>, pos[0], status_pos_col);
                //                    }
                //
                //                    transaction_table.fnUpdate(value, pos[0], pos[2]);
                //
                //                }, {
                //                    type: 'numberOnly',
                //                    placeholder: '',
                //                    indicator: '',
                //                    tooltip: 'Click to edit',
                //                    submit: 'Ok',
                //                    width: "100%",
                //                    height: "30px"
                //                });
                //
                //                $('td:eq(10)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                //                    var pos = transaction_table.fnGetPosition(this);
                //                    transaction_table.fnUpdate(value, pos[0], pos[2]);
                //                }, {
                //                    type: 'text',
                //                    placeholder: '',
                //                    indicator: '',
                //                    tooltip: 'Click to edit',
                //                    width: "100%",
                //                    submit: 'Ok',
                //                    height: "30px"
                //                });

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#IncomingInventory_total_amount").val(parseFloat(total_amount).toFixed(2));

                growlAlert(data.type, data.message);

                $('#incoming-inventory-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.inventory_uom_selected').html('');

                //                $("#IncomingInventoryDetail_quantity_received, #IncomingInventoryDetail_unit_price, #IncomingInventoryDetail_amount").val(0);

            } else if (data.form == print && serializeTransactionTable().length > 0) {
                printPDF(data.print);
            }

            sku_table.fnMultiFilter();
        } else {

            growlAlert(data.type, data.message);

            $("#btn_save, #btn_add_item").attr('disabled', false);
            $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
            $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');

            $.each(JSON.parse(data.error), function(i, v) {
                var element = document.getElementById(i);
                var element_select2 = document.getElementById("s2id_" + i);

                var $element = $(element);
                $element.data("title", v)
                        .addClass("error")
                        .tooltip();

                var $element_select2 = $(element_select2);
                $element_select2.data("title", v)
                        .addClass("error_border")
                        .tooltip();
            });
        }

        $("#btn_save, #btn_add_item, #btn_print").attr('disabled', false);
        $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
        $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');
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

            var status = aTrs[i].getElementsByTagName('span')[0].innerHTML;

            row_datas.push({
                "sku_id": row_data[1],
                "unit_price": row_data[5],
                "batch_no": row_data[6],
                "expiration_date": row_data[7],
                "planned_quantity": row_data[8],
                "quantity_received": row_data[9],
                "uom_id": row_data[10],
                "sku_status_id": row_data[12],
                "amount": row_data[14],
                "remarks": row_data[15],
                "return_date": row_data[16],
                "inventory_id": row_data[17],
                "source_zone_id": row_data[18],
                "outgoing_inventory_detail_id": row_data[20],
                "status": status,
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
                $("#IncomingInventoryDetail_expiration_date").val(data.expiration_date);
                $("#IncomingInventoryDetail_uom_id").val(data.uom_id);
                $("#IncomingInventoryDetail_sku_status_id").val(data.sku_status_id);
                //                $("#IncomingInventoryDetail_amount").val(0);
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

    $('#btn_print').click(function() {
        send(print);
    });

    $("#IncomingInventoryDetail_quantity_received").keyup(function(e) {
        var unit_price = 0;
        if ($("#IncomingInventoryDetail_unit_price").val() != "") {
            var unit_price = $("#IncomingInventoryDetail_unit_price").val();
        }

        var amount = ($("#IncomingInventoryDetail_quantity_received").val() * unit_price);
        $("#IncomingInventoryDetail_amount").val(parseFloat(amount).toFixed(2));
    });

    $("#IncomingInventoryDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#IncomingInventoryDetail_quantity_received").val() != "") {
            var qty = $("#IncomingInventoryDetail_quantity_received").val();
        }

        var amount = (qty * $("#IncomingInventoryDetail_unit_price").val());
        $("#IncomingInventoryDetail_amount").val(parseFloat(amount).toFixed(2));
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

                $("#IncomingInventory_rra_date").val(data.headers.rra_date);
                //                $("#IncomingInventory_campaign_no").val(data.headers.campaign_no);
                //                $("#IncomingInventory_pr_no").val(data.headers.pr_no);
                $("#IncomingInventory_dr_date").val(data.headers.dr_date);
                $("#IncomingInventory_rra_no").val(data.headers.rra_no);
                $("#IncomingInventory_source_zone_id").val(data.headers.source_zone_id);
                $("#IncomingInventory_destination_zone_id").val(data.headers.destination_zone_name);
                $("#IncomingInventory_destination_zone").val(data.headers.destination_zone_id);
                $("#IncomingInventory_plan_delivery_date").val(data.headers.plan_delivery_date);
                //                $("#IncomingInventory_plan_arrival_date").val(data.headers.plan_arrival_date);
                $("#IncomingInventory_outgoing_inventory_id").val(data.headers.outgoing_inventory_id);

                total_amount = 0;
                $("#IncomingInventory_total_amount").val(parseFloat(total_amount).toFixed(2));
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
                            v.expiration_date,
                            v.planned_quantity,
                            v.quantity_received,
                            v.uom_id,
                            "",
                            "",
                            "",
                            v.amount,
                            v.remarks,
                            v.return_date,
                            v.inventory_id,
                            v.source_zone_id,
                            "",
                            v.outgoing_inventory_detail_id,
                            v.status,
                        ]);

                        var nTr = transaction_table.fnSettings().aoData[addedRow[0]].nTr;
                        $('td:eq(8), td:eq(10)', nTr).addClass("success");

                        $.editable.addInputType('numberOnly', {
                            element: $.editable.types.text.element,
                            plugin: function(settings, original) {
                                $('input', this).bind('keypress', function(event) {
                                    return onlyNumbers(this, event, false);
                                });
                            }
                        });

                        var oSettings = transaction_table.fnSettings();
                        $('td:eq(8)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
                            var pos = transaction_table.fnGetPosition(this);
                            var rowData = transaction_table.fnGetData(pos);
                            var planned_qty = parseInt(rowData[8]);
                            var status_pos_col = 21;

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
                            //                            onblur: 'submit',
                            submit: 'Ok',
                            width: "100%",
                            height: "30px"
                        });

                        $('td:eq(10)', oSettings.aoData[addedRow[0]].nTr).editable(function(value, settings) {
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

                $("#IncomingInventory_total_amount").val(parseFloat(total_amount).toFixed(2));

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
        if (!confirm('Are you sure you want to delete selected item?'))
            return false;

        var aTrs = transaction_table.fnGetNodes();

        for (var i = 0; i < aTrs.length; i++) {
            $(aTrs[i]).find('input:checkbox:checked').each(function() {
                var row_data = transaction_table.fnGetData(aTrs[i]);
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[14]));
                $("#IncomingInventory_total_amount").val(parseFloat(total_amount).toFixed(2));

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
        $('#IncomingInventory_transaction_date, #IncomingInventory_dr_date, #IncomingInventory_pr_date, #IncomingInventory_plan_delivery_date, #IncomingInventory_revised_delivery_date, #IncomingInventory_rra_date, #IncomingInventoryDetail_expiration_date, #IncomingInventoryDetail_return_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

    function printPDF(data) {

        $.ajax({
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/IncomingInventory/print'); ?> ',
            type: 'POST',
            dataType: "json",
            data: {"post_data": data},
            success: function(data) {
                if (data.success === true) {
                    var params = [
                        'height=' + screen.height,
                        'width=' + screen.width,
                        'fullscreen=yes'
                    ].join(',');

                    var tab = window.open(<?php echo "'" . Yii::app()->createUrl($this->module->id . '/IncomingInventory/loadPDF') . "'" ?> + "&id=" + data.id, "_blank", params);

                    if (tab) {
                        tab.focus();
                        tab.moveTo(0, 0);
                    } else {
                        alert('Please allow popups for this site');
                    }
                }

                return false;
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function loadSkuDetails(sku_id) {

        $("#IncomingInventoryDetail_sku_id").val(sku_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ReceivingInventory/loadSkuDetails'); ?>',
            data: {"sku_id": sku_id},
            dataType: "json",
            success: function(data) {
                $("#IncomingInventoryDetail_unit_price").val(data.default_unit_price);
                $("#IncomingInventoryDetail_uom_id").val(data.sku_default_uom_id);
                $(".sku_uom_selected").html(data.sku_default_uom_name);
                $("#IncomingInventoryDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#IncomingInventoryDetail_planned_quantity, #IncomingInventoryDetail_quantity_received, #IncomingInventoryDetail_amount").val("");

                //                $("#Sku_type").val(data.sku_category);
                //                $("#Sku_sub_type").val(data.sku_sub_category);
                //                $("#Sku_brand_id").val(data.brand_name);
                //                $("#Sku_sku_code").val(data.sku_code);
                //                $("#Sku_description").val(data.sku_description);
                //                $("#IncomingInventoryDetail_sku_id").val(data.sku_id);
                //                $("#IncomingInventoryDetail_source_zone").val(data.source_zone_id);
                //                $("#IncomingInventoryDetail_source_zone_id").val(data.source_zone_name);
                //                $("#IncomingInventoryDetail_unit_price").val(data.unit_price);
                //                $(".inventory_uom_selected").html(data.inventory_uom_selected);
                //                $("#IncomingInventoryDetail_inventory_on_hand").val(data.inventory_on_hand);
                //                $("#IncomingInventoryDetail_batch_no").val(data.reference_no);
                //                $("#IncomingInventoryDetail_expiration_date").val(data.expiration_date);
                //                $("#IncomingInventoryDetail_uom_id").val(data.uom_id);
                //                $("#IncomingInventoryDetail_sku_status_id").val(data.sku_status_id);

                //                $("#ReceivingInventoryDetail_quantity_received, #ReceivingInventoryDetail_amount").val(0);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    function loadToView() {

        window.location = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/incomingInventory') . '"' ?> + "/view&id=" + success_incoming_inv_id;

        growlAlert(success_type, success_message);
    }

</script>