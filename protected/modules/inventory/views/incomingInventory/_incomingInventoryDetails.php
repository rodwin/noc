<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'add-item-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'onsubmit' => "return false;",
        'onkeypress' => " if(event.keyCode == 13){} "
    ),
        ));
?>

<div class="col-md-6 clearfix">
    <div class="pull-left col-md-5">

        <?php echo $form->labelEx($sku, 'type'); ?><br/><br/>
        <?php echo $form->labelEx($sku, 'sub_type'); ?><br/><br/>
        <?php echo $form->labelEx($sku, 'brand_id'); ?><br/><br/>
        <?php echo $form->labelEx($sku, 'sku_code'); ?><br/><br/>
        <?php echo $form->labelEx($sku, 'description'); ?><br/><br/>

    </div>
    <div class="pull-right col-md-7">

        <?php echo $form->textFieldGroup($sku, 'type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

        <?php echo $form->textFieldGroup($sku, 'sub_type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

        <?php echo $form->textFieldGroup($sku, 'brand_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

        <?php echo $form->textFieldGroup($sku, 'sku_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true)), 'labelOptions' => array('label' => false))); ?>

        <?php
        echo $form->textAreaGroup(
                $sku, 'description', array(
            'wrapperHtmlOptions' => array(
                'class' => 'span5',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('style' => 'resize: none; width: 200px;', 'readonly' => true),
            ),
            'labelOptions' => array('label' => false)));
        ?>

        <?php echo $form->textFieldGroup($transaction_detail, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'style' => 'display: none;')), 'labelOptions' => array('label' => false))); ?>
    </div>
</div>

<div class="col-md-6">
    <div class="pull-left col-md-5">

        <?php echo $form->labelEx($transaction_detail, 'batch_no'); ?><br/><br/>
        <?php echo $form->labelEx($transaction_detail, 'expiration_date'); ?><br/><br/>
        <?php echo $form->labelEx($transaction_detail, 'uom_id'); ?><br/><br/>
        <?php echo $form->labelEx($transaction_detail, 'quantity_received'); ?><br/><br/>
        <?php echo $form->labelEx($transaction_detail, 'unit_price'); ?><br/><br/>
        <?php echo $form->labelEx($transaction_detail, 'amount'); ?><br/><br/>
        <?php echo $form->labelEx($transaction_detail, 'inventory_on_hand'); ?><br/><br/>
        <?php echo $form->labelEx($transaction_detail, 'remarks'); ?>

    </div>
    <div class="pull-right col-md-7">

        <?php echo $form->textFieldGroup($transaction_detail, 'batch_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50)), 'labelOptions' => array('label' => false))); ?>

        <?php echo $form->textFieldGroup($transaction_detail, 'expiration_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

        <?php
        echo $form->dropDownListGroup($transaction_detail, 'uom_id', array(
            'wrapperHtmlOptions' => array(
                'class' => 'span5',
            ),
            'widgetOptions' => array(
                'data' => $uom,
                'htmlOptions' => array('multiple' => false, 'prompt' => 'Select UOM', 'class' => 'span5 input-sm'),
            ),
            'labelOptions' => array('label' => false)));
        ?>

        <div class="span5">
            <?php
            echo $form->textFieldGroup($transaction_detail, 'quantity_received', array(
                'widgetOptions' => array(
                    'htmlOptions' => array("class" => "span5 input-sm", "onkeypress" => "return onlyNumbers(this, event, false)")
                ),
                'labelOptions' => array('label' => false),
                'append' => '<b class="sku_uom_selected"></b>'
            ));
            ?>
        </div>

        <div class="span5">
            <?php
            echo $form->textFieldGroup($transaction_detail, 'unit_price', array(
                'widgetOptions' => array(
                    'htmlOptions' => array("class" => "span5 input-sm", "onkeypress" => "return onlyNumbers(this, event, true)", 'value' => 0)
                ),
                'labelOptions' => array('label' => false),
                'prepend' => '&#8369',
                'append' => '<b class="sku_uom_selected"></b>'
            ));
            ?>
        </div>

        <?php echo $form->textFieldGroup($transaction_detail, 'amount', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 input-sm', 'maxlength' => 50, 'readonly' => true, 'value' => 0)), 'labelOptions' => array('label' => false))); ?>

        <div class="span5">
            <?php
            echo $form->textFieldGroup($transaction_detail, 'inventory_on_hand', array(
                'widgetOptions' => array(
                    'htmlOptions' => array("class" => "span5 input-sm", 'readonly' => true)
                ),
                'labelOptions' => array('label' => false),
                'append' => '<b class="sku_uom_selected"></b>'
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

    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function() {
        $("[data-mask]").inputmask();

        $('#IncomingInventoryDetail_expiration_date').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'
        });
    });

    function loadSkuDetails(sku_id) {

        $("#IncomingInventoryDetail_sku_id").val(sku_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/IncomingInventory/loadSkuDetails'); ?>',
            data: {"sku_id": sku_id},
            dataType: "json",
            success: function(data) {
                $("#Sku_type").val(data.sku_category);
                $("#Sku_sub_type").val(data.sku_sub_category);
                $("#Sku_brand_id").val(data.brand_name);
                $("#Sku_sku_code").val(data.sku_code);
                $("#Sku_description").val(data.sku_description);
                $("#IncomingInventoryDetail_unit_price").val(data.default_unit_price);
                $("#IncomingInventoryDetail_uom_id").val(data.sku_default_uom_id);
                $(".sku_uom_selected").html(data.sku_default_uom_name);
                $("#IncomingInventoryDetail_inventory_on_hand").val(data.inventory_on_hand);

                $("#IncomingInventoryDetail_quantity_received").val(0);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

    $('#IncomingInventoryDetail_uom_id').change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/Uom/getUomByID'); ?>',
            data: {"uom_id": $("#IncomingInventoryDetail_uom_id").val()},
            dataType: "json",
            success: function(data) {
                $(".sku_uom_selected").html(data.uom_name);
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });

    });

    $("#IncomingInventoryDetail_quantity_received").keyup(function(e) {
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

</script>