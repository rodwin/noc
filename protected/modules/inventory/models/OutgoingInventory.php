<?php

/**
 * This is the model class for table "outgoing_inventory".
 *
 * The followings are the available columns in table 'outgoing_inventory':
 * @property integer $outgoing_inventory_id
 * @property string $company_id
 * @property integer $rra_no
 * @property string $rra_name
 * @property string $destination_zone_id
 * @property string $contact_person
 * @property string $contact_no
 * @property string $address
 * @property string $campaign_no
 * @property string $pr_no
 * @property string $pr_date
 * @property string $plan_delivery_date
 * @property string $revised_delivery_date
 * @property string $actual_delivery_date
 * @property string $plan_arrival_date
 * @property string $transaction_date
 * @property string $total_amount
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property OutgoingInventoryDetail[] $outgoingInventoryDetails
 */
class OutgoingInventory extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'outgoing_inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, rra_no, rra_name, dr_no, destination_zone_id, campaign_no, pr_no, pr_date, transaction_date', 'required'),
            array('company_id, campaign_no, rra_no, pr_no, dr_no, rra_name, destination_zone_id, contact_person, contact_no, created_by, updated_by', 'length', 'max' => 50),
            array('address', 'length', 'max' => 200),
            array('total_amount', 'length', 'max' => 18),
            array('destination_zone_id', 'isValidZone'),
            array('pr_date, transaction_date, plan_delivery_date, revised_delivery_date, actual_delivery_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('pr_date, plan_delivery_date, revised_delivery_date, actual_delivery_date, plan_arrival_date, transaction_date, created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('outgoing_inventory_id, company_id, rra_no, rra_name, dr_no, destination_zone_id, contact_person, contact_no, address, campaign_no, pr_no, pr_date, plan_delivery_date, revised_delivery_date, actual_delivery_date, plan_arrival_date, transaction_date, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function isValidZone($attribute) {
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
            'outgoingInventoryDetails' => array(self::HAS_MANY, 'OutgoingInventoryDetail', 'outgoing_inventory_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'destination_zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'outgoing_inventory_id' => 'Outgoing Inventory',
            'company_id' => 'Company',
            'rra_no' => 'RRA No',
            'rra_name' => 'RRA Name',
            'dr_no' => 'DR No',
            'destination_zone_id' => 'Destination Zone',
            'contact_person' => 'Contact Person',
            'contact_no' => 'Contact No',
            'address' => 'Address',
            'campaign_no' => 'Campaign No',
            'pr_no' => 'PR No',
            'pr_date' => 'PR Date',
            'plan_delivery_date' => 'Plan Delivery Date',
            'revised_delivery_date' => 'Revised Delivery Date',
            'actual_delivery_date' => 'Actual Delivery Date',
            'plan_arrival_date' => 'Plan Arrival Date',
            'transaction_date' => 'Transaction Date',
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

        $criteria->compare('outgoing_inventory_id', $this->outgoing_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('rra_no', $this->rra_no);
        $criteria->compare('rra_name', $this->rra_name, true);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('destination_zone_id', $this->destination_zone_id, true);
        $criteria->compare('contact_person', $this->contact_person, true);
        $criteria->compare('contact_no', $this->contact_no, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('campaign_no', $this->campaign_no, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('plan_delivery_date', $this->plan_delivery_date, true);
        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
        $criteria->compare('actual_delivery_date', $this->actual_delivery_date, true);
        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
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
                $sort_column = 'rra_no';
                break;

            case 1:
                $sort_column = 'rra_name';
                break;

            case 2:
                $sort_column = 'rra_name';
                break;

            case 3:
                $sort_column = 'destination_zone_id';
                break;

            case 4:
                $sort_column = 'campaign_no';
                break;

            case 5:
                $sort_column = 'pr_no';
                break;

            case 6:
                $sort_column = 'contact_person';
                break;

            case 7:
                $sort_column = 'total_amount';
                break;

            case 8:
                $sort_column = 'created_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('rra_no', $columns[0]['search']['value']);
        $criteria->compare('rra_name', $columns[1]['search']['value'], true);
        $criteria->compare('dr_no', $columns[2]['search']['value'], true);
        $criteria->compare('destination_zone_id', $columns[3]['search']['value'], true);
        $criteria->compare('campaign_no', $columns[4]['search']['value'], true);
        $criteria->compare('pr_no', $columns[5]['search']['value'], true);
        $criteria->compare('contact_person', $columns[6]['search']['value'], true);
        $criteria->compare('total_amount', $columns[7]['search']['value'], true);
        $criteria->compare('created_date', $columns[8]['search']['value'], true);
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
     * @return OutgoingInventory the static model class
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

        $outgoing_inventory = new OutgoingInventory;

        try {

            $outgoing_inventory_data = array(
                'company_id' => $this->company_id,
                'rra_no' => $this->rra_no,
                'rra_name' => $this->rra_name,
                'dr_no' => $this->dr_no,
                'destination_zone_id' => $this->destination_zone_id,
                'contact_person' => $this->contact_person,
                'contact_no' => $this->contact_no,
                'address' => $this->address,
                'campaign_no' => $this->campaign_no,
                'pr_no' => $this->pr_no,
                'pr_date' => $this->pr_date,
                'plan_delivery_date' => $this->plan_delivery_date != "" ? $this->plan_delivery_date : null,
                'revised_delivery_date' => $this->revised_delivery_date != "" ? $this->revised_delivery_date : null,
                'actual_delivery_date' => $this->actual_delivery_date != "" ? $this->actual_delivery_date : null,
                'transaction_date' => $this->transaction_date,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $outgoing_inventory->attributes = $outgoing_inventory_data;

            if (count($transaction_details) > 0) {
                if ($outgoing_inventory->save(false)) {

                    for ($i = 0; $i < count($transaction_details); $i++) {
                        OutgoingInventoryDetail::model()->createOutgoingTransactionDetails($outgoing_inventory->outgoing_inventory_id, $outgoing_inventory->company_id, $transaction_details[$i]['inventory_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['sku_id'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['unit_price'], $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['quantity_issued'], $transaction_details[$i]['amount'], $transaction_details[$i]['inventory_on_hand'], $transaction_details[$i]['return_date'], $transaction_details[$i]['remarks'], $outgoing_inventory->created_by);
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

}
