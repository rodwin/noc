<?php
$this->breadcrumbs=array(
	'Zones'=>array('admin'),
	$model->zone_id,
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
		'sales_office_id',
		'description',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
