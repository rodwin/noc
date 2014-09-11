<?php
$this->breadcrumbs = array(
    'Uoms' => array('admin'),
    $model->uom_name,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'uom_id',
            'company.name',
            'uom_name',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
        ),
    ));
    ?>
</div>
