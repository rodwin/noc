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
        
      <div class="panel-heading">Attendance</div>
      <div class="panel-body" id ="attendance_div">
            <?php

            echo $this->renderPartial('_view', array(
                'model' => $model,
                'agency' => $agency,
                'region' => $region,
                'brand' => $brand,
                'month' => $month,

            ));
            ?>
            <div id="container" style="min-width: auto; height: 400px; margin: 0 auto"></div>

      </div>
      <div id="detail_table_loader_attendance"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>
 
      </div>

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

                ));
                ?>
          </br>
         
                
              <div class="col-md-6">
                <div id="tlreach" style="min-width: auto; height: 400px; margin: 0 auto"></div>
                <div id="detail_table_loader_tl_reach"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>
 
              </div>
              <div class="col-md-6">
                 <div id="tlattendance" style="min-width: auto; height: 400px; margin: 0 auto"></div>
                 <div id="detail_table_loader_dtl_tl_attn"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>
 
              </div>
           
          
        </div>
      
          
          <div class="panel-body">
                
               

          </div>
      </div>

      <div class="panel panel-default">
          <div class="panel-heading">Detailed Reach</div>
          <div class="panel-body" id ="dtl_reach_div">
                <?php

                echo $this->renderPartial('_viewdetailed', array(
                    'model' => $model,
                    'agency' => $agency,
                    'ph' => $ph,
                    'brand' => $brand,
                    'region' => $region,
                    'month' => $month,

                ));
                ?>
              
                <div id="detailed_reach" style="min-width: auto; height: 400px; margin: 0 auto"></div>

          </div>
          <div id="detail_table_loader_dtl"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>
 
      </div>

      <div class="panel panel-default">
          <div class="panel-heading">Total National Reach</div>
          
          <div class="panel-body" id ="ttl_national_div">
        <?php

                echo $this->renderPartial('_viewtotalnational', array(
                    'model' => $model,
                    'qtr' => $qtr,
                    'brand' => $brand,
                    'agency' => $agency,

                ));
                ?>
          </br>
         
                
              <div class="col-md-6">
                  <table>
                      <tr>
                          <td>
                             <p>
                              <button type="button" class="btn btn-primary btn-lg">Covered</button>
                            </p> 
                          </td>
                          <td>
                             <p style="margin-top: -20px; ">
                                 <h3  id ="covered"></h3>
                            </p> 
                          </td>
                      </tr>
                      <tr>
                          <td>
                             <p>
                              <button type="button" class="btn btn-primary btn-lg"># of Reach</button>
                            </p> 
                          </td>
                          <td>
                             <p style="margin-top: -20px;">
                             <h3 id ="reach"></h3>
                            </p> 
                          </td>
                      </tr>
                      <tr>
                          <td>
                             <p>
                              <button type="button" class="btn btn-primary btn-lg"># of Trials</button>
                            </p> 
                          </td>
                          <td>
                             <p style="margin-top: -20px;">
                             <h3 id ="trial"></h3>
                            </p>  
                          </td>
                      </tr>
                      <tr>
                          <td>
                             <p>
                              <button type="button" class="btn btn-primary btn-lg">Productivity</button>
                            </p> 
                          </td>
                          <td>
                             <p style="margin-top: -20px;">
                             <h3 id ="productivity">0</h3>
                            </p> 
                          </td>
                      </tr>
                     
                          
                     
                
                 
                </table>
              </div>
              <div class="col-md-6">
                 <div id="TotalNational" style="min-width: auto; height: 400px; margin: 0 auto"></div>
                 <div id="detail_table_loader_ttl_national"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>
               
              </div>
           
                                       
        </div>
      
            
      </div>
      
    

                
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script>
$(function () {
    
    
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
                            'Total: ' + this.point.stackTotal;
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
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/attendance'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency.value+'&region='+region.value+'&month='+month.value+'&province='+province.value+'&brand='+brand.value,
             beforeSend: function(){
               $("#detail_table_loader_attendance").show();  
               $("#container").hide();             
             },
            'success':function(data) {
              
               for(var i = 0; i < data.length; i++){
                    labels.push(data[i].name);
                    
                    var target = data[i].count *data[i].ac_count - data[i].attendance;
                    var percentage = data[i].attendance / (data[i].count *data[i].ac_count) * 100;
                    if(percentage >= 95)
                    {
                        color = 'green';
                    }else if(percentage >= 90 && percentage <=94)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    attendance_target.push({y: target, color: 'gray'});
                    attendance_reach.push({y: data[i].attendance, color: color});
   
               }
               chart.xAxis[0].setCategories(labels)
               chart.series[0].setData(attendance_target)
               chart.series[1].setData(attendance_reach)
               $("#detail_table_loader_attendance").hide();  
               $("#container").show();
             
              
               
            },
            error: function(jqXHR, exception) {
               alert('An error occured: '+ exception);
            }
         }); 
 
         
    

    
    
      var charts = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'detailed_reach'
                },
                title: {
                    text: 'Detailed Reach'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Detailed Reach'
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
                            'Total: ' + this.point.stackTotal;
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
                        target_reach
                        
                }, {
                    name: 'Reach',
                    data:target_actual
            
                }]
    });
    
      var labels_detail = new Array();
      var target_reach = new Array();
      var target_actual = new Array();
      var agency_detail =  document.getElementById('agency_detail');
      var region_detail =  document.getElementById('region_detail');
      var month_detail =  document.getElementById('month_detail');
      var province_detail =  document.getElementById('province_detail');
      var ph_detail =  document.getElementById('ph_detail');
      var brand_detail =  document.getElementById('brand_detail');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/DetailedReach'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_detail.value+'&region='+region_detail.value+'&month='+month_detail.value+'&province='+province_detail.value+'&ph='+ph_detail.value+'&brand='+brand_detail.value,           
             beforeSend: function(){
               $("#detail_table_loader_dtl").show();  
               $("#detailed_reach").hide();           
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_detail.push(data[i].name);
                    
                    var target = data[i].target_reach - data[i].actual_reach;
                    var percentage = data[i].actual_reach / data[i].target_reach * 100;
                    if(percentage >= 95)
                    {
                        color = 'green';
                    }else if(percentage >= 90 && percentage <=94)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    target_reach.push({y: target, color: 'gray'});
                    target_actual.push({y: data[i].actual_reach, color: color});
   
               }
               charts.xAxis[0].setCategories(labels_detail)
               charts.series[0].setData(target_reach)
               charts.series[1].setData(target_actual)
               $("#detail_table_loader_dtl").hide();  
               $("#detailed_reach").show();
               
              
               
            },
            error: function(jqXHR, exception) {
               alert('An error occured: '+ exception);
            }
         }); 
         
         
         var chartz = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'TotalNational'
                },
                title: {
                    text: 'Total National Reach'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total National Reach'
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
                            'Total: ' + this.point.stackTotal;
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
                        target_reach
                        
                }, {
                    name: 'Reach',
                    data:target_actual
            
                }]
    });
    
      var labels_total = new Array();
      var target_reach_total = new Array();
      var target_actual_total = new Array();
      var counter_target = 0;
      var counter_actual = 0;
      var total_target;
      var total_actual;
      var agency_ttl =  document.getElementById('total_agency');
      var qtr_ttl =  document.getElementById('total_quarter');
      var brand_ttl =  document.getElementById('total_brand');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReach'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr='+qtr_ttl.value,
             beforeSend: function(){
                $("#detail_table_loader_ttl_national").show();  
                $("#TotalNational").hide();          
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_total.push(data[i].name);

                    var target = data[i].target_reach - data[i].actual_reach;
                    var percentage = data[i].actual_reach / data[i].target_reach * 100;
                    counter_target += data[i].target_reach
                    counter_actual += data[i].actual_reach
                    total_target = counter_target ;
                    total_actual = counter_actual ;
                    if(percentage >= 95)
                    {
                        color = 'green';
                    }else if(percentage >= 90 && percentage <=94)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                   
                    target_reach_total.push({y: target, color: 'gray'});
                    target_actual_total.push({y: data[i].actual_reach, color: color});
                   
   
               }
             $("#detail_table_loader_ttl_national").hide();  
             $("#TotalNational").show();  
                $("#covered").append(total_target);
                $("#reach").append(total_actual);
                $("#trial").append(total_actual);
               chartz.xAxis[0].setCategories(labels_total)
               chartz.series[0].setData(target_reach_total)
               chartz.series[1].setData(target_actual_total)
            
               
              
               
            },
            error: function(jqXHR, exception) {
                $("#detail_table_loader_ttl_national").hide();  
                $("#TotalNational").show();
               alert('An error occured: '+ exception);
            }
         }); 
         
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
                            'Total: ' + this.point.stackTotal;
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
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TlAttendance'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_tl_att.value+'&month='+month_tl_att.value+'&brand='+brand_tl_att.value+'&teamlead='+team_leader_att.value,
             beforeSend: function(){
                $("#detail_table_loader_dtl_tl_attn").show();  
                $("#tlattendance").hide();         
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labelstl.push(data[i].code);
                    
                    var target = data[i].count - data[i].attendance;
                    var percentage = data[i].attendance / data[i].count * 100;
                    if(percentage >= 95)
                    {
                        color = 'green';
                    }else if(percentage >= 90 && percentage <=94)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    attendancetl_target.push({y: target, color: 'gray'});
                    attendancetl_reach.push({y: data[i].attendance, color: color});
   
               }
               chartx.xAxis[0].setCategories(labelstl)
               chartx.series[0].setData(attendancetl_target)
               chartx.series[1].setData(attendancetl_reach)
               
              $("#detail_table_loader_dtl_tl_attn").hide();  
              $("#tlattendance").show();
            
               
              
               
            },
            error: function(jqXHR, exception) {
              $("#detail_table_loader_dtl_tl_attn").hide();  
              $("#tlattendance").show();
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
                            'Total: ' + this.point.stackTotal;
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
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TlReach'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_tl_rc.value+'&month='+month_tl_rc.value+'&brand='+brand_tl_rc.value+'&teamlead='+team_leader_rc.value,
             beforeSend: function(){
                $("#detail_table_loader_tl_reach").show();  
                $("#tlreach").hide();         
             },
            'success':function(data) {
             
                for(var i = 0; i < data.length; i++){
                    labels_tlreach.push(data[i].code);

                    var target = data[i].target_reach - data[i].actual_reach;
                    var percentage = data[i].actual_reach / data[i].target_reach * 100;
                    if(percentage >= 95)
                    {
                        color = 'green';
                    }else if(percentage >= 90 && percentage <=94)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                   
                    target_reach_tl.push({y: target, color: 'gray'});
                    target_actualtl.push({y: parseFloat(data[i].actual_reach), color: color});
                   
   
               }
//               console.log(target_reach_tl);
//               console.log(target_actualtl);
               chartv.xAxis[0].setCategories(labels_tlreach)
               chartv.series[0].setData(target_reach_tl)
               chartv.series[1].setData(target_actualtl)
              $("#detail_table_loader_tl_reach").hide();  
              $("#tlreach").show();  
               
            },
            error: function(jqXHR, exception) {
                $("#detail_table_loader_tl_reach").hide();  
              $("#tlreach").show();
               alert('An error occured: '+ exception);
            }
         }); 
         
    
});


</script>