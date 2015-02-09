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
                            'htmlOptions' => array('multiple' => false, 'id' => 'total_agency'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'total_brand'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'total_year')
                                
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
    
       
       
    function redrawtotal(){
    var covered_global =0;
    var reach_global =0;
    var trials_global = 0;
    
     
     var chartz = new Highcharts.Chart({
             chart: {
                        type: 'column',
                        renderTo: 'TotalNational'
                    },
                    title: {
                        text: 'JAS'
                    },
                    xAxis: {
                        categories: labels_total
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total National Reach JAS'
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
                        },series: {
                                pointWidth: 35
                    }
                    },
                    series: [{
                        name: 'Target',
                         data: 
                            target_reach_total

                    }, {
                        name: 'Reach',
                        data:target_actual_total

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
          var chasi =  document.getElementById('project');
          console.log(chasi.value);
            $.ajax({
                'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReach'); ?>",
                'type':'GET',
                'dataType': 'json',
                'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=JAS'+'&year='+year_ttl.value+'&chasi='+chasi.value,
                 beforeSend: function(){
    //                $("#detail_table_loader_ttl_national").show();  
    //                $("#TotalNational").hide();     
                      chartz.showLoading();
                 },
                'success':function(data) {

                   for(var i = 0; i < data.length; i++){
                        labels_total.push(data[i].name);

                        var target = data[i].target_reach - data[i].actual_reach;
                        var percentage = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var test = percentage / par *100;
                        counter_target += data[i].target_reach
                        counter_actual += data[i].actual_reach
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

                        target_reach_total.push({y: target, color: 'gray',mydatac:data[i].target_reach});
                        target_actual_total.push({y: data[i].actual_reach, color: color,mydatac:data[i].target_reach});


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
                                text: 'Total National Reach OND'
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
                            },series: {
                                pointWidth: 35
                    }
                        },
                        series: [{
                            name: 'Target',
                             data: 
                                total_target_ond

                        }, {
                            name: 'Reach',
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
                'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=OND'+'&year='+year_ttl.value+'&chasi='+chasi.value,
                 beforeSend: function(){
    //                $("#detail_table_loader_ttl_national").show();  
    //                $("#TotalNational").hide(); 
                      chartond.showLoading();
                 },
                'success':function(data) {

                   for(var i = 0; i < data.length; i++){
                        labels_total_ond.push(data[i].name);

                        var target = data[i].target_reach - data[i].actual_reach;
                        var percentage = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var test = percentage / par *100;
                        counter_target_ond += data[i].target_reach
                        counter_actual_ond += data[i].actual_reach
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

                        target_reach_total_ond.push({y: target, color: 'gray',mydatac:data[i].target_reach});
                        target_actual_total_ond.push({y: data[i].actual_reach, color: color,mydatac:data[i].target_reach});


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
                            text: 'Total National Reach AMJ'
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
                        },series: {
                                pointWidth: 35
                    }
                    },
                    series: [{
                        name: 'Target',
                         data: 
                            total_target_amj

                    }, {
                        name: 'Reach',
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
                'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=AMJ'+'&year='+year_ttl.value+'&chasi='+chasi.value,
                 beforeSend: function(){
    //                $("#detail_table_loader_ttl_national").show();  
    //                $("#TotalNational").hide();  
                      chartamj.showLoading();
                 },
                'success':function(data) {

                   for(var i = 0; i < data.length; i++){
                        labels_total_amj.push(data[i].name);

                        var target = data[i].target_reach - data[i].actual_reach;
                        var percentage = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var test = percentage / par *100;
                        counter_target_amj += data[i].target_reach
                        counter_actual_amj += data[i].actual_reach
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

                        target_reach_total_amj.push({y: target, color: 'gray',mydatac:data[i].target_reach});
                        target_actual_total_amj.push({y: data[i].actual_reach, color: color,mydatac:data[i].target_reach});


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
                            text: 'Total National Reach JFM'
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
                        },series: {
                                pointWidth: 35
                        }
                    },
                    series: [{
                        name: 'Target',
                         data: 
                            total_target_jfm

                    }, {
                        name: 'Reach',
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
                'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=JFM'+'&year='+year_ttl.value+'&chasi='+chasi.value,
                 beforeSend: function(){
    //                $("#detail_table_loader_ttl_national").show();  
    //                $("#TotalNational").hide(); 
                      chartjfm.showLoading();
                 },
                'success':function(data) {

                   for(var i = 0; i < data.length; i++){
                      
                        labels_total_jfm.push(data[i].name);

                        var target = data[i].target_reach - data[i].actual_reach;
                        var percentage = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var test = percentage / par *100;
                        counter_target_jfm += data[i].target_reach
                        counter_actual_jfm += data[i].actual_reach
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

                        target_reach_total_jfm.push({y: target, color: 'gray',mydatac:data[i].target_reach});
                        target_actual_total_jfm.push({y: data[i].actual_reach, color: color,mydatac:data[i].target_reach});


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
    }   
    
    
    
    
//    
//  
$('#total_agency').change(function() {
    
    redrawtotal(); 
//    redrawtotalOND();
//    redrawtotalJFM();
//    redrawtotalAMJ();
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});
$('#total_quarter').change(function() {
    
    redrawtotal();
//    redrawtotalOND();
//    redrawtotalJFM();
//    redrawtotalAMJ();
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});
$('#total_brand').change(function() {
    
    redrawtotal();
//    redrawtotalOND();
//    redrawtotalJFM();
//    redrawtotalAMJ();
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});

$('#total_year').change(function() {
    
    redrawtotal();
//    redrawtotalOND();
//    redrawtotalJFM();
//    redrawtotalAMJ();
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});


</script>

</script>