<div class="panel panel-default">

    <div class="panel-body">
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'increase-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array(
                'onsubmit' => "return false;", /* Disable normal form submit */
                'onkeypress' => " if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
            ),
//                'action'=>Yii::app()->createUrl('/inventory/Inventory/increase'),
//                'enableClientValidation'=>true,
//                'clientOptions'=>array(
//                        'validateOnSubmit'=>true,
//                ),
        ));
        ?>
        <input type="hidden" id="inventory_id" name="IncreaseInventoryForm[inventory_id]" value="<?php echo $inventoryObj->inventory_id;?>"

        <p>For this record...</p>
        1 pc(s) of TST9516 @ Wise Sales Office
        test12345

        <?php echo $form->textFieldGroup($model, 'qty', array('widgetOptions' => array('htmlOptions' => array('class' => 'required', 'value' => $qty)))); ?>
        
        <div class="extra-info-cont">
            <span>With these transaction details...</span>
                <div id="extraInfoSpacingCont">
                    <?php echo $form->textFieldGroup($model, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => 'required')))); ?> 
                    <?php echo $form->textFieldGroup($model, 'cost_per_unit', array('widgetOptions' => array('htmlOptions' => array()))); ?> 

                </div>                                                             
            </div>
        <div class="form-group">
            <?php echo CHtml::Button('Save', array('name' => 'save', 'class' => 'btn btn-primary btn-flat', 'id' => 'btn_increase')); ?>
            <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    function send()
    {

        var data = $("#increase-form").serialize();
        console.log(data);
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/Inventory/increase'); ?>',
            data: data,
            success: function(data) {
                alert(data);
            },
            error: function(data) { // if error occured
                alert("Error occured.please try again");
                alert(data);
            },
            dataType: 'html'
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