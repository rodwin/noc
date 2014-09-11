<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('salesman_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->salesman_id), array('view', 'id' => $data->salesman_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('team_leader_id')); ?>:</b>
    <?php echo CHtml::encode($data->team_leader_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
    <?php echo CHtml::encode($data->company_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('salesman_name')); ?>:</b>
    <?php echo CHtml::encode($data->salesman_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('salesman_code')); ?>:</b>
    <?php echo CHtml::encode($data->salesman_code); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('mobile_number')); ?>:</b>
    <?php echo CHtml::encode($data->mobile_number); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('device_no')); ?>:</b>
    <?php echo CHtml::encode($data->device_no); ?>
    <br />

    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('other_fields_1')); ?>:</b>
      <?php echo CHtml::encode($data->other_fields_1); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('other_fields_2')); ?>:</b>
      <?php echo CHtml::encode($data->other_fields_2); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('other_fields_3')); ?>:</b>
      <?php echo CHtml::encode($data->other_fields_3); ?>
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

      <b><?php echo CHtml::encode($data->getAttributeLabel('is_team_leader')); ?>:</b>
      <?php echo CHtml::encode($data->is_team_leader); ?>
      <br />

     */ ?>

</div>