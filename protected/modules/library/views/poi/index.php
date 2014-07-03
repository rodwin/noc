<?php
$this->breadcrumbs=array(
	'Pois',
);

?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
