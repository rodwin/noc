<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = Authitem::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="Authitem_name" class="col-sm-2 control-label"><?php echo $fields['name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Authitem_name" placeholder="<?php echo $fields['name'];?>" name="Authitem[name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Authitem_type" class="col-sm-2 control-label"><?php echo $fields['type'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Authitem_type" placeholder="<?php echo $fields['type'];?>" name="Authitem[type]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Authitem_description" class="col-sm-2 control-label"><?php echo $fields['description'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Authitem_description" placeholder="<?php echo $fields['description'];?>" name="Authitem[description]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Authitem_bizrule" class="col-sm-2 control-label"><?php echo $fields['bizrule'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Authitem_bizrule" placeholder="<?php echo $fields['bizrule'];?>" name="Authitem[bizrule]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Authitem_data" class="col-sm-2 control-label"><?php echo $fields['data'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Authitem_data" placeholder="<?php echo $fields['data'];?>" name="Authitem[data]">
            </div>
        </div>
		<div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" id="btnSearch" class="btn btn-primary btn-flat">Search</button>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>