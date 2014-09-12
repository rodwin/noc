<?php

class DecreaseInventoryForm extends CFormModel {

    public $qty;
    public $transaction_date;
    public $cost_per_unit;
    public $inventory_id;
    public $created_by;
    public $inventoryObj = null;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('created_by, qty, transaction_date', 'required'),
            array('inventory_id', 'isValidInventoryId'),
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
            'qty' => 'Decrease the quantity by...',
            'transaction_date' => 'Transaction Date',
            'cost_per_unit' => 'Cost per Unit',
        );
    }

    public function decrease($validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $transaction = $this->inventoryObj->dbConnection->beginTransaction(); // Transaction begin

        try {

            $qty = $this->inventoryObj->qty - $this->qty;
            $this->inventoryObj->qty = $qty;
            $this->inventoryObj->save(false);

            InventoryHistory::model()->createHistory($this->inventoryObj->company_id, $this->inventoryObj->inventory_id, $this->transaction_date, "-" . $this->qty, $qty, Inventory::INVENTORY_ACTION_TYPE_DECREASE, $this->cost_per_unit, $this->created_by, $this->inventoryObj->zone_id);

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
