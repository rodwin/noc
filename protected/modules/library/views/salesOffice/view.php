<?php
$this->breadcrumbs=array(
	'Sales Offices'=>array('admin'),
	$model->sales_office_name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'sales_office_id',
		'distributor.distributor_name',
		'company.name',
		'sales_office_code',
		'sales_office_name',
		'address1',
		'address2',
		'barangay_id',
		'municipal_id',
		'province_id',
		'region_id',
		'latitude',
		'longitude',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
