<?php
$this->breadcrumbs = array(
    'Suppliers' => array('admin'),
    'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('supplier-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Supplier/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php $fields = Supplier::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="supplier_table" class="table table-bordered">
        <thead>
            <tr>
                <!--<th><?php echo $fields['supplier_id']; ?></th>-->
                <th><?php echo $fields['supplier_code']; ?></th>
                <th><?php echo $fields['supplier_name']; ?></th>
                <th><?php echo $fields['contact_person1']; ?></th>
                <th><?php echo $fields['telephone']; ?></th>
                <th><?php echo $fields['address1']; ?></th>
                <th><?php echo $fields['barangay_id']; ?></th>
                <th><?php echo $fields['municipal_id']; ?></th>
                <th><?php echo $fields['province_id']; ?></th>
                <th><?php echo $fields['region_id']; ?></th>
                <th>Actions</th>
            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
    $(function() {
        var table = $('#supplier_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Supplier/data'); ?>",
            "columns": [
//                {"name": "supplier_id", "data": "supplier_id"},
                {"name": "supplier_code", "data": "supplier_code"},
                {"name": "supplier_name", "data": "supplier_name"},
                {"name": "contact_person1", "data": "contact_person1"},
                {"name": "telephone", "data": "telephone"},
                {"name": "address1", "data": "address1"},
                {"name": "barangay_name", "data": "barangay_name"},
                {"name": "municipal_name", "data": "municipal_name"},
                {"name": "province_name", "data": "province_name"},
                {"name": "region_name", "data": "region_name"},
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
//                "supplier_id": $("#Supplier_supplier_id").val(),
                "supplier_code": $("#Supplier_supplier_code").val(),
                "supplier_name": $("#Supplier_supplier_name").val(),
                "contact_person1": $("#Supplier_contact_person1").val(),
                "contact_person2": $("#Supplier_contact_person2").val(),
                "telephone": $("#Supplier_telephone").val(),
                "cellphone": $("#Supplier_cellphone").val(),
            });
        });

        jQuery(document).on('click', '#supplier_table a.delete', function() {
            if (!confirm('Are you sure you want to delete this item?'))
                return false;
            $.ajax({
                'url': jQuery(this).attr('href') + '&ajax=1',
                'type': 'POST',
                'dataType': 'text',
                'success': function(data) {
                    if (data == "1451") {
                        $.growl("Unable to delete", {
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