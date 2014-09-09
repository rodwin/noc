<?php
$this->breadcrumbs=array(
	'Employee Types'=>array('admin'),
	$model->employee_type_id=>array('view','id'=>$model->employee_type_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>