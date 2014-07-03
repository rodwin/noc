<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('inventory_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->inventory_id),array('view','id'=>$data->inventory_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::encode($data->company_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_id')); ?>:</b>
	<?php echo CHtml::encode($data->sku_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uom_id')); ?>:</b>
	<?php echo CHtml::encode($data->uom_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zone_id')); ?>:</b>
	<?php echo CHtml::encode($data->zone_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_status_id')); ?>:</b>
	<?php echo CHtml::encode($data->sku_status_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_date')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_date); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiration_date')); ?>:</b>
	<?php echo CHtml::encode($data->expiration_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_no')); ?>:</b>
	<?php echo CHtml::encode($data->reference_no); ?>
	<br />

	*/ ?>

</div>