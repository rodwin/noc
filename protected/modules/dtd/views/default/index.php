<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<style>
 #test {display: none; }  
 #tldashboard {display: none; }  
 #productivity{
     
 }
 #reach{
     
 }
 #trial{
     
 }
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
                                 <p style="margin-top: -20px; ">
                                     <h3  id ="reach"></h3>
                                </p> 
                              </td>
                          </tr>
                          <tr>
                              <td>
                                 <p>
                                  <button type="button" class="btn btn-primary btn-lg"># of Trials</button>
                                </p> 
                              </td>
                              <td >
                                  <p style="margin-top: -20px; ">
                                     <h3  id ="trial"></h3>
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
                               <p style="margin-top: -20px; ">
                                     <h3  id ="productivity"></h3>
                                </p> 
                              </td>
                          </tr>
                    </table>
                  </div>
                   
              </div>
               <div class="nav-tabs-custom" id ="custTabs">
                        <ul class="nav nav-tabs">
                            <li class="active" ><a href="#TotalNational" data-toggle="tab">JAS</a></li>
                            <li><a href="#TotalNational_ond" data-toggle="tab">OND</a></li>
                            <li><a href="#TotalNational_jfm" data-toggle="tab">JFM</a></li>
                            <li><a href="#TotalNational_amj" data-toggle="tab">AMJ</a></li>
                        </ul>
                        <div class="tab-content" id ="info">
                           
                            <div class="tab-pane active" id="TotalNational" ></div>
                            <div class="tab-pane" id="TotalNational_ond"></div>
                            <div class="tab-pane" id="TotalNational_jfm"></div>
                            <div class="tab-pane" id="TotalNational_amj"></div>
                            
                        </div>
                    </div>
             
        </div>
      
            
      </div>

      <div class="panel panel-default">
          <div class="panel-heading">Detailed</div>
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
              <div class="row" id ="tesz">
                <div id="detailed_reach" style="min-width: auto; height: 400px; margin: 0 auto"></div>
              </div>
 

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

      <div class="panel panel-default" id="tldashboard">
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
      </div>
      <div class="panel panel-default" id="average_detail_dashboard">
          <div class="panel-heading">Average Detail</div>
          
          <div class="panel-body" id ="average_detail">
               <?php

                echo $this->renderPartial('_view_detailed_ave', array(
                    'model' => $model,
                    'agency' => $agency,
                    'brand' => $brand,
                    'region' => $region,
                    'month' => $month,
                    'year' => $year,

                ));
                ?>
              
                <div id="Detailed_Average" style="min-width: auto; height: 400px; margin: 0 auto"></div>
          </div>
      </div>



    

                
<!--<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>-->
<script>

    

$(function () {
//    $('#custTabs').click(function (e) {
////    $('#custTabs').tabs({
//        select: function(event, ui) {
//            var theSelectedTab = ui.index;
//            if (theSelectedTab == 0) {
//                alert("0");
//            }
//            else if (theSelectedTab == 1) {
//                alert("1");
//            }
//        }
//    });
//      $('#tesz').css('overflow','scroll');
    $('#custTabs').on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) { // on tab selection event
		    $( ".tab-pane" ).each(function() { // target each element with the .contains-chart class
		        var chart = $(this).highcharts(); // target the chart itself
		        chart.reflow() // reflow that chart
		    });
		    });
    
     
    
    
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
                        stacking: 'percent',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                            style: {
                                textShadow: '0 0 3px black, 0 0 3px black'
                            }
                        },series: {
                                pointWidth: 15
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
                    text: 'Detailed'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Detailed'
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
                        stacking: 'percent',
                        size:'100%',
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
                            name: 'Target Hit',
                            data:target_hit,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_hit,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_reach,
                            stack:'reach'

                        },{
                            name: 'Productivity',
                            data:prod_bar_detail_reach_ind,
                            stack:'prod'

                        }]
    });
    
      var labels_detail = new Array();
      var target_reach = new Array();
      var target_hit = new Array();
      var actual_reach = new Array();
      var actual_hit = new Array();
      var prod_bar_detail_reach_ind = new Array();
      var agency_detail =  document.getElementById('agency_detail');
      var region_detail =  document.getElementById('region_detail');
      var month_detail =  document.getElementById('month_detail');
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
                    
                    var target_reach = data[i].target_reach - data[i].actual_reach;
                    var target_hit = data[i].target_hit - data[i].actual_hit;
                    var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                    var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var prod = data[i].actual_hit / data[i].actual_reach * 100;
                    var test_hit = percentage_hit / par *100;
                    var test_reach = percentage_reach / par *100;
                    if(test_hit >= 100)
                    {
                        color_hit = 'green';
                    }else if(test_hit >= 90 && test_hit <99)
                    {
                        color_hit = 'yellow';
                    }else{
                        color_hit = 'red';
                    }
                    if(test_reach >= 100)
                    {
                        color_reach = 'green';
                    }else if(test_reach >= 90 && test_reach <99)
                    {
                        color_reach = 'yellow';
                    }else{
                        color_reach = 'red';
                    }
                     var a_p = parseFloat(Math.round(prod)).toFixed(2)
