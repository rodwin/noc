<?php
$this->breadcrumbs = array(
    'Images' => array('admin'),
    'Upload',
);
?>

<?php
$this->widget('booster.widgets.TbFileUpload', array(
    'url' => $this->createUrl('images/uploadImage'),
    'model' => $model,
    'attribute' => 'image',
    'multiple' => true,
    'options' => array(
        'maxFileSize' => 2000000,
        'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png)$/i',
    ),
    'formView' => 'application.modules.library.views.images._form',
    'uploadView' => 'application.modules.library.views.images._upload',
    'downloadView' => 'application.modules.library.views.images._download',
    'callbacks' => array(
        'done' => new CJavaScriptExpression(
                'function(e, data) { ajaxLoadImages(); }'
        ),
        'fail' => new CJavaScriptExpression(
                'function(e, data) { console.log("fail"); }'
        ),
)));
?>

<div class="box box-primary box-solid">
    <div class="box-header">

        <div class="col-md-3">
            <div class="input-group navbar-form navbar-left">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <?php
                echo CHtml::textField(
                        'file_name', '', array(
                    'id' => '',
                    'class' => "form-control input-sm",
                    'placeholder' => 'Search',
                    'onkeyup' => CHtml::ajax(
                            array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('library/images/upload'),
                                'data' => 'js:jQuery(this).serialize()',
                                'success' => 'js:function(data){ $("#image_thumbnails").html(data); }'
                            )
                    ),
                ));
                ?>
            </div>
        </div> 

        <div class="col-md-9">
            <div class="pull-right margin">
                <button type="button" id="delete_img"class="btn btn-danger btn-sm btn-flat">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <button type="button" id="checkAll_img" class="btn btn-info btn-sm btn-flat">
                    <i class="glyphicon glyphicon-check"></i>
                    <span>Check All</span>
                </button>
                <button type="button" id="unCheckAll_img" class="btn btn-info btn-sm btn-flat">
                    <i class="glyphicon glyphicon-unchecked"></i>
                    <span>Uncheck All</span>
                </button>
            </div>
        </div>

    </div>

    <div class="box-body">

        <?php echo $this->renderPartial('_images', array('dataProvider' => $dataProvider,)); ?>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        ajaxLoadImages();
    });

    function ajaxStopLoad() {
        $(document).ajaxStop(function() {
            window.location.reload();
        });
    }

    function ajaxLoadImages() {
        $.ajax({
            'url': '<?php echo CController::createUrl('images/ajaxLoadImages') ?>',
            'dataType': 'text',
            'success': function(data) {
                $("#image_thumbnails").html(data);
            },
            error: function(jqXHR, exception) {
            }
        });
    }

    $('#delete_img').click(function() {
        if (!window.confirm("Are you sure you want to delete selected item(s)?"))
            return false;
        $(':checkbox[name="img[]"]:checked').each(function() {
            $.ajax({
                'url': '<?php echo CController::createUrl('images/deleteMultiple') ?>',
                'type': 'POST',
                'data': {img_id: this.value},
                'dataType': 'text',
                'success': function(data) {

                    if (data == "1451") {
                        $.growl("Unable to deleted", {
                            icon: 'glyphicon glyphicon-warning-sign',
                            type: 'danger'
                        });
                    } else {
                        $.growl(data, {
                            icon: 'glyphicon glyphicon-info-sign',
                            type: 'success'
                        });
                    }
                },
                error: function(jqXHR, exception) {
//                        alert('An error occured: ' + exception);
                }
            });

            ajaxLoadImages();
        });

    });

    $('#unCheckAll_img').click(function() {
        $('[id=img_delete_chk]').prop('checked', false);
    });

    $('#checkAll_img').click(function() {
        $("[id=img_delete_chk]").prop('checked', true);
        $(':checkbox[name="img[]"]').each(function() {
        });
    });

    $('#checkAll_uploaded_img').click(function() {
        $("[id=uploaded_check_box]").prop('checked', true);
    });

</script>
