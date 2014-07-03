<?php
$this->breadcrumbs=array(
	'Brand Categories'=>array('admin'),
	$model->category_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'category_id',
		'company.name',
		'category_name',
		'created_date',
		'created_by',
		'updated_by',
		'updated_date',
),
)); ?>
</div>
