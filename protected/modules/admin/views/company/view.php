<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->name,
);

?>


<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'company_id',
		'status_id',
		'name',
		'short_name',
		'address1',
		'address2',
		'barangay_id',
		'municipal_id',
		'province_id',
		'region_id',
		'country',
		'phone',
		'fax',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
		'deleted_date',
		'deleted_by',
		'deleted',
),
)); ?>
