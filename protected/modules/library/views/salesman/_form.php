<div class="row">
    
<div class="panel panel-default">
    
  <div class="panel-body">
    <div class="col-md-12">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'salesman-form',
	'enableAjaxValidation'=>false,
)); ?>

 <?php /*if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <?php echo $form->errorSummary($model); ?></div>
*/ ?>        

	<div class="row">
            <div class="col-md-6">
                <div class="form-group">
		<?php echo $form->textFieldGroup($model,'team_leader_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                </div>


                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'salesman_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
                </div>


                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'salesman_code',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                </div>


                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'mobile_number',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                </div>


                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'device_no',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                </div>
                
                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'is_team_leader',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>1)))); ?>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'other_fields_1',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                </div>


                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'other_fields_2',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                </div>


                <div class="form-group">
                        <?php echo $form->textFieldGroup($model,'other_fields_3',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                </div>
            </div>
	

	
	

	
	


        
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-flat')); ?>    <?php echo CHtml::resetButton('Reset',array('class'=>'btn btn-primary btn-flat')); ?>
                </div>
            </div>
        </div>
<?php $this->endWidget(); ?>
    </div>
  </div>
</div>
</div>