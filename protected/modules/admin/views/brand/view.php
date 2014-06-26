<?php
$this->breadcrumbs=array(
	'Brands'=>array('admin'),
	$model->brand_code,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'brand_code',
		'company.name',
		'brand_name',
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
