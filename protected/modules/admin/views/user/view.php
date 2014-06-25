<?php
$this->breadcrumbs=array(
	'Users'=>array('admin'),
	$model->user_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'user_id',
		'company_id',
		'user_type_id',
		'user_name',
		'status',
		'first_name',
		'last_name',
		'email',
		'position',
		'telephone',
		'address',
		'created_date',
		'created_by',
		'updated_by',
		'updated_date',
		'deleted_date',
		'deleted_by',
		'deleted',
),
)); ?>
</div>
