<?php
$this->breadcrumbs=array(
	'Poi Sub Categories'=>array('admin'),
	$model->poi_sub_category_id=>array('view','id'=>$model->poi_sub_category_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>