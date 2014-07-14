<?php

$this->breadcrumbs = array(
    'Pois' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'poi_category' => $poi_category,
    'poi_sub_category' => $poi_sub_category,));
?>