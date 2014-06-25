<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="col-md-9">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="col-md-3">
        <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <div class="box-title">Operations</div>
                                </div>
                                <div class="box-body">
                                    <?php
                                    $this->widget(
                                        'booster.widgets.TbMenu',
                                        array(
                                            'type' => 'list',
                                            'items' => $this->menu,
                                        )
                                    );

                                    ?>
                                    
                                </div><!-- /.box-body -->
                            </div>
	<div id="sidebar">
	
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>