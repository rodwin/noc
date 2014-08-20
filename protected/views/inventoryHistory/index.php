<?php
/* @var $this InventoryHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inventory Histories',
);

$this->menu=array(
	array('label'=>'Create InventoryHistory', 'url'=>array('create')),
	array('label'=>'Manage InventoryHistory', 'url'=>array('admin')),
);
?>

<h1>Inventory Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
