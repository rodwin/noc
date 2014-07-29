<?php

$this->breadcrumbs = array(
    'Inventories' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'sku' => $sku,
    'uom' => $uom,
    'zone' => $zone,
    'sku_status' => $sku_status,
));
?>