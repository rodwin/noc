<div class="row">
    <div class="panel panel-default">

        <div class="panel-body">
            <div class="col-md-8">
                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'inventory-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-ban"></i>
                  <?php echo $form->errorSummary($model); ?></div>
                 */ ?>        


                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'sku_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $sku,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Sku'),
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'qty', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'uom_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'uom_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $uom,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select UOM'),
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'zone_id', array(
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
                    <?php // echo $form->textFieldGroup($model, 'sku_status_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'sku_status_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $sku_status,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Sku Status'),
                        )
                            )
                    );
                    ?>
                </div>


                <div class="form-group">
                    <?php echo $form->datePickerGroup($model, 'transaction_date', array('widgetOptions' => array('options' => array(), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => 'Click on Month/Year to select a different Month/Year.')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->datePickerGroup($model, 'expiration_date', array('widgetOptions' => array('options' => array(), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => 'Click on Month/Year to select a different Month/Year.')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'reference_no', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 250)))); ?>
                </div>

                <div class="form-group">
                    <?php echo CHtml::submitButton('Create & New', array('name' => 'create', 'class' => 'btn btn-primary btn-flat')); ?>
                    <?php echo CHtml::submitButton('Save', array('name' => 'save', 'class' => 'btn btn-primary btn-flat')); ?>
                    <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="box box-primary">
        <div class="box-body">
            <?php
            echo $this->renderPartial('_inventory_history', array());
            ?> 
        </div>
    </div>
</div>

