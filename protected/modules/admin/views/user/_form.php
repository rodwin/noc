<div class="row">
    
<div class="panel panel-default">
    
  <div class="panel-body">
    <div class="col-md-8">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

 <?php /*if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <?php echo $form->errorSummary($model); ?></div>
*/ ?>        

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'user_type_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'user_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->passwordFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	</div>
        
        <div class="form-group">
		<?php echo $form->passwordFieldGroup($model,'password2',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'form-control','maxlength'=>100)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'status',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'first_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'last_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'email',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'position',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'telephone',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'address',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>250)))); ?>
	</div>


<div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-flat')); ?>    <?php echo CHtml::resetButton('Reset',array('class'=>'btn btn-primary btn-flat')); ?></div>

<?php $this->endWidget(); ?>
    </div>
  </div>
</div>
</div>