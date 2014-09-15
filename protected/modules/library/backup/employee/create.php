<?php

$this->breadcrumbs = array(
    'Employees' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'employee_status_list' => $employee_status_list,
    'employee_type_list' => $employee_type_list,
    'sales_office_list' => $sales_office_list,
    'so_zones' => $so_zones,
));
?>