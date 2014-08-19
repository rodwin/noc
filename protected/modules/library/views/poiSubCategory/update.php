<?php

$this->breadcrumbs = array(
    Poi::POI_LABEL . ' Sub Categories' => array('admin'),
    $model->sub_category_name => array('view', 'id' => $model->poi_sub_category_id),
    'Update',
);
?>


<?php echo $this->renderPartial('_form', array('model' => $model, 'poi_category' => $poi_category,)); ?>