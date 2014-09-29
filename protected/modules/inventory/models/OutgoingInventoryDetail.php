<?php

/**
 * This is the model class for table "outgoing_inventory_detail".
 *
 * The followings are the available columns in table 'outgoing_inventory_detail':
 * @property integer $outgoing_inventory_detail_id
 * @property integer $outgoing_inventory_id
 * @property string $company_id
 * @property string $batch_no
 * @property string $sku_id
 * @property string $source_zone_id
 * @property string $unit_price
 * @property string $expiration_date
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
 * @property OutgoingInventory $outgoingInventory
 */
class OutgoingInventoryDetail extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'outgoing_inventory_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, inventory_id, sku_id, source_zone_id, quantity_issued, amount', 'required'),
            array('outgoing_inventory_id, inventory_id, planned_quantity, quantity_issued, inventory_on_hand', 'numerical', 'integerOnly' => true),
            array('company_id, batch_no, sku_id, source_zone_id, status, created_by, updated_by', 'length', 'max' => 50),
            array('unit_price, amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('unit_price, amount', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
            array('expiration_date, return_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('expiration_date, return_date, created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('outgoing_inventory_detail_id, outgoing_inventory_id, company_id, batch_no, sku_id, source_zone_id, unit_price, expiration_date, quantity_issued, amount, inventory_on_hand, return_date, status, remarks, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
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
            'outgoingInventory' => array(self::BELONGS_TO, 'OutgoingInventory', 'outgoing_inventory_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'source_zone_id'),
            'sku' => array(self::BELONGS_TO, 'Sku', 'sku_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'outgoing_inventory_detail_id' => 'Outgoing Inventory Detail',
            'outgoing_inventory_id' => 'Outgoing Inventory',
            'company_id' => 'Company',
            'inventory_id' => 'Inventory',
            'batch_no' => 'Batch No',
            'sku_id' => 'Sku',
            'source_zone_id' => 'Source Zone',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'planned_quantity' => 'Planned Quantity',
            'quantity_issued' => 'Actual Quantity',
            'amount' => 'Amount',
            'inventory_on_hand' => 'Inventory On Hand',
            'return_date' => 'Return Date',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
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

        $criteria->compare('outgoing_inventory_detail_id', $this->outgoing_inventory_detail_id);
        $criteria->compare('outgoing_inventory_id', $this->outgoing_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('batch_no', $this->batch_no, true);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('planned_quantity', $this->planned_quantity);
        $criteria->compare('quantity_issued', $this->quantity_issued);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('inventory_on_hand', $this->inventory_on_hand);
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
                $sort_column = 'outgoing_inventory_detail_id';
                break;

            case 1:
                $sort_column = 'outgoing_inventory_id';
                break;

            case 2:
                $sort_column = 'batch_no';
                break;

            case 3:
                $sort_column = 'sku_id';
                break;

            case 4:
                $sort_column = 'source_zone_id';
                break;

            case 5:
                $sort_column = 'unit_price';
                break;

            case 6:
                $sort_column = 'expiration_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('outgoing_inventory_detail_id', $columns[0]['search']['value']);
        $criteria->compare('outgoing_inventory_id', $columns[1]['search']['value']);
        $criteria->compare('batch_no', $columns[2]['search']['value'], true);
        $criteria->compare('sku_id', $columns[3]['search']['value'], true);
        $criteria->compare('source_zone_id', $columns[4]['search']['value'], true);
        $criteria->compare('unit_price', $columns[5]['search']['value'], true);
        $criteria->compare('expiration_date', $columns[6]['search']['value'], true);
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
     * @return OutgoingInventoryDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createOutgoingTransactionDetails($outgoing_inventory_id, $company_id, $inventory_id, $batch_no, $sku_id, $source_zone_id, $unit_price, $expiration_date, $planned_quantity, $quantity_issued, $amount, $inventory_on_hand, $return_date, $remarks, $created_by = null) {

        $outgoing_transaction_detail = new OutgoingInventoryDetail;
        $outgoing_transaction_detail->outgoing_inventory_id = $outgoing_inventory_id;
        $outgoing_transaction_detail->company_id = $company_id;
        $outgoing_transaction_detail->inventory_id = $inventory_id;
        $outgoing_transaction_detail->batch_no = $batch_no;
        $outgoing_transaction_detail->sku_id = $sku_id;
        $outgoing_transaction_detail->source_zone_id = $source_zone_id;
        $outgoing_transaction_detail->unit_price = isset($unit_price) ? $unit_price : "";
        $outgoing_transaction_detail->expiration_date = $expiration_date != "" ? $expiration_date : null;
        $outgoing_transaction_detail->planned_quantity = $planned_quantity;
        $outgoing_transaction_detail->quantity_issued = $quantity_issued;
        $outgoing_transaction_detail->amount = $amount;
        $outgoing_transaction_detail->inventory_on_hand = $inventory_on_hand;
        $outgoing_transaction_detail->return_date = $return_date != "" ? $return_date : null;
        $outgoing_transaction_detail->status = OutgoingInventory::OUTGOING_PENDING_STATUS;
        $outgoing_transaction_detail->remarks = $remarks;
        $outgoing_transaction_detail->created_by = $created_by;

        if ($outgoing_transaction_detail->save(false)) {
            $qty = $outgoing_transaction_detail->inventory_on_hand - $outgoing_transaction_detail->quantity_issued;
            Inventory::model()->updateInvByInvID($outgoing_transaction_detail->inventory_id, $outgoing_transaction_detail->company_id, $qty);
        } else {
            return $outgoing_transaction_detail->getErrors();
        }
    }

}
