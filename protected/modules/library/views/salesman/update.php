<?php

$this->breadcrumbs = array(
    'Salesmen' => array('admin'),
    $model->salesman_name => array('view', 'id' => $model->salesman_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'sales_office' => $sales_office,
    'so_zones' => $so_zones,
));
?>