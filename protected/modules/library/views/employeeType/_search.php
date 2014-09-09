<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = EmployeeType::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="EmployeeType_employee_type_id" class="col-sm-2 control-label"><?php echo $fields['employee_type_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeType_employee_type_id" placeholder="<?php echo $fields['employee_type_id'];?>" name="EmployeeType[employee_type_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="EmployeeType_employee_type_code" class="col-sm-2 control-label"><?php echo $fields['employee_type_code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeType_employee_type_code" placeholder="<?php echo $fields['employee_type_code'];?>" name="EmployeeType[employee_type_code]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeType_description" class="col-sm-2 control-label"><?php echo $fields['description'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeType_description" placeholder="<?php echo $fields['description'];?>" name="EmployeeType[description]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeType_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeType_created_date" placeholder="<?php echo $fields['created_date'];?>" name="EmployeeType[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeType_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeType_created_by" placeholder="<?php echo $fields['created_by'];?>" name="EmployeeType[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeType_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeType_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="EmployeeType[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="EmployeeType_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="EmployeeType_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="EmployeeType[updated_by]">
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