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
                            'htmlOptions' => array('multiple' => false, 'id' => 'tl_agency', 'prompt' => 'Select Agency',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('getTeam'),
                                    'update' => '#tl_team',
                                    'data' => array('id' => 'js:this.value',),
                                )),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'tl_month'),
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
                            'data' => $brand,
                            'htmlOptions' => array('multiple' => false, 'id' => 'tl_brand')
                                
                        )
                            )
                    );
                    ?>  
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'team', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('multiple' => false, 'id' => 'tl_team', 'prompt' => 'Select Team',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('getTlPerTeam'),
                                    'update' => '#tl_leader',
                                    'data' => array('id' => 'js:this.value',),
                                )),
                                
                        )
                            )
                    );
                    ?> 
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'teamlead', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Team Leader', 'id' => 'tl_leader'),
                                
                                
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'tl_year')
                                
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
    
       
    
    function redrawattendancetl(){
         var chartx = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'tlattendance'
                },
                title: {
                    text: 'Tl Attendance'
                },
                xAxis: {
                    categories: labelstl
                },
                yAxis: {
                    min: 0,
                    
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
                    },series: {
                        pointWidth: 30
                    }
                },
                series: [{
                    name: 'Target',
                     data: 
                        attendancetl_target
                        
                }, {
                    name: 'Reach',
                    data:attendancetl_reach
            
                }]
    });
    
     var labelstl = new Array();
     var attendancetl_target = new Array();
     var attendancetl_reach = new Array();
     var month_tl;
     var agency_tl =  document.getElementById('tl_agency');
     var month_tl =  document.getElementById('tl_month');
     var brand_tl =  document.getElementById('tl_brand');
     var team_leader =  document.getElementById('tl_leader');
     var tl_year =  document.getElementById('tl_year');
     var tl_team =  document.getElementById('tl_team');
   
     
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TlAttendance'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_tl.value+'&month='+month_tl.value+'&brand='+brand_tl.value+'&teamlead='+team_leader.value+'&year='+tl_year.value+'&team='+tl_team.value,
             beforeSend: function(){
//                $("#detail_table_loader_dtl_tl_attn").show();  
//                $("#tlattendance").hide(); 
                chartx.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labelstl.push(data[i].salesman);
//                    
//                    var target = data[i].count - data[i].attendance;
//                    var percentage = data[i].attendance / data[i].count * 100;
                    
                    var target = data[i].target_attendance - data[i].actual_attendance;
                    var targettl = data[i].target_attendance;
                    var percentage = data[i].actual_attendance / data[i].target_attendance * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var answer =  percentage / par * 100;
                    if(answer >= 100)
                    {
                        color = 'green';
                    }else if(answer >= 90 && answer <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    attendancetl_target.push({y: target, color: 'gray',mydata:targettl});
                    attendancetl_reach.push({y: parseFloat(data[i].actual_attendance), color: color,mydata:targettl});
   
               }
               chartx.xAxis[0].setCategories(labelstl)
               chartx.series[0].setData(attendancetl_target)
               chartx.series[1].setData(attendancetl_reach)
               chartx.hideLoading();
//               $("#detail_table_loader_dtl_tl_attn").hide();  
//               $("#tlattendance").show();
//            
               
              
               
            },
            error: function(jqXHR, exception) {
//              $("#detail_table_loader_dtl_tl_attn").hide();  
//              $("#tlattendance").show();
                chartx.hideLoading();
               alert('An error occured: '+ exception);
            }
         });
    }
//    
//  

    function redrawtlreach(){
    
          var chartv = new Highcharts.Chart({
             chart: {
                        type: 'column',
                        renderTo: 'tlreach'
                    },
                    title: {
                        text: 'Hit/Target'
                    },
                    xAxis: {
                        categories: labels_tlreach
                    },
                    yAxis: {
                        min: 0,
                        
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
                        },series: {
                            pointWidth: 20
                        }
                    },
                    series: [{
                        name: 'Target',
                         data:target_reach_tl

                    }, {
                        name: 'hit',
                        data:target_actualtl

                    }]
        });

          var labels_tlreach = new Array();
          var target_reach_tl = new Array();
          var target_actualtl = new Array();
          var agency_tl_reach =  document.getElementById('tl_agency');
          var month_tl_reach =  document.getElementById('tl_month');
          var brand_tl_reach =  document.getElementById('tl_brand');
          var team_leader_reach =  document.getElementById('tl_leader');
          var tls_year =  document.getElementById('tl_year');
          var tls_team =  document.getElementById('tl_team');
            $.ajax({
                'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TlReach'); ?>",
                'type':'get',
                'dataType': 'json',
                'data':'agency='+agency_tl_reach.value+'&month='+month_tl_reach.value+'&brand='+brand_tl_reach.value+'&teamlead='+team_leader_reach.value+'&year='+tls_year.value+'&team='+tls_team.value,
                 beforeSend: function(){
//                    $("#detail_table_loader_tl_reach").show();  
//                    $("#tlreach").hide();   
                      chartv.showLoading();
                },
                'success':function(data) {

                    for(var i = 0; i < data.length; i++){
                        labels_tlreach.push(data[i].salesman);

                        var target = data[i].target_hit - data[i].actual_hit;
                        var percentage = data[i].actual_hit / data[i].target_hit * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var test = percentage / par *100;
                        if(percentage >= 100)
                        {
                            color = 'green';
                        }else if(percentage >= 90 && percentage <99)
                        {
                            color = 'yellow';
                        }else{
                            color = 'red';
                        }

                        target_reach_tl.push({y: target, color: 'gray',mydata:data[i].target_hit});
                        target_actualtl.push({y: parseFloat(data[i].actual_hit), color: color,mydata:data[i].target_hit});


                   }
    //               console.log(target_reach_tl);
    //               console.log(target_actualtl);
                   chartv.xAxis[0].setCategories(labels_tlreach)
                   chartv.series[0].setData(target_reach_tl)
                   chartv.series[1].setData(target_actualtl)
                   chartv.hideLoading();
//                   $("#detail_table_loader_tl_reach").hide();  
//                   $("#tlreach").show();

                },
                error: function(jqXHR, exception) {
//                    $("#detail_table_loader_tl_reach").hide();  
//                    $("#tlreach").show();
                      chartv.hideLoading();
                   alert('An error occured: '+ exception);
                }
             }); 
             
    }
    
$('#tl_agency').change(function() {
    
    redrawattendancetl(); 
    redrawtlreach(); 

    
});
$('#tl_month').change(function() {
    
    redrawattendancetl(); 
    redrawtlreach(); 

});
$('#tl_brand').change(function() {
    
    redrawattendancetl();
    redrawtlreach();
 
    
});
$('#tl_leader').change(function() {
    
    redrawattendancetl();
    redrawtlreach();

    
});
$('#tl_ph').change(function() {
    
  
    redrawtlreach();

    
});
$('#tl_year').change(function() {
    
   redrawattendancetl();
    redrawtlreach();

    
});

</script>

</script>