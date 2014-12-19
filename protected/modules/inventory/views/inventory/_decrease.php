
<style type="text/css">
    .form-group { width: 80%; }

    .modal-header h4 { font-weight: bolder; padding-left: 10px; }
</style>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-decrease clearfix no-padding small-box">
            <h4 class="modal-title pull-left margin">Decrease</h4>
            <button class="btn btn-sm btn-flat bg-decrease pull-right margin" data-dismiss="modal"><i class="fa fa-times"></i></button>
        </div>  

        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'decrease-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array(
                'onsubmit' => "return false;", /* Disable normal form submit */
                'onkeypress' => " if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
            ),
        ));
        ?>

        <div class="modal-body">

            <div class="well well-sm">
                <?php echo CHtml::hiddenField("DecreaseInventoryForm[inventory_id]", $inventoryObj->inventory_id) ?>
                <dt class="text-decrease">For this record</dt>

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

            <div id="DecreaseInventoryForm_summaryError" class="alert alert-danger alert-dismissable no-margin" style="display: none; margin-bottom: 10px!important;">
                <b></b>
            </div>

            <div class="form-group">
                <script type="text/javascript">
                    $("#DecreaseInventoryForm_qty").val(<?php echo $qty; ?>);
                </script>

                <?php
                echo $form->labelEx($model, 'qty', array('class' => 'text-decrease'));
                echo $form->textFieldGroup(
                        $model, 'qty', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5', 'id' => 'DecreaseInventoryForm_qty'
                    ),
                    'labelOptions' => array('label' => false),
                    'append' => $inventoryObj->uom->uom_name
                ));
                ?>
            </div>

            <dt class="text-decrease">With these transaction details...</dt>

            <div class="form-group">
                <?php echo $form->textFieldGroup($model, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('id' => 'transaction_date_dp')))); ?> 

                <?php
                echo $form->textAreaGroup($model, 'remarks', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'span5',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('class' => 'input-width', 'style' => 'resize: none;', 'maxlength' => 200),
                )));
                ?>
            </div>

        </div>

        <div class="modal-footer clearfix" style="padding-top: 10px; padding-bottom: 10px;">

            <div class="pull-left"> 
                <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-check"></i> Save', array('name' => 'save', 'class' => 'btn btn-primary', 'id' => 'btn_decrease')); ?>
                <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-mail-reply"></i> Reset', array('class' => 'btn btn-primary', 'id' => 'btn_decrease_form_reset')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>

<script type="text/javascript">

    function send() {

        var data = $("#decrease-form").serialize();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/Inventory/decrease'); ?>',
            data: data,
            dataType: "json",
            success: function(data) {

                if (data.success === true) {
                    $("#DecreaseInventoryForm_summaryError").hide();
                    $('#myModal').modal('hide');
                    $.growl(data.message, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'success'
                    });
                    table.fnMultiFilter();
                } else if (data.success === false) {
                    $("#DecreaseInventoryForm_summaryError").hide();
                    alert(data.message);
                }

                if (data.error.length > 0) {
                    $("#DecreaseInventoryForm_summaryError b").html(data.error);
                    $('#DecreaseInventoryForm_summaryError').show().delay(3000).fadeOut('slow');
                }

            },
            error: function(data) { // if error occured
                alert("Error occured: Please try again");
            },
        });

    }

    $('#btn_decrease').click(function() {
        send();
    });

    $('#btn_decrease_form_reset').click(function() {
        document.forms["decrease-form"].reset();
    });

    $(function() {
        $('#transaction_date_dp').datepicker({
            timePicker: false,
            format: 'YYYY-MM-DD',
            applyClass: 'btn-primary'
        });
    });

</script>