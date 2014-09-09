<div class="row">
    
<div class="panel panel-default">
    
  <div class="panel-body">
    <div class="col-md-8">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>false,
)); ?>

 <?php /*if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <?php echo $form->errorSummary($model); ?></div>
*/ ?>        

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'supplier_code',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'supplier_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'contact_person1',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'contact_person2',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'telephone',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'cellphone',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'fax_number',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'address1',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'address2',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'barangay',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'municipal',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'province',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'region',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'latitude',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>9)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'longitude',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>9)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'update_date',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'update_by',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	</div>


<div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-flat')); ?>    <?php echo CHtml::resetButton('Reset',array('class'=>'btn btn-primary btn-flat')); ?></div>

<?php $this->endWidget(); ?>
    </div>
  </div>
</div>
</div>