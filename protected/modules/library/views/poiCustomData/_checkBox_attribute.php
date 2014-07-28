
<div><?php echo $form->label($model, 'CheckBox', array('class' => 'control-label text-primary', 'style' => 'font-weight: bold;')); ?></div>

<div>
    <?php echo $form->label($model, 'Default Value', array('class' => 'control-label')); ?><br/>
    <?php echo CHtml::dropDownList('default_value', $unserialize_attribute['default_value'], array('0' => 'Un-Checked', '1' => 'Checked'), array('style' => 'width: 200px; padding: 5px; font-size: 12px;')); ?>
</div>
