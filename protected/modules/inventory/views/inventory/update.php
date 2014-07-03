<?php
$this->breadcrumbs=array(
	'Inventories'=>array('admin'),
	$model->inventory_id=>array('view','id'=>$model->inventory_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>