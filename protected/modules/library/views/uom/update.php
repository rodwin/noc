<?php

$this->breadcrumbs = array(
    'Uoms' => array('admin'),
    $model->uom_name => array('view', 'id' => $model->uom_id),
    'Update',
);
?>


<?php echo $this->renderPartial('_form', array('model' => $model)); ?>