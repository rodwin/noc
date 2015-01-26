<?php

/**
 * This is the model class for table "return_mdse".
 *
 * The followings are the available columns in table 'return_mdse':
 * @property integer $return_mdse_id
 * @property string $company_id
 * @property string $return_mdse_no
 * @property string $reference_dr_no
 * @property string $return_to
 * @property string $return_to_id
 * @property string $transaction_date
 * @property string $date_returned
 * @property string $remarks
 * @property string $total_amount
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property ReturnMdseDetail[] $returnMdseDetails
 */
class ReturnMdse extends CActiveRecord {

    public $search_string;
    
    const RETURN_MDSE_LABEL = "RETURN MDSE";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'return_mdse';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, return_mdse_no, return_to, transaction_date, date_returned', 'required'),
            array('company_id, return_mdse_no, reference_dr_no, return_to, return_to_id, created_by, updated_by', 'length', 'max' => 50),
            array('remarks', 'length', 'max' => 150),
            array('total_amount', 'length', 'max' => 18),
            array('return_mdse_no', 'uniqueMdseNo'),
            array('transaction_date, date_returned, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('return_mdse_id, company_id, return_mdse_no, reference_dr_no, return_to, return_to_id, transaction_date, date_returned, remarks, total_amount, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueMdseNo($attribute, $params) {

        $model = ReturnMdse::model()->findByAttributes(array('company_id' => $this->company_id, 'return_mdse_no' => $this->$attribute));
        if ($model && $model->return_mdse_id != $this->return_mdse_id) {
            $this->addError($attribute, 'Return Mdse Number selected already taken');
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
            'returnMdseDetails' => array(self::HAS_MANY, 'ReturnMdseDetail', 'return_mdse_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'return_mdse_id' => 'Return Mdse',
            'company_id' => 'Company',
            'return_mdse_no' => 'Return Mdse No',
            'reference_dr_no' => 'Reference DR No',
            'return_to' => 'Return To',
            'return_to_id' => 'Return To',
            'transaction_date' => 'Transaction Date',
            'date_returned' => 'Date Returned',
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

        $criteria->compare('return_mdse_id', $this->return_mdse_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('return_mdse_no', $this->return_mdse_no, true);
        $criteria->compare('reference_dr_no', $this->reference_dr_no, true);
        $criteria->compare('return_to', $this->return_to, true);
        $criteria->compare('return_to_id', $this->return_to_id, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('date_returned', $this->date_returned, true);
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
                $sort_column = 'return_mdse_no';
                break;

            case 1:
                $sort_column = 'transaction_date';
                break;

            case 2:
                $sort_column = 'return_to';
                break;

//            case 3:
//                $sort_column = 'return_to';
//                break;

            case 4:
                $sort_column = 'total_amount';
                break;

            case 5:
                $sort_column = 'remarks';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('return_mdse_no', $columns[0]['search']['value']);
        $criteria->compare('transaction_date', $columns[1]['search']['value'], true);
        $criteria->compare('return_to', $columns[2]['search']['value'], true);
        $criteria->compare('return_to', $columns[3]['search']['value']);
        $criteria->compare('total_amount', $columns[4]['search']['value'], true);
        $criteria->compare('remarks', $columns[5]['search']['value'], true);
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
     * @return ReturnMdse the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getListReturnTo() {

        return array(
            array('value' => 'SUPPLIER', 'title' => 'Supplier', 'id' => 'selected_supplier'),
            array('value' => 'SALESOFFICE', 'title' => 'Salesoffice', 'id' => 'selected_salesoffice'),
            array('value' => 'WAREHOUSE', 'title' => 'Warehouse', 'id' => 'selected_warehouse'),
        );
    }

    public function validateReturnTo($model, $key, $return_to_label) {

        $destination_arr = ReturnMdse::model()->getListReturnTo();
        $id = "";

        if ($key == $destination_arr[0]['value']) {

            if ($_POST[$return_to_label . $destination_arr[0]['id']] == "") {
                $model->addError($return_to_label . $destination_arr[0]['id'], "Supplier cannot be blank.");
            } else {
                $id = $_POST[$return_to_label . $destination_arr[0]['id']];
            }
        } else if ($key == $destination_arr[1]['value']) {

            if ($_POST[$return_to_label . $destination_arr[1]['id']] == "") {
                $model->addError($return_to_label . $destination_arr[1]['id'], "Salesoffice cannot be blank.");
            } else {
                $id = $_POST[$return_to_label . $destination_arr[1]['id']];
            }
        } else {

            if ($_POST[$return_to_label . $destination_arr[2]['id']] == "") {
                $model->addError($return_to_label . $destination_arr[2]['id'], "Warehouse cannot be blank.");
            } else {
                $id = $_POST[$return_to_label . $destination_arr[2]['id']];
            }
        }

        return $id;
    }

    public function createReturnMdse($transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $data = array();
        $data['success'] = false;

        $return_mdse = new ReturnMdse;

        try {

            $return_mdse_data = array(
                'company_id' => $this->company_id,
                'return_mdse_no' => $this->return_mdse_no,
                'reference_dr_no' => $this->reference_dr_no,
                'return_to' => $this->return_to,
                'return_to_id' => $this->return_to_id,
                'transaction_date' => $this->transaction_date,
                'date_returned' => $this->date_returned,
                'remarks' => $this->remarks,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
            );

            $return_mdse->attributes = $return_mdse_data;

            if (count($transaction_details) > 0) {
                if ($return_mdse->save(false)) {

                    $return_mdse_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        $return_mdse_detail = ReturnMdseDetail::model()->createReturnMdseTransactionDetails($return_mdse->return_mdse_id, $return_mdse->company_id, $transaction_details[$i], $return_mdse->transaction_date, $return_mdse->created_by);

                        $return_mdse_details[] = $return_mdse_detail;
                    }

                    $data['success'] = true;
                    $data['header_data'] = $return_mdse;
                    $data['detail_data'] = $return_mdse_details;
                }
            }
        } catch (Exception $exc) {
            pr($exc);
            Yii::log($exc->getTraceAsString(), 'error');
        }

        return $data;
    }

    public function getReturnToDetails($company_id, $return_to, $return_to_id) {

        $destination_arr = ReturnMdse::model()->getListReturnTo();
        $data = array();

        if ($return_to == $destination_arr[0]['value']) {

            $c1 = new CDbCriteria;
            $c1->condition = "t.company_id = '" . $company_id . "' AND t.supplier_id = '" . $return_to_id . "'";
            $supplier = Supplier::model()->find($c1);

            $data['destination_name'] = isset($supplier->supplier_name) ? $supplier->supplier_name : "";
            $data['destination_code'] = isset($supplier->supplier_code) ? $supplier->supplier_code : "";
            $data['contact_person'] = isset($supplier->contact_person1) ? $supplier->contact_person1 : "";
            $data['contact_no'] = isset($supplier->telephone) ? $supplier->telephone : "";
            $data['address'] = isset($supplier->address1) ? $supplier->address1 : "";
        } else if ($return_to == $destination_arr[1]['value'] || $return_to == $destination_arr[2]['value']) {

            $c2 = new CDbCriteria;
            $c2->condition = "t.company_id = '" . $company_id . "' AND t.sales_office_id = '" . $return_to_id . "'";
            $sales_office = Salesoffice::model()->find($c2);

            $data['destination_name'] = isset($sales_office->sales_office_name) ? $sales_office->sales_office_name : "";
            $data['destination_code'] = isset($sales_office->sales_office_code) ? $sales_office->sales_office_code : "";
            $data['contact_person'] = "";
            $data['contact_no'] = "";
            $data['address'] = isset($sales_office->address1) ? $sales_office->address1 : "";
        }

        return $data;
    }

    public function getReturnToID($key, $return_label, $post_data) {

        $destination_arr = ReturnMdse::model()->getListReturnTo();
        $data = array();

        if ($key == $destination_arr[0]['value']) {

            if ($post_data[$return_label . $destination_arr[0]['id']] != "") {
                $data['id'] = $post_data[$return_label . $destination_arr[0]['id']];
            }
        } else if ($key == $destination_arr[1]['value']) {

            if ($post_data[$return_label . $destination_arr[1]['id']] != "") {
                $data['id'] = $post_data[$return_label . $destination_arr[1]['id']];
            }
        } else {

            if ($post_data[$return_label . $destination_arr[2]['id']] != "") {
                $data['id'] = $post_data[$return_label . $destination_arr[2]['id']];
            }
        }

        return $data;
    }

}
