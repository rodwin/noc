<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = EmployeeStatus::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="EmployeeStatus_employee_status_id" class="col-sm-2 control-label"><?php echo $fields['employee_status_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_employee_status_id" placeholder="<?php echo $fields['employee_status_id'];?>" name="EmployeeStatus[employee_status_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="EmployeeStatus_employee_status_code" class="col-sm-2 control-label"><?php echo $fields['employee_status_code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_employee_status_code" placeholder="<?php echo $fields['employee_status_code'];?>" name="EmployeeStatus[employee_status_code]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeStatus_description" class="col-sm-2 control-label"><?php echo $fields['description'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_description" placeholder="<?php echo $fields['description'];?>" name="EmployeeStatus[description]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeStatus_available" class="col-sm-2 control-label"><?php echo $fields['available'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_available" placeholder="<?php echo $fields['available'];?>" name="EmployeeStatus[available]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeStatus_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_created_date" placeholder="<?php echo $fields['created_date'];?>" name="EmployeeStatus[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeStatus_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_created_by" placeholder="<?php echo $fields['created_by'];?>" name="EmployeeStatus[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeStatus_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="EmployeeStatus[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeStatus_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeStatus_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="EmployeeStatus[updated_by]">
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