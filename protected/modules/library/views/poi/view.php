<?php
$this->breadcrumbs = array(
    'Pois' => array('admin'),
    $model->short_name,
);
?>

<div class="row">
    <div class="nav-tabs-custom">

        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">POI</a></li>
            <li><a href="#tab_2" data-toggle="tab">POI Custom Data</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <?php
                $this->widget('booster.widgets.TbDetailView', array(
                    'data' => $model,
                    'type' => 'bordered condensed',
                    'attributes' => array(
                        'poi_id',
                        'company.name',
                        'short_name',
                        'long_name',
                        'primary_code',
                        'secondary_code',
                        'barangay_id',
                        'municipal_id',
                        'province_id',
                        'region_id',
                        'sales_region_id',
                        'latitude',
                        'longitude',
                        'address1',
                        'address2',
                        'zip',
                        'landline',
                        'mobile',
                        'poiCategory.category_name',
                        'poiSubCategory.sub_category_name',
                        'remarks',
                        'status',
                        'created_date',
                        'created_by',
                        'edited_date',
                        'edited_by',
                        'verified_by',
                        'verified_date',
                    ),
                ));
                ?>
            </div>

            <div class="tab-pane" id="tab_2">

                <?php if (count($poi_custom_data_value) > 0) { ?>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered">
                            <?php foreach ($poi_custom_data_value as $key => $val) { ?>

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
