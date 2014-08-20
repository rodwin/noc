<style>
    .input-group{
        width: 60%;
    }
    .form-group{
        width: 60%;
    }
</style>
    
    <div class="box box-solid box-success">
        <div class="box-header">
            <h3 class="box-title">Increase</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-success btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'increase-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array(
                    'onsubmit' => "return false;", /* Disable normal form submit */
                    'onkeypress' => " if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
                ),
            ));
            ?>
            <input type="hidden" id="inventory_id" name="IncreaseInventoryForm[inventory_id]" value="<?php echo $inventoryObj->inventory_id;?>" />
            <dt class="text-green">For this record</dt>
            
        
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th><?php echo Inventory::model()->getAttributeLabel('qty')?></th>
                        <th><?php echo Inventory::model()->getAttributeLabel('uom.uom_name')?></th>
                        <th><?php echo Inventory::model()->getAttributeLabel('sku.sku_name')?></th>
                        <th><?php echo Inventory::model()->getAttributeLabel('zone.zone_name')?></th>
                        <th><?php echo Inventory::model()->getAttributeLabel('reference_no')?></th>
                        <th><?php echo Inventory::model()->getAttributeLabel('expiration_date')?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $inventoryObj->qty;?></td>
                        <td><?php echo $inventoryObj->uom->uom_name;?></td>
                        <td><?php echo $inventoryObj->sku->sku_name;?></td>
                        <td><?php echo $inventoryObj->zone->zone_name;?></td>
                        <td><?php echo $inventoryObj->reference_no;?></td>
                        <td><?php echo $inventoryObj->expiration_date;?></td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <dt class="text-green">Increase the quantity by...</dt>
            <div class="input-group">
                <input type="text" id="IncreaseInventoryForm_qty" class="required form-control" name="IncreaseInventoryForm[qty]" value="<?php echo $qty;?>" />
                <span class="input-group-addon"><?php echo $inventoryObj->uom->uom_name;?></span>
            </div>
            <br/>
            
            <dt class="text-green">With these transaction details...</dt>
            <?php echo $form->textFieldGroup($model, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'required')))); ?> 
            <?php
                echo $form->textFieldGroup($model, 'cost_per_unit', array('widgetOptions' => array('htmlOptions' => array())
                , 'prepend' => 'P'
            ));
            ?>
            <div class="form-group">
                <?php echo CHtml::Button('Save', array('name' => 'save', 'class' => 'btn btn-primary btn-flat', 'id' => 'btn_increase')); ?>
                <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
            </div>
            
            <?php $this->endWidget(); ?>
        </div>
        
    </div><!-- /.box-body -->
<script>
    function send()
    {

        var data = $("#increase-form").serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/Inventory/increase'); ?>',
            data: data,
            dataType:"json",
            success: function(data) {
                if(data.success === true){
                    $('#myModal').modal('hide');
                    $.growl(data.message, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'success'
                    });
                    table.fnMultiFilter();
                }else{
                    alert(data);
                }
            },
            error: function(data) { // if error occured
                alert("Error occured.please try again");
            },
        });

    }

    $(document).ready(function() {
        var rules = {
            IncreaseInventoryForm_qty: {
                required: true
            }
        };
        var messages = {
            IncreaseInventoryForm_qty: {
                required: "Please enter qty"
            }
        };
        $("#increase-form").validate({
            rules: rules,
            messages: messages
        });

        $('#btn_increase').click(function() {
            if($("#increase-form").valid()){
                send();
            } 
            
//            
        })

    });
</script>