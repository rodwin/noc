<?php

$this->breadcrumbs = array(
    'Images' => array('admin'),
    $model->image_id => array('view', 'id' => $model->image_id),
    'Update',
);
?>


<?php echo $this->renderPartial('_form', array('model' => $model)); ?>