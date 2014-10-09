

<?php
Yii::app()->clientScript->registerScript('gallery', "
$('.gallery-button').click(function(){
$('#img_gallery').toggle();
return false;
});
");
?>

<div class="row">

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'sku-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="nav-tabs-custom">

        <ul id="tabs" class="nav nav-tabs">
            <?php $active = isset($_POST['active_tab']) ? "" : "active"; ?>
            <li id="tab1" class="<?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 1 ? "active" : $active; ?>"><a href="#tab_1" data-toggle="tab" onclick="getOnclickTabID(1)">Details</a></li>
            <li id="tab2" class="<?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 2 ? "active" : ""; ?>"><a href="#tab_2" data-toggle="tab" onclick="getOnclickTabID(2)">Settings</a></li>
            <li id="tab3" class="<?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 3 ? "active" : ""; ?>"><a href="#tab_3" data-toggle="tab" onclick="getOnclickTabID(3)">Restock</a></li>
            <li id="tab5" class="<?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 4 ? "active" : ""; ?>"><a href="#tab_4" data-toggle="tab" onclick="getOnclickTabID(4)">&#x20b1; Values</a></li>
        </ul>

        <?php echo CHtml::hiddenField("active_tab", isset($_POST['active_tab']) ? $_POST['active_tab'] : "1") ?>
        <?php echo CHtml::hiddenField("sku_id", isset($model) ? $model->sku_id : "") ?>

        <div class="tab-content">

            <div class="tab-pane <?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 1 ? "active" : $active; ?>" id="tab_1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-5">

                            <div class="form-group">
                                <?php echo $form->textFieldGroup($model, 'sku_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                            </div>

                            <div class="form-group">
                                <?php // echo $form->textFieldGroup($model, 'brand_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50))));   ?>
                                <?php
                                echo $form->dropDownListGroup(
                                        $model, 'brand_id', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                    ),
                                    'widgetOptions' => array(
                                        'data' => $brand,
                                        'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Brand'),
                                )));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->textFieldGroup($model, 'sku_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 150)))); ?>  
                            </div>

                            <div class="form-group">
                                <?php echo $form->textFieldGroup($model, 'description', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 150)))); ?>  
                            </div>

                            <div id="sku_custom_datas">

                                <?php
                                echo $this->renderPartial('_customItems_update', array('model' => $model, 'custom_datas' => $custom_datas, 'sku_custom_data' => $sku_custom_data, 'form' => $form,));
                                ?>

                            </div>

                            <div class="form-group">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'default', 'class' => 'btn btn-primary btn-flat')); ?>&nbsp;
                                <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
                            </div>   

                        </div>

                        <div class="col-md-7">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h4 class="box-title text-primary">Images</h4>
                                </div>
                                <div class="box-body">

                                    <?php echo $this->renderPartial('_sku_images', array('sku_imgs_dp' => $sku_imgs_dp,)); ?>

                                </div>

                            </div>

                            <?php echo CHtml::link('Assign from Gallery', '#', array('class' => 'gallery-button btn btn-default btn-sm btn-flat')); ?>

                            <div id="img_gallery" class="search-form panel panel-default" style="display:none">
                                <div class="panel-heading">
                                    <h3 class="panel-title clearfix no-padding">

                                        <div class="input-group col-md-6 pull-right">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                            <?php
                                            echo CHtml::textField(
                                                    'file_name', '', array(
                                                'id' => 'img_search',
                                                'class' => "form-control input-sm",
                                                'placeholder' => 'Search',
                                                'onkeyup' => CHtml::ajax(
                                                        array(
                                                            'type' => 'POST',
                                                            'url' => $this->createUrl('/library/sku/ajaxFilterImages', array('sku_id' => $model->sku_id)),
                                                            'data' => 'js:jQuery(this).serialize()',
                                                            'success' => 'js:function(data){ $("#image_thumbnails").html(data); }'
                                                )),
                                            ));
                                            ?>
                                        </div>

                                    </h3>
                                </div>
                                <div class="panel-body">

                                    <button type="button" id="assign_img" class="btn btn-primary btn-sm btn-flat pull-left">
                                        <span>Assign Image</span>
                                    </button>&nbsp;

                                    <button type="button" id="close_img_gallery" class="btn btn-default btn-sm btn-flat">
                                        <span>Close</span>
                                    </button>

                                    <div>
                                        <?php echo $this->renderPartial('_images', array('imgs_dp' => $imgs_dp, 'sku_id' => $model->sku_id,)); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="tab-pane <?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 2 ? "active" : ""; ?>" id="tab_2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">

                            <h4 class="control-label text-primary"><b>Item Settings</b></h4>

                            <div class="form-group">
                                <?php // echo $form->textFieldGroup($model, 'default_uom_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50))));   ?>
                                <?php
                                echo $form->dropDownListGroup(
                                        $model, 'default_uom_id', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                    ),
                                    'widgetOptions' => array(
                                        'data' => $uom,
                                        'htmlOptions' => array('multiple' => false, 'prompt' => 'Select UOM'),
                                )));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->textFieldGroup($model, 'default_unit_price', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 18)))); ?>
                            </div>

                            <div class="form-group">
                                <?php // echo $form->textFieldGroup($model, 'type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                                <?php
                                echo $form->dropDownListGroup(
                                        $model, 'type', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                    ),
                                    'widgetOptions' => array(
                                        'data' => $sku_category,
                                        'htmlOptions' => array('multiple' => false, 'prompt' => 'Select ' . Sku::SKU_LABEL . ' Category', 'id' => 'sku_category',),
                                )));
                                ?>
                            </div>

                            <div id="sku_sub_category" class="form-group" style="<?php echo isset($model->type) && $model->type == Sku::INFRA ? "display: block;" : "display: none;"; ?>">
                                <?php
                                echo $form->dropDownListGroup(
                                        $model, 'sub_type', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                    ),
                                    'widgetOptions' => array(
                                        'data' => $infra_sub_category,
                                        'htmlOptions' => array('multiple' => false, 'prompt' => 'Select ' . Sku::SKU_LABEL . ' Sub Category'), 'id' => 'sku_sub_type',
                                )));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php // echo $form->textFieldGroup($model, 'default_zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50))));   ?>
                                <?php
                                echo $form->dropDownListGroup(
                                        $model, 'default_zone_id', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                    ),
                                    'widgetOptions' => array(
                                        'data' => $zone,
                                        'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Zone'),
                                )));
                                ?>
                            </div>


                            <div class="form-group">
                                <?php echo $form->textFieldGroup($model, 'supplier', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 250)))); ?>
                            </div>

                            <div class="form-group">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat')); ?>
                            </div>                              

                        </div>
                    </div>
                </div>

            </div>

            <div class="tab-pane <?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 3 ? "active" : ""; ?>" id="tab_3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">

                            <h4 class="control-label text-primary"><b>Restock Levels</b></h4>

                            <div class="form-group">
                                <?php // echo $form->textFieldGroup($model, 'low_qty_threshold', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5'))));   ?>
                                <?php
                                echo $form->textFieldGroup(
                                        $model, 'low_qty_threshold', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                    ),
                                    'append' => !empty($model->defaultUom->uom_name) ? $model->defaultUom->uom_name : ""
                                ));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php // echo $form->textFieldGroup($model, 'high_qty_threshold', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5'))));   ?>
                                <?php
                                echo $form->textFieldGroup(
                                        $model, 'high_qty_threshold', array(
                                    'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                    ),
                                    'append' => !empty($model->defaultUom->uom_name) ? $model->defaultUom->uom_name : ""
                                ));
                                ?>
                            </div>

                            <div class="form-group">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat')); ?>
                            </div>    

                        </div>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="tab_4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">



                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div> 

    <?php $this->endWidget(); ?>    

