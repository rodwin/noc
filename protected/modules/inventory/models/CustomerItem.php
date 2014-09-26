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
            array('company_id, name, dr_no, source_zone_id, poi_id, transaction_date', 'required'),
            array('company_id, name, pr_no, dr_no, source_zone_id, poi_id, created_by, updated_by', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('source_zone_id', 'isValidZone'),
            array('transaction_date, plan_delivery_date, revised_delivery_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('plan_delivery_date, revised_delivery_date, created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('customer_item_id, company_id, name, pr_no, dr_no, source_zone_id, poi_id, transaction_date, plan_delivery_date, revised_delivery_date, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
            'customerItemDetails' => array(self::HAS_MANY, 'CustomerItemDetail', 'customer_item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'customer_item_id' => 'Customer Item',
            'company_id' => 'Company',
            'name' => 'Name',
            'pr_no' => 'Pr No',
            'dr_no' => 'Dr No',
            'source_zone_id' => 'Source Zone',
            'poi_id' => 'Poi',
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

        $criteria->compare('customer_item_id', $this->customer_item_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('poi_id', $this->poi_id, true);
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
                $sort_column = 'customer_item_id';
                break;

            case 1:
                $sort_column = 'name';
                break;

            case 2:
                $sort_column = 'pr_no';
                break;

            case 3:
                $sort_column = 'dr_no';
                break;

            case 4:
                $sort_column = 'source_zone_id';
                break;

            case 5:
                $sort_column = 'poi_id';
                break;

            case 6:
                $sort_column = 'transaction_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('customer_item_id', $columns[0]['search']['value']);
        $criteria->compare('name', $columns[1]['search']['value'], true);
        $criteria->compare('pr_no', $columns[2]['search']['value'], true);
        $criteria->compare('dr_no', $columns[3]['search']['value'], true);
        $criteria->compare('source_zone_id', $columns[4]['search']['value'], true);
        $criteria->compare('poi_id', $columns[5]['search']['value'], true);
        $criteria->compare('transaction_date', $columns[6]['search']['value'], true);
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
     * @return CustomerItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
