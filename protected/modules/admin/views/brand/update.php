<?php
$this->breadcrumbs=array(
	'Brands'=>array('admin'),
	$model->brand_code=>array('view','id'=>$model->brand_code),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>