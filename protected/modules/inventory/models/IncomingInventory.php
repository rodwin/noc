<?php

/**
 * This is the model class for table "incoming_inventory".
 *
 * The followings are the available columns in table 'incoming_inventory':
 * @property integer $incoming_inventory_id
 * @property string $company_id
 * @property string $campaign_no
 * @property string $pr_no
 * @property string $pr_date
 * @property string $dr_no
 * @property string $zone_id
 * @property string $transaction_date
 * @property string $total_amount
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 */
class IncomingInventory extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'incoming_inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, name, dr_no, pr_no, transaction_date', 'required'),
            array('company_id, campaign_no, pr_no, dr_no, name, zone_id, created_by, updated_by', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('zone_id', 'isValidZone'),
            array('transaction_date, plan_delivery_date, revised_delivery_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('pr_date, transaction_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('incoming_inventory_id, company_id, campaign_no, pr_no, pr_date, dr_no, zone_id, transaction_date, plan_delivery_date, revised_delivery_date, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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

        if ($this->plan_delivery_date == "") {
            $this->plan_delivery_date = null;
        }
        if ($this->revised_delivery_date == "") {
            $this->revised_delivery_date = null;
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
            'incomingInventoryDetails' => array(self::HAS_MANY, 'IncomingInventoryDetail', 'incoming_inventory_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'incoming_inventory_id' => 'Incoming Inventory',
            'company_id' => 'Company',
            'campaign_no' => 'Campaign No',
            'pr_no' => 'PR No',
            'pr_date' => 'PR Date',
            'name' => 'Name',
            'dr_no' => 'DR No',
            'zone_id' => 'Zone',
            'transaction_date' => 'Transaction Date',
            'plan_delivery_date' => 'Plan Delivery Date',
            'revised_delivery_date' => 'Revised Delivery Date',
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

        $criteria->compare('incoming_inventory_id', $this->incoming_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('campaign_no', $this->campaign_no, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('zone_id', $this->zone_id, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('plan_delivery_date', $this->plan_delivery_date, true);
        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
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
                $sort_column = 'zone.zone_name';
                break;

            case 5:
                $sort_column = 't.transaction_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.campaign_no', $columns[0]['search']['value'], true);
        $criteria->compare('t.pr_no', $columns[1]['search']['value'], true);
        $criteria->compare('t.pr_date', $columns[2]['search']['value'], true);
        $criteria->compare('t.dr_no', $columns[3]['search']['value'], true);
        $criteria->compare('zone.zone_name', $columns[4]['search']['value'], true);
        $criteria->compare('t.transaction_date', $columns[5]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array("zone");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return IncomingInventory the static model class
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

        $incoming_inventory = new IncomingInventory;

        try {

            $incoming_inventory_data = array(
                'company_id' => $this->company_id,
                'campaign_no' => $this->campaign_no,
                'pr_no' => $this->pr_no,
                'name' => $this->name,
                'dr_no' => $this->dr_no,
                'zone_id' => $this->zone_id,
                'transaction_date' => $this->transaction_date,
                'pr_date' => $this->pr_date,
                'plan_delivery_date' => $this->plan_delivery_date,
                'revised_delivery_date' => $this->revised_delivery_date,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $incoming_inventory->attributes = $incoming_inventory_data;

            if (count($transaction_details) > 0) {
                if ($incoming_inventory->save(false)) {

                    for ($i = 0; $i < count($transaction_details); $i++) {
                        pr($transaction_details[$i]);
//                        IncomingInventoryDetail::model()->createIncomingTransactionDetails($incoming_inventory->incoming_inventory_id, $incoming_inventory->company_id, $transaction_details[$i]['inventory_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['sku_id'], $transaction_details[$i]['unit_price'], $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['quantity_received'], $transaction_details[$i]['amount'], $transaction_details[$i]['inventory_on_hand'], $transaction_details[$i]['return_date'], $transaction_details[$i]['remarks'], $incoming_inventory->created_by);
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
