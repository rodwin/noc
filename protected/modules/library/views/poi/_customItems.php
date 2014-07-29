
<div class="panel panel-default">
    <div class="panel-body">

        <div class="control-label text-primary"><h4><b>Custom Item Fields</b></h4></div>

        <?php if (count($custom_datas) > 0) { ?>

            <?php
            foreach ($custom_datas as $key => $val) {

                $attr = CJSON::decode($val['attribute']);
                $label_name = $val['name'];
                $data_type = $val['data_type'];
                $post_name = $val['category_name'] . "_" . $val['data_type'] = str_replace(' ', '_', strtolower($val['data_type'])) . "_" . $val['name'] = str_replace(' ', '_', strtolower($val['name']));


                if ($data_type == 'Text and Numbers') {

                    if ($attr['text_field'] == 1) {
                        ?>

                        <div class="form-group">
                            <label><?php echo $label_name; ?></label>
                            <?php echo CHtml::textArea($post_name, isset($_POST[$post_name]) ? $_POST[$post_name] : $attr['default_value'], array('maxlength' => isset($attr['max_character_length']) ? $attr['max_character_length'] : "", 'class' => 'form-control input-sm', 'style' => 'resize: none; height: 100px;')); ?>
                        </div>

                    <?php } else { ?>

                        <div class="form-group">
                            <label><?php echo $label_name; ?></label>
                            <?php echo CHtml::textField($post_name, isset($_POST[$post_name]) ? $_POST[$post_name] : $attr['default_value'], array('maxlength' => isset($attr['max_character_length']) ? $attr['max_character_length'] : "", 'class' => 'form-control input-sm')); ?>

                        </div>

                    <?php } ?>

                <?php } else if ($data_type == 'Numbers Only') { ?>

                    <div class="form-group">
                        <label><?php echo $label_name; ?></label>

                        <?php
                        $value = rtrim(isset($_POST[$post_name]) ? $_POST[$post_name] : $attr['default_value'], "0");
                        $value = substr($value, -1) == "." ? rtrim($value, ".") : $value;
                        ?>
                        <?php $decimal_place = $attr['decimal_place']; ?>
                        <?php echo CHtml::numberField($post_name, isset($_POST[$post_name]) ? $_POST[$post_name] : $attr['default_value'], array('min' => $attr['min_value'], 'max' => $attr['max_value'], "onkeypress" => "return onlyDotsAndNumbers(this, event, $decimal_place)", 'class' => 'form-control input-sm')) ?>
                    </div>

                <?php } else if ($data_type == 'CheckBox') { ?>

                    <label>
                        <?php
                        if (isset($_POST[$post_name]) && $_POST[$post_name] == "1") {
                            $check = true;
                        } else if (!isset($_POST[$post_name]) && $attr['default_value'] == "1" && $val['custom_data_value'] == "") {
                            $check = true;
                        } else if (!isset($_POST[$post_name]) && $val['custom_data_value'] == "1") {
                            $check = true;
                        } else {
                            $check = false;
                        }
                        ?>

                        <?php echo CHtml::hiddenField($post_name, "0") ?>
                        <?php echo CHtml::CheckBox($post_name, $check, array('value' => '1',)); ?>
                        <?php echo $label_name; ?>
                    </label>

                <?php } else if ($data_type == 'Drop Down List') { ?>

                    <div class="form-group">
                        <label><?php echo $label_name; ?></label>
                        <select id="<?php echo $post_name; ?>" name="<?php echo $post_name; ?>" class="form-control">
                            <?php echo implode("\n", $attr['dropDownList_default']); ?>
                        </select>

                        <script type="text/javascript">
                            function setSelectedOption(id, value) {
                                for (var i = 0; i < id.options.length; i++) {
                                    if (id.options[i].text == value) {
                                        id.options[i].selected = true;
                                        return;
                                    }
                                }
                            }

                            setSelectedOption(document.getElementById(<?php echo '"' . $post_name . '"'; ?>), <?php echo isset($_POST[$post_name]) ? '"' . $_POST[$post_name] . '"' : ""; ?>);
                        </script>
                    </div>

                <?php } else if ($data_type == 'Date') { ?>



                    <?php
                }
            }
            ?>

        <?php } else { ?>
            <h6><em>No Custom Data Available.</em></h6>
        <?php } ?>

    </div>
</div>