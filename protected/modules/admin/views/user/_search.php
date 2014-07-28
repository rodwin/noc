<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form class="form-horizontal" role="form">
                    <?php $fields = User::model()->attributeLabels(); ?>
                    <!--                    <div class="form-group">
                                            <label for="User_user_id" class="col-sm-2 control-label"><?php echo $fields['user_id']; ?></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="User_user_id" placeholder="<?php echo $fields['user_id']; ?>" name="User[user_id]">
                                            </div>
                                        </div>-->

                    <div class="form-group">
                        <label for="User_user_type_id" class="col-sm-2 control-label"><?php echo $fields['user_type_id']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_user_type_id" placeholder="<?php echo $fields['user_type_id']; ?>" name="User[user_type_id]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_user_name" class="col-sm-2 control-label"><?php echo $fields['user_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_user_name" placeholder="<?php echo $fields['user_name']; ?>" name="User[user_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_status" class="col-sm-2 control-label"><?php echo $fields['status']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_status" placeholder="<?php echo $fields['status']; ?>" name="User[status]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_first_name" class="col-sm-2 control-label"><?php echo $fields['first_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_first_name" placeholder="<?php echo $fields['first_name']; ?>" name="User[first_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_last_name" class="col-sm-2 control-label"><?php echo $fields['last_name']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_last_name" placeholder="<?php echo $fields['last_name']; ?>" name="User[last_name]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_email" class="col-sm-2 control-label"><?php echo $fields['email']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_email" placeholder="<?php echo $fields['email']; ?>" name="User[email]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_position" class="col-sm-2 control-label"><?php echo $fields['position']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_position" placeholder="<?php echo $fields['position']; ?>" name="User[position]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_telephone" class="col-sm-2 control-label"><?php echo $fields['telephone']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_telephone" placeholder="<?php echo $fields['telephone']; ?>" name="User[telephone]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_address" class="col-sm-2 control-label"><?php echo $fields['address']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_address" placeholder="<?php echo $fields['address']; ?>" name="User[address]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_created_date" class="col-sm-2 control-label"><?php echo $fields['created_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_created_date" placeholder="<?php echo $fields['created_date']; ?>" name="User[created_date]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_created_by" class="col-sm-2 control-label"><?php echo $fields['created_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_created_by" placeholder="<?php echo $fields['created_by']; ?>" name="User[created_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_updated_by" class="col-sm-2 control-label"><?php echo $fields['updated_by']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_updated_by" placeholder="<?php echo $fields['updated_by']; ?>" name="User[updated_by]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="User_updated_date" class="col-sm-2 control-label"><?php echo $fields['updated_date']; ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="User_updated_date" placeholder="<?php echo $fields['updated_date']; ?>" name="User[updated_date]">
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