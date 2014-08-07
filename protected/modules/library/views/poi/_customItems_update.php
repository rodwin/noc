
<div class="panel panel-default">
    <div class="panel-body">

        <h4 class="control-label text-primary"><b>Custom Item Fields</b></h4>

        <?php if (count($custom_datas) > 0) { ?>

            <?php
            foreach ($custom_datas as $key => $val) {

                $attr = CJSON::decode($val['attribute']);
                $required = $val['required'] == 1 ? "*" : "";
                $label_name = ucwords($val['name']) . " " . $required;
                $placeholder = ucwords($val['name']);
                $data_type = $val['data_type'];
                $post_name = str_replace(' ', '_', strtolower($val['category_name'])) . "_" . str_replace(' ', '_', strtolower($val['data_type'])) . "_" . str_replace(' ', '_', strtolower($val['name']));

                if ($data_type == PoiCustomData::TYPE_TEXT_NUMBERS) {

                    if ($attr['text_field'] == 1) {
                        ?>

                        <div class="form-group">
                            <label><?php echo $label_name; ?></label>
                            <?php echo CHtml::textArea($post_name, isset($_POST[$post_name]) ? $_POST[$post_name] : $val['custom_data_value'], array('maxlength' => isset($attr['max_character_length']) ? $attr['max_character_length'] : "", 'class' => 'form-control input', 'style' => 'resize: none; height: 100px;', 'placeholder' => $placeholder)); ?>
                            <?php echo isset($_POST[$post_name]) ? $form->error($poi_custom_data, $post_name, array("style" => "color: #f56954;")) : ""; ?>
                        </div>

                    <?php } else { ?>

                        <div class="form-group">
                            <label><?php echo $label_name; ?></label>                            
                            <?php echo CHtml::textField($post_name, isset($_POST[$post_name]) ? $_POST[$post_name] : $val['custom_data_value'], array('maxlength' => isset($attr['max_character_length']) ? $attr['max_character_length'] : "", 'class' => 'form-control input', 'placeholder' => $placeholder)); ?>
                            <?php echo isset($_POST[$post_name]) ? $form->error($poi_custom_data, $post_name, array("style" => "color: #f56954;")) : ""; ?>	
                        </div>

                    <?php } ?>

                <?php } else if ($data_type == PoiCustomData::TYPE_NUMBER_ONLY) { ?>

                    <div class="form-group">
                        <label><?php echo $label_name; ?></label>

                        <?php $decimal_place = $attr['decimal_place']; ?>
                        <?php echo CHtml::textField($post_name, isset($_POST[$post_name]) ? $_POST[$post_name] : $val['custom_data_value'], array('maxlength' => PoiCustomData::CUSTOM_VALUE_LENGTH, "onkeypress" => "return onlyDotsAndNumbers(this, event, $decimal_place)", 'class' => 'form-control input', 'placeholder' => $placeholder)) ?>
                        <?php echo isset($_POST[$post_name]) ? $form->error($poi_custom_data, $post_name, array("style" => "color: #f56954;")) : ""; ?>	
                    </div>

                <?php } else if ($data_type == PoiCustomData::TYPE_CHECKBOX) { ?>

                    <div class="form-group">
                        <label>
                            <?php
                            if (isset($_POST[$post_name]) && $_POST[$post_name] == "yes") {
                                $check = true;
                            } else if (!isset($_POST[$post_name]) && $attr['default_value'] == "yes" && $val['custom_data_value'] == "") {
                                $check = true;
                            } else if (!isset($_POST[$post_name]) && $val['custom_data_value'] == "yes") {
                                $check = true;
                            } else {
                                $check = false;
                            }
                            ?>

                            <?php echo CHtml::hiddenField($post_name, "no") ?>
                            <?php echo CHtml::CheckBox($post_name, $check, array('value' => 'yes',)); ?>
                            <?php echo $label_name; ?>
                        </label>
                        <?php echo isset($_POST[$post_name]) ? $form->error($poi_custom_data, $post_name, array("style" => "color: #f56954;")) : ""; ?>
                    </div>

                <?php } else if ($data_type == PoiCustomData::TYPE_DROPDOWN) { ?>

                    <div class="form-group">
                        <label><?php echo $label_name; ?></label>
                        <select id="<?php echo $post_name; ?>" name="<?php echo $post_name; ?>" class="form-control input"><?php
                            echo implode("\n", $attr['dropDownList_default']);
                            ?></select>
                        <?php echo isset($_POST[$post_name]) ? $form->error($poi_custom_data, $post_name, array("style" => "color: #f56954;")) : ""; ?>

                        <script type="text/javascript">
                            function setSelectedOption(id, value) {
                                for (var i = 0; i < id.options.length; i++) {
                                    if (id.options[i].text == value) {
                                        id.options[i].selected = true;
                                        return;
                                    }
                                }
                            }

                            setSelectedOption(document.getElementById(<?php echo '"' . $post_name . '"'; ?>),
            <?php
            if (isset($_POST[$post_name])) {
                echo isset($_POST[$post_name]) ? '"' . $_POST[$post_name] . '"' : "";
            } else {
                echo '"' . $val['custom_data_value'] . '"';
            }
            ?>);
                        </script>
                    </div>

                <?php
                } else if ($data_type == 'Date') {
                    
                }
            }
            ?>

<?php } else { ?>
            <h6><em>No Custom Data Available.</em></h6>
<?php } ?>

    </div>
</div>