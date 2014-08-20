<?php

$this->breadcrumbs = array(
    Poi::POI_LABEL . ' Categories' => array('admin'),
    'Create',
);
?>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>