<?php
$this->breadcrumbs=array(
	'Authitems'=>array('admin'),
	$model->name=>array('view','id'=>$model->name),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>