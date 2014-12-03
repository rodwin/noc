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
          <div class="panel-heading">Total National Hit</div>
          
          <div class="panel-body" id ="ttl_national_div">
              <div class="row">
                  <div class="col-md-6">                    
                       <?php

                        echo $this->renderPartial('_viewtotalnational', array(
                            'model' => $model,
                            'brand' => $brand,
                            'agency' => $agency,
                            'year' => $year,

                        ));
                        ?>
                  </div>
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
                                 <h3 id ="productivity"></h3>
                                </p> 
                              </td>
                          </tr>
                    </table>
                  </div>
              </div>
              <div class="col-xs-6 col-sm-3">
                 <div id="TotalNational" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                 <div id="detail_table_loader_ttl_national_qtr"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
               
              </div>
              <div class="col-xs-6 col-sm-3">
                 <div id="TotalNational_ond" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                 <div id="detail_table_loader_ttl_national"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
               
              </div>
              <div class="col-xs-6 col-sm-3">
                 <div id="TotalNational_jfm" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                 <div id="detail_table_loader_ttl_national"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
               
              </div>
              <div class="col-xs-6 col-sm-3">
                 <div id="TotalNational_amj" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                 <div id="detail_table_loader_ttl_national"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
               
              </div>
           
                                       
        </div>
      
            
      </div>

      <div class="panel panel-default">
          <div class="panel-heading">Detailed Hit</div>
          <div class="panel-body" id ="dtl_reach_div">
                <?php

                echo $this->renderPartial('_viewdetailed', array(
                    'model' => $model,
                    'agency' => $agency,
                    'brand' => $brand,
                    'region' => $region,
                    'month' => $month,
                    'year' => $year,

                ));
                ?>
              
                <div id="detailed_reach" style="min-width: auto; height: 400px; margin: 0 auto"></div>

          </div>
<!--          <div id="detail_table_loader_dtl"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
 
      </div> 

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
                    'year' => $year,

                ));
                ?>
                <div id="container" style="min-width: auto; height: 400px; margin: 0 auto"></div>

          </div>
<!--          <div id="detail_table_loader_attendance"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->

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
                    'year' => $year,
              

                ));
                ?>
          </br>
         
                
              <div class="col-md-6">
                <div id="tlreach" style="min-width: auto; height: 400px; margin: 0 auto"></div>