//                    target_reach.push({y: target, color: 'gray',mydatab:data[i].target_reach});
//                    target_actual.push({y: data[i].actual_reach, color: color,mydatab:data[i].target_reach});
                      target_reach.push({y: target_reach, color: 'gray',mydatac:data[i].target_reach});
                      actual_reach.push({y: data[i].actual_reach, color: color_reach,mydatac:data[i].target_reach});
                      target_hit.push({y: target_hit, color: 'gray',mydatac:data[i].target_hit});
                      actual_hit.push({y: data[i].actual_hit, color: color_hit,mydatac:data[i].target_hit})
                      prod_bar_detail_reach_ind.push({y: parseFloat(a_p) , color: color_prod,mydatac:100});
   
               }
               charts.xAxis[0].setCategories(labels_detail)
               charts.series[0].setData(target_reach)
               charts.series[1].setData(actual_reach)
               charts.series[2].setData(target_hit)
               charts.series[3].setData(actual_hit)
               charts.series[4].setData(prod_bar_detail_reach_ind)
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
                    categories: labels_total_jas_ind
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
                        stacking: 'percent',
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
                            name: 'Target Hit',
                            data:target_hit_total_jas_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_jas_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach_total_jas_ind,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_jas_ind,
                            stack:'reach'

                        },{
                            name: 'Productivity Reach',
                            data:prod_bar_jas_reach_ind,
                            stack:'prod'

                        }
                        ]
    });
    
      var labels_total_jas_ind = new Array();
      var target_reach_total_jas_ind = new Array();
      var target_hit_total_jas_ind = new Array();
      var actual_total_reach_jas_ind = new Array();
      var actual_total_hit_jas_ind = new Array();
      var counter_target_reach_jas_ind = 0;
      var counter_target_hit_jas_ind = 0;
      var counter_actual_hit_jas_ind = 0;
      var counter_actual_reach_jas_ind = 0;
      var total_target_jas_ind =0;
      var total_actual_jas_ind=0;
      var total_actual_reach_jas_ind=0;
      var prod_bar_jas_reach_ind = new Array();

      var agency_ttl =  document.getElementById('total_agency');
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
                        labels_total_jas_ind.push(data[i].name);

                        var target_hit = data[i].target_hit - data[i].actual_hit;
                        var target_reach = data[i].target_reach - data[i].actual_reach;
                        var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                        var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var prod = data[i].actual_hit / data[i].actual_reach * 100;
                        var test_hit = percentage_hit / par *100;
                        var test_reach = percentage_reach / par *100;
                          counter_target_reach_jas_ind += data[i].target_reach
                          counter_target_hit_jas_ind += data[i].target_hit
                          counter_actual_reach_jas_ind += data[i].actual_reach
                          counter_actual_hit_jas_ind += data[i].actual_hit
//                        counter_target_ond += data[i].target_hit
//                        counter_actual_ond += data[i].actual_hit
//                        counter_actual_reach_ond += data[i].actual_reach +data[i].actual_hit
                        total_target_jas_ind = counter_target_reach_jas_ind ;
                        total_actual_jas_ind = counter_actual_hit_jas_ind ;
                        total_actual_reach_jas_ind = counter_actual_reach_jas_ind ;
