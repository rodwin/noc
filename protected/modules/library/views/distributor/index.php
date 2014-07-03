<?php
$this->breadcrumbs=array(
	'Distributors',
);

?>


<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
