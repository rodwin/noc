<?php
$this->breadcrumbs=array(
	'Inventory Histories'=>array('admin'),
	$model->inventory_history_id=>array('view','id'=>$model->inventory_history_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>