<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('poi_category_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->poi_category_id), array('view', 'id' => $data->poi_category_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
    <?php echo CHtml::encode($data->company_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('category_name')); ?>:</b>
    <?php echo CHtml::encode($data->category_name); ?>
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


</div>