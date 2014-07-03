<?php
$this->breadcrumbs=array(
	'Pois'=>array('admin'),
	$model->poi_id=>array('view','id'=>$model->poi_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>