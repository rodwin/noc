<?php
$this->breadcrumbs=array(
	'Images'=>array('admin'),
	$model->image_id,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'image_id',
		'company.name',
		'file_name',
		'url',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
),
)); ?>
</div>
