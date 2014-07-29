<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('inventory_history_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->inventory_history_id),array('view','id'=>$data->inventory_history_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::encode($data->company_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inventory_id')); ?>:</b>
	<?php echo CHtml::encode($data->inventory_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_change')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_change); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('running_total')); ?>:</b>
	<?php echo CHtml::encode($data->running_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action')); ?>:</b>
	<?php echo CHtml::encode($data->action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost_unit')); ?>:</b>
	<?php echo CHtml::encode($data->cost_unit); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ave_cost_per_unit')); ?>:</b>
	<?php echo CHtml::encode($data->ave_cost_per_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	*/ ?>

</div>