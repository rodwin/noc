<?php

$this->breadcrumbs = array(
    'Pois' => array('admin'),
    $model->short_name => array('view', 'id' => $model->poi_id),
    'Update',
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