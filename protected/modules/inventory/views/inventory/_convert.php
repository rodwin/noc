
<style type="text/css">
    .form-group { width: 80%; }

    .modal-header h4 { font-weight: bolder; padding-left: 10px; }
</style>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-convert clearfix no-padding small-box">
            <h4 class="modal-title pull-left margin">Convert</h4>
            <button class="btn btn-sm btn-flat bg-convert pull-right margin" data-dismiss="modal"><i class="fa fa-times"></i></button>
        </div>  

        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'convert-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array(
                'onsubmit' => "return false;", /* Disable normal form submit */
                'onkeypress' => " if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
            ),
        ));
        ?>

        <div class="modal-body">

            <div class="well well-sm">
                <?php echo CHtml::hiddenField("ConvertInventoryForm[inventory_id]", $inventoryObj->inventory_id); ?>
                <dt class="text-convert">For this record</dt>

                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo Inventory::model()->getAttributeLabel('qty'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('uom.uom_name'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('sku.sku_name'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('zone.zone_name'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('reference_no'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('expiration_date'); ?></th>
                            <th><?php echo "Status"; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $inventoryObj->qty; ?></td>
                            <td><?php echo $inventoryObj->uom->uom_name; ?></td>
                            <td><?php echo $inventoryObj->sku->sku_name; ?></td>
                            <td><?php echo $inventoryObj->zone->zone_name; ?></td>
                            <td><?php echo $inventoryObj->reference_no; ?></td>
                            <td><?php echo $inventoryObj->expiration_date; ?></td>
                            <td><?php echo isset($inventoryObj->skuStatus->status_name) ? $inventoryObj->skuStatus->status_name : ""; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="ConvertInventoryForm_summaryError" class="alert alert-danger alert-dismissable no-margin" style="display: none; margin-bottom: 10px!important;">
                <b></b>
            </div>

            <div class="form-group">
                <script type="text/javascript">
                    $("#ConvertInventoryForm_qty").val(<?php echo $qty; ?>);
                </script>

                <?php
                echo $form->labelEx($model, 'qty', array('class' => 'text-convert'));
                echo $form->textFieldGroup(
                        $model, 'qty', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5', 'id' => 'ConvertInventoryForm_qty'
                    ),
                    'labelOptions' => array('label' => false),
                    'append' => $inventoryObj->uom->uom_name
                ));
                ?>
            </div>

            <dt class="text-convert">...into an equivalent quantity of:</dt>

            <div class="form-group clearfix">
                <div class="pull-left" style="width: 35%;">
                    <?php
                    echo $form->textFieldGroup(
                            $model, 'equivalent_qty', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5', 'placeholder' => 'hello',
                        ),
                        'labelOptions' => array('label' => false)
                    ));
                    ?>
                </div>

                <div class="pull-right" style="width: 65%;">
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'new_uom_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $uom,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Unit of Measure'),
                        ),
                        'labelOptions' => array('label' => false)
                    ));
                    ?>
                </div>
            </div>

            <dt class="text-convert">With these transaction details...</dt>

            <div class="form-group">
                <?php echo $form->textFieldGroup($model, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('id' => 'transaction_date_dp')))); ?> 
            </div>

        </div>

        <div class="modal-footer clearfix" style="padding-top: 10px; padding-bottom: 10px;">

            <div class="pull-left"> 
                <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-check"></i> Save', array('name' => 'save', 'class' => 'btn btn-primary', 'id' => 'btn_convert')); ?>
                <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-mail-reply"></i> Reset', array('class' => 'btn btn-primary', 'id' => 'btn_convert_form_reset')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>

<script type="text/javascript">

    function send() {

        var data = $("#convert-form").serialize();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/Inventory/convert'); ?>',
            data: data,
            dataType: "json",
            success: function(data) {

                if (data.success === true) {
                    $("#ConvertInventoryForm_summaryError").hide();
                    $('#myModal').modal('hide');
                    $.growl(data.message, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'success'
                    });
                    table.fnMultiFilter();
                } else if (data.success === false) {
                    $("#ConvertInventoryForm_summaryError").hide();
                    alert(data.message);
                }

                if (data.error.length > 0) {
                    $("#ConvertInventoryForm_summaryError b").html(data.error);
                    $('#ConvertInventoryForm_summaryError').show().delay(3000).fadeOut('slow');
                }

            },
            error: function(data) { // if error occured
                alert("Error occured: Please try again");
            },
        });

    }

    $('#btn_convert').click(function() {
        send();
    });

    $('#btn_convert_form_reset').click(function() {
        document.forms["convert-form"].reset();
    });

    $(function() {
        $('#transaction_date_dp').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'
        });
    });

</script>