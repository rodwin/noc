<?php
$this->breadcrumbs=array(
	'Brands'=>array('admin'),
	$model->brand_id=>array('view','id'=>$model->brand_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>