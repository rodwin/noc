<?php

/**
 * This is the model class for table "moving_inventory_detail".
 *
 * The followings are the available columns in table 'moving_inventory_detail':
 * @property integer $moving_inventory_detail_id
 * @property integer $moving_inventory_id
 * @property string $company_id
 * @property string $batch_no
 * @property string $sku_id
 * @property string $source_zone_id
 * @property string $destination_zone_id
 * @property string $unit_price
 * @property string $expiration_date
 * @property integer $quantity
 * @property string $amount
 * @property integer $inventory_on_hand
 * @property string $remarks
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property MovingInventory $movingInventory
 */
class MovingInventoryDetail extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'moving_inventory_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('inventory_id, company_id, pr_no, batch_no, sku_id, source_zone_id, destination_zone_id, quantity, amount', 'required'),
            array('moving_inventory_id, inventory_id, quantity, inventory_on_hand', 'numerical', 'integerOnly' => true),
            array('company_id, batch_no, sku_id, source_zone_id, destination_zone_id, created_by, updated_by', 'length', 'max' => 50),
            array('unit_price, amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('pr_no', 'length', 'max' => 10),
            array('destination_zone_id', 'isValidDestinationZone'),
            array('unit_price, amount', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
            array('expiration_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('moving_inventory_detail_id, moving_inventory_id, inventory_id, company_id, pr_no, batch_no, sku_id, source_zone_id, destination_zone_id, unit_price, expiration_date, quantity, amount, inventory_on_hand, remarks, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function isValidDestinationZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Zone from the auto-complete.');
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
            'movingInventory' => array(self::BELONGS_TO, 'MovingInventory', 'moving_inventory_id'),
            'sourceZone' => array(self::BELONGS_TO, 'Zone', 'source_zone_id'),
            'destinationZone' => array(self::BELONGS_TO, 'Zone', 'destination_zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'moving_inventory_detail_id' => 'Moving Inventory Detail',
            'moving_inventory_id' => 'Moving Inventory',
            'inventory_id' => 'Inventory',
            'company_id' => 'Company',
            'pr_no' => 'PR No',
            'batch_no' => 'Batch No',
            'sku_id' => 'Sku',
            'source_zone_id' => 'Source Zone',
            'destination_zone_id' => 'Destination Zone',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
            'inventory_on_hand' => 'Inventory On Hand',
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

        $criteria->compare('moving_inventory_detail_id', $this->moving_inventory_detail_id);
        $criteria->compare('moving_inventory_id', $this->moving_inventory_id);
        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('batch_no', $this->batch_no, true);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('destination_zone_id', $this->destination_zone_id, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('inventory_on_hand', $this->inventory_on_hand);
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
                $sort_column = 'moving_inventory_detail_id';
                break;

            case 1:
                $sort_column = 'moving_inventory_id';
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
                $sort_column = 'destination_zone_id';
                break;

            case 6:
                $sort_column = 'unit_price';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('moving_inventory_detail_id', $columns[0]['search']['value']);
        $criteria->compare('moving_inventory_id', $columns[1]['search']['value']);
        $criteria->compare('batch_no', $columns[2]['search']['value'], true);
        $criteria->compare('sku_id', $columns[3]['search']['value'], true);
        $criteria->compare('source_zone_id', $columns[4]['search']['value'], true);
        $criteria->compare('destination_zone_id', $columns[5]['search']['value'], true);
        $criteria->compare('unit_price', $columns[6]['search']['value'], true);
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
     * @return MovingInventoryDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createMovingTransactionDetails($moving_inventory_id, $company_id, $sku_id, $source_zone_id, $destination_zone_id, $batch_no, $unit_price, $transaction_date, $expiration_date, $quantity, $amount, $inventory_on_hand, $remarks, $reference_no, $created_by = null, $inventory_id) {

        $moving_transaction_detail = new MovingInventoryDetail;
        $moving_transaction_detail->moving_inventory_id = $moving_inventory_id;
        $moving_transaction_detail->company_id = $company_id;
        $moving_transaction_detail->pr_no = $reference_no;
        $moving_transaction_detail->sku_id = $sku_id;
        $moving_transaction_detail->batch_no = $batch_no;
        $moving_transaction_detail->source_zone_id = $source_zone_id;
        $moving_transaction_detail->destination_zone_id = $destination_zone_id;
        $moving_transaction_detail->unit_price = $unit_price != "" ? $unit_price : null;
        $moving_transaction_detail->expiration_date = $expiration_date != "" ? $expiration_date : null;
        $moving_transaction_detail->quantity = $quantity;
        $moving_transaction_detail->amount = isset($amount) ? $amount : "";
        $moving_transaction_detail->inventory_on_hand = $inventory_on_hand + $quantity;
        $moving_transaction_detail->remarks = $remarks;
        $moving_transaction_detail->created_by = $created_by;

        if ($moving_transaction_detail->save(false)) {
            MovingInventoryDetail::model()->createInventory($company_id, $sku_id, $unit_price, $quantity, $source_zone_id, $destination_zone_id, $transaction_date, $created_by, $expiration_date, $reference_no, $inventory_id);
        } else {
            return $moving_transaction_detail->getErrors();
        }
    }

    public function createInventory($company_id, $sku_id, $unit_price, $quantity, $source_zone_id, $destination_zone_id, $transaction_date, $created_by, $expiration_date, $reference_no, $inventory_id) {

        $inventory = Inventory::model()->findByAttributes(array("company_id" => $company_id, "inventory_id" => $inventory_id));

        $move_inventory = new MoveInventoryForm;
        $move_inventory->qty = $quantity;
        $move_inventory->transaction_date = $transaction_date;
        $move_inventory->cost_per_unit = $unit_price != "" ? $unit_price : null;
        $move_inventory->created_by = $created_by;
        $move_inventory->zone_id = $destination_zone_id;
        $move_inventory->status_id = null;
        $move_inventory->inventoryObj = $inventory;

        if ($move_inventory->move(false)) {
            return true;
        } else {
            return $move_inventory->getErrors();
        }
    }

}
