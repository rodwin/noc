<?php
$this->breadcrumbs=array(
	'Poi Custom Datas',
);

?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>