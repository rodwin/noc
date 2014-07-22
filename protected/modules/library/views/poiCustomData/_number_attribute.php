
<div><?php echo $form->label($model, 'Numbers Only', array('class' => 'control-label text-primary', 'style' => 'font-weight: bold;')); ?></div>

<div>

    <div style="float: left; margin-right: 20px;">
        <?php echo $form->label($model, 'Minimum Value <i style="color: red;">*</i>', array('class' => 'control-label')); ?><br/>
        <?php echo CHtml::textField('minimum_value', $unserialize_attribute['minimum_value'], array('class' => 'span5', 'maxlength' => 50, 'style' => 'width: 100px;')); ?> 
    </div>

    <div style="float: left;">
        <?php echo $form->label($model, 'Maximum Value <i style="color: red;">*</i>', array('class' => 'control-label')); ?><br/>
        <?php echo CHtml::textField('maximum_value', $unserialize_attribute['maximum_value'], array('class' => 'span5', 'maxlength' => 50, 'style' => 'width: 100px;')); ?> 
    </div>

    <div class="clearfix"></div>
</div>

<div>
    <?php echo $form->label($model, 'Default Value', array('class' => 'control-label')); ?><br/>
    <?php echo CHtml::textField('default_value', $unserialize_attribute['default_value'], array('class' => 'span5', 'maxlength' => 50, 'style' => 'width: 100px;')); ?> 
</div>

<div><?php echo $form->label($model, 'Format', array('class' => 'control-label text-primary', 'style' => 'font-weight: bold;')); ?></div>

<div>
    <?php echo CHtml::CheckBox('use_seperator', PoiCustomData::model()->getValueByName("form_checked", $unserialize_attribute['use_seperator']), array('value' => '1',)); ?>
    <?php echo $form->label($model, 'Use Separator', array('class' => 'control-label')); ?>
</div>

<div>
    <?php echo CHtml::CheckBox('leading_zero', PoiCustomData::model()->getValueByName("form_checked", $unserialize_attribute['leading_zero']), array('value' => '1',)); ?>
    <?php echo $form->label($model, 'Show Leading Zero for numbers between 0 and 1', array('class' => 'control-label')); ?>
</div>

<div>
    <?php echo $form->label($model, 'Decimal Places', array('class' => 'control-label text-primary', 'style' => 'font-weight: bold;')); ?><br/>
    <?php echo CHtml::dropDownList('decimal_place', $unserialize_attribute['decimal_place'], array('0' => '0', '1' => '1', '2' => '2'), array('style' => 'width: 100px; padding: 5px; font-size: 12px;')); ?>
</div>
