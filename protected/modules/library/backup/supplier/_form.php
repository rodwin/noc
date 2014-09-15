<div class="row">

    <div class="panel panel-default">

        <div class="panel-body">
            <div class="col-md-8">

                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'supplier-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-ban"></i>
                  <?php echo $form->errorSummary($model); ?></div>
                 */ ?>        


                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'supplier_code', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'supplier_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'contact_person1', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'contact_person2', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'telephone', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'cellphone', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textFieldGroup($model, 'fax_number', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
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
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Region',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('poi/getProvinceByRegionCode'),
                                    'update' => '#Supplier_province_id',
                                    'data' => array('region_code' => 'js:this.value',),
                                )),
                    )));
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
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Province',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('poi/getMunicipalByProvinceCode'),
                                    'update' => '#Supplier_municipal_id',
                                    'data' => array('province_code' => 'js:this.value',),
                                )),
                    )));
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
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Municipal',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('poi/getBarangayByMunicipalCode'),
                                    'update' => '#Supplier_barangay_id',
                                    'data' => array('municipal_code' => 'js:this.value',),
                                )),
                    )));
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
                            'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Barangay',
                            ),
                    )));
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

    $('#Supplier_region_id').change(function() {
        $('#Supplier_municipal_id, #Supplier_barangay_id').empty();
        $('#Supplier_municipal_id').append('<option value="">Select Municipal</option>');
        $('#Supplier_barangay_id').append('<option value="">Select Barangay</option>');
    });

    $('#Supplier_province_id').change(function() {
        $('#Supplier_barangay_id').empty();
        $('#Supplier_barangay_id').append('<option value="">Select Barangay</option>');
    });

</script>