<?php
$this->breadcrumbs = array(
    Sku::SKU_LABEL . ' Status' => array('admin'),
    $model->status_name,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'sku_status_id',
            'company.name',
            'status_name',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
        ),
    ));
    ?>
</div>
