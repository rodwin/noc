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
                            $model, 'quarter', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $qtr,
                            'htmlOptions' => array('multiple' => false, 'id' => 'total_quarter')
                                
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
         var charts = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'TotalNational'
                },
                title: {
                    text: 'Total National Reach'
                },
                xAxis: {
                    categories: labels_ttl_view
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
                        target_reach_ttl_view
                        
                }, {
                    name: 'Reach',
                    data:target_actual_ttl_view
            
                }]
    });
    
      var labels_ttl_view = new Array();
      var target_reach_ttl_view = new Array();
      var target_actual_ttl_view = new Array();
      var month;
      var agency =  document.getElementById('total_agency');
      var qtr =  document.getElementById('total_quarter');
      var brand =  document.getElementById('total_brand');
      var year =  document.getElementById('total_year');
      var counter_target = 0;
      var counter_actual = 0;
      var total_target;
      var total_actual;
         $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReach'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency.value+'&brand='+brand.value+'&qtr='+qtr.value+'&year='+year.value,
             beforeSend: function(){
                $("#detail_table_loader_ttl_national").show();  
                $("#TotalNational").hide();   
                $("#detail_table_loader_ttl_national_qtr").show();  
                $("#TotalNational_qtr").hide();  
             },
            'success':function(data) {
             alert(data.length);
               for(var i = 0; i < data.length; i++){
                    labels_ttl_view.push(data[i].name);
                  
                    var target = data[i].target_reach - data[i].actual_reach;
                    var percentage = data[i].actual_reach / data[i].target_reach * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;
                    counter_target += data[i].target_reach
                    counter_actual += data[i].actual_reach
                    total_target = counter_target ;
                    total_actual = counter_actual ;
                    if(test >= 95)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <94)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    target_reach_ttl_view.push({y: target, color: 'gray',mydata:data[i].target_reach});
                    target_actual_ttl_view.push({y: data[i].actual_reach, color: color,mydata:data[i].target_reach});
   
               }
                if(data.length > 0){
                $("#covered").append(total_target.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#reach").append(total_actual.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#trial").append(total_actual.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
               charts.xAxis[0].setCategories(labels_ttl_view)
               charts.series[0].setData(target_reach_ttl_view)
               charts.series[1].setData(target_actual_ttl_view)
               $("#detail_table_loader_ttl_national").hide();  
               $("#TotalNational").show();  
               
              redrawtotalhs()
               
            },
            error: function(jqXHR, exception) {
               alert('An error occured: '+ exception);
                $("#detail_table_loader_ttl_national").hide();  
               $("#TotalNational").show();  
//                redrawtotalhs()
            }
         }); 
    }
    
    
    function redrawtotalhs(){
         var chartxz= new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'TotalNational_qtr'
                },
                title: {
                    text: 'Total National Reach'
                },
                xAxis: {
                    categories: labels_ttl_view_hs
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
                        target_reach_ttl_view_hs
                        
                }, {
                    name: 'Reach',
                    data:target_actual_ttl_view_hs
            
                }]
    });
    
      var labels_ttl_view_hs = new Array();
      var target_reach_ttl_view_hs = new Array();
      var target_actual_ttl_view_hs = new Array();
      var month;
      var agency =  document.getElementById('total_agency');
      var qtr =  document.getElementById('total_quarter');
      var brand =  document.getElementById('total_brand');
      var year =  document.getElementById('total_year');
         $.ajax({
            'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/TotalNationalReachHistory'); ?>",
            'type':'GET',
            'dataType': 'json',
            'data':'agency='+agency.value+'&brand='+brand.value+'&qtr='+qtr.value+'&year='+year.value,
             beforeSend: function(){
                $("#detail_table_loader_ttl_national_qtr").show();  
                $("#TotalNational_qtr").hide();          
             },
            'success':function(data) {
             
               for(var i = 0; i < data.length; i++){
                    labels_ttl_view_hs.push(data[i].name);
                  
                    var target = data[i].target_reach - data[i].actual_reach;
                    var percentage = data[i].actual_reach / data[i].target_reach * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var test = percentage / par *100;

                    if(test >= 95)
                    {
                        color = 'green';
                    }else if(test >= 90 && test <94)
                    {
                        color = 'yellow';
                    }else{
                        color = 'red';
                    }
                    target_reach_ttl_view_hs.push({y: target, color: 'gray',mydata:data[i].target_reach});
                    target_actual_ttl_view_hs.push({y: data[i].actual_reach, color: color,mydata:data[i].target_reach});
   
               }
  
               chartxz.xAxis[0].setCategories(labels_ttl_view_hs)
               chartxz.series[0].setData(target_reach_ttl_view_hs)
               chartxz.series[1].setData(target_actual_ttl_view_hs)
               $("#detail_table_loader_ttl_national_qtr").hide();  
               $("#TotalNational_qtr").show();  
               
              
               
            },
            error: function(jqXHR, exception) {
               alert('An error occured: '+ exception);
               $("#detail_table_loader_ttl_national_qtr").hide();  
               $("#TotalNational_qtr").show();  
            }
         }); 
    }
//    
//  
$('#total_agency').change(function() {
    
    redrawtotal(); 
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});
$('#total_quarter').change(function() {
    
    redrawtotal();
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});
$('#total_brand').change(function() {
    
    redrawtotal();
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});

$('#total_year').change(function() {
    
    redrawtotal();
//    redrawtotalhs(); 
    $("#covered").html('');
    $("#reach").html('');
    $("#trial").html('');
    
});


</script>

</script>