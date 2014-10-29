
<?php

$this->widget('booster.widgets.TbThumbnails', array(
    'dataProvider' => $pod_attachment_dp,
    'itemView' => '_thumb',
    'id' => 'attached_thumbnails',
    'emptyText' => 'No attachment found.',
    'summaryText' => "Showing {start} to {end} of {count} entries",
    'tagName' => 'table',
    'htmlOptions' => array(
        'class' => 'table',
    ),
    'template' =>
    '<tr><td class="pull-right no-padding" style="border: none;">{summary}</td></tr>' .
    '<tr><td class="text-center clearfix" style="border: none;">{items}</td></tr>' .
    '<tr><td class="pull-right no-padding" style="border: none; margin-top: -30px; margin-bottom: -70px;">{pager}</td></tr>',
));
?>