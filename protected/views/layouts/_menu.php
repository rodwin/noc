<?php
$main_menu = array(
    array('label' => 'Dashboard', 'url' => array('/site/index'), 'visible' => !Yii::app()->user->isGuest),
    array('label' => 'Widgets', 'url' => array('/tracker'), 'visible' => !Yii::app()->user->isGuest),
    array('label' => 'Charts', 'url' => '#', 'visible' => !Yii::app()->user->isGuest, 'items' => array(
            array('label' => 'Morris', 'url' => array('/transaction/salesorder/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Flot', 'url' => array('/transaction/salesorder/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Inline charts', 'url' => array('/transaction/salesorder/admin'), 'visible' => !Yii::app()->user->isGuest),
        )),
);
?>

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <?php
//foreach ($main_menu as $key => $value) {
//    if($value['url'] != '#'){
    ?>



    <?php
    //}
    //}
    ?>
    <li class="active">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="<?php echo Yii::app()->createUrl("locationviewer") ?>">
            <i class="fa fa-map-marker"></i> <span>Location Viewer</span>
        </a>
    </li>
    <li class="">
        <a href="<?php echo Yii::app()->createUrl("/inventory/inventory/admin") ?>">
            <i class="fa fa-list-alt"></i> <span>Inventory</span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-book"></i> <span>Library</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/distributor/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Distributor</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/salesoffice/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Sales Office</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/zone/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Zone</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/salesman/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Salesman</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/poicategory/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>POI Category</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/poisubcategory/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>POI Sub Category</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/PoiCustomData/create") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>POI Custom Data</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/poi/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>POI</span>
                </a>
            </li>

            <li>
                <hr/>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/brandcategory/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Brand Category</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/brand/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Brand</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/uom/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>UOM</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/skustatus/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>SKU Status</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/skuCustomData/create") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>SKU Custom Data</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/library/sku/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>SKU</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i> <span>Admin</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="<?php echo Yii::app()->createUrl("/admin/user/admin") ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Users</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl("/admin/company/update", array('id' => Yii::app()->user->company_id)) ?>">
                    <i class="fa fa-angle-double-right"></i> <span>Company</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-angle-double-right"></i> <span>Settings</span>
                </a>
            </li>
        </ul>
    </li>

</ul>