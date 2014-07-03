<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = Poi::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="Poi_poi_id" class="col-sm-2 control-label"><?php echo $fields['poi_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_poi_id" placeholder="<?php echo $fields['poi_id'];?>" name="Poi[poi_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="Poi_short_name" class="col-sm-2 control-label"><?php echo $fields['short_name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_short_name" placeholder="<?php echo $fields['short_name'];?>" name="Poi[short_name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_long_name" class="col-sm-2 control-label"><?php echo $fields['long_name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_long_name" placeholder="<?php echo $fields['long_name'];?>" name="Poi[long_name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_primary_code" class="col-sm-2 control-label"><?php echo $fields['primary_code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_primary_code" placeholder="<?php echo $fields['primary_code'];?>" name="Poi[primary_code]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_secondary_code" class="col-sm-2 control-label"><?php echo $fields['secondary_code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_secondary_code" placeholder="<?php echo $fields['secondary_code'];?>" name="Poi[secondary_code]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_barangay_id" class="col-sm-2 control-label"><?php echo $fields['barangay_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_barangay_id" placeholder="<?php echo $fields['barangay_id'];?>" name="Poi[barangay_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_municipal_id" class="col-sm-2 control-label"><?php echo $fields['municipal_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_municipal_id" placeholder="<?php echo $fields['municipal_id'];?>" name="Poi[municipal_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_province_id" class="col-sm-2 control-label"><?php echo $fields['province_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_province_id" placeholder="<?php echo $fields['province_id'];?>" name="Poi[province_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_region_id" class="col-sm-2 control-label"><?php echo $fields['region_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_region_id" placeholder="<?php echo $fields['region_id'];?>" name="Poi[region_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_sales_region_id" class="col-sm-2 control-label"><?php echo $fields['sales_region_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_sales_region_id" placeholder="<?php echo $fields['sales_region_id'];?>" name="Poi[sales_region_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_latitude" class="col-sm-2 control-label"><?php echo $fields['latitude'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_latitude" placeholder="<?php echo $fields['latitude'];?>" name="Poi[latitude]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_longitude" class="col-sm-2 control-label"><?php echo $fields['longitude'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_longitude" placeholder="<?php echo $fields['longitude'];?>" name="Poi[longitude]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_address1" class="col-sm-2 control-label"><?php echo $fields['address1'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_address1" placeholder="<?php echo $fields['address1'];?>" name="Poi[address1]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_address2" class="col-sm-2 control-label"><?php echo $fields['address2'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_address2" placeholder="<?php echo $fields['address2'];?>" name="Poi[address2]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_zip" class="col-sm-2 control-label"><?php echo $fields['zip'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_zip" placeholder="<?php echo $fields['zip'];?>" name="Poi[zip]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_landline" class="col-sm-2 control-label"><?php echo $fields['landline'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_landline" placeholder="<?php echo $fields['landline'];?>" name="Poi[landline]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_mobile" class="col-sm-2 control-label"><?php echo $fields['mobile'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_mobile" placeholder="<?php echo $fields['mobile'];?>" name="Poi[mobile]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_poi_category_id" class="col-sm-2 control-label"><?php echo $fields['poi_category_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_poi_category_id" placeholder="<?php echo $fields['poi_category_id'];?>" name="Poi[poi_category_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_poi_sub_category_id" class="col-sm-2 control-label"><?php echo $fields['poi_sub_category_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_poi_sub_category_id" placeholder="<?php echo $fields['poi_sub_category_id'];?>" name="Poi[poi_sub_category_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_remarks" class="col-sm-2 control-label"><?php echo $fields['remarks'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_remarks" placeholder="<?php echo $fields['remarks'];?>" name="Poi[remarks]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_status" class="col-sm-2 control-label"><?php echo $fields['status'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_status" placeholder="<?php echo $fields['status'];?>" name="Poi[status]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_created_date" placeholder="<?php echo $fields['created_date'];?>" name="Poi[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_created_by" placeholder="<?php echo $fields['created_by'];?>" name="Poi[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_edited_date" class="col-sm-2 control-label"><?php echo $fields['edited_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_edited_date" placeholder="<?php echo $fields['edited_date'];?>" name="Poi[edited_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_edited_by" class="col-sm-2 control-label"><?php echo $fields['edited_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_edited_by" placeholder="<?php echo $fields['edited_by'];?>" name="Poi[edited_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_verified_by" class="col-sm-2 control-label"><?php echo $fields['verified_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_verified_by" placeholder="<?php echo $fields['verified_by'];?>" name="Poi[verified_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Poi_verified_date" class="col-sm-2 control-label"><?php echo $fields['verified_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Poi_verified_date" placeholder="<?php echo $fields['verified_date'];?>" name="Poi[verified_date]">
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