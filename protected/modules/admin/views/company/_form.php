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
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class'=>'form-control','size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'short_name'); ?>
		<?php echo $form->textField($model,'short_name',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'short_name'); ?>
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
		<?php echo $form->labelEx($model,'barangay_id'); ?>
		<?php echo $form->textField($model,'barangay_id',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'barangay_id'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'municipal_id'); ?>
		<?php echo $form->textField($model,'municipal_id',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'municipal_id'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'province_id'); ?>
		<?php echo $form->textField($model,'province_id',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'province_id'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'region_id'); ?>
		<?php echo $form->textField($model,'region_id',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'region_id'); ?>
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
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'updated_date'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'updated_by'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'deleted_date'); ?>
		<?php echo $form->textField($model,'deleted_date',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'deleted_date'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'deleted_by'); ?>
		<?php echo $form->textField($model,'deleted_by',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'deleted_by'); ?>
	</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'deleted'); ?>
	</div>


<div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-flat')); ?>    <?php echo CHtml::resetButton('Reset',array('class'=>'btn btn-primary btn-flat')); ?></div>

<?php $this->endWidget(); ?>
    </div>
  </div>
</div>
</div>