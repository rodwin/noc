<?php
$this->breadcrumbs = array(
    'Employees' => array('admin'),
    $model->employee_id,
);
?>

<div class="row">
   <?php
   $this->widget('booster.widgets.TbDetailView', array(
       'data' => $model,
       'type' => 'bordered condensed',
       'attributes' => array(
           //'employee_id',
           'company.name',
           'employee_code',
           'employee_status_code',
           'employeeType.employee_type_code',
           'salesOffice.sales_office_name',
           'zone.zone_name',
           'first_name',
           'last_name',
           'middle_name',
           'address1',
           'address2',
           'barangay_id',
           'home_phone_number',
           'work_phone_number',
           'birth_date',
           'date_start',
           'date_termination',
           'password',
           array(
               'name' => 'Supervisor',
               'value' => CHtml::encode($model->fullname)
           ),
           'created_date',
           'created_by',
           'updated_date',
           'updated_by',
       ),
   ));
   ?>
</div>
