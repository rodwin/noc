<?php
$this->breadcrumbs=array(
	'Uoms'=>array('admin'),
	$model->uom_id=>array('view','id'=>$model->uom_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>