<?php

$this->breadcrumbs = array(
    'Sales Offices' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'distributors' => $distributors,
    'region' => $region,
    'province' => $province,
    'municipal' => $municipal,
    'barangay' => $barangay,
    'zones' => $zones,
));
?>