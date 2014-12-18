<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    
    <tr class="template-upload fade">
    <td class="preview"><span class="fade"></span></td>
    <td class="name"><span>{%=file.name%}</span></td>
    <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
    {% if (file.error) {  %}
    <td class="error" colspan="2"><span class="label label-danger">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
    {% } else if (o.files.valid && !i) { files.push(file); ctr = files.length ; %}
    <td>
    <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
    </td>
    
     <td>
        <input id="saved_incoming_inventory_id" type="hidden" name="saved_incoming_inventory_id" class="tagValues" />          
        <select class="form-control tagValues" name="inventorytype" id="inventory_type" onchange="selectchange(this);">
            <option>PO No.</option>
            <option>DR No.</option>
            <option>RRA No.</option>
            <option>OTHERS</option>
        </select>
      </td>
      
      <td>
         <input class="form-control tagValues" placeholder="Tag to" type="text" id="txttag" name="tagname" disabled="true" />
      </td>
    
    <td class="start">{% if (!o.options.autoUpload) { %}
    <button class="btn btn-primary btn-sm btn-flat" style="display: none;">
    <i class="glyphicon glyphicon-upload"></i>
    <span>{%=locale.fileupload.start%}</span>
    </button>
    {% } %}</td>
    {% } else { %}
    <td colspan="2"></td>
    {% } %}
    <td class="cancel">{% if (!i) { %}
    <button class="btn btn-warning btn-sm btn-flat" onclick="removebyID('{%=ctr%}');">  <!--onclick="alert('{%=ctr - 1%}');"> -->
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>{%=locale.fileupload.cancel%}</span>
    </button>
    {% } %}</td>
    </tr>
    
    {% } %}
    
    
</script>
