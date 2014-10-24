<?php

/**
 * This is the model class for table "customer_item_detail".
 *
 * The followings are the available columns in table 'customer_item_detail':
 * @property integer $customer_item_detail_id
 * @property integer $customer_item_id
 * @property string $company_id
 * @property integer $inventory_id
 * @property string $batch_no
 * @property string $sku_id
 * @property string $uom_id
 * @property string $sku_status_id
 * @property string $source_zone_id
 * @property string $unit_price
 * @property string $expiration_date
 * @property integer $planned_quantity
 * @property integer $quantity_issued
 * @property string $amount
 * @property integer $inventory_on_hand
 * @property string $return_date
 * @property string $remarks
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property CustomerItem $customerItem
 */
class CustomerItemDetail extends CActiveRecord {

    public $search_string;
    public $inventory_on_hand;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'customer_item_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, sku_id, uom_id, quantity_issued, amount', 'required'),
            array('customer_item_id, inventory_id, planned_quantity, quantity_issued', 'numerical', 'integerOnly' => true),
            array('company_id, batch_no, sku_id, uom_id, sku_status_id, source_zone_id, created_by, updated_by, status', 'length', 'max' => 50),
            array('unit_price, amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('source_zone_id', 'isValidZone'),
            array('unit_price, amount', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
            array('expiration_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('expiration_date, return_date, created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('customer_item_detail_id, customer_item_id, company_id, inventory_id, batch_no, sku_id, uom_id, sku_status_id, source_zone_id, unit_price, expiration_date, planned_quantity, quantity_issued, amount, return_date, status, remarks, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function isValidZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Zone is invalid.');
        }

        return;
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customerItem' => array(self::BELONGS_TO, 'CustomerItem', 'customer_item_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'source_zone_id'),
            'sku' => array(self::BELONGS_TO, 'Sku', 'sku_id'),
            'uom' => array(self::BELONGS_TO, 'Uom', 'uom_id'),
            'skuStatus' => array(self::BELONGS_TO, 'SkuStatus', 'sku_status_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'customer_item_detail_id' => 'Customer Item Detail',
            'customer_item_id' => 'Customer Item',
            'company_id' => 'Company',
            'inventory_id' => 'Inventory',
            'batch_no' => 'Batch No',
            'sku_id' => 'Sku',
            'uom_id' => 'Uom',
            'sku_status_id' => Sku::SKU_LABEL . ' Status',
            'source_zone_id' => 'Source Zone',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'planned_quantity' => 'Planned Quantity',
            'quantity_issued' => 'Quantity Issued',
            'amount' => 'Amount',
//            'inventory_on_hand' => 'Inventory On Hand',
            'return_date' => 'Return Date',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'campaign_no' => 'Campaign No',
            'pr_no' => 'PR No',
            'pr_date' => 'PR Date',
            'plan_arrival_date' => 'Plan Arrival Date',
            'revised_delivery_date' => 'Revised Delivery Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('customer_item_detail_id', $this->customer_item_detail_id);
        $criteria->compare('customer_item_id', $this->customer_item_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('batch_no', $this->batch_no, true);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('sku_status_id', $this->sku_status_id, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('planned_quantity', $this->planned_quantity);
        $criteria->compare('quantity_issued', $this->quantity_issued);
        $criteria->compare('amount', $this->amount, true);
//        $criteria->compare('inventory_on_hand', $this->inventory_on_hand);
        $criteria->compare('return_date', $this->return_date, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'customer_item_detail_id';
                break;

            case 1:
                $sort_column = 'customer_item_id';
                break;

            case 2:
                $sort_column = 'inventory_id';
                break;

            case 3:
                $sort_column = 'batch_no';
                break;

            case 4:
                $sort_column = 'sku_id';
                break;

            case 5:
                $sort_column = 'uom_id';
                break;

            case 6:
                $sort_column = 'sku_status_id';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('customer_item_detail_id', $columns[0]['search']['value']);
        $criteria->compare('customer_item_id', $columns[1]['search']['value']);
        $criteria->compare('inventory_id', $columns[2]['search']['value']);
        $criteria->compare('batch_no', $columns[3]['search']['value'], true);
        $criteria->compare('sku_id', $columns[4]['search']['value'], true);
        $criteria->compare('uom_id', $columns[5]['search']['value'], true);
        $criteria->compare('sku_status_id', $columns[6]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CustomerItemDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createCustomerItemTransactionDetails($customer_item_id, $company_id, $inventory_id, $batch_no, $sku_id, $source_zone_id, $unit_price, $expiration_date, $planned_quantity, $quantity_issued, $amount, $return_date, $remarks, $created_by = null, $uom_id, $sku_status_id, $transaction_date) {

        $inventory = Inventory::model()->findByAttributes(array("inventory_id" => $inventory_id, "company_id" => $company_id));

        $ret_date = ($return_date != "" ? $return_date : null);
        $exp_date = ($expiration_date != "" ? $expiration_date : null);
        $cost_per_unit = (isset($unit_price) ? $unit_price : 0);

        $customer_item_transaction_detail = new CustomerItemDetail;
        $customer_item_transaction_detail->customer_item_id = $customer_item_id;
        $customer_item_transaction_detail->company_id = $company_id;
        $customer_item_transaction_detail->inventory_id = $inventory_id;
        $customer_item_transaction_detail->batch_no = $batch_no;
        $customer_item_transaction_detail->sku_id = $sku_id;
        $customer_item_transaction_detail->uom_id = $uom_id;
        $customer_item_transaction_detail->sku_status_id = $sku_status_id;
        $customer_item_transaction_detail->source_zone_id = $source_zone_id;
        $customer_item_transaction_detail->unit_price = $cost_per_unit;
        $customer_item_transaction_detail->expiration_date = $exp_date;
        $customer_item_transaction_detail->planned_quantity = $planned_quantity;
        $customer_item_transaction_detail->quantity_issued = $quantity_issued != "" ? $quantity_issued : 0;
        $customer_item_transaction_detail->amount = $amount;
//        $customer_item_transaction_detail->inventory_on_hand = $inventory_on_hand;
        $customer_item_transaction_detail->return_date = $ret_date;
        $customer_item_transaction_detail->status = OutgoingInventory::OUTGOING_PENDING_STATUS;
        ;
        $customer_item_transaction_detail->remarks = $remarks;
        $customer_item_transaction_detail->created_by = $created_by;
        $customer_item_transaction_detail->campaign_no = $inventory->campaign_no;
        $customer_item_transaction_detail->pr_no = $inventory->pr_no;
        $customer_item_transaction_detail->pr_date = $inventory->pr_date;
        $customer_item_transaction_detail->plan_arrival_date = $inventory->plan_arrival_date;
        $customer_item_transaction_detail->revised_delivery_date = $inventory->revised_delivery_date;

        if ($customer_item_transaction_detail->save(false)) {
            $this->decreaseInventory($customer_item_transaction_detail->inventory_id, $customer_item_transaction_detail->quantity_issued, $transaction_date, $customer_item_transaction_detail->unit_price, $customer_item_transaction_detail->created_by);
        } else {
            return $customer_item_transaction_detail->getErrors();
        }
    }

    public function decreaseInventory($inventory_id, $quantity_issued, $transaction_date, $cost_per_unit, $created_by) {

        $inventory = Inventory::model()->findByPk($inventory_id);

        $decrease_inventory = new DecreaseInventoryForm();
        $decrease_inventory->qty = $quantity_issued;
        $decrease_inventory->transaction_date = $transaction_date;
        $decrease_inventory->cost_per_unit = $cost_per_unit;
        $decrease_inventory->created_by = $created_by;
        $decrease_inventory->inventoryObj = $inventory;

        if ($decrease_inventory->decrease(false)) {
            return true;
        } else {
            return $decrease_inventory->getErrors();
        }
    }

}
