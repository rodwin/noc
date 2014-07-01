<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	'Manage',
);\n";
?>


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo "<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>"; ?>
&nbsp;
<?php echo "<?php echo CHtml::link('Create',array('";?><?php echo $this->class2id($this->modelClass); ?><?php echo "/create'),array('class'=>'btn btn-primary btn-flat')); ?>\n";?>

<div class="btn-group">
    <button type="button" class="btn btn-info btn-flat">More Options</button>
    <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="#">Download All Records</a></li>
        <li><a href="#">Download All Filtered Records</a></li>
        <li><a href="#">Upload</a></li>
    </ul>
</div>

<br/>
<br/>

<div class="search-form" style="display:none">
	<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php \$fields = ".$this->modelClass."::model()->attributeLabels(); ?>";?>

<div class="box-body table-responsive">
    <table id="<?php echo $this->class2id($this->modelClass); ?>_table" class="table table-bordered">
        <thead>
            <tr>
                <?php
                $count = 0;
                foreach ($this->tableSchema->columns as $column) {
                        if ($count >6) {
                                continue;
                        }
                        
                        if($column->name == 'company_id'){
                            continue;
                        }
                        
                        echo "<th><?php echo \$fields['".$column->name."']; ?></th>\n";
                        $count++;
                }
                
                ?>
                <th>Actions</th>
                
            </tr>
        </thead>
        
        </table>
</div>

<script type="text/javascript">
$(function() {
    var table = $('#<?php echo $this->class2id($this->modelClass); ?>_table').dataTable({
        "filter": false,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "ajax": "<?php echo "<?php echo Yii::app()->createUrl(\$this->module->id."?>'/<?php echo $this->class2id($this->modelClass); ?>/data');?>",
        "columns": [
            <?php
                $count = 0;
                
                foreach ($this->tableSchema->columns as $column) {
                        if ($count >6) {
                                continue;
                        }
                        if($column->name == 'company_id'){
                            continue;
                        }
                        echo '{ "name": "'. $column->name.'","data": "'. $column->name.'"},';
                        $count++;
                }
                
            ?>
            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                <?php
                $count=0;
                foreach ($this->tableSchema->columns as $column) {
                        if ($count >6) {
                                continue;
                        }
                        if($column->name == 'company_id'){
                            continue;
                        }
                        echo '"'.$column->name.'": $("#'.$this->modelClass.'_'.$column->name.'").val(),';
                        $count++;
                }
                ?>
            } );
        });
        
        
        
        jQuery(document).on('click','#<?php echo $this->class2id($this->modelClass); ?>_table a.delete',function() {
            if(!confirm('Are you sure you want to delete this item?')) return false;
            $.ajax({
                'url':jQuery(this).attr('href')+'&ajax=1',
                'type':'POST',
                'dataType': 'text',
                'success':function(data) {
                   $.growl( data, { 
                        icon: 'glyphicon glyphicon-info-sign', 
                        type: 'success'
                    });
                    
                    table.fnMultiFilter();
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: '+ exception);
                }
            });  
            return false;
        });
    });
</script>