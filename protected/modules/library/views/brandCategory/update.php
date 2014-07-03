<?php
$this->breadcrumbs=array(
	'Brand Categories'=>array('admin'),
	$model->brand_category_id=>array('view','id'=>$model->brand_category_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>