<?php

$this->breadcrumbs = array(
    'Pois' => array('admin'),
    $model->poi_id => array('view', 'id' => $model->poi_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'poi_category' => $poi_category,
    'poi_sub_category' => $poi_sub_category,
));
?>