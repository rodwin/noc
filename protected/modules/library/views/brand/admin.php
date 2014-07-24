<?php
$this->breadcrumbs = array(
    'Brands' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('brand-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Brand/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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
        'model' => $model, 'brand_category' => $brand_category,
    ));
    ?>
</div><!-- search-form -->

<?php $fields = Brand::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="brand_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['brand_id']; ?></th>-->
                <th><?php echo $fields['brand_category_id']; ?></th>
                <th><?php echo $fields['brand_code']; ?></th>
                <th><?php echo $fields['brand_name']; ?></th>
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
        var table = $('#brand_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Brand/data'); ?>",
            "columns": [
//                { "name": "brand_id","data": "brand_id"},
                {"name": "brand_category_name", "data": "brand_category_name"}, {"name": "brand_code", "data": "brand_code"}, {"name": "brand_name", "data": "brand_name"}, {"name": "created_date", "data": "created_date"}, {"name": "created_by", "data": "created_by"}, {"name": "updated_date", "data": "updated_date"}, {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
//                "brand_id": $("#Brand_brand_id").val(),
                "brand_category_name": $("#Brand_brand_category_name").val(), "brand_code": $("#Brand_brand_code").val(), "brand_name": $("#Brand_brand_name").val(), "created_date": $("#Brand_created_date").val(), "created_by": $("#Brand_created_by").val(), "updated_date": $("#Brand_updated_date").val(), });
        });



        jQuery(document).on('click', '#brand_table a.delete', function() {
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