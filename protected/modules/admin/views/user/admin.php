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


<div class="box-body table-responsive">
    <table id="user_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>user_id</th>
<th>company_id</th>
<th>user_type_id</th>
<th>user_name</th>
<th>password</th>
<th>status</th>
<th>first_name</th>
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
            { "name": "user_id","data": "user_id"},{ "name": "company_id","data": "company_id"},{ "name": "user_type_id","data": "user_type_id"},{ "name": "user_name","data": "user_name"},{ "name": "password","data": "password"},{ "name": "status","data": "status"},{ "name": "first_name","data": "first_name"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "user_id": $("#User_user_id").val(),"company_id": $("#User_company_id").val(),"user_type_id": $("#User_user_type_id").val(),"user_name": $("#User_user_name").val(),"password": $("#User_password").val(),"status": $("#User_status").val(),"first_name": $("#User_first_name").val(),            } );
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