
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'sku-convertion-form',
    'enableAjaxValidation' => false,
        ));
?> 

<?php echo CHtml::hiddenField("active_tab", isset($_POST['active_tab']) ? $_POST['active_tab'] : "") ?>

<div class="form-group clearfix">
    <div style="width: 45%; float: left;">
        <?php echo $form->textFieldGroup($sku_convertion, 'quantity', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
        <?php // echo $form->textFieldGroup($sku_convertion, 'new_quantity', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
        <?php
        echo $form->textFieldGroup(
                $sku_convertion, 'new_quantity', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'append' => !empty($model->defaultUom->uom_name) ? $model->defaultUom->uom_name : ""
                )
        );
        ?>
    </div>

    <div style="width: 50%; float: right;">
        <?php
        echo $form->dropDownListGroup(
                $sku_convertion, 'uom_id', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'data' => $sku_convertion_uom,
                'htmlOptions' => array('multiple' => false, 'prompt' => 'Select UOM'),
            )
                )
        );
        ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary btn-flat')); ?>
</div>

<?php $this->endWidget(); ?>


<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sku-convertion-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php $fields = SkuConvertion::model()->attributeLabels(); ?>
<div class="table-responsive">
    <table id="sku-convertion_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['quantity']; ?></th>
                <th><?php echo $fields['uom_id']; ?></th>
                <th>Equals</th>
                <th><?php echo $fields['new_quantity']; ?></th>
                <th>Default Unit of Measure</th>
                <th>Actions</th>
            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    
    $(function() {

        var table = $('#sku-convertion_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/SkuConvertion/skuConvertionData', array('sku_id' => $model->sku_id,  'uom_name' => !empty($model->defaultUom->uom_name) ? $model->defaultUom->uom_name : null)); ?>",
            "columns": [
                {"name": "quantity", "data": "quantity"}, {"name": "uom_name", "data": "uom_name"}, {"name": "equals", "data": "equals", 'sortable': false}, {"name": "new_quantity", "data": "new_quantity"}, {"name": "default_of_unit_measure", "data": "default_of_unit_measure", 'sortable': false}, {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        jQuery(document).on('click', '#sku-convertion_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    $.growl(data, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'success'
                    });

                    table.fnMultiFilter();
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });
        
    });
</script>