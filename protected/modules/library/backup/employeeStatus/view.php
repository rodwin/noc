<?php
$this->breadcrumbs = array(
    'Employee Statuses' => array('admin'),
    $model->employee_status_code,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'employee_status_id',
            'company.name',
            'employee_status_code',
            'description',
            'available',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
        ),
    ));
    ?>
</div>
