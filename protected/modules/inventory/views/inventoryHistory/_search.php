<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php $fields = InventoryHistory::model()->attributeLabels(); ?>	                
        <div class="form-group">
            <label for="InventoryHistory_inventory_history_id" class="col-sm-2 control-label"><?php echo $fields['inventory_history_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_inventory_history_id" placeholder="<?php echo $fields['inventory_history_id'];?>" name="InventoryHistory[inventory_history_id]">
            </div>
        </div>
		                
        <div class="form-group">
            <label for="InventoryHistory_inventory_id" class="col-sm-2 control-label"><?php echo $fields['inventory_id'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_inventory_id" placeholder="<?php echo $fields['inventory_id'];?>" name="InventoryHistory[inventory_id]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_quantity_change" class="col-sm-2 control-label"><?php echo $fields['quantity_change'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_quantity_change" placeholder="<?php echo $fields['quantity_change'];?>" name="InventoryHistory[quantity_change]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_running_total" class="col-sm-2 control-label"><?php echo $fields['running_total'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_running_total" placeholder="<?php echo $fields['running_total'];?>" name="InventoryHistory[running_total]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_action" class="col-sm-2 control-label"><?php echo $fields['action'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_action" placeholder="<?php echo $fields['action'];?>" name="InventoryHistory[action]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_cost_unit" class="col-sm-2 control-label"><?php echo $fields['cost_unit'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_cost_unit" placeholder="<?php echo $fields['cost_unit'];?>" name="InventoryHistory[cost_unit]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_ave_cost_per_unit" class="col-sm-2 control-label"><?php echo $fields['ave_cost_per_unit'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_ave_cost_per_unit" placeholder="<?php echo $fields['ave_cost_per_unit'];?>" name="InventoryHistory[ave_cost_per_unit]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_created_date" placeholder="<?php echo $fields['created_date'];?>" name="InventoryHistory[created_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_created_by" placeholder="<?php echo $fields['created_by'];?>" name="InventoryHistory[created_by]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_updated_date" placeholder="<?php echo $fields['updated_date'];?>" name="InventoryHistory[updated_date]">
            </div>
        </div>
	                
        <div class="form-group">
            <label for="InventoryHistory_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by'];?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="InventoryHistory_updated_by" placeholder="<?php echo $fields['updated_by'];?>" name="InventoryHistory[updated_by]">
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