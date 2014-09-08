<?php

$this->breadcrumbs = array(
    'Salesmen' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'sales_office' => $sales_office,
    'so_zones' => $so_zones,
));
?>