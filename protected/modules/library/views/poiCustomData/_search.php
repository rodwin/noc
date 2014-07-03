<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = PoiCustomData::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="PoiCustomData_custom_data_id" class="col-sm-2 control-label"><?php echo $fields['custom_data_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_custom_data_id" placeholder="<?php echo $fields['custom_data_id'];?>" name="PoiCustomData[custom_data_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="PoiCustomData_name" class="col-sm-2 control-label"><?php echo $fields['name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_name" placeholder="<?php echo $fields['name'];?>" name="PoiCustomData[name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_type" class="col-sm-2 control-label"><?php echo $fields['type'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_type" placeholder="<?php echo $fields['type'];?>" name="PoiCustomData[type]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_data_type" class="col-sm-2 control-label"><?php echo $fields['data_type'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_data_type" placeholder="<?php echo $fields['data_type'];?>" name="PoiCustomData[data_type]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_description" class="col-sm-2 control-label"><?php echo $fields['description'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_description" placeholder="<?php echo $fields['description'];?>" name="PoiCustomData[description]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_required" class="col-sm-2 control-label"><?php echo $fields['required'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_required" placeholder="<?php echo $fields['required'];?>" name="PoiCustomData[required]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_sort_order" class="col-sm-2 control-label"><?php echo $fields['sort_order'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_sort_order" placeholder="<?php echo $fields['sort_order'];?>" name="PoiCustomData[sort_order]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_attribute" class="col-sm-2 control-label"><?php echo $fields['attribute'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_attribute" placeholder="<?php echo $fields['attribute'];?>" name="PoiCustomData[attribute]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_created_date" placeholder="<?php echo $fields['created_date'];?>" name="PoiCustomData[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_created_by" placeholder="<?php echo $fields['created_by'];?>" name="PoiCustomData[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="PoiCustomData[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiCustomData_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiCustomData_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="PoiCustomData[updated_by]">
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