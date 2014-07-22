
<div class="panel panel-default">
    <div class="panel-body">

        <div class="control-label text-primary"><h4><b>Custom Item Fields</b></h4></div>

        <?php if (count($custom_datas) > 0) { ?>

            <?php
            foreach ($custom_datas as $key => $val) {

                $attr = CJSON::decode($val['attribute']);
                $label_name = $val['name'];
                $post_name = $val['name'] = str_replace(' ', '_', strtolower($val['name']));

                if ($val['data_type'] == 'Text and Numbers') {

                    if ($attr['text_field'] == 1) {
                        ?>

                        <div class="form-group">
                            <label><?php echo $label_name; ?></label>
                            <textarea id="<?php echo $post_name; ?>" name="<?php echo $post_name; ?>" class="form-control input-sm" rows="3" maxlength="<?php echo isset($attr['max_character_length']) ? $attr['max_character_length'] : 0; ?>" style="resize: none;"><?php
                                echo isset($_POST[$post_name]) ? $_POST[$post_name] : $attr['default_value'];
                                ?></textarea>
                        </div>

                    <?php } else { ?>

                        <div class="form-group">
                            <label><?php echo $label_name; ?></label>                            
                            <input id="<?php echo $post_name; ?>" name="<?php echo $post_name; ?>" type="text" class="form-control input-sm" maxlength="<?php echo isset($attr['max_character_length']) ? $attr['max_character_length'] : 0; ?>" value="<?php echo isset($_POST[$post_name]) ? $_POST[$post_name] : $attr['default_value']; ?>"/>
                        </div>

                    <?php } ?>

                <?php } else if ($val['data_type'] == 'Numbers Only') { ?>

                    <div class="form-group">
                        <label><?php echo $label_name; ?></label>
                        <input id="<?php echo $post_name; ?>" name="<?php echo $post_name; ?>" type="number" class="form-control input-sm" value="<?php echo isset($_POST[$post_name]) ? $_POST[$post_name] : $attr['default_value']; ?>" onkeypress="return isNumberKey(event)"/>
                    </div>

                <?php } else if ($val['data_type'] == 'CheckBox') { ?>

                    <div class="form-group">
                        <label>
                            <input id="<?php echo $post_name; ?>" name="<?php echo $post_name; ?>" type="checkbox" class="minimal" <?php echo isset($_POST[$post_name]) ? "checked" : ""; ?>/>
                            <?php echo $label_name; ?>
                        </label>
                    </div>

                <?php } else if ($val['data_type'] == 'Drop Down List') { ?>

                    <div class="form-group">
                        <script type="text/javascript">
                            
                        </script>
                        <label><?php echo $label_name; ?></label>
                        <select id="<?php echo $post_name; ?>" name="<?php echo $post_name; ?>" class="form-control">
                            <?php echo implode("\n", $attr['dropDownList_default']); ?>
                        </select>
                    </div>

                <?php } else if ($val['data_type'] == 'Date') { ?>



                    <?php
                }
            }
            ?>

        <?php } else { ?>
            <h6><em>No Custom Data Available.</em></h6>
        <?php } ?>

    </div>
</div>