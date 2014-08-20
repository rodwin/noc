<?php
$this->breadcrumbs = array(
    'Images' => array('admin'),
    $model->file_name,
);
?>

<div class="row">

    <?php echo CHtml::image(Yii::app()->baseUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . CHtml::encode($model->file_name), "Image", array("style" => "max-height: 150px; margin-bottom: 20px;", 'class' => 'img-thumbnail')); ?>

    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'image_id',
            'company.name',
            'file_name',
            'url',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
        ),
    ));
    ?>

</div>
