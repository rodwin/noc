<?php
$this->breadcrumbs = array(
    'Returns' => array('admin'),
    'Create',
);
?>

<div class="nav-tabs-custom" id ="custTabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab"><?php echo Returns::RETURNABLE; ?></a></li>
        <li><a href="#tab_2" data-toggle="tab"><?php echo Returns::RETURN_RECEIPT; ?></a></li>
        <li><a href="#tab_3" data-toggle="tab"><?php echo Returns::RETURN_MDSE; ?></a></li>
    </ul>
    <div class="tab-content" id ="info">
        <div class="tab-pane active" id="tab_1">
            <?php
            $this->renderPartial("_returnable", array(
                'model' => $model,
                'return_from_list' => $return_from_list,
                'zone_list' => $zone_list,
                'poi_list' => $poi_list,
                'salesoffice_list' => $salesoffice_list,
                'employee' => $employee,
            ));
            ?>
        </div>

        <div class="tab-pane" id="tab_2">
            <?php $this->renderPartial("_return_receipt", array()); ?>
        </div>

        <div class="tab-pane" id="tab_3">
            <?php $this->renderPartial("_return_mdse", array()); ?>
        </div>
    </div>
</div>