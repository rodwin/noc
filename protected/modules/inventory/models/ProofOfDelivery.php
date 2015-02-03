<?php

/**
 * This is the model class for table "proof_of_delivery".
 *
 * The followings are the available columns in table 'proof_of_delivery':
 * @property integer $pod_id
 * @property string $company_id
 * @property string $dr_no
 * @property string $dr_date
 * @property string $rra_no
 * @property string $rra_date
 * @property string $source_zone_id
 * @property string $poi_id
 * @property string $status
 * @property string $total_amount
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 * @property string $verified
 * @property string $verified_by
 *
 * The followings are the available model relations:
 * @property PodDetail[] $podDetails
 */
class ProofOfDelivery extends CActiveRecord {

    public $search_string;

    const PROOF_OF_DELIVERY_LABEL = "Proof of Delivery";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'proof_of_delivery';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, dr_no, dr_date, poi_id, customer_item_id', 'required'),
            array('company_id, dr_no, rra_no, source_zone_id, poi_id, status, created_by, updated_by, verified_by', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('customer_item_id', 'length', 'max' => 11),
            array('verified', 'length', 'max' => 1),
            array('dr_date, rra_date, transaction_date, created_date, updated_date, verified_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('pod_id, company_id, dr_no, dr_date, rra_no, rra_date, source_zone_id, poi_id, transaction_date, status, total_amount, created_by, created_date, updated_by, updated_date, verified, verified_by, verified_date, customer_item_id', 'safe', 'on' => 'search'),
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
            'podDetails' => array(self::HAS_MANY, 'ProofOfDeliveryDetail', 'pod_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'source_zone_id'),
            'poi' => array(self::BELONGS_TO, 'Poi', 'poi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pod_id' => 'Pod',
            'company_id' => 'Company',
            'dr_no' => 'DR No',
            'dr_date' => 'DR Date',
            'rra_no' => 'RA No',
            'rra_date' => 'RA Date',
            'source_zone_id' => 'Source Zone',
            'poi_id' => Poi::POI_LABEL,
            'transaction_date' => 'Transaction Date',
            'status' => 'Status',
            'total_amount' => 'Total Amount',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'verified' => 'Verified',
            'verified_by' => 'Verified By',
            'verified_date' => 'Verified Date',
            'customer_item_id' => 'Customer Item',
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

        $criteria->compare('pod_id', $this->pod_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('dr_date', $this->dr_date, true);
        $criteria->compare('rra_no', $this->rra_no, true);
        $criteria->compare('rra_date', $this->rra_date, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('poi_id', $this->poi_id, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('total_amount', $this->total_amount, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('verified', $this->verified, true);
        $criteria->compare('verified_by', $this->verified_by, true);
        $criteria->compare('customer_item_id', $this->customer_item_id, true);
        $criteria->compare('customer_item_id', $this->customer_item_id, true);

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
                $sort_column = 't.dr_date';
                break;

            case 2:
                $sort_column = 't.rra_no';
                break;

            case 3:
                $sort_column = 't.source_zone_id';
                break;

            case 4:
                $sort_column = 'poi.short_name';
                break;

            case 5:
                $sort_column = 'poi.address1';
                break;


            case 6:
                $sort_column = 't.status';
                break;

            case 7:
                $sort_column = 't.total_amount';
                break;

            case 8:
                $sort_column = 't.verified';
                break;

            case 9:
                $sort_column = 't.verified_by';
                break;

            case 10:
                $sort_column = 't.verified_date';
                break;

            case 11:
                $sort_column = 't.created_date';
                break;
        }
        
//        $zone_arr = array();
//        if (Yii::app()->user->userObj->userType->updated_date == "") {
//
//            $data_first_rem = strstr(Yii::app()->user->userObj->userType->data, '{');
//            $data_last_rem = strstr(strrev($data_first_rem), '}');
//            $final_data = strrev($data_last_rem);
//        } else {
//
//            $final_data = Yii::app()->user->userObj->userType->data;
//        }
//        
//        $unserialize = CJSON::decode($final_data);
//        $zones = CJSON::decode(isset($unserialize['zone']) ? $unserialize['zone'] : "");
//
//        if (!empty($zones)) {
//            foreach ($zones as $key => $val) {
//                $zone_arr[] = $key;
//            }
//        }

        $c1 = new CDbCriteria;
        $c1->condition = "t.company_id = '" . Yii::app()->user->company_id . "' AND t.source_zone_id IN (" . Yii::app()->user->zones . ")";
        $c1->group = "t.pod_id";
        $c1->with = array('pod');
        $pod_detail = ProofOfDeliveryDetail::model()->findAll($c1);

        $pod_id_arr = array();
        if (count($pod_detail) > 0) {
            foreach ($pod_detail as $key1 => $val1) {
                $pod_id_arr[] = $val1->pod->pod_id;
            }
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.dr_no', $columns[0]['search']['value'], true);
        $criteria->compare('t.dr_date', $columns[1]['search']['value'], true);
        $criteria->compare('t.rra_no', $columns[2]['search']['value'], true);
        $criteria->compare('t.source_zone_id', $columns[3]['search']['value'], true);
        $criteria->compare('poi.short_name', $columns[4]['search']['value'], true);
        $criteria->compare('poi.address1', $columns[5]['search']['value'], true);
        $criteria->compare('t.status', $columns[6]['search']['value'], true);
        $criteria->compare('t.total_amount', $columns[7]['search']['value'], true);
        $criteria->compare('t.verified', $columns[8]['search']['value'], true);
        $criteria->compare('t.verified_by', $columns[9]['search']['value'], true);
        $criteria->compare('t.verified_date', $columns[10]['search']['value'], true);
        $criteria->compare('t.created_date', $columns[11]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array("poi");
        $criteria->addInCondition('t.pod_id', $pod_id_arr);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProofOfDelivery the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function customerData($customer_header_data, $transaction_details) {

        $pod = new ProofOfDelivery;
        $pod->company_id = $customer_header_data->company_id;
        $pod->rra_no = $customer_header_data->rra_no;
        $pod->rra_date = $customer_header_data->rra_date;
        $pod->dr_no = $customer_header_data->dr_no;
        $pod->dr_date = $customer_header_data->dr_date;
        $pod->source_zone_id = $customer_header_data->source_zone_id;
        $pod->poi_id = $customer_header_data->poi_id;
        $pod->transaction_date = $customer_header_data->transaction_date;
        $pod->status = $customer_header_data->status;
        $pod->total_amount = $customer_header_data->total_amount;
        $pod->created_by = $customer_header_data->created_by;
        $pod->customer_item_id = $customer_header_data->customer_item_id;

        $data = $pod->create($transaction_details);
        
        if ($data['success']) {
            return $data;
        } else {
            return $pod->getErrors();
        }
    }

    public function create($transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $data = array();
        $data['success'] = false;

        $proofOfDelivery = new ProofOfDelivery;

        try {

            $proof_of_delivery_data = array(
                'company_id' => $this->company_id,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->transaction_date,
                'source_zone_id' => $this->source_zone_id,
                'poi_id' => $this->poi_id,
                'transaction_date' => null,
                'status' => $this->status,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
                'customer_item_id' => $this->customer_item_id,
            );

            $proofOfDelivery->attributes = $proof_of_delivery_data;

            if (count($transaction_details) > 0) {
                if ($proofOfDelivery->save(false)) {

                    $pod_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        
                        $pod_detail = ProofOfDeliveryDetail::model()->createPODTransactionDetails($proofOfDelivery->pod_id, $proofOfDelivery->company_id, $transaction_details[$i]->inventory_id, $transaction_details[$i]->batch_no, $transaction_details[$i]->sku_id, $transaction_details[$i]->source_zone_id, $transaction_details[$i]->unit_price, $transaction_details[$i]->expiration_date, $transaction_details[$i]->planned_quantity, $transaction_details[$i]->quantity_issued, $transaction_details[$i]->amount, $transaction_details[$i]->return_date, $transaction_details[$i]->remarks, $proofOfDelivery->created_by, $transaction_details[$i]->uom_id, $transaction_details[$i]->sku_status_id, $proofOfDelivery->transaction_date, $transaction_details[$i]->customer_item_detail_id, $transaction_details[$i]->po_no, $transaction_details[$i]->pr_no, $transaction_details[$i]->pr_date, $transaction_details[$i]->plan_arrival_date);
                    
                        $pod_details[] = $pod_detail;
                    }
                    
                    $data['success'] = true;
                    $data['pod_header_data'] = $proofOfDelivery;
                    $data['pod_detail_data'] = $pod_details;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
        }
        
        return $data;
    }

    public function updateCustomerData($customer_header_data, $customer_item_detail_ids_to_be_delete, $transaction_details) {

        $pod = ProofOfDelivery::model()->findByAttributes(array("company_id" => $customer_header_data->company_id, "customer_item_id" => $customer_header_data->customer_item_id));

        if ($pod) {
            $pod->rra_no = $customer_header_data->rra_no;
            $pod->rra_date = $customer_header_data->rra_date;
            $pod->dr_no = $customer_header_data->dr_no;
            $pod->dr_date = $customer_header_data->dr_date;
            $pod->dr_date = $customer_header_data->dr_date;
            $pod->source_zone_id = $customer_header_data->source_zone_id;
            $pod->poi_id = $customer_header_data->poi_id;
            $pod->status = $customer_header_data->status;
            $pod->total_amount = $customer_header_data->total_amount;
            $pod->updated_by = $customer_header_data->updated_by;
            $pod->updated_date = $customer_header_data->updated_date;

            $data = $pod->updateTransaction($pod, $customer_item_detail_ids_to_be_delete, $transaction_details);
            
            if ($data['success']) {
                return $data;
            } else {
                return $pod->getErrors();
            }
        } else {
            return false;
        }
    }

    public function updateTransaction($proofOfDelivery, $customer_item_detail_ids_to_be_delete, $transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $data = array();
        $data['success'] = false;

        try {

            $proof_of_delivery_data = array(
                'company_id' => $this->company_id,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->dr_date,
                'source_zone_id' => $this->source_zone_id,
                'poi_id' => $this->poi_id,
                'status' => $this->status,
                'total_amount' => $this->total_amount,
                'customer_item_id' => $this->customer_item_id,
                'updated_by' => $this->updated_by,
                'updated_date' => $this->updated_date,
            );

            $proofOfDelivery->attributes = $proof_of_delivery_data;

            if (count($transaction_details) > 0) {
                if ($proofOfDelivery->save(false)) {

                    $pod_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        $pod_detail = ProofOfDeliveryDetail::model()->updatePODTransactionDetails($proofOfDelivery->pod_id, $transaction_details[$i]->customer_item_detail_id, $proofOfDelivery->company_id, $transaction_details[$i]->inventory_id, $transaction_details[$i]->quantity_issued, $transaction_details[$i]->amount, $proofOfDelivery->updated_by, $proofOfDelivery->updated_date);
                                            
                        $pod_details[] = $pod_detail;
                    }
                    
                    $data['success'] = true;
                    $data['pod_header_data'] = $proofOfDelivery;
                    $data['pod_detail_data'] = $pod_details;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
        }
        
        return $data;
    }

}
