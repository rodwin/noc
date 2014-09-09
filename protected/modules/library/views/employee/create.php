<?php
$this->breadcrumbs=array(
	'Employees'=>array('admin'),
	'Create',
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 
    'employee_status' => $employee_status, 'employee_type' => $employee_type,
    'supervisor' =>$supervisor, 'sales_office' =>$sales_office, 'zone' => $zone)); ?>