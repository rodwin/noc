<?php

$this->breadcrumbs = array(
    Poi::POI_LABEL,
);
?>


<?php

$this->widget('booster.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
