
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
                <?php echo $form->labelEx($customer_item, 'dr_no'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'rra_no'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'rra_date'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'poi_id'); ?><br/>
                <?php echo $form->label($customer_item, 'Outlet Code'); ?><br/>
                <?php echo $form->label($customer_item, 'Address'); ?>
            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($customer_item, 'dr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50, "readonly" => true)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'rra_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'rra_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->select2Group(
                        $customer_item, 'poi_id', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '', 'id' => 'CustomerItem_poi_id',
                    ),
                    'widgetOptions' => array(
                        'data' => $poi_list,
                        'options' => array(
                        ),
                        'htmlOptions' => array('class' => 'ignore span5', 'prompt' => '--')),
                    'labelOptions' => array('label' => false)));
                ?>

                <?php // echo CHtml::textField('poi_id', '', array('id' => 'CustomerItem_poi_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Outlet")); ?>
                <?php // echo $form->textFieldGroup($customer_item, 'poi_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'CustomerItem_poi', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                <div id="CustomerItem_poi_primary_code" class="autofill_text"></div>
                <div id="CustomerItem_poi_address1" class="autofill_text" style="height: auto;"></div>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($customer_item, 'transaction_date'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'plan_delivery_date'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'salesman'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'remarks'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($customer_item, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('salesman_id', '', array('id' => 'CustomerItem_salesman_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Salesman", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldGroup($customer_item, 'salesman_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'CustomerItem_salesman', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

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

                <?php echo $form->textFieldGroup($customer_item, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

            </div>
        </div>

        <div class="clearfix"></div>

        <div id="inventory_bg" class="panel panel-default col-md-12 no-padding">
            <div class="panel-body" style="padding-top: 10px;">
                <h4 class="control-label text-primary pull-left"><b>Select Inventory</b></h4>
                <!--<button class="btn btn-default btn-sm pull-right" onclick="inventory_table.fnMultiFilter();">Reload Table</button>-->

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
                                <th><?php echo $invFields['brand_name']; ?></th>
                                <th><?php echo $invFields['sales_office_name']; ?></th>
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

                                    <?php echo $form->textFieldGroup($transaction_detail, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>
                                    <?php echo $form->textFieldGroup($transaction_detail, 'inventory_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="input_label" class="pull-left col-md-5"> 
                        <?php echo $form->labelEx($transaction_detail, 'source_zone_id'); ?><br/>
                        <?php echo $form->labelEx($transaction_detail, 'inventory_on_hand'); ?>
                    </div>
                    <div class="pull-right col-md-7">

                        <?php echo CHtml::textField('source_zone', '', array('id' => 'CustomerItemDetail_source_zone_id', 'class' => 'typeahead form-control span5', 'placeholder' => "Source Zone", 'readonly' => true)); ?>
                        <?php echo $form->textFieldGroup($transaction_detail, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array("id" => "CustomerItemDetail_source_zone", 'class' => 'span5', "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

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
                        <?php echo $form->labelEx($sku, 'planned_quantity'); ?><br/>
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

        <?php $customerItemFields = CustomerItemDetail::model()->attributeLabels(); ?>
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
                        <th><?php echo $customerItemFields['unit_price']; ?></th>
                        <th><?php echo $customerItemFields['batch_no']; ?></th>
                        <th><?php echo $customerItemFields['expiration_date']; ?></th>
                        <th><?php echo $customerItemFields['planned_quantity']; ?></th>
                        <th><?php echo $customerItemFields['quantity_issued']; ?></th>
                        <th class="hide_row"><?php echo $customerItemFields['uom_id']; ?></th>
                        <th class="hide_row"><?php echo $customerItemFields['uom_id']; ?></th>
                        <th class="hide_row"><?php echo $customerItemFields['sku_status_id']; ?></th>
                        <th class="hide_row"><?php echo $customerItemFields['sku_status_id']; ?></th>
                        <th><?php echo $customerItemFields['amount']; ?></th>
                        <th class="hide_row"><?php echo $customerItemFields['remarks']; ?></th>
                        <th class="hide_row"><?php echo $customerItemFields['return_date']; ?></th>
                        <th class="hide_row">Inventory</th>
                        <th class="hide_row"><?php echo $customerItemFields['source_zone_id']; ?></th>
                        <th class="hide_row"><?php echo $customerItemFields['source_zone_id']; ?></th>
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

                         if(file_upload_count == 0) { $("#tbl tbody tr").remove(); loadToView(); }
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
    var inventory_table;
    var item_details_table;
    var headers = "transaction";
    var details = "details";
    var print = "print";
    var total_amount = 0;
    var reference_DRNo;
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
                loadInventoryDetails("");
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
                    "targets": [1, 10, 11, 12, 13, 15, 16, 17, 18, 19],
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
    var success_customer_item_id, success_type, success_message;
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

//                document.forms["customer-item-form"].reset();
//                $('#customer-item-form .autofill_text').html('');
//                $("#customer-item-form .select2-container").select2("val", "");

                success_customer_item_id = data.customer_item_id;
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
                    data.details.quantity_issued,
                    data.details.uom_id,
                    "",
                    data.details.sku_status_id,
                    "",
                    data.details.amount,
                    data.details.remarks,
                    data.details.return_date,
                    data.details.inventory_id,
                    data.details.source_zone_id,
                    data.details.source_zone_name,
                ]);

                total_amount = (parseFloat(total_amount) + parseFloat(data.details.amount));
                $("#CustomerItem_total_amount").val(parseFloat(total_amount).toFixed(2));

                growlAlert(data.type, data.message);

                $('#customer-item-form select:not(.ignore), input:not(.ignore), textarea:not(.ignore)').val('');
                $('.inventory_uom_selected').html('');

            } else if (data.form == print && serializeTransactionTable().length > 0) {
                printPDF(data.print);
            }

            inventory_table.fnMultiFilter();
        } else {

            growlAlert(data.type, data.message);

            $("#btn_save, #btn_add_item, #btn_print").attr('disabled', false);
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
                "uom_id": row_data[10],
                "sku_status_id": row_data[12],
                "amount": row_data[14],
                "remarks": row_data[15],
//                "inventory_on_hand": row_data[13],
                "return_date": row_data[16],
                "inventory_id": row_data[17],
                "source_zone_id": row_data[18],
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
                $("#CustomerItemDetail_source_zone").val(data.source_zone_id);
                $("#CustomerItemDetail_source_zone_id").val(data.source_zone_name);
                $("#CustomerItemDetail_unit_price").val(data.unit_price);
                $(".inventory_uom_selected").html(data.inventory_uom_selected);
                $("#CustomerItemDetail_inventory_on_hand").val(data.inventory_on_hand);
                $("#CustomerItemDetail_batch_no").val(data.reference_no);
                $("#CustomerItemDetail_expiration_date").val(data.expiration_date);
                $("#CustomerItemDetail_uom_id").val(data.uom_id);
                $("#CustomerItemDetail_sku_status_id").val(data.sku_status_id);
                $("#CustomerItemDetail_planned_quantity, #CustomerItemDetail_quantity_issued, #CustomerItemDetail_amount").val("");
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
        $("#CustomerItemDetail_amount").val(parseFloat(amount).toFixed(2));
    });

    $("#CustomerItemDetail_unit_price").keyup(function(e) {
        var qty = 0;
        if ($("#CustomerItemDetail_quantity_issued").val() != "") {
            var qty = $("#CustomerItemDetail_quantity_issued").val();
        }

        var amount = (qty * $("#CustomerItemDetail_unit_price").val());
        $("#CustomerItemDetail_amount").val(parseFloat(amount).toFixed(2));
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
                total_amount = (parseFloat(total_amount) - parseFloat(row_data[14]));
                $("#CustomerItem_total_amount").val(parseFloat(total_amount).toFixed(2));

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
        $('#CustomerItem_transaction_date, #CustomerItem_rra_date, #CustomerItem_plan_delivery_date, #CustomerItemDetail_expiration_date, #CustomerItemDetail_return_date').datepicker({
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

    $('#CustomerItem_poi_id').change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/poi/getPOIDetails'); ?>' + '&poi_id=' + this.value,
            dataType: "json",
            success: function(data) {
                $("#CustomerItem_poi_primary_code").html(data.primary_code);
                $("#CustomerItem_poi_address1").html(data.address1);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    });

    function loadToView() {

        window.location = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/customerItem') . '"' ?> + "/view&id=" + success_customer_item_id;

        growlAlert(success_type, success_message);
    }

</script>