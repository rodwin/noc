<?php
$this->breadcrumbs = array(
    Poi::POI_LABEL . ' Sub Categories' => array('admin'),
    $model->sub_category_name,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'poi_sub_category_id',
            'company.name',
            'poi_category_id',
            'sub_category_name',
            'description',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
        ),
    ));
    ?>
</div>
