<?php
$this->breadcrumbs=array(
	'Poi Categories'=>array('admin'),
	$model->category_name=>array('view','id'=>$model->poi_category_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>