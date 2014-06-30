<?php
$this->breadcrumbs=array(
	'Skus'=>array('admin'),
	$model->name=>array('view','id'=>$model->code),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>