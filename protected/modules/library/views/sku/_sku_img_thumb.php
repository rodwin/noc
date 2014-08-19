
<div class="col-xs-12 col-md-1 col-lg-4 pull-left">
    <div class="row">

        <?php $image = Images::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, "image_id" => CHtml::encode($data->image_id))); ?>

        <a id="sku_img_thumb" class="thumbnail panel panel-default text-center" style="margin-right: 3px; min-height: 150px; height: 200px;">

            <div class="panel-heading clearfix no-padding">
                <i class="fa fa-fw fa-times-circle-o pull-right" onclick="deleteSkuImg(<?php echo CHtml::encode($data->sku_image_id); ?>);" style="cursor: pointer;"></i>         
            </div>

            <div class="panel-body">

                <?php
                echo CHtml::image('images' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . $image->file_name, "Image", array("style" => "max-height: 100px;", 'class' => 'img-thumbnail'));
                ?>

            </div>

            <p><?php echo CHtml::encode($image->file_name); ?></p>

        </a>

    </div>
</div>