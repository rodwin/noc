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

    ////start of variables for soap
    /**
     * @var integer outgoing_inventory_id
     * @soap
     */
    public $outgoing_inventory_id;

    /**
     * @var string company_id
     * @soap
     */
    public $company_id;

    /**
     * @var string rra_no
     * @soap
     */
    public $rra_no;

    /**
     * @var string rra_name
     * @soap
     */
    public $rra_name;

    /**
     * @var string destination_zone_id
     * @soap
     */
    public $destination_zone_id;

    /**
     * @var string contact_person
     * @soap
     */
    public $contact_person;

    /**
     * @var string contact_no
     * @soap
     */
    public $contact_no;

    /**
     * @var string address
     * @soap
     */
    public $address;

    /**
     * @var string campaign_no
     * @soap
     */
    public $campaign_no;

    /**
     * @var string pr_no
     * @soap
     */
    public $pr_no;

    /**
     * @var string $pr_date
     * @soap
     */
    public $pr_date;

    /**
     * @var string plan_delivery_date
     * @soap
     */
    public $plan_delivery_date;

    /**
     * @var string revised_delivery_date
     * @soap
     */
    public $revised_delivery_date;

    /**
     * @var string actual_delivery_date
     * @soap
     */
    public $actual_delivery_date;

    /**
     * @var string plan_arrival_date
     * @soap
     */
    public $plan_arrival_date;

    /**
     * @var string transaction_date
     * @soap
     */
    public $transaction_date;

    /**
     * @var string total_amount
     * @soap
     */
    public $total_amount;

    /**
     * @var string status
     * @soap
     */
    public $status;

    /**
     * @var OutgoingInventoryDetail[] outgoing_inventory_detail_obj
     * @soap
     */
    public $outgoing_inventory_detail_obj;
    ////end of variables for soap

    public $search_string;
    public $total_quantity;

    const OUTGOING_PENDING_STATUS = 'IN-TRANSIT';
    const OUTGOING_INCOMPLETE_STATUS = 'INCOMPLETE';
    const OUTGOING_COMPLETE_STATUS = 'COMPLETE';
    const OUTGOING_OVER_DELIVERY_STATUS = 'OVER DELIVERY';
    const OUTGOING_LABEL = "Outbound";

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
            array('company_id, dr_no, transaction_date', 'required'),
            array('company_id, rra_no, dr_no, source_zone_id, destination_zone_id, contact_person, contact_no, status, created_by, updated_by', 'length', 'max' => 50),
            array('address', 'length', 'max' => 200),
            array('total_amount', 'length', 'max' => 18),
            array('remarks', 'length', 'max' => 150),
            array('closed', 'length', 'max' => 1),
            array('destination_zone_id', 'isValidZone'),
            array('dr_no', 'uniqueDRNo'),
            array('rra_date, transaction_date, plan_delivery_date, dr_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('plan_delivery_date, transaction_date, created_date, updated_date, dr_date, recipients', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('outgoing_inventory_id, company_id, rra_no, dr_no, dr_date, source_zone_id, destination_zone_id, contact_person, contact_no, address, plan_delivery_date, transaction_date, status, remarks, total_amount, closed, created_date, created_by, updated_date, updated_by, recipients', 'safe', 'on' => 'search'),
        );
    }

    public function isValidZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Zone from the auto-complete.');
        }

        return;
    }

    public function uniqueDRNo($attribute, $params) {

        $model = OutgoingInventory::model()->findByAttributes(array('company_id' => $this->company_id, 'dr_no' => $this->$attribute));
        if ($model && $model->outgoing_inventory_id != $this->outgoing_inventory_id) {
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
        if ($this->dr_date == "") {
            $this->dr_date = null;
        }
//        if ($this->actual_delivery_date == "") {
//            $this->actual_delivery_date = null;
//        }
//        if ($this->plan_arrival_date == "") {
//            $this->plan_arrival_date = null;
//        }

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
            'rra_no' => 'RA No',
            'dr_no' => 'DR No',
            'dr_date' => 'DR Date',
            'rra_date' => 'RA Date',
            'source_zone_id' => 'Source Zone',
            'destination_zone_id' => 'Destination Zone',
            'contact_person' => 'Contact Person',
            'contact_no' => 'Contact No',
            'address' => 'Address',
//            'campaign_no' => 'Campaign No',
//            'pr_no' => 'PR No',
//            'pr_date' => 'PR Date',
            'plan_delivery_date' => 'Plan Delivery Date',
//            'revised_delivery_date' => 'Revised Delivery Date',
//            'actual_delivery_date' => 'Actual Delivery Date',
//            'plan_arrival_date' => 'Plan Arrival Date',
            'transaction_date' => 'Date',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'total_amount' => 'Total Amount',
            'closed' => 'Closed',
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

        $criteria->compare('outgoing_inventory_id', $this->outgoing_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('rra_no', $this->rra_no);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('dr_date', $this->dr_date, true);
        $criteria->compare('rra_date', $this->rra_date, true);
        $criteria->compare('source_zone_id', $this->source_zone_id, true);
        $criteria->compare('destination_zone_id', $this->destination_zone_id, true);
        $criteria->compare('contact_person', $this->contact_person, true);
        $criteria->compare('contact_no', $this->contact_no, true);
        $criteria->compare('address', $this->address, true);
//        $criteria->compare('campaign_no', $this->campaign_no, true);
//        $criteria->compare('pr_no', $this->pr_no, true);
//        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('plan_delivery_date', $this->plan_delivery_date, true);
//        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
//        $criteria->compare('actual_delivery_date', $this->actual_delivery_date, true);
//        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('total_amount', $this->total_amount, true);
        $criteria->compare('closed', $this->closed, true);
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

//            case 4:
//                $sort_column = 't.campaign_no';
//                break;
//
//            case 5:
//                $sort_column = 't.pr_no';
//                break;

            case 5:
                $sort_column = 't.status';
                break;

            case 6:
                $sort_column = 't.contact_person';
                break;

            case 7:
                $sort_column = 't.total_amount';
                break;

            case 8:
                $sort_column = 't.created_date';
                break;
        }

        $zone_arr = array();
        $unserialize = CJSON::decode(Yii::app()->user->userObj->userType->data);
        $zones = CJSON::decode(isset($unserialize['zone']) ? $unserialize['zone'] : "");

        if (!empty($zones)) {
            if (count($zones) > 0) {
                foreach ($zones as $key => $val) {
                    $zone_arr[] = $key;
                }
            }
        }

        $c1 = new CDbCriteria;
        $c1->condition = "t.source_zone_id IN (" . Yii::app()->user->zones . ")";
        $c1->group = "t.outgoing_inventory_id";
        $outgoing_inv_detail = OutgoingInventoryDetail::model()->findAll($c1);

        $outgoing_inv_id_arr = array();
        if (count($outgoing_inv_detail) > 0) {
            foreach ($outgoing_inv_detail as $key1 => $val1) {
                $outgoing_inv_id_arr[] = $val1->outgoing_inventory_id;
            }
        }

        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.dr_no', $columns[0]['search']['value'], true);
        $criteria->compare('t.dr_date', $columns[1]['search']['value'], true);
        $criteria->compare('t.rra_no', $columns[2]['search']['value'], true);
        $criteria->compare('t.rra_date', $columns[3]['search']['value'], true);
        $criteria->compare('zone.zone_name', $columns[4]['search']['value'], true);
//        $criteria->compare('t.campaign_no', $columns[4]['search']['value'], true);
//        $criteria->compare('t.pr_no', $columns[5]['search']['value'], true);
        $criteria->compare('t.status', $columns[5]['search']['value'], true);
        $criteria->compare('t.contact_person', $columns[6]['search']['value'], true);
        $criteria->compare('t.total_amount', $columns[7]['search']['value'], true);
        $criteria->compare('t.created_date', $columns[8]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array("zone");
        $criteria->addInCondition('t.outgoing_inventory_id', $outgoing_inv_id_arr);

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

        $data = array();
        $data['success'] = false;

        $outgoing_inventory = new OutgoingInventory;

        try {

            $outgoing_inventory_data = array(
                'company_id' => $this->company_id,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->transaction_date,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'source_zone_id' => $this->source_zone_id,
                'destination_zone_id' => $this->destination_zone_id,
                'contact_person' => $this->contact_person,
                'contact_no' => $this->contact_no,
                'address' => $this->address,
                'plan_delivery_date' => $this->plan_delivery_date,
//                'actual_delivery_date' => $this->actual_delivery_date,
                'transaction_date' => $this->transaction_date,
                'status' => OutgoingInventory::OUTGOING_PENDING_STATUS,
                'remarks' => $this->remarks,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
                'recipients' => $this->recipients,
            );

            $outgoing_inventory->attributes = $outgoing_inventory_data;

            if (count($transaction_details) > 0) {
                if ($outgoing_inventory->save(false)) {

                    $outgoing_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        $outgoing_inv_detail = OutgoingInventoryDetail::model()->createOutgoingTransactionDetails($outgoing_inventory->outgoing_inventory_id, $outgoing_inventory->company_id, $transaction_details[$i]['inventory_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['sku_id'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['unit_price'], $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['quantity_issued'], $transaction_details[$i]['amount'], $transaction_details[$i]['return_date'], $transaction_details[$i]['remarks'], $outgoing_inventory->created_by, $transaction_details[$i]['uom_id'], $transaction_details[$i]['sku_status_id'], $outgoing_inventory->transaction_date);

                        $outgoing_details[] = $outgoing_inv_detail;
                    }

                    $data['success'] = true;
                    $data['header_data'] = $outgoing_inventory;
                    $data['detail_data'] = $outgoing_details;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
        }

        return $data;
    }

    public function updateTransaction($model, $outgoing_inv_ids_to_be_delete, $transaction_details, $deletedTransactionRowData, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $data = array();
        $data['success'] = false;

        $outgoing_inventory = $model;

        try {

            $outgoing_inventory_data = array(
                'company_id' => $this->company_id,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->transaction_date,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'source_zone_id' => $this->source_zone_id,
                'destination_zone_id' => $this->destination_zone_id,
                'contact_person' => $this->contact_person,
                'contact_no' => $this->contact_no,
                'address' => $this->address,
                'plan_delivery_date' => $this->plan_delivery_date,
                'transaction_date' => $this->transaction_date,
                'status' => OutgoingInventory::OUTGOING_PENDING_STATUS,
                'remarks' => $this->remarks,
                'total_amount' => $this->total_amount,
                'updated_by' => $this->updated_by,
                'updated_date' => $this->updated_date,
                'recipients' => $this->recipients,
            );

            $outgoing_inventory->attributes = $outgoing_inventory_data;

            if (count($transaction_details) > 0) {
                if ($outgoing_inventory->save(false)) {

                    $outgoing_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        if (trim($transaction_details[$i]['outgoing_inv_detail_id']) != "") {

                            $outgoing_inv_detail = OutgoingInventoryDetail::model()->updateOutgoingTransactionDetails($outgoing_inventory->outgoing_inventory_id, $transaction_details[$i]['outgoing_inv_detail_id'], $outgoing_inventory->company_id, $transaction_details[$i]['qty_for_new_inventory'], $transaction_details[$i]['quantity_issued'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['amount'], $outgoing_inventory->updated_by, $outgoing_inventory->updated_date);
                        } else {

                            $outgoing_inv_detail = OutgoingInventoryDetail::model()->createOutgoingTransactionDetails($outgoing_inventory->outgoing_inventory_id, $outgoing_inventory->company_id, $transaction_details[$i]['inventory_id'], $transaction_details[$i]['batch_no'], $transaction_details[$i]['sku_id'], $transaction_details[$i]['source_zone_id'], $transaction_details[$i]['unit_price'], $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['quantity_issued'], $transaction_details[$i]['amount'], $transaction_details[$i]['return_date'], $transaction_details[$i]['remarks'], $outgoing_inventory->updated_by, $transaction_details[$i]['uom_id'], $transaction_details[$i]['sku_status_id'], date("Y-m-d", strtotime($outgoing_inventory->updated_date)));
                        }

                        $outgoing_details[] = $outgoing_inv_detail;
                    }

                    if (count($deletedTransactionRowData) > 0) {
                        for ($x = 0; $x < count($deletedTransactionRowData); $x++) {

                            $outgoing_inv_detail = OutgoingInventoryDetail::model()->findByAttributes(array("company_id" => $outgoing_inventory->company_id, "outgoing_inventory_detail_id" => $deletedTransactionRowData[$x]['outgoing_inv_detail_id']));

                            ReceivingInventoryDetail::model()->createInventory($outgoing_inventory->company_id, $deletedTransactionRowData[$x]['sku_id'], $deletedTransactionRowData[$x]['uom_id'], $deletedTransactionRowData[$x]['unit_price'], $deletedTransactionRowData[$x]['quantity_issued'], $deletedTransactionRowData[$x]['source_zone_id'], date("Y-m-d", strtotime($outgoing_inventory->updated_date)), $outgoing_inventory->updated_by, $deletedTransactionRowData[$x]['expiration_date'], $deletedTransactionRowData[$x]['batch_no'], $deletedTransactionRowData[$x]['sku_status_id'], $outgoing_inv_detail->pr_no, $outgoing_inv_detail->pr_date, $outgoing_inv_detail->plan_arrival_date, $outgoing_inv_detail->po_no, $deletedTransactionRowData[$x]['remarks']);

                            if ((count($deletedTransactionRowData) - 1) == $x) {
                                for ($y = 0; $y < count($outgoing_inv_ids_to_be_delete); $y++) {

                                    OutgoingInventoryDetail::model()->deleteAll("company_id = '" . $outgoing_inventory->company_id . "' AND outgoing_inventory_detail_id = " . $outgoing_inv_ids_to_be_delete[$y]);
                                }
                            }
                        }
                    }

                    $data['success'] = true;
                    $data['header_data'] = $outgoing_inventory;
                    $data['detail_data'] = $outgoing_details;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), 'error');
        }
        
        return $data;
    }

    ///// start of retriving of data for outgoing in webservice
    public function retrieveOutgoing($dr_no, $employee_code, $sales_office_code) {
        $cdbcriteria = new CDbCriteria();
        $cdbcriteria->with = array('outgoingInventoryDetails', 'outgoingInventoryDetails.sku', 'outgoingInventoryDetails.sku.brand', 'zone');
//      $cdbcriteria->compare('t.company_id', $company_id);
        $cdbcriteria->join = "INNER JOIN zone a ON a.zone_id = t.destination_zone_id";
        $cdbcriteria->join .= " INNER JOIN sales_office b ON b.sales_office_id = a.sales_office_id";
        $cdbcriteria->join .= " INNER JOIN employee c ON c.sales_office_id = b.sales_office_id";
        $cdbcriteria->condition = "c.employee_code = '" . $employee_code . "'";
        $cdbcriteria->condition .= " AND b.sales_office_code = '" . $sales_office_code . "'";
        $cdbcriteria->compare('t.dr_no', $dr_no); //pre($cdbcriteria);
        $val = OutgoingInventory::model()->find($cdbcriteria);
        // pre($val);
        return $val;
    }

    ///// end of retriving of data for outgoing in webservice
    
    public function returnInvIfOutgoingInvDeleted($company_id, $id, $created_date, $created_by) {
        
        $c = new CDbCriteria;
        $c->condition = "outgoingInventory.company_id = '" . $company_id . "' AND outgoingInventory.outgoing_inventory_id = '" . $id . "'";
        $c->with = array('outgoingInventory');
        $outgoing_inv_detail = OutgoingInventoryDetail::model()->findAll($c);
        
        $data = array();
        $data['success'] = false;
        
        if (count($outgoing_inv_detail) > 0) {
            if (trim($outgoing_inv_detail[0]->outgoingInventory->status) != OutgoingInventory::OUTGOING_COMPLETE_STATUS) {
               for ($x = 0; $x < count($outgoing_inv_detail); $x++) {
                
                    if ($outgoing_inv_detail[$x]->status == OutgoingInventory::OUTGOING_PENDING_STATUS) {
                        
                        ReceivingInventoryDetail::model()->createInventory($outgoing_inv_detail[$x]->company_id, $outgoing_inv_detail[$x]->sku_id, $outgoing_inv_detail[$x]->uom_id, $outgoing_inv_detail[$x]->unit_price, $outgoing_inv_detail[$x]->quantity_issued, $outgoing_inv_detail[$x]->source_zone_id, $created_date, $created_by, $outgoing_inv_detail[$x]->expiration_date, $outgoing_inv_detail[$x]->batch_no, $outgoing_inv_detail[$x]->sku_status_id, $outgoing_inv_detail[$x]->pr_no, $outgoing_inv_detail[$x]->pr_date, $outgoing_inv_detail[$x]->plan_arrival_date, $outgoing_inv_detail[$x]->po_no, $outgoing_inv_detail[$x]->remarks);  
                    } else if ($outgoing_inv_detail[$x]->status == OutgoingInventory::OUTGOING_INCOMPLETE_STATUS) {
                       
                        $data = OutgoingInventory::model()->getRemainingQtyByOutgoingInvDetailIDAndDRNo($outgoing_inv_detail[$x]->outgoing_inventory_detail_id, $outgoing_inv_detail[$x]->outgoingInventory->dr_no);
                       
                        ReceivingInventoryDetail::model()->createInventory($outgoing_inv_detail[$x]->company_id, $outgoing_inv_detail[$x]->sku_id, $outgoing_inv_detail[$x]->uom_id, $outgoing_inv_detail[$x]->unit_price, $data[0]['remaining_qty'], $outgoing_inv_detail[$x]->source_zone_id, $created_date, $created_by, $outgoing_inv_detail[$x]->expiration_date, $outgoing_inv_detail[$x]->batch_no, $outgoing_inv_detail[$x]->sku_status_id, $outgoing_inv_detail[$x]->pr_no, $outgoing_inv_detail[$x]->pr_date, $outgoing_inv_detail[$x]->plan_arrival_date, $outgoing_inv_detail[$x]->po_no, $outgoing_inv_detail[$x]->remarks);  
                    }
                }
                
                $data['success'] = true;
            }          
        }
        
        return $data;
    }
    
    public function getRemainingQtyByOutgoingInvDetailIDAndDRNo($outgoing_inv_detail_id, $dr_no) {
        
        $sql = "SELECT (d.planned_quantity - d.quantity_received) AS remaining_qty

                FROM outgoing_inventory a
                INNER JOIN outgoing_inventory_detail b ON b.outgoing_inventory_id = a.outgoing_inventory_id
                LEFT JOIN incoming_inventory c ON c.dr_no = a.dr_no AND c.destination_zone_id = a.destination_zone_id
                LEFT JOIN incoming_inventory_detail d ON d.incoming_inventory_id = c.incoming_inventory_id AND d.source_zone_id = b.source_zone_id
                
                WHERE b.outgoing_inventory_detail_id = :outgoing_inventory_detail_id AND a.dr_no = :dr_no";
        
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':outgoing_inventory_detail_id', $outgoing_inv_detail_id, PDO::PARAM_STR);
        $command->bindParam(':dr_no', $dr_no, PDO::PARAM_STR);
        $data = $command->queryAll();
          
        return $data;
    }
}
