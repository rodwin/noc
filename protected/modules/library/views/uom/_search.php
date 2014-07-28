<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = Uom::model()->attributeLabels(); ?>	                
                    <!--                    <div class="form-group">
                                            <label for="Uom_uom_id" class="col-sm-2 control-label"><?php echo $fields['uom_id']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Uom_uom_id" placeholder="<?php echo $fields['uom_id']; ?>" name="Uom[uom_id]">
                                            </div>
                                        </div>-->

                    <div class="form-group">
                        <label for="Uom_uom_name" class="col-sm-2 control-label"><?php echo $fields['uom_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Uom_uom_name" placeholder="<?php echo $fields['uom_name']; ?>" name="Uom[uom_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Uom_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Uom_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Uom[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Uom_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Uom_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Uom[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Uom_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Uom_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Uom[updated_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Uom_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Uom_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Uom[updated_by]">
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