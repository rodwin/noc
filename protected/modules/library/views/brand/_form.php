<div class="row">

    <div class="panel panel-default">

        <div class="panel-body">
            <div class="col-md-8">
                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'brand-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-ban"></i>
                  <?php echo $form->errorSummary($model); ?></div>
                 */ ?>        


                <div class="form-group">
                    <?php //echo $form->textFieldGroup($model, 'brand_category_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'brand_category_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $brand_category,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Brand Category'),
                        )
                            )
                    );
                    ?>
                </div>


                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'brand_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>


                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'brand_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 250)))); ?>
                </div>


                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat')); ?>    <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?></div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>