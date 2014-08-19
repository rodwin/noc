
<?php

$this->widget('booster.widgets.TbThumbnails', array(
    'dataProvider' => $imgs_dp,
    'itemView' => '_thumb',
    'id' => 'image_thumbnails',
    'emptyText' => 'No image found.',
    'summaryText' => "Showing {start} to {end} of {count} entries",
    'tagName' => 'table',
    'htmlOptions' => array(
        'class' => 'table',
    ),
    'template' =>
    '<tr><td class="pull-right no-padding" style="border: none;">{summary}</td></tr>' .
    '<tr><td style="border: none;">{items}</td></tr>' .
    '<tr><td class="pull-right no-padding" style="border: none; margin-top: -50px; margin-bottom: -50px;">{pager}</td></tr>',
));
?>