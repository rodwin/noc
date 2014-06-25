<?php
$this->breadcrumbs=array(
	'Companies'=>array('admin'),
	$model->name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'company_id',
		'status_id',
		'industry',
		'code',
		'name',
		'address1',
		'address2',
		'city',
		'province',
		'country',
		'phone',
		'fax',
		'zip_code',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
		'deleted_date',
		'deleted_by',
		'deleted',
),
)); ?>
</div>
