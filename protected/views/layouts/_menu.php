<?php
$main_menu = array(
    array('label' => 'Dashboard', 'url' => array('site/index'), 'icon' => 'fa fa-dashboard', 'visible' => !Yii::app()->user->isGuest),
    array('label' => 'Location Viewer', 'url' => array('locationviewer'), 'icon' => 'fa fa-map-marker', 'visible' => !Yii::app()->user->isGuest),
    array('label' => 'Inventory', 'url' => '#', 'icon' => 'fa fa-list-alt', 'visible' => !Yii::app()->user->isGuest, 'items' => array(
            array('label' => 'Inventory Management', 'icon' => 'fa fa-angle-double-right', 'url' => array('/inventory/inventory/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Receiving', 'icon' => 'fa fa-angle-double-right', 'url' => array('/inventory/receivingInventory/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Incoming', 'icon' => 'fa fa-angle-double-right', 'url' => array('/inventory/incomingInventory/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Outgoing', 'icon' => 'fa fa-angle-double-right', 'url' => array('/inventory/outgoingInventory/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Customer Item', 'icon' => 'fa fa-angle-double-right', 'url' => array('/inventory/customerItem/admin'), 'visible' => !Yii::app()->user->isGuest),
        )),
    array('label' => 'Library', 'url' => '#', 'icon' => 'fa fa-book', 'visible' => !Yii::app()->user->isGuest, 'items' => array(
            array('label' => 'Supplier', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/supplier/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Sales Office', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/salesoffice/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Zone', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/zone/admin'), 'visible' => !Yii::app()->user->isGuest),
            '---',
            array('label' => 'Employee Status', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/employeestatus/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Employee Type', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/employeetype/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Employee', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/employee/admin'), 'visible' => !Yii::app()->user->isGuest),
            '---',
            array('label' => Poi::POI_LABEL . ' ' . 'Category', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poicategory/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => Poi::POI_LABEL . ' ' . 'Sub Category', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poisubcategory/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => Poi::POI_LABEL . ' ' . 'Custom Data', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poicustomdata/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => Poi::POI_LABEL, 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poi/admin'), 'visible' => !Yii::app()->user->isGuest),
            '---',
            array('label' => 'Brand Category', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/brandcategory/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Brand', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/brand/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'UOM', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/uom/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Images', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/images/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => Sku::SKU_LABEL . ' ' . 'Status', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/skustatus/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => Sku::SKU_LABEL . ' ' . 'Custom Data', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/skuCustomData/create'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Merchandising Material', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/sku/admin'), 'visible' => !Yii::app()->user->isGuest),
        )),
    array('label' => 'Admin', 'url' => '#', 'icon' => 'fa fa-users', 'visible' => !Yii::app()->user->isGuest, 'items' => array(
            array('label' => 'Users', 'icon' => 'fa fa-angle-double-right', 'url' => array('admin/user/admin'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Company', 'icon' => 'fa fa-angle-double-right', 'url' => array('admin/company/update', array('id' => Yii::app()->user->company_id)), 'visible' => !Yii::app()->user->isGuest),
        )),
);
?>

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <?php
    foreach ($main_menu as $key => $value) {
        if ($value['url'] != '#') {
            ?>

            <li class="<?php echo Yii::app()->getRequest()->getQuery('r') == $value['url'][0] ? 'active' : '' ?>">
                <a href="<?php echo Yii::app()->createUrl($value['url'][0]) ?>">
                    <i class="<?php echo $value['icon']; ?>"></i> <span><?php echo $value['label']; ?></span>
                </a>
            </li>


        <?php } else { ?>

            <?php
            $tv_active = '';
            foreach ($value['items'] as $i => $item) {
                if (!is_array($item)) {
                    continue;
                }
                if ($item['url'][0] == Yii::app()->getRequest()->getQuery('r')) {
                    $tv_active = 'active';
                    break;
                }
            }
            ?>
            <li class="treeview <?php echo $tv_active; ?>">
                <a href="#">
                    <i class="<?php echo $value['icon']; ?>"></i> <span><?php echo $value['label']; ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                    <ul class="treeview-menu">
                        <?php
                        foreach ($value['items'] as $i => $item) {
                            if (!is_array($item)) {
                                echo '<hr/>';
                                continue;
                            }
                            ?>

                            <li class="<?php echo Yii::app()->getRequest()->getQuery('r') == $item['url'][0] ? 'active' : '' ?>">
                                <a href="<?php echo Yii::app()->createUrl($item['url'][0], isset($item['url'][1]) ? $item['url'][1] : array()) ?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo $item['label']; ?></span>
                                </a>
                            </li>

        <?php } ?>
                    </ul>
                </a>
            </li>
    <?php } ?>


<?php } ?>
</ul>