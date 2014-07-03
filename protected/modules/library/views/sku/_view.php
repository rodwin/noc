<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('sku_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sku_id),array('view','id'=>$data->sku_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_code')); ?>:</b>
	<?php echo CHtml::encode($data->sku_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::encode($data->company_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brand_id')); ?>:</b>
	<?php echo CHtml::encode($data->brand_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_name')); ?>:</b>
	<?php echo CHtml::encode($data->sku_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_uom_id')); ?>:</b>
	<?php echo CHtml::encode($data->default_uom_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('default_unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->default_unit_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_zone_id')); ?>:</b>
	<?php echo CHtml::encode($data->default_zone_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier')); ?>:</b>
	<?php echo CHtml::encode($data->supplier); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('low_qty_threshold')); ?>:</b>
	<?php echo CHtml::encode($data->low_qty_threshold); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('high_qty_threshold')); ?>:</b>
	<?php echo CHtml::encode($data->high_qty_threshold); ?>
	<br />

	*/ ?>

</div>