<?php
$main_menu = array(
    array('label' => 'Dashboard Pome', 'url' => array(Yii::app()->params['company_modules'][Yii::app()->user->company_id]['dashboard']), 'icon' => 'fa fa-dashboard', 'visible' => Yii::app()->user->checkAccess(Yii::app()->user->auth_company_dashboard, array('company_id' => Yii::app()->user->company_id))),
    array('label' => 'Dashboard Pome', 'url' => array('pome/tl'), 'icon' => 'fa fa-dashboard', 'visible' => Yii::app()->user->checkAccess('Pome Dashboard TL', array('company_id' => Yii::app()->user->company_id))),
    array('label' => 'Dashboard Dtd', 'url' => array('dtd'), 'icon' => 'fa fa-dashboard', 'visible' => Yii::app()->user->checkAccess('DTD Dashboard', array('company_id' => Yii::app()->user->company_id))),
    array('label' => 'Edac', 'url' => array('pome/survey'), 'icon' => 'fa fa-book', 'visible' => Yii::app()->user->checkAccess('Survey', array('company_id' => Yii::app()->user->company_id))),
    array('label' => 'Location Viewer', 'url' => array('locationviewer'), 'icon' => 'fa fa-map-marker', 'visible' => Yii::app()->user->checkAccess('Location Viewer', array('company_id' => Yii::app()->user->company_id))),
    array('label' => 'Inventory', 'url' => '#', 'icon' => 'fa fa-list-alt', 'visible' => true, 'items' => array(
            array('label' => 'Inventory Management', 'icon' => 'fa fa-angle-double-right', 'url' => array('inventory/inventory/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Inventory', array('company_id' => Yii::app()->user->company_id))),
            array('label' => ReceivingInventory::RECEIVING_LABEL, 'icon' => 'fa fa-angle-double-right', 'url' => array('inventory/receivingInventory/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Incoming', array('company_id' => Yii::app()->user->company_id))),
            array('label' => IncomingInventory::INCOMING_LABEL, 'icon' => 'fa fa-angle-double-right', 'url' => array('inventory/incomingInventory/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Inbound', array('company_id' => Yii::app()->user->company_id))),
            array('label' => OutgoingInventory::OUTGOING_LABEL, 'icon' => 'fa fa-angle-double-right', 'url' => array('inventory/outgoingInventory/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Outbound', array('company_id' => Yii::app()->user->company_id))),
            array('label' => CustomerItem::CUSTOMER_ITEM_LABEL, 'icon' => 'fa fa-angle-double-right', 'url' => array('inventory/customerItem/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Outgoing', array('company_id' => Yii::app()->user->company_id))),
            array('label' => ProofOfDelivery::PROOF_OF_DELIVERY_LABEL, 'icon' => 'fa fa-angle-double-right', 'url' => array('inventory/proofOfDelivery/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Proof Of Delivery', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Returns', 'icon' => 'fa fa-angle-double-right', 'url' => array('inventory/returns/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Returns', array('company_id' => Yii::app()->user->company_id))),
    )),
    array('label' => 'Library', 'url' => '#', 'icon' => 'fa fa-book', 'visible' => true, 'items' => array(
            array('label' => 'Supplier', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/supplier/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Supplier', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Sales Office', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/salesoffice/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Salesoffice', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Zone', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/zone/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Zone', array('company_id' => Yii::app()->user->company_id))),
            '---',
            array('label' => 'Employee Status', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/employeestatus/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Employee Status', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Employee Type', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/employeetype/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Employee Type', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Employee', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/employee/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Employee', array('company_id' => Yii::app()->user->company_id))),
            '---',
            array('label' => Poi::POI_LABEL . ' ' . 'Category', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poicategory/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Outlet Category', array('company_id' => Yii::app()->user->company_id))),
            array('label' => Poi::POI_LABEL . ' ' . 'Sub Category', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poisubcategory/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Outlet Sub Category', array('company_id' => Yii::app()->user->company_id))),
            array('label' => Poi::POI_LABEL . ' ' . 'Custom Data', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poicustomdata/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Outlet Custom Data', array('company_id' => Yii::app()->user->company_id))),
            array('label' => Poi::POI_LABEL, 'icon' => 'fa fa-angle-double-right', 'url' => array('library/poi/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Outlet', array('company_id' => Yii::app()->user->company_id))),
            '---',
            array('label' => 'Brand Category', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/brandcategory/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Brand Category', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Brand', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/brand/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Brand', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'UOM', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/uom/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Unit Of Measure', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Images', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/images/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Images', array('company_id' => Yii::app()->user->company_id))),
            array('label' => Sku::SKU_LABEL . ' ' . 'Status', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/skustatus/admin'), 'visible' => Yii::app()->user->checkAccess('Manage SKU Status', array('company_id' => Yii::app()->user->company_id))),
            array('label' => Sku::SKU_LABEL . ' ' . 'Custom Data', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/skuCustomData/admin'), 'visible' => Yii::app()->user->checkAccess('Manage SKU Custom Data', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Merchandising Material', 'icon' => 'fa fa-angle-double-right', 'url' => array('library/sku/admin'), 'visible' => Yii::app()->user->checkAccess('Manage SKU', array('company_id' => Yii::app()->user->company_id))),
    )),
    array('label' => 'Reports', 'url' => '#', 'icon' => 'fa fa-file-text-o', 'visible' => true, 'items' => array(
            array('label' => 'Ending Inventory', 'icon' => 'fa fa-angle-double-right', 'url' => array('reports/endingInventory/index'), 'visible' => Yii::app()->user->checkAccess('Ending Inventory Report', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Infra Inventory', 'icon' => 'fa fa-angle-double-right', 'url' => array('reports/infraInventory/index'), 'visible' => Yii::app()->user->checkAccess('Infra Inventory Report', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Delivery Lead-Time', 'icon' => 'fa fa-angle-double-right', 'url' => array('reports/deliveryLeadTime/index'), 'visible' => Yii::app()->user->checkAccess('Delivery Lead Time Report', array('company_id' => Yii::app()->user->company_id))),
    )),
    array('label' => 'Admin', 'url' => '#', 'icon' => 'fa fa-users', 'visible' => true, 'items' => array(
            array('label' => 'Users', 'icon' => 'fa fa-angle-double-right', 'url' => array('admin/user/admin'), 'visible' => Yii::app()->user->checkAccess('Manage User', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Company', 'icon' => 'fa fa-angle-double-right', 'url' => array('admin/company/update', array('id' => Yii::app()->user->company_id)), 'visible' => Yii::app()->user->checkAccess('Edit Company', array('company_id' => Yii::app()->user->company_id))),
            array('label' => 'Role', 'icon' => 'fa fa-angle-double-right', 'url' => array('admin/authitem/admin'), 'visible' => Yii::app()->user->checkAccess('Manage Role', array('company_id' => Yii::app()->user->company_id))),
    )),
);
?>

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
   <?php
   foreach ($main_menu as $key => $value) {
      if ($value['visible'] === true) {
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
            $visible_count = 0;
            foreach ($value['items'] as $i => $item) {

               if (!is_array($item)) {
                  continue;
               }
               if ($item['url'][0] == Yii::app()->getRequest()->getQuery('r')) {
                  $tv_active = 'active';
                  $visible_count = 1;
                  break;
               }

               if ($item['visible'] === true) {
                  $visible_count++;
               }
            }
            ?>

            <?php if ($visible_count > 0) { ?>
               <li id="parent_li_<?php echo $key; ?>" class="treeview <?php echo $tv_active; ?>">
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

                           if ($item['visible'] === true) {
                              ?>

                              <li class="<?php echo Yii::app()->getRequest()->getQuery('r') == $item['url'][0] ? 'active' : '' ?>">
                                 <a href="<?php echo Yii::app()->createUrl($item['url'][0], isset($item['url'][1]) ? $item['url'][1] : array()) ?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo $item['label']; ?></span>
                                 </a>
                              </li>

                              <?php
                           }
                        }
                        ?>
                     </ul>
                  </a>
               </li>
               <?php
            }
         }
      }
      ?>

   <?php } ?>
</ul>