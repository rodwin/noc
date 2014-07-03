<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = Distributor::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="Distributor_distributor_id" class="col-sm-2 control-label"><?php echo $fields['distributor_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Distributor_distributor_id" placeholder="<?php echo $fields['distributor_id'];?>" name="Distributor[distributor_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="Distributor_distributor_code" class="col-sm-2 control-label"><?php echo $fields['distributor_code'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Distributor_distributor_code" placeholder="<?php echo $fields['distributor_code'];?>" name="Distributor[distributor_code]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Distributor_distributor_name" class="col-sm-2 control-label"><?php echo $fields['distributor_name'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Distributor_distributor_name" placeholder="<?php echo $fields['distributor_name'];?>" name="Distributor[distributor_name]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Distributor_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Distributor_created_date" placeholder="<?php echo $fields['created_date'];?>" name="Distributor[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Distributor_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Distributor_created_by" placeholder="<?php echo $fields['created_by'];?>" name="Distributor[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Distributor_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Distributor_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="Distributor[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="Distributor_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="Distributor_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="Distributor[updated_by]">
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