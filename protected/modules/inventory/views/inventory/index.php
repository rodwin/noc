<?php
$this->breadcrumbs=array(
	'Inventories',
);

?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
