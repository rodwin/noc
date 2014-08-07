<?php

$this->breadcrumbs = array(
    'Sku Custom Datas' => array('admin'),
    $model->name => array('view', 'id' => $model->custom_data_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'unserialize_attribute' => $unserialize_attribute,
    'sku_custom_data' => $sku_custom_data,
));
?>