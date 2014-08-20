<?php
/* @var $this InventoryHistoryController */
/* @var $model InventoryHistory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-history-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'inventory_id'); ?>
		<?php echo $form->textField($model,'inventory_id'); ?>
		<?php echo $form->error($model,'inventory_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_date'); ?>
		<?php echo $form->textField($model,'transaction_date'); ?>
		<?php echo $form->error($model,'transaction_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity_change'); ?>
		<?php echo $form->textField($model,'quantity_change'); ?>
		<?php echo $form->error($model,'quantity_change'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'running_total'); ?>
		<?php echo $form->textField($model,'running_total'); ?>
		<?php echo $form->error($model,'running_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'action'); ?>
		<?php echo $form->textField($model,'action',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'action'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost_unit'); ?>
		<?php echo $form->textField($model,'cost_unit',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'cost_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ave_cost_per_unit'); ?>
		<?php echo $form->textField($model,'ave_cost_per_unit',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'ave_cost_per_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
		<?php echo $form->error($model,'updated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'updated_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->