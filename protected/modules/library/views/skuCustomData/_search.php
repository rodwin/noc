<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = SkuCustomData::model()->attributeLabels(); ?>	                
                    <!--                    <div class="form-group">
                                            <label for="SkuCustomData_custom_data_id" class="col-sm-2 control-label"><?php echo $fields['custom_data_id']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="SkuCustomData_custom_data_id" placeholder="<?php echo $fields['custom_data_id']; ?>" name="SkuCustomData[custom_data_id]">
                                            </div>
                                        </div>-->

                    <div class="form-group">
                        <label for="SkuCustomData_name" class="col-sm-2 control-label"><?php echo $fields['name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_name" placeholder="<?php echo $fields['name']; ?>" name="SkuCustomData[name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_type" class="col-sm-2 control-label"><?php echo $fields['type']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_type" placeholder="<?php echo $fields['type']; ?>" name="SkuCustomData[type]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_data_type" class="col-sm-2 control-label"><?php echo $fields['data_type']; ?></label>
                        <div class="col-sm-3">
                            <!--<input type="text" class="form-control" id="SkuCustomData_data_type" placeholder="<?php echo $fields['data_type']; ?>" name="SkuCustomData[data_type]">-->
                            <?php echo CHtml::dropDownList('SkuCustomData_data_type', '', $data_type_list, array('prompt' => 'Select Data Type', 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_description" class="col-sm-2 control-label"><?php echo $fields['description']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_description" placeholder="<?php echo $fields['description']; ?>" name="SkuCustomData[description]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_required" class="col-sm-2 control-label"><?php echo $fields['required']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_required" placeholder="<?php echo $fields['required']; ?>" name="SkuCustomData[required]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_sort_order" class="col-sm-2 control-label"><?php echo $fields['sort_order']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_sort_order" placeholder="<?php echo $fields['sort_order']; ?>" name="SkuCustomData[sort_order]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_attribute" class="col-sm-2 control-label"><?php echo $fields['attribute']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_attribute" placeholder="<?php echo $fields['attribute']; ?>" name="SkuCustomData[attribute]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="SkuCustomData[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="SkuCustomData[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="SkuCustomData[updated_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SkuCustomData_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="SkuCustomData_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="SkuCustomData[updated_by]">
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