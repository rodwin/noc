<?php

/**
 * This is the model class for table "receiving_inventory_detail".
 *
 * The followings are the available columns in table 'receiving_inventory_detail':
 * @property integer $receiving_inventory_detail_id
 * @property integer $receiving_inventory_id
 * @property string $company_id
 * @property string $batch_no
 * @property string $sku_id
 * @property string $uom_id
 * @property string $unit_price
 * @property string $expiration_date
 * @property integer $planned_quantity
 * @property integer $quantity_received
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
 * @property ReceivingInventory $receivingInventory
 */
class ReceivingInventoryDetail extends CActiveRecord {

    public $search_string;
    public $inventory_on_hand;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'receiving_inventory_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, sku_id, uom_id, quantity_received, amount', 'required'),
            array('receiving_inventory_id, planned_quantity, quantity_received', 'numerical', 'integerOnly' => true),
            array('company_id, batch_no, sku_id, uom_id, sku_status_id, item_remarks, created_by, updated_by', 'length', 'max' => 50),
            array('unit_price, amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('unit_price, amount', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
            array('expiration_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('expiration_date, created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('receiving_inventory_detail_id, receiving_inventory_id, company_id, batch_no, sku_id, uom_id, unit_price, expiration_date, planned_quantity_received, quantity_received_received, amount, item_remarks, remarks, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
            'receivingInventory' => array(self::BELONGS_TO, 'ReceivingInventory', 'receiving_inventory_id'),
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
            'receiving_inventory_detail_id' => 'Receiving Inventory Detail',
            'receiving_inventory_id' => 'Receiving Inventory',
            'company_id' => 'Company',
            'batch_no' => 'Batch No',
            'sku_id' => 'Sku',
            'uom_id' => 'Uom',
            'sku_status_id' => Sku::SKU_LABEL . ' Status',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'planned_quantity' => 'Planned Quantity',
            'quantity_received' => 'Actual Quantity',
            'amount' => 'Amount',
//            'inventory_on_hand' => 'Inventory On Hand',
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

        $criteria->compare('receiving_inventory_detail_id', $this->receiving_inventory_detail_id);
        $criteria->compare('receiving_inventory_id', $this->receiving_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('batch_no', $this->batch_no, true);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('sku_status_id', $this->sku_status_id, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('planned_quantity', $this->planned_quantity);
        $criteria->compare('quantity_received', $this->quantity_received);
        $criteria->compare('amount', $this->amount, true);
//        $criteria->compare('inventory_on_hand', $this->inventory_on_hand);
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

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'receiving_inventory_detail_id';
                break;

            case 1:
                $sort_column = 'receiving_inventory_id';
                break;

            case 2:
                $sort_column = 'batch_no';
                break;

            case 3:
                $sort_column = 'sku_id';
                break;

            case 4:
                $sort_column = 'uom_id';
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
        $criteria->compare('receiving_inventory_detail_id', $columns[0]['search']['value']);
        $criteria->compare('receiving_inventory_id', $columns[1]['search']['value']);
        $criteria->compare('batch_no', $columns[2]['search']['value'], true);
        $criteria->compare('sku_id', $columns[3]['search']['value'], true);
        $criteria->compare('uom_id', $columns[4]['search']['value'], true);
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
     * @return ReceivingInventoryDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createReceivingTransactionDetails($receiving_inventory_id, $company_id, $sku_id, $uom_id, $status_id, $zone_id, $batch_no, $unit_price, $transaction_date, $expiration_date, $planned_quantity, $quantity_received, $amount, $remarks, $pr_no, $pr_date, $created_by = null, $pr_no, $pr_date, $plan_arrival_date, $po_no) {

        $exp_date = ($expiration_date != "" ? $expiration_date : null);
        $sku_status_id = ($status_id != "" ? $status_id : null);

        $receiving_transaction_detail = new ReceivingInventoryDetail;
        $receiving_transaction_detail->receiving_inventory_id = $receiving_inventory_id;
        $receiving_transaction_detail->company_id = $company_id;
        $receiving_transaction_detail->sku_id = $sku_id;
        $receiving_transaction_detail->uom_id = $uom_id;
        $receiving_transaction_detail->sku_status_id = $sku_status_id;
        $receiving_transaction_detail->batch_no = $batch_no;
        $receiving_transaction_detail->unit_price = $unit_price;
        $receiving_transaction_detail->expiration_date = $exp_date;
        $receiving_transaction_detail->planned_quantity = $planned_quantity;
        $receiving_transaction_detail->quantity_received = $quantity_received;
        $receiving_transaction_detail->amount = $amount;
//        $receiving_transaction_detail->inventory_on_hand = $inventory_on_hand + $quantity_received;
        $receiving_transaction_detail->remarks = $remarks;
        $receiving_transaction_detail->created_by = $created_by;

        if ($receiving_transaction_detail->save(false)) {
            $this->createInventory($company_id, $sku_id, $uom_id, $unit_price, $quantity_received, $zone_id, $transaction_date, $created_by, $exp_date, $batch_no, $receiving_transaction_detail->sku_status_id, $pr_no, $pr_date, $plan_arrival_date, $po_no);
        } else {
            return $receiving_transaction_detail->getErrors();
        }
    }

    public function createInventory($company_id, $sku_id, $uom_id, $unit_price, $quantity_received, $zone_id, $transaction_date, $created_by, $expiration_date, $reference_no, $status_id, $pr_no, $pr_date, $plan_arrival_date, $po_no) {

        $sku = Sku::model()->findByAttributes(array("company_id" => $company_id, "sku_id" => $sku_id));

        $plan_arr_date = ($plan_arrival_date != "" ? $plan_arrival_date : null);
//        $rev_del_date = ($revised_delivery_date != "" ? $revised_delivery_date : null);

        $create_inventory = new CreateInventoryForm();
        $create_inventory->company_id = $company_id;
        $create_inventory->sku_code = isset($sku->sku_code) ? $sku->sku_code : null;
        $create_inventory->sku_id = $sku_id;
        $create_inventory->qty = $quantity_received;
        $create_inventory->default_uom_id = $uom_id;
        $create_inventory->default_zone_id = $zone_id;
        $create_inventory->transaction_date = $transaction_date;
        $create_inventory->cost_per_unit = $unit_price;
        $create_inventory->sku_status_id = $status_id;
        $create_inventory->unique_tag = $reference_no;
        $create_inventory->unique_date = $expiration_date;
        $create_inventory->created_by = $created_by;
        $create_inventory->po_no = $po_no;
        $create_inventory->pr_no = $pr_no;
        $create_inventory->pr_date = $pr_date;
        $create_inventory->plan_arrival_date = $plan_arr_date;
//        $create_inventory->revised_delivery_date = $rev_del_date;

        if ($create_inventory->create(false)) {
            return true;
        } else {
            return $create_inventory->getErrors();
        }
    }

}
