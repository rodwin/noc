<?php

$this->breadcrumbs = array(
    Poi::POI_LABEL => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'region' => $region,
    'province' => $province,
    'municipal' => $municipal,
    'barangay' => $barangay,
    'poi_category' => $poi_category,
    'poi_sub_category' => $poi_sub_category,
    'custom_datas' => $custom_datas,
    'poi_custom_data' => $poi_custom_data,
));
?>