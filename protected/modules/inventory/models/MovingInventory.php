<?php

/**
 * This is the model class for table "moving_inventory".
 *
 * The followings are the available columns in table 'moving_inventory':
 * @property integer $moving_inventory_id
 * @property string $company_id
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
 * @property MovingInventoryDetail[] $movingInventoryDetails
 */
class MovingInventory extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'moving_inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, transaction_date', 'required'),
            array('company_id, created_by, updated_by', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('transaction_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('moving_inventory_id, company_id, transaction_date, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
            'movingInventoryDetails' => array(self::HAS_MANY, 'MovingInventoryDetail', 'moving_inventory_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'moving_inventory_id' => 'Moving Inventory',
            'company_id' => 'Company',
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

        $criteria->compare('moving_inventory_id', $this->moving_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
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
                $sort_column = 'transaction_date';
                break;

            case 1:
                $sort_column = 'total_amount';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('transaction_date', $columns[0]['search']['value'], true);
        $criteria->compare('total_amount', $columns[1]['search']['value'], true);
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
     * @return MovingInventory the static model class
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

        $moving_inventory = new MovingInventory;

        try {

            $moving_inventory_data = array(
                'company_id' => $this->company_id,
                'transaction_date' => $this->transaction_date,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $moving_inventory->attributes = $moving_inventory_data;

            if (count($transaction_details) > 0) {
                if ($moving_inventory->save(false)) {

                    for ($i = 0; $i < count($transaction_details); $i++) {
                        MovingInventoryDetail::model()->createMovingTransactionDetails($moving_inventory->moving_inventory_id, $moving_inventory->company_id, $transaction_details[$i]['sku_id'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['destination_zone_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['unit_price'], $moving_inventory->transaction_date, $transaction_details[$i]['expiration_date'], $transaction_details[$i]['quantity'], $transaction_details[$i]['amount'], $transaction_details[$i]['inventory_on_hand'], $transaction_details[$i]['remarks'], $transaction_details[$i]['pr_no'], $moving_inventory->created_by, $transaction_details[$i]['inventory_id']);
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
