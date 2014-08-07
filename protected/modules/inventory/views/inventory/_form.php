<?php  
  $baseUrl = Yii::app()->theme->baseUrl; 
  $cs = Yii::app()->getClientScript();
  //$cs->registerCssFile(Yii::app()->baseUrl.'/css/select2.css');
  $cs->registerScriptFile($baseUrl.'/js/plugins/input-mask/jquery.inputmask.js',CClientScript::POS_END);
  $cs->registerScriptFile($baseUrl.'/js/plugins/input-mask/jquery.inputmask.date.extensions.js',CClientScript::POS_END);
  $cs->registerScriptFile($baseUrl.'/js/plugins/input-mask/jquery.inputmask.extensions.js',CClientScript::POS_END);
  //$cs->registerScriptFile(Yii::app()->baseUrl.'/js/select2.min.js',CClientScript::POS_END);
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-5">
        <!-- general form elements -->
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Create a New Inventory Record</h3>
            </div><!-- /.box-header -->
            
            <?php
            
            ?>

            
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'inventory-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="box-body">
                <?php if ($form->errorSummary($model)) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <?php echo $form->errorSummary($model); ?></div>
                <?php } ?>        


                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'sku_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                        $model, 'sku_id', array(
                           
                            'widgetOptions' => array(
                                'data' => $sku,
                                'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Sku'),
                            )
                        )
                    );
                    ?>
                    Brand Name:<br/>
                    Sku Name:
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'qty', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'uom_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                        $model, 'default_uom_id', 
                        array(
                            'wrapperHtmlOptions' => 
                                array(
                                'class' => 'col-sm-5',
                                ),
                            'widgetOptions' => array(
                                'data' => $uom,
                                'htmlOptions' => array('multiple' => false, 'prompt' => 'Select UOM'),
                            )
                        )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'default_zone_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $zone,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Zone'),
                        )
                            )
                    );
                    ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'cost_per_unit', array('widgetOptions' => array('htmlOptions' => array())
                            ,'prepend' => 'P'
                            ,'append' => '.00'
                            )); ?>
                </div>
                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'sku_status_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                        $model, 'sku_status_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $sku_status,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Sku Status'),
                        )
                            )
                    );
                    ?>
                </div>


                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('data-inputmask'=>"'alias': 'yyyy-mm-dd'",'data-mask'=>'data-mask'))
                            ,'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
                            )); ?>
                    
                    
                </div>

                <div class="form-group">
                    <?php //echo $form->datePickerGroup($model, 'unique_date', array('widgetOptions' => array('options' => array(), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'unique_tag', array('widgetOptions' => array('htmlOptions' => array('maxlength' => 250))
                            ,'prepend' => '<i class="fa fa-tag"></i>'
                        )); ?>
                </div>

                <div class="form-group">
                    <?php echo CHtml::submitButton('Create & New', array('name' => 'create', 'class' => 'btn btn-primary btn-flat')); ?>
                    <?php echo CHtml::submitButton('Save', array('name' => 'save', 'class' => 'btn btn-primary btn-flat')); ?>
                    <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>

        </div>
    </div>
    <!-- right column -->
    <div class="col-md-7">
        <?php
        echo $this->renderPartial('_inventory_history', array());
        ?>

    </div>
</div>
<script type="text/javascript">
    $(function() {
        //Datemask dd/mm/yyyy
        $("[data-mask]").inputmask();
        //$("#CreateInventoryForm_sku_id").select2();
    });
</script>