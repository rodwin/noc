<style type="text/css">
   #hide_textbox input { display:none; }
   .hide_row { display: none; }
</style> 
<div class="row">

   <div class="panel panel-default">

      <div class="panel-body">
         <div class="col-md-12">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'employee-form',
                'enableAjaxValidation' => false,
                    ));
            ?>

            <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
              <i class="fa fa-ban"></i>
              <?php echo $form->errorSummary($model); ?></div>
             */ ?>        
            <div class="nav-tabs-custom" id ="custTabs">
               <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Employee Details</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Employee POI</a></li>
               </ul>

               <div class="tab-content" id ="info">
                  <div class="tab-pane active" id="tab_1">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'employee_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>


                           <div class="form-group">
                              <?php //echo $form->textFieldGroup($model,'employee_status',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                              <?php
                              echo $form->dropDownListGroup(
                                      $model, 'employee_status', array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-5',
                                  ),
                                  'widgetOptions' => array(
                                      'data' => $employee_status,
                                      'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Employee Status'),
                                  )
                                      )
                              );
                              ?>
                           </div>


                           <div class="form-group">
                              <?php //echo $form->textFieldGroup($model,'employee_type',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                              <?php
                              echo $form->dropDownListGroup(
                                      $model, 'employee_type', array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-5',
                                  ),
                                  'widgetOptions' => array(
                                      'data' => $employee_type,
                                      'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Employee Type'),
                                  )
                                      )
                              );
                              ?>
                           </div>

                           <div class="form-group">
                              <?php //echo $form->textFieldGroup($model,'employee_type',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                              <?php
                              echo $form->dropDownListGroup(
                                      $model, 'sales_office_id', array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-5',
                                  ),
                                  'widgetOptions' => array(
                                      'data' => $sales_office,
                                      'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Sales Office',
                                          'ajax' => array(
                                              'type' => 'POST',
                                              'url' => CController::createUrl('employee/getZoneByEmployeeID'),
                                              'update' => '#Employee_default_zone_id',
                                              'data' => array('sales_office_id' => 'js:this.value',),
                                      )),
                                  )
                                      )
                              );
                              ?>
                           </div>

                           <div class="form-group">
                              <?php //echo $form->textFieldGroup($model,'employee_type',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                              <?php
                              echo $form->dropDownListGroup(
                                      $model, 'default_zone_id', array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-5',
                                  ),
                                  'widgetOptions' => array(
                                      'data' => $zone,
                                      'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Zone'),
                                  )
                                      )
                              );
                              ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'first_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'last_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'middle_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>

                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'address1', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'address2', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>
                        </div>
                        <div class="col-md-6">



                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'barangay_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'home_phone_number', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)))); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->textFieldGroup($model, 'work_phone_number', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)))); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->datePickerGroup($model, 'birth_date', array('widgetOptions' => array('options' => array('dateFormat' => 'yy-mm-dd'), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => '')); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->datePickerGroup($model, 'date_start', array('widgetOptions' => array('options' => array('dateFormat' => 'yy-M-dd'), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => '')); ?>
                           </div>


                           <div class="form-group">
                              <?php echo $form->datePickerGroup($model, 'date_termination', array('widgetOptions' => array('options' => array('dateFormat' => 'yy-M-dd'), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => '')); ?> <!--Click on Month/Year to select a different Month/Year.-->
                           </div>


                           <div class="form-group">
                              <?php echo $form->passwordFieldGroup($model, 'password', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                           </div>


                           <div class="form-group">
                              <?php //echo $form->textFieldGroup($model,'supervisor_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                              <?php
                              echo $form->dropDownListGroup(
                                      $model, 'supervisor_id', array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-5',
                                  ),
                                  'widgetOptions' => array(
                                      'data' => $supervisor,
                                      'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Supervisor'),
                                  )
                                      )
                              );
                              ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab_2">
                     <div class="box-body table-responsive">  
                        <?php $fields = Poi::model()->attributeLabels(); ?>
                        <?php $fields2 = EmployeePoi::model()->attributeLabels(); ?>
                        <div class="row-offcanvas-left">
                           <h4>Assigned</h4>
                           <table id="employee_poi_assigned_table" class="table table-bordered table-hover table-striped">
                              <thead>                   
                                 <tr>
                                    <th style="text-align: center;"><input type="checkbox" name="assigned" id="all_assigned" /></th>
                                    <th><?php echo $fields['short_name']; ?></th>
                                    <th><?php echo $fields['long_name']; ?></th>
                                    <th><?php echo $fields['primary_code']; ?></th>
                                    <th><?php echo $fields['secondary_code']; ?></th>

                              </thead>
                              <thead>
                                 <tr id="filter_row">
                                    <td class="filter" id="hide_textbox"></td>
                                    <td class="filter"></td>
                                    <td class="filter"></td>
                                    <td class="filter"></td>
                                    <td class="filter"></td>

                                 </tr>
                              </thead>
                           </table>
                        </div>
                        <div class="text-center">
                           <br></br>
                           <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-arrow-up"></i>', array('name' => 'add_item', 'class' => 'btn btn-primary btn-sm span5', 'id' => 'btn_add_item')); ?>
                           <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-arrow-down"></i>', array('name' => 'add_item', 'class' => 'btn btn-primary btn-sm span5', 'id' => 'btn_remove_item')); ?>
                        </div>
                        <div class="row-offcanvas-left">
                           <h4>Available</h4>
                           <table id="employee_poi_available_table" class="table table-bordered table-hover table-striped">
                              <thead>                   
                                 <tr>
                                    <th style="text-align: center;"><input type="checkbox" name="available" id="all_available"/></th>
                                    <th><?php echo $fields['short_name']; ?></th>
                                    <th><?php echo $fields['long_name']; ?></th>
                                    <th><?php echo $fields['primary_code']; ?></th>
                                    <th><?php echo $fields['secondary_code']; ?></th>
                                 </tr>    
                              </thead>
                              <thead>
                                 <tr id="filter_row">
                                    <td class="filter" id="hide_textbox"></td>
                                    <td class="filter"></td>
                                    <td class="filter"></td>
                                    <td class="filter"></td>
                                    <td class="filter"></td>
                                 </tr>
                              </thead>
                           </table>
                           <br></br>
                        </div>
                     </div>
                  </div>
               </div>
            </div>


            <div class="form-group">
               <?php echo CHtml::htmlButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat', 'id' => 'btn_save')); ?>   
               <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?></div>

            <?php $this->endWidget(); ?>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   var employee_poi_available_table;
   var employee_poi_assigned_table;
   var headers = "transaction";
   var details = "details";
   var i = 0; var i2 = 0; var poi_id = "'',";
   var arrsave = new Array(); var arrremove = new Array();
   
   $(function() {
      LoadPOI('<?php echo $model->employee_id; ?>');
      employee_poi_assigned_table = $('#employee_poi_assigned_table').dataTable({
         "filter": true,
         "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
         //         "bSort": false,
         "processing": false,
         "serverSide": false,
         "bAutoWidth": false,
         'iDisplayLength': 5,
         "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td:eq(11)', nRow).addClass("text-center");
            $('td:eq(8)', nRow).addClass("text-right");
         }
      });
      
      employee_poi_available_table = $('#employee_poi_available_table').dataTable({
         "filter": true,
         "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
         //         "bSort": false,
         "processing": false,
         "serverSide": false,
         "bAutoWidth": false,
         'iDisplayLength': 5,
         "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td:eq(11)', nRow).addClass("text-center");
            $('td:eq(8)', nRow).addClass("text-right");
         }
      });
      
      $('#employee_poi_assigned_table thead tr#filter_row td.filter').each(function() {
         $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i + '" />');
         i++;
      });
   
      $('#employee_poi_available_table thead tr#filter_row td.filter').each(function() {
         $(this).html('<input type="text" class="form-control input-sm" placeholder="" colPos="' + i2 + '" />');
         i2++;
      });
      
      $("#employee_poi_available_table thead input").keyup(function() {
         employee_poi_available_table.fnFilter(this.value, $(this).attr("colPos") - 1);
      });
        
      $("#employee_poi_assigned_table thead input").keyup(function() {
         employee_poi_assigned_table.fnFilter(this.value, $(this).attr("colPos") -1);
      });
   
      $('#btn_add_item').click(function() {
         setPOI();
      });
      
      $('#btn_remove_item').click(function() {
         removePOI();
      });
      
      $('#all_available').on('ifChecked', function(event){
         //         $('.available_chk').iCheck('check');
         var elem = document.getElementsByName('poi_row');

         for(var i = 0; i < elem.length; i++)
         {
            elem[i].checked = true;
         }
      });
      
      $('#all_available').on('ifUnchecked', function(event){
         //         $('.available_chk').iCheck('uncheck');
         var elem = document.getElementsByName('poi_row');

         for(var i = 0; i < elem.length; i++)
         {
            elem[i].checked = false;
         }
      });
      
      $('#all_assigned').on('ifChecked', function(event){
         //         $('#assigned_chk').iCheck('check');
         var elem = document.getElementsByName('poi_row2');

         for(var i = 0; i < elem.length; i++)
         {
            elem[i].checked = true;
         }
      });
      
      $('#all_assigned').on('ifUnchecked', function(event){
         //         $('#assigned_chk').iCheck('uncheck');
         var elem = document.getElementsByName('poi_row2');
      
         for(var i = 0; i < elem.length; i++)
         {
            elem[i].checked = false;
         }
      });
      
      
      $('#btn_save').click(function() {
         if (!confirm('Are you sure you want to submit?'))
            return false;
<?php if ($model->isNewRecord) { ?>
            send(headers);
<?php } else { ?>
            sendUpdate(headers);
<?php } ?>
      });
      
   });
   
   function removePOI(){ 
      var poi_ids = new Array(); var chk = new Array();
      console.log("old save: "+arrsave);
      console.log("old remove: "+arrremove);
      $('input[name="poi_row2"]:checked').each(function() {
         console.log(this.id);
         poi_ids.push({
            "poi_id": this.value
         });
         poi_id += "'"+ this.value +"',";
         chk.push (this.value); 
         arrremove.push(this.value);
      });         
  
      if (poi_ids.length > 0){
         $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/Employee/POIIDs2'); ?>'+'&' + $.param({"poi_ids": poi_ids}),
            dataType: "json",
            success: function(data) {  
               $.each(data.data, function(i, v) {
                              
                  employee_poi_available_table.fnAddData([
                     v.checkbox,
                     v.short_name,
                     v.long_name,
                     v.primary_code,
                     v.secondary_code,
                  ]);
               });
              
               for (i=0; i<chk.length; i++){
                  var index = arrsave.indexOf(chk[i]);
                  if(index != -1)arrsave.splice(index, 1);
                  
               }
               var selected = employee_poi_assigned_table.fnGetNodes();
               for (var i = 0; i < selected.length; i++) {
                  $(selected[i]).find('input:checkbox:checked').each(function() {                
                     employee_poi_assigned_table.fnDeleteRow(selected[i]);
                  });
               }
               $('#all_assigned').iCheck('uncheck');
               console.log("new save: "+arrsave);
               console.log("new remove: "+arrremove);   
            },
            error: function(data) {
               alert("Error occured: Please try again.");
            }
         });
      }
   }
   
   function setPOI(){
      var poi_ids = new Array(); var chk = new Array();
      console.log("old save: "+arrsave);
      console.log("old remove: "+arrremove);
      $('input[name="poi_row"]:checked').each(function() {
         console.log(this.id);
         poi_ids.push({
            "poi_id": this.value
         });
         poi_id += "'"+ this.value +"',";
         arrsave.push(this.value);
         chk.push (this.value);
      });
               
      if (poi_ids.length > 0){
         $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/Employee/POIIDs'); ?>'+'&' + $.param({"poi_ids": poi_ids}),
            dataType: "json",
            success: function(data) {  
               $.each(data.data, function(i, v) {
                        
                  employee_poi_assigned_table.fnAddData([
                     v.checkbox,
                     v.short_name,
                     v.long_name,
                     v.primary_code,
                     v.secondary_code,
                  ]);
               });
               
               for (i=0; i<chk.length; i++){
                  var index = arrremove.indexOf(chk[i]);
                  if(index != -1) arrremove.splice(index, 1);
                  
               }
               var selected = employee_poi_available_table.fnGetNodes();
               for (var i = 0; i < selected.length; i++) { 
                  $(selected[i]).find('input:checkbox:checked').each(function() {                
                     employee_poi_available_table.fnDeleteRow(selected[i]);
                  });
               }
               $('#all_available').iCheck('uncheck');
               console.log("new save: "+arrsave);
               console.log("new remove: "+arrremove); 
            },
            error: function(data) {
               alert("Error occured: Please try again.");
            }
         });
      }
   } 
   
   var employee_poi_ids = "";
   function LoadPOI($employee_id){
      if($employee_id != ''){ 
         var poi_ids = new Array();
         $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/Employee/EmployeePOIData'); ?>'+'&' + $.param({"employee_id": $employee_id}),
            dataType: "json",
            success: function(data) {
               $.each(data.data, function(i, v) {
                  employee_poi_assigned_table.fnAddData([
                     v.checkbox,
                     v.short_name,
                     v.long_name,
                     v.primary_code,
                     v.secondary_code,
                  ]);
                  
                  employee_poi_ids += "'"+ v.poi_id +"',";
               });
               FilteredPOI(employee_poi_ids);
            },
            error: function(data) {
               alert("Error occured: Please try again.");
            }
         });
      
      }
      else{ 
         AllPOI();
      } 
   } 
   
   function AllPOI(){   
            
      $.ajax({
         type: 'POST',
         url: '<?php echo Yii::app()->createUrl('/library/Poi/getAllPoiData'); ?>'+'&' + $.param({"poi_id": ''}),
         dataType: "json",
         success: function(data) {  
            $.each(data.data, function(i, v) {
               employee_poi_available_table.fnAddData([
                  v.checkbox,
                  v.short_name,
                  v.long_name,
                  v.primary_code,
                  v.secondary_code,
               ]);
            });
         },
         error: function(data) {
            alert("Error occured: Please try again.");
         }
      });
        
   } 
   
   function FilteredPOI(poi_ids){
      $.ajax({
         type: 'POST',
         url: '<?php echo Yii::app()->createUrl('/library/Poi/getAllPoiData'); ?>'+'&poi_id=' + poi_ids.slice(0, - 1),
         dataType: "json",
         success: function(data) {  
            $.each(data.data, function(i, v) {
               employee_poi_available_table.fnAddData([
                  v.checkbox,
                  v.short_name,
                  v.long_name,
                  v.primary_code,
                  v.secondary_code,
               ]);
            });
         },
         error: function(data) {
            alert("Error occured: Please try again.");
         }
      });
        
   } 
   
   function serializePoiTable() {

      var row_datas = new Array();
      for (var i = 0; i < arrsave.length; i++) {
         
         row_datas.push({
            "poi_id":  arrsave[i]
         });
      }
      return row_datas;
   }
   
   function serializeRemovePoi() {

      var row_datas = new Array();
      for (var i = 0; i < arrremove.length; i++) {
         
         row_datas.push({
            "poi_id":  arrremove[i]
         });
      }
      return row_datas;
   }
   
  
   function send(form){
      var data = $("#employee-form").serialize() + "&form=" + form + '&' + $.param({"assigned_poi": serializePoiTable()}) + '&' + $.param({"remove_poi": serializeRemovePoi()});
     
      if ($("#btn_save, #btn_add_item, #btn_remove_item").is("[disabled=disabled]")) {
         return false;
      }
      else{
         $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/Employee/create'); ?>',
            data: data,
            dataType: "json",beforeSend: function(data) {
               $("#btn_save, #btn_add_item, #btn_remove_item").attr("disabled", "disabled");
               if (form == headers) {
                  $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting Form...');
               }
            },
            success: function(data) {
               validateForm(data);
            },
            error: function(data) {
               alert("Error occured: Please try again.");
               $("#btn_save, #btn_add_item, #btn_remove_item").attr('disabled', false);
               $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');             
            }
         });
      }
      
   }
   
   function sendUpdate(form){
      var data = $("#employee-form").serialize() + "&form=" + form + '&' + $.param({"assigned_poi": serializePoiTable()}) + '&' + $.param({"remove_poi": serializeRemovePoi()});
     
      if ($("#btn_save, #btn_add_item, #btn_remove_item").is("[disabled=disabled]")) {
         return false;
      }
      else{
         $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/Employee/update'); ?>'+'&id=' + '<?php echo $model->employee_id; ?>',
            data: data,
            dataType: "json",beforeSend: function(data) {
               $("#btn_save, #btn_add_item, #btn_remove_item").attr("disabled", "disabled");
               if (form == headers) {
                  $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Submitting Form...');
               }
            },
            success: function(data) {
               validateForm(data);
            },
            error: function(data) {
               alert("Error occured: Please try again.");
               $("#btn_save, #btn_add_item, #btn_remove_item").attr('disabled', false);
               $('#btn_save').html('<i class="glyphicon glyphicon-ok"></i>&nbsp; Save');             
            }
         });
      }
      
   }
   
   function validateForm(data) {
      console.log(data);
      var e = $(".error");
      for (var i = 0; i < e.length; i++) {
         var $element = $(e[i]);

         $element.data("title", "")
         .removeClass("error")
         .tooltip("destroy");
      }

      if (data.success === true) {
         
         if (data.form == headers) {
            window.location = <?php echo '"' . Yii::app()->createAbsoluteUrl($this->module->id . '/Employee') . '"' ?> + "/view&id=" + data.id;
         } 
         //            
      } else {
         $("#btn_save, #btn_add_item, #btn_remove_item").attr('disabled', false);
         $('#btn_save').html('Save');        
         growlAlert(data.type, data.message);

         $.each(JSON.parse(data.error), function(i, v) {
            var element = document.getElementById(i);

            var $element = $(element);
            $element.data("title", v)
            .addClass("error")
            .tooltip();
         });
         
      }
   }
   
   function growlAlert(type, message) {
      $.growl(message, {
         icon: 'glyphicon glyphicon-info-sign',
         type: type
      });
   }
    
   
   
   
   


</script>