
<h4 class="control-label text-primary"><b>Text and Numbers</b></h4>

<div class="form-group">
    <label>Max Character Length <i style="color: red;">*</i></label>
    <?php echo CHtml::textField('max_character_length', $unserialize_attribute['max_character_length'], array('class' => 'form-control input', 'maxlength' => PoiCustomData::CUSTOM_VALUE_LENGTH, "onkeypress" => "return onlyNumbers(this, event)", "placeholder" => "Max Character Length")); ?> 
    <?php echo $form->error($poi_custom_data, "max_character_length", array("style" => "color: #f56954;")); ?>
</div>

<div class="form-group">
    <label>
        <?php echo CHtml::CheckBox('text_area', PoiCustomData::model()->getValueByName("form_checked", $unserialize_attribute['text_field']), array()); ?>
        Text Area
    </label>
</div>

<div class="form-group">
    <label>Default Value</label>
    <?php echo CHtml::textField('default_value', $unserialize_attribute['default_value'], array('class' => 'form-control input', 'maxlength' => PoiCustomData::CUSTOM_VALUE_LENGTH, "placeholder" => "Default Value")); ?> 
</div>