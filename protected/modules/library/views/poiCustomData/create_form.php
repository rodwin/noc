
<?php

$this->breadcrumbs = array(
    'Poi Custom Datas' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'unserialize_attribute' => $unserialize_attribute,
    'poi_category' => $poi_category,
));
?>