<!--                <div id="detail_table_loader_tl_reach"><img height="50" style="display:block;margin:auto;" alt="activity indicator" src="<?php Yii::app()->baseUrl ;?>protected/modules/pome/image/loader.gif" alt="" /></div>-->
 
              </div>
              <div class="col-md-6">
                 <div id="tlattendance" style="min-width: auto; height: 400px; margin: 0 auto"></div>
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
    
    var covered_global =0;
    var reach_global =0;
    var trials_global = 0;
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
                            'Target: ' + this.point.mydataa;
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
                    name: 'Actual',
                    data:attendance_reach
            
                }]
    });
    
      var labels = new Array();
      var attendance_target = new Array();
      var attendance_reach = new Array();
      var month;
      var agency =  document.getElementById('Dtd_agency');
      var region =  document.getElementById('region');
      var month =  document.getElementById('Dtd_month');
      var province =  document.getElementById('Dtd_province');
      var brand =  document.getElementById('Dtd_brand');
      var attd_year =  document.getElementById('att_year');
      console.log(agency.value);
      console.log(brand.value);
      console.log(month.value);
      console.log(attd_year.value);
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/attendance'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency.value+'&region='+region.value+'&month='+month.value+'&brand='+brand.value+'&year='+attd_year.value,
             beforeSend: function(){
//               $("#detail_table_loader_attendance").show();  
//               $("#container").hide();     
                 chart.showLoading();
             },
            'success':function(data) {
              
               for(var i = 0; i < data.length; i++){
                    labels.push(data[i].name);
                    
                    var target = data[i].target_attendance - data[i].actual_attendance;
                    var targettotal = data[i].target_attendance;
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
                    attendance_target.push({y: target, color: 'gray',mydataa:targettotal});
                    attendance_reach.push({y: data[i].actual_attendance, color: color,mydataa:targettotal});
   
               }
               chart.xAxis[0].setCategories(labels)
               chart.series[0].setData(attendance_target)
               chart.series[1].setData(attendance_reach)
//               $("#detail_table_loader_attendance").hide();  
//               $("#container").show();
                chart.hideLoading();
             
              
               
            },
            error: function(jqXHR, exception) {
                chart.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
 
         
    

    
    
      var charts = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'detailed_reach'
                },
                title: {
                    text: 'Detailed Hit'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Detailed Hit'
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
                            'Target: ' + this.point.mydatab;
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
                    name: 'Hit',
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
      var year_details =  document.getElementById('year_detail');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/DetailHit'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_detail.value+'&region='+region_detail.value+'&month='+month_detail.value+'&brand='+brand_detail.value+'&year='+year_details.value,
             beforeSend: function(){
//               $("#detail_table_loader_dtl").show();  
//               $("#detailed_reach").hide();  
                 charts.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_detail.push(data[i].name);
                    
                    var target = data[i].target_hit - data[i].actual_hit;
                    var percentage = data[i].actual_hit / data[i].target_hit * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;
                    console.log(test);
                    if(test >= 100)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    target_reach.push({y: target, color: 'gray',mydatab:data[i].target_reach});
                    target_actual.push({y: data[i].actual_reach, color: color,mydatab:data[i].target_reach});
   
               }
               charts.xAxis[0].setCategories(labels_detail)
               charts.series[0].setData(target_reach)
               charts.series[1].setData(target_actual)
//               $("#detail_table_loader_dtl").hide();  
//               $("#detailed_reach").show();
                 charts.hideLoading();
               
              
               
            },
            error: function(jqXHR, exception) {
                charts.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
         
         
         var chartz = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'TotalNational'
                },
                title: {
                    text: 'JAS'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total National Hit JAS'
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
                            'Target: ' + this.point.mydatac;
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
                    name: 'Hit',
                    data:target_actual
            
                }]
    });
    
      var labels_total = new Array();
      var target_reach_total = new Array();
      var target_actual_total = new Array();
      var counter_target = 0;
      var counter_actual = 0;
      var total_target=0;
      var total_actual=0;
      var agency_ttl =  document.getElementById('total_agency');
//      var qtr_ttl =  document.getElementById('total_quarter');
      var brand_ttl =  document.getElementById('total_brand');
      var year_ttl =  document.getElementById('total_year');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachJAS'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=JAS'+'&year='+year_ttl.value,
             beforeSend: function(){
//                $("#detail_table_loader_ttl_national").show();  
//                $("#TotalNational").hide();     
                  chartz.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_total.push(data[i].name);

                    var target = data[i].target_hit - data[i].actual_hit;
                    var percentage = data[i].actual_hit / data[i].target_hit * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;
                    counter_target += data[i].target_hit
                    counter_actual += data[i].actual_hit
                    total_target = counter_target ;
                    total_actual = counter_actual ;
                    if(test >= 100)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                   
                    target_reach_total.push({y: target, color: 'gray',mydatac:data[i].target_hit});
                    target_actual_total.push({y: data[i].actual_hit, color: color,mydatac:data[i].target_hit});
                   
   
               }
