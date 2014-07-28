<?php

$this->breadcrumbs = array(
    'Poi Custom Datas' => array('admin'),
    $model->name => array('view', 'id' => $model->custom_data_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'poi_category' => $poi_category,
    'unserialize_attribute' => $unserialize_attribute,
));
?>