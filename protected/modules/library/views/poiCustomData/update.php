<?php

$this->breadcrumbs = array(
    Poi::POI_LABEL . ' Custom Datas' => array('admin'),
    $model->name => array('view', 'id' => $model->custom_data_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'poi_category' => $poi_category,
    'unserialize_attribute' => $unserialize_attribute,
    'poi_custom_data' => $poi_custom_data,
));
?>