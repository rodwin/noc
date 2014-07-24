<?php
$this->breadcrumbs=array(
	'Zones'=>array('admin'),
	$model->zone_name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'zone_id',
		'zone_name',
		'company.name',
		'salesOffice.sales_office_name',
		'description',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
