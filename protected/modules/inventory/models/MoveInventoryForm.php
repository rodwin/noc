<?php

class MoveInventoryForm extends CFormModel {

    public $qty;
    public $transaction_date;
    public $cost_per_unit;
    public $inventory_id;
    public $created_by;
    public $zone_id;
    public $status_id;
    public $inventoryObj = null;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('created_by, qty, transaction_date, zone_id', 'required'),
            array('inventory_id', 'isValidInventoryId'),
            array('zone_id', 'isValidZone'),
            array('status_id', 'isValidStatus'),
            array('transaction_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('qty', 'numerical', 'integerOnly' => true, 'max' => 9999999, 'min' => 0),
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

    public function isValidZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Zone from the auto-complete.');
        }

        return;
    }

    public function isValidStatus($attribute) {
        if ($this->$attribute == null) {
            return;
        }

        $model = SkuStatus::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Status is invalid');
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

        if ($this->status_id == "") {
            $this->status_id = null;
        }

        return parent::beforeValidate();
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'qty' => 'Move a quantity of...',
            'transaction_date' => 'Transaction Date',
            'cost_per_unit' => 'Cost per Unit',
            'zone_id' => 'Zone',
            'status_id' => 'Update Status to:',
        );
    }

    public function move($validate = true) {

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
                    'uom_id' => $this->inventoryObj->uom_id,
                    'zone_id' => $this->zone_id,
                    'sku_status_id' => $this->status_id,
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
                $inv_qty = $this->qty + $inventory->qty;
                InventoryHistory::model()->createHistory($inventory->company_id, $inventory->inventory_id, $inventory->transaction_date, $this->qty, $inv_qty, Inventory::INVENTORY_ACTION_TYPE_MOVE, $inventory->cost_per_unit, $this->created_by);
            } else {
                $inventory = new Inventory();
                $inv_qty = $this->qty;
            }

            $inventory_data = array(
                'sku_id' => $this->inventoryObj->sku_id,
                'company_id' => Yii::app()->user->company_id,
                'qty' => $inv_qty,
                'uom_id' => $this->inventoryObj->uom_id,
                'zone_id' => $this->zone_id,
                'sku_status_id' => $this->status_id,
                'transaction_date' => $this->transaction_date,
                'expiration_date' => $this->inventoryObj->expiration_date,
                'reference_no' => $this->inventoryObj->reference_no,
            );

            $inventory->attributes = $inventory_data;

            if ($inventory->save(false)) {
                
                if ($item_exist == false) {
                    InventoryHistory::model()->createHistory($inventory->company_id, $inventory->inventory_id, $inventory->transaction_date, $this->qty, $inv_qty, Inventory::INVENTORY_ACTION_TYPE_MOVE, $inventory->cost_per_unit, $this->created_by);
                }
            }

            InventoryHistory::model()->createHistory($this->inventoryObj->company_id, $this->inventoryObj->inventory_id, $this->transaction_date, "-" . $this->qty, $qty, Inventory::INVENTORY_ACTION_TYPE_MOVE, $this->cost_per_unit, $this->created_by);

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
