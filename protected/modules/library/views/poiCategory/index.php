<?php
$this->breadcrumbs=array(
	'Poi Categories',
);

?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
