<?php
$this->breadcrumbs=array(
	'Distributors'=>array('admin'),
	$model->distributor_name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'distributor_id',
		'company.name',
		'distributor_code',
		'distributor_name',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
