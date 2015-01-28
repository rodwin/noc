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
                        categories: labels_total_jas
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
                            if(this.series.name !='Productivity'){
                            return '<b>' + this.x + '</b><br/>' +
                                this.series.name + ': ' + this.y + '<br/>' +
                                'Total: ' + this.point.stackTotal;
                            }else{
                             return '<b>' + this.x + '</b><br/>' +
                                
                                'Productivity: ' + this.point.stackTotal+'%';
                              
                            }
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
                            pointWidth: 15
                        }
                    },
                        series: [{
                            name: 'Target Hit',
                            data:target_hit_total_jas,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_jas,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach_total_jas,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_jas,
                            stack:'reach'

                        },{
                            name: 'Productivity',
                            data:prod_bar_jas_reach,
                            stack:'prod'

                        }
                        ]
        });

          var labels_total_jas = new Array();
          var target_reach_total_jas = new Array();
          var target_hit_total_jas = new Array();
          var actual_total_reach_jas = new Array();
          var actual_total_hit_jas = new Array();
          var counter_target_reach_jas = 0;
          var counter_target_hit_jas = 0;
          var counter_actual_hit_jas = 0;
          var counter_actual_reach_jas = 0;
          var total_target_jas =0;
          var total_actual_jas=0;
          var total_actual_reach_jas=0;
          var prod_bar_jas_reach = new Array();
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
                        labels_total_jas.push(data[i].name);

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
                        target_hit_total_jas.push({y: parseFloat(target_hit), color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_jas.push({y: parseFloat(data[i].actual_hit), color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_jas.push({y: parseFloat(target_reach), color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_jas.push({y: parseFloat(data[i].actual_reach), color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_jas_reach.push({y: parseFloat(a_p), color: color_prod,mydatac:100});
//                        prod_bar_jas_hit.push({y: parseFloat(data[i].actual_hit), color: color_prod,mydatac:parseFloat (data[i].actual_hit)});


                   }

                   chartz.xAxis[0].setCategories(labels_total_jas)
                   chartz.series[0].setData(target_hit_total_jas)
                   chartz.series[1].setData(actual_total_hit_jas)
                   chartz.series[2].setData(target_reach_total_jas)
                   chartz.series[3].setData(actual_total_reach_jas)
                   chartz.series[4].setData(prod_bar_jas_reach)
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
                                if(this.series.name !='Productivity'){
                                return '<b>' + this.x + '</b><br/>' +
                                    this.series.name + ': ' + this.y + '<br/>' +
                                    'Total: ' + this.point.stackTotal;
                                }else{
                                 return '<b>' + this.x + '</b><br/>' +

                                    'Productivity: ' + this.point.stackTotal+'%';

                                }
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
                                pointWidth: 15
                            }
                        },
                        series: [{
                            name: 'Target Hit',
                            data:target_hit_total_ond,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_ond,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach_total_ond,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_ond,
                            stack:'reach'

                        },{
                            name: 'Productivity',
                            data:prod_bar_ond_reach,
                            stack:'prod'

                        }
                        ]
            });

              var labels_total_ond = new Array();
              var target_reach_total_ond = new Array();
              var target_hit_total_ond = new Array();
              var actual_total_reach_ond = new Array();
              var actual_total_hit_ond = new Array();
              var prod_bar_ond_reach = new Array();
              
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

                        var target_hit = data[i].target_hit - data[i].actual_hit;
                        var target_reach = data[i].target_reach - data[i].actual_reach;
                        var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                        var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                        var prod = data[i].actual_hit / data[i].actual_reach * 100;
                        var test_hit = percentage_hit / par *100;
                        var test_reach = percentage_reach / par *100;
                        var prod_p = 100 - prod;
 
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



                        target_hit_total_ond.push({y: parseFloat(target_hit), color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_ond.push({y: parseFloat(data[i].actual_hit), color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_ond.push({y: parseFloat(target_reach), color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_ond.push({y: parseFloat(data[i].actual_reach), color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_ond_reach.push({y: parseFloat(a_p), color: color_prod,mydatac:100});
                        


                   }
    //             $("#detail_table_loader_ttl_national").hide();  
    //             $("#TotalNational").show();  
//                    covered_global +=total_target_ond;
//                    reach_global +=total_actual_reach_ond;
//                    trials_global +=total_actual_ond;
//                    $("#covered").html('');
//                    $("#reach").html('');
//                    $("#trial").html('');
//                    $("#covered").append(covered_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
//                    $("#reach").append(reach_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
//                    $("#trial").append(trials_global.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
//                    productivity(reach_global,trials_global)
                   chartond.xAxis[0].setCategories(labels_total_ond)
                   chartond.series[0].setData(target_hit_total_ond)
                   chartond.series[1].setData(actual_total_hit_ond)
                   chartond.series[2].setData(target_reach_total_ond)
                   chartond.series[3].setData(actual_total_reach_ond)
                   chartond.series[4].setData(prod_bar_ond_reach)
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
                           if(this.series.name !='Productivity'){
                            return '<b>' + this.x + '</b><br/>' +
                                this.series.name + ': ' + this.y + '<br/>' +
                                'Total: ' + this.point.stackTotal;
                            }else{
                             return '<b>' + this.x + '</b><br/>' +
                                
                                'Productivity: ' + this.point.stackTotal+'%';
                              
                            }
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
                                pointWidth: 15
                        }
                    },
                    series: [{
                            name: 'Target Hit',
                            data:target_hit_total_amj,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_amj,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            data:target_reach_total_amj,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_amj,
                            stack:'reach'

                        },{
                            name: 'Productivity',
                            data:prod_bar_amj_reach,
                            stack:'prod'

                        }
                        ]
        });

          var labels_total_amj = new Array();
          var target_reach_total_amj = new Array();
          var target_hit_total_amj = new Array();
          var actual_total_reach_amj = new Array();
          var actual_total_hit_amj = new Array();
          var prod_bar_amj_reach = new Array();
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
 
                        target_hit_total_amj.push({y: parseFloat(target_hit), color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_amj.push({y: parseFloat(data[i].actual_hit), color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_amj.push({y: parseFloat(target_reach), color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_amj.push({y: parseFloat(data[i].actual_reach), color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_amj_reach.push({y: parseFloat(a_p), color: color_prod,mydatac:100});

                        
//                        target_reach_total_amj.push({y: target, color: 'gray',mydatac:data[i].target_hit});
//                        target_actual_total_amj.push({y: data[i].actual_hit, color: color,mydatac:data[i].target_hit});


                   }
                   chartamj.xAxis[0].setCategories(labels_total_amj)
                   chartamj.series[0].setData(target_hit_total_amj)
                   chartamj.series[1].setData(actual_total_hit_amj)
                   chartamj.series[2].setData(target_reach_total_amj)
                   chartamj.series[3].setData(actual_total_reach_amj)
                   chartamj.series[4].setData(prod_bar_amj_reach)
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
                            if(this.series.name !='Productivity'){
                            return '<b>' + this.x + '</b><br/>' +
                                this.series.name + ': ' + this.y + '<br/>' +
                                'Total: ' + this.point.stackTotal;
                            }else{
                             return '<b>' + this.x + '</b><br/>' +
                                
                                'Productivity: ' + this.point.stackTotal+'%';
                              
                            }
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
                                pointWidth: 15
                        }
                    },
                    series: [{
                            name: 'Target Hit',
                            data:target_hit_total_jfm,
                            stack:'hit'

                        },
                        {
                            name: 'Actual Hit',
                            data:actual_total_hit_jfm,
                            stack:'hit'

                        },
                        {
                            name: 'Target Reach',
                            
                            data:target_reach_total_jfm,
                            stack:'reach'

                        }, {
                            name: 'Actual Reach',
                            data:actual_total_reach_jfm,
                            stack:'reach'

                        },{
                            
                            name: 'Productivity',
                            data:prod_bar_jfm_reach,
                            stack:'prod'

                        }
                        ]
        });

          var labels_total_jfm = new Array();
          var target_reach_total_jfm = new Array();
          var target_hit_total_jfm = new Array();
          var actual_total_reach_jfm = new Array();
          var actual_total_hit_jfm = new Array();

          var prod_bar_jfm_reach = new Array();
  
            $.ajax({
                'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachJFM'); ?>",
                'type':'GET',
                'dataType': 'json',
                'data':'agency='+agency_ttl.value+'&brand='+brand_ttl.value+'&qtr=AMJ'+'&year='+year_ttl.value,
                 beforeSend: function(){
    //                $("#detail_table_loader_ttl_national").show();  
    //                $("#TotalNational").hide();  
                      chartjfm.showLoading();
                 },
                'success':function(data) {

                   for(var i = 0; i < data.length; i++){
                        labels_total_jfm.push(data[i].name);

                        var target_hit = data[i].target_hit - data[i].actual_hit;
                        var target_reach = data[i].target_reach - data[i].actual_reach;
                        var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                        var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                        var par = data[i].par / data[i].target_attendance * 100;
                         var prod = data[i].actual_hit / data[i].actual_reach * 100;
                        var test_hit = percentage_hit / par *100;
                        var test_reach = percentage_reach / par *100;
                        var prod_p = 100 - prod;
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
                        target_hit_total_jfm.push({y: parseFloat(target_hit), color: 'gray',mydatac:data[i].target_hit});
                        actual_total_hit_jfm.push({y: parseFloat(data[i].actual_hit), color: color_hit,mydatac:data[i].target_hit});
                        target_reach_total_jfm.push({y: parseFloat(target_reach), color: 'gray',mydatac:data[i].target_reach});
                        actual_total_reach_jfm.push({y: parseFloat(data[i].actual_reach), color: color_hit,mydatac:data[i].target_reach});
                        prod_bar_jfm_reach.push({y: parseFloat(a_p), color: color_prod,mydatac:100});
                        
//                        target_reach_total_amj.push({y: target, color: 'gray',mydatac:data[i].target_hit});
//                        target_actual_total_amj.push({y: data[i].actual_hit, color: color,mydatac:data[i].target_hit});


                   }

                   chartjfm.xAxis[0].setCategories(labels_total_jfm)
                   chartjfm.series[0].setData(target_hit_total_jfm)
                   chartjfm.series[1].setData(actual_total_hit_jfm)
                   chartjfm.series[2].setData(target_reach_total_jfm)
                   chartjfm.series[3].setData(actual_total_reach_jfm)
                   chartjfm.series[4].setData(prod_bar_jfm_reach)
//                   chartjfm.series[5].setData(prod_bar_jfm_hit)
                   chartjfm.hideLoading();




                },
                error: function(jqXHR, exception) {
    //                $("#detail_table_loader_ttl_national").hide();  
    //                $("#TotalNational").show();
                   chartjfm.hideLoading();
                   alert('An error occured: '+ exception);
                }
             }); 
//             console.log(trials_global);
//             console.log(reach_global);
//             var test_global = trials_global / reach_global;
//             
//             $("#productivity").append();
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
//                        $(".head h3").html("your new header");
//                            alert(data[i].covered);
//                        document.getElementById('covered').innerHTML =data[i].covered;
//                        document.getElementById('covered').innerHTML =data[i].covered;
//                        document.getElementById('covered').innerHTML =data[i].covered;
                        $("#covered").append(data[i].covered.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $("#reach").append(data[i].reach.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $("#trial").append(data[i].hit.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                        $("#productivity").append(data[i].productivity+'%');
                    }
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
    $("#productivity").html('');
    
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
    $("#productivity").html('');
    
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
    $("#productivity").html('');
    
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
    $("#productivity").html('');
    
});


</script>

</script>