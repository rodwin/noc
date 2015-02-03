<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<style>
 #test {display: none; }    
</style>
   
      <div class="panel panel-default">
          <div class="panel-heading">TL Dashboard</div>
          
          <div class="panel-body" id ="tl_dashboard_div">
                <?php

                echo $this->renderPartial('_viewtldashboard', array(
                    'model' => $model,
                    'month' => $month,
                    'teamlead' => $teamlead,
                    'agency' => $agency,
                    'brand' => $brand,
                    'ph' => $ph,
                    'year' => $year,

                ));
                ?>
          </br>
         
                
              <div class="col-md-4">
                <div id="tlreach" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                <div id="detail_table_loader_tl_reach"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
 
              </div>
              <div class="col-md-4">
                 <div id="tlattendance" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                 <div id="detail_table_loader_dtl_tl_attn"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
 
              </div>
              <div class="col-md-4">
                 <div id="tlqa" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                 <div id="detail_table_loader_dtl_tl_attn"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
 
              </div>
           
          
        </div>
      
          
          <div class="panel-body">
                
               

          </div>
      </div>


    

                
<!--<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>-->
<script>
$(function () {
    
            
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
                    title: {
                        text: 'Tl Attendance'
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
                            'Target: ' + this.point.mydatad;
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
                        attendancetl_target
                        
                }, {
                    name: 'Reach',
                    data:attendancetl_reach
            
                }]
    });
    
      var labelstl = new Array();
      var attendancetl_target = new Array();
      var attendancetl_reach = new Array();
      var agency_tl_att =  document.getElementById('tl_agency');
      var month_tl_att =  document.getElementById('tl_month');
      var brand_tl_att =  document.getElementById('tl_brand');
      var team_leader_att =  document.getElementById('tl_leader');
      var tls_year =  document.getElementById('tl_year');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Tl/TlAttendance'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_tl_att.value+'&month='+month_tl_att.value+'&brand='+brand_tl_att.value+'&teamlead='+team_leader_att.value+'&year='+tls_year.value,
             beforeSend: function(){
//                $("#detail_table_loader_dtl_tl_attn").show();  
//                $("#tlattendance").hide();  
                 chartx.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labelstl.push(data[i].code);
                    
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
                    attendancetl_target.push({y: target, color: 'gray',mydatad:targettl});
                    attendancetl_reach.push({y: data[i].actual_attendance, color: color,mydatab:targettl});
   
               }
               chartx.xAxis[0].setCategories(labelstl)
               chartx.series[0].setData(attendancetl_target)
               chartx.series[1].setData(attendancetl_reach)
               
//              $("#detail_table_loader_dtl_tl_attn").hide();  
//              $("#tlattendance").show();
                chartx.hideLoading();
            
               
              
               
            },
            error: function(jqXHR, exception) {
//              $("#detail_table_loader_dtl_tl_attn").hide();  
//              $("#tlattendance").show();
                chartx.hideLoading();
               alert('An error occured: '+ exception);
            }
         });
 
      var chartv = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'tlreach'
                },
                title: {
                    text: 'Reach/Target in Ph1'
                },
                xAxis: {
                    categories: labels_tlreach
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Reach/Target in Ph1'
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
                            'Target: ' + this.point.mydatae;
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
                     data:target_reach_tl
                        
                }, {
                    name: 'Reach',
                    data:target_actualtl
            
                }]
    });
    
      var labels_tlreach = new Array();
      var target_reach_tl = new Array();
      var target_actualtl = new Array();
      var agency_tl_rc =  document.getElementById('tl_agency');
      var month_tl_rc =  document.getElementById('tl_month');
      var brand_tl_rc =  document.getElementById('tl_brand');
      var team_leader_rc =  document.getElementById('tl_leader');
      var tl_ph =  document.getElementById('tl_ph');
      var tls_year =  document.getElementById('tl_year');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Tl/TlReach'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_tl_rc.value+'&month='+month_tl_rc.value+'&brand='+brand_tl_rc.value+'&teamlead='+team_leader_rc.value+'&ph='+tl_ph.value+'&year='+tls_year.value,
                 beforeSend: function(){
//                $("#detail_table_loader_tl_reach").show();  
//                $("#tlreach").hide();
                   chartv.showLoading();
             },
            'success':function(data) {
             
                for(var i = 0; i < data.length; i++){
                    labels_tlreach.push(data[i].code);

                    var target = data[i].target_reach - data[i].actual_reach;
                    var percentage = data[i].actual_reach / data[i].target_reach * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;
                    if(test >= 100)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                   
                    target_reach_tl.push({y: target, color: 'gray',mydatae:data[i].target_reach});
                    target_actualtl.push({y: parseFloat(data[i].actual_reach), color: color,mydatae:data[i].target_reach});
                   
   
               }
//               console.log(target_reach_tl);
//               console.log(target_actualtl);
               chartv.xAxis[0].setCategories(labels_tlreach)
               chartv.series[0].setData(target_reach_tl)
               chartv.series[1].setData(target_actualtl)
//              $("#detail_table_loader_tl_reach").hide();  
//              $("#tlreach").show();  
                chartv.hideLoading();
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_tl_reach").hide();  
//              $("#tlreach").show();
                chartv.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
         
       
         
         
         
        var chartqa= new Highcharts.Chart({
        
             chart: {
                        type: 'column',
                        renderTo: 'tlqa'
                    },
                    title: {
                        text: 'QA Checklist'
                    },
                    xAxis: {
                        categories: labels_code
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'QA Checklist'
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
                            'Actual Score: ' + this.point.mydata;
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
                        name: 'Total Score',
                         data:score_target

                    }, {
                        name: 'Actual Score',
                        data:score_actual

                    }]
      });
    
      var labels_code= new Array();
      var score_actual = new Array();
      var score_target = new Array();
      var team_ph =  document.getElementById('tl_ph');
      var team_leader_qa =  document.getElementById('tl_leader');
      var team_month =  document.getElementById('tl_month');
//      var brand_tl =  document.getElementById('tl_brand');
      var team_year =  document.getElementById('tl_year');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Tl/TlQa'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'teamlead='+team_leader_qa.value+'&ph='+team_ph.value+'&month='+team_month.value+'&year='+team_year.value,
            beforeSend: function(){
//                $("#detail_table_loader_ttl_national").show();  
//                $("#TotalNational").hide(); 
                  chartqa.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_code.push(data[i].bws);

 
                    var test = data[i].total / data[i].score * 100;
                    var remaining = data[i].score - data[i].total;

       
                    if(test >= 100)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
             
                   score_target.push({y: remaining, color: 'gray',mydata:data[i].total});
                   score_actual.push({y: parseFloat(data[i].total), color: color,mydata:data[i].total});
//                    target_actual_total_jfm.push({y: data[i].actual_reach, color: color,mydatac:data[i].target_reach});
                   
   
               }
//             $("#detail_table_loader_ttl_national").hide();  
//             $("#TotalNational").show();  

               chartqa.xAxis[0].setCategories(labels_code)
               chartqa.series[0].setData(score_target)
               chartqa.series[1].setData(score_actual)
               chartqa.hideLoading();
            
               
              
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_ttl_national").hide();  
//                $("#TotalNational").show();
               chartqa.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
         
    
});


</script>