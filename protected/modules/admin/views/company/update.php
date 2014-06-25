<?php
$this->breadcrumbs=array(
	'Companies'=>array('admin'),
	$model->name=>array('view','id'=>$model->company_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>