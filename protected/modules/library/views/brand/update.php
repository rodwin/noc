<?php

$this->breadcrumbs = array(
    'Brands' => array('admin'),
    $model->brand_name => array('view', 'id' => $model->brand_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'brand_category' => $brand_category,
));
?>