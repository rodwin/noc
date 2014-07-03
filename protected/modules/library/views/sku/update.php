<?php
$this->breadcrumbs=array(
	'Skus'=>array('admin'),
	$model->sku_id=>array('view','id'=>$model->sku_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>