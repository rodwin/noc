
<?php echo CHtml::beginForm($this->url, 'post', $this->htmlOptions); ?>

<div class="fileupload-buttonbar">
   <div class="span7">
      <!-- The fileinput-button span is used to style the file input field as button -->
      <span class="btn btn-success fileinput-button btn-sm btn-flat" style="display: none;">
         <i class="glyphicon glyphicon-plus"></i>
         <span>Add files...</span>
         <?php
         if ($this->hasModel()) :

            echo CHtml::activeFileField($this->model, $this->attribute, array("id" => "return_mdse_file_uploads", "multiple" => true)) . "\n";
         else :
            echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
         endif;
         ?>
      </span>

      <button type="submit" class="btn btn-primary btn-sm btn-flat start" id="return_mdse_uploading_attachments" style="display: none;">
         <i class="icon-upload icon-white"></i>
         <i class="glyphicon glyphicon-upload"></i>
         <span>Start upload</span>
      </button>

      <button type="reset" class="btn btn-warning btn-sm btn-flat cancel" style="display: none;">
         <i class="glyphicon glyphicon-ban-circle"></i>
         <span>Cancel upload</span>
      </button>

      <button type="button" class="btn btn-danger btn-sm btn-flat delete" style="display: none;">
         <i class="glyphicon glyphicon-trash"></i>
         <span>Delete</span>
      </button>
      <!--<input type="checkbox" class="toggle">-->
      <button type="button" id="checkAll_uploaded_img" class="btn btn-info btn-sm btn-flat" style="display: none;">
         <i class="glyphicon glyphicon-check"></i>
      </button>

   </div>
</div>

<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>

<!-- The table listing the files available for upload/download -->
<div class="row-fluid">
   <table class="table table-striped" id="return_mdse_attached_table">
      <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
   </table>
</div>

<?php echo CHtml::endForm(); ?>

