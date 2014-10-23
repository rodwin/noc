<?php

/**
 * This is the model class for table "receiving_inventory".
 *
 * The followings are the available columns in table 'receiving_inventory':
 * @property integer $receiving_inventory_id
 * @property string $company_id
 * @property string $campaign_no
 * @property string $pr_no
 * @property string $pr_date
 * @property string $dr_no
 * @property string $requestor
 * @property string $supplier_id
 * @property string $zone_id
 * @property string $plan_delivery_date
 * @property string $revised_delivery_date
 * @property string $actual_delivery_date
 * @property string $plan_arrival_date
 * @property string $transaction_date
 * @property string $delivery_remarks
 * @property string $total_amount
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property ReceivingInventoryDetail[] $receivingInventoryDetails
 */
class ReceivingInventory extends CActiveRecord {

    public $search_string;
    public $total_quantity;

    const RECEIVING_LABEL = "Incoming";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'receiving_inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, campaign_no, pr_no, pr_date, requestor, dr_no, sales_office_id, transaction_date', 'required'),
            array('company_id, campaign_no, pr_no, dr_no, requestor, supplier_id, sales_office_id, zone_id, delivery_remarks, created_by, updated_by', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('pr_date, plan_delivery_date, revised_delivery_date, plan_arrival_date, transaction_date, dr_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('zone_id', 'isValidZone'),
            array('supplier_id', 'isValidSupplier'),
            array('plan_delivery_date, revised_delivery_date, plan_arrival_date, created_date, updated_date, dr_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('receiving_inventory_id, company_id, campaign_no, pr_no, pr_date, dr_no, dr_date, requestor, supplier_id, sales_office_id, zone_id, plan_delivery_date, revised_delivery_date, plan_arrival_date, transaction_date, delivery_remarks, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function isValidZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Zone from the auto-complete.');
        }

        return;
    }

    public function isValidSupplier($attribute) {
        $model = Supplier::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Supplier from the auto-complete.');
        }

        return;
    }

    public function beforeValidate() {

        if ($this->plan_delivery_date == "") {
            $this->plan_delivery_date = null;
        }
        if ($this->revised_delivery_date == "") {
            $this->revised_delivery_date = null;
        }
//        if ($this->actual_delivery_date == "") {
//            $this->actual_delivery_date = null;
//        }        
        if ($this->plan_arrival_date == "") {
            $this->plan_arrival_date = null;
        }      
        if ($this->dr_date == "") {
            $this->dr_date = null;
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
            'receivingInventoryDetails' => array(self::HAS_MANY, 'ReceivingInventoryDetail', 'receiving_inventory_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
            'employee' => array(self::BELONGS_TO, 'Employee', 'requestor'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'receiving_inventory_id' => 'Receiving Inventory',
            'company_id' => 'Company',
            'campaign_no' => 'Campaign No',
            'pr_no' => 'PR No',
            'pr_date' => 'PR Date',
            'dr_no' => 'DR No',
            'dr_date' => 'DR Date',
            'requestor' => 'Requestor',
            'supplier_id' => 'Supplier',
            'sales_office_id' => 'Sales Office',
            'zone_id' => 'Destination Zone',
            'plan_delivery_date' => 'Plan Delivery Date',
            'revised_delivery_date' => 'Revised Delivery Date',
//            'actual_delivery_date' => 'Actual Delivery Date',
            'plan_arrival_date' => 'Plan Arrival Date To SO',
            'transaction_date' => 'Transaction Date',
            'delivery_remarks' => 'Delivery Remarks',
            'total_amount' => 'Total Amount',
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

        $criteria->compare('receiving_inventory_id', $this->receiving_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('campaign_no', $this->campaign_no, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('dr_date', $this->dr_date, true);
        $criteria->compare('requestor', $this->requestor, true);
        $criteria->compare('supplier_id', $this->supplier_id, true);
        $criteria->compare('sales_office_id', $this->sales_office_id, true);
        $criteria->compare('zone_id', $this->zone_id, true);
        $criteria->compare('plan_delivery_date', $this->plan_delivery_date, true);
        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
//        $criteria->compare('actual_delivery_date', $this->actual_delivery_date, true);
        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('delivery_remarks', $this->delivery_remarks, true);
        $criteria->compare('total_amount', $this->total_amount, true);
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
                $sort_column = 't.campaign_no';
                break;

            case 1:
                $sort_column = 't.pr_no';
                break;

            case 2:
                $sort_column = 't.pr_date';
                break;

            case 3:
                $sort_column = 't.dr_no';
                break;

            case 4:
                $sort_column = 't.requestor';
                break;

            case 5:
                $sort_column = 'supplier.supplier_name';
                break;

            case 6:
                $sort_column = 'zone.zone_name';
                break;

            case 7:
                $sort_column = 't.total_amount';
                break;

            case 8:
                $sort_column = 't.created_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.campaign_no', $columns[0]['search']['value'], true);
        $criteria->compare('t.pr_no', $columns[1]['search']['value'], true);
        $criteria->compare('t.pr_date', $columns[2]['search']['value'], true);
        $criteria->compare('t.dr_no', $columns[3]['search']['value'], true);
        $criteria->compare('t.requestor', $columns[4]['search']['value'], true);
        $criteria->compare('supplier.supplier_name', $columns[5]['search']['value'], true);
        $criteria->compare('zone.zone_name', $columns[6]['search']['value'], true);
        $criteria->compare('t.total_amount', $columns[7]['search']['value'], true);
        $criteria->compare('t.created_date', $columns[8]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array("supplier", "employee", "zone");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ReceivingInventory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function skuData($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 't.sku_code';
                break;

            case 1:
                $sort_column = 't.description';
                break;

            case 2:
                $sort_column = 'brand.brand_name';
                break;

            case 4:
                $sort_column = 't.type';
                break;

            case 5:
                $sort_column = 't.sub_type';
                break;

            case 6:
                $sort_column = 't.default_unit_price';
                break;
        }

        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.sku_code', $columns[0]['search']['value'], true);
        $criteria->compare('t.description', $columns[1]['search']['value'], true);
        $criteria->compare('brand.brand_name', $columns[2]['search']['value'], true);
        $criteria->compare('t.type', $columns[4]['search']['value'], true);
        $criteria->compare('t.sub_type', $columns[5]['search']['value'], true);
        $criteria->compare('t.default_unit_price', $columns[6]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array('brand', 'company', 'defaultUom', 'defaultZone');

        return new CActiveDataProvider("Sku", array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function create($transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $receiving_inventory = new ReceivingInventory;

        try {

            $receiving_inventory_data = array(
                'company_id' => $this->company_id,
                'campaign_no' => $this->campaign_no,
                'pr_no' => $this->pr_no,
                'pr_date' => $this->pr_date,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->transaction_date,
                'requestor' => $this->requestor,
                'supplier_id' => $this->supplier_id,
                'sales_office_id' => $this->sales_office_id,
                'zone_id' => $this->zone_id,
                'plan_delivery_date' => $this->plan_delivery_date,
                'revised_delivery_date' => $this->revised_delivery_date,
//                'actual_delivery_date' => $this->actual_delivery_date,
                'plan_arrival_date' => $this->plan_arrival_date,
                'transaction_date' => $this->transaction_date,
                'delivery_remarks' => $this->delivery_remarks,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $receiving_inventory->attributes = $receiving_inventory_data;

            if (count($transaction_details) > 0) {
                if ($receiving_inventory->save(false)) {
                    unset(Yii::app()->session['tid']);
                    Yii::app()->session['tid'] = $receiving_inventory->receiving_inventory_id; //julius code
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        ReceivingInventoryDetail::model()->createReceivingTransactionDetails($receiving_inventory->receiving_inventory_id, $receiving_inventory->company_id, $transaction_details[$i]['sku_id'], $transaction_details[$i]['uom_id'], $transaction_details[$i]['sku_status_id'], $receiving_inventory->zone_id, $transaction_details[$i]['batch_no'], $transaction_details[$i]['unit_price'], $receiving_inventory->transaction_date, $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['qty_received'], $transaction_details[$i]['amount'], $transaction_details[$i]['remarks'], $receiving_inventory->pr_no, $receiving_inventory->pr_date, $receiving_inventory->created_by, $receiving_inventory->campaign_no, $receiving_inventory->pr_no, $receiving_inventory->pr_date, $receiving_inventory->plan_arrival_date, $receiving_inventory->revised_delivery_date);
                    }
                }
                return true;
            } else {
                return false;
            }

            return true;
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
            return false;
        }
    }

    public function getDeliveryRemarks() {
        return array(
            array('id' => "ON TIME", 'title' => "ON TIME"),
            array('id' => "DELAY", 'title' => "DELAY"),
            array('id' => "ADVANCE", 'title' => "ADVANCE"),
        );
    }

}
