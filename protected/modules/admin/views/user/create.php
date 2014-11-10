<?php

$this->breadcrumbs = array(
    'Users' => array('admin'),
    'Create',
);
?>

<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'listCompanies' => $listCompanies,
    'list_role' => $list_role,));
?>