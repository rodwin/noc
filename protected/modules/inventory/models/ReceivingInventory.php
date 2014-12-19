<?php

/**
 * This is the model class for table "receiving_inventory".
 *
 * The followings are the available columns in table 'receiving_inventory':
 * @property integer $receiving_inventory_id
 * @property string $company_id
 * @property string $campaign_no
 * @property string $pr_no
 * @property string $pr_date
 * @property string $dr_no
 * @property string $requestor
 * @property string $supplier_id
 * @property string $zone_id
 * @property string $plan_delivery_date
 * @property string $revised_delivery_date
 * @property string $actual_delivery_date
 * @property string $plan_arrival_date
 * @property string $transaction_date
 * @property string $delivery_remarks
 * @property string $total_amount
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property ReceivingInventoryDetail[] $receivingInventoryDetails
 */
class ReceivingInventory extends CActiveRecord {

    public $search_string;
    public $total_quantity;

    const RECEIVING_LABEL = "Incoming";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'receiving_inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, requestor, dr_no, transaction_date', 'required'),
            array('company_id, campaign_no, pr_no, dr_no, requestor, supplier_id, sales_office_id, zone_id, delivery_remarks, created_by, updated_by, po_no, rra_no', 'length', 'max' => 50),
            array('total_amount', 'length', 'max' => 18),
            array('pr_date, plan_delivery_date, revised_delivery_date, plan_arrival_date, transaction_date, dr_date, po_date, rra_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('zone_id', 'isValidZone'),
            array('supplier_id', 'isValidSupplier'),
            array('dr_no', 'uniqueDRNo'),
            array('plan_delivery_date, revised_delivery_date, plan_arrival_date, created_date, updated_date, dr_date, recipients', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('receiving_inventory_id, company_id, campaign_no, pr_no, pr_date, dr_no, dr_date, requestor, supplier_id, sales_office_id, zone_id, plan_delivery_date, revised_delivery_date, plan_arrival_date, transaction_date, delivery_remarks, total_amount, created_date, created_by, updated_date, updated_by, po_no, po_date, rra_no, rra_date, recipients', 'safe', 'on' => 'search'),
        );
    }

    public function isValidZone($attribute) {
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Zone from the auto-complete.');
        }

        return;
    }

    public function isValidSupplier($attribute) {
        $model = Supplier::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Please select a Supplier from the auto-complete.');
        }

        return;
    }

    public function uniqueDRNo($attribute, $params) {

        $model = ReceivingInventory::model()->findByAttributes(array('company_id' => $this->company_id, 'dr_no' => $this->$attribute));
        if ($model && $model->receiving_inventory_id != $this->receiving_inventory_id) {
            $this->addError($attribute, 'DR Number selected already taken');
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
//        if ($this->actual_delivery_date == "") {
//            $this->actual_delivery_date = null;
//        }        
        if ($this->plan_arrival_date == "") {
            $this->plan_arrival_date = null;
        }
        if ($this->dr_date == "") {
            $this->dr_date = null;
        }
        if ($this->pr_date == "") {
            $this->pr_date = null;
        }
        if ($this->po_date == "") {
            $this->po_date = null;
        }
        if ($this->rra_date == "") {
            $this->rra_date = null;
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
            'receivingInventoryDetails' => array(self::HAS_MANY, 'ReceivingInventoryDetail', 'receiving_inventory_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
            'employee' => array(self::BELONGS_TO, 'Employee', 'requestor'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'receiving_inventory_id' => 'Receiving Inventory',
            'company_id' => 'Company',
            'campaign_no' => 'Campaign No',
            'pr_no' => 'PR No',
            'pr_date' => 'PR Date',
            'dr_no' => 'DR No',
            'dr_date' => 'DR Date',
            'requestor' => 'Requestor',
            'supplier_id' => 'Supplier',
            'sales_office_id' => 'Sales Office',
            'zone_id' => 'Destination Zone',
            'plan_delivery_date' => 'Plan Delivery Date',
            'revised_delivery_date' => 'Revised Delivery Date',
//            'actual_delivery_date' => 'Actual Delivery Date',
            'plan_arrival_date' => 'Plan Arrival Date To SO',
            'transaction_date' => 'Date',
            'delivery_remarks' => 'Delivery Remarks',
            'total_amount' => 'Total Amount',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'po_no' => 'PO No',
            'po_date' => 'PO Date',
            'rra_no' => 'RA No',
            'rra_date' => 'RA Date',
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

        $criteria->compare('receiving_inventory_id', $this->receiving_inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('campaign_no', $this->campaign_no, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('dr_no', $this->dr_no, true);
        $criteria->compare('dr_date', $this->dr_date, true);
        $criteria->compare('requestor', $this->requestor, true);
        $criteria->compare('supplier_id', $this->supplier_id, true);
        $criteria->compare('sales_office_id', $this->sales_office_id, true);
        $criteria->compare('zone_id', $this->zone_id, true);
        $criteria->compare('plan_delivery_date', $this->plan_delivery_date, true);
        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
//        $criteria->compare('actual_delivery_date', $this->actual_delivery_date, true);
        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('delivery_remarks', $this->delivery_remarks, true);
        $criteria->compare('total_amount', $this->total_amount, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('po_no', $this->po_no, true);
        $criteria->compare('po_date', $this->po_date, true);
        $criteria->compare('rra_no', $this->rra_no, true);
        $criteria->compare('rra_date', $this->rra_date, true);
        $criteria->compare('recipients', $this->recipients, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 't.pr_no';
                break;

            case 1:
                $sort_column = 't.pr_date';
                break;

            case 2:
                $sort_column = 't.po_no';
                break;

            case 3:
                $sort_column = 't.po_date';
                break;

            case 4:
                $sort_column = 't.rra_no';
                break;

            case 5:
                $sort_column = 't.dr_no';
                break;

            case 6:
                $sort_column = 't.requestor';
                break;

            case 7:
                $sort_column = 'supplier.supplier_name';
                break;

            case 8:
                $sort_column = 'zone.zone_name';
                break;

            case 9:
                $sort_column = 't.total_amount';
                break;

            case 10:
                $sort_column = 't.created_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.pr_no', $columns[0]['search']['value'], true);
        $criteria->compare('t.pr_date', $columns[1]['search']['value'], true);
        $criteria->compare('t.po_no', $columns[2]['search']['value'], true);
        $criteria->compare('t.po_date', $columns[3]['search']['value'], true);
        $criteria->compare('t.rra_no', $columns[4]['search']['value'], true);
        $criteria->compare('t.dr_no', $columns[5]['search']['value'], true);
        $criteria->compare('t.requestor', $columns[6]['search']['value'], true);
        $criteria->compare('supplier.supplier_name', $columns[7]['search']['value'], true);
        $criteria->compare('zone.zone_name', $columns[8]['search']['value'], true);
        $criteria->compare('t.total_amount', $columns[9]['search']['value'], true);
        $criteria->compare('t.created_date', $columns[10]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array("supplier", "employee", "zone");

        $arr = array();
        $unserialize = CJSON::decode(Yii::app()->user->userObj->userType->data);
        $zones = CJSON::decode(isset($unserialize['zone']) ? $unserialize['zone'] : "");

        if (!empty($zones)) {
            foreach ($zones as $key => $val) {
                $arr[] = $key;
            }
        }

        $criteria->addInCondition('t.zone_id', $arr);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ReceivingInventory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function skuData($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 't.sku_code';
                break;

            case 1:
                $sort_column = 't.description';
                break;

            case 2:
                $sort_column = 'brand.brand_name';
                break;

            case 4:
                $sort_column = 't.type';
                break;

            case 5:
                $sort_column = 't.sub_type';
                break;

            case 6:
                $sort_column = 't.default_unit_price';
                break;
        }

        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.sku_code', $columns[0]['search']['value'], true);
        $criteria->compare('t.description', $columns[1]['search']['value'], true);
        $criteria->compare('brand.brand_name', $columns[2]['search']['value'], true);
        $criteria->compare('t.type', $columns[4]['search']['value'], true);
        $criteria->compare('t.sub_type', $columns[5]['search']['value'], true);
        $criteria->compare('t.default_unit_price', $columns[6]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array('brand', 'company', 'defaultUom', 'defaultZone');

        $arr = array();
        $unserialize = CJSON::decode(Yii::app()->user->userObj->userType->data);
        $brands = CJSON::decode(isset($unserialize['brand']) ? $unserialize['brand'] : "");

        foreach ($brands as $key => $val) {
            $arr[] = $key;
        }

        $criteria->addInCondition('t.brand_id', $arr);

        return new CActiveDataProvider("Sku", array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function create($transaction_details, $validate = true) {

        if ($validate) {
            if (!$this->validate()) {
                return false;
            }
        }

        $data = array();
        $data['success'] = false;

        $receiving_inventory = new ReceivingInventory;

        try {

            $receiving_inventory_data = array(
                'company_id' => $this->company_id,
//                'campaign_no' => $this->campaign_no,
                'pr_no' => $this->pr_no,
                'pr_date' => $this->pr_date,
                'dr_no' => $this->dr_no,
                'dr_date' => $this->transaction_date,
                'requestor' => $this->requestor,
                'supplier_id' => $this->supplier_id,
                'sales_office_id' => $this->sales_office_id,
                'zone_id' => $this->zone_id,
                'plan_delivery_date' => $this->plan_delivery_date,
//                'revised_delivery_date' => $this->revised_delivery_date,
//                'actual_delivery_date' => $this->actual_delivery_date,
                'plan_arrival_date' => $this->plan_arrival_date,
                'transaction_date' => $this->transaction_date,
                'delivery_remarks' => $this->delivery_remarks,
                'total_amount' => $this->total_amount,
                'created_by' => $this->created_by,
                'po_no' => $this->po_no,
                'po_date' => $this->po_date,
                'rra_no' => $this->rra_no,
                'rra_date' => $this->rra_date,
                'recipients' => $this->recipients,
            );

            $receiving_inventory->attributes = $receiving_inventory_data;

            if (count($transaction_details) > 0) {
                if ($receiving_inventory->save(false)) {

                    $receiving_details = array();
                    for ($i = 0; $i < count($transaction_details); $i++) {
                        $receiving_inv_detail = ReceivingInventoryDetail::model()->createReceivingTransactionDetails($receiving_inventory->receiving_inventory_id, $receiving_inventory->company_id, $transaction_details[$i]['sku_id'], $transaction_details[$i]['uom_id'], $transaction_details[$i]['sku_status_id'], $receiving_inventory->zone_id, $transaction_details[$i]['batch_no'], $transaction_details[$i]['unit_price'], $receiving_inventory->transaction_date, $transaction_details[$i]['expiration_date'], $transaction_details[$i]['planned_quantity'], $transaction_details[$i]['qty_received'], $transaction_details[$i]['amount'], $transaction_details[$i]['remarks'], $receiving_inventory->pr_no, $receiving_inventory->pr_date, $receiving_inventory->created_by, $receiving_inventory->pr_no, $receiving_inventory->pr_date, $receiving_inventory->plan_arrival_date, $receiving_inventory->po_no, $transaction_details[$i]['remarks']);

                        $receiving_details[] = $receiving_inv_detail;
                    }

                    $data['success'] = true;
                    $data['header_data'] = $receiving_inventory;
                    $data['detail_data'] = $receiving_details;
                }
            }
        } catch (Exception $exc) {
            pr($exc);
            Yii::log($exc->getTraceAsString(), 'error');
        }

        return $data;
    }

    public function getDeliveryRemarks() {
        return array(
            array('id' => "ON TIME", 'title' => "ON TIME", 'label_style' => 'success'),
            array('id' => "DELAY", 'title' => "DELAY", 'label_style' => 'danger'),
            array('id' => "ADVANCE", 'title' => "ADVANCE", 'label_style' => 'primary'),
        );
    }

    public function getDeliveryRemarksLabel($status_value) {

        $deliveryRemarks = $this->getDeliveryRemarks();

        $status = "";
        foreach ($deliveryRemarks as $val) {
            if ($val['id'] == trim($status_value)) {
                $status = '<span class="label label-' . $val['label_style'] . '">' . $status_value . '</span>';
            }
        }

        return $status;
    }

    public function validateEmails($model, $emails) {

        $data = array();

        if (count($emails) > 0) {

            foreach ($emails as $k => $v) {

                if (trim($v['value']) != "") {
                    if (!filter_var($v['value'], FILTER_VALIDATE_EMAIL)) {
                        $data[$v['id']][] = "Email is invalid.";
                    }
                } else {
                    $data[$v['id']][] = "Email not set.";
                }
            }
        } else {

            $data['Emails'][] = "Email Required.";
        }

        return $data;
    }

    public function validateRecipients($model, $recipients) {

        $data = array();

        if (count($recipients) > 0) {

            foreach ($recipients as $k => $v) {

                if (trim($v['value']) == "") {
                    $data[$v['id']][] = "Recipient name required.";
                }
            }
        } else {

            $data['Recipients'][] = "Recipient Required.";
        }

        return $data;
    }

    public function mergeRecipientAndEmails($emails, $recipients) {

        $data = array();
        $emails_arr = array();
        $recipients_arr = array();

        foreach ($recipients as $k => $v) {
            $recipients_arr[] = array(
                'name' => ucwords($v['value'])
            );
        }

        foreach ($emails as $k1 => $v1) {
            $emails_arr[] = array(
                'address' => $v1['value']
            );
        }

        foreach ($emails_arr as $k => $v) {
            $data[$k] = array_merge($emails_arr[$k], $recipients_arr[$k]);
        }

        return $data;
    }

}
