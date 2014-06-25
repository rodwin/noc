<?php
$this->breadcrumbs=array(
	'Companies'=>array('admin'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('company-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create',array('company/create'),array('class'=>'btn btn-primary btn-flat')); ?><br/>
<br/>

<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<div class="box-body table-responsive">
    <table id="company_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>company_id</th>
<th>status_id</th>
<th>industry</th>
<th>code</th>
<th>name</th>
<th>address1</th>
<th>address2</th>
                <th>Actions</th>
                
            </tr>
        </thead>
        
        </table>
</div>

<script type="text/javascript">
$(function() {
    var table = $('#company_table').dataTable({
        "filter": false,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "ajax": "<?php echo Yii::app()->createUrl($this->module->id.'/company/data');?>",
        "columns": [
            { "name": "company_id","data": "company_id"},{ "name": "status_id","data": "status_id"},{ "name": "industry","data": "industry"},{ "name": "code","data": "code"},{ "name": "name","data": "name"},{ "name": "address1","data": "address1"},{ "name": "address2","data": "address2"},            { "name": "links","data": "links", 'sortable': false}
               ]
        });

        $('#btnSearch').click(function(){
            table.fnMultiFilter( { 
                "company_id": $("#Company_company_id").val(),"status_id": $("#Company_status_id").val(),"industry": $("#Company_industry").val(),"code": $("#Company_code").val(),"name": $("#Company_name").val(),"address1": $("#Company_address1").val(),"address2": $("#Company_address2").val(),            } );
        });
        
        
        
        jQuery(document).on('click','#company_table a.delete',function() {
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