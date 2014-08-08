
<h4 class="control-label text-primary"><b>CheckBox</b></h4>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Default Value</label><br/>
            <?php echo CHtml::dropDownList('default_value', $unserialize_attribute['default_value'], array('no' => 'Un-Checked', 'yes' => 'Checked'), array('class' => 'form-control input-sm')); ?>
        </div>
    </div>
</div>