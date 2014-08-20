<?php

$this->breadcrumbs = array(
    Sku::SKU_LABEL . ' Status' => array('admin'),
    'Create',
);
?>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>