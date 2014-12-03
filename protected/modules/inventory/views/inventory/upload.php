<?php
$this->breadcrumbs = array(
    'Inventories' => array('admin'),
    'Upload',
);
?>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12">
            <p><h4>Column Headings:</h4></p>
            <small>
                <?php
                $total_col = count($headers);
                foreach ($headers as $key => $value) {
                    ?>
                    <?php echo $value; ?>
                    <?php
                    $total_col--;
                    echo $total_col != 0 ? "," : "";
                }
                ?>
            </small>

            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'upload-inventory-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation' => false,
            ));
            ?>

            <p><h4>File Upload Settings:</h4></p>
            <p class="help-block">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->fileFieldGroup($model, 'doc_file', array('size' => 36, 'maxlength' => 255)); ?>
            <?php echo $form->checkboxGroup($model, 'notify'); ?>


            <div class="form-group">
                <?php echo CHtml::submitButton('Upload', array('class' => 'btn btn-primary btn-flat')); ?>    
                <?php echo CHtml::link('Download Template', array('/inventory/inventory/generateTemplate'), array('class' => 'btn btn-info btn-flat')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<?php $fields = BatchUpload::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="sku_upload_table" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th><?php echo $fields['id']; ?></th>
                <th><?php echo $fields['status']; ?></th>
                <th><?php echo $fields['file_name']; ?></th>
                <th><?php echo $fields['created_date']; ?></th>
                <th><?php echo $fields['total_rows']; ?></th>
                <th><?php echo $fields['failed_rows']; ?></th>
                <th><?php echo $fields['error_message']; ?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($uploads as $key => $value) {

                $status = "";
                switch ($value->status) {
                    case BatchUpload::STATUS_PENDING:
                        $status = '<span class="label label-warning">' . BatchUpload::STATUS_PENDING . '</span>';
                        break;
                    case BatchUpload::STATUS_DONE:
                        $status = '<span class="label label-success">' . BatchUpload::STATUS_DONE . '</span>';
                        break;
                    case BatchUpload::STATUS_WARNING:
                        $status = '<span class="label label-primary">' . BatchUpload::STATUS_WARNING . '</span>';
                        break;
                    case BatchUpload::STATUS_ERROR:
                        $status = '<span class="label label-danger">' . BatchUpload::STATUS_ERROR . '</span>';
                        break;

                    default:
                        break;
                }
                ?>
                <tr>
                    <td><?php echo $value->id; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $value->file_name; ?></td>
                    <td><?php echo date('Y-m-d', strtotime($value->created_date)); ?></td>
                    <td><?php echo $value->total_rows; ?></td>
                    <td><?php echo $value->failed_rows; ?></td>
                    <td><?php echo $value->error_message; ?></td>
                    <td>
                        <div align="center">
                            <?php if ($value->failed_rows > 0) { ?>
                                <a class="view" title="View" data-toggle="tooltip" href="<?php echo $this->createUrl('/inventory/inventory/uploadDetails', array('id' => $value->id)); ?>" data-original-title="View"><i class="glyphicon glyphicon-eye-open"></i></a>
                                <?php } ?>
                        </div>


                    </td>
                </tr>  
            <?php } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(function() {
        $('#sku_upload_table').dataTable({
            "order": [[0, "desc"]]
        });
    });
</script>
