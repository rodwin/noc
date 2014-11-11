
<style type="text/javascript">

    .tree {
        min-height:20px;
        padding:19px;
        margin-bottom:20px;
        background-color:#fbfbfb;
        border:1px solid #999;
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
        -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
    }
    .tree li {
        list-style-type:none;
        margin:0;
        padding:10px 5px 0 5px;
        position:relative
    }
    .tree li::before, .tree li::after {
        content:'';
        left:-20px;
        position:absolute;
        right:auto
    }
    .tree li::before {
        border-left:1px solid #999;
        bottom:50px;
        height:100%;
        top:0;
        width:1px
    }
    .tree li::after {
        border-top:1px solid #999;
        height:20px;
        top:25px;
        width:25px
    }
    .tree li span {
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border:1px solid #999;
        border-radius:5px;
        display:inline-block;
        padding:3px 8px;
        text-decoration:none
    }
    .tree li.parent_li>span {
        cursor:pointer
    }
    .tree>ul>li::before, .tree>ul>li::after {
        border:0
    }
    .tree li:last-child::before {
        height:30px
    }
    .tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
        background:#eee;
        border:1px solid #94a0b4;
        color:#000
    }

</style>

<div class="panel panel-default">
    <div class="panel-body">


        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'authitem-form',
            'enableAjaxValidation' => true,
        ));
        ?>

        <div class="col-md-5">

            <?php /* if($form->errorSummary($model)){?><div class="alert alert-danger alert-dismissable">
              <i class="fa fa-ban"></i>
              <?php echo $form->errorSummary($model); ?></div>
             */ ?>        

            <div class="form-group">
                <?php echo $form->textFieldGroup($model, 'name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'readonly' => !$model->isNewRecord ? true : false)))); ?>
            </div>

            <!--                        <div class="form-group">
            <?php // echo $form->textFieldGroup($model, 'type', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
                                    </div>-->

            <div class="form-group">
                <?php echo $form->textAreaGroup($model, 'description', array('widgetOptions' => array('htmlOptions' => array('rows' => 2, 'cols' => 50, 'class' => 'span8', 'style' => 'resize: none;')))); ?>
            </div>

            <!--            <div class="form-group">
            <?php // echo $form->textAreaGroup($model, 'bizrule', array('widgetOptions' => array('htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'span8')))); ?>
                        </div>-->

            <!--            <div class="form-group">
            <?php // echo $form->textAreaGroup($model, 'data', array('widgetOptions' => array('htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'span8')))); ?>
                        </div>-->
        </div>

        <div class="col-md-12">
            <div class="row-fluid">

                <?php
                $distributor = SalesOffice::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "distributor_id" => ""), array("order" => "sales_office_name ASC"));

                if (count($distributor) > 0) {
                    ?>
                    <h4>Sales Offices</h4>

                    <div class="tree">
                        <ul style="list-style-type: none;">

                            <?php foreach ($distributor as $k1 => $v1) { ?>

                                <li id="distributor_li_<?php echo $k1; ?>">
                                    <input type="checkbox" id="so_parent_node[]" class="so_parent_<?php echo $k1; ?>" value="<?php echo $k1; ?>">&nbsp;
                                    <span class="label label-primary" data-toggle="tooltip" style="cursor: pointer;"><i class="fa fa-fw fa-plus-square"></i>
                                        <?php echo $v1->sales_office_name; ?>
                                    </span>

                                    <ul id="distributor_ul_<?php echo $k1; ?>" style="max-height: 300px; overflow:auto; list-style-type: none;">

                                        <?php
                                        $sales_offices = SalesOffice::model()->findAllByAttributes(array("company_id" => Yii::app()->user->company_id, "distributor_id" => $v1->sales_office_id), array("order" => "sales_office_name ASC"));

                                        foreach ($sales_offices as $v) {
                                            ?>

                                            <script type="text/javascript">
                                                $(function() {
                                                    var selected_so_id = <?php echo isset($selected_so[$v->sales_office_id]) ? "'" . $v->sales_office_id . "'" : "''"; ?>

                                                    if (selected_so_id != "") {
                                                        getSalesofficeDetailsByID(selected_so_id);
                                                    }
                                                });
                                            </script>

                                            <li>
                                                <?php echo CHtml::checkBox('so[' . $v->sales_office_id . ']', isset($selected_so[$v->sales_office_id]) ? true : false, array('class' => 'so_child_' . $k1, 'id' => 'so_child_list[]', 'data-id' => $v->sales_office_id, 'data-key' => $k1)); ?>&nbsp;
                                                <span><?php echo $v->sales_office_name; ?></span>
                                                <span class="text-muted">(<?php echo $v->sales_office_code; ?>)</span>
                                            </li>

                                        <?php } ?>

                                        <script type="text/javascript">
                                            $(function() {

                                                var selected_so_id = <?php echo isset($selected_so[$v1->sales_office_id]) ? "'" . $v1->sales_office_id . "'" : "''"; ?>

                                                if (selected_so_id != "") {
                                                    getSalesofficeDetailsByID(selected_so_id);
                                                }

                                                $('#distributor_ul_' +<?php echo $k1; ?>).prepend('<li><input type="checkbox" name="so[<?php echo $v1->sales_office_id; ?>]" class="so_child_<?php echo $k1 ?>" id="so_child_list[]" data-id="<?php echo $v1->sales_office_id; ?>" data-key="<?php echo $k1 ?>" <?php echo isset($selected_so[$v1->sales_office_id]) ? 'checked' : ''; ?> />&nbsp;&nbsp;<span><?php echo $v1->sales_office_name; ?></span><span class="text-muted">&nbsp;(<?php echo $v1->sales_office_code; ?>)</span></li>');

                                            });
                                        </script>

                                    </ul>
                                </li>


                            <?php } ?>

                        </ul>
                    </div>

                    <?php
                }
                ?>

                <div class="well well-sm" style="">
                    <label>Zones <span id="ajax_zone_load"></span></label>

                    <div id="zone_tree" class="tree" style="max-height: 300px; overflow: scroll;">
                        <span id="empty_selected_so" style="margin-left: 30px;"><i>No selected sales office</i></span>
                        <ul id="selected_so" style="list-style-type: none;"></ul>
                    </div>
                </div>

                <div class="clearfix"><br/></div>

                <?php if (count($operations) > 0) { ?>
                    <h4>Operations</h4>

                    <div class="col-md-12">
                        <?php
                        $ctr = "";

                        foreach ($operations as $k2 => $v2) {
                            ?>

                            <?php if ($ctr != $v2->description) {
                                ?>

                                <b><?php echo strtoupper($v2->description); ?></b>
                                <input type="checkbox" name="operation_title[]" value="<?php echo str_replace(" ", "_", strtoupper($v2->description)); ?>"/>
                                <br/>

                                <?php
                            }

                            $ctr = $v2->description;

                            if ($ctr == $v2->description) {
                                ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php } ?>

                            <span style="<?php // echo $v2->description == "Dashboard" ? "display: none" : "";          ?>">
                                <input type="checkbox" name="operations[]" <?php echo isset($childs[$v2->name]) ? 'checked' : '' ?> value="<?php echo $v2->name; ?>" id="op_list" class="<?php echo "operation_list_" . str_replace(" ", "_", strtoupper($v2->description)); ?>"/>&nbsp;
                                <?php echo $v2->name; ?>
                            </span><br/>

                        <?php } ?>
                    </div>
                <?php } ?>

            </div>

            <div class="form-group col-md-12">
                <div class="clearfix"><br/></div>
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-flat')); ?>&nbsp;
                <?php echo CHtml::resetButton('Reset', array('class' => 'btn btn-primary btn-flat')); ?>
            </div>


            <?php $this->endWidget(); ?>

        </div>
    </div>
