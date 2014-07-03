<?php
$this->breadcrumbs=array(
	'Inventories'=>array('admin'),
	$model->inventory_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'inventory_id',
		'company.name',
		'sku_id',
		'qty',
		'uom_id',
		'zone_id',
		'sku_status_id',
		'transaction_date',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
		'expiration_date',
		'reference_no',
),
)); ?>
</div>
