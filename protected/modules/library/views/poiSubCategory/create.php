<?php
$this->breadcrumbs=array(
	'Poi Sub Categories'=>array('admin'),
	'Create',
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'poi_category' => $poi_category,)); ?>