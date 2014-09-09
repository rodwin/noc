<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('admin'),
	$model->supplier_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'supplier_id',
		'supplier_code',
		'supplier_name',
		'contact_person1',
		'contact_person2',
		'telephone',
		'cellphone',
		'fax_number',
		'address1',
		'address2',
		'barangay',
		'municipal',
		'province',
		'region',
		'latitude',
		'longitude',
		'created_date',
		'created_by',
		'update_date',
		'update_by',
),
)); ?>
</div>
