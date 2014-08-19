<?php

$this->breadcrumbs = array(
    Poi::POI_LABEL . ' Categories' => array('admin'),
    $model->category_name => array('view', 'id' => $model->poi_category_id),
    'Update',
);
?>


<?php echo $this->renderPartial('_form', array('model' => $model)); ?>