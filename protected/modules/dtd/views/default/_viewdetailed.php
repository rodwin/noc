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
                    text: 'Detailed Reach'
                },
                xAxis: {
                    categories: labels_detail
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
                        target_reach
                        
                }, {
                    name: 'Reach',
                    data:target_actual
            
                }]
    });
    
      var labels_detail = new Array();
      var target_reach = new Array();
      var target_actual = new Array();
      var month;
      var agency =  document.getElementById('agency_detail');
      var region =  document.getElementById('region_detail');
      var month =  document.getElementById('month_detail');
      var brand =  document.getElementById('brand_detail');
      var year_detail =  document.getElementById('year_detail');
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
                    
                    var target = data[i].target_hit - data[i].actual_hit;
//                    console.log(target);
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
                    target_reach.push({y: target, color: 'gray',mydata:target});
                    target_actual.push({y: parseFloat(data[i].actual_hit), color: color,mydata:target});
   
               }
//               console.log(target_reach);
               charts.xAxis[0].setCategories(labels_detail)
               charts.series[0].setData(target_reach)
               charts.series[1].setData(target_actual)
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