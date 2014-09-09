<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('admin'),
	$model->supplier_id=>array('view','id'=>$model->supplier_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>