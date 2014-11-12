<?php

$this->breadcrumbs = array(
    Authitem::AUTHITEM_LABEL . 's' => array('admin'),
    $model->name => array('view', 'id' => $model->name),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'selected_so' => $selected_so,
    'operations' => $operations,
    'childs' => $childs,
    'selected_zone' => $selected_zone,
    'selected_brand' => $selected_brand,
));
?>