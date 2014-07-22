<?php
$this->breadcrumbs = array(
    'Poi Custom Datas' => array('admin'),
    'Create',
);
?>

<?php //echo $this->renderPartial('_form', array('model'=>$model));  ?>

<div class="row">

    <div class="panel panel-default">

        <div class="panel-body">

            <div class="col-md-8">

                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'custom-data-item-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <h4><b><p class="text-primary">Item</p></b></h4>

                <div class="form-group">
                    <?php
                    echo $form->radioButtonListGroup(
                            $customDataForm, 'customDataType', array(
                        'widgetOptions' => array(
                            'data' => $data_type_list,
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($customDataForm, 'customItemName', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                </div>

                <div class="form-group">
                    <?php
                    echo $form->dropDownListGroup(
                            $customDataForm, 'type', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $poi_category,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Category'),
                        )
                            )
                    );
                    ?>
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