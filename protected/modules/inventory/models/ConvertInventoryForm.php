<?php

class ConvertInventoryForm extends CFormModel {

    public $qty;
    public $transaction_date;
    public $cost_per_unit;
    public $inventory_id;
    public $created_by;
    public $equivalent_qty;
    public $new_uom_id;
    public $inventoryObj = null;
    public $remarks;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('created_by, qty, transaction_date, equivalent_qty', 'required'),
            array('new_uom_id', 'required', 'message' => 'Unit of Measure is required.'),
            array('remarks', 'length', 'max' => 200),
            array('inventory_id', 'isValidInventoryId'),
            array('qty', 'isValidQty'),
            array('transaction_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('qty, equivalent_qty', 'numerical', 'integerOnly' => true, 'max' => 9999999, 'min' => 0),
        );
    }

    public function isValidInventoryId($attribute) {
        $model = Inventory::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Inventory id is invalid');
        } else {
            $this->inventoryObj = $model;
        }

        return;
    }

    public function isValidQty($attribute) {

        if (ctype_digit($this->$attribute)) {            
            if ($this->$attribute > $this->inventoryObj->qty) {
                $this->addError($attribute, 'Quantity is greater than inventory on hand');
            }
        }

        return;
    }

    public function beforeValidate() {

        if ($this->cost_per_unit == "") {
            $this->cost_per_unit = 0;
        }

        if ($this->qty == "") {
            $this->qty = 0;
        }

        return parent::beforeValidate();
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'qty' => 'Convert a quantity of...',
            'transaction_date' => 'Transaction Date',
            'cost_per_unit' => 'Cost per Unit',
            'equivalent_qty' => 'Enter Number',
            'remarks' => 'Remarks',
        );
    }

    public function convert($validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $inv_qty = 0;
        $item_exist = false;

        $inventory = Inventory::model()->findByAttributes(
                array(
                    'company_id' => Yii::app()->user->company_id,
                    'sku_id' => $this->inventoryObj->sku_id,
                    'uom_id' => $this->new_uom_id,
                    'zone_id' => $this->inventoryObj->zone_id,
                    'sku_status_id' => $this->inventoryObj->sku_status_id,
                    'expiration_date' => $this->inventoryObj->expiration_date,
                    'reference_no' => $this->inventoryObj->reference_no,
                )
        );

        $transaction = $this->inventoryObj->dbConnection->beginTransaction(); // Transaction begin

        try {

            $qty = $this->inventoryObj->qty - $this->qty;
            $this->inventoryObj->qty = $qty;
            $this->inventoryObj->save(false);

            if ($inventory) {
                $item_exist = true;
                $inv_qty = $this->equivalent_qty + $inventory->qty;
                InventoryHistory::model()->createHistory($inventory->company_id, $inventory->inventory_id, $inventory->transaction_date, $this->equivalent_qty, $inv_qty, Inventory::INVENTORY_ACTION_TYPE_CONVERT, $inventory->cost_per_unit, $this->created_by, $this->inventoryObj->zone_id, $this->remarks);
            } else {
                $inventory = new Inventory();
                $inv_qty = $this->equivalent_qty;
            }

            $inventory_data = array(
                'sku_id' => $this->inventoryObj->sku_id,
                'company_id' => Yii::app()->user->company_id,
                'qty' => $inv_qty,
                'uom_id' => $this->new_uom_id,
                'zone_id' => $this->inventoryObj->zone_id,
                'sku_status_id' => $this->inventoryObj->sku_status_id,
                'transaction_date' => $this->transaction_date,
                'expiration_date' => $this->inventoryObj->expiration_date,
                'reference_no' => $this->inventoryObj->reference_no,
            );

            $inventory->attributes = $inventory_data;

            if ($inventory->save(false)) {

                if ($item_exist == false) {
                    InventoryHistory::model()->createHistory($inventory->company_id, $inventory->inventory_id, $inventory->transaction_date, $this->equivalent_qty, $inv_qty, Inventory::INVENTORY_ACTION_TYPE_CONVERT, $inventory->cost_per_unit, $this->created_by, $this->inventoryObj->zone_id, $this->remarks);
                }
            }

            InventoryHistory::model()->createHistory($this->inventoryObj->company_id, $this->inventoryObj->inventory_id, $this->transaction_date, "-" . $this->qty, $qty, Inventory::INVENTORY_ACTION_TYPE_CONVERT, $this->cost_per_unit, $this->created_by, $this->inventoryObj->zone_id, $this->remarks);

            $transaction->commit();

            return true;
        } catch (Exception $exc) {

            Yii::log($exc->getTraceAsString(), 'error');
            $transaction->rollBack();
            return false;
        }

        return false;
    }

}
