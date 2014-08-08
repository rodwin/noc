<?php
$this->breadcrumbs = array(
    'Sku Custom Datas' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sku-custom-data-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('SkuCustomData/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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
    <?php
    $this->renderPartial('_search', array(
        'model' => $model, 'data_type_list' => $data_type_list,
    ));
    ?>
</div><!-- search-form -->

<?php $fields = SkuCustomData::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="sku-custom-data_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['custom_data_id']; ?></th>-->
                <th><?php echo $fields['name']; ?></th>
                <!--<th><?php echo $fields['type']; ?></th>-->
                <th><?php echo $fields['data_type']; ?></th>
                <th><?php echo $fields['description']; ?></th>
                <th><?php echo $fields['required']; ?></th>
                <th><?php echo $fields['sort_order']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#sku-custom-data_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/SkuCustomData/data'); ?>",
            "columns": [
                {"name": "name", "data": "name"},
//                {"name": "type", "data": "type"}, 
                {"name": "data_type", "data": "data_type"}, {"name": "description", "data": "description"}, {"name": "required", "data": "required"}, {"name": "sort_order", "data": "sort_order"}, {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
                "name": $("#SkuCustomData_name").val(),
//                "type": $("#SkuCustomData_type").val(), 
                "data_type": $("#SkuCustomData_data_type").val(), "description": $("#SkuCustomData_description").val(), "required": $("#SkuCustomData_required").val(), "sort_order": $("#SkuCustomData_sort_order").val(), });
        });



        jQuery(document).on('click', '#sku-custom-data_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    if (data == "1451") {
                        $.growl("Unable to deleted", {
                            icon: 'glyphicon glyphicon-warning-sign',
                            type: 'danger'
                        });
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });
                    }

                    table.fnMultiFilter();
                },
                error: function(jqXHR, exception) {
                    alert('An error occured: ' + exception);
                }
            });
            return false;
        });
    });
</script>