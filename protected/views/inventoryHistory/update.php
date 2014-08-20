<?php
/* @var $this InventoryHistoryController */
/* @var $model InventoryHistory */

$this->breadcrumbs=array(
	'Inventory Histories'=>array('index'),
	$model->inventory_history_id=>array('view','id'=>$model->inventory_history_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InventoryHistory', 'url'=>array('index')),
	array('label'=>'Create InventoryHistory', 'url'=>array('create')),
	array('label'=>'View InventoryHistory', 'url'=>array('view', 'id'=>$model->inventory_history_id)),
	array('label'=>'Manage InventoryHistory', 'url'=>array('admin')),
);
?>

<h1>Update InventoryHistory <?php echo $model->inventory_history_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>