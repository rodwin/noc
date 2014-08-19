<?php

$this->breadcrumbs = array(
    Sku::SKU_LABEL => array('admin'),
    $model->sku_name => array('view', 'id' => $model->sku_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_update_form', array(
    'model' => $model,
    'brand' => $brand,
    'uom' => $uom,
    'zone' => $zone,
    'custom_datas' => $custom_datas,
    'sku_convertion' => $sku_convertion,
    'sku_convertion_uom' => $sku_convertion_uom,
    'sku_location_restock' => $sku_location_restock,
    'sku_custom_data' => $sku_custom_data,
    'sku_category' => $sku_category,
    'infra_sub_category' => $infra_sub_category,
    'imgs_dp' => $imgs_dp,
    'sku_imgs_dp' => $sku_imgs_dp,
));
?>