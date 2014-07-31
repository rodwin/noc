<?php
$this->breadcrumbs=array(
	'Sku'=>array('admin'),
	'Sku Upload Details',
);

?>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
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
)); ?>

<div class="box-body table-responsive">
        <table id="sku_upload_table" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($uploads as $key => $value) {
                    ?>
                   <tr>
                        <td><?php echo $value->message; ?></td>
                    </tr>  
                 <?php } ?>
            </tbody>
        </table>
    </div>
<script type="text/javascript">
    $(function() {
        $('#sku_upload_table').dataTable();
    });
</script>
