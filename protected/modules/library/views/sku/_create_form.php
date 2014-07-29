<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">

            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'sku-form', 'enableAjaxValidation' => false,
            ));
            ?>

            <div style="float: left; width: 60%;">
                <div class="panel-body">

                    <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
                      <i class="fa fa-ban"></i>
                      <?php echo $form->errorSummary($model); ?></div>
                     */ ?>   

                    <div class="form-group">
                        <?php echo $form->textFieldGroup($model, 'sku_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    </div>

                    <div class="form-group">
                        <?php // echo $form->textFieldGroup($model, 'brand_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50))));  ?>
                        <?php
                        echo $form->dropDownListGroup(
                                $model, 'brand_id', array('wrapperHtmlOptions' => array(
                                'class' => 'col-sm-5',
                            ),
                            'widgetOptions' => array(
                                'data' => $brand,
                                'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Brand'),
                            )
                                )
                        );
                        ?>
                    </div>

                    <div class="form-group">
                        <?php echo $form->textFieldGroup($model, 'sku_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 150)))); ?>
                    </div>

                    <div class="form-group">
                        <?php echo $form->textFieldGroup($model, 'description', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 150)))); ?>
                    </div>

                    <div id="sku_custom_datas">

                        <?php
                        echo $this->renderPartial('_customItems', array('model' => $model, 'custom_datas' => $custom_datas));
                        ?>

                    </div>

                    <div class="form-group">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat')); ?>
                        <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
                    </div>

                </div>
            </div>

            <div style="float: right; width: 40%;">
                <div class="panel-body">

                    <h4 class="control-label text-primary"><b>Item Settings</b></h4>

                    <div class="form-group">
                        <?php // echo $form->textFieldGroup($model, 'default_uom_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50))));  ?>
                        <?php
                        echo $form->dropDownListGroup(
                                $model, 'default_uom_id', array(
                            'wrapperHtmlOptions' => array(
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
                        <?php echo $form->textFieldGroup($model, 'default_unit_price', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 18)))); ?>
                    </div>

                    <div class="form-group">
                        <?php echo $form->textFieldGroup($model, 'type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                    </div>

                    <div class="form-group">
                        <?php // echo $form->textFieldGroup($model, 'default_zone_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50))));  ?>
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
                        <?php echo $form->textFieldGroup($model, 'supplier', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 250)))); ?>
                    </div><br/>

                    <h4 class="control-label text-primary"><b>Restock Levels</b></h4>

                    <div class="form-group">
                        <?php echo $form->textFieldGroup($model, 'low_qty_threshold', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                    </div>

                    <div class="form-group">
                        <?php echo $form->textFieldGroup($model, 'high_qty_threshold', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                    </div>

                </div>
            </div>

            <?php $this->endWidget(); ?>                       

        </div>
    </div>
</div>

<script type="text/javascript">
    
    function onlyDotsAndNumbers(txt, event, dots) {
        console.log(dots);
        var charCode = (event.which) ? event.which : event.keyCode;

        if (charCode == 46) {
            if (dots == 0) {
                return false;
            }
            if (txt.value.indexOf(".") < 0) {
                return true;
            } else {
                return false;
            }
        }

        if (txt.value.indexOf(".") > 0) {
            var txtlen = txt.value.length;
            var dotpos = txt.value.indexOf(".");

            if ((txtlen - dotpos) > dots) {
                return false;
            }
        }

        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

</script>

