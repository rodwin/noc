<?php

/**
 * This is the model class for table "return_mdse_detail".
 *
 * The followings are the available columns in table 'return_mdse_detail':
 * @property integer $return_mdse_detail_id
 * @property integer $return_mdse_id
 * @property string $company_id
 * @property string $batch_no
 * @property string $sku_id
 * @property string $uom_id
 * @property string $sku_status_id
 * @property string $source_zone_id
 * @property string $unit_price
 * @property string $expiration_date
 * @property integer $returned_quantity
 * @property string $amount
 * @property string $remarks
 * @property string $pr_no
 * @property string $pr_date
 * @property string $plan_arrival_date
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property string $po_no
 *
 * The followings are the available model relations:
 * @property ReturnMdse $returnMdse
 */
class ReturnMdseDetail extends CActiveRecord {

    public $search_string;
    public $inventory_on_hand;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'return_mdse_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, sku_id, uom_id, returned_quantity, amount', 'required'),
            array('return_mdse_id, returned_quantity, inventory_id', 'numerical', 'integerOnly' => true),
            array('company_id, batch_no, sku_id, uom_id, sku_status_id, source_zone_id, pr_no, created_by, updated_by, po_no', 'length', 'max' => 50),
            array('unit_price, amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('expiration_date, pr_date, plan_arrival_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('return_mdse_detail_id, return_mdse_id, company_id, batch_no, sku_id, uom_id, sku_status_id, source_zone_id, unit_price, expiration_date, returned_quantity, amount, remarks, pr_no, pr_date, plan_arrival_date, created_date, created_by, updated_date, updated_by, po_no, inventory_id', 'safe', 'on' => 'search'),
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
            'returnMdse' => array(self::BELONGS_TO, 'ReturnMdse', 'return_mdse_id'),
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
            'return_mdse_detail_id' => 'Return Mdse Detail',
            'return_mdse_id' => 'Return Mdse',
            'company_id' => 'Company',
            'batch_no' => 'Batch No',
            'sku_id' => 'Sku',
            'uom_id' => 'Uom',
            'sku_status_id' => 'Sku Status',
            'source_zone_id' => 'Source Zone',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'returned_quantity' => 'Returned Quantity',
            'amount' => 'Amount',
            'remarks' => 'Remarks',
            'pr_no' => 'Pr No',
            'pr_date' => 'Pr Date',
            'plan_arrival_date' => 'Plan Arrival Date',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'po_no' => 'Po No',
            'inventory_id' => 'Inventory ID'
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

        $criteria->compare('return_mdse_detail_id', $this->return_mdse_detail_id);
        $criteria->compare('return_mdse_id', $this->return_mdse_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('batch_no', $this->batch_no, true);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('sku_status_id', $this->sku_status_id, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('returned_quantity', $this->returned_quantity);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('po_no', $this->po_no, true);
        $criteria->compare('inventory_id', $this->inventory_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'return_mdse_detail_id';
                break;

            case 1:
                $sort_column = 'return_mdse_id';
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
                $sort_column = 'sku_status_id';
                break;

            case 6:
                $sort_column = 'source_zone_id';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('return_mdse_detail_id', $columns[0]['search']['value']);
        $criteria->compare('return_mdse_id', $columns[1]['search']['value']);
        $criteria->compare('batch_no', $columns[2]['search']['value'], true);
        $criteria->compare('sku_id', $columns[3]['search']['value'], true);
        $criteria->compare('uom_id', $columns[4]['search']['value'], true);
        $criteria->compare('sku_status_id', $columns[5]['search']['value'], true);
        $criteria->compare('source_zone_id', $columns[6]['search']['value'], true);
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
     * @return ReturnMdseDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createReturnMdseTransactionDetails($return_mdse_id, $company_id, $transaction_details, $transaction_date, $created_by) {

        $inventory = Inventory::model()->findByAttributes(array("inventory_id" => $transaction_details['inventory_id'], "company_id" => $company_id));
        
        $retur_mdse_detail = new ReturnMdseDetail;
        $retur_mdse_detail->return_mdse_id = $return_mdse_id;
        $retur_mdse_detail->company_id = $company_id;
        $retur_mdse_detail->inventory_id = $transaction_details['inventory_id'];
        $retur_mdse_detail->batch_no = $transaction_details['batch_no'];
        $retur_mdse_detail->sku_id = $transaction_details['sku_id'];
        $retur_mdse_detail->uom_id = $transaction_details['uom_id'];
        $retur_mdse_detail->sku_status_id = (trim($transaction_details['sku_status_id']) != "" ? $transaction_details['sku_status_id'] : null);
        $retur_mdse_detail->source_zone_id = $transaction_details['source_zone_id'];
        $retur_mdse_detail->unit_price = (trim($transaction_details['unit_price']) != "" ? $transaction_details['unit_price'] : 0);
        $retur_mdse_detail->expiration_date = (trim($transaction_details['expiration_date']) != "" ? $transaction_details['expiration_date'] : null);
        $retur_mdse_detail->returned_quantity = $transaction_details['returned_quantity'];
        $retur_mdse_detail->amount = $transaction_details['amount'];
        $retur_mdse_detail->remarks = $transaction_details['remarks'];
        $retur_mdse_detail->created_by = $created_by;
        $retur_mdse_detail->po_no = $inventory->po_no;
        $retur_mdse_detail->pr_no = $inventory->pr_no;
        $retur_mdse_detail->pr_date = $inventory->pr_date;
        $retur_mdse_detail->plan_arrival_date = $inventory->plan_arrival_date;

        if ($retur_mdse_detail->save(false)) {
            OutgoingInventoryDetail::model()->decreaseInventory($inventory->inventory_id, $retur_mdse_detail->returned_quantity, $transaction_date, $retur_mdse_detail->unit_price, $retur_mdse_detail->created_by, $retur_mdse_detail->remarks);
            
            return $retur_mdse_detail;
        } else {
            return $retur_mdse_detail->getErrors();
        }
    }

}
