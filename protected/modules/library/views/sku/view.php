<?php
$this->breadcrumbs=array(
	'Skus'=>array('admin'),
	$model->sku_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'sku_id',
		'sku_code',
		'company.name',
		'brand_id',
		'sku_name',
		'description',
		'default_uom_id',
		'default_unit_price',
		'type',
		'default_zone_id',
		'supplier',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
		'low_qty_threshold',
		'high_qty_threshold',
),
)); ?>
</div>
