<?php

$this->breadcrumbs = array(
    Poi::POI_LABEL . ' Sub Categories' => array('admin'),
    'Create',
);
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'poi_category' => $poi_category,)); ?>