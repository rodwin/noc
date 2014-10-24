<?php

/**
 * This is the model class for table "customer_item".
 *
 * The followings are the available columns in table 'customer_item':
 * @property integer $customer_item_id
 * @property string $company_id
 * @property string $name
 * @property string $pr_no
 * @property string $dr_no
 * @property string $source_zone_id
 * @property string $poi_id
 * @property string $transaction_date
 * @property string $plan_delivery_date
 * @property string $revised_delivery_date
 * @property string $total_amount
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property CustomerItemDetail[] $customerItemDetails
 */
class CustomerItem extends CActiveRecord {

    public $search_string;
    public $total_quantity;

    const CUSTOMER_ITEM_LABEL = "Outgoing";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'customer_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, dr_no, transaction_date', 'required'),
            array('company_id, rra_no, dr_no, source_zone_id, poi_id, salesman_id, created_by, updated_by, status', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('source_zone_id', 'isValidZone'),
            array('salesman_id', 'isValidEmployee'),
            array('poi_id', 'isValidPoi'),
            array('transaction_date, plan_delivery_date, rra_date, dr_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('plan_delivery_date, rra_date, created_date, updated_date, dr_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('customer_item_id, company_id, rra_no, dr_no, dr_date, source_zone_id, poi_id, salesman_id, transaction_date, rra_date, plan_delivery_date, remarks, status, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function isValidZone($attribute) {
        $data = trim($this->$attribute);

        if ($data == null) {
            return;
        }

        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Zone is invalid.');
        }

        return;
    }

    public function isValidEmployee($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = Employee::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Employee is invalid.');
        }

        return;
    }

    public function isValidPoi($attribute) {
        $model = Poi::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Poi from the auto-complete.');
        }

        return;
    }

    public function beforeValidate() {

        if ($this->plan_delivery_date == "") {
            $this->plan_delivery_date = null;
        }
        if ($this->dr_date == "") {
            $this->dr_date = null;
        }
        if ($this->rra_date == "") {
            $this->rra_date = null;
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
            'customerItemDetails' => array(self::HAS_MANY, 'CustomerItemDetail', 'customer_item_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'source_zone_id'),
            'poi' => array(self::BELONGS_TO, 'Poi', 'poi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'customer_item_id' => 'Customer Item',
            'company_id' => 'Company',
            'rra_no' => 'RRA No',
            'rra_date' => 'RRA Date',
//            'campaign_no' => 'Campaign No',
//            'pr_no' => 'PR No',
//            'pr_date' => 'PR Date',
            'dr_no' => 'DR No',
            'dr_date' => 'DR Date',
//            'reference_dr_no' => 'Reference No',
            'source_zone_id' => 'Source Zone',
            'poi_id' => Poi::POI_LABEL,
            'salesman_id' => 'Salesman',
            'transaction_date' => 'Transaction Date',
            'plan_delivery_date' => 'Plan Delivery Date',
//            'revised_delivery_date' => 'Revised Delivery Date',
            'remarks' => 'Remarks',
            'status' => 'Status',
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

        $criteria->compare('customer_item_id', $this->customer_item_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('rra_no', $this->rra_no, true);
        $criteria->compare('rra_date', $this->rra_date, true);
//        $criteria->compare('campaign_no', $this->campaign_no, true);
//        $criteria->compare('pr_no', $this->pr_no, true);
//        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('dr_date', $this->dr_date, true);
//        $criteria->compare('reference_dr_no', $this->reference_dr_no, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('poi_id', $this->poi_id, true);
        $criteria->compare('salesman_id', $this->salesman_id, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('plan_delivery_date', $this->plan_delivery_date, true);
//        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('status', $this->status, true);
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
                $sort_column = 't.dr_no';
                break;

            case 1:
                $sort_column = 't.rra_no';
                break;

            case 2:
                $sort_column = 't.rra_date';
                break;

            case 3:
                $sort_column = 't.poi_id';
                break;

            case 4:
                $sort_column = 't.status';
                break;

            case 5:
                $sort_column = 't.total_amount';
                break;

            case 6:
                $sort_column = 't.created_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.dr_no', $columns[0]['search']['value'], true);
        $criteria->compare('t.rra_no', $columns[1]['search']['value'], true);
        $criteria->compare('t.rra_date', $columns[2]['search']['value'], true);
        $criteria->compare('poi.short_name', $columns[3]['search']['value'], true);
        $criteria->compare('t.status', $columns[4]['search']['value'], true);
        $criteria->compare('t.total_amount', $columns[5]['search']['value'], true);
        $criteria->compare('t.created_date', $columns[6]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array("zone", "poi");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CustomerItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function create($transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $customer_item = new CustomerItem;

        try {

            $customer_item_data = array(
                'company_id' => $this->company_id,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->transaction_date,
//                'reference_dr_no' => $this->reference_dr_no,
                'source_zone_id' => $this->source_zone_id,
                'poi_id' => $this->poi_id,
                'transaction_date' => $this->transaction_date,
//                'campaign_no' => $this->campaign_no,
//                'pr_date' => $this->pr_date,
                'plan_delivery_date' => $this->plan_delivery_date,
//                'revised_delivery_date' => $this->revised_delivery_date,
                'remarks' => $this->remarks,
                'status' => OutgoingInventory::OUTGOING_PENDING_STATUS,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $customer_item->attributes = $customer_item_data;

            if (count($transaction_details) > 0) {
                if ($customer_item->save(false)) {
                    unset(Yii::app()->session['tid']);
                    Yii::app()->session['tid'] = $customer_item->customer_item_id;
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        CustomerItemDetail::model()->createCustomerItemTransactionDetails($customer_item->customer_item_id, $customer_item->company_id, $transaction_details[$i]['inventory_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['sku_id'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['unit_price'], $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['quantity_issued'], $transaction_details[$i]['amount'], $transaction_details[$i]['return_date'], $transaction_details[$i]['remarks'], $customer_item->created_by, $transaction_details[$i]['uom_id'], $transaction_details[$i]['sku_status_id'], $customer_item->transaction_date);
                    }
                }
                return true;
            } else {
                return false;
            }

            return true;
        } catch (Exception $exc) {
            pr($exc);
            Yii::log($exc->getTraceAsString(), 'error');
            return false;
        }
    }

}
