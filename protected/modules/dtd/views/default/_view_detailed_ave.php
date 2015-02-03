<div class="view">
 <div class="form-group">
            <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'view_detail_ave-form',
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'agency_detail_ave'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'month_detail_ave'  , 'required'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'brand_detail_ave'),
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
                            'htmlOptions' => array('multiple' => false,'prompt' => 'Select Region', 'id' => 'region_detail_ave'),
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
                            'htmlOptions' => array('multiple' => false, 'id' => 'year_detail_ave')
                                
                        )
                            )
                    );
                    ?> 
     <?php $this->endWidget(); ?>
                </div>



</div>

<script>
   
    function redrawdetailave(){
         var chartix = new Highcharts.Chart({
         chart: {
                    type: 'column',
                    renderTo: 'Detailed_Average'
                },
                title: {
                    text: 'Detailed Average'
                },
                xAxis: {
                    categories: labels_detail
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Detailed Average'
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
                        return '<b>' + this.x + '%</b><br/>' +
                            'Total: ' + this.point.stackTotal+'%';
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
                            name: 'Hit Average',
                            data:target_hit,
                            stack:'hit'

                        },
                        {
                            name: 'Reach Average',
                            data:target_reach,
                            stack:'reach'

                        }]
    });
    
      var labels_detail = new Array();
      var target_reach = new Array();
      var target_hit = new Array();
      var actual_reach = new Array();
      var actual_hit = new Array();
      var month;
      var agency =  document.getElementById('agency_detail_ave');
      var region =  document.getElementById('region_detail_ave');
      var month =  document.getElementById('month_detail_ave');
      var brand =  document.getElementById('brand_detail_ave');
      var year_detail =  document.getElementById('year_detail_ave');
      
             $.ajax({
                'url':"<?php echo Yii::app()->createUrl($this->module->id . '/Default/DetailAverage'); ?>",
                'type':'GET',
                'dataType': 'json',
                'data':'agency='+agency.value+'&region='+region.value+'&month='+month.value+'&brand='+brand.value+'&year='+year_detail.value,
                beforeSend: function(){
    //               $("#detail_table_loader_dtl").show();  
    //               $("#detailed_reach").hide();  
                     chartix.showLoading();
                 },
                'success':function(data) {

                   for(var i = 0; i < data.length; i++){
                    labels_detail.push(data[i].name);
                    
                    
                    var percentage_hit = data[i].actual_hit / data[i].actual_attendance;
                    var percentage_reach = data[i].actual_reach / data[i].actual_attendance;
                    var target_reach_ajax = 100 - percentage_reach;
                    var target_hit_ajax = 100 - percentage_hit;
//                    console.log(test);
                    if(brand.value == 9 ){
                        
                       
                        var hits_from =37.50;
                        var hits_to =41.49;
                        var calls_from = 62.50;
                        var calls_to = 69.49;
                    }else if(brand.value == 29 ){
                        var hits_from =23;
                        var hits_to =26;
                        var calls_from = 54;
                        var calls_to = 59;
                    }else{
                        var hits_from =44;
                        var hits_to =48;
                        var calls_from = 63;
                        var calls_to = 69;
                    }
                    
                    if(percentage_hit > hits_to)
                    {
                        color_hit = 'green';
                    }else if(percentage_hit >= hits_from && percentage_hit <hits_to)
                    {
                        color_hit = 'yellow';
                    }else{
                        
                        color_hit = 'red';
                    }

                    if(percentage_reach > calls_to)
                    {
                        color_reach = 'green';
                    }else if(percentage_reach >= calls_from && percentage_reach <calls_to)
                    {
                        color_reach = 'yellow';
                    }else{
                        color_reach = 'red';
                    }
                      var hit_percentage = parseFloat(Math.round(percentage_hit * 100) / 100).toFixed(2)
                      var reach_percentage = parseFloat(Math.round(percentage_reach * 100) / 100).toFixed(2)
                      
                      var t_reach_percentage = parseFloat(Math.round(target_reach_ajax * 100) / 100).toFixed(2)
                      var t_hit_percentage = parseFloat(Math.round(target_hit_ajax * 100) / 100).toFixed(2)
                      target_hit.push({y: parseFloat(hit_percentage), color: color_hit,mydatac:100});
//                      actual_hit.push({y: parseFloat(hit_percentage), color: color_hit,mydatac:parseFloat(hit_percentage)});
                      
                      target_reach.push({y: parseFloat(reach_percentage), color: color_reach,mydatac:100});
//                      actual_reach.push({y: parseFloat(reach_percentage), color: color_reach,mydatac:parseFloat(reach_percentage)});
                      

                   }
    //               console.log(target_reach);
                   chartix.xAxis[0].setCategories(labels_detail)
                   chartix.series[0].setData(target_reach)
//                   chartix.series[1].setData(actual_reach)
                   chartix.series[1].setData(target_hit)
//                   chartix.series[3].setData(actual_hit)
                   chartix.hideLoading();
    //               $("#detail_table_loader_dtl").hide();  
    //               $("#detailed_reach").show();



                },
                error: function(jqXHR, exception) {
    //                $("#detail_table_loader_dtl").hide();  
    //                $("#detailed_reach").show();
                      chartix.hideLoading();

                   alert('An error occured: '+ exception);
                }
             }); 

    }
//    
//  
$('#agency_detail_ave').change(function() {
    
    redrawdetailave(); 
    
});
$('#region_detail_ave').change(function() {
    
    redrawdetailave(); 
    
});

$('#month_detail_ave').change(function() {
    
    redrawdetailave(); 
    
});

$('#brand_detail_ave').change(function() {
    
    redrawdetailave(); 
    
});
$('#year_detail_ave').change(function() {
    
    redrawdetailave(); 
    
});
</script>