</div>


<script type="text/javascript">

    $(function() {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('data-original-title', 'Expand');
        $('.tree li > ul > li').hide('fast');

        $('.tree li.parent_li > span').on('click', function(e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');

            if (children.is(":visible")) {

                children.hide('fast');
                $(this).attr('data-original-title', 'Expand').find(' > i').removeClass('fa-minus-square').addClass('fa-plus-square');
            } else {

                children.show('fast');
                $(this).attr('data-original-title', 'Collapse').find(' > i').removeClass('fa-plus-square').addClass('fa-minus-square');
            }
            e.stopPropagation();
        });

    });

    var zones = new Array();
    var update = false;
    $(function() {

<?php
if (!$model->isNewRecord) {
    if ($selected_zone != "") {
        foreach ($selected_zone as $k => $v) {
            ?>
                    zones['<?php echo $k; ?>'] = 1;
                    update = true;
            <?php
        }
    }
}
?>

//        var so_parent_checked = false;

        $('input[type="checkbox"][id="so_parent_node[]"]').on('ifChecked', function(event) {
            $("input.so_child_" + this.value).iCheck('check');
        });

        $('input[type="checkbox"][id="so_parent_node[]"]').on('ifUnchecked', function(event) {
//            if (so_parent_checked === false) {
            $("input.so_child_" + this.value).iCheck('uncheck');
//            }
        });

        $('input[type="checkbox"][name="operation_title[]"]').on('ifChecked', function(event) {
            $("input.operation_list_" + this.value).iCheck('check');
        });

        $('input[type="checkbox"][name="operation_title[]"]').on('ifUnchecked', function(event) {
            $("input.operation_list_" + this.value).iCheck('uncheck');
        });

        $('input[type="checkbox"][id="so_child_list[]"]').on('ifChecked', function(event) {
            var sales_office_id = $(this).attr("data-id");
            var so_parent_key = $(this).attr("data-key");

            $('input[type="checkbox"][id="so_parent_node[]"], input[type="checkbox"][id="so_child_list[]"]').iCheck('disable');

            var parent = $(this).closest("#distributor_ul_" + so_parent_key);
            var status = parent.find("input.so_child_" + so_parent_key).not(':checked').length === 0;

//            if (status === true) {
//                $(".so_parent_" + so_parent_key).iCheck('check');
//            }

            getSalesofficeDetailsByID(sales_office_id);

        });

        $('input[type="checkbox"][id="so_child_list[]"]').on('ifUnchecked', function(event) {
            var sales_office_id = $(this).attr("data-id");
            $('#sales_office_' + sales_office_id).remove();
            var so_parent_key = $(this).attr("data-key");

            var parent = $(this).closest("#distributor_ul_" + so_parent_key);
            var status = parent.find("input.so_child_" + so_parent_key).not(':checked').length !== 0;

//            if (status === true) {
//                so_parent_checked = true;
//                $(".so_parent_" + so_parent_key).iCheck('uncheck');
//            }

            update = false;
            if ($('#zone_tree ul li').length == 0) {
                $("#empty_selected_so").show();
            }
        });


    });

    var ajaxQueue = $({});
    (function($) {
        $.ajaxQueue = function(ajaxOpts) {

            var oldComplete = ajaxOpts.complete;

            ajaxQueue.queue(function(next) {

                ajaxOpts.complete = function() {
                    if (ajaxQueue.queue().length == 1) {
                        $("#ajax_zone_load").html("");
                        $('input[type="checkbox"][id="so_parent_node[]"], input[type="checkbox"][id="so_child_list[]"]').iCheck('enable');
                    }

                    if (oldComplete)
                        oldComplete.apply(this, arguments);

                    next();
                };

                $.ajax(ajaxOpts);
            });
        };

    })(jQuery);

    function getSalesofficeDetailsByID(sales_office_id) {

        $("#ajax_zone_load").html("<img src=\"<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader.gif\" />");

        $.ajaxQueue({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/library/salesOffice/getSODetailsByID'); ?>' + '&sales_office_id=' + sales_office_id,
            dataType: "json",
            success: function(data) {

                var so_id = data.so_detail.sales_office_id;
                var so_code = data.so_detail.sales_office_code;
                var so_name = data.so_detail.sales_office_name;

                $("#empty_selected_so").hide();

                $('#selected_so').append('<li id="sales_office_' + so_id + '" class="parent_li"><input type="checkbox" id="zone_parent_node_' + so_code + '" data-id="' + so_code + '">&nbsp;<i class="fa fa-fw fa-plus-square"></i><span style="cursor: pointer;" title="Expand">' + so_name + '</span></li>');
                $('#sales_office_' + so_id).append('<ul id="ul_zones' + so_code + '"></ul>');

                $.each(data.zones, function(i, v) {

                    var checked = "";
                    if (typeof zones[v.zone_id] != 'undefined' && update === true) {
                        checked = "checked";
                    }

                    $('#ul_zones' + v.sales_office_code).append('<li id="ul_zones" style="list-style-type: none;"><input type="checkbox" name="zone[' + v.zone_id + ']" value="1" class="zone_child_' + v.sales_office_code + '" ' + checked + ' >&nbsp;' + v.zone_name + '</li>');

                    $('#zone_parent_node_' + v.sales_office_code).change(function() {
                        var sales_office_code = $(this).attr("data-id");

                        if (this.checked) {
                            $("input.zone_child_" + sales_office_code).iCheck('check');
                        } else {
                            $("input.zone_child_" + sales_office_code).iCheck('uncheck');
                        }
                    });
                });

                $('#ul_zones' + so_code).hide();

                $('#sales_office_' + so_id + ' span').click(function() {
                    var el = $('#sales_office_' + so_id).find('ul');
                    var span = $(this);

                    el.slideToggle('fast', function() {
                        if (el.is(':hidden')) {
                            span.attr('title', 'Expand').prev('i').removeClass('fa-minus-square').addClass('fa-plus-square');
                        }
                        else {
                            span.attr('title', 'Collapse').prev('i').removeClass('fa-plus-square').addClass('fa-minus-square');
                        }
                    });
                });

            },
            error: function(status, exception) {
                alert("Error occured: Please try again.");
            }
        });

    }

</script>