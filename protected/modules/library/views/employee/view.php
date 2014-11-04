<?php
$this->breadcrumbs = array(
    'Employees' => array('admin'),
    $model->employee_id,
);
?>
<div class="row">
   <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
         <li class="active"><a href="#tab_1" data-toggle="tab">Employee Details</a></li>
         <li><a href="#tab_2" data-toggle="tab">Assigned POI</a></li>
      </ul>
      <div class="tab-content">
         <div class="tab-pane active" id="tab_1">
            <?php
            $this->widget('booster.widgets.TbDetailView', array(
                'data' => $model,
                'type' => 'bordered condensed',
                'attributes' => array(
                    //'employee_id',
                    'company.name',
                    'employee_code',
                    'employee_status_code',
                    'employeeType.employee_type_code',
                    'salesOffice.sales_office_name',
                    'zone.zone_name',
                    'first_name',
                    'last_name',
                    'middle_name',
                    'address1',
                    'address2',
                    'barangay_id',
                    'home_phone_number',
                    'work_phone_number',
                    'birth_date',
                    'date_start',
                    'date_termination',
                    'password',
                    array(
                        'name' => 'Supervisor',
                        'value' => CHtml::encode($model->fullname)
                    ),
                    'created_date',
                    'created_by',
                    'updated_date',
                    'updated_by',
                ),
            ));
            ?>
         </div>

         <div class="tab-pane" id="tab_2">
            <?php $fields = Poi::model()->attributeLabels(); ?>
            <div class="row-offcanvas-left">
               <h4>Available</h4>
               <table id="employee_poi_available_table" class="table table-bordered table-hover table-striped">
                  <thead>                   
                     <tr>
                        <th><?php echo $fields['short_name']; ?></th>
                        <th><?php echo $fields['long_name']; ?></th>
                        <th><?php echo $fields['primary_code']; ?></th>
                        <th><?php echo $fields['secondary_code']; ?></th>
                        <th><?php echo $fields['poi_category_id']; ?></th>
                        <th><?php echo $fields['poi_sub_category_id']; ?></th>
                        <th><?php echo $fields['barangay_id']; ?></th>
                        <th><?php echo $fields['municipal_id']; ?></th>
                        <th><?php echo $fields['province_id']; ?></th>
                        <th><?php echo $fields['region_id']; ?></th>
                     </tr>    
                  </thead>
               </table>
               <br/><br/>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   //   $(document).ready(function() {
   //    var t = $('#employee_poi_available_table').DataTable();
   //    var counter = 1;
   // 
   //    $('#btn_remove_item').on( 'click', function () {
   //        t.row.add( [
   //            counter +'.1',
   //            counter +'.2',
   //            counter +'.3',
   //            counter +'.4',
   //            counter +'.5',
   //            counter +'.1',
   //            counter +'.2',
   //            counter +'.3',
   //            counter +'.4',
   //            counter +'.5'
   //        ] ).draw();
   // 
   //        counter++;
   //    } );
   // 
   //    // Automatically add a first row of data
   //    $('#btn_remove_item').click();
   //} );
   
   var employee_poi_available_table;
   $(function() {
      employee_poi_available_table = $('#employee_poi_available_table').dataTable({
         "filter": true,
         "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
         "processing": true,
         "serverSide": true,
         "bAutoWidth": false,
         'iDisplayLength': 5,
         "dom": 'l<"text-center"r>t<"pull-left"i><"pull-right"p>',
         "ajax": "<?php echo Yii::app()->createUrl($this->module->id . '/Employee/employeePOIData', array('employee_id' => isset($model->employee_id) ? $model->employee_id : "")); ?>",
         "columns": [
            {"name": "short_name", "data": "short_name"},
            {"name": "long_name", "data": "long_name"},
            {"name": "primary_code", "data": "primary_code"},
            {"name": "secondary_code", "data": "secondary_code"},
            {"name": "poi_category_name", "data": "poi_category_name"},
            {"name": "poi_sub_category_name", "data": "poi_sub_category_name"},
            {"name": "barangay_name", "data": "barangay_name"},
            {"name": "municipal_name", "data": "municipal_name"},
            {"name": "province_name", "data": "province_name"},
            {"name": "region_name", "data": "region_name"},
         ],
         iDisplayLength: -1,
         "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td:eq(11)', nRow).addClass("text-center");}
      });
      
   
   });
</script>

