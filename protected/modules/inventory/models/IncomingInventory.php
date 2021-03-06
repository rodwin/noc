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
    public $outgoing_inventory_id;
    public $total_quantity;

    const INCOMING_LABEL = "Inbound";

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
            array('company_id, dr_no, dr_date, transaction_date', 'required'),
            array('company_id, dr_no, source_zone_id, destination_zone_id, contact_person, contact_no, status, created_by, updated_by, rra_no', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('destination_zone_id', 'isValidZone'),
            array('dr_no', 'uniqueDRNo'),
            array('transaction_date, plan_delivery_date, rra_date, dr_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('dr_date, transaction_date, updated_date, recipients', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('incoming_inventory_id, company_id, dr_no, dr_date, rra_date, source_zone_id, destination_zone_id, contact_person, contact_no, transaction_date, plan_delivery_date, status, total_amount, created_date, created_by, updated_date, updated_by, rra_no, recipients', 'safe', 'on' => 'search'),
        );
    }

    public function isValidZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Zone is invalid.');
        }

        return;
    }

    public function uniqueDRNo($attribute, $params) {

        $model = IncomingInventory::model()->findByAttributes(array('company_id' => $this->company_id, 'dr_no' => $this->$attribute));
        if ($model && $model->incoming_inventory_id != $this->incoming_inventory_id) {
            $this->addError($attribute, 'DR Number selected already taken');
        }
        return;
    }

    public function beforeValidate() {

        if ($this->plan_delivery_date == "") {
            $this->plan_delivery_date = null;
        }
        if ($this->rra_date == "") {
            $this->rra_date = null;
        }
//        if ($this->revised_delivery_date == "") {
//            $this->revised_delivery_date = null;
//        }
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
            'incomingInventoryDetails' => array(self::HAS_MANY, 'IncomingInventoryDetail', 'incoming_inventory_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'destination_zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'incoming_inventory_id' => 'Incoming Inventory',
            'company_id' => 'Company',
//            'campaign_no' => 'Campaign No',
//            'pr_no' => 'PR No',
//            'pr_date' => 'PR Date',
            'dr_no' => 'DR No',
            'dr_date' => 'DR Date',
            'rra_date' => 'RA Date',
            'rra_no' => 'RA No',
            'source_zone_id' => 'Source Zone',
            'destination_zone_id' => 'Destination Zone',
            'contact_person' => 'Contact Person',
            'contact_no' => 'Contact No',
            'transaction_date' => 'Date',
            'plan_delivery_date' => 'Plan Delivery Date',
//            'revised_delivery_date' => 'Revised Delivery Date',
//            'plan_arrival_date' => 'Plan Arrival Date',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'total_amount' => 'Total Amount',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'recipients' => 'Recipients',
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
//        $criteria->compare('campaign_no', $this->campaign_no, true);
//        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('dr_date', $this->dr_date, true);
        $criteria->compare('rra_date', $this->rra_date, true);
        $criteria->compare('rra_no', $this->rra_no, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('destination_zone_id', $this->destination_zone_id, true);
        $criteria->compare('contact_person', $this->contact_person, true);
        $criteria->compare('contact_no', $this->contact_no, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('plan_delivery_date', $this->plan_delivery_date, true);
//        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
//        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('total_amount', $this->total_amount, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('recipients', $this->recipients, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
//                $sort_column = 't.campaign_no';
//                break;
//
//            case 1:
//                $sort_column = 't.pr_no';
//                break;
//
//            case 2:
//                $sort_column = 't.pr_date';
//                break;

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
                $sort_column = 't.rra_date';
                break;

            case 4:
                $sort_column = 'zone.zone_name';
                break;

            case 5:
                $sort_column = 't.status';
                break;

            case 6:
                $sort_column = 't.total_amount';
                break;

            case 7:
                $sort_column = 't.created_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
//        $criteria->compare('t.campaign_no', $columns[0]['search']['value'], true);
//        $criteria->compare('t.pr_no', $columns[1]['search']['value'], true);
//        $criteria->compare('t.pr_date', $columns[2]['search']['value'], true);
        $criteria->compare('t.dr_no', $columns[0]['search']['value'], true);
        $criteria->compare('t.dr_date', $columns[1]['search']['value'], true);
        $criteria->compare('t.rra_no', $columns[2]['search']['value'], true);
        $criteria->compare('t.rra_date', $columns[3]['search']['value'], true);
        $criteria->compare('zone.zone_name', $columns[4]['search']['value'], true);
        $criteria->compare('t.status', $columns[5]['search']['value'], true);
        $criteria->compare('t.total_amount', $columns[6]['search']['value'], true);
        $criteria->compare('t.created_date', $columns[7]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array("zone");

        $arr = array();
        $unserialize = CJSON::decode(Yii::app()->user->userObj->userType->data);
        $zones = CJSON::decode(isset($unserialize['zone']) ? $unserialize['zone'] : "");

        if (!empty($zones)) {
            foreach ($zones as $key => $val) {
                $arr[] = $key;
            }
        }

        $criteria->addInCondition('t.destination_zone_id', $arr);

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

        $data = array();
        $data['success'] = false;

        $item_status = array();
        $incoming_status = "";
        foreach ($transaction_details as $v) {
            $item_status[$v['status']][] = $v['status'];
        }

        $closed = 1;
        if (array_key_exists(OutgoingInventory::OUTGOING_PENDING_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_PENDING_STATUS;
        } else if (array_key_exists(OutgoingInventory::OUTGOING_INCOMPLETE_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_INCOMPLETE_STATUS;
        } else if (array_key_exists(OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS;
            $closed = 2;
        } else {
            $incoming_status = OutgoingInventory::OUTGOING_COMPLETE_STATUS;
            $closed = 2;
        }

        $incoming_inventory = new IncomingInventory;

        try {

            $incoming_inventory_data = array(
                'company_id' => $this->company_id,
//                'campaign_no' => $this->campaign_no,
//                'pr_no' => $this->pr_no,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->dr_date,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'source_zone_id' => $this->source_zone_id,
                'destination_zone_id' => $this->destination_zone_id,
                'contact_person' => $this->contact_person,
                'contact_no' => $this->contact_no,
                'transaction_date' => $this->transaction_date,
//                'pr_date' => $this->pr_date,
                'plan_delivery_date' => $this->plan_delivery_date,
//                'revised_delivery_date' => $this->revised_delivery_date,
//                'plan_arrival_date' => $this->plan_arrival_date,
                'status' => $incoming_status,
                'remarks' => $this->remarks,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
                'recipients' => $this->recipients,
            );

            $incoming_inventory->attributes = $incoming_inventory_data;

            if (count($transaction_details) > 0) {
                if ($incoming_inventory->save(false)) {

//                    if ($incoming_inventory->status != OutgoingInventory::OUTGOING_PENDING_STATUS) {
                    OutgoingInventory::model()->updateAll(array('status' => $incoming_inventory->status, 'updated_by' => $this->created_by, 'updated_date' => date('Y-m-d H:i:s'), "closed" => $closed), 'outgoing_inventory_id = ' . $this->outgoing_inventory_id . ' AND company_id = "' . $incoming_inventory->company_id . '"');
//                    } else {
//                        OutgoingInventory::model()->updateAll(array('status' => $incoming_inventory->status, 'updated_by' => $this->created_by, 'updated_date' => date('Y-m-d H:i:s')), 'outgoing_inventory_id = ' . $this->outgoing_inventory_id . ' AND company_id = "' . $incoming_inventory->company_id . '"');
//                    }

                    $incoming_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        $incoming_inv_detail = IncomingInventoryDetail::model()->createIncomingTransactionDetails($incoming_inventory->incoming_inventory_id, $incoming_inventory->company_id, $transaction_details[$i]['inventory_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['sku_id'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['unit_price'], $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['quantity_received'], $transaction_details[$i]['amount'], $transaction_details[$i]['return_date'], $transaction_details[$i]['remarks'], $incoming_inventory->created_by, $transaction_details[$i]['status'], $transaction_details[$i]['outgoing_inventory_detail_id'], $transaction_details[$i]['uom_id'], $transaction_details[$i]['sku_status_id'], $incoming_inventory->destination_zone_id, $incoming_inventory->transaction_date);

                        $incoming_details[] = $incoming_inv_detail;
                    }

                    $data['success'] = true;
                    $data['header_data'] = $incoming_inventory;
                    $data['detail_data'] = $incoming_details;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
        }

        return $data;
    }
    
    public function loadAllOutgoingTransactionDetailsByDRNo($company_id, $dr_no) {
        
        $sql = "SELECT a.status AS header_status, c.incoming_inventory_id, d.incoming_inventory_detail_id, a.closed as closed_status, (d.planned_quantity - d.quantity_received) AS remaining_qty, a.*, b.*, e.*, h.*, f.brand_name,
                g.zone_id AS source_zone_id, g.zone_name AS source_zone_name, i.zone_id AS destination_zone_id, i.zone_name AS destination_zone_name

                FROM outgoing_inventory a
                INNER JOIN outgoing_inventory_detail b ON b.outgoing_inventory_id = a.outgoing_inventory_id
                LEFT JOIN incoming_inventory c ON c.dr_no = a.dr_no AND c.destination_zone_id = a.destination_zone_id
                LEFT JOIN incoming_inventory_detail d ON d.incoming_inventory_id = c.incoming_inventory_id AND d.source_zone_id = b.source_zone_id
                LEFT JOIN sku e ON e.sku_id = b.sku_id
                LEFT JOIN brand f ON f.brand_id = e.brand_id
                LEFT JOIN zone g ON g.zone_id = b.source_zone_id
                LEFT JOIN uom h ON h.uom_id = b.uom_id
                LEFT JOIN zone i ON i.zone_id = a.destination_zone_id
                WHERE a.dr_no = :dr_no AND a.company_id = :company_id";
        
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':company_id', $company_id, PDO::PARAM_STR);
        $command->bindParam(':dr_no', $dr_no, PDO::PARAM_STR);
        $data = $command->queryAll();
            
        return $data;
        
    }
    
    public function updateTransaction($transaction_details, $validate = true) {
        
        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $data = array();
        $data['success'] = false;
        
        $item_status = array();
        $incoming_status = "";
        foreach ($transaction_details as $v) {
            $item_status[$v['status']][] = $v['status'];
        }

        $closed = 1;
        if (array_key_exists(OutgoingInventory::OUTGOING_PENDING_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_PENDING_STATUS;
        } else if (array_key_exists(OutgoingInventory::OUTGOING_INCOMPLETE_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_INCOMPLETE_STATUS;
        } else if (array_key_exists(OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS, $item_status)) {
            $incoming_status = OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS;
            $closed = 2;
        } else {
            $incoming_status = OutgoingInventory::OUTGOING_COMPLETE_STATUS;
            $closed = 2;
        }

        $incoming_inventory = $this;

        try {

            $incoming_inventory_data = array(
                'company_id' => $this->company_id,
//                'campaign_no' => $this->campaign_no,
//                'pr_no' => $this->pr_no,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->dr_date,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'source_zone_id' => $this->source_zone_id,
                'destination_zone_id' => $this->destination_zone_id,
                'contact_person' => $this->contact_person,
                'contact_no' => $this->contact_no,
                'transaction_date' => $this->transaction_date,
//                'pr_date' => $this->pr_date,
                'plan_delivery_date' => $this->plan_delivery_date,
//                'revised_delivery_date' => $this->revised_delivery_date,
//                'plan_arrival_date' => $this->plan_arrival_date,
                'status' => $incoming_status,
                'remarks' => $this->remarks,
                'total_amount' => $this->total_amount,
                'recipients' => $this->recipients,
                'updated_by' => $this->updated_by,
                'updated_date' => $this->updated_date,
            );

            $incoming_inventory->attributes = $incoming_inventory_data;

            if (count($transaction_details) > 0) {
                if ($incoming_inventory->save(false)) {

//                    if ($incoming_inventory->status != OutgoingInventory::OUTGOING_PENDING_STATUS) {
                    OutgoingInventory::model()->updateAll(array('status' => $incoming_inventory->status, 'updated_by' => $this->updated_by, 'updated_date' => $this->updated_date, "closed" => $closed), 'outgoing_inventory_id = ' . $this->outgoing_inventory_id . ' AND company_id = "' . $incoming_inventory->company_id . '"');
//                    } else {
//                        OutgoingInventory::model()->updateAll(array('status' => $incoming_inventory->status, 'updated_by' => $this->created_by, 'updated_date' => date('Y-m-d H:i:s')), 'outgoing_inventory_id = ' . $this->outgoing_inventory_id . ' AND company_id = "' . $incoming_inventory->company_id . '"');
//                    }

                    $incoming_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        $incoming_inv_detail = IncomingInventoryDetail::model()->updateIncomingTransactionDetails($incoming_inventory->incoming_inventory_id, $transaction_details[$i]['incoming_inventory_detail_id'], $incoming_inventory->company_id, $transaction_details[$i]['inventory_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['sku_id'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['unit_price'], $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['quantity_received'], $transaction_details[$i]['amount'], $transaction_details[$i]['return_date'], $transaction_details[$i]['remarks'], $incoming_inventory->updated_by, $transaction_details[$i]['status'], $transaction_details[$i]['outgoing_inventory_detail_id'], $transaction_details[$i]['uom_id'], $transaction_details[$i]['sku_status_id'], $incoming_inventory->destination_zone_id, $incoming_inventory->transaction_date);
                        
                        $incoming_details[] = $incoming_inv_detail;
                    }

                    $data['success'] = true;
                    $data['header_data'] = $incoming_inventory;
                    $data['detail_data'] = $incoming_details;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
        }
        
        return $data;     
    }

}
