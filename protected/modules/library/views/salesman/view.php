<?php
$this->breadcrumbs = array(
    'Salesmen' => array('admin'),
    $model->salesman_name,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'salesman_id',
            'team_leader_id',
            'company.name',
            'salesman_name',
            'salesman_code',
            'salesOffice.sales_office_name',
            'zone.zone_name',
            'mobile_number',
            'device_no',
            'other_fields_1',
            'other_fields_2',
            'other_fields_3',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
            'is_team_leader',
        ),
    ));
    ?>
</div>
