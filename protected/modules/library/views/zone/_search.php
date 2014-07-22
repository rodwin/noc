<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = Zone::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="Zone_zone_id" class="col-sm-2 control-label"><?php echo $fields['zone_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Zone_zone_id" placeholder="<?php echo $fields['zone_id'];?>" name="Zone[zone_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Zone_zone_name" class="col-sm-2 control-label"><?php echo $fields['zone_name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Zone_zone_name" placeholder="<?php echo $fields['zone_name'];?>" name="Zone[zone_name]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="Zone_sales_office_id" class="col-sm-2 control-label"><?php echo $fields['sales_office_id'];?></label>
            <div class="col-sm-3">
                <!--<input type="text" class="form-control" id="Zone_sales_office_id" placeholder="<?php echo $fields['sales_office_id'];?>" name="Zone[sales_office_id]">-->
                <?php echo CHtml::dropDownList('Zone_sales_office_name', '', $sales_office, array('prompt' => 'Select Salesoffice', 'class' => 'form-control')); ?>
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Zone_description" class="col-sm-2 control-label"><?php echo $fields['description'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Zone_description" placeholder="<?php echo $fields['description'];?>" name="Zone[description]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Zone_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Zone_created_date" placeholder="<?php echo $fields['created_date'];?>" name="Zone[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Zone_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Zone_created_by" placeholder="<?php echo $fields['created_by'];?>" name="Zone[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Zone_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Zone_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="Zone[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Zone_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Zone_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="Zone[updated_by]">
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