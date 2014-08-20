<?php

$this->breadcrumbs = array(
    Sku::SKU_LABEL => array('admin'),
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
    'sku_category' => $sku_category,
    'infra_sub_category' => $infra_sub_category,
));
?>