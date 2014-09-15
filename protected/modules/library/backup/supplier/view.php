<?php
$this->breadcrumbs = array(
    'Suppliers' => array('admin'),
    $model->supplier_name,
);
?>

<div class="row">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'type' => 'bordered condensed',
        'attributes' => array(
            'supplier_id',
            'company.name',
            'supplier_code',
            'supplier_name',
            'contact_person1',
            'contact_person2',
            'telephone',
            'cellphone',
            'fax_number',
            'address1',
            'address2',
            'barangay_name',
            'municipal_name',
            'province_name',
            'region_name',
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
