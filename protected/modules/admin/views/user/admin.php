<?php
$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('user-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create',array('user/create'),array('class'=>'btn btn-primary btn-flat')); ?><br/>
<br/>

<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $fields = User::model()->attributeLabels(); ?>

<div class="box-body table-responsive">
    <table id="user_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['user_id']; ?></th>
                <th><?php echo $fields['user_type_id']; ?></th>
                <th><?php echo $fields['user_name']; ?></th>
                <th><?php echo $fields['status']; ?></th>
                <th><?php echo $fields['first_name']; ?></th>
                <th><?php echo $fields['last_name']; ?></th>
                <th>Actions</th>
                
            </tr>
        </thead>
        
        </table>
</div>

<script type="text/javascript">
$(function() {
    var table = $('#user_table').dataTable({
        "filter": false,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/user/data');?>",
        "columns": [
            { "name": "user_id","data": "user_id"},{ "name": "user_type_id","data": "user_type_id"},{ "name": "user_name","data": "user_name"},{ "name": "status","data": "status"},{ "name": "first_name","data": "first_name"},{ "name": "last_name","data": "last_name"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "user_id": $("#User_user_id").val(),"user_type_id": $("#User_user_type_id").val(),"user_name": $("#User_user_name").val(),"status": $("#User_status").val(),"first_name": $("#User_first_name").val(),"last_name": $("#User_last_name").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#user_table a.delete',function() {
            if(!confirm('Are you sure you want to delete this item?')) return false;
            $.ajax({
                'url':jQuery(this).attr('href')+'&ajax=1',
                'type':'POST',
                'dataType': 'text',
                'success':function(data) {
                   $.growl( { 
                        icon: 'glyphicon glyphicon-info-sign', 
                        message: data 
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