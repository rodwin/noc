<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	\$model->{$nameColumn},
);\n";
?>

?>

<div class="row">
<?php echo "<?php"; ?> $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'type' => 'bordered condensed',
'attributes'=>array(
<?php
foreach ($this->tableSchema->columns as $column) {
        if($column->name == 'company_id'){
            echo "\t\t'company.name',\n";
        }else{
            echo "\t\t'" . $column->name . "',\n";
        }
}
?>
),
)); ?>
</div>
