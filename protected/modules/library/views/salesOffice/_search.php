<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = SalesOffice::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="SalesOffice_sales_office_id" class="col-sm-2 control-label"><?php echo $fields['sales_office_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_sales_office_id" placeholder="<?php echo $fields['sales_office_id'];?>" name="SalesOffice[sales_office_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_distributor_id" class="col-sm-2 control-label"><?php echo $fields['distributor_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_distributor_id" placeholder="<?php echo $fields['distributor_id'];?>" name="SalesOffice[distributor_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="SalesOffice_sales_office_code" class="col-sm-2 control-label"><?php echo $fields['sales_office_code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_sales_office_code" placeholder="<?php echo $fields['sales_office_code'];?>" name="SalesOffice[sales_office_code]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_sales_office_name" class="col-sm-2 control-label"><?php echo $fields['sales_office_name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_sales_office_name" placeholder="<?php echo $fields['sales_office_name'];?>" name="SalesOffice[sales_office_name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_address1" class="col-sm-2 control-label"><?php echo $fields['address1'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_address1" placeholder="<?php echo $fields['address1'];?>" name="SalesOffice[address1]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_address2" class="col-sm-2 control-label"><?php echo $fields['address2'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_address2" placeholder="<?php echo $fields['address2'];?>" name="SalesOffice[address2]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_barangay_id" class="col-sm-2 control-label"><?php echo $fields['barangay_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_barangay_id" placeholder="<?php echo $fields['barangay_id'];?>" name="SalesOffice[barangay_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_municipal_id" class="col-sm-2 control-label"><?php echo $fields['municipal_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_municipal_id" placeholder="<?php echo $fields['municipal_id'];?>" name="SalesOffice[municipal_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_province_id" class="col-sm-2 control-label"><?php echo $fields['province_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_province_id" placeholder="<?php echo $fields['province_id'];?>" name="SalesOffice[province_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_region_id" class="col-sm-2 control-label"><?php echo $fields['region_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_region_id" placeholder="<?php echo $fields['region_id'];?>" name="SalesOffice[region_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_latitude" class="col-sm-2 control-label"><?php echo $fields['latitude'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_latitude" placeholder="<?php echo $fields['latitude'];?>" name="SalesOffice[latitude]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_longitude" class="col-sm-2 control-label"><?php echo $fields['longitude'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_longitude" placeholder="<?php echo $fields['longitude'];?>" name="SalesOffice[longitude]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_created_date" placeholder="<?php echo $fields['created_date'];?>" name="SalesOffice[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_created_by" placeholder="<?php echo $fields['created_by'];?>" name="SalesOffice[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="SalesOffice[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="SalesOffice_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="SalesOffice_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="SalesOffice[updated_by]">
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