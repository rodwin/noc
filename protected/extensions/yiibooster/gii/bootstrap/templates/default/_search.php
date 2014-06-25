<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <form class="form-horizontal" role="form">
<?php foreach ($this->tableSchema->columns as $column): ?>
	<?php
	$field = $this->generateInputField($this->modelClass, $column);
	if (strpos($field, 'password') !== false) {
		continue;
	}
	?>
                
        <div class="form-group">
            <label for="<?php echo $this->modelClass;?>_<?php echo $column->name;?>" class="col-sm-2 control-label"><?php echo $column->name;?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="<?php echo $this->modelClass;?>_<?php echo $column->name;?>" placeholder="<?php echo $column->name;?>" name="<?php echo $this->modelClass;?>[<?php echo $column->name;?>]">
            </div>
        </div>
<?php endforeach; ?>
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