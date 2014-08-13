<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = Inventory::model()->attributeLabels(); ?>	                
                    <!--                    <div class="form-group">
                                            <label for="Inventory_inventory_id" class="col-sm-2 control-label"><?php echo $fields['inventory_id']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Inventory_inventory_id" placeholder="<?php echo $fields['inventory_id']; ?>" name="Inventory[inventory_id]">
                                            </div>
                                        </div>-->

                    <div class="form-group">
                        <label for="Inventory_sku_id" class="col-sm-2 control-label"><?php echo $fields['sku_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_sku_id" placeholder="<?php echo $fields['sku_id']; ?>" name="Inventory[sku_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_qty" class="col-sm-2 control-label"><?php echo $fields['qty']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_qty" placeholder="<?php echo $fields['qty']; ?>" name="Inventory[qty]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_uom_id" class="col-sm-2 control-label"><?php echo $fields['uom_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_uom_id" placeholder="<?php echo $fields['uom_id']; ?>" name="Inventory[uom_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_zone_id" class="col-sm-2 control-label"><?php echo $fields['zone_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_zone_id" placeholder="<?php echo $fields['zone_id']; ?>" name="Inventory[zone_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_sku_status_id" class="col-sm-2 control-label"><?php echo $fields['sku_status_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_sku_status_id" placeholder="<?php echo $fields['sku_status_id']; ?>" name="Inventory[sku_status_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Inventory[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Inventory[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Inventory[updated_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Inventory[updated_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_expiration_date" class="col-sm-2 control-label"><?php echo $fields['expiration_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_expiration_date" placeholder="<?php echo $fields['expiration_date']; ?>" name="Inventory[expiration_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Inventory_reference_no" class="col-sm-2 control-label"><?php echo $fields['reference_no']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Inventory_reference_no" placeholder="<?php echo $fields['reference_no']; ?>" name="Inventory[reference_no]">
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