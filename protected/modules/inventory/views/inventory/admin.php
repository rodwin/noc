<style>
    .action_qty{
        width: 50px;
    }
    .popModal .popModal_content.popModal_contentOverflow {max-height:250px;}
</style>
<?php
$this->breadcrumbs = array(
    'Inventories' => array('admin'),
    'Manage',
);

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/popModal.min.js', CClientScript::POS_END);
$cs->registerCssFile($baseUrl . '/css/popModal.min.css');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('inventory-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-primary btn-flat')); ?>&nbsp;
<?php echo CHtml::link('Create', array('Inventory/create'), array('class' => 'btn btn-primary btn-flat')); ?>

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

<?php $fields = Inventory::model()->attributeLabels(); ?>
<div class="box-body table-responsive">
    <table id="inventory_table" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo $fields['sku_code']; ?></th>
                <th><?php echo $fields['sku_name']; ?></th>
                <th><?php echo $fields['qty']; ?></th>
                <th><?php echo $fields['uom_id']; ?></th>
                <th>Action Qty <i class="fa fa-fw fa-info-circle" data-toggle="popover" content="And here's some amazing content. It's very engaging. right?"></i></th>
                <th><?php echo $fields['zone_id']; ?></th>
                <th><?php echo $fields['sku_status_id']; ?></th>
                <th><?php echo $fields['expiration_date']; ?></th>
                <th><?php echo $fields['reference_no']; ?></th>
                <th><?php echo $fields['brand_name']; ?></th>
                <th><?php echo $fields['sales_office_name']; ?></th>
                <th>Actions</th>

            </tr>
        </thead>

    </table>
</div>

<div style="display:none">
<div id="content" >
    <div class="box-body">
                
            <a class="btn btn-default btn-block btn-sm" onclick="LoadModal('1')">
                <i class="fa fa-bitbucket"></i> Increase
            </a>
            <a class="btn btn-default btn-block btn-sm" onclick="LoadModal('2')">
                <i class="fa fa-bitbucket"></i> Decrease
            </a>
            <a class="btn btn-default btn-block btn-sm" onclick="LoadModal('3')">
                <i class="fa fa-bitbucket"></i> Convert Unit of Measure
            </a>
            <a class="btn btn-default btn-block btn-sm" onclick="LoadModal('4')">
                <i class="fa fa-bitbucket"></i> Move Items
            </a>
            <a class="btn btn-default btn-block btn-sm" onclick="LoadModal('5')">
                <i class="fa fa-bitbucket"></i> Update Status
            </a>
            <a class="btn btn-default btn-block btn-sm" onclick="LoadModal('6')">
                <i class="fa fa-bitbucket"></i> Apply
            </a>
            
            
	<div class="popModal_footer">
		<button type="button" data-popModalBut="cancel">cancel</button>
	</div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'inventory-trans-form',
            'enableAjaxValidation' => true,
        ));
        ?>
        <div id="transactionDialogContainer">

        </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
        <?php $this->endWidget(); ?>
    </div>
  </div>
</div>


<script type="text/javascript">
    
    var inventory_id = null;
    var loaded = false;
    
    $(function() {
        
        var table = $('#inventory_table').dataTable({
            "filter": false,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": false,
            "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Inventory/data'); ?>",
            "columns": [
                {"name": "sku_code", "data": "sku_code"}, 
                {"name": "sku_name", "data": "sku_name"},
                {"name": "qty", "data": "qty"},
                {"name": "uom_name", "data": "uom_name"},
                {"name": "action_qty", "data": "action_qty", 'sortable': false,"class":'action_qty'},
                {"name": "zone_name", "data": "zone_name"},
                {"name": "sku_status_name", "data": "sku_status_name"},
                {"name": "expiration_date", "data": "expiration_date"}, 
                {"name": "reference_no", "data": "reference_no"}, 
                {"name": "brand_name", "data": "brand_name"}, 
                {"name": "sales_office_name", "data": "sales_office_name"}, 
                {"name": "links", "data": "links", 'sortable': false}
            ]
        });

        $('#btnSearch').click(function() {
            table.fnMultiFilter({
                "sku_code": $("#Inventory_sku_code").val(), 
                "sku_name": $("#Inventory_qty").val(), 
                "qty": $("#Inventory_qty").val(), 
                "zone_name": $("#Inventory_zone_name").val(), 
                "sku_status_name": $("#Inventory_sku_status_name").val(), 
                "expiration_date": $("#Inventory_expiration_date").val(), 
                "reference_no": $("#Inventory_reference_no").val(), 
                "brand_name": $("#Inventory_brand_name").val(), 
                "sales_office_name": $("#Inventory_sales_office_name").val(), 
            });
        });

        // Triggers the Click Event and Shows the Overlay Menu if the Input receives a digital or decimal value.          
        $('table#inventory_table tbody').on('keypress', 'td.action_qty input', function (e) {
            
            if (fnIsQtyKeyOkay(e)) {
                if ((e.which >= 48 && e.which <= 57) || e.which == 46) {
                    
                    /*
                     * TODO:
                     * show context menu to increase, decrease,move, convert, apply
                     */
                    if(loaded === false){
                        
                        inventory_id = $(this).attr("data-id");
                        popModal_id = 
                        $(this).popModal({
                                html : $('#content'),
                                placement : 'bottomLeft',
                                showCloseBut : true,
                                onDocumentClickClose : true,
                                onOkBut : function(){},
                                onCancelBut : function(){},
                                onLoad : function(){
                                    loaded = true;
                                },
                                onClose : function(){
                                    loaded = false;
                                }
                        });
                    }
                }
            } else {
                e.preventDefault();
            }
        });
        
        jQuery(document).on('click', '#inventory_table a.delete', function() {
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
    
    function LoadModal(val){
        
        $('html').popModal("hide");
        
        var qty = $('#action_qty_'+inventory_id).val();
        
        $('#transactionDialogContainer').load(
            '<?php echo Yii::app()->createUrl($this->module->id . '/Inventory/Trans'); ?>&inventory_id=' + inventory_id + '&transaction_type=' + val + ($.isNumeric(qty) ? '&qty=' + qty : '&qty=0'),
            function () {
                $('#myModal').modal('show');
                $('#action_qty_'+inventory_id).popModal("hide");
            }
        );
        
    }
</script>