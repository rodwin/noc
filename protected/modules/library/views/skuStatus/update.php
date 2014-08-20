<?php

$this->breadcrumbs = array(
    Sku::SKU_LABEL . ' Status' => array('admin'),
    $model->status_name => array('view', 'id' => $model->sku_status_id),
    'Update',
);
?>


<?php echo $this->renderPartial('_form', array('model' => $model)); ?>