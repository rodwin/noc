<?php
$this->breadcrumbs=array(
	'Sales Offices',
);

?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
