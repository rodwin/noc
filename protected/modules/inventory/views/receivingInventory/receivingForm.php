<?php
$this->breadcrumbs = array(
    'Receiving Inventories' => array('admin'),
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

    #transaction_table td { text-align:center; }
    #transaction_table td + td { text-align: left; }

    .span5  { width: 200px; }
    .hide_row { display: none; }

    .sku_uom_selected { width: 20px; }

    #input_label label { margin-bottom: 20px; padding: 5px; }

    #sku_bg {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

</style>   

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"></h3>
    </div>

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'receiving-inventory-form',
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

                <?php echo $form->labelEx($receiving, 'campaign_no'); ?><br/>
                <?php echo $form->labelEx($receiving, 'pr_no'); ?><br/>
                <?php echo $form->labelEx($receiving, 'pr_date'); ?><br/>
                <?php echo $form->labelEx($receiving, 'requestor'); ?><br/>
                <?php echo $form->labelEx($receiving, 'plan_delivery_date'); ?><br/>
                <?php echo $form->labelEx($receiving, 'revised_delivery_date'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($receiving, 'campaign_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($receiving, 'pr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($receiving, 'pr_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->dropDownListGroup($receiving, 'requestor', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => $employee,
                        'htmlOptions' => array('class' => 'ignore span5', 'multiple' => false, 'prompt' => 'Select Requestor'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo $form->textFieldGroup($receiving, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($receiving, 'revised_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

            </div>
        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($receiving, 'transaction_date'); ?><br/>
                <?php echo $form->labelEx($receiving, 'dr_no'); ?><br/>
                <?php echo $form->labelEx($receiving, 'zone_id'); ?><br/>
                <?php echo $form->labelEx($receiving, 'plan_arrival_date'); ?><br/>
                <?php echo $form->labelEx($receiving, 'supplier_id'); ?><br/>
                <?php echo $form->labelEx($receiving, 'delivery_remarks'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($receiving, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($receiving, 'dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('zone_name', '', array('id' => 'ReceivingInventory_zone_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Zone")); ?>
                <?php echo $form->textFieldGroup($receiving, 'zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'receivingInventory_zone_id', 'class' => 'ignore span5', 'maxlength' => 50, 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($receiving, 'plan_arrival_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>
                
                <?php echo CHtml::textField('supplier_name', '', array('id' => 'ReceivingInventory_supplier_id', 'class' => 'ignore typeahead form-control span5', 'maxlength' => 50, 'placeholder' => "Supplier")); ?>
                <?php echo $form->textFieldGroup($receiving, 'supplier_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'ReceivingInventory_supplier', 'class' => 'ignore span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->dropDownListGroup($receiving, 'delivery_remarks', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => $delivery_remarks,
                        'htmlOptions' => array('class' => 'ignore span5', 'multiple' => false, 'prompt' => 'Select Delivery Remarks'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo $form->textFieldGroup($receiving, 'sales_office_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

            </div>
        </div>

        <div class="clearfix"></div><br/>

        <div id="sku_bg" class="panel panel-default col-md-12 no-padding">    
            <div class="panel-body" style="padding-top: 10px;">
                <h4 class="control-label text-primary pull-left"><b>Select <?php echo Sku::SKU_LABEL; ?> Product</b></h4>
                <!--<button class="btn btn-default btn-sm pull-right" onclick="sku_table.fnMultiFilter();">Reload Table</button>-->

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

                        <?php echo $form->labelEx($transaction_detail, 'batch_no'); ?><br/>
                        <?php // echo $form->labelEx($transaction_detail, 'uom_id'); ?>
                        <?php echo $form->labelEx($transaction_detail, 'planned_quantity'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'quantity_received'); ?><br/>
                        <?php // echo $form->labelEx($transaction_detail, 'sku_status_id'); ?>
                        <?php echo $form->label($transaction_detail,'Inventory On Hand'); ?>

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

        <?php $receivingDetailFields = ReceivingInventoryDetail::model()->attributeLabels(); ?>
        <h4 class="control-label text-primary"><b>Transaction Table</b></h4>

        <div class="table-responsive">            
            <table id="transaction_table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th style="text-align: center;"><button id="delete_row_btn" class="btn btn-danger btn-sm" onclick="deleteTransactionRow()" style="display: none;"><i class="fa fa-trash-o"></i></button></th>
                        <th class="hide_row"><?php echo $fields['sku_id']; ?></th>
                        <th><?php echo $fields['sku_code']; ?></th>
                        <th><?php echo $fields['description']; ?></th>
                        <th><?php echo $fields['brand_id']; ?></th>
                        <th><?php echo $receivingDetailFields['unit_price']; ?></th>
                        <th><?php echo $receivingDetailFields['batch_no']; ?></th>
                        <th><?php echo $receivingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $receivingDetailFields['planned_quantity']; ?></th>
                        <th><?php echo $receivingDetailFields['quantity_received']; ?></th>
                        <th class="hide_row"><?php echo $receivingDetailFields['uom_id']; ?></th>
                        <th class="hide_row"><?php echo $receivingDetailFields['uom_id']; ?></th>
                        <th class="hide_row"><?php echo $receivingDetailFields['sku_status_id']; ?></th>
                        <th class="hide_row"><?php echo $receivingDetailFields['sku_status_id']; ?></th>
                        <th><?php echo $receivingDetailFields['amount']; ?></th>
                        <!--<th class=""><?php // echo $receivingDetailFields['inventory_on_hand']; ?></th>-->
                        <th class="hide_row"><?php echo $receivingDetailFields['remarks']; ?></th>
                    </tr>                                    
                </thead>
            </table>                            
        </div>

        <div class="pull-right col-md-4 no-padding" style='margin-top: 10px;'>
            <?php echo $form->labelEx($receiving, 'total_amount', array("class" => "pull-left")); ?>
            <?php echo $form->textFieldGroup($receiving, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 pull-right', 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
        </div>

    </div>

    <div class="box-footer clearfix">

        <div class="row no-print">
            <div class="col-xs-12">
                <button class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn-upload" class="btn btn-primary pull-right"><i class="fa fa-fw fa-upload"></i> Upload PR / DR</button>
                <button id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="glyphicon glyphicon-ok"></i> Save</button>  
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>

    <div id="upload">
        <?php
        $this->widget('booster.widgets.TbFileUpload', array(
            'url' => $this->createUrl('ReceivingInventory/uploadAttachment'),
            'model' => $attachment,
            'attribute' => 'file',
            'multiple' => true,
            'options' => array(
                'maxFileSize' => 2000000,
                'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png|pdf|doc|docx)$/i',
            ),
            'formView' => 'application.modules.inventory.views.receivingInventory._form',
            'uploadView' => 'application.modules.inventory.views.receivingInventory._upload',
            'downloadView' => 'application.modules.inventory.views.receivingInventory._download',
            'callbacks' => array(
                'done' => new CJavaScriptExpression(
                        'function(e, data) { 
                         file_upload_count--;
                         console.log(file_upload_count);
                         
                         if(file_upload_count == 0) { $("#tbl tbody tr").remove(); }
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

    var sku_table;
    var transaction_table;
    var headers = "transaction";
    var details = "details";
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
                    "targets": [1,10, 11, 12, 13, 15],
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

        var data = $("#receiving-inventory-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable()});

        if ($("#btn_save, #btn_add_item, #btn_print").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/ReceivingInventory/create'); ?>',
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
    function validateForm(data) {

        var e = $(".error");
        for (var i = 0; i < e.length; i++) {
            var $element = $(e[i]);

            $element.data("title", "")
                    .removeClass("error")
                    .tooltip("destroy");

//            $(e[i]).removeClass('error');
        }

        if (data.success === true) {

            if (data.form == headers) {

                if (files != "") {
                    file_upload_count = files.length;

                    $('#uploading').click();
                }

                document.forms["receiving-inventory-form"].reset();

                var oSettings = transaction_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    transaction_table.fnDeleteRow(0, null, true);
                }

                growlAlert(data.type, data.message);

            } else if (data.form == details) {

                transaction_table.fnAddData([
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
                    data.details.uom_name,
                    data.details.sku_status_id,
                    data.details.sku_status_name,
                    data.details.amount,
//                    data.details.inventory_on_hand,
                    data.details.remarks
                ]);

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#ReceivingInventory_total_amount").val(total_amount);

                growlAlert(data.type, data.message);

                $('#receiving-inventory-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.sku_uom_selected').html('');

//                $("#ReceivingInventoryDetail_planned_quantity, #ReceivingInventoryDetail_quantity_received, #ReceivingInventoryDetail_unit_price, #ReceivingInventoryDetail_amount").val(0);

            }

            sku_table.fnMultiFilter();
        } else {

            if (data.form == headers) {
                growlAlert(data.type, data.message);
            }

            $("#btn_save, #btn_add_item, #btn_print").attr('disabled', false);
            $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
            $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');

            var error_count = 0;
            $.each(JSON.parse(data.error), function(i, v) {
                var element = document.getElementById(i);

                var $element = $(element);
                $element.data("title", v)
                        .addClass("error")
                        .tooltip();

//                element.classList.add("error");
                error_count++;
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
                "planned_quantity": row_data[8],
                "qty_received": row_data[9],
                "uom_id": row_data[10],
                "sku_status_id": row_data[12],
                "amount": row_data[14],
//                "inventory_on_hand": row_data[15],
                "remarks": row_data[15],
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
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[14]));
                $("#ReceivingInventory_total_amount").val(total_amount);

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

    function loadSkuDetails(sku_id) {

        $("#ReceivingInventoryDetail_sku_id").val(sku_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/ReceivingInventory/loadSkuDetails'); ?>',
            data: {"sku_id": sku_id},
            dataType: "json",
            success: function(data) {
                $("#ReceivingInventoryDetail_unit_price").val(data.default_unit_price);
                $("#ReceivingInventoryDetail_uom_id").val(data.sku_default_uom_id);
                $(".sku_uom_selected").html(data.sku_default_uom_name);
                $("#ReceivingInventoryDetail_inventory_on_hand").val(data.inventory_on_hand);
//                $("#ReceivingInventoryDetail_amount").val(0.00);
                $("#ReceivingInventoryDetail_planned_quantity, #ReceivingInventoryDetail_quantity_received, #ReceivingInventoryDetail_amount").val("");
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    $('#ReceivingInventoryDetail_uom_id').change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/Uom/getUomByID'); ?>',
            data: {"uom_id": $("#ReceivingInventoryDetail_uom_id").val()},
            dataType: "json",
            success: function(data) {
                $(".sku_uom_selected").html(data.uom_name);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    });

    $("#ReceivingInventoryDetail_quantity_received").keyup(function(e) {
        var unit_price = 0;
        if ($("#ReceivingInventoryDetail_unit_price").val() != "") {
            var unit_price = $("#ReceivingInventoryDetail_unit_price").val();
        }

        var amount = ($("#ReceivingInventoryDetail_quantity_received").val() * unit_price);
        $("#ReceivingInventoryDetail_amount").val(amount);
    });

    $("#ReceivingInventoryDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#ReceivingInventoryDetail_quantity_received").val() != "") {
            var qty = $("#ReceivingInventoryDetail_quantity_received").val();
        }

        var amount = (qty * $("#ReceivingInventoryDetail_unit_price").val());
        $("#ReceivingInventoryDetail_amount").val(amount);
    });

    $(function() {
        var zone = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('zone'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo Yii::app()->createUrl("library/zone/searchByWarehouse", array('value' => '')) ?>',
            remote: '<?php echo Yii::app()->createUrl("library/zone/searchByWarehouse") ?>&value=%QUERY'
        });

        zone.initialize();

        $('#ReceivingInventory_zone_id').typeahead(null, {
            name: 'zones',
            displayKey: 'zone_name',
            source: zone.ttAdapter(),
            templates: {
                suggestion: Handlebars.compile([
                    '<p class="repo-name">{{zone_name}}</p>',
                    '<p class="repo-description">{{sales_office_name}}</p>'
                ].join(''))
            }

        }).on('typeahead:selected', function(obj, datum) {
            $("#receivingInventory_zone_id").val(datum.zone_id);
            $("#ReceivingInventory_sales_office_id").val(datum.sales_office_id);
        });

        jQuery('#ReceivingInventory_zone_id').on('input', function() {
            $("#receivingInventory_zone_id, #ReceivingInventory_sales_office_id").val("");
        });
        
        var supplier = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('supplier'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo Yii::app()->createUrl("library/supplier/searchSupplier", array('value' => '')) ?>',
            remote: '<?php echo Yii::app()->createUrl("library/supplier/searchSupplier") ?>&value=%QUERY'
        });

        supplier.initialize();

        $('#ReceivingInventory_supplier_id').typeahead(null, {
            name: 'suppliers',
            displayKey: 'supplier_name',
            source: supplier.ttAdapter(),
            templates: {
                suggestion: Handlebars.compile([
                    '<p class="repo-name">{{supplier_name}}</p>',
                    '<p class="repo-description">{{supplier_code}}</p>'
                ].join(''))
            }

        }).on('typeahead:selected', function(obj, datum) {
            $("#ReceivingInventory_supplier").val(datum.supplier_id);
        });

        jQuery('#ReceivingInventory_supplier_id').on('input', function() {
            var value = $("#ReceivingInventory_supplier_id").val();
            $("#ReceivingInventory_supplier").val(value);
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
        $('#ReceivingInventory_pr_date, #ReceivingInventory_plan_delivery_date, #ReceivingInventory_revised_delivery_date, #ReceivingInventory_actual_delivery_date, #ReceivingInventory_plan_arrival_date, #ReceivingInventory_transaction_date, #ReceivingInventoryDetail_expiration_date, #ReceivingInventoryDetail_expiration_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'
        });
    });


    function printPDF(data) {

        $.ajax({
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/ReceivingInventory/print'); ?> ',
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

                    var tab = window.open(<?php echo "'" . Yii::app()->createUrl($this->module->id . '/ReceivingInventory/loadPDF') . "'" ?> + "&id=" + data.id, "_blank", params);

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

</script>