<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = PoiSubCategory::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="PoiSubCategory_poi_sub_category_id" class="col-sm-2 control-label"><?php echo $fields['poi_sub_category_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiSubCategory_poi_sub_category_id" placeholder="<?php echo $fields['poi_sub_category_id'];?>" name="PoiSubCategory[poi_sub_category_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="PoiSubCategory_poi_category_id" class="col-sm-2 control-label"><?php echo $fields['poi_category_id'];?></label>
            <div class="col-sm-3">
                <!--<input type="text" class="form-control" id="PoiSubCategory_poi_category_id" placeholder="<?php echo $fields['poi_category_id'];?>" name="PoiSubCategory[poi_category_id]">-->
                <?php echo CHtml::dropDownList('PoiSubCategory_poi_category_name', '', $poi_category, array('prompt' => 'Select Category', 'class' => 'form-control')); ?>
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiSubCategory_sub_category_name" class="col-sm-2 control-label"><?php echo $fields['sub_category_name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiSubCategory_sub_category_name" placeholder="<?php echo $fields['sub_category_name'];?>" name="PoiSubCategory[sub_category_name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiSubCategory_description" class="col-sm-2 control-label"><?php echo $fields['description'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiSubCategory_description" placeholder="<?php echo $fields['description'];?>" name="PoiSubCategory[description]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiSubCategory_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiSubCategory_created_date" placeholder="<?php echo $fields['created_date'];?>" name="PoiSubCategory[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiSubCategory_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiSubCategory_created_by" placeholder="<?php echo $fields['created_by'];?>" name="PoiSubCategory[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiSubCategory_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiSubCategory_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="PoiSubCategory[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="PoiSubCategory_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="PoiSubCategory_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="PoiSubCategory[updated_by]">
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