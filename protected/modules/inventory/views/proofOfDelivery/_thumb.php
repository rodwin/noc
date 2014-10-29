
<div class="pull-left" style="margin-top: -30px; font-weight: bold;">
    <?php
    echo CHtml::encode(str_replace("_", " ", $data->file_name));
    ?>
</div>

<div>
    <?php
    echo CHtml::image(CHtml::encode($data->url), "Image", array("style" => "", 'class' => 'img-thumbnail'));
    ?>

    <div class="clearfix"></div>
</div>

<div class="pull-left" style="margin-bottom: -50px; margin-top: 20px;">
    <a class="btn btn-sm btn-default delete_pod_attached" title="Delete" href="<?php echo $this->createUrl('/inventory/proofOfDelivery/deletePODAttachment', array('pod_attachment_id' => $data->pod_attachment_id)); ?>">
        <i class="glyphicon glyphicon-trash"></i>
    </a>&nbsp;
    <a class="btn btn-sm btn-default download_pod_attached" title="Download" href="<?php echo $this->createUrl('/inventory/proofOfDelivery/downloadPODAttachment', array('pod_attachment_id' => $data->pod_attachment_id)); ?>">
        <i class="glyphicon glyphicon-download"></i>
    </a>
</div>