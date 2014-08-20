<?php
/* @var $this InventoryHistoryController */
/* @var $model InventoryHistory */

$this->breadcrumbs=array(
	'Inventory Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InventoryHistory', 'url'=>array('index')),
	array('label'=>'Manage InventoryHistory', 'url'=>array('admin')),
);
?>

<h1>Create InventoryHistory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>