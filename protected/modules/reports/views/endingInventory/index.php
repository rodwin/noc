<?php
/* @var $this EndingInventoryController */

$this->breadcrumbs = array(
    'Ending Inventory',
);
?>

<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.date.extensions.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/plugins/input-mask/jquery.inputmask.extensions.js', CClientScript::POS_END);
?>

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"></h3>
    </div>

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'ending-inventory-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <div class="box-body clearfix">

        <div class="col-md-6 clearfix">
            <?php echo $form->labelEx($model, 'sales_office_id', array('class' => 'pull-left')); ?>

            <span class="pull-right"><input type="checkbox" name="all" id="all_warehouse"/>&nbsp; Select All</span>
            <div class="clearfix"></div>
            <div style="max-height: 200px; overflow: scroll; padding: 10px; border: 1px solid #ccc;">

                <?php
                $c = new CDbCriteria;
                $c->condition = "company_id = '". Yii::app()->user->company_id ."' AND t.sales_office_id IN (" . Yii::app()->user->salesoffices . ")";
                $c->order = "sales_office_name asc";
                $sales_offices = SalesOffice::model()->findAll($c);

                foreach ($sales_offices as $v) {
                    ?>
                    <?php echo CHtml::checkBox('so[' . $v->sales_office_id . ']', false, array('class' => 'so_child', 'id' => 'so_child_list[]', 'data-id' => $v->sales_office_id)); ?>&nbsp;
                    <span><?php echo $v->sales_office_name; ?></span>
                    <span class="text-muted">(<?php echo $v->sales_office_code; ?>)</span><br/>

                <?php } ?>
            </div>

            <div class="clearfix"><br/><br/></div>
        </div>

        <div class="col-md-6">
            <div class="clearfix" style="margin-left: 10px; margin-right: 10px;">
                <br/>
                <div class="pull-left" style="width: 30%;">
                    <label>Brand Category</label><br/><br/>
                    <label>Brand</label><br/><br/><br/>
                    <label>Covered Date</label>
                </div>

                <div class="pull-right"  style="width: 70%;">
                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => 'brand_category',
                        'data' => $brand_category,
                        'options' => array(
                            'placeholder' => '',
                            'width' => '100%',
                        ),
                        'htmlOptions' => array(
                            'id' => 'brand_category',
                            'class' => 'form-control', 'style' => 'margin-bottom: 10px;',
                            'prompt' => 'ALL',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('library/brand/loadBrandByBrandCategory'), //or $this->createUrl('loadcities') if '$this' extends CController
                                'update' => '#brand', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                'data' => array('brand_category' => 'js:this.value'),
                            )
                        ),
                    ));
                    ?>

                    <?php
                    $this->widget(
                            'booster.widgets.TbSelect2', array(
                        'name' => 'brand',
                        'data' => null,
                        'options' => array(
                            'placeholder' => '',
                            'width' => '100%',
                        ),
                        'htmlOptions' => array('id' => 'brand', 'class' => 'form-control', 'prompt' => '--'),
                    ));
                    ?><br/>

                    <?php echo $form->textFieldGroup($model, 'cover_date', array('widgetOptions' => array('htmlOptions' => array('class' => ' span5', 'value' => date("Y-m-d"), 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask' => 'data-mask')), 'labelOptions' => array('label' => false))); ?>

                    <div class="form-group"><br/>
                        <?php echo CHtml::htmlButton('Submit', array('class' => 'btn btn-primary btn-flat', 'id' => 'btn_submit')); ?>   
                    </div>
                </div>

            </div>

        </div>

        <?php $this->endWidget(); ?>

        <div class="clearfix"><br/><br/></div>

        <div class="box-body table-responsive">
            <h4 class="control-label text-primary"><b>ENDING INVENTORY REPORT as of: <span id="covered_date_title"></span></b></h4>
           <div id="ajax_loader_table"></div>

            <table id="ending-inventory_table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>WAREHOUSE</th>
                        <th>ZONE</th>
                        <th>BRAND CATEGORY</th>
                        <th>BRAND</th>
                        <th>MM  CODE</th>
                        <th>MM DESCRIPTION</th>
                        <th>MM CATEGORY</th>
                        <th>MM SUB CATEGORY</th>
                        <th>INVENTORY ON HAND</th>
                        <th>UNIT PRICE</th>
                        <th>UOM</th>
                        <th>TOTAL AMOUNT</th>
                    </tr>
                </thead>
            </table>

        </div>

        <?php
        $form = $this->beginWidget(
                'booster.widgets.TbActiveForm', array(
            'action' => $this->createUrl("endingInventory/export"),
            'method' => 'post'
                )
        );
        ?>

        <input type="hidden" id="cover_date_hidden" name="cover_date" value="" />
        <input type="hidden" id="brand_category_hidden" name="brand_category" value="" />
        <input type="hidden" id="brand_hidden" name="brand" value="" />
        <textarea rows="4" cols="50" id="sales_office_ids_hidden" name="sales_office_ids" value="" style="display: none;"></textarea> 

        <div class="form-group col-md-12">
            <?php echo CHtml::submitButton('Export', array('class' => 'btn btn-primary btn-flat', 'style' => 'display: none;', 'id' => 'btn_export')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>


<script type="text/javascript">
    var ending_inventory_table;

    $(function() {

        $("#EndingReportForm_cover_date").datepicker();
        $("[data-mask]").inputmask();

        ending_inventory_table = $('#ending-inventory_table').dataTable({
            "filter": false,
            "processing": false,
            "serverSide": false,
            "bAutoWidth": false
        });

        $('#all_warehouse').on('ifChecked', function(event) {
            $("input.so_child").iCheck('check');

        });

        $('#all_warehouse').on('ifUnchecked', function(event) {
            $("input.so_child").iCheck('uncheck');
        });

    });

    $('#btn_submit').click(function() {
        generatePreviewReport();
    });

    function generatePreviewReport() {

        var data = $("#ending-inventory-form").serialize();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl($this->module->id . '/endingInventory/generateEndingReport'); ?>',
            data: data,
            dataType: "json",
            beforeSend: function(){
               $("#ajax_loader_table").html("<div class=\"img-loader text-center\"><img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" /></div>"); 
            },
            success: function(data) { 
                $("#ajax_loader_table").html(""); 
                
                var e = $(".error");
                for (var i = 0; i < e.length; i++) {
                    var $element = $(e[i]);

                    $element.data("title", "")
                            .removeClass("error")
                            .tooltip("destroy");
                }

                if (data.success === false) {

                    $.each(JSON.parse(data.error), function(i, v) {
                        var element = document.getElementById(i);

                        var $element = $(element);
                        $element.data("title", v)
                                .addClass("error")
                                .tooltip();
                    });
                } else {

                    $("#cover_date_title, #sales_office_ids_hidden").html("");
                    $("#cover_date_hidden, #brand_category_hidden, #brand_hidden").val("");

                    $("#cover_date_title").html(data.covered_date);
                    $("#cover_date_hidden").val(data.hidden_cover_date);
                    $("#brand_category_hidden").val(data.hidden_category);
                    $("#brand_hidden").val(data.hidden_brand);
                    $("#sales_office_ids_hidden").html(data.hidden_warehouse);
                    
                    $("#btn_export").show();

                    ending_inventory_table.fnDeleteRow();
                    $.each(data.row_data, function(i, v) {
                        ending_inventory_table.fnAddData([
                            v.warehouse,
                            v.zone,
                            v.brand_category,
                            v.brand,
                            v.mm_code,
                            v.mm_description,
                            v.mm_category,
                            v.mm_sub_category,
                            v.qty,
                            v.price,
                            v.uom,
                            v.total
                        ]);
                    });
                }



                    document.getElementById("covered_date_title").innerHTML = data['covered_date'];
//                    document.getElementById("txtso").innerHTML = data['hidden_warehouse'];
//                    document.getElementById("txtcategory").innerHTML = data['hidden_category'];
//                    document.getElementById("txtbrand").innerHTML = data['hidden_brand'];
//                    document.getElementById("txtdate").innerHTML = data['date'];
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    }

</script>



