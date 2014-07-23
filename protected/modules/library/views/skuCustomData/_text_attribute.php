
<div><?php echo $form->labelEx($model, 'Text and Numbers', array('class' => 'control-label text-primary', 'style' => 'font-weight: bold;')); ?></div>

<div>
    <?php echo $form->labelEx($model, 'Max Character Length <i style="color: red;">*</i>', array('class' => 'control-label')); ?><br/>
    <?php echo CHtml::textField('max_character_length', $unserialize_attribute['max_character_length'], array('class' => 'span5', 'maxlength' => 50)); ?> 
</div>

<div>
    <?php echo CHtml::checkBox('text_area', PoiCustomData::model()->getValueByName("form_checked", $unserialize_attribute['text_field']), array()); ?>
    <?php echo $form->labelEx($model, 'Text Area', array('class' => 'control-label')); ?>
</div>

<div>
    <?php echo $form->labelEx($model, 'Default Value', array('class' => 'control-label')); ?><br/>
    <?php echo CHtml::textField('default_value', $unserialize_attribute['default_value'], array('class' => 'span5', 'maxlength' => 50)); ?> 
</div>