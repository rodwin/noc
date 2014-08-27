
<style type="text/css">
    .form-group { width: 80%; }

    .modal-header h4 { font-weight: bolder; padding-left: 10px; }
    
    .typeahead {
        background-color: #fff;
        width: 100%;
    }
    .tt-dropdown-menu {
        width: 400px;
        margin-top: 5px;
        padding: 8px 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }
    .tt-suggestion {
        padding: 8px 20px 8px 20px;
        font-size: 14px;
        line-height: 18px;
    }

    .tt-suggestion + .tt-suggestion {
        font-size: 14px;
        border-top: 1px solid #ccc;
    }

    .tt-suggestions .repo-language {
        float: right;
        font-style: italic;
    }

    .tt-suggestions .repo-name {
        font-size: 14px;
        font-weight: bold;
    }

    .tt-suggestions .repo-description {
        margin: 0;
    }

    .twitter-typeahead .tt-suggestion.tt-cursor {
        color: #03739c;
        cursor: pointer;
    }

    #scrollable-dropdown-menu .tt-dropdown-menu {
        max-height: 150px;
        overflow-y: auto;
    }
</style>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-move clearfix no-padding small-box">
            <h4 class="modal-title pull-left margin">Move</h4>
            <button class="btn btn-sm btn-flat bg-move pull-right margin" data-dismiss="modal"><i class="fa fa-times"></i></button>
        </div>  

        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'move-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array(
                'onsubmit' => "return false;", /* Disable normal form submit */
                'onkeypress' => " if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
            ),
        ));
        ?>

        <div class="modal-body">

            <div class="well well-sm">
                <?php echo CHtml::hiddenField("MoveInventoryForm[inventory_id]", $inventoryObj->inventory_id); ?>
                <dt class="text-move">For this record</dt>

                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo Inventory::model()->getAttributeLabel('qty'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('uom.uom_name'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('sku.sku_name'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('zone.zone_name'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('reference_no'); ?></th>
                            <th><?php echo Inventory::model()->getAttributeLabel('expiration_date'); ?></th>
                            <th><?php echo "Status"; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $inventoryObj->qty; ?></td>
                            <td><?php echo $inventoryObj->uom->uom_name; ?></td>
                            <td><?php echo $inventoryObj->sku->sku_name; ?></td>
                            <td><?php echo $inventoryObj->zone->zone_name; ?></td>
                            <td><?php echo $inventoryObj->reference_no; ?></td>
                            <td><?php echo $inventoryObj->expiration_date; ?></td>
                            <td><?php echo isset($inventoryObj->skuStatus->status_name) ? $inventoryObj->skuStatus->status_name : ""; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="MoveInventoryForm_summaryError" class="alert alert-danger alert-dismissable no-margin" style="display: none; margin-bottom: 10px!important;">
                <b></b>
            </div>

            <div class="form-group">
                <script type="text/javascript">
                    $("#MoveInventoryForm_qty").val(<?php echo $qty; ?>);
                </script>

                <?php
                echo $form->labelEx($model, 'qty', array('class' => 'text-move'));
                echo $form->textFieldGroup(
                        $model, 'qty', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5', 'id' => 'MoveInventoryForm_qty'
                    ),
                    'labelOptions' => array('label' => false),
                    'append' => $inventoryObj->uom->uom_name
                ));
                ?>
            </div>

            <div class="form-group">

                <dt class="text-move">...to the location:</dt>
                <?php echo CHtml::textField('zone_name', '', array('id' => 'MoveInventoryForm_zone_name', 'class' => 'typeahead form-control', 'placeholder' => "Zone")); ?>

                <?php
                echo $form->textFieldGroup($model, 'zone_id', array('widgetOptions' => array('htmlOptions' => array('id' => 'MoveInventoryForm_zone_id', 'style' => 'display: none;')),
                    'labelOptions' => array('label' => false)));
                ?> 
            </div>

            <div class="form-group">
                <?php
                echo $form->labelEx($model, 'status_id', array('class' => 'text-move'));
                echo $form->dropDownListGroup(
                        $model, 'status_id', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5',
                    ),
                    'widgetOptions' => array(
                        'data' => $status,
                        'htmlOptions' => array('multiple' => false, 'prompt' => 'Select Status'),
                    ),
                    'labelOptions' => array('label' => false),
                ));
                ?>
            </div>

            <dt class="text-move">With these transaction details...</dt>

            <div class="form-group">
                <?php echo $form->textFieldGroup($model, 'transaction_date', array('widgetOptions' => array('htmlOptions' => array('class' => '')))); ?> 
            </div>

        </div>

        <div class="modal-footer clearfix" style="padding-top: 10px; padding-bottom: 10px;">

            <div class="pull-left"> 
                <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-check"></i> Save', array('name' => 'save', 'class' => 'btn btn-primary', 'id' => 'btn_move')); ?>
                <?php echo CHtml::htmlButton('<i class="fa fa-fw fa-mail-reply"></i> Reset', array('class' => 'btn btn-primary', 'id' => 'btn_move_form_reset')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>

<script type="text/javascript">

    function send() {

        var data = $("#move-form").serialize();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/inventory/Inventory/move'); ?>',
            data: data,
            dataType: "json",
            success: function(data) {

                if (data.success === true) {
                    $("#MoveInventoryForm_summaryError").hide();
                    $('#myModal').modal('hide');
                    $.growl(data.message, {
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'success'
                    });
                    table.fnMultiFilter();
                } else if (data.success === false) {
                    $("#MoveInventoryForm_summaryError").hide();
                    alert(data.message);
                }

                if (data.error.length > 0) {
                    $("#MoveInventoryForm_summaryError b").html(data.error);
                    $('#MoveInventoryForm_summaryError').show().delay(3000).fadeOut('slow');
                }

            },
            error: function(data) { // if error occured
                alert("Error occured: Please try again");
            },
        });

    }

    $('#btn_move').click(function() {
        send();
    });

    $('#btn_move_form_reset').click(function() {
        document.forms["move-form"].reset();
    });

    var zone = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('zone'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?php echo Yii::app()->createUrl("library/zone/search", array('value' => '')) ?>',
        remote: '<?php echo Yii::app()->createUrl("library/zone/search") ?>&value=%QUERY'
    });

    zone.initialize();

    $('#MoveInventoryForm_zone_name').typeahead(null, {
        name: 'zones',
        displayKey: 'zone_name',
        source: zone.ttAdapter(),
        templates: {
            suggestion: Handlebars.compile([
                '<p class="repo-language">{{sales_office}}</p>',
                '<p class="repo-name">{{zone_name}}</p>'
            ].join(''))
        }

    }).on('typeahead:selected', function(obj, datum) {

        $("#MoveInventoryForm_zone_id").val(datum.zone_id);

    });

    jQuery('#MoveInventoryForm_zone_name').on('input', function() {
        var value = $("#MoveInventoryForm_zone_name").val();
        $("#MoveInventoryForm_zone_id").val(value);
    });

</script>