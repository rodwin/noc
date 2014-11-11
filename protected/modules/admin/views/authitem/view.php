<?php
$this->breadcrumbs = array(
    Authitem::AUTHITEM_LABEL . 's' => array('admin'),
    $model->name,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'name',
            'type',
            'description',
            'bizrule',
//		'data',
//		'company.name',
        ),
    ));
    ?>
</div>
