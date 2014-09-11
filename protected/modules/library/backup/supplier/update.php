<?php

$this->breadcrumbs = array(
    'Suppliers' => array('admin'),
    $model->supplier_name => array('view', 'id' => $model->supplier_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'region' => $region,
    'province' => $province,
    'municipal' => $municipal,
    'barangay' => $barangay,
));
?>