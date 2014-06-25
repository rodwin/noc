<div class="row">
    
<div class="panel panel-default">
    
  <div class="panel-body">
    <div class="col-md-8">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>

 <?php if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <?php echo $form->errorSummary($model); ?></div>
<?php } ?>        


		<div class="form-group">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->textField($model,'status_id',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'industry'); ?>
		<?php echo $form->textField($model,'industry',array('class'=>'form-control','size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'industry'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('class'=>'form-control','size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class'=>'form-control','size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'address1'); ?>
		<?php echo $form->textField($model,'address1',array('class'=>'form-control','size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'address1'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'address2'); ?>
		<?php echo $form->textField($model,'address2',array('class'=>'form-control','size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'address2'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('class'=>'form-control','size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'province'); ?>
		<?php echo $form->textField($model,'province',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'province'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model,'fax',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'fax'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'zip_code'); ?>
		<?php echo $form->textField($model,'zip_code',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'zip_code'); ?>
	</div>



<div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-flat')); ?>    <?php echo CHtml::resetButton('Reset',array('class'=>'btn btn-primary btn-flat')); ?></div>

<?php $this->endWidget(); ?>
    </div>
  </div>
</div>
</div>