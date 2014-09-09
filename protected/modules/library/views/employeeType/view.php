<?php
$this->breadcrumbs=array(
	'Employee Types'=>array('admin'),
	$model->employee_type_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'employee_type_id',
		'company.name',
		'employee_type_code',
		'description',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