//                        console.log(prod);
                        if(test_hit >= 100)
                        {
                            color_hit = 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_hit = 'yellow';
                        }else{
                            color_hit = 'red';
                        }
                        
                        if(test_reach >= 100)
                        {
                            color_reach= 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_reach = 'yellow';
                        }else{
                            color_reach = 'red';
                        }
                        if(prod >= 59.50)
                        {
                            color_prod= 'green';
                        }else if(prod >= 54.50 && prod <59.49)
                        {
                            color_prod = 'yellow';
                        }else{
                            color_prod = 'red';
                        }
                        var a_p = parseFloat(Math.round(prod)).toFixed(2)
                        target_hit_total_jas_ind.push({y: target_hit, color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_jas_ind.push({y: data[i].actual_hit, color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_jas_ind.push({y: target_reach, color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_jas_ind.push({y: data[i].actual_reach, color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_jas_reach_ind.push({y: a_p , color: color_prod,mydatac:100});
             
                   
   
               }
               chartz.xAxis[0].setCategories(labels_total_jas_ind)
               chartz.series[0].setData(target_hit_total_jas_ind)
               chartz.series[1].setData(actual_total_hit_jas_ind)
               chartz.series[2].setData(target_reach_total_jas_ind)
               chartz.series[3].setData(actual_total_reach_jas_ind)
               chartz.series[4].setData(prod_bar_jas_reach_ind)
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
                        stacking: 'percent',
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
                        stacking: 'percent',
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
                    categories: labels_total_ond_ind
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
                        stacking: 'percent',
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
                            name: 'Target Hit',
                            data:target_hit_total_ond_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_ond_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach_total_ond_ind,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_ond_ind,
                            stack:'reach'

                        },{
                            name: 'Productivity',
                            data:prod_bar_ond_reach_ind,
                            stack:'prod'

                        }
                        ]
    });
    
      var labels_total_ond_ind = new Array();
      var target_reach_total_ond_ind = new Array();
      var target_hit_total_ond_ind = new Array();
      var actual_total_reach_ond_ind = new Array();
      var actual_total_hit_ond_ind = new Array();
      var prod_bar_ond_reach_ind = new Array();
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
                        labels_total_ond_ind.push(data[i].name);

                        var target_hit = data[i].target_hit - data[i].actual_hit;
                        var target_reach = data[i].target_reach - data[i].actual_reach;
                        var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                        var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var prod = data[i].actual_hit / data[i].actual_reach * 100;
                        var test_hit = percentage_hit / par *100;
                        var test_reach = percentage_reach / par *100;
                        if(test_hit >= 100)
                        {
                            color_hit = 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_hit = 'yellow';
                        }else{
                            color_hit = 'red';
                        }
                        
                        if(test_reach >= 100)
                        {
                            color_reach= 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_reach = 'yellow';
                        }else{
                            color_reach = 'red';
                        }
                        if(prod >= 59.50)
                        {
                            color_prod= 'green';
                        }else if(prod >= 54.50 && prod <59.49)
                        {
                            color_prod = 'yellow';
                        }else{
                            color_prod = 'red';
                        }
                        var a_p = parseFloat(Math.round(prod)).toFixed(2)
                        target_hit_total_ond_ind.push({y: target_hit, color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_ond_ind.push({y: data[i].actual_hit, color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_ond_ind.push({y: target_reach, color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_ond_ind.push({y: data[i].actual_reach, color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_ond_reach_ind.push({y: a_p , color: color_prod,mydatac:100});
                   
   
               }

               chartond.xAxis[0].setCategories(labels_total_ond_ind)
               chartond.series[0].setData(target_hit_total_ond_ind)
               chartond.series[1].setData(actual_total_hit_ond_ind)
               chartond.series[2].setData(target_reach_total_ond_ind)
               chartond.series[3].setData(actual_total_reach_ond_ind)
               chartond.series[4].setData(prod_bar_ond_reach_ind)
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
                    categories: labels_total_amj_ind
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
                        stacking: 'percentt',
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
                            name: 'Target Hit',
                            data:target_hit_total_amj_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_amj_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach_total_amj_ind,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_amj_ind,
                            stack:'reach'

                        },{
                            name: 'Productivity',
                            data:prod_bar_amj_reach_ind,
                            stack:'prod'

                        }
                        ]
    });
    
      var labels_total_amj_ind = new Array();
      var target_reach_total_amj_ind = new Array();
      var target_hit_total_amj_ind = new Array();
      var actual_total_reach_amj_ind = new Array();
      var actual_total_hit_amj_ind = new Array();
      var prod_bar_amj_reach_ind = new Array();
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachAMJ'); ?>",
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
                        labels_total_amj_ind.push(data[i].name);

                        var target_hit = data[i].target_hit - data[i].actual_hit;
                        var target_reach = data[i].target_reach - data[i].actual_reach;
                        var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                        var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var prod = data[i].actual_hit / data[i].actual_reach * 100;
                        var test_hit = percentage_hit / par *100;
                        var test_reach = percentage_reach / par *100;
//                        console.log(prod);
                        if(test_hit >= 100)
                        {
                            color_hit = 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_hit = 'yellow';
                        }else{
                            color_hit = 'red';
                        }
                        
                        if(test_reach >= 100)
                        {
                            color_reach= 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_reach = 'yellow';
                        }else{
                            color_reach = 'red';
                        }
                        if(prod >= 59.50)
                        {
                            color_prod= 'green';
                        }else if(prod >= 54.50 && prod <59.49)
                        {
                            color_prod = 'yellow';
                        }else{
                            color_prod = 'red';
                        }
                        var a_p = parseFloat(Math.round(prod)).toFixed(2)
                        target_hit_total_amj_ind.push({y: target_hit, color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_amj_ind.push({y: data[i].actual_hit, color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_amj_ind.push({y: target_reach, color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_amj_ind.push({y: data[i].actual_reach, color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_amj_reach_ind.push({y: a_p, color: color_prod,mydatac:100});
                   
   
               }

               chartamj.xAxis[0].setCategories(labels_total_amj_ind)
               chartamj.series[0].setData(target_hit_total_amj_ind)
               chartamj.series[1].setData(actual_total_hit_amj_ind)
               chartamj.series[2].setData(target_reach_total_amj_ind)
               chartamj.series[3].setData(actual_total_reach_amj_ind)
               chartamj.series[4].setData(prod_bar_amj_reach_ind)
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
                    categories: labels_total_jfm_ind
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
                        stacking: 'percent',
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
                            name: 'Target Hit',
                            data:target_hit_total_jfm_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_jfm_ind,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach_total_jfm_ind,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_jfm_ind,
                            stack:'reach'

                        },{
                            name: 'Productivity',
                            data:prod_bar_jfm_reach_ind,
                            stack:'prod'

                        }
                        ]
    });
    
      var labels_total_jfm_ind = new Array();
      var target_reach_total_jfm_ind = new Array();
      var target_hit_total_jfm_ind = new Array();
      var actual_total_reach_jfm_ind = new Array();
      var actual_total_hit_jfm_ind = new Array();
      var prod_bar_jfm_reach_ind = new Array();

        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachJFM'); ?>",
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
                        labels_total_jfm_ind.push(data[i].name);

                        var target_hit = data[i].target_hit - data[i].actual_hit;
                        var target_reach = data[i].target_reach - data[i].actual_reach;
                        var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                        var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var prod = data[i].actual_hit / data[i].actual_reach * 100;
                        var test_hit = percentage_hit / par *100;
                        var test_reach = percentage_reach / par *100;
  
                        if(test_hit >= 100)
                        {
                            color_hit = 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_hit = 'yellow';
                        }else{
                            color_hit = 'red';
                        }
                        
                        if(test_reach >= 100)
                        {
                            color_reach= 'green';
                        }else if(test_hit >= 89.50 && test_hit <99.49)
                        {
                            color_reach = 'yellow';
                        }else{
                            color_reach = 'red';
                        }
                        if(prod >= 59.50)
                        {
                            color_prod= 'green';
                        }else if(prod >= 54.50 && prod <59.49)
                        {
                            color_prod = 'yellow';
                        }else{
                            color_prod = 'red';
                        }
                        var a_p = parseFloat(Math.round(prod)).toFixed(2)
                        target_hit_total_jfm_ind.push({y: target_hit, color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_jfm_ind.push({y: data[i].actual_hit, color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_jfm_ind.push({y: target_reach, color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_jfm_ind.push({y: data[i].actual_reach, color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_jfm_reach_ind.push({y: a_p , color: color_prod,mydatac:100});
                   
   
               }

               chartjfm.xAxis[0].setCategories(labels_total_jfm_ind)
               chartjfm.series[0].setData(target_hit_total_jfm_ind)
               chartjfm.series[1].setData(actual_total_hit_jfm_ind)
               chartjfm.series[2].setData(target_reach_total_jfm_ind)
               chartjfm.series[3].setData(actual_total_reach_jfm_ind)
               chartjfm.series[4].setData(prod_bar_jfm_reach_ind)
               chartjfm.hideLoading();
            
               
              
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_ttl_national").hide();  
//                $("#TotalNational").show();
               chartjfm.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
         
         var chartix = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'Detailed_Average'
                },
                title: {
                    text: 'Detailed Average'
                },
                xAxis: {
                    categories: labels_detail_ave
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'average'
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
                        stacking: 'percent',
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
                            name: 'Target Hit',
                            data:target_hit,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_hit,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_reach,
                            stack:'reach'

                        }]
    });
    
      var labels_detail_ave = new Array();
      var target_reach_ave = new Array();
      var target_hit_ave = new Array();
      var actual_reach_ave = new Array();
      var actual_hit_ave = new Array();
      var agency_detail_ave =  document.getElementById('agency_detail_ave');
      var region_detail_ave =  document.getElementById('region_detail_ave');
      var month_detail_ave =  document.getElementById('month_detail_ave');
      var brand_detail_ave =  document.getElementById('brand_detail_ave');
      var year_details_ave =  document.getElementById('year_detail_ave');
        $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/DetailAverage'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency_detail_ave.value+'&region='+region_detail_ave.value+'&month='+month_detail_ave.value+'&brand='+brand_detail_ave.value+'&year='+year_details_ave.value,
             beforeSend: function(){
//               $("#detail_table_loader_dtl").show();  
//               $("#detailed_reach").hide();  
                 charts.showLoading();
             },
            'success':function(data) {
             
                for(var i = 0; i < data.length; i++){
                    labels_detail_ave.push(data[i].salesman);

                    var percentage_hit = data[i].actual_hit / data[i].actual_attendance;
                    var percentage_reach = data[i].actual_reach / data[i].actual_attendance;
                    var target_reach_ajax = 100 - percentage_reach;
                    var target_hit_ajax = 100 - percentage_hit;
//                    console.log(test);
                    if(percentage_hit >= 100)
                    {
                        color_hit = 'green';
                    }else if(percentage_hit >= 90 && percentage_hit <99)
                    {
                        color_hit = 'yellow';
                    }else{
                        color_hit = 'red';
                    }
                    
                    if(percentage_reach >= 100)
                    {
                        color_reach = 'green';
                    }else if(percentage_reach >= 90 && percentage_reach <99)
                    {
                        color_reach = 'yellow';
                    }else{
                        color_reach = 'red';
                    }
                      var hit_percentage = parseFloat(Math.round(percentage_hit * 100) / 100).toFixed(2)
                      var reach_percentage = parseFloat(Math.round(percentage_reach * 100) / 100).toFixed(2)
                      
                      var t_reach_percentage = parseFloat(Math.round(target_reach_ajax * 100) / 100).toFixed(2)
                      var t_hit_percentage = parseFloat(Math.round(target_hit_ajax * 100) / 100).toFixed(2)
                      target_hit_ave.push({y: parseFloat(t_hit_percentage), color: 'gray',mydatac:100});
                      actual_hit_ave.push({y: parseFloat(hit_percentage), color: color_hit,mydatac:parseFloat(hit_percentage)});
                      
                      target_reach_ave.push({y: parseFloat(t_reach_percentage), color: 'gray',mydatac:100});
                      actual_reach_ave.push({y: parseFloat(reach_percentage), color: color_reach,mydatac:parseFloat(reach_percentage)});
                      

                   }

               chartix.xAxis[0].setCategories(labels_detail_ave)
               chartix.series[0].setData(target_reach_ave)
               chartix.series[1].setData(actual_reach_ave)
               chartix.series[2].setData(target_hit_ave)
               chartix.series[3].setData(actual_hit_ave)  
               chartix.hideLoading();
               
            },
            error: function(jqXHR, exception) {
//                $("#detail_table_loader_tl_reach").hide();  
//              $("#tlreach").show();
                chartv.hideLoading();
               alert('An error occured: '+ exception);
            }
         }); 
         
          $.ajax({
                'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/compute'); ?>",
                'type':'GET',
                'dataType': 'json',
                'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&year='+year_ttl.value,
                 beforeSend: function(){
                        $("#covered").html('');
                        $("#reach").html('');
                        $("#trial").html('');
                 },
                'success':function(data) {
                    
                    for(var i = 0; i < data.length; i++){

                        $("#covered").append(data[i].covered.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $("#reach").append(data[i].reach.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $("#trial").append(data[i].hit.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                        $("#productivity").append(data[i].productivity+'%');
                    }
                }
                
                });

});
    
    


</script>