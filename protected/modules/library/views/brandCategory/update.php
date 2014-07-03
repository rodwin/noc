<?php
$this->breadcrumbs=array(
	'Brand Categories'=>array('admin'),
	$model->category_id=>array('view','id'=>$model->category_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>