<?php
$this->breadcrumbs=array(
	'Sku Statuses'=>array('admin'),
	$model->sku_status_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'sku_status_id',
		'company.name',
		'status_name',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
