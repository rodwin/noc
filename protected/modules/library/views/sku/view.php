<?php
$this->breadcrumbs = array(
    Sku::SKU_LABEL => array('admin'),
    $model->sku_name,
);
?>

<style type="text/css">
    #sku tr th { width: 20%; }
</style>

<div class="row">
    <div class="nav-tabs-custom">

        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><?php echo Sku::SKU_LABEL; ?> Details</a></li>
            <li><a href="#tab_2" data-toggle="tab"><?php echo Sku::SKU_LABEL; ?> Custom Data</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <?php
                $this->widget('booster.widgets.TbDetailView', array(
                    'id' => 'sku',
                    'data' => $model,
                    'type' => 'bordered condensed',
                    'attributes' => array(
                        'sku_id',
                        'sku_code',
                        'company.name',
                        'brand.brand_name',
                        'sku_name',
                        'description',
                        'created_date',
                        'created_by',
                        'updated_date',
                        'updated_by',
                    ),
                ));
                ?>

                <h4 class="control-label text-primary"><b>Item Settings</b></h4>

                <?php
                $this->widget('booster.widgets.TbDetailView', array(
                    'id' => 'sku',
                    'data' => $model,
                    'type' => 'bordered condensed',
                    'attributes' => array(
                        'defaultUom.uom_name',
                        'default_unit_price',
                        'type',
                        'defaultZone.zone_name',
                        'supplier',
                    ),
                ));
                ?>

                <h4 class="control-label text-primary"><b>Restock Levels</b></h4>

                <?php
                $this->widget('booster.widgets.TbDetailView', array(
                    'id' => 'sku',
                    'data' => $model,
                    'type' => 'bordered condensed',
                    'attributes' => array(
                        'low_qty_threshold',
                        'high_qty_threshold',
                    ),
                ));
                ?>

            </div>

            <div class="tab-pane" id="tab_2">

                <?php if (count($sku_custom_data_value) > 0) { ?>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered">
                            <?php foreach ($sku_custom_data_value as $key => $val) { ?>

                                <tr><th><?php echo $val['custom_data_name']; ?></th><td><?php echo $val['value']; ?></td></tr>

                            <?php } ?>
                        </table>

                    </div>

                <?php } else { ?>
                    <h6 style="text-align: center;"><em>Custom Data Not Set.</em></h6>
                <?php } ?>

            </div>

        </div>

    </div> 
</div>
