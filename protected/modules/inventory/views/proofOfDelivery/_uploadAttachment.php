
<style type="text/css">
    .modal-header h4 { font-weight: bolder; padding-left: 10px; }
</style>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-green clearfix no-padding small-box">
            <h4 class="modal-title pull-left margin">Upload</h4>
            <button class="btn btn-sm btn-flat bg-green pull-right margin" data-dismiss="modal"><i class="fa fa-times"></i></button>
        </div>

        <div class="modal-body">

            <?php
            $this->widget('booster.widgets.TbFileUpload', array(
                'url' => $this->createUrl(''),
                'model' => $model,
                'attribute' => 'file_name',
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
                            'function(e, data) {  }'
                    ),
                    'fail' => new CJavaScriptExpression(
                            'function(e, data) {  }'
                    ),
            )));
            ?>

        </div>

        <div class="modal-footer clearfix" style="">

        </div>

    </div>
</div>
