<?php

$this->breadcrumbs = array(
    'Brand Categories',
);
?>


<?php

$this->widget('booster.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
