
<div class="panel-heading"><b>Custom Item Fields</b></div>

<div class="panel-body">
    <?php
    if (count($custom_datas) > 0) {
        ?>

        <div class="form-horizontal">
            <?php
            foreach ($custom_datas as $key => $val) {

                $attr = CJSON::decode($val['attribute']);

                if ($val['data_type'] == 'Text and Numbers') {

                    if ($attr['text_field'] == 1) {
                        ?>

                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?php echo $val['name']; ?><?php echo $val['required'] == 1 ? '<i style="color: red;">*</i>' : ''; ?></label>
                            <div class="col-lg-10">
                                <textarea id="<?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?>" class="form-control" rows="3" id="" maxlength="<?php echo isset($attr['max_character_length']) ? $attr['max_character_length'] : 0; ?>"><?php echo $attr['default_value']; ?></textarea>
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?><?php echo $val['required'] == 1 ? '<i style="color: red;">*</i>' : ''; ?></label>
                            <div class="col-lg-10">
                                <input id="<?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?>" type="text" class="form-control" value="<?php echo $attr['default_value']; ?>" maxlength="<?php echo isset($attr['max_character_length']) ? $attr['max_character_length'] : 0; ?>" />
                            </div>
                        </div>

                        <?php
                    }
                } else if ($val['data_type'] == 'Numbers Only') {
                    ?>

                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo $val['name']; ?><?php echo $val['required'] == 1 ? '<i style="color: red;">*</i>' : ''; ?></label>
                        <div class="col-lg-10">
                            <input id="<?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?>" type="number" class="form-control" onkeypress="return isNumberKey(event)" />
                <!--                        <input type="number" class="form-control" id="<?php ?>" onkeypress="return isNumberKey(event)" onkeyup="this.value = minmax(this.value, <?php echo $attr['minimum_value']; ?>, <?php echo $attr['maximum_value']; ?>)" value="<?php echo $attr['default_value']; ?>" />-->
                        </div>
                    </div>

                <?php } else if ($val['data_type'] == 'CheckBox') { ?>
                    <div class="form-group">
                        <label for="select" class="col-lg-2 control-label"></label>
                        <div class="col-lg-10">
                            <div class="checkbox">
                                <label>
                                    <input id="<?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?>" type="checkbox" <?php echo $attr['default_value'] == 1 ? 'checked' : ''; ?> /><?php echo $val['name']; ?><?php echo $val['required'] == 1 ? '<i style="color: red;">*</i>' : ''; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php } else if ($val['data_type'] == 'Drop Down List') { ?>
                    <div class="form-group">
                        <label for="select" class="col-lg-2 control-label"><?php echo $val['name']; ?><?php echo $val['required'] == 1 ? '<i style="color: red;">*</i>' : ''; ?></label>
                        <div class="col-lg-10">
                            <select id="<?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?>" class="form-control">
                                <?php echo implode("\n", $attr['dropDownList_default']); ?>
                            </select>
                        </div>
                    </div>
                <?php } else if ($val['data_type'] == 'Date') { ?>
                    <div class="form-group">
                        <label for="select" class="col-lg-2 control-label"><?php echo $val['name']; ?><?php echo $val['required'] == 1 ? '<i style="color: red;">*</i>' : ''; ?></label>
                        <div class="col-lg-10">
                            <input id="<?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?>" type="text" class="span2" value="" data-date-format="yy-mm-dd" />
                        </div>
                    </div>

                    <script type="text/javascript">
                                                                                                                        
                        var today = new Date();
                        var str = today.toString("yy-mm-dd");
                                                                                                                        
                        //    $("#dp1").val(str);
                                                                                                                        
                        $("#<?php echo $val['name'] = str_replace(' ', '_', $val['name']); ?>").datepicker();
                    </script>
                    <?php
                }
            }
            ?>
        </div>

        <?php
    } else {
        ?>

        <h6><em>No Custom Data Available.</em></h6>

    <?php } ?>
</div>

