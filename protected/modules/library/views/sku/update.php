<?php

$this->breadcrumbs = array(
    'Skus' => array('admin'),
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
));
?>