<?php

$this->breadcrumbs = array(
    Authitem::AUTHITEM_LABEL . 's' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'operations' => $operations,
));
?>