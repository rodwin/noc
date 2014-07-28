<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = Brand::model()->attributeLabels(); ?>	                
                    <!--                    <div class="form-group">
                                            <label for="Brand_brand_id" class="col-sm-2 control-label"><?php echo $fields['brand_id']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Brand_brand_id" placeholder="<?php echo $fields['brand_id']; ?>" name="Brand[brand_id]">
                                            </div>
                                        </div>-->

                    <div class="form-group">
                        <label for="Brand_brand_category_id" class="col-sm-2 control-label"><?php echo $fields['brand_category_id']; ?></label>
                        <div class="col-sm-3">
                            <!--<input type="text" class="form-control" id="Brand_brand_category_id" placeholder="<?php echo $fields['brand_category_id']; ?>" name="Brand[brand_category_id]">-->
                            <?php echo CHtml::dropDownList('Brand_brand_category_name', '', $brand_category, array('prompt' => 'Select Category', 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Brand_brand_code" class="col-sm-2 control-label"><?php echo $fields['brand_code']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Brand_brand_code" placeholder="<?php echo $fields['brand_code']; ?>" name="Brand[brand_code]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Brand_brand_name" class="col-sm-2 control-label"><?php echo $fields['brand_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Brand_brand_name" placeholder="<?php echo $fields['brand_name']; ?>" name="Brand[brand_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Brand_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Brand_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Brand[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Brand_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Brand_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Brand[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Brand_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Brand_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Brand[updated_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Brand_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Brand_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Brand[updated_by]">
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