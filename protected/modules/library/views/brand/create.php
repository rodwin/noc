<?php

$this->breadcrumbs = array(
    'Brands' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'brand_category' => $brand_category,
));
?>