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
                            'htmlOptions' => array('multiple' => false, 'id' => 'agency_detail'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'month_detail'  , 'required'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'brand_detail'),
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
                            'htmlOptions' => array('multiple' => false,'prompt' => 'Select Region', 'id' => 'region_detail'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'year_detail')
                                
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
    
       
    
    function redrawdetail(){
         var charts = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'detailed_reach'
                },
                title: {
                    text: 'Detailed'
                },
                xAxis: {
                    categories: labels_detail
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
                        size:'100%',
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
                            data:prod_bar_detail_reach,
                            stack:'prod'

                        }]
    });
    
      var labels_detail = new Array();
      var target_reach = new Array();
      var target_hit = new Array();
      var actual_reach = new Array();
      var actual_hit = new Array();
      var month;
      var agency =  document.getElementById('agency_detail');
      var region =  document.getElementById('region_detail');
      var month =  document.getElementById('month_detail');
      var brand =  document.getElementById('brand_detail');
      var year_detail =  document.getElementById('year_detail');
      var prod_bar_detail_reach = new Array();
      
        if(brand.value != 6){
             $.ajax({
                'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/DetailHit'); ?>",
                'type':'GET',
                'dataType': 'json',
                'data':'agency='+agency.value+'&region='+region.value+'&month='+month.value+'&brand='+brand.value+'&year='+year_detail.value,
                beforeSend: function(){
    //               $("#detail_table_loader_dtl").show();  
    //               $("#detailed_reach").hide();  
                     charts.showLoading();
                 },
                'success':function(data) {

                   for(var i = 0; i < data.length; i++){
                    labels_detail.push(data[i].name);
                    
                    var target_reach_ajax = data[i].target_reach - data[i].actual_reach;
                    var target_hit_ajax = data[i].target_hit - data[i].actual_hit;
                    var percentage_hit = data[i].actual_hit / data[i].target_hit * 100;
                    var percentage_reach = data[i].actual_reach / data[i].target_reach * 100;
                    var par = data[i].par / data[i].target_attendance * 100;
                    var prod = data[i].actual_hit / data[i].actual_reach * 100;
                    var test_hit = percentage_hit / par *100;
                    var test_reach = percentage_reach / par *100;
//                    console.log(test);

                    if(brand.value == 9 ){

                        var hits_from =54.50;
                        var hits_to =59.49;

                    }else if(brand.value == 29 ){
                        var hits_from =40;
                        var hits_to =44;

                    }else{
                        var hits_from =65;
                        var hits_to =69;

                    }
                    
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
                    
                    if(prod > hits_to)
                    {
                        color_prod= 'green';
                    }else if(prod >= hits_from && prod <hits_to)
                    {
                        color_prod = 'yellow';
                    }else{
                        color_prod = 'red';
                    }
                    var a_p = parseFloat(Math.round(prod)).toFixed(2)
//                    target_reach.push({y: target, color: 'gray',mydatab:data[i].target_reach});
//                    target_actual.push({y: data[i].actual_reach, color: color,mydatab:data[i].target_reach});
                      target_reach.push({y: parseFloat(target_reach_ajax), color: 'gray',mydatac:target_reach_ajax});
                      actual_reach.push({y: parseFloat(data[i].actual_reach), color: color_reach,mydatac:target_reach_ajax});
                      target_hit.push({y: parseFloat(target_hit_ajax), color: 'gray',mydatac:target_hit_ajax});
                      actual_hit.push({y: parseFloat(data[i].actual_hit), color: color_hit,mydatac:target_hit_ajax})
                      prod_bar_detail_reach.push({y: parseFloat(a_p) , color: color_prod,mydatac:100});


                   }
    //               console.log(target_reach);
                   charts.xAxis[0].setCategories(labels_detail)                 
                   charts.series[0].setData(target_hit)
                   charts.series[1].setData(actual_hit)
                   charts.series[2].setData(target_reach)
                   charts.series[3].setData(actual_reach)
                   charts.series[4].setData(prod_bar_detail_reach)
                  
                   charts.hideLoading();
    //               $("#detail_table_loader_dtl").hide();  
    //               $("#detailed_reach").show();



                },
                error: function(jqXHR, exception) {
    //                $("#detail_table_loader_dtl").hide();  
    //                $("#detailed_reach").show();
                      charts.hideLoading();

                   alert('An error occured: '+ exception);
                }
             }); 
         }else{
            alert('test');
         }
    }
//    
//  
$('#agency_detail').change(function() {
    
    redrawdetail(); 
    
});
$('#region_detail').change(function() {
    
    redrawdetail(); 
    
});
$('#province_detail').change(function() {
    
    redrawdetail(); 
    
});
$('#month_detail').change(function() {
    
    redrawdetail(); 
    
});
$('#ph_detail').change(function() {
    
    redrawdetail(); 
    
});
$('#brand_detail').change(function() {
    
    redrawdetail(); 
    
});
$('#year_detail').change(function() {
    
    redrawdetail(); 
    
});
</script>

</script>