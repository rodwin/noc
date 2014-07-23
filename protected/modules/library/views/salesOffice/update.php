<?php
$this->breadcrumbs=array(
	'Sales Offices'=>array('admin'),
	$model->sales_office_name=>array('view','id'=>$model->sales_office_id),
	'Update',
);

	?>


<?php echo $this->renderPartial('_form',array('model'=>$model, 'distributors' => $distributors)); ?>