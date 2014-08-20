
<div class="col-xs-12 col-md-1 col-lg-4 pull-left">
    <div class="row">

        <?php $sku_image = SkuImage::model()->findByAttributes(array("image_id" => $data->image_id, "sku_id" => $sku_id)); ?>

        <a id="img_thumb" class="thumbnail panel panel-default text-center" style="margin-right: 3px; min-height: 150px; height: 200px;">

            <div class="panel-heading clearfix no-padding">
                <?php if (isset($sku_image)) { ?>
                    <span class="glyphicon glyphicon-check"></span>  
                <?php } else { ?>
                    <input type="checkbox" id="img_assign_chk" name='img[]' value="<?php echo CHtml::encode($data->image_id); ?>" class="img_assign_cls"/> 
                <?php } ?>
            </div>

            <div class="panel-body">

                <?php
                echo CHtml::image('images' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id . DIRECTORY_SEPARATOR . CHtml::encode($data->file_name), "Image", array("style" => "max-height: 100px;", 'class' => 'img-thumbnail'));
                ?>

            </div>

            <p><?php echo CHtml::encode($data->file_name); ?></p>

        </a>

    </div>
</div>