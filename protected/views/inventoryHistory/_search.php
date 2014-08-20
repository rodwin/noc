<?php
/* @var $this InventoryHistoryController */
/* @var $model InventoryHistory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'inventory_history_id'); ?>
		<?php echo $form->textField($model,'inventory_history_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inventory_id'); ?>
		<?php echo $form->textField($model,'inventory_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transaction_date'); ?>
		<?php echo $form->textField($model,'transaction_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity_change'); ?>
		<?php echo $form->textField($model,'quantity_change'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'running_total'); ?>
		<?php echo $form->textField($model,'running_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'action'); ?>
		<?php echo $form->textField($model,'action',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cost_unit'); ?>
		<?php echo $form->textField($model,'cost_unit',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ave_cost_per_unit'); ?>
		<?php echo $form->textField($model,'ave_cost_per_unit',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->