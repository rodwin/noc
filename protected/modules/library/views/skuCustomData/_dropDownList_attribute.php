
<div><?php echo $form->label($model, 'Drop Down List', array('class' => 'control-label text-primary', 'style' => 'font-weight: bold;')); ?></div>


<div style="width: 400px; margin-bottom: 20px;">

    <label class="control-label">Available Values</label>
    <div class="input-group">
        <span class="input-group-addon">+</span>
        <input id="add_dropdown_value" type="text" class="form-control" placeholder="" />
        <span class="input-group-btn">
            <button class="btn btn-primary" type="button" onclick="addDropdownValue(document.getElementById('add_dropdown_value').value)" style="width: 100px;">Add</button>
        </span>
    </div>

</div>

<div style="width: 400px; margin-bottom: 20px;">
    <div style="float: left;">
        <?php //echo CHtml::dropDownList('dropDownList_multiple', $unserialize_attribute['dropDownList_multiple'], array(), array('name' => 'dropDownList_multiple[]', 'multiple' => 'multiple','style' => 'width: 280px; height: 200px;')); ?>
        <select id="dropDownList_multiple" name="dropDownList_multiple[]" multiple="multiple" onchange="showOptions(this)" style="width: 280px; height: 200px;">
            <?php echo implode("\n", $unserialize_attribute['dropDownList_multiple']); ?>
        </select>
    </div>

    <div style="float: right;">
        <button id="option_move_up" onclick="optionMoveUp()" type="button" class="btn btn-default btn-sm" style="float: right; width: 100px; margin-bottom: 10px; text-align: left;">Move Up</button><br/>
        <button id="option_move_down" onclick="optionMoveDown()" type="button" class="btn btn-default btn-sm" style="float: right; width: 100px; margin-bottom: 10px; text-align: left;">Move Down</button><br/>
        <button id="option_remove" onclick="optionRemove()" type="button" class="btn btn-default btn-sm" style="float: right; width: 100px; margin-bottom: 10px; text-align: left;">Delete</button>
    </div>
</div>

<div class="clearfix"></div>

<div>
    <?php echo $form->label($model, 'Drop Down List Default Value', array('class' => 'control-label')); ?><br/>
    <?php //echo CHtml::dropDownList('dropDownList_default[]', $unserialize_attribute['default_value'], array(implode("\n", $unserialize_attribute['dropDownList_multiple'])), array('name' => 'dropDownList_default[]','style' => 'width: 280px; padding: 5px;')); ?>
    <select class="form-control" id="dropDownList_default" name="dropDownList_default[]" style="width: 280px; padding: 5px;">
        <?php echo implode("\n", $unserialize_attribute['dropDownList_default']); ?>
    </select>
</div>

<script type="text/javascript">
    var dropDownList_multiple_idSelected;

    function showOptions(dropDownList_multiple) {
        dropDownList_multiple_idSelected = dropDownList_multiple[dropDownList_multiple.selectedIndex].id;
    }

    var ctr = 0;

    function addDropdownValue(value) {

        if (value == '') {
            return false;
        }

        var dropdown_value = document.getElementById("dropDownList_multiple");
        var dropdown_default = document.getElementById("dropDownList_default");

        var multiDropdown_options = new Option(value);
        multiDropdown_options.setAttribute("id", ctr);
        multiDropdown_options.value = value;
        multiDropdown_options.innerText = value;
        dropdown_value.options[dropdown_value.options.length] = multiDropdown_options;

        var defaultDropdown_options = new Option(value);
        defaultDropdown_options.setAttribute("id", ctr);
        defaultDropdown_options.value = value;
        defaultDropdown_options.innerText = value;
        dropdown_default.options[dropdown_default.options.length] = defaultDropdown_options;

        ctr++;

        document.getElementById("add_dropdown_value").value = '';
    }

    //move dropdown list item up
    function optionMoveUp(){
        var optionID;
        $('#dropDownList_multiple option:selected:first-child').prop("selected", false);
        var before = $('#dropDownList_multiple option:selected:first').prev();
        $('#dropDownList_multiple option:selected').detach().insertBefore(before);

        var e = document.getElementById("dropDownList_multiple");
        optionID = e.options[e.selectedIndex].id;
        $('#dropDownList_default option[id="' + optionID + '"]').attr("selected", "selected");

        $('#dropDownList_default option:selected:first-child').prop("selected", false);
        var before = $('#dropDownList_default option:selected:first').prev();
        $('#dropDownList_default option:selected').detach().insertBefore(before);
        $('#dropDownList_default option[id="' + optionID + '"]').attr("selected", false);
    }

    //move dropdown list item down
    function optionMoveDown() {
        var optionID;
        $('#dropDownList_multiple option:selected:last-child').prop("selected", false);
        var after = $('#dropDownList_multiple option:selected:last').next();
        $('#dropDownList_multiple option:selected').detach().insertAfter(after);

        var e = document.getElementById("dropDownList_multiple");
        optionID = e.options[e.selectedIndex].id;
        $('#dropDownList_default option[id="' + optionID + '"]').attr("selected", "selected");

        $('#dropDownList_default option:selected:last-child').prop("selected", false);
        var after = $('#dropDownList_default option:selected:last').next();
        $('#dropDownList_default option:selected').detach().insertAfter(after);
        $('#dropDownList_default option[id="' + optionID + '"]').attr("selected", false);
    }

    //remove dropdown list item
    function optionRemove() {
        var optionID;
        $('#dropDownList_multiple option:selected').each(function() {
            var e = document.getElementById("dropDownList_multiple");
            optionID = e.options[e.selectedIndex].id;
            $(this).remove();

            $("#dropDownList_default option[id='" + optionID + "']").remove();
        });
    }

</script>



