
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
                <?php echo $form->labelEx($customer_item, 'name'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'dr_no'); ?>
            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($customer_item, 'name', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

                <?php
                echo $form->dropDownListGroup($customer_item, 'dr_no', array(
                    'wrapperHtmlOptions' => array(
                        'class' => '',
                    ),
                    'widgetOptions' => array(
                        'data' => array(),
                        'htmlOptions' => array('class' => 'ignore span5', 'multiple' => false, 'prompt' => 'Select DR No'),
                    ),
                    'labelOptions' => array('label' => false)));
                ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">
                <?php echo $form->labelEx($customer_item, 'transaction_date'); ?>
            </div>
            <div class="pull-right col-md-7">
                <?php echo $form->textFieldGroup($customer_item, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <h4 class="control-label text-primary"><b><?php echo Sku::SKU_LABEL; ?> Information</b></h4>

        <div class="col-md-6 clearfix">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($customer_item, 'pr_no'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'source_zone_id'); ?>

            </div>

            <div class="pull-right col-md-7">

                <?php echo $form->textFieldGroup($customer_item, 'pr_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'maxlength' => 10, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

                <?php echo CHtml::textField('source_zone_id', '', array('id' => 'CustomerItem_source_zone_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "Source Zone", 'readonly' => true)); ?>
                <?php echo $form->textFieldGroup($customer_item, 'source_zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'CustomerItem_source_zone', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

            </div>

        </div>

        <div class="col-md-6">
            <div id="input_label" class="pull-left col-md-5">

                <?php echo $form->labelEx($customer_item, 'poi_id'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'plan_delivery_date'); ?><br/>
                <?php echo $form->labelEx($customer_item, 'revised_delivery_date'); ?>

            </div>
            <div class="pull-right col-md-7">

                <?php echo CHtml::textField('poi_id', '', array('id' => 'CustomerItem_poi_id', 'class' => 'ignore typeahead form-control span5', 'placeholder' => "POI")); ?>
                <?php echo $form->textFieldGroup($customer_item, 'poi_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'CustomerItem_poi', 'class' => 'ignore span5', 'maxlength' => 50, "style" => "display: none;")), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'plan_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                <?php echo $form->textFieldGroup($customer_item, 'revised_delivery_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'ignore span5', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

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
                        <th><?php echo $skuFields['description']; ?></th>
                        <th><?php echo $skuFields['brand_id']; ?></th>
                        <th><?php echo $incomingDetailFields['unit_price']; ?></th>
                        <th><?php echo $incomingDetailFields['batch_no']; ?></th>
                        <th class="hide_row">Source Zone ID</th>
                        <th><?php echo $incomingDetailFields['source_zone_id']; ?></th>
                        <th><?php echo $incomingDetailFields['expiration_date']; ?></th>
                        <th><?php echo $incomingDetailFields['planned_quantity']; ?></th>
                        <th><?php echo $incomingDetailFields['quantity_received']; ?></th>
                        <th><?php echo $incomingDetailFields['amount']; ?></th>
                        <th><?php echo $incomingDetailFields['inventory_on_hand']; ?></th>
                        <th><?php echo $incomingDetailFields['return_date']; ?></th>
                        <th class="hide_row"><?php echo $incomingDetailFields['remarks']; ?></th>
                        <th class="hide_row">Inventory</th>
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
                <button class="btn btn-default" onclick=""><i class="fa fa-print"></i> Print</button>
                <button id="btn-upload" class="btn btn-primary pull-right"><i class="fa fa-fw fa-upload"></i> Upload</button>
                <button id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-fw fa-check"></i> Save</button>  
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>    
</div>

<script type="text/javascript">

    var transaction_table;
    var headers = "transaction";
    var details = "details";
    var total_amount = 0;
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

    $(function() {
        $('#CustomerItem_transaction_date, #CustomerItem_plan_delivery_date, #CustomerItem_revised_delivery_date, #CustomerItemDetail_expiration_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'});
    });

</script>