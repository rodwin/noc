<?php
$this->breadcrumbs=array(
	'Sku Custom Datas',
);

?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
