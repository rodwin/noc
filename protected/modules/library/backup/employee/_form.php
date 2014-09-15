<div class="row">

    <div class="panel panel-default">

        <div class="panel-body">
            <div class="col-md-8">

                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'employee-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-ban"></i>
                  <?php echo $form->errorSummary($model); ?></div>
                 */ ?>    

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'employee_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'employee_status', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'employee_status', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $employee_status_list,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Status'),
                    )));
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'employee_type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'employee_type', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $employee_type_list,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Type'),
                    )));
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'sales_office_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'sales_office_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $sales_office_list,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Salesoffice',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('salesman/getZoneBySalesoffice'),
                                    'update' => '#Employee_default_zone_id',
                                    'data' => array('sales_office_id' => 'js:this.value',),
                                )),
                    )));
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'default_zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'default_zone_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $so_zones,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Zone'),
                    )));
                    ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'first_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'last_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'middle_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'address1', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'address2', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'barangay_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'home_phone_number', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'work_phone_number', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->datePickerGroup($model, 'birth_date', array('widgetOptions' => array('options' => array(), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => 'Click on Month/Year to select a different Month/Year.')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->datePickerGroup($model, 'date_start', array('widgetOptions' => array('options' => array(), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => 'Click on Month/Year to select a different Month/Year.')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->datePickerGroup($model, 'date_termination', array('widgetOptions' => array('options' => array(), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => 'Click on Month/Year to select a different Month/Year.')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->passwordFieldGroup($model, 'password', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'supervisor_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat')); ?>   
                    <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</div>