<?php

$this->breadcrumbs = array(
    'Employee Statuses' => array('admin'),
    $model->employee_status_code => array('view', 'id' => $model->employee_status_id),
    'Update',
);
?>


<?php echo $this->renderPartial('_form', array('model' => $model)); ?>