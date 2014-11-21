<?php

class CreateInventoryForm extends CFormModel {

    /**
     * @var string company_id
     * @soap
     */
    public $company_id;

    /**
     * @var string sku_code
     * @soap
     */
    public $sku_code;

    /**
     * @var string sku_id
     * @soap
     */
    public $sku_id;

    /**
     * @var int qty
     * @soap
     */
    public $qty;

    /**
     * @var string default_uom_id
     * @soap
     */
    public $default_uom_id;

    /**
     * @var string default_zone_id
     * @soap
     */
    public $default_zone_id;

    /**
     * @var date transaction_date
     * @soap
     */
    public $transaction_date;

    /**
     * @var double cost_per_unit
     * @soap
     */
    public $cost_per_unit;

    /**
     * @var string sku_status_id
     * @soap
     */
    public $sku_status_id;

    /**
     * @var string unique_tag
     * @soap
     */
    public $unique_tag;

    /**
     * @var date unique_date
     * @soap
     */
    public $unique_date;

    /**
     * @var string created_by
     * @soap
     */
    public $created_by;
    public $campaign_no;
    public $pr_no;
    public $pr_date;
    public $plan_arrival_date;
    public $revised_delivery_date;
    public $po_no;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('created_by,sku_code,company_id,qty,default_uom_id,default_zone_id,transaction_date', 'required'),
            array('unique_tag', 'length', 'max' => 150),
            array('campaign_no, pr_no', 'length', 'max' => 50),
            array('sku_code', 'isValidSku'),
            array('default_uom_id', 'isValidUOM'),
            array('default_zone_id', 'isValidZone'),
            array('sku_status_id', 'isValidStatus'),
            array('cost_per_unit', 'length', 'max' => 18),
            array('cost_per_unit', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,3})?$/'),
            array('unique_date,transaction_date, pr_date, plan_arrival_date, revised_delivery_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date.', 'dateFormat' => 'yyyy-MM-dd'),
            array('qty', 'numerical', 'integerOnly' => true, 'max' => 9999999, 'min' => 0),
        );
    }

    public function isValidSku($attribute) {
        $model = Sku::model()->findByAttributes(array('sku_code' => $this->$attribute, 'company_id' => $this->company_id));

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Sku not found.');
        } else {
            $this->sku_id = $model->sku_id;
        }

        return;
    }

    public function isValidStatus($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = SkuStatus::model()->findbypk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Status is invalid.');
        }

        return;
    }

    public function isValidZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Zone is invalid.');
        }

        return;
    }

    public function isValidUOM($attribute) {
        $model = Uom::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'UOM is invalid.');
        }

        return;
    }

    public function beforeValidate() {

        if ($this->default_uom_id == "") {
            $this->default_uom_id = null;
        }
        if ($this->default_zone_id == "") {
            $this->default_zone_id = null;
        }
        if ($this->cost_per_unit == "") {
            $this->cost_per_unit = 0;
        }
        if ($this->sku_status_id == "") {
            $this->sku_status_id = null;
        }
        if ($this->qty == "") {
            $this->qty = 0;
        }
        if ($this->unique_date == "") {
            $this->unique_date = null;
        }
        if ($this->campaign_no == "") {
            $this->campaign_no = "";
        }
        if ($this->pr_no == "") {
            $this->pr_no = "";
        }
        if ($this->pr_date == "") {
            $this->pr_date = null;
        }
        if ($this->plan_arrival_date == "") {
            $this->plan_arrival_date = null;
        }
        if ($this->revised_delivery_date == "") {
            $this->revised_delivery_date = null;
        }

        return parent::beforeValidate();
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'sku_code' => 'Sku Code',
            'qty' => 'Quantity',
            'default_uom_id' => 'Unit of Measure',
            'default_zone_id' => 'Zone',
            'transaction_date' => 'Transaction Date',
            'cost_per_unit' => 'Cost per Unit',
            'sku_status_id' => 'Status',
            'unique_tag' => 'Unique Tag',
            'campaign_no' => 'Campaign No',
            'pr_no' => 'PR No',
            'pr_date' => 'PR Date',
            'plan_arrival_date' => 'Plan Arrival Date',
            'revised_delivery_date' => 'Revised Delivery Date',
        );
    }

    public function create($validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $qty = 0;

        $inventoryObj = Inventory::model()->findByAttributes(
                array(
                    'company_id' => $this->company_id,
                    'sku_id' => $this->sku_id,
                    'uom_id' => $this->default_uom_id,
                    'zone_id' => $this->default_zone_id,
                    'sku_status_id' => $this->sku_status_id,
                    'expiration_date' => $this->unique_date,
                    'po_no' => $this->po_no,
                    'pr_no' => $this->pr_no,
                    'pr_date' => $this->pr_date,
                    'plan_arrival_date' => $this->plan_arrival_date,
//                    'revised_delivery_date' => $this->revised_delivery_date,
                )
        );

        if ($inventoryObj) {
            $inventory = $inventoryObj;
            $qty = $this->qty + $inventory->qty;
        } else {
            $inventory = new Inventory();
            $qty = $this->qty;
        }

        $transaction = $inventory->dbConnection->beginTransaction(); // Transaction begin

        try {

            $inventory_data = array(
                'sku_id' => $this->sku_id,
                'company_id' => $this->company_id,
                'qty' => $qty,
                'uom_id' => $this->default_uom_id,
                'zone_id' => $this->default_zone_id,
                'sku_status_id' => $this->sku_status_id,
                'transaction_date' => $this->transaction_date,
                'expiration_date' => $this->unique_date,
                'reference_no' => $this->unique_tag,
                'po_no' => $this->po_no,
                'pr_no' => $this->pr_no,
                'pr_date' => $this->pr_date,
                'plan_arrival_date' => $this->plan_arrival_date,
//                'revised_delivery_date' => $this->revised_delivery_date,
            );

            $inventory->attributes = $inventory_data;

            $inventory->save(false);

            InventoryHistory::model()->createHistory($this->company_id, $inventory->inventory_id, $this->transaction_date, $this->qty, $qty, Inventory::INVENTORY_ACTION_TYPE_INCREASE, $this->cost_per_unit, $this->created_by, $this->default_zone_id);

            $transaction->commit();
            return true;
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
            $transaction->rollBack();
            return false;
        }
    }

}
