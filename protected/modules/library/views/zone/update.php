<?php
$this->breadcrumbs=array(
	'Zones'=>array('admin'),
	$model->zone_id=>array('view','id'=>$model->zone_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model, 'sales_office' => $sales_office,)); ?>