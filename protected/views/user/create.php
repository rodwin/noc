<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Create',
);


?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>