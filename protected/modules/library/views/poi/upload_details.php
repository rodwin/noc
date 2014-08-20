<?php
$this->breadcrumbs = array(
    Poi::POI_LABEL => array('admin'),
    Poi::POI_LABEL . ' Upload Details',
);
?>

<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'type' => 'bordered condensed',
    'attributes' => array(
        'id',
        'file_name',
        'status',
        'total_rows',
        'failed_rows',
        'type',
        'error_message',
        'created_date',
        'ended_date',
    ),
));
?>

<div class="box-body table-responsive">
    <table id="sku_upload_table" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th style="display: none;"></th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uploads as $key => $value) {
                ?>
                <tr>
                    <td style="display: none;"><?php echo $value->id; ?></td>
                    <td><?php echo $value->message; ?></td>
                </tr>  
            <?php } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(function() {
        $('#sku_upload_table').dataTable({
            "order": [[0, "asc"]]
        });
    });
</script>