//             $("#detail_table_loader_ttl_national").hide();  
//             $("#TotalNational").show();  
                covered_global +=total_target;
                reach_global +=total_actual;
                trials_global +=total_actual;
                $("#covered").html('');
                $("#reach").html('');
                $("#trial").html('');
             
                $("#covered").append(covered_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#reach").append(reach_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#trial").append(trials_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
               chartz.xAxis[0].setCategories(labels_total)
               chartz.series[0].setData(target_reach_total)
               chartz.series[1].setData(target_actual_total)
               chartz.hideLoading();
            
               
              
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_ttl_national").hide();  
//                $("#TotalNational").show();
                  chartz.hideLoading();
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
      var tls_team =  document.getElementById('tl_team');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TlAttendance'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_tl_att.value+'&month='+month_tl_att.value+'&brand='+brand_tl_att.value+'&teamlead='+team_leader_att.value+'&year='+tls_year.value+'&team='+tls_team.value,
             beforeSend: function(){
//                $("#detail_table_loader_dtl_tl_attn").show();  
//                $("#tlattendance").hide();  
                 chartx.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labelstl.push(data[i].salesman);
                    
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
                    text: 'Hit/Target'
                },
                xAxis: {
                    categories: labels_tlreach
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Hit/Target'
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
                    name: 'Hit',
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
      var tls_year =  document.getElementById('tl_year');
      var tls_team =  document.getElementById('tl_team');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TlReach'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_tl_rc.value+'&month='+month_tl_rc.value+'&brand='+brand_tl_rc.value+'&teamlead='+team_leader_rc.value+'&year='+tls_year.value+'&team='+tls_team.value,
                 beforeSend: function(){
//                $("#detail_table_loader_tl_reach").show();  
//                $("#tlreach").hide();
                   chartv.showLoading();
             },
            'success':function(data) {
             
                for(var i = 0; i < data.length; i++){
                    labels_tlreach.push(data[i].salesman);

                    var target = data[i].target_hit - data[i].actual_hit;
                    var percentage = data[i].actual_hit / data[i].target_hit * 100;
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
                   
                    target_reach_tl.push({y: target, color: 'gray',mydatae:data[i].target_hit});
                    target_actualtl.push({y: parseFloat(data[i].actual_hit), color: color,mydatae:data[i].target_hit});
                   
   
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
         
         var chartond = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'TotalNational_ond'
                },
                title: {
                    text: 'OND'
                },
                xAxis: {
                    categories: labels_total_ond
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total National Hit OND'
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
                            'Target: ' + this.point.mydatac;
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
                        total_target_ond
                        
                }, {
                    name: 'Hit',
                    data:total_actual_ond
            
                }]
    });
    
      var labels_total_ond = new Array();
      var target_reach_total_ond = new Array();
      var target_actual_total_ond = new Array();
      var counter_target_ond = 0;
      var counter_actual_ond = 0;
      var total_target_ond =0;
      var total_actual_ond=0;
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachOND'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=OND'+'&year='+year_ttl.value,
             beforeSend: function(){
//                $("#detail_table_loader_ttl_national").show();  
//                $("#TotalNational").hide(); 
                  chartond.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_total_ond.push(data[i].name);

                    var target = data[i].target_hit - data[i].actual_hit;
                    var percentage = data[i].actual_hit / data[i].target_hit * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;
                    counter_target_ond += data[i].target_hit
                    counter_actual_ond += data[i].actual_hit
                    total_target_ond = counter_target_ond ;
                    total_actual_ond = counter_actual_ond ;
                    if(test >= 100)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                   
                    target_reach_total_ond.push({y: target, color: 'gray',mydatac:data[i].target_hit});
                    target_actual_total_ond.push({y: data[i].actual_hit, color: color,mydatac:data[i].target_hit});
                   
   
               }
//             $("#detail_table_loader_ttl_national").hide();  
//             $("#TotalNational").show();  
                covered_global +=total_target_ond;
                reach_global +=total_actual_ond;
                trials_global +=total_actual_ond;
                $("#covered").html('');
                $("#reach").html('');
                $("#trial").html('');
                $("#covered").append(covered_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#reach").append(reach_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#trial").append(trials_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
               chartond.xAxis[0].setCategories(labels_total_ond)
               chartond.series[0].setData(target_reach_total_ond)
               chartond.series[1].setData(target_actual_total_ond)
               chartond.hideLoading();
            
               
              
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_ttl_national").hide();  
//                $("#TotalNational").show();
                  chartond.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 

          var chartamj= new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'TotalNational_amj'
                },
                title: {
                    text: 'AMJ'
                },
                xAxis: {
                    categories: labels_total_amj
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total National Hit AMJ'
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
                            'Target: ' + this.point.mydatac;
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
                        total_target_amj
                        
                }, {
                    name: 'Hit',
                    data:total_actual_amj
            
                }]
    });
    
      var labels_total_amj= new Array();
      var target_reach_total_amj = new Array();
      var target_actual_total_amj = new Array();
      var counter_target_amj = 0;
      var counter_actual_amj = 0;
      var total_target_amj=0;
      var total_actual_amj=0;
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachAMJ'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=AMJ'+'&year='+year_ttl.value,
             beforeSend: function(){
//                $("#detail_table_loader_ttl_national").show();  
//                $("#TotalNational").hide();  
                  chartamj.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_total_amj.push(data[i].name);

                    var target = data[i].target_hit - data[i].actual_hit;
                    var percentage = data[i].actual_hit / data[i].target_hit * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;
                    counter_target_amj += data[i].target_hit
                    counter_actual_amj += data[i].actual_hit
                    total_target_amj = counter_target_amj ;
                    total_actual_amj = counter_actual_amj ;
                    if(test >= 100)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                   
                    target_reach_total_amj.push({y: target, color: 'gray',mydatac:data[i].target_hit});
                    target_actual_total_amj.push({y: data[i].actual_hit, color: color,mydatac:data[i].target_hit});
                   
   
               }
