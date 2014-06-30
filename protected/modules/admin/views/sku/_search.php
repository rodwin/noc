<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = Sku::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="Sku_code" class="col-sm-2 control-label"><?php echo $fields['code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_code" placeholder="<?php echo $fields['code'];?>" name="Sku[code]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="Sku_brand_code" class="col-sm-2 control-label"><?php echo $fields['brand_code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_brand_code" placeholder="<?php echo $fields['brand_code'];?>" name="Sku[brand_code]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_name" class="col-sm-2 control-label"><?php echo $fields['name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_name" placeholder="<?php echo $fields['name'];?>" name="Sku[name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_description" class="col-sm-2 control-label"><?php echo $fields['description'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_description" placeholder="<?php echo $fields['description'];?>" name="Sku[description]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_uom" class="col-sm-2 control-label"><?php echo $fields['uom'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_uom" placeholder="<?php echo $fields['uom'];?>" name="Sku[uom]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_unit_price" class="col-sm-2 control-label"><?php echo $fields['unit_price'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_unit_price" placeholder="<?php echo $fields['unit_price'];?>" name="Sku[unit_price]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_type" class="col-sm-2 control-label"><?php echo $fields['type'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_type" placeholder="<?php echo $fields['type'];?>" name="Sku[type]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_created_date" placeholder="<?php echo $fields['created_date'];?>" name="Sku[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_created_by" placeholder="<?php echo $fields['created_by'];?>" name="Sku[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="Sku[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="Sku[updated_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_deleted_date" class="col-sm-2 control-label"><?php echo $fields['deleted_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_deleted_date" placeholder="<?php echo $fields['deleted_date'];?>" name="Sku[deleted_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_deleted_by" class="col-sm-2 control-label"><?php echo $fields['deleted_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_deleted_by" placeholder="<?php echo $fields['deleted_by'];?>" name="Sku[deleted_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Sku_deleted" class="col-sm-2 control-label"><?php echo $fields['deleted'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Sku_deleted" placeholder="<?php echo $fields['deleted'];?>" name="Sku[deleted]">
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