<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="row">
    
<div class="panel panel-default">
    
  <div class="panel-body">
    <div class="col-md-8">
<?php echo "<?php \$form=\$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

 <?php echo "<?php /*if(\$form->errorSummary(\$model)){?>";?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <?php echo "<?php echo \$form->errorSummary(\$model); ?>";?>
</div>
<?php echo "*/ ?>";?>
        

<?php
foreach ($this->tableSchema->columns as $column) {
//	if ($column->autoIncrement) {
//		continue;
//	}
    
	if ($this->tableSchema->primaryKey == $column->name) {
		continue;
	}
        
        if (strpos($column->name,'company_id') !== false) 
		continue;
        
        if (strpos($column->name,'created_date') !== false) 
		continue;
        
	if (strpos($column->name,'created_by') !== false) 
		continue;
        
        if (strpos($column->name,'updated_date') !== false) 
		continue;
        
        if (strpos($column->name,'updated_by') !== false) 
		continue;
        
        if (strpos($column->name,'deleted_date') !== false) 
		continue;
        
        if (strpos($column->name,'deleted_by') !== false) 
		continue;
        
        if (strpos($column->name,'deleted') !== false) 
		continue;
        
	?>
	
	<div class="form-group">
		<?php echo "<?php echo " . $this->generateActiveGroup($this->modelClass, $column) . "; ?>\n"; ?>
	</div>

<?php
}
?>

<div class="form-group">
    <?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-flat')); ?>";?>
    <?php echo "<?php echo CHtml::resetButton('Reset',array('class'=>'btn btn-primary btn-flat')); ?>"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
    </div>
  </div>
</div>
</div>