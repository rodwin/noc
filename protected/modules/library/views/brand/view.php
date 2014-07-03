<?php
$this->breadcrumbs=array(
	'Brands'=>array('admin'),
	$model->brand_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'brand_id',
		'brand_category_id',
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
