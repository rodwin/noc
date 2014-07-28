<?php
$this->breadcrumbs=array(
	'Sku Custom Datas'=>array('admin'),
	$model->name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'custom_data_id',
		'company.name',
		'name',
		'type',
		'data_type',
		'description',
		'required',
		'sort_order',
		'attribute',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
