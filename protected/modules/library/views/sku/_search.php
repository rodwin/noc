<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = Sku::model()->attributeLabels(); ?>	                
                    <!--        <div class="form-group">
                                <label for="Sku_sku_id" class="col-sm-2 control-label"><?php echo $fields['sku_id']; ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="Sku_sku_id" placeholder="<?php echo $fields['sku_id']; ?>" name="Sku[sku_id]">
                                </div>
                            </div>-->

                    <div class="form-group">
                        <label for="Sku_sku_code" class="col-sm-2 control-label"><?php echo $fields['sku_code']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_sku_code" placeholder="<?php echo $fields['sku_code']; ?>" name="Sku[sku_code]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_brand_id" class="col-sm-2 control-label"><?php echo $fields['brand_id']; ?></label>
                        <div class="col-sm-3">
                            <!--<input type="text" class="form-control" id="Sku_brand_id" placeholder="<?php echo $fields['brand_id']; ?>" name="Sku[brand_id]">-->
                            <?php echo CHtml::dropDownList('Sku_brand_name', '', $brand, array('prompt' => 'Select Brand', 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_sku_name" class="col-sm-2 control-label"><?php echo $fields['sku_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_sku_name" placeholder="<?php echo $fields['sku_name']; ?>" name="Sku[sku_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_description" class="col-sm-2 control-label"><?php echo $fields['description']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_description" placeholder="<?php echo $fields['description']; ?>" name="Sku[description]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_default_uom_id" class="col-sm-2 control-label"><?php echo $fields['default_uom_id']; ?></label>
                        <div class="col-sm-3">
                            <!--<input type="text" class="form-control" id="Sku_default_uom_id" placeholder="<?php echo $fields['default_uom_id']; ?>" name="Sku[default_uom_id]">-->
                            <?php echo CHtml::dropDownList('Sku_default_uom_name', '', $uom, array('prompt' => 'Select UOM', 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_default_unit_price" class="col-sm-2 control-label"><?php echo $fields['default_unit_price']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_default_unit_price" placeholder="<?php echo $fields['default_unit_price']; ?>" name="Sku[default_unit_price]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_type" class="col-sm-2 control-label"><?php echo $fields['type']; ?></label>
                        <div class="col-sm-3">
                            <!--<input type="text" class="form-control" id="Sku_type" placeholder="<?php echo $fields['type']; ?>" name="Sku[type]">-->
                            <?php echo CHtml::dropDownList('Sku_type', '', $sku_category, array('prompt' => 'Select ' . Sku::SKU_LABEL . ' Category', 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div id="sku_sub_category" class="form-group" style="display: none;">
                        <label for="Sku_type" class="col-sm-2 control-label"><?php echo $fields['sub_type']; ?></label>
                        <div class="col-sm-3">
                            <!--<input type="text" class="form-control" id="Sku_type" placeholder="<?php echo $fields['type']; ?>" name="Sku[type]">-->
                            <?php echo CHtml::dropDownList('Sku_sub_type', '', $infra_sub_category, array('prompt' => 'Select ' . Sku::SKU_LABEL . ' Sub Category', 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_default_zone_id" class="col-sm-2 control-label"><?php echo $fields['default_zone_id']; ?></label>
                        <div class="col-sm-3">
                            <!--<input type="text" class="form-control" id="Sku_default_zone_id" placeholder="<?php echo $fields['default_zone_id']; ?>" name="Sku[default_zone_id]">-->
                            <?php echo CHtml::dropDownList('Sku_default_zone_name', '', $zone, array('prompt' => 'Select Zone', 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_supplier" class="col-sm-2 control-label"><?php echo $fields['supplier']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_supplier" placeholder="<?php echo $fields['supplier']; ?>" name="Sku[supplier]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Sku[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Sku[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Sku[updated_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Sku[updated_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_low_qty_threshold" class="col-sm-2 control-label"><?php echo $fields['low_qty_threshold']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_low_qty_threshold" placeholder="<?php echo $fields['low_qty_threshold']; ?>" name="Sku[low_qty_threshold]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Sku_high_qty_threshold" class="col-sm-2 control-label"><?php echo $fields['high_qty_threshold']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Sku_high_qty_threshold" placeholder="<?php echo $fields['high_qty_threshold']; ?>" name="Sku[high_qty_threshold]">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" id="btnSearch" class="btn btn-primary btn-flat">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#Sku_type').change(function() {
        var sku_category = $("#Sku_type").val();

        if (sku_category == "infra") {
            $("#sku_sub_category").show();
        } else {
            $("#sku_sub_category").hide();
            $("#Sku_sub_type").val("");
        }
    });

</script>