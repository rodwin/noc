<?php

$this->breadcrumbs = array(
    'Skus' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_create_form', array(
    'model' => $model,
    'brand' => $brand,
    'uom' => $uom,
    'zone' => $zone,
    'custom_datas' => $custom_datas,
    'sku_custom_data' => $sku_custom_data,
));
?>