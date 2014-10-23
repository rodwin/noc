
<?php
$this->breadcrumbs = array(
    CustomerItem::CUSTOMER_ITEM_LABEL . ' Inventories' => array('admin'),
    'Manage',
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
</style>

<style type="text/css">

    #item_details_table tbody tr { cursor: pointer }

    #transaction_table td, th { text-align:center; }
    #transaction_table td + td, th + th { text-align: left; }

    .span5  { width: 200px; }

    .hide_row { display: none; }

    .inventory_uom_selected { width: 20px; }

    #input_label label { margin-bottom: 20px; padding: 5px; }

    #item_details_bg {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

    #hide_textbox input {display:none;}

    .autofill_text { height: 30px; margin-top: 20px; margin-bottom: 20px; width: 200px; }
</style>

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"></h3>
    </div>

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'customer-item-form',
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
                <?php echo $form->labelEx($customer_item, 'reference_dr_no'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'rra_no'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'dr_no'); ?>
            </div>

            <div class="pull-right col-md-7">

                <?php
                echo $form->dropDownListGroup($customer_item, 'reference_dr_no', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => $reference_dr_nos,
                        'htmlOptions' => array('class' => 'ignore span5', 'multiple' => false, 'prompt' => 'Select Reference No', 'onchange' => 'referenceDRNoChange(this.value, false)'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php echo $form->textFieldGroup($customer_item, 'rra_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($customer_item, 'transaction_date'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'plan_delivery_date'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'revised_delivery_date'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($customer_item, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'revised_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

            </div>
        </div>

        <div class="clearfix"></div>

        <h4 class="control-label text-primary"><b><?php echo Sku::SKU_LABEL; ?> Information</b></h4>

        <div class="col-md-6 clearfix">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($customer_item, 'campaign_no'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'pr_no'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'pr_date'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'source_zone_id'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'salesman'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($customer_item, 'campaign_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'pr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'pr_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('source_zone_id', '', array('id' => 'CustomerItem_source_zone_id', 'class' => 'ignore form-control span5', 'placeholder' => "Source Zone", 'readonly' => true)); ?>
                <?php echo $form->textFieldGroup($customer_item, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'CustomerItem_source_zone', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('salesman_id', '', array('id' => 'CustomerItem_salesman_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Salesman", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldGroup($customer_item, 'salesman_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'CustomerItem_salesman', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($customer_item, 'poi_id'); ?><br/>
                <?php echo $form->label($customer_item, 'Outlet Code'); ?><br/>
                <?php echo $form->label($customer_item, 'Address'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'remarks'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo CHtml::textField('poi_id', '', array('id' => 'CustomerItem_poi_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Outlet")); ?>
                <?php echo $form->textFieldGroup($customer_item, 'poi_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'CustomerItem_poi', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                <div id="CustomerItem_poi_primary_code" class="autofill_text"></div>
                <div id="CustomerItem_poi_address1" class="autofill_text"></div>
                
                <?php
                echo $form->textAreaGroup($customer_item, 'remarks', array(
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

        <div class="clearfix"></div>

        <div id="item_details_bg" class="panel panel-default col-md-12 no-padding">
            <div class="panel-body" style="padding-top: 10px;">
                <h4 class="control-label text-primary pull-left"><b>Select Item</b></h4>

                <?php $skuFields = Sku::model()->attributeLabels(); ?>
                <?php $invFields = Inventory::model()->attributeLabels(); ?>

                <div class="table-responsive">
                    <table id="item_details_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="hide_row"><?php echo $invFields['inventory_id']; ?></th>
                                <th class="hide_row"><?php echo $skuFields['sku_id']; ?></th>
                                <th><?php echo $skuFields['sku_code']; ?></th>
                                <th><?php echo $skuFields['description']; ?></th>
                                <th><?php echo $skuFields['brand_id']; ?></th>
                                <th><?php echo $invFields['cost_per_unit']; ?></th>
                                <th>Inventory On Hand</th>
                                <th><?php echo $invFields['uom_id']; ?></th>
                                <th><?php echo $invFields['sku_status_id']; ?></th>
                                <th><?php echo $invFields['expiration_date']; ?></th>
                                <th><?php echo $invFields['reference_no']; ?></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr id="filter_row">
                                <td class="filter hide_row"></td>
                                <td class="filter hide_row"></td>
                                <td class="filter"></td>
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
                                    <?php echo $form->labelEx($sku, 'description'); ?><br/>
                                    <?php echo $form->labelEx($transaction_detail, 'uom_id'); ?><br/>
                                    <?php echo $form->labelEx($transaction_detail, 'sku_status_id'); ?>

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

                                    <?php
                                    echo $form->dropDownListGroup($transaction_detail, 'uom_id', array(
                                        'wrapperHtmlOptions' => array(
                                            'class' => 'span5',
                                        ),
                                        'widgetOptions' => array(
                                            'data' => $uom,
                                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select UOM', 'class' => 'span5'),
                                        ),
                                        'labelOptions' => array('label' => false)));
                                    ?>

                                    <?php
                                    echo $form->dropDownListGroup($transaction_detail, 'sku_status_id', array(
                                        'wrapperHtmlOptions' => array(
                                            'class' => '',
                                        ),
                                        'widgetOptions' => array(
                                            'data' => $sku_status,
                                            'htmlOptions' => array('class' => 'span5', 'multiple' => false, 'prompt' => 'Select ' . Sku::SKU_LABEL . ' Status'),
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
                        <?php echo $form->labelEx($transaction_detail, 'expiration_date'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'quantity_issued'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'unit_price'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'amount'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'return_date'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'remarks'); ?>

                    </div>
                    <div class="pull-right col-md-7">

                        <?php echo $form->textFieldGroup($transaction_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

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
//                                'append' => '<b class="inventory_uom_selected"></b>'
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

        <?php $incomingDetailFields = IncomingInventoryDetail::model()->attributeLabels(); ?>
        <h4 class="control-label text-primary"><b>Transaction Table</b></h4>

        <div class="table-responsive">
            <table id="transaction_table" class="table table-bordered">
                <thead>
                    <tr>
                        <th><button id="delete_row_btn" class="btn btn-danger btn-sm" onclick="deleteTransactionRow()" style="display: none;"><i class="fa fa-trash-o"></i></button></th>
                        <th class="hide_row"><?php echo $skuFields['sku_id']; ?></th>
                        <th><?php echo $skuFields['sku_code']; ?></th>
                        <th class="hide_row"><?php echo $skuFields['description']; ?></th>
                        <th class="hide_row"><?php echo $skuFields['brand_id']; ?></th>
                        <th><?php echo $incomingDetailFields['unit_price']; ?></th>
                        <th><?php echo $incomingDetailFields['batch_no']; ?></th>
                        <th><?php echo $incomingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $incomingDetailFields['planned_quantity']; ?></th>
                        <th><?php echo $incomingDetailFields['quantity_received']; ?></th>
                        <th><?php echo $incomingDetailFields['amount']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['inventory_on_hand']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['return_date']; ?></th>
                        <th><?php echo $incomingDetailFields['remarks']; ?></th>
                        <th class="hide_row">Inventory</th>
                        <th class="hide_row"><?php echo $incomingDetailFields['uom_id']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['sku_status_id']; ?></th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="pull-right col-md-4 no-padding" style='margin-top: 10px;'>
            <?php echo $form->labelEx($customer_item, 'total_amount', array("class" => "pull-left")); ?>
            <?php echo $form->textFieldGroup($customer_item, 'total_amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5 pull-right', 'value' => 0, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>
        </div>

    </div>

    <div class="box-footer clearfix">

        <div class="row no-print">
            <div class="col-xs-12">
                <button id="btn_print" class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn-upload" class="btn btn-primary pull-right"><i class="fa fa-fw fa-upload"></i> Upload DR</button>
                <button id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="glyphicon glyphicon-ok"></i> Save</button>
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>

    <div id="upload">
        <?php
        $this->widget('booster.widgets.TbFileUpload', array(
            'url' => $this->createUrl('CustomerItem/uploadAttachment'),
            'model' => $model,
            'attribute' => 'file',
            'multiple' => true,
            'options' => array(
                'maxFileSize' => 5000000,
                'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png|pdf|doc|docx|xls|xlsx)$/i',
            ),
            'formView' => 'application.modules.inventory.views.customerItem._form',
            'uploadView' => 'application.modules.inventory.views.customerItem._upload',
            'downloadView' => 'application.modules.inventory.views.customerItem._download',
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

    var transaction_table;
    var item_details_table;
    var headers = "transaction";
    var details = "details";
    var print = "print";
    var total_amount = 0;
    var reference_DRNo;
    $(function() {
        $("[data-mask]").inputmask();

        item_details_table = $('#item_details_table').dataTable({
            "filter": true,
            "dom": '<"text-center"r>t',
            "bSort": true,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            'iDisplayLength': 5,
            "columnDefs": [{
                    "targets": [0, 1],
                    "visible": false
                }]
        });

        var i = 0;
        $('#item_details_table thead tr#filter_row td.filter').each(function() {
            $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
            i++;
        });

        $("#item_details_table thead input").keyup(function() {
            item_details_table.fnFilter(this.value, $(this).attr("colPos"));
        });

        $('#item_details_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
                loadInventoryDetails("");
            }
            else {
                item_details_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
                var row_data = item_details_table.fnGetData(this);
                loadInventoryDetails(parseInt(row_data[0]));
            }
        });

        transaction_table = $('#transaction_table').dataTable({
            "filter": false,
            "dom": 't',
            "bSort": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false,
            "columnDefs": [{
                    "targets": [1, 3, 4, 11, 12, 14, 15, 16],
                    "visible": false
                }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            }
        });
    });

    var files = new Array();
    var ctr;
    function removebyID($id) {
        files.splice($id - 1, 1);
    }

    function send(form) {

        var data = $("#customer-item-form").serialize() + "&form=" + form + '&' + $.param({"transaction_details": serializeTransactionTable()});

        if ($("#btn_save, #btn_add_item, #btn_print").is("[disabled=disabled]")) {
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/inventory/CustomerItem/create'); ?>',
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
            $(e[i]).removeClass('error');
        }

        if (data.success === true) {

            if (data.form == headers) {

                if (files != "") {
                    file_upload_count = files.length;

                    $('#uploading').click();
                }

                document.forms["customer-item-form"].reset();
                $('#customer-item-form .autofill_text').html('');
                referenceDRNoChange(reference_DRNo, true);

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
                    data.details.expiration_date,
                    data.details.planned_quantity,
                    data.details.quantity_issued,
                    data.details.amount,
                    data.details.inventory_on_hand,
                    data.details.return_date,
                    data.details.remarks,
                    data.details.inventory_id,
                    data.details.uom_id,
                    data.details.sku_status_id
                ]);

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#CustomerItem_total_amount").val(total_amount);

                growlAlert(data.type, data.message);

                $('#customer-item-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.inventory_uom_selected').html('');

            } else if (data.form == print && serializeTransactionTable().length > 0) {
                printPDF(data.print);
            }

            $("#item_details_table tbody tr").removeClass('success');
        } else {

            growlAlert(data.type, data.message);

            $("#btn_save, #btn_add_item, #btn_print").attr('disabled', false);
            $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');
            $('#btn_print').html('<i class="fa fa-print"></i>&nbsp; Print');

            $.each(JSON.parse(data.error), function(i, v) {
                var element = document.getElementById(i);
                element.classList.add("error");
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

            row_datas.push({
                "sku_id": row_data[1],
                "unit_price": row_data[5],
                "batch_no": row_data[6],
                "expiration_date": row_data[7],
                "planned_quantity": row_data[8],
                "quantity_issued": row_data[9],
                "amount": row_data[10],
                "inventory_on_hand": row_data[11],
                "return_date": row_data[12],
                "remarks": row_data[13],
                "inventory_id": row_data[14],
                "outgoing_inventory_detail_id": row_data[15],
                "uom_id": row_data[16],
                "sku_status_id": row_data[17],
            });
        }

        return row_datas;
    }

    function loadInventoryDetails(inventory_id) {

        $("#CustomerItemDetail_inventory_id").val(inventory_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/CustomerItem/loadInventoryDetails'); ?>' + '&inventory_id=' + inventory_id,
            dataType: "json",
            success: function(data) {
                $("#Sku_type").val(data.sku_category);
                $("#Sku_sub_type").val(data.sku_sub_category);
                $("#Sku_brand_id").val(data.brand_name);
                $("#Sku_sku_code").val(data.sku_code);
                $("#Sku_description").val(data.sku_description);
                $("#CustomerItemDetail_sku_id").val(data.sku_id);
                $("#CustomerItemDetail_unit_price").val(data.unit_price);
                $(".inventory_uom_selected").html(data.inventory_uom_selected);
                $("#CustomerItemDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#CustomerItemDetail_batch_no").val(data.reference_no);
                $("#CustomerItemDetail_expiration_date").val(data.expiration_date);
                $("#CustomerItemDetail_uom_id").val(data.uom_id);
                $("#CustomerItemDetail_sku_status_id").val(data.sku_status_id);
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

    $("#CustomerItemDetail_quantity_issued").keyup(function(e) {
        var unit_price = 0;
        if ($("#CustomerItemDetail_unit_price").val() != "") {
            var unit_price = $("#CustomerItemDetail_unit_price").val();
        }

        var amount = ($("#CustomerItemDetail_quantity_issued").val() * unit_price);
        $("#CustomerItemDetail_amount").val(amount);
    });

    $("#CustomerItemDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#CustomerItemDetail_quantity_issued").val() != "") {
            var qty = $("#CustomerItemDetail_quantity_issued").val();
        }

        var amount = (qty * $("#CustomerItemDetail_unit_price").val());
        $("#CustomerItemDetail_amount").val(amount);
    });

    function referenceDRNoChange(reference_dr_no, reset) {
        reference_DRNo = reference_dr_no;

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/customerItem/loadTransactionByDRNo'); ?>' + '&dr_no=' + reference_dr_no,
            dataType: "json",
            success: function(data) {

                var oSettings = item_details_table.fnSettings();
                var iTotalRecords = oSettings.fnRecordsTotal();
                for (var i = 0; i <= iTotalRecords; i++) {
                    item_details_table.fnDeleteRow(0, null, true);
                }

                if (reset === false) {
                    $("#CustomerItem_rra_no").val(data.headers.rra_no);
                    $("#CustomerItem_campaign_no").val(data.headers.campaign_no);
                    $("#CustomerItem_pr_no").val(data.headers.pr_no);
                    $("#CustomerItem_source_zone").val(data.headers.source_zone_id);
                    $("#CustomerItem_source_zone_id").val(data.headers.source_zone_name);
                    $("#CustomerItem_pr_date").val(data.headers.pr_date);
                }

                $.each(data.data, function(i, v) {
                    item_details_table.fnAddData([
                        v.inventory_id,
                        v.sku_id,
                        v.sku_code,
                        v.sku_description,
                        v.brand_name,
                        v.cost_per_unit,
                        v.inventory_on_hand,
                        v.uom_name,
                        v.sku_status_name,
                        v.expiration_date,
                        v.reference_no
                    ]);
                });

            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    }

    $(function() {
        var outlet = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('outlet'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo Yii::app()->createUrl("library/poi/search", array('value' => '')) ?>',
            remote: '<?php echo Yii::app()->createUrl("library/poi/search") ?>&value=%QUERY'
        });

        outlet.initialize();

        $('#CustomerItem_poi_id').typeahead(null, {
            name: 'outlets',
            displayKey: 'short_name',
            source: outlet.ttAdapter(),
            templates: {
                suggestion: Handlebars.compile([
                    '<p class="repo-name">{{short_name}}</p>',
                    '<p class="repo-description">{{primary_code}}</p>'
                ].join(''))
            }

        }).on('typeahead:selected', function(obj, datum) {
            $("#CustomerItem_poi").val(datum.poi_id);
            $("#CustomerItem_poi_primary_code").html(datum.primary_code);
            $("#CustomerItem_poi_address1").html(datum.address1);
        });

        jQuery('#CustomerItem_poi_id').on('input', function() {
            var value = $("#CustomerItem_poi_id").val();
            $("#CustomerItem_poi").val(value);
            $("#CustomerItem_poi_primary_code, #CustomerItem_poi_address1").html("");
        });

        var salesman = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('outlet'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo Yii::app()->createUrl("library/employee/search", array('value' => '')) ?>',
            remote: '<?php echo Yii::app()->createUrl("library/employee/search") ?>&value=%QUERY'
        });

        salesman.initialize();

        $('#CustomerItem_salesman_id').typeahead(null, {
            name: 'salesmans',
            displayKey: 'fullname',
            source: salesman.ttAdapter(),
            templates: {
                suggestion: Handlebars.compile([
                    '<p class="repo-name">{{fullname}}</p>',
                    '<p class="repo-description">{{employee_code}}</p>'
                ].join(''))
            }

        }).on('typeahead:selected', function(obj, datum) {
            $("#CustomerItem_salesman").val(datum.employee_id);
        });

        jQuery('#CustomerItem_salesman_id').on('input', function() {
            var value = $("#CustomerItem_salesman_id").val();
            $("#CustomerItem_salesman").val(value);
        });
    });

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
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[10]));
                $("#CustomerItem_total_amount").val(total_amount);

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
        $('#CustomerItem_transaction_date, #CustomerItem_pr_date, #CustomerItem_plan_delivery_date, #CustomerItem_revised_delivery_date, #CustomerItemDetail_expiration_date, #CustomerItemDetail_return_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

    function printPDF(data) {

        $.ajax({
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/customerItem/print'); ?> ',
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

                    var tab = window.open(<?php echo "'" . Yii::app()->createUrl($this->module->id . '/customerItem/loadPDF') . "'" ?> + "&id=" + data.id, "_blank", params);

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