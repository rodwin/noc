
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'sku-location-restock-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo CHtml::hiddenField("active_tab", isset($_POST['active_tab']) ? $_POST['active_tab'] : "") ?>

<div class="form-group clearfix">
    <div style="width: 45%; float: left;">

        <div class="form-group">
            <?php // echo $form->textFieldGroup($sku_location_restock, 'zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50))));  ?>
            <?php
            echo $form->dropDownListGroup(
                    $sku_location_restock, 'zone_id', array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'widgetOptions' => array(
                    'data' => $zone,
                    'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Zone'),
                )
                    )
            );
            ?>
        </div>

        <div class="form-group">
            <?php // echo $form->textFieldGroup($sku_location_restock, 'low_qty_threshold', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
            <?php
            echo $form->textFieldGroup(
                    $sku_location_restock, 'low_qty_threshold', array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'append' => !empty($model->defaultUom->uom_name) ? $model->defaultUom->uom_name : ""
                    )
            );
            ?>
        </div>

        <div class="form-group">
            <?php // echo $form->textFieldGroup($sku_location_restock, 'high_qty_threshold', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?> 
            <?php
            echo $form->textFieldGroup(
                    $sku_location_restock, 'high_qty_threshold', array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'append' => !empty($model->defaultUom->uom_name) ? $model->defaultUom->uom_name : ""
                    )
            );
            ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary btn-flat')); ?>
        </div>

    </div>

    <div style="width: 65%; float: right;"></div>
</div>

<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sku-location-restock-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php $fields = SkuLocationRestock::model()->attributeLabels(); ?>
<div class="table-responsive">
    <table id="sku-location-restock_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['zone_id']; ?></th>
                <th><?php echo $fields['low_qty_threshold']; ?></th>
                <th><?php echo $fields['high_qty_threshold']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#sku-location-restock_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/SkuLocationRestock/skuLocationRestockData', array('sku_id' => $model->sku_id)); ?>",
            "columns": [
                {"name": "zone_name", "data": "zone_name"}, {"name": "low_qty_threshold", "data": "low_qty_threshold"}, {"name": "high_qty_threshold", "data": "high_qty_threshold"}, {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        jQuery(document).on('click', '#sku-location-restock_table a.delete', function() {
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