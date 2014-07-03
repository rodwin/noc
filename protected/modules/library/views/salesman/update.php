<?php
$this->breadcrumbs=array(
	'Salesmen'=>array('admin'),
	$model->salesman_id=>array('view','id'=>$model->salesman_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>