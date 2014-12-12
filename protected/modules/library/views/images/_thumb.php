
<div class="col-xs-12 col-md-1 col-lg-2 pull-left">
    <div class="row">

        <a id="sku_img_thumb" class="thumbnail panel panel-default text-center" style="margin-right: 3px; min-height: 150px; height: 200px;">

            <div class="panel-heading clearfix no-padding">
                <input type="checkbox" id="img_delete_chk" name='img[]' value="<?php echo CHtml::encode($data->image_id); ?>" class="img_delete_cls" />           
            </div>

            <div class="panel-body">

                <?php
                echo CHtml::image(CHtml::encode($data->url), "Image", array("style" => "max-height: 100px;", 'class' => 'img-thumbnail', 'title' => CHtml::encode(str_replace("_", " ", $data->file_name))));
                ?>

            </div>

<!--<p><?php // echo CHtml::encode(str_replace("_", " ", $data->file_name));   ?></p>-->
            <p><?php echo CHtml::encode($data->file_name); ?></p>

        </a>

    </div>
</div>