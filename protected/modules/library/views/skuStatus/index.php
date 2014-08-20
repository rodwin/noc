<?php

$this->breadcrumbs = array(
    Sku::SKU_LABEL . ' Status',
);
?>


<?php

$this->widget('booster.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
