<?php

/**
 * This is the model class for table "incoming_inventory_detail".
 *
 * The followings are the available columns in table 'incoming_inventory_detail':
 * @property integer $incoming_inventory_detail_id
 * @property integer $incoming_inventory_id
 * @property string $company_id
 * @property string $batch_no
 * @property string $sku_id
 * @property string $unit_price
 * @property string $expiration_date
 * @property integer $planned_quantity_received
 * @property integer $quantity_received_received
 * @property string $amount
 * @property integer $inventory_on_hand
 * @property string $item_remarks
 * @property string $remarks
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property IncomingInventory $incomingInventory
 */
class IncomingInventoryDetail extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'incoming_inventory_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, sku_id, uom_id, quantity_received, amount, batch_no', 'required'),
            array('incoming_inventory_id, planned_quantity, quantity_received, inventory_on_hand', 'numerical', 'integerOnly' => true),
            array('company_id, batch_no, sku_id, uom_id, item_remarks, created_by, updated_by', 'length', 'max' => 50),
            array('unit_price, amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('unit_price, amount', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
            array('expiration_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('expiration_date, created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('incoming_inventory_detail_id, incoming_inventory_id, company_id, batch_no, sku_id, uom_id, unit_price, expiration_date, planned_quantity_received, quantity_received_received, amount, inventory_on_hand, item_remarks, remarks, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate() {

        if ($this->amount == "") {
            $this->amount = 0;
        }

        return parent::beforeValidate();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'incomingInventory' => array(self::BELONGS_TO, 'IncomingInventory', 'incoming_inventory_id'),
            'sku' => array(self::BELONGS_TO, 'Sku', 'sku_id'),
            'uom' => array(self::BELONGS_TO, 'Uom', 'uom_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'incoming_inventory_detail_id' => 'Incoming Inventory Detail',
            'incoming_inventory_id' => 'Incoming Inventory',
            'company_id' => 'Company',
            'batch_no' => 'Batch No',
            'sku_id' => 'Sku',
            'uom_id' => 'Unit of Measure',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'planned_quantity' => 'Planned Quantity',
            'quantity_received' => 'Quantity Received',
            'amount' => 'Amount',
            'inventory_on_hand' => 'Inventory On Hand',
            'item_remarks' => 'Item Remarks',
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

        $criteria->compare('incoming_inventory_detail_id', $this->incoming_inventory_detail_id);
        $criteria->compare('incoming_inventory_id', $this->incoming_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('batch_no', $this->batch_no, true);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('planned_quantity_received', $this->planned_quantity_received);
        $criteria->compare('quantity_received_received', $this->quantity_received_received);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('inventory_on_hand', $this->inventory_on_hand);
        $criteria->compare('item_remarks', $this->item_remarks, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns, $incoming_inv_id) {
        switch ($col) {

            case 0:
                $sort_column = 'incoming_inventory_detail_id';
                break;

            case 1:
                $sort_column = 'incoming_inventory_id';
                break;

            case 2:
                $sort_column = 'batch_no';
                break;

            case 3:
                $sort_column = 'sku_id';
                break;

            case 4:
                $sort_column = 'unit_price';
                break;

            case 5:
                $sort_column = 'expiration_date';
                break;

            case 6:
                $sort_column = 'quantity_received';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare("incoming_inventory_id", $incoming_inv_id);
        $criteria->compare('incoming_inventory_detail_id', $columns[0]['search']['value']);
        $criteria->compare('incoming_inventory_id', $columns[1]['search']['value']);
        $criteria->compare('batch_no', $columns[2]['search']['value'], true);
        $criteria->compare('sku_id', $columns[3]['search']['value'], true);
        $criteria->compare('unit_price', $columns[4]['search']['value'], true);
        $criteria->compare('expiration_date', $columns[5]['search']['value'], true);
        $criteria->compare('planned_quantity_received', $columns[6]['search']['value']);
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
     * @return IncomingInventoryDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createIncomingTransactionDetails($incoming_inventory_id, $company_id, $sku_id, $uom_id, $zone_id, $batch_no, $unit_price, $transaction_date, $expiration_date, $quantity_received, $amount, $inventory_on_hand, $remarks, $pr_no, $pr_date, $created_by = null) {

        $incoming_transaction_detail = new IncomingInventoryDetail;
        $incoming_transaction_detail->incoming_inventory_id = $incoming_inventory_id;
        $incoming_transaction_detail->company_id = $company_id;
        $incoming_transaction_detail->sku_id = $sku_id;
        $incoming_transaction_detail->uom_id = $uom_id;
        $incoming_transaction_detail->batch_no = $batch_no;
        $incoming_transaction_detail->unit_price = isset($unit_price) ? $unit_price : "";
        $incoming_transaction_detail->expiration_date = $expiration_date != "" ? $expiration_date : null;
        $incoming_transaction_detail->quantity_received = $quantity_received;
        $incoming_transaction_detail->amount = isset($amount) ? $amount : "";
        $incoming_transaction_detail->inventory_on_hand = $inventory_on_hand + $quantity_received;
        $incoming_transaction_detail->remarks = $remarks;
        $incoming_transaction_detail->created_by = $created_by;

        if ($incoming_transaction_detail->save(false)) {
            IncomingInventoryDetail::model()->createInventory($company_id, $sku_id, $uom_id, $unit_price, $quantity_received, $zone_id, $transaction_date, $created_by, $expiration_date, $pr_no);
        } else {
            return $incoming_transaction_detail->getErrors();
        }
    }

    public function createInventory($company_id, $sku_id, $uom_id, $unit_price, $quantity_received, $zone_id, $transaction_date, $created_by, $expiration_date, $reference_no) {


        $sku = Sku::model()->findByAttributes(array("company_id" => $company_id, "sku_id" => $sku_id));

        $create_inventory = new CreateInventoryForm();
        $create_inventory->company_id = $company_id;
        $create_inventory->sku_code = isset($sku->sku_code) ? $sku->sku_code : null;
        $create_inventory->sku_id = $sku_id;
        $create_inventory->qty = $quantity_received;
        $create_inventory->default_uom_id = $uom_id;
        $create_inventory->default_zone_id = $zone_id;
        $create_inventory->transaction_date = $transaction_date;
        $create_inventory->cost_per_unit = $unit_price;
        $create_inventory->sku_status_id = null;
        $create_inventory->unique_tag = $reference_no;
        $create_inventory->unique_date = $expiration_date != "" ? $expiration_date : null;
        $create_inventory->created_by = $created_by;

        if ($create_inventory->create(false)) {
            return true;
        } else {
            return $create_inventory->getErrors();
        }
    }

}
