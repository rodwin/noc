<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);


?>

<style>
 #test {display: none; }  
 #ph2_table {display: none; } 
</style>

      <div class="panel panel-default">
          <div class="panel-heading">Survey</div>
          
          <div class="panel-body" id ="Survey">
              <div class="row">
                  <div class="col-md-6">                    
                       <?php

                        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                            'id' => 'survey-form',
                            'enableAjaxValidation' => false,
                            'type'=>'horizontal',
                        ));
                        
                        
                        echo $form->dropDownListGroup(
                                $model, 'bws', array(
                            'wrapperHtmlOptions' => array(
                                'class' => 'col-sm-5',
                            ),
                            'widgetOptions' => array(
                                'data' =>$bws,
                                'htmlOptions' => array('multiple' => false, 'id' => 'bws_survey' , 'prompt' => 'Select bws'),
                           )

                                )
                        );
                        
                        echo $form->dropDownListGroup(
                            $model, 'ph', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' =>$ph,
                            'htmlOptions' => array('multiple' => false, 'id' => 'ph_survey',
                                'ajax' => array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('getHospitalByPh'),
                                    'update' => '#hospital_survey',
                                    'data' => array('id' => 'js:this.value',),
                                )),
                       )
                        
                            )
                    );
                
                        ?>
                  </div>
                  
              </div>
              <div class="row">
                  <div class="col-md-6"> 
                      <table class="table table-bordered">
                          <tr>
                              <td>PAMPERS BABY WELLNESS SPECIALIST</td>
                          </tr>
                          <tr>
                              <td>INTERNAL QA CHECKLIST</td>
                          </tr>
                      </table>
                      <table class="table table-bordered">
                          <tr>
                              <td>
                                  NAME OF BWS:
                              </td>
                              <td id="name_bws">
                                  
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  HOSPITAL/CLINIC CHECKED:
                              </td>
                              <td>
                                  <?php
                                    echo $form->dropDownListGroup(
                                            $model, 'hospital', array(
                                        
                                        'widgetOptions' => array(
                                            'data' =>$hospital,
                                            'htmlOptions' => array('multiple' => false, 'id' => 'hospital_survey', 'prompt' => 'Select hospital'),
                                       ),'labelOptions'=> array(
                                           'label'=>false,
                                       )

                                            )
                                    );
                                    ?>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  DATE CHECKED:
                              </td>
                              <td>
                                   <?php echo $form->textField($model,'date',array('size'=>10,'maxlength'=>50,'value'=>date('Y-m-d'), 'readonly'=>'readonly')); ?>
                                   <?php echo $form->error($model,'date'); ?>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  NAME OF RATER:
                              </td>
                          
                              <td>
                                   <?php echo $form->textField($model,'rater',array('size'=>30,'maxlength'=>50, 'readonly'=>'readonly','value'=>Yii::app()->user->userObj->user_name)); ?>
                                   <?php echo $form->error($model,'rater'); ?>
                              </td>
                         </tr>
                      </table>
 
                      <table class="table table-bordered" id ="Question">
                          <?php 
                            foreach($question as $key => $val){
                           ?>
                          <tr>
                              <th>
                                  <?php echo $key ?>
                              </th>
                              <th>
                                  
                              </th>
                          </tr>
                          <?php
                           foreach($val as $k => $v){
                          ?>
                          <tr>
                              <td><?php echo $v ?></td>
                              <td>  <select name ="answer[]">
                                      <option value="1">1</option>
                                      <option value="0.5">0.5</option>
                                      <option value="0.25">0.25</option>
                                      <option value="0.75">0.75</option>
                                      <option value="0">0</option>
                                    </select>
<!--                                  <input type="textbox" name ="answer[]" maxlength='2' onkeypress="javascript: return acceptValidNumbersOnly(this,event);"</td>-->
                              <input type="hidden" name ="question[]" value="<?php echo $v?>" ></td>
                          </tr>
                          <?php
                           }
                           }                        
                          ?>
                      </table>
                  </div>
              </div>
           
             <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary btn-flat')); ?></div>                              
        </div>
      
        
      </div>
 
<?php $this->endWidget(); ?>

      <script>
      $(document).ready(function(){
      $('#bws_survey').val('');
      });
$('#bws_survey').change(function() {
    
        $.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createUrl('/pome/survey/getBwsDetail'); ?>' + '&bws_id=' + this.value,
            dataType: "json",
            success: function(data) {
                document.getElementById('name_bws').innerHTML = data.firstname+' '+data.lastname;
//                document.getElementById('S').innerHTML = data.firstname+' '+data.lastname;
            },
            error: function(data) {
                alert("Error occured: Please try again.");
            }
        });
    
});

$('#ph_survey').change(function() {
    
      if(this.value =='PH1'){
           $("#ph2_table" ).hide();
           $("#ph1_table" ).show();
      }else{
          $("#ph2_table" ).show();
          $("#ph1_table" ).hide();
      }
    
});

function acceptValidNumbersOnly(obj,e) {
			var key='';
			var strcheck = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()_+=-`{}[]:\";'\|/?,><\\23456789 ";
			var whichcode = (window.Event) ? e.which : e.keyCode;
			try{
			if(whichcode == 13 || whichcode == 8)return true;
			key = String.fromCharCode(whichcode);
			if(strcheck.indexOf(key) != -1)return false;
			return true;
			}catch(e){;}
            //onkeypress="javascript: return acceptValidNumbersOnly(this,event);"
}
</script>

