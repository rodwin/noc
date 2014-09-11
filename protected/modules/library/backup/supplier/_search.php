<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = Supplier::model()->attributeLabels(); ?>	                
                    <div class="form-group">
                        <label for="Supplier_supplier_id" class="col-sm-2 control-label"><?php echo $fields['supplier_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_supplier_id" placeholder="<?php echo $fields['supplier_id']; ?>" name="Supplier[supplier_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_supplier_code" class="col-sm-2 control-label"><?php echo $fields['supplier_code']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_supplier_code" placeholder="<?php echo $fields['supplier_code']; ?>" name="Supplier[supplier_code]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_supplier_name" class="col-sm-2 control-label"><?php echo $fields['supplier_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_supplier_name" placeholder="<?php echo $fields['supplier_name']; ?>" name="Supplier[supplier_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_contact_person1" class="col-sm-2 control-label"><?php echo $fields['contact_person1']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_contact_person1" placeholder="<?php echo $fields['contact_person1']; ?>" name="Supplier[contact_person1]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_contact_person2" class="col-sm-2 control-label"><?php echo $fields['contact_person2']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_contact_person2" placeholder="<?php echo $fields['contact_person2']; ?>" name="Supplier[contact_person2]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_telephone" class="col-sm-2 control-label"><?php echo $fields['telephone']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_telephone" placeholder="<?php echo $fields['telephone']; ?>" name="Supplier[telephone]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_cellphone" class="col-sm-2 control-label"><?php echo $fields['cellphone']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_cellphone" placeholder="<?php echo $fields['cellphone']; ?>" name="Supplier[cellphone]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_fax_number" class="col-sm-2 control-label"><?php echo $fields['fax_number']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_fax_number" placeholder="<?php echo $fields['fax_number']; ?>" name="Supplier[fax_number]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_address1" class="col-sm-2 control-label"><?php echo $fields['address1']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_address1" placeholder="<?php echo $fields['address1']; ?>" name="Supplier[address1]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_address2" class="col-sm-2 control-label"><?php echo $fields['address2']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_address2" placeholder="<?php echo $fields['address2']; ?>" name="Supplier[address2]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_barangay_id" class="col-sm-2 control-label"><?php echo $fields['barangay_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_barangay_id" placeholder="<?php echo $fields['barangay_id']; ?>" name="Supplier[barangay_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_municipal_id" class="col-sm-2 control-label"><?php echo $fields['municipal_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_municipal_id" placeholder="<?php echo $fields['municipal_id']; ?>" name="Supplier[municipal_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_province_id" class="col-sm-2 control-label"><?php echo $fields['province_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_province_id" placeholder="<?php echo $fields['province_id']; ?>" name="Supplier[province_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_region_id" class="col-sm-2 control-label"><?php echo $fields['region_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_region_id" placeholder="<?php echo $fields['region_id']; ?>" name="Supplier[region_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_latitude" class="col-sm-2 control-label"><?php echo $fields['latitude']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_latitude" placeholder="<?php echo $fields['latitude']; ?>" name="Supplier[latitude]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_longitude" class="col-sm-2 control-label"><?php echo $fields['longitude']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_longitude" placeholder="<?php echo $fields['longitude']; ?>" name="Supplier[longitude]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Supplier[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Supplier[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Supplier[updated_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Supplier_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Supplier_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Supplier[updated_by]">
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