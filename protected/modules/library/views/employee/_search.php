<div class="row">
   <div class="col-md-12">
      <div class="box box-primary">
         <div class="box-body">
            <form class="form-horizontal" role="form">
               <?php $fields = Employee::model()->attributeLabels(); ?>	                
               <!--        <div class="form-group">
                           <label for="Employee_employee_id" class="col-sm-2 control-label"><?php echo $fields['employee_id']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_employee_id" placeholder="<?php echo $fields['employee_id']; ?>" name="Employee[employee_id]">
                           </div>
                       </div>-->

               <div class="form-group">
                  <label for="Employee_employee_code" class="col-sm-2 control-label"><?php echo $fields['employee_code']; ?></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="Employee_employee_code" placeholder="<?php echo $fields['employee_code']; ?>" name="Employee[employee_code]">
                  </div>
               </div>

               <div class="form-group">
                  <label for="Employee_employee_status" class="col-sm-2 control-label"><?php echo $fields['employee_status']; ?></label>
                  <div class="col-sm-3">
                     <?php echo CHtml::dropDownList('Employee_employee_status', '', $employee_status, array('prompt' => 'Select Employee Status', 'class' => 'form-control')); ?>
      <!--               <input type="text" class="form-control" id="Employee_employee_status" placeholder="<?php echo $fields['employee_status']; ?>" name="Employee[employee_status]">-->
                  </div>
               </div>

               <div class="form-group">
                  <label for="Employee_employee_type" class="col-sm-2 control-label"><?php echo $fields['employee_type']; ?></label>
                  <div class="col-sm-3">
                     <?php echo CHtml::dropDownList('Employee_employee_type', '', $employee_type, array('prompt' => 'Select Employee Type', 'class' => 'form-control')); ?>
      <!--                <input type="text" class="form-control" id="Employee_employee_type" placeholder="<?php echo $fields['employee_type']; ?>" name="Employee[employee_type]">-->
                  </div>
               </div>

               <div class="form-group">
                  <label for="Employee_sales_office" class="col-sm-2 control-label"><?php echo $fields['sales_office_id']; ?></label>
                  <div class="col-sm-3">
                     <?php //echo CHtml::dropDownList('Employee_sales_office', '', $sales_office, array('prompt' => 'Select Sales Office', 'class' => 'form-control')); ?>
                     <?php
                     echo CHtml::dropDownList('Employee_sales_office', '', $sales_office, array('prompt' => 'Select Sales Office', 'class' => 'form-control',
                         'ajax' => array(
                             'type' => 'POST',
                             'url' => CController::createUrl('employee/getZoneBySalesOffice'),
                             'update' => '#Employee_zone',
                             'data' => array('sales_office_name' => 'js:this.value',),
                             )));
                     ?>

                  </div>
               </div>

               <div class="form-group">
                  <label for="Employee_zone" class="col-sm-2 control-label"><?php echo $fields['default_zone_id']; ?></label>
                  <div class="col-sm-3">
                     <?php echo CHtml::dropDownList('Employee_zone', '', $zone, array('prompt' => 'Select Zone', 'class' => 'form-control')); ?>
                  </div>
               </div>

               <div class="form-group">
                  <label for="Employee_first_name" class="col-sm-2 control-label"><?php echo $fields['first_name']; ?></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="Employee_first_name" placeholder="<?php echo $fields['first_name']; ?>" name="Employee[first_name]">
                  </div>
               </div>

               <div class="form-group">
                  <label for="Employee_last_name" class="col-sm-2 control-label"><?php echo $fields['last_name']; ?></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="Employee_last_name" placeholder="<?php echo $fields['last_name']; ?>" name="Employee[last_name]">
                  </div>
               </div>

               <div class="form-group">
                  <label for="Employee_middle_name" class="col-sm-2 control-label"><?php echo $fields['middle_name']; ?></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="Employee_middle_name" placeholder="<?php echo $fields['middle_name']; ?>" name="Employee[middle_name]">
                  </div>
               </div>

               <!--        <div class="form-group">
                           <label for="Employee_address1" class="col-sm-2 control-label"><?php echo $fields['address1']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_address1" placeholder="<?php echo $fields['address1']; ?>" name="Employee[address1]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_address2" class="col-sm-2 control-label"><?php echo $fields['address2']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_address2" placeholder="<?php echo $fields['address2']; ?>" name="Employee[address2]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_barangay_id" class="col-sm-2 control-label"><?php echo $fields['barangay_id']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_barangay_id" placeholder="<?php echo $fields['barangay_id']; ?>" name="Employee[barangay_id]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_home_phone_number" class="col-sm-2 control-label"><?php echo $fields['home_phone_number']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_home_phone_number" placeholder="<?php echo $fields['home_phone_number']; ?>" name="Employee[home_phone_number]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_work_phone_number" class="col-sm-2 control-label"><?php echo $fields['work_phone_number']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_work_phone_number" placeholder="<?php echo $fields['work_phone_number']; ?>" name="Employee[work_phone_number]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_birth_date" class="col-sm-2 control-label"><?php echo $fields['birth_date']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_birth_date" placeholder="<?php echo $fields['birth_date']; ?>" name="Employee[birth_date]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_date_start" class="col-sm-2 control-label"><?php echo $fields['date_start']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_date_start" placeholder="<?php echo $fields['date_start']; ?>" name="Employee[date_start]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_date_termination" class="col-sm-2 control-label"><?php echo $fields['date_termination']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_date_termination" placeholder="<?php echo $fields['date_termination']; ?>" name="Employee[date_termination]">
                           </div>
                       </div>-->

               <!--        <div class="form-group">
                           <label for="Employee_supervisor_id" class="col-sm-2 control-label"><?php echo $fields['supervisor_id']; ?></label>
                           <div class="col-sm-3">
               <?php echo CHtml::dropDownList('Employee_supervisor_id', '', $supervisor, array('prompt' => 'Select Supervisor', 'class' => 'form-control')); ?>
                               <input type="text" class="form-control" id="Employee_supervisor_id" placeholder="<?php echo $fields['supervisor_id']; ?>" name="Employee[supervisor_id]">
                           </div>
                       </div>-->

               <!--        <div class="form-group">
                           <label for="Employee_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Employee[created_date]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Employee[created_by]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Employee[updated_date]">
                           </div>
                       </div>
                                       
                       <div class="form-group">
                           <label for="Employee_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="Employee_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Employee[updated_by]">
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