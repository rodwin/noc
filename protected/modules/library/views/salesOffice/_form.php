<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8">

                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'sales-office-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-ban"></i>
                  <?php echo $form->errorSummary($model); ?></div>
                 */ ?>

                <div class="form-group">
                    <?php //echo $form->textFieldGroup($model,'distributor_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'distributor_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $distributors,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select ' . Distributor::DIST_LABEL),
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'sales_office_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'sales_office_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'address1', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'address2', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200)))); ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'region_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'region_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $region,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Region', 'id' => 'region',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('poi/getProvinceByRegionCode'),
                                    'update' => '#province',
                                    'data' => array('region_code' => 'js:this.value',),
                                )),
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'province_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'province_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $province,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Province', 'id' => 'province',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('poi/getMunicipalByProvinceCode'),
                                    'update' => '#municipal',
                                    'data' => array('province_code' => 'js:this.value',),
                                )),
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'municipal_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'municipal_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $municipal,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Municipal', 'id' => 'municipal',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('poi/getBarangayByMunicipalCode'),
                                    'update' => '#barangay',
                                    'data' => array('municipal_code' => 'js:this.value',),
                                )),
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php // echo $form->textFieldGroup($model, 'barangay_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                    <?php
                    echo $form->dropDownListGroup(
                            $model, 'barangay_id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $barangay,
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Barangay', 'id' => 'barangay'),
                        )
                            )
                    );
                    ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'latitude', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 9)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'longitude', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 9)))); ?>
                </div>

                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat')); ?>
                    <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#region').change(function() {
        $('#municipal, #barangay').empty();
        $('#municipal').append('<option value="">Select Municipal</option>');
        $('#barangay').append('<option value="">Select Barangay</option>');
    });

    $('#province').change(function() {
        $('#barangay').empty();
        $('#barangay').append('<option value="">Select Barangay</option>');
    });

</script>