<?php
$this->breadcrumbs=array(
	'Skus'=>array('admin'),
	$model->name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'code',
		'company.name',
		'brand_code',
		'name',
		'description',
		'uom',
		'unit_price',
		'type',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
		'deleted_date',
		'deleted_by',
		'deleted',
),
)); ?>
</div>
