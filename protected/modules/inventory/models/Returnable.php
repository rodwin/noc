<?php

/**
 * This is the model class for table "returnable".
 *
 * The followings are the available columns in table 'returnable':
 * @property integer $returnable_id
 * @property string $company_id
 * @property string $return_receipt_no
 * @property string $reference_dr_no
 * @property string $receive_return_from
 * @property string $receive_return_from_id
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
 * @property ReturnableDetail[] $returnableDetails
 */
class Returnable extends CActiveRecord {

    public $search_string;

    const RETURNABLE = "RETURNABLE";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'returnable';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, return_receipt_no, receive_return_from, transaction_date, date_returned, destination_zone_id', 'required'),
            array('company_id, return_receipt_no, reference_dr_no, receive_return_from, receive_return_from_id, destination_zone_id, created_by, updated_by', 'length', 'max' => 50),
            array('remarks', 'length', 'max' => 150),
            array('total_amount', 'length', 'max' => 18),
            array('transaction_date, date_returned, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('returnable_id, company_id, return_receipt_no, reference_dr_no, receive_return_from, receive_return_from_id, transaction_date, date_returned, destination_zone_id, remarks, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
            'returnableDetails' => array(self::HAS_MANY, 'ReturnableDetail', 'returnable_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'destination_zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'returnable_id' => 'Returnable',
            'company_id' => 'Company',
            'return_receipt_no' => 'Return Receipt No',
            'reference_dr_no' => 'Reference DR No',
            'receive_return_from' => 'Receive Return From',
            'receive_return_from_id' => 'Receive Return From',
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

        $criteria->compare('returnable_id', $this->returnable_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('return_receipt_no', $this->return_receipt_no, true);
        $criteria->compare('reference_dr_no', $this->reference_dr_no, true);
        $criteria->compare('receive_return_from', $this->receive_return_from, true);
        $criteria->compare('receive_return_from_id', $this->receive_return_from_id, true);
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
                $sort_column = 'returnable_id';
                break;

            case 1:
                $sort_column = 'return_type';
                break;

            case 2:
                $sort_column = 'return_receipt_no';
                break;

            case 3:
                $sort_column = 'reference_dr_no';
                break;

            case 4:
                $sort_column = 'receive_return_from';
                break;

            case 5:
                $sort_column = 'receive_return_from_id';
                break;

            case 6:
                $sort_column = 'transaction_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('returnable_id', $columns[0]['search']['value']);
        $criteria->compare('return_type', $columns[1]['search']['value'], true);
        $criteria->compare('return_receipt_no', $columns[2]['search']['value'], true);
        $criteria->compare('reference_dr_no', $columns[3]['search']['value'], true);
        $criteria->compare('receive_return_from', $columns[4]['search']['value'], true);
        $criteria->compare('receive_return_from_id', $columns[5]['search']['value'], true);
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
     * @return Returnable the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getListReturnFrom() {

        return array(
            array('value' => 'SALESOFFICE', 'title' => 'Salesoffice', 'id' => 'selected_salesoffice'),
            array('value' => 'SALESMAN', 'title' => 'Salesman', 'id' => 'selected_salesman'),
            array('value' => 'OUTLET', 'title' => 'Outlet', 'id' => 'selected_outlet'),
        );
    }

    public function getListReturnTo() {

        return array(
            array('value' => 'SALESOFFICE', 'title' => 'Salesoffice'),
            array('value' => 'SUPPLIER', 'title' => 'Supplier'),
        );
    }

    public function validateReturnFrom($model, $key, $return_label) {

        $source_arr = Returnable::model()->getListReturnFrom();
        $id = "";

        if ($key == $source_arr[0]['value']) {

            if ($_POST[$return_label . $source_arr[0]['id']] == "") {
                $model->addError($return_label . $source_arr[0]['id'], "Salesoffice cannot be blank.");
            } else {
                $id = $_POST[$return_label . $source_arr[0]['id']];
            }
        } else if ($key == $source_arr[1]['value']) {

            if ($_POST[$return_label . $source_arr[1]['id']] == "") {
                $model->addError($return_label . $source_arr[1]['id'], "Salesman cannot be blank.");
            } else {
                $id = $_POST[$return_label . $source_arr[1]['id']];
            }
        } else {

            if ($_POST[$return_label . $source_arr[2]['id']] == "") {
                $model->addError($return_label . $source_arr[2]['id'], "Outlet cannot be blank.");
            } else {
                $id = $_POST[$return_label . $source_arr[2]['id']];
            }
        }

        return $id;
    }

    function getReturnFromIDDetail($source, $id, $company_id) {

        $source_arr = Returnable::model()->getListReturnFrom();
        $source_name = "";

        if ($source == $source_arr[0]['value']) {
            $sales_office = SalesOffice::model()->findByAttributes(array("company_id" => $company_id, "sales_office_id" => $id));
            if ($sales_office) {
                $source_name = $sales_office->sales_office_name;
            }
        } else if ($source == $source_arr[1]['value']) {
            $c = new CDbCriteria;
            $c->select = new CDbExpression('t.*, CONCAT(t.first_name, " ", t.last_name) AS fullname');
            $c->condition = 'company_id = "' . $company_id . '" AND t.employee_id = "' . $id . '"';
            $employee = Employee::model()->find($c);
            if ($employee) {
                $source_name = $employee->fullname;
            }
        } else if ($source == $source_arr[2]['value']) {
            $poi = Poi::model()->findByAttributes(array("company_id" => $company_id, "poi_id" => $id));
            if ($poi) {
                $source_name = $poi->short_name;
            }
        }

        return $source_name;
    }

    function getReturnToIDDetail($destination, $id, $company_id) {

        $destination_arr = Returnable::model()->getListReturnTo();
        $destination_name = "";

        if ($destination == $destination_arr[0]['value']) {
            $zone = Zone::model()->findByAttributes(array("company_id" => $company_id, "zone_id" => $id));
            if ($zone) {
                $destination_name = $zone->zone_name;
            }
        } else if ($destination == $destination_arr[1]['value']) {
            $supplier = Supplier::model()->findByAttributes(array("company_id" => $company_id, "supplier_id" => $id));
            if ($supplier) {
                $destination_name = $supplier->supplier_name;
            }
        }

        return $destination_name;
    }

    public function createReturnable($transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $item_status = array();
        $incoming_status = "";
        foreach ($transaction_details as $v) {
            $item_status[$v['status']][] = $v['status'];
        }

        if (array_key_exists(OutgoingInventory::OUTGOING_PENDING_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_PENDING_STATUS;
        } else if (array_key_exists(OutgoingInventory::OUTGOING_INCOMPLETE_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_INCOMPLETE_STATUS;
        } else if (array_key_exists(OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS;
        } else {
            $incoming_status = OutgoingInventory::OUTGOING_COMPLETE_STATUS;
        }

        $returnable = new Returnable;

        try {

            $returnable_data = array(
                'company_id' => $this->company_id,
                'return_receipt_no' => $this->return_receipt_no,
                'reference_dr_no' => $this->reference_dr_no,
                'receive_return_from' => $this->receive_return_from,
                'receive_return_from_id' => $this->receive_return_from_id,
                'destination_zone_id' => $this->destination_zone_id,
                'transaction_date' => $this->transaction_date,
                'date_returned' => $this->date_returned,
                'status' => $incoming_status,
                'remarks' => $this->remarks,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $returnable->attributes = $returnable_data;

            if (count($transaction_details) > 0) {
                if ($returnable->save(false)) {

//                    Yii::app()->session['returns_id_create_session'] = $return->returns_id;
//                    unset(Yii::app()->session['returns_id_create_session']);

                    for ($i = 0; $i < count($transaction_details); $i++) {
                        ReturnableDetail::model()->createReturnableTransactionDetails($returnable->returnable_id, $returnable->company_id, $transaction_details[$i], $returnable->destination_zone_id, $returnable->transaction_date, $returnable->created_by);
                    }

                    return true;
                } else {
                    return false;
                }
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
