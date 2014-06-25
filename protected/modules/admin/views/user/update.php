<?php
$this->breadcrumbs=array(
	'Users'=>array('admin'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model,'listCompanies'=>$listCompanies)); ?>