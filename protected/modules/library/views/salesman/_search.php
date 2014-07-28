<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = Salesman::model()->attributeLabels(); ?>	                
                    <!--        <div class="form-group">
                                <label for="Salesman_salesman_id" class="col-sm-2 control-label"><?php echo $fields['salesman_id']; ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="Salesman_salesman_id" placeholder="<?php echo $fields['salesman_id']; ?>" name="Salesman[salesman_id]">
                                </div>
                            </div>-->

                    <div class="form-group">
                        <label for="Salesman_team_leader_id" class="col-sm-2 control-label"><?php echo $fields['team_leader_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_team_leader_id" placeholder="<?php echo $fields['team_leader_id']; ?>" name="Salesman[team_leader_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_salesman_name" class="col-sm-2 control-label"><?php echo $fields['salesman_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_salesman_name" placeholder="<?php echo $fields['salesman_name']; ?>" name="Salesman[salesman_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_salesman_code" class="col-sm-2 control-label"><?php echo $fields['salesman_code']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_salesman_code" placeholder="<?php echo $fields['salesman_code']; ?>" name="Salesman[salesman_code]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_mobile_number" class="col-sm-2 control-label"><?php echo $fields['mobile_number']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_mobile_number" placeholder="<?php echo $fields['mobile_number']; ?>" name="Salesman[mobile_number]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_device_no" class="col-sm-2 control-label"><?php echo $fields['device_no']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_device_no" placeholder="<?php echo $fields['device_no']; ?>" name="Salesman[device_no]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_other_fields_1" class="col-sm-2 control-label"><?php echo $fields['other_fields_1']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_other_fields_1" placeholder="<?php echo $fields['other_fields_1']; ?>" name="Salesman[other_fields_1]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_other_fields_2" class="col-sm-2 control-label"><?php echo $fields['other_fields_2']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_other_fields_2" placeholder="<?php echo $fields['other_fields_2']; ?>" name="Salesman[other_fields_2]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_other_fields_3" class="col-sm-2 control-label"><?php echo $fields['other_fields_3']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_other_fields_3" placeholder="<?php echo $fields['other_fields_3']; ?>" name="Salesman[other_fields_3]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="Salesman[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="Salesman[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="Salesman[updated_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="Salesman[updated_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Salesman_is_team_leader" class="col-sm-2 control-label"><?php echo $fields['is_team_leader']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="Salesman_is_team_leader" placeholder="<?php echo $fields['is_team_leader']; ?>" name="Salesman[is_team_leader]">
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