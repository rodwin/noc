<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div class="box-header">
    <h3 class="box-title">Manage Users</h3>                                    
</div><!-- /.box-header -->
<div class="box-body table-responsive">
    <table id="user_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Type</th>
                <th>User Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Status</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
                <th>ID</th>
                <th>User Type</th>
                <th>User Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Status</th>
            </tr>
        </tfoot>
        </table>
</div>
<script type="text/javascript">
            $(function() {
                
                var table = $('#user_table').dataTable({
                    "processing": false,
                    "serverSide": true,
                    "ajax": "<?php echo Yii::app()->createUrl("user/data"); ?>",
                    "columns": [
                        { "name": "id","data": "id"},
                        { "name": "user_type_id","data": "user_type_id"},
                        { "name": "user_name","data": "user_name"},
                        { "name": "first_name","data": "first_name"},
                        { "name": "last_name","data": "last_name"},
                        { "name": "status","data": "status"},
                       ]
                });
                
            });
        </script>