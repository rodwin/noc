<?php
$this->breadcrumbs = array(
    Sku::SKU_LABEL . ' Custom Datas' => array('admin'),
    'Create',
);
?>

<?php //echo $this->renderPartial('_form', array('model'=>$model));   ?>

<div class="row">

    <div class="panel panel-default">

        <div class="panel-body">

            <div class="col-md-8">

                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'sku-custom-data-item-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <h4><b><p class="text-primary">Item</p></b></h4>

                <div class="form-group">
                    <?php
                    echo $form->radioButtonListGroup(
                            $skuCustomDataForm, 'customDataType', array(
                        'widgetOptions' => array(
                            'data' => $data_type_list,
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($skuCustomDataForm, 'customItemName', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                </div>

                <div class="form-group">
                    <?php echo CHtml::submitButton('Next', array('class' => 'btn btn-primary btn-flat')); ?>
                    <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div>

        </div>

    </div>

</div>