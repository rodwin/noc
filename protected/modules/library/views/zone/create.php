<?php
$this->breadcrumbs=array(
	'Zones'=>array('admin'),
	'Create',
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'sales_office' => $sales_office,)); ?>