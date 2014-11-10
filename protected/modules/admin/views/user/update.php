<?php

$this->breadcrumbs = array(
    'Users' => array('admin'),
    $model->user_name => array('view', 'id' => $model->user_id),
    'Update',
);
?>


<?php

echo $this->renderPartial('_form', array(
    'model' => $model,
    'listCompanies' => $listCompanies,
    'list_role' => $list_role,
));
?>