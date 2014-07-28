<div class="row">

    <div class="panel panel-default">

        <div class="panel-body">
            <div class="col-md-8">
                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'poi-custom-data-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-ban"></i>
                  <?php echo $form->errorSummary($model); ?></div>
                 */ ?>        


                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 250, 'readonly' => $model->isNewRecord ? true : false)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'data_type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>
                </div>


                <div class="form-group">
                    <?php //echo $form->textFieldGroup($model, 'description', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 250))));  ?>
                    <?php
                    echo $form->textAreaGroup(
                            $model, 'description', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('rows' => 5, 'style' => 'resize: none;'),
                        )
                            )
                    );
                    ?>
                </div>


                <div class="panel panel-default">

                    <div class="panel-body">

                        <?php
                        if ($model->data_type == 'Text and Numbers') {

                            echo $this->renderPartial('_text_attribute', array('model' => $model, 'form' => $form, 'unserialize_attribute' => $unserialize_attribute));
                        } else if ($model->data_type == 'Numbers Only') {

                            echo $this->renderPartial('_number_attribute', array('model' => $model, 'form' => $form, 'unserialize_attribute' => $unserialize_attribute));
                        } else if ($model->data_type == 'CheckBox') {

                            echo $this->renderPartial('_checkBox_attribute', array('model' => $model, 'form' => $form, 'unserialize_attribute' => $unserialize_attribute));
                        } else if ($model->data_type == 'Drop Down List') {

                            echo $this->renderPartial('_dropDownList_attribute', array('model' => $model, 'form' => $form, 'unserialize_attribute' => $unserialize_attribute));
                        } else if ($model->data_type == 'Date') {

                            echo $this->renderPartial('_date_attribute', array('model' => $model, 'form' => $form, 'unserialize_attribute' => $unserialize_attribute));
                        }
                        ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->checkboxGroup($model, 'required'); ?>
                </div>


                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'sort_order', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                </div>


                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('onclick' => 'getAllOptions()', 'class' => 'btn btn-primary btn-flat')); ?>&nbsp;
                    <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>&nbsp;
                    <?php echo $model->isNewRecord ? CHtml::link('Cancel', array('SkuCustomData/create'), array('class' => 'btn btn-primary btn-flat')) : ""; ?>
                </div>

<?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function getAllOptions() {

        dropDownList_multiple = document.getElementById("dropDownList_multiple");

        for (var i = 0; i < dropDownList_multiple.options.length; i++) {
            dropDownList_multiple.options[i].selected = true;
        }
    }

</script>