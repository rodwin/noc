<div class="well clearfix" style="padding-left: 0px!important; padding-right: 0px!important;">
    <div id="<?php echo $model_label; ?>selected_return_from"><i class="text-muted"><center>Not Set</center></i></div>

    <div id="<?php echo $model_label; ?>outlet_fields" class="return_source" style="display: none;">
        <div id="input_label" class="pull-left col-md-5">
            <?php echo $form->label($model, "Outlet"); ?><br/>
            <?php echo $form->label($model, "Outlet Code"); ?><br/>
            <?php echo $form->label($model, "Address"); ?>
        </div>

        <div class="pull-right col-md-7">
            <?php
            $this->widget(
                    'booster.widgets.TbSelect2', array(
                'name' => 'selected_outlet',
                'data' => $poi_list,
                'htmlOptions' => array(
                    'id' => 'selected_outlet',
                    'class' => 'span5 return_from_select2',
                    'prompt' => '--'
                ),
            ));
            ?>

            <div id="poi_primary_code" class="autofill_text span5"><?php echo $not_set; ?></div>
            <div id="poi_address1" class="autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
        </div>

    </div>

    <div id="<?php echo $model_label; ?>salesoffice_fields" class="return_source" style="display: none;">
        <div id="input_label" class="pull-left col-md-5">
            <?php echo $form->label($model, "Salesoffice"); ?><br/>
            <?php echo $form->label($model, "Salesoffice Code"); ?><br/>
            <?php echo $form->label($model, "Address"); ?>
        </div>

        <div class="pull-right col-md-7">
            <?php
            $this->widget(
                    'booster.widgets.TbSelect2', array(
                'name' => 'selected_salesoffice',
                'data' => $salesoffice_list,
                'htmlOptions' => array(
                    'id' => 'selected_salesoffice',
                    'class' => 'span5 return_from_select2',
                    'prompt' => '--'
                ),
            ));
            ?>

            <div id="salesoffice_code" class="autofill_text span5"><?php echo $not_set; ?></div>
            <div id="salesoffice_address1" class="autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
        </div>

    </div>

    <div id="<?php echo $model_label; ?>employee_fields" class="return_source" style="display: none;">
        <div id="input_label" class="pull-left col-md-5">
            <?php echo $form->label($model, "Salesman"); ?><br/>
            <?php echo $form->label($model, "Salesman Code"); ?><br/>
            <?php echo $form->label($model, "Default Zone"); ?><br/>
            <?php echo $form->label($model, "Address"); ?>
        </div>

        <div class="pull-right col-md-7">
            <?php
            $this->widget(
                    'booster.widgets.TbSelect2', array(
                'name' => 'selected_salesman',
                'data' => $employee,
                'htmlOptions' => array(
                    'id' => 'selected_salesman',
                    'class' => 'span5 return_from_select2',
                    'prompt' => '--'
                ),
            ));
            ?>

            <div id="employee_code" class="autofill_text span5"><?php echo $not_set; ?></div>
            <div id="employee_address1" class="autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
            <div id="employee_default_zone" class="autofill_text span5" style="height: auto;"><?php echo $not_set; ?></div>
        </div>

    </div>
</div>


<script type="text/javascript">



</script>