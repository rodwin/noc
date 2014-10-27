<div class="view">
 <div class="form-group">
            <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'attendance-form',
                    'enableAjaxValidation' => false,
                    'type'=>'horizontal',
                ));
                ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'agency', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' =>$agency,
                            'htmlOptions' => array('multiple' => false),
                       )
                        
                            )
                    );
                    ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'brand', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' =>$brand,
                            'htmlOptions' => array('multiple' => false),
                        )
                            )
                    );
                    ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'month', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' =>$month,
                            'htmlOptions' => array('multiple' => false),
                        )
                            )
                    );
                    ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'region', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $region,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Region', 'id' => 'region',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('one'),
                                    'update' => '#Attendance_province',
                                    'data' => array('region_id' => 'js:this.value',),
                                )),
                        )
                            )
                    );
                    ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'province', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(                          
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Province'),
                            )
                                )
                    );
                    ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'year', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $year,
                            'htmlOptions' => array('multiple' => false, 'id' => 'att_year')
                                
                        )
                            )
                    );
                    ?>  
                    
     <?php $this->endWidget(); ?>
                </div>



</div>

<script>
  $('#region').change(function() {
        $('#Attendance_province').empty();
        $('#Attendance_province').append('<option value="">Select Province</option>');
        
    });
    
    function redraw(){
         var chart = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'container'
                },
                title: {
                    text: 'Attendance'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Attendance'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Target: ' + this.point.mydata;
                    }
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                            style: {
                                textShadow: '0 0 3px black, 0 0 3px black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Target',
                     data: 
                        attendance_target
                        
                }, {
                    name: 'Reach',
                    data:attendance_reach
            
                }]
    });
    
      var labels = new Array();
      var attendance_target = new Array();
      var attendance_reach = new Array();
      var month;
      var agency =  document.getElementById('Attendance_agency');
      var region =  document.getElementById('region');
      var month =  document.getElementById('Attendance_month');
      var province =  document.getElementById('Attendance_province');
      var brand =  document.getElementById('Attendance_brand');
      var att_year =  document.getElementById('att_year');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/attendance'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency.value+'&region='+region.value+'&month='+month.value+'&province='+province.value+'&brand='+brand.value+'&year='+att_year.value,
             beforeSend: function(){
//               $("#detail_table_loader_attendance").show();  
//               $("#container").hide();  
                 chart.showLoading();
             },
            'success':function(data) {
              
               for(var i = 0; i < data.length; i++){
               
                    labels.push(data[i].name);
                   
                    var target = data[i].target_attendance - data[i].actual_attendance;
                    var targettl = data[i].target_attendance;
                    var percentage = data[i].actual_attendance / data[i].target_attendance * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var coloring = percentage / par *100;
                    if(coloring >= 100)
                    {
                        color = 'green';
                    }else if(coloring >= 90 && coloring <99){
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    
                    attendance_target.push({y: target, color: 'gray',mydata:targettl});
                    attendance_reach.push({y: data[i].actual_attendance, color: color,mydata:targettl});
   
               }
               chart.xAxis[0].setCategories(labels)
               chart.series[0].setData(attendance_target)
               chart.series[1].setData(attendance_reach)
//               $("#detail_table_loader_attendance").hide();  
//               $("#container").show();
               chart.hideLoading();
               
              
               
            },
            error: function(jqXHR, exception) {
//               $("#detail_table_loader_attendance").hide();  
//               $("#container").show();
                chart.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
    }
    
   
$('#Attendance_agency').change(function() {
    
    redraw(); 
    
});
$('#region').change(function() {
    
    redraw(); 
    
});
$('#Attendance_province').change(function() {
    
    redraw(); 
    
});
$('#Attendance_month').change(function() {
    
    redraw(); 
    
});
$('#Attendance_brand').change(function() {
    
    redraw(); 
    
});
$('#att_year').change(function() {
    
    redraw(); 
    
});
//




  
</script>

</script>