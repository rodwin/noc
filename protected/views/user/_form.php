<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="row">

	<!-- left column -->
            <!-- general form elements -->
            <div class="box box-primary">
<!--                <div class="box-header">
                    <h3 class="box-title">Quick Example</h3>
                </div> /.box-header -->
                <!-- form start -->
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'user-form',
                        'enableAjaxValidation'=>false,
                )); ?>
                <div class="box-body">
                    <br/>
                    <?php if($form->errorSummary($model)){?>
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <?php echo $form->errorSummary($model); ?>
                    </div>
                    <?php }?>

                    <div class="alert alert-info alert-dismissable">
                        <i class="fa fa-info"></i>
                        <p class="note">Fields with <span class="required">*</span> are required.</p>
                    </div>
                    
                    <?php //echo $form->textFieldRow($model,'user_type_id',array("class"=>'form-control','size'=>60,'maxlength'=>100)); ?>
                    
                    <div class="form-group">
                            <?php echo $form->labelEx($model,'user_type_id'); ?>
                            <?php echo $form->textField($model,'user_type_id',array("class"=>'form-control', 'size'=>60,'maxlength'=>200)); ?>
                            <?php echo $form->error($model,'user_type_id'); ?>
                    </div>
                    
                    <div class="form-group">
                            <?php echo $form->labelEx($model,'user_name'); ?>
                            <?php echo $form->textField($model,'user_name',array("class"=>'form-control','size'=>60,'maxlength'=>100)); ?>
                            <?php echo $form->error($model,'user_name'); ?>
                    </div>

                    <div class="form-group">
                            <?php echo $form->labelEx($model,'password'); ?>
                            <?php echo $form->passwordField($model,'password',array("class"=>'form-control','size'=>60,'maxlength'=>200)); ?>
                            <?php echo $form->error($model,'password'); ?>
                    </div>

                    <div class="form-group">
                            <?php echo $form->labelEx($model,'first_name'); ?>
                            <?php echo $form->textField($model,'first_name',array("class"=>'form-control','size'=>60,'maxlength'=>100)); ?>
                            <?php echo $form->error($model,'first_name'); ?>
                    </div>

                    <div class="form-group">
                            <?php echo $form->labelEx($model,'last_name'); ?>
                            <?php echo $form->textField($model,'last_name',array("class"=>'form-control','size'=>60,'maxlength'=>100)); ?>
                            <?php echo $form->error($model,'last_name'); ?>
                    </div>

                    <div class="form-group">
                            <?php echo $form->labelEx($model,'email'); ?>
                            <?php echo $form->textField($model,'email',array("class"=>'form-control','size'=>60,'maxlength'=>100)); ?>
                            <?php echo $form->error($model,'email'); ?>
                    </div>

                    <div class="form-group">
                            <?php echo $form->labelEx($model,'telephone'); ?>
                            <?php echo $form->textField($model,'telephone',array("class"=>'form-control','size'=>45,'maxlength'=>45)); ?>
                            <?php echo $form->error($model,'telephone'); ?>
                    </div>

                    <div class="form-group">
                            <?php echo $form->labelEx($model,'address'); ?>
                            <?php echo $form->textField($model,'address',array("class"=>'form-control','size'=>60,'maxlength'=>200)); ?>
                            <?php echo $form->error($model,'address'); ?>
                    </div>

                    <div class="form-group">
                            <?php echo $form->labelEx($model,'status'); ?>
                            <?php echo $form->textField($model,'status',array("class"=>'form-control')); ?>
                            <?php echo $form->error($model,'status'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>"btn btn-primary btn-flat")); ?>
                        <?php echo CHtml::resetButton('Reset',array('class'=>"btn btn-primary btn-flat")); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        
        
	

	



</div><!-- form -->