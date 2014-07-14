<?php
$this->breadcrumbs=array(
	'Pois'=>array('admin'),
	$model->poi_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'poi_id',
		'company.name',
		'short_name',
		'long_name',
		'primary_code',
		'secondary_code',
		'barangay_id',
		'municipal_id',
		'province_id',
		'region_id',
		'sales_region_id',
		'latitude',
		'longitude',
		'address1',
		'address2',
		'zip',
		'landline',
		'mobile',
		'poiCategory.category_name',
		'poiSubCategory.sub_category_name',
		'remarks',
		'status',
		'created_date',
		'created_by',
		'edited_date',
		'edited_by',
		'verified_by',
		'verified_date',
),
)); ?>
</div>