//             $("#detail_table_loader_ttl_national").hide();  
//             $("#TotalNational").show();
                covered_global +=total_target_amj;
                reach_global +=total_actual_amj;
                trials_global +=total_actual_amj;  
                $("#covered").html('');
                $("#reach").html('');
                $("#trial").html('');
                $("#covered").append(covered_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#reach").append(reach_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#trial").append(trials_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
               chartamj.xAxis[0].setCategories(labels_total_amj)
               chartamj.series[0].setData(target_reach_total_amj)
               chartamj.series[1].setData(target_actual_total_amj)
               chartamj.hideLoading();
            
               
              
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_ttl_national").hide();  
//                $("#TotalNational").show();
                  chartamj.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
         
         var chartjfm= new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'TotalNational_jfm'
                },
                title: {
                    text: 'JFM'
                },
                xAxis: {
                    categories: labels_total_jfm
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total National Hit JFM'
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
                            'Target: ' + this.point.mydatac;
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
                        total_target_jfm
                        
                }, {
                    name: 'Hit',
                    data:total_actual_jfm
            
                }]
    });
    
      var labels_total_jfm= new Array();
      var target_reach_total_jfm = new Array();
      var target_actual_total_jfm = new Array();
      var counter_target_jfm = 0;
      var counter_actual_jfm = 0;
      var total_target_jfm=0;
      var total_actual_jfm=0;
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachJFM'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=JFM'+'&year='+year_ttl.value,
             beforeSend: function(){
//                $("#detail_table_loader_ttl_national").show();  
//                $("#TotalNational").hide(); 
                  chartjfm.showLoading();
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_total_amj.push(data[i].name);

                    var target = data[i].target_hit - data[i].actual_hit;
                    var percentage = data[i].actual_hit / data[i].target_hit * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;
                    counter_target_jfm += data[i].target_hit
                    counter_actual_jfm += data[i].actual_hit
                    total_target_jfm = counter_target_jfm ;
                    total_actual_jfm = counter_actual_jfm ;
                    if(test >= 100)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <99)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                   
                    target_reach_total_jfm.push({y: target, color: 'gray',mydatac:data[i].target_hit});
                    target_actual_total_jfm.push({y: data[i].actual_hit, color: color,mydatac:data[i].target_hit});
                   
   
               }
//             $("#detail_table_loader_ttl_national").hide();  
//             $("#TotalNational").show();  
             covered_global +=total_target_jfm;
                reach_global +=total_actual_jfm;
                trials_global +=total_actual_jfm;
                $("#covered").html('');
                $("#reach").html('');
                $("#trial").html('');
                $("#covered").append(covered_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#reach").append(reach_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#trial").append(trials_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
               chartjfm.xAxis[0].setCategories(labels_total_jfm)
               chartjfm.series[0].setData(target_reach_total_jfm)
               chartjfm.series[1].setData(target_actual_total_jfm)
               chartjfm.hideLoading();
            
               
              
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_ttl_national").hide();  
//                $("#TotalNational").show();
               chartjfm.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
         
    
});


</script>