<?php
$this->breadcrumbs=array(
	'Authitems'=>array('admin'),
	$model->name,
);

?>

<div class="row">
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
		'name',
		'type',
		'description',
		'bizrule',
		'data',
		'company.name',
),
)); ?>
</div>
