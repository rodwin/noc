<?php

/**
 * This is the model class for table "return_receipt".
 *
 * The followings are the available columns in table 'return_receipt':
 * @property integer $return_receipt_id
 * @property string $company_id
 * @property string $return_receipt_no
 * @property string $receive_return_from
 * @property string $receive_return_from_id
 * @property string $reference_dr_no
 * @property string $transaction_date
 * @property string $date_returned
 * @property string $destination_zone_id
 * @property string $remarks
 * @property string $total_amount
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property ReturnReceiptDetail[] $returnReceiptDetails
 */
class ReturnReceipt extends CActiveRecord {

    public $search_string;

    const RETURN_RECEIPT_LABEL = "RETURN RECEIPT";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'return_receipt';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, return_receipt_no, receive_return_from, transaction_date, destination_zone_id', 'required'),
            array('company_id, return_receipt_no, receive_return_from, receive_return_from_id, reference_dr_no, destination_zone_id, created_by, updated_by', 'length', 'max' => 50),
            array('remarks', 'length', 'max' => 150),
            array('total_amount', 'length', 'max' => 18),
            array('return_receipt_no', 'uniqueRRNo'),
            array('transaction_date, date_returned, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('return_receipt_id, company_id, return_receipt_no, receive_return_from, receive_return_from_id, reference_dr_no, transaction_date, date_returned, destination_zone_id, remarks, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueRRNo($attribute, $params) {

        $model = ReturnReceipt::model()->findByAttributes(array('company_id' => $this->company_id, 'return_receipt_no' => $this->$attribute));
        if ($model && $model->return_receipt_id != $this->return_receipt_id) {
            $this->addError($attribute, 'Return Rceipt Number selected already taken');
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
            'returnReceiptDetails' => array(self::HAS_MANY, 'ReturnReceiptDetail', 'return_receipt_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'destination_zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'return_receipt_id' => 'Return Receipt',
            'company_id' => 'Company',
            'return_receipt_no' => 'Return Receipt No',
            'receive_return_from' => 'Receive Return From',
            'receive_return_from_id' => 'Receive Return From',
            'reference_dr_no' => 'Reference DR No',
            'transaction_date' => 'Transaction Date',
            'date_returned' => 'Date Returned',
            'destination_zone_id' => 'Destination Zone',
            'remarks' => 'Remarks',
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

        $criteria->compare('return_receipt_id', $this->return_receipt_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('return_receipt_no', $this->return_receipt_no, true);
        $criteria->compare('receive_return_from', $this->receive_return_from, true);
        $criteria->compare('receive_return_from_id', $this->receive_return_from_id, true);
        $criteria->compare('reference_dr_no', $this->reference_dr_no, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('date_returned', $this->date_returned, true);
        $criteria->compare('destination_zone_id', $this->destination_zone_id, true);
        $criteria->compare('remarks', $this->remarks, true);
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
                $sort_column = 'return_receipt_no';
                break;

            case 1:
                $sort_column = 'transaction_date';
                break;

            case 2:
                $sort_column = 'receive_return_from';
                break;

//            case 3:
//                $sort_column = 'receive_return_from_id';
//                break;
//
//            case 4:
//                $sort_column = 'reference_dr_no';
//                break;

            case 5:
                $sort_column = 'total_amount';
                break;

            case 6:
                $sort_column = 'remarks';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('return_receipt_no', $columns[0]['search']['value']);
        $criteria->compare('transaction_date', $columns[1]['search']['value'], true);
        $criteria->compare('receive_return_from', $columns[2]['search']['value'], true);
        $criteria->compare('receive_return_from_id', $columns[3]['search']['value']);
        $criteria->compare('reference_dr_no', $columns[4]['search']['value']);
        $criteria->compare('total_amount', $columns[5]['search']['value'], true);
        $criteria->compare('remarks', $columns[6]['search']['value'], true);
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
     * @return ReturnReceipt the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createReturnReceipt($transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }
        
        $data = array();
        $data['success'] = false;

        $return_receipt = new ReturnReceipt;

        try {

            $return_receipt_data = array(
                'company_id' => $this->company_id,
                'return_receipt_no' => $this->return_receipt_no,
                'receive_return_from' => $this->receive_return_from,
                'receive_return_from_id' => $this->receive_return_from_id,
                'reference_dr_no' => $this->reference_dr_no,
                'transaction_date' => $this->transaction_date,
                'date_returned' => $this->date_returned,
                'destination_zone_id' => $this->destination_zone_id,
                'remarks' => $this->remarks,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $return_receipt->attributes = $return_receipt_data;

            if (count($transaction_details) > 0) {
                if ($return_receipt->save(false)) {

                    $return_receipt_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        $return_receipt_detail = ReturnReceiptDetail::model()->createReturnReceiptTransactionDetails($return_receipt->return_receipt_id, $return_receipt->company_id, $transaction_details[$i], $return_receipt->destination_zone_id, $return_receipt->transaction_date, $return_receipt->created_by);
                    
                        $return_receipt_details[] = $return_receipt_detail;
                    }

                    $data['success'] = true;
                    $data['header_data'] = $return_receipt;
                    $data['detail_data'] = $return_receipt_details;
                }
            }
        } catch (Exception $exc) {
            pr($exc);
            Yii::log($exc->getTraceAsString(), 'error');
        }
        
        return $data;
    }

}
