<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = SkuStatus::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="SkuStatus_sku_status_id" class="col-sm-2 control-label"><?php echo $fields['sku_status_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SkuStatus_sku_status_id" placeholder="<?php echo $fields['sku_status_id'];?>" name="SkuStatus[sku_status_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="SkuStatus_status_name" class="col-sm-2 control-label"><?php echo $fields['status_name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SkuStatus_status_name" placeholder="<?php echo $fields['status_name'];?>" name="SkuStatus[status_name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SkuStatus_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SkuStatus_created_date" placeholder="<?php echo $fields['created_date'];?>" name="SkuStatus[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SkuStatus_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SkuStatus_created_by" placeholder="<?php echo $fields['created_by'];?>" name="SkuStatus[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SkuStatus_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SkuStatus_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="SkuStatus[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SkuStatus_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SkuStatus_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="SkuStatus[updated_by]">
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