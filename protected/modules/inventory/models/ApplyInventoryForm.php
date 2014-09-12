<?php

class ApplyInventoryForm extends CFormModel {

    public $qty;
    public $transaction_date;
    public $cost_per_unit;
    public $inventory_id;
    public $created_by;
    public $unique_tag;
    public $unique_date;
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
            array('unique_tag', 'safe'),
            array('transaction_date, unique_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
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

        if ($this->unique_tag == "") {
            $this->unique_tag = "";
        }

        if ($this->unique_date == "") {
            $this->unique_date = null;
        }

        return parent::beforeValidate();
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'qty' => 'Apply to a quantity of...',
            'transaction_date' => 'Transaction Date',
            'cost_per_unit' => 'Cost per Unit',
            'unique_tag' => 'Unique Tag',
            'unique_date' => 'Unique Date',
        );
    }

    public function apply($validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }
        InventoryHistory::model()->selected_inventory_id = $this->inventoryObj->inventory_id;
        
        $inv_qty = 0;
        $key = 0;
        $item_exist = false;

        $c = new CDbCriteria;
        $c->condition = 't.inventory_id != ' . $this->inventoryObj->inventory_id;

        if ($this->unique_tag == "" && $this->unique_date == "") {

            $inv = Inventory::model()->findAllByAttributes(
                    array(
                'company_id' => Yii::app()->user->company_id,
                'sku_id' => $this->inventoryObj->sku_id,
                'uom_id' => $this->inventoryObj->uom_id,
                'zone_id' => $this->inventoryObj->zone_id,
                'sku_status_id' => $this->inventoryObj->sku_status_id,
                'expiration_date' => $this->unique_date,
                'reference_no' => $this->unique_tag,
                    ), $c);
        } else {

            $inv = Inventory::model()->findAllByAttributes(
                    array(
                'company_id' => Yii::app()->user->company_id,
                'sku_id' => $this->inventoryObj->sku_id,
                'uom_id' => $this->inventoryObj->uom_id,
                'zone_id' => $this->inventoryObj->zone_id,
                'sku_status_id' => $this->inventoryObj->sku_status_id,
                'expiration_date' => $this->unique_date,
                'reference_no' => $this->unique_tag,
                    ), $c);
        }

        if (count($inv) > 1) {
            $created_date_arry = array();
            foreach ($inv as $k => $v) {
                $created_date_arry[$k] = $v['created_date'];
            }

            $tmp = array_keys($created_date_arry, min($created_date_arry));
            $key = $tmp[0];
        }
        
        $transaction = $this->inventoryObj->dbConnection->beginTransaction(); // Transaction begin

        try {

            $qty = $this->inventoryObj->qty - $this->qty;
            $this->inventoryObj->qty = $qty;
            $this->inventoryObj->save(false);

            if ($inv) {
                $inventory = $inv[$key];
                $item_exist = true;
                $inv_qty = $this->qty + $inventory->qty;
                InventoryHistory::model()->createHistory($inventory->company_id, $inventory->inventory_id, $inventory->transaction_date, $this->qty, $inv_qty, Inventory::INVENTORY_ACTION_TYPE_APPLY, $inventory->cost_per_unit, $this->created_by);
            } else {
                $inventory = new Inventory();
                $inv_qty = $this->qty;
            }

            $inventory_data = array(
                'sku_id' => $this->inventoryObj->sku_id,
                'company_id' => Yii::app()->user->company_id,
                'qty' => $inv_qty,
                'uom_id' => $this->inventoryObj->uom_id,
                'zone_id' => $this->inventoryObj->zone_id,
                'sku_status_id' => $this->inventoryObj->sku_status_id,
                'transaction_date' => $this->transaction_date,
                'expiration_date' => $this->unique_date,
                'reference_no' => $this->unique_tag,
            );

            $inventory->attributes = $inventory_data;

            if ($inventory->save(false)) {

                if ($item_exist == false) {
                    InventoryHistory::model()->createHistory($inventory->company_id, $inventory->inventory_id, $inventory->transaction_date, $this->qty, $inv_qty, Inventory::INVENTORY_ACTION_TYPE_APPLY, $inventory->cost_per_unit, $this->created_by);
                }
            }

            InventoryHistory::model()->createHistory($this->inventoryObj->company_id, $this->inventoryObj->inventory_id, $this->transaction_date, "-" . $this->qty, $qty, Inventory::INVENTORY_ACTION_TYPE_APPLY, $this->cost_per_unit, $this->created_by);

            $transaction->commit();

            return true;
        } catch (Exception $exc) {
            pr($exc);
            Yii::log($exc->getTraceAsString(), 'error');
            $transaction->rollBack();
            return false;
        }

        return false;
    }

}
