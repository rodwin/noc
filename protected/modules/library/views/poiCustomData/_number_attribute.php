
<h4 class="control-label text-primary"><b>Numbers Only</b></h4>

<div class="form-group">
    <label>Minimum Value <i style="color: red;">*</i></label>
    <?php echo CHtml::textField('minimum_value', $unserialize_attribute['min_value'], array('class' => 'form-control input', 'maxlength' => PoiCustomData::CUSTOM_VALUE_LENGTH, "onkeypress" => "return onlyNumbers(this, event)", "placeholder" => "Minimum Value")); ?> 
    <?php echo $form->error($poi_custom_data, "minimum_value", array("style" => "color: #f56954;")); ?>
</div>

<div class="form-group">
    <label>Maximum Value <i style="color: red;">*</i></label>
    <?php echo CHtml::textField('maximum_value', $unserialize_attribute['max_value'], array('class' => 'form-control input', 'maxlength' => PoiCustomData::CUSTOM_VALUE_LENGTH, "onkeypress" => "return onlyNumbers(this, event)", "placeholder" => "Maximum Value")); ?> 
    <?php echo $form->error($poi_custom_data, "maximum_value", array("style" => "color: #f56954;")); ?>
</div>

<div class="form-group">
    <label>Default Value</label>
    <?php echo CHtml::textField('default_value', $unserialize_attribute['default_value'], array('class' => 'form-control input', 'maxlength' => PoiCustomData::CUSTOM_VALUE_LENGTH, "onkeypress" => "return onlyNumbers(this, event)", "placeholder" => "Default Value")); ?> 
</div>

<h5 class="control-label text-primary"><b>Format</b></h5>

<div class="form-group">
    <label>
        <?php echo CHtml::CheckBox('use_seperator', PoiCustomData::model()->getValueByName("form_checked", $unserialize_attribute['use_seperator']), array()); ?>
        Use Separator
    </label>
</div>

<div class="form-group">
    <label>
        <?php echo CHtml::CheckBox('leading_zero', PoiCustomData::model()->getValueByName("form_checked", $unserialize_attribute['leading_zero']), array()); ?>
        Show Leading Zero for numbers between 0 and 1
    </label>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label text-primary">Decimal Places</label><br/>
            <?php echo CHtml::dropDownList('decimal_place', $unserialize_attribute['decimal_place'], array('0' => '0', '1' => '1', '2' => '2'), array('class' => 'form-control input')); ?>
        </div>
    </div>
</div>
