<?php
$this->breadcrumbs = array(
    'Zones' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('zone-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Zone/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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
        'model' => $model, 'sales_office' => $sales_office,
    ));
    ?>
</div><!-- search-form -->

<?php $fields = Zone::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="zone_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['zone_id']; ?></th>-->
                <th><?php echo $fields['zone_name']; ?></th>
                <th><?php echo $fields['sales_office_id']; ?></th>
                <th><?php echo $fields['description']; ?></th>
                <th><?php echo $fields['created_date']; ?></th>
                <th><?php echo $fields['created_by']; ?></th>
                <th><?php echo $fields['updated_date']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#zone_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Zone/data'); ?>",
            "columns": [
//                { "name": "zone_id","data": "zone_id"},
                {"name": "zone_name", "data": "zone_name"}, {"name": "sales_office_name", "data": "sales_office_name"}, {"name": "description", "data": "description"}, {"name": "created_date", "data": "created_date"}, {"name": "created_by", "data": "created_by"}, {"name": "updated_date", "data": "updated_date"}, {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
//                "zone_id": $("#Zone_zone_id").val(),
                "zone_name": $("#Zone_zone_name").val(), "sales_office_name": $("#Zone_sales_office_name").val(), "description": $("#Zone_description").val(), "created_date": $("#Zone_created_date").val(), "created_by": $("#Zone_created_by").val(), "updated_date": $("#Zone_updated_date").val(), });
        });



        jQuery(document).on('click', '#zone_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    $.growl(data, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'success'
                    });

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