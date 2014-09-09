<?php
$this->breadcrumbs = array(
    'Suppliers' => array('admin'),
    $model->supplier_id,
);
?>

<div class="row">
   <?php
   $this->widget('booster.widgets.TbDetailView', array(
       'data' => $model,
       'type' => 'bordered condensed',
       'attributes' => array(
//		'supplier_id',
//		'company.name',
           'supplier_code',
           'supplier_name',
           'contact_person1',
           'contact_person2',
           'telephone',
           'cellphone',
           'fax_number',
           'address1',
           'address2',
            array(
               'name' => 'Region',
               'value' => CHtml::encode($model->region_name)
           ),
           'region',
           'province',
           'municipal',
           'barangay',
           'latitude',
           'longitude',
           'created_date',
           'created_by',
           'updated_date',
           'updated_by',
       ),
   ));
   ?>
</div>
