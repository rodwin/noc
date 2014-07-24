<?php
$this->breadcrumbs=array(
	'Brands'=>array('admin'),
	$model->brand_name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'brand_id',
		'brandCategory.category_name',
		'brand_code',
		'company.name',
		'brand_name',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
