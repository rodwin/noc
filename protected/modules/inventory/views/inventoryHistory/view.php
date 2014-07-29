<?php
$this->breadcrumbs=array(
	'Inventory Histories'=>array('admin'),
	$model->inventory_history_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'inventory_history_id',
		'company.name',
		'inventory_id',
		'quantity_change',
		'running_total',
		'action',
		'cost_unit',
		'ave_cost_per_unit',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
