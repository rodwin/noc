<?php
/* @var $this InventoryHistoryController */
/* @var $model InventoryHistory */

$this->breadcrumbs=array(
	'Inventory Histories'=>array('index'),
	$model->inventory_history_id,
);

$this->menu=array(
	array('label'=>'List InventoryHistory', 'url'=>array('index')),
	array('label'=>'Create InventoryHistory', 'url'=>array('create')),
	array('label'=>'Update InventoryHistory', 'url'=>array('update', 'id'=>$model->inventory_history_id)),
	array('label'=>'Delete InventoryHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->inventory_history_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InventoryHistory', 'url'=>array('admin')),
);
?>

<h1>View InventoryHistory #<?php echo $model->inventory_history_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'inventory_history_id',
		'inventory_id',
		'company_id',
		'transaction_date',
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
