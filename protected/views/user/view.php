<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

?>

<div class="row">

<?php $this->widget('booster.widgets.TbDetailView', array(
	'data'=>$model,
        'type' => 'bordered condensed',
	'attributes'=>array(
		'id',
		'user_type_id',
		'user_name',
		'password',
		'first_name',
		'last_name',
		'email',
		'telephone',
		'address',
		'added_when',
		'added_by',
		'updated_when',
		'updated_by',
		'deleted_when',
		'deleted_by',
		'deleted',
		'status',
	),
)); ?>

</div>