</div>

<div id="sku_convertion_div" class="row" style="display: <?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 2 ? "block" : "none"; ?>">
    <div class="box box-primary">
        <div class="box-header">
            <h4 class="box-title text-primary">Units of Measure Conversions for Calculating Restock Triggers</h4>
        </div>
        <div class="box-body">
            <div id="sku_img_div">
                <?php
                echo $this->renderPartial('_sku_convertion', array('model' => $model, 'sku_convertion' => $sku_convertion, 'sku_convertion_uom' => $sku_convertion_uom,));
                ?> 
            </div>
        </div>
    </div>
</div>

<div id="sku_location_restock_div" class="row" style="display: <?php echo isset($_POST['active_tab']) && $_POST['active_tab'] == 3 ? "block" : "none"; ?>">
    <div class="box box-primary">
        <div class="box-header">
            <h4 class="box-title text-primary">Location Restock Levels</h4>
        </div>
        <div class="box-body">
            <?php
            echo $this->renderPartial('_sku_location_restock', array('model' => $model, 'sku_location_restock' => $sku_location_restock, 'zone' => $zone,));
            ?> 
        </div>
    </div>
</div>


<script type="text/javascript">

    $('#assign_img').click(function() {
        $(':checkbox[name="img[]"]:checked').each(function() {
            $.ajax({
                'url': '<?php echo $this->createUrl('/library/sku/skuImage', array('sku_id' => $model->sku_id)) ?>' + '&ajax=1',
                'type': 'POST',
                'data': {
                    sku_id: $("#sku_id").val(),
                    img_id: this.value
                },
                'dataType': 'text',
                'success': function(data) {
                    $("#sku_image_thumbnails").html(data);
                    ajaxLoadImages();
                    $("#img_search").val("");
                },
                error: function(jqXHR, exception) {
                }
            });
        });
    });

    function ajaxLoadImages() {
        $.ajax({
            'url': '<?php echo $this->createUrl('/library/sku/ajaxLoadImages', array('sku_id' => $model->sku_id)) ?>' + '&ajax=1',
            'dataType': 'text',
            'success': function(data) {
                $("#image_thumbnails").html(data);
            },
            error: function(jqXHR, exception) {
            }
        });
    }

    $('.gallery-button').click(function() {
        $(".gallery-button").hide();
    });

    $('#close_img_gallery').click(function() {
        $(".gallery-button").show();
        $("#img_gallery").hide();
    });

    function deleteSkuImg(sku_img_id) {
        $.ajax({
            'url': '<?php echo $this->createUrl('/library/sku/deleteSkuImage', array('sku_id' => $model->sku_id)) ?>' + '&ajax=1',
            'type': 'POST',
            'data': {
                sku_img_id: sku_img_id
            },
            'dataType': 'text',
            'success': function(data) {
                $("#sku_image_thumbnails").html(data);
                ajaxLoadImages();
            },
            error: function(jqXHR, exception) {
            }
        });
    }

    function getOnclickTabID(id) {

        jQuery("[id=active_tab]").val(id);
        if (id == 2) {
            $("#sku_location_restock_div").hide();
            $("#sku_convertion_div").show();
        } else if (id == 3) {
            $("#sku_convertion_div").hide();
            $("#sku_location_restock_div").show();
        } else {
            $("#sku_convertion_div, #sku_location_restock_div").hide();
        }

    }

    function onlyDotsAndNumbers(txt, event, dots) {

        var charCode = (event.which) ? event.which : event.keyCode;
        if (charCode == 46) {
            if (dots == 0) {
                return false;
            }
            if (txt.value.indexOf(".") < 0) {
                return true;
            } else {
                return false;
            }
        }

        if (txt.value.indexOf(".") > 0) {
            var txtlen = txt.value.length;
            var dotpos = txt.value.indexOf(".");
            if ((txtlen - dotpos) > dots) {
                return false;
            }
        }

        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $('#sku_category').change(function() {
        var sku_category = $("#sku_category").val();

        if (sku_category == "INFRA") {
            $("#sku_sub_category").show();
        } else {
            $("#sku_sub_category").hide();
            $("#sku_sub_type").val("");
        }
    });

</script>