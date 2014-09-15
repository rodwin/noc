<?php

$this->breadcrumbs = array(
    'Employee Types',
);
?>


<?php

$this->widget('booster.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
