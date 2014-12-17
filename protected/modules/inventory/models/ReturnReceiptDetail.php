<?php

/**
 * This is the model class for table "return_receipt_detail".
 *
 * The followings are the available columns in table 'return_receipt_detail':
 * @property integer $return_receipt_detail_id
 * @property integer $return_receipt_id
 * @property string $company_id
 * @property string $batch_no
 * @property string $sku_id
 * @property string $uom_id
 * @property string $sku_status_id
 * @property string $unit_price
 * @property string $expiration_date
 * @property integer $quantity_issued
 * @property integer $returned_quantity
 * @property string $amount
 * @property string $status
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
 * @property ReturnReceipt $returnReceipt
 */
class ReturnReceiptDetail extends CActiveRecord {

    public $search_string;
    public $inventory_on_hand;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'return_receipt_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('return_receipt_id, company_id, sku_id, uom_id, returned_quantity', 'required'),
            array('return_receipt_id, quantity_issued, returned_quantity', 'numerical', 'integerOnly' => true),
            array('company_id, batch_no, sku_id, uom_id, sku_status_id, status, pr_no, created_by, updated_by, po_no', 'length', 'max' => 50),
            array('unit_price, amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('expiration_date, pr_date, plan_arrival_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('return_receipt_detail_id, return_receipt_id, company_id, batch_no, sku_id, uom_id, sku_status_id, unit_price, expiration_date, quantity_issued, returned_quantity, amount, status, remarks, pr_no, pr_date, plan_arrival_date, created_date, created_by, updated_date, updated_by, po_no', 'safe', 'on' => 'search'),
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
            'returnReceipt' => array(self::BELONGS_TO, 'ReturnReceipt', 'return_receipt_id'),
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
            'return_receipt_detail_id' => 'Return Receipt Detail',
            'return_receipt_id' => 'Return Receipt',
            'company_id' => 'Company',
            'batch_no' => 'Batch No',
            'sku_id' => 'Sku',
            'uom_id' => 'Uom',
            'sku_status_id' => 'Sku Status',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'quantity_issued' => 'Quantity Issued',
            'returned_quantity' => 'Returned Quantity',
            'amount' => 'Amount',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'pr_no' => 'Pr No',
            'pr_date' => 'Pr Date',
            'plan_arrival_date' => 'Plan Arrival Date',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'po_no' => 'Po No',
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

        $criteria->compare('return_receipt_detail_id', $this->return_receipt_detail_id);
        $criteria->compare('return_receipt_id', $this->return_receipt_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('batch_no', $this->batch_no, true);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('sku_status_id', $this->sku_status_id, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('quantity_issued', $this->quantity_issued);
        $criteria->compare('returned_quantity', $this->returned_quantity);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('po_no', $this->po_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'return_receipt_detail_id';
                break;

            case 1:
                $sort_column = 'return_receipt_id';
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
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('return_receipt_detail_id', $columns[0]['search']['value']);
        $criteria->compare('return_receipt_id', $columns[1]['search']['value']);
        $criteria->compare('batch_no', $columns[2]['search']['value'], true);
        $criteria->compare('sku_id', $columns[3]['search']['value'], true);
        $criteria->compare('uom_id', $columns[4]['search']['value'], true);
        $criteria->compare('sku_status_id', $columns[5]['search']['value'], true);
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
     * @return ReturnReceiptDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createReturnReceiptTransactionDetails($return_receipt_id, $company_id, $transaction_details, $zone_id, $transaction_date, $created_by) {

        $exp_date = ($transaction_details['expiration_date'] != "" ? $transaction_details['expiration_date'] : null);
        $sku_status_id = ($transaction_details['sku_status_id'] != "" ? $transaction_details['sku_status_id'] : null);
//        $plan_arrival_date = ($transaction_details['plan_arrival_date'] != "" ? $transaction_details['plan_arrival_date'] : null);
//        $pr_date = ($transaction_details['pr_date'] != "" ? $transaction_details['pr_date'] : null);
        
        $return_receipt_detail = new ReturnReceiptDetail;
        $return_receipt_detail->return_receipt_id = $return_receipt_id;
        $return_receipt_detail->company_id = $company_id;
        $return_receipt_detail->batch_no = $transaction_details['batch_no'];
        $return_receipt_detail->sku_id = $transaction_details['sku_id'];
        $return_receipt_detail->uom_id = $transaction_details['uom_id'];
        $return_receipt_detail->unit_price = $transaction_details['unit_price'] != "" ? $transaction_details['unit_price'] : "";
        $return_receipt_detail->expiration_date = $exp_date;
        $return_receipt_detail->quantity_issued = $transaction_details['quantity_issued'];
        $return_receipt_detail->returned_quantity = $transaction_details['returned_quantity'] != "" ? $transaction_details['returned_quantity'] : 0;
        $return_receipt_detail->amount = $transaction_details['amount'];
        $return_receipt_detail->status = $sku_status_id;
        $return_receipt_detail->remarks = $transaction_details['remarks'];
        $return_receipt_detail->created_by = $created_by;
//        $return_receipt_detail->po_no = $transaction_details['po_no'];
//        $return_receipt_detail->pr_no = $transaction_details['pr_no'];
//        $return_receipt_detail->pr_date = $pr_date;
//        $return_receipt_detail->plan_arrival_date = $plan_arrival_date;
        
        if ($return_receipt_detail->save(false)) {

            ReceivingInventoryDetail::model()->createInventory($return_receipt_detail->company_id, $return_receipt_detail->sku_id, $return_receipt_detail->uom_id, $return_receipt_detail->unit_price, $return_receipt_detail->returned_quantity, $zone_id, $transaction_date, $return_receipt_detail->created_by, $return_receipt_detail->expiration_date, $return_receipt_detail->batch_no, $sku_status_id, $return_receipt_detail->pr_no, $return_receipt_detail->pr_date, $return_receipt_detail->plan_arrival_date, $return_receipt_detail->po_no, $return_receipt_detail->remarks);
        } else {
            return $return_receipt_detail->getErrors();
        }
    }

}
