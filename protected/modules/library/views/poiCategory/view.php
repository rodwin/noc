<?php
$this->breadcrumbs=array(
	'Poi Categories'=>array('admin'),
	$model->poi_category_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'poi_category_id',
		'company.name',
		'category_name',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
