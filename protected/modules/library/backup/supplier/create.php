<?php

$this->breadcrumbs = array(
    'Suppliers' => array('admin'),
    'Create',
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