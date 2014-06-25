<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <div class="body bg-gray ">
	<div class="form-group">
		<?php echo $form->textField($model,'username',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
    </div>
    <div class="footer">                                                               
                <?php echo CHtml::submitButton('Sign me in',array('class'=>'btn bg-blue btn-block')); ?>
    </div>
    

<?php $this->endWidget(); ?>
</div><!-- form -->
