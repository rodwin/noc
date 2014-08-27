
<?php

$this->widget('booster.widgets.TbThumbnails', array(
    'dataProvider' => $sku_imgs_dp,
    'itemView' => '_sku_img_thumb',
    'id' => 'sku_image_thumbnails',
    'emptyText' => '<p>You can assign an Image by using the options below.</p>',
    'summaryText' => "Showing {start} to {end} of {count} entries",
    'tagName' => 'table',
    'htmlOptions' => array(
        'class' => 'table',
    ),
    'template' =>
    '<tr><td class="pull-right no-padding" style="border: none; margin-top: -30px;">{summary}</td></tr>' .
    '<tr><td style="border: none;">{items}</td></tr>' .
    '<tr><td class="pull-right no-padding" style="border: none; margin-top: -50px; margin-bottom: -50px;">{pager}</td></tr>',
));
?>