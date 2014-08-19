<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = Images::model()->attributeLabels(); ?>	                
                    <!--                    <div class="form-group">
                                            <label for="Images_image_id" class="col-sm-2 control-label"><?php echo $fields['image_id']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Images_image_id" placeholder="<?php echo $fields['image_id']; ?>" name="Images[image_id]">
                                            </div>
                                        </div>-->

                    <div class="form-group">
                        <label for="Images_file_name" class="col-sm-2 control-label"><?php echo $fields['file_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Images_file_name" placeholder="<?php echo $fields['file_name']; ?>" name="Images[file_name]">
                        </div>
                    </div>

                    <!--                    <div class="form-group">
                                            <label for="Images_url" class="col-sm-2 control-label"><?php echo $fields['url']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Images_url" placeholder="<?php echo $fields['url']; ?>" name="Images[url]">
                                            </div>
                                        </div>-->

                    <div class="form-group">
                        <label for="Images_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Images_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Images[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Images_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Images_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Images[created_by]">
                        </div>
                    </div>

                    <!--                    <div class="form-group">
                                            <label for="Images_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Images_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Images[updated_date]">
                                            </div>
                                        </div>-->

                    <!--                    <div class="form-group">
                                            <label for="Images_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Images_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Images[updated_by]">
                                            </div>
                                        </div>-->
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