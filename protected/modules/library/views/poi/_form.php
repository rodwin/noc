<div class="row">
    
<div class="panel panel-default">
    
  <div class="panel-body">
    <div class="col-md-8">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'poi-form',
	'enableAjaxValidation'=>false,
)); ?>

 <?php /*if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <?php echo $form->errorSummary($model); ?></div>
*/ ?>        

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'short_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'long_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>250)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'primary_code',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'secondary_code',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'barangay_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'municipal_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'province_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'region_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'sales_region_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'latitude',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>9)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'longitude',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>9)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'address1',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'address2',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'zip',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'landline',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'mobile',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'poi_category_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'poi_sub_category_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'remarks',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>250)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'status',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'edited_date',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'edited_by',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'verified_by',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->textFieldGroup($model,'verified_date',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>


<div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-flat')); ?>    <?php echo CHtml::resetButton('Reset',array('class'=>'btn btn-primary btn-flat')); ?></div>

<?php $this->endWidget(); ?>
    </div>
  </div>
</div>
</div>