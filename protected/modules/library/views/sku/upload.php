<?php
$this->breadcrumbs = array(
    'Skus' => array('admin'),
    'Upload',
);
?>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
            <div class="col-md-12">
                <p><h4>Column Headings:</h4></p>
                <small>
                    <?php foreach ($headers as $key => $value) {?>
                        <?php echo $value; ?>,
                    <?php }?>
                </small>
                <?php
                
                $form =$this->beginWidget('booster.widgets.TbActiveForm',array(
                        'id'=>'hmo-utilization-form',
                        'htmlOptions' => array('enctype' => 'multipart/form-data'),
                        'enableAjaxValidation'=>false,
                )); ?>

                <p><h4>File Upload Settings:</h4></p>
                <p class="help-block">Fields with <span class="required">*</span> are required.</p>

                <?php echo $form->fileFieldGroup($model, 'doc_file', array('size' => 36, 'maxlength' => 255)); ?>
                <?php echo $form->checkboxGroup($model, 'notify'); ?>


                <div class="form-group">
                    <?php echo CHtml::submitButton('Upload',array('class'=>'btn btn-primary btn-flat')); ?>    
                    <?php echo CHtml::submitButton('Download Template',array('class'=>'btn btn-info btn-flat')); ?>    
                    <?php echo CHtml::submitButton('Download All SKU',array('class'=>'btn btn-info btn-flat')); ?>    
                </div>

                <?php $this->endWidget(); ?>
            </div>
            </div>
        </div>
    </div>
</div>
