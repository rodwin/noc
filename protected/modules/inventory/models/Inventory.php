<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property integer $inventory_id
 * @property string $company_id
 * @property string $sku_id
 * @property integer $qty
 * @property string $uom_id
 * @property string $zone_id
 * @property string $sku_status_id
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property string $expiration_date
 * @property string $reference_no
 * @property string $cost_per_unit
 * @property string $transaction_date
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Sku $sku
 * @property SkuStatus $skuStatus
 * @property Uom $uom
 * @property Zone $zone
 * @property InventoryHistory[] $inventoryHistories
 */
class Inventory extends CActiveRecord {

    public $search_string;
    public $inventory_on_hand;
    public $total_ave_cost_per_unit;

    const INVENTORY_ACTION_TYPE_INCREASE = 'increase';
    const INVENTORY_ACTION_TYPE_DECREASE = 'decrease';
    const INVENTORY_ACTION_TYPE_MOVE = 'move';
    const INVENTORY_ACTION_TYPE_CONVERT = 'convert';
    const INVENTORY_ACTION_TYPE_UPDATE = 'update';
    const INVENTORY_ACTION_TYPE_APPLY = 'apply';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, sku_id, qty, uom_id, zone_id, transaction_date', 'required'),
            array('qty', 'numerical', 'integerOnly' => true),
            array('company_id, sku_id, uom_id, zone_id, sku_status_id, created_by, updated_by, campaign_no, pr_no, po_no', 'length', 'max' => 50),
            array('reference_no', 'length', 'max' => 250),
            array('cost_per_unit', 'length', 'max' => 18),
            array('cost_per_unit', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
            array('sku_id', 'isValidSKU'),
            array('uom_id', 'isValidUOM'),
            array('zone_id', 'isValidZone'),
            array('sku_status_id', 'isValidSKUStatus'),
            array('transaction_date,expiration_date, updated_date, expiration_date, pr_date, plan_arrival_date, revised_delivery_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('inventory_id, company_id, sku_id, qty, uom_id, zone_id, sku_status_id, created_date, created_by, updated_date, updated_by, expiration_date, reference_no, campaign_no, pr_no, pr_date, plan_arrival_date, revised_delivery_date, po_no', 'safe', 'on' => 'search'),
        );
    }

    public function isValidSKUStatus($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = SkuStatus::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Status ' . $this->$attribute . ' is invalid');
        }

        return;
    }

    public function isValidZone($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Zone ' . $this->$attribute . ' is invalid');
        }

        return;
    }

    public function isValidSKU($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = SKU::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'MM ' . $this->$attribute . ' is invalid');
        }

        return;
    }

    public function isValidUOM($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = Uom::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'UOM ' . $this->$attribute . ' is invalid');
        }

        return;
    }

    public function beforeValidate() {

        if ($this->qty == "") {
            $this->qty = 0;
        }

        if ($this->cost_per_unit == "") {
            $this->cost_per_unit = null;
        }

        if ($this->zone_id == "") {
            $this->zone_id = null;
        }

        if ($this->uom_id == "") {
            $this->uom_id = null;
        }

        if ($this->sku_status_id == "") {
            $this->sku_status_id = null;
        }

        if ($this->plan_arrival_date == "") {
            $this->plan_arrival_date = null;
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
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'sku' => array(self::BELONGS_TO, 'Sku', 'sku_id'),
            'skuStatus' => array(self::BELONGS_TO, 'SkuStatus', 'sku_status_id'),
            'uom' => array(self::BELONGS_TO, 'Uom', 'uom_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
            'inventoryHistories' => array(self::HAS_MANY, 'InventoryHistory', 'inventory_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'inventory_id' => 'Inventory',
            'company_id' => 'Company',
            'sku_id' => Sku::SKU_LABEL,
            'cost_per_unit' => 'Cost Per Unit',
            'qty' => 'Qty',
            'uom_id' => 'Uom',
            'zone_id' => 'Zone',
            'sku_status_id' => 'MM Status',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'expiration_date' => 'Expiration Date',
            'reference_no' => 'Batch No',
            'campaign_no' => 'Campaign No',
            'pr_no' => 'PR No',
            'pr_date' => 'PR Date',
            'plan_arrival_date' => 'Plan Arrival Date',
            'revised_delivery_date' => 'Revised Delivery Date',
            'po_no' => 'PO No',
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

        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('zone_id', $this->zone_id, true);
        $criteria->compare('sku_status_id', $this->sku_status_id, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('reference_no', $this->reference_no, true);
        $criteria->compare('campaign_no', $this->campaign_no, true);
        $criteria->compare('pr_no', $this->pr_no, true);
        $criteria->compare('pr_date', $this->pr_date, true);
        $criteria->compare('plan_arrival_date', $this->plan_arrival_date, true);
        $criteria->compare('revised_delivery_date', $this->revised_delivery_date, true);
        $criteria->compare('po_no', $this->po_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function olddata($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'sku.sku_code';
                break;
            case 1:
                $sort_column = 'sku.description';
                break;
            case 2:
                $sort_column = 'qty';
                break;
            case 3:
                $sort_column = 'uom.uom_name';
                break;
            case 5:
                $sort_column = 'zone.zone_name';
                break;
            case 6:
                $sort_column = 'skuStatus.status_name';
                break;
            case 7:
                $sort_column = 't.po_no';
                break;
            case 8:
                $sort_column = 'expiration_date';
                break;
            case 9:
                $sort_column = 'reference_no';
                break;
            case 10:
                $sort_column = 'sku.brand.brand_name';
                break;
            case 11:
                $sort_column = 'zone.salesOffice.sales_office_name';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('sku.sku_code', $columns[0]['search']['value'], true);
        $criteria->compare('sku.description', $columns[1]['search']['value'], true);
        $criteria->compare('qty', $columns[2]['search']['value'], true);
        $criteria->compare('uom.uom_name', $columns[3]['search']['value'], true);
        $criteria->compare('zone.zone_name', $columns[5]['search']['value'], true);
        $criteria->compare('skuStatus.status_name', $columns[6]['search']['value'], true);
        $criteria->compare('t.po_no', $columns[7]['search']['value'], true);
        $criteria->compare('expiration_date', $columns[8]['search']['value'], true);
        $criteria->compare('reference_no', $columns[9]['search']['value'], true);
        $criteria->compare('sku.brand.brand_name', $columns[10]['search']['value'], true);
        $criteria->compare('zone.salesOffice.sales_office_name', $columns[11]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->with = array('sku', 'sku.brand', 'skuStatus', 'uom', 'zone', 'zone.salesOffice');
        $criteria->limit = $limit;
        $criteria->offset = $offset;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'sku.sku_code';
                break;
            case 1:
                $sort_column = 'sku.description';
                break;
            case 2:
                $sort_column = 'qty';
                break;
            case 3:
                $sort_column = 'uom.uom_name';
                break;
            case 5:
                $sort_column = 'zone.zone_name';
                break;
            case 6:
                $sort_column = 'skuStatus.status_name';
                break;
            case 7:
                $sort_column = 't.po_no';
                break;
            case 8:
                $sort_column = 't.pr_no';
                break;
            case 9:
                $sort_column = 't.pr_date';
                break;
            case 10:
                $sort_column = 't.plan_arrival_date';
                break;
            case 11:
                $sort_column = 't.reference_no';
                break;
            case 12:
                $sort_column = 't.expiration_date';
                break;
            case 13:
                $sort_column = 'sku.brand.brand_name';
                break;
            case 14:
                $sort_column = 'zone.salesOffice.sales_office_name';
                break;
        }

        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('sku.sku_code', $columns[0]['search']['value'], true);
        $criteria->compare('sku.description', $columns[1]['search']['value'], true);
        $criteria->compare('qty', $columns[2]['search']['value'], true);
        $criteria->compare('uom.uom_name', $columns[3]['search']['value'], true);
        $criteria->compare('zone.zone_name', $columns[5]['search']['value'], true);
        $criteria->compare('skuStatus.status_name', $columns[6]['search']['value'], true);
        $criteria->compare('t.po_no', $columns[7]['search']['value'], true);
        $criteria->compare('t.pr_no', $columns[8]['search']['value'], true);
        $criteria->compare('t.pr_date', $columns[9]['search']['value'], true);
        $criteria->compare('t.plan_arrival_date', $columns[10]['search']['value'], true);
        $criteria->compare('t.reference_no', $columns[11]['search']['value'], true);
        $criteria->compare('t.expiration_date', $columns[12]['search']['value'], true);
        $criteria->compare('sku.brand.brand_name', $columns[13]['search']['value'], true);
        $criteria->compare('zone.salesOffice.sales_office_name', $columns[14]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->with = array('sku', 'sku.brand', 'skuStatus', 'uom', 'zone', 'zone.salesOffice');
        $criteria->limit = $limit;
        $criteria->offset = $offset;

        $arr = array();
        $unserialize = CJSON::decode(Yii::app()->user->userObj->userType->data);
        $zones = CJSON::decode(isset($unserialize['zone']) ? $unserialize['zone'] : "");

        foreach ($zones as $key => $val) {
            $arr[] = $key;
        }

        $criteria->addInCondition('t.zone_id', $arr);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function recentlyCreatedItems($company_id, $limit = 20) {

        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', $company_id);
        $criteria->order = "t.created_date desc";
        $criteria->with = array('sku', 'sku.brand', 'skuStatus', 'uom', 'zone', 'zone.salesOffice');
        $criteria->limit = $limit;

        return Inventory::model()->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Inventory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function increase($company_id, $inventory_id, $qty, $transaction_date, $cost_per_unit) {
        $model = Inventory::model()->findByAttributes(array('inventory_id' => $inventory_id, 'company_id' => $company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model->qty = bcadd($model->qty, $qty);
        $model->transaction_date = $transaction_date;
        $model->cost_per_unit = $cost_per_unit;

        if ($model->validate()) {

            try {

                $model->save();

                //InventoryHistory::model()->createHistory($company_id, $inventory_id, $qty, $model->qty, self::INVENTORY_ACTION_TYPE_INCREASE, $cost_per_unit);

                return true;
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }
        }

        return false;
    }

    public function decrease($company_id, $inventory_id, $qty, $transaction_date) {
        $model = Inventory::model()->findByAttributes(array('inventory_id' => $inventory_id, 'company_id' => $company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model->qty = bcsub($model->qty, $qty);
        $model->transaction_date = $transaction_date;

        if ($model->validate()) {
            try {

                $model->save();
                $qty = $qty * -1;
                //InventoryHistory::model()->createHistory($company_id, $inventory_id, $qty, $model->qty, self::INVENTORY_ACTION_TYPE_DECREASE, 0);

                return true;
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }
        }

        return false;
    }

    public function move($company_id, $inventory_id, $move_qty, $move_to_zone, $move_status, $transaction_date) {
        $model = Inventory::model()->findByAttributes(array('inventory_id' => $inventory_id, 'company_id' => $company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');


        $move = new Inventory;
        $move->company_id = $company_id;
        $move->qty = $move_qty;
        $move->zone_id = $move_to_zone;
        $move->sku_status_id = $move_status;
        $move->transaction_date = $transaction_date;
        $move->sku_id = $model->sku_id;
        $move->uom_id = $model->uom_id;

        if ($move->validate()) {
            try {

                $move->save();
                $qty = bcsub($model->qty, $move_qty);
                $move_qty = $move_qty * -1;

                $model->qty = $qty;
                $model->save();

                //InventoryHistory::model()->createHistory($company_id, $inventory_id, $move_qty, $qty, self::INVENTORY_ACTION_TYPE_MOVE);

                return true;
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }
        }

        return false;
    }

    public function updateInvByInvID($inventory_id, $company_id, $quantity) {
        Inventory::model()->updateAll(array('qty' => $quantity), 'inventory_id = ' . $inventory_id . ' AND company_id = "' . $company_id . '"');
    }

    public function getTotalCountInventoryByMonth($year, $month) {

        $c = new CDbCriteria;
        $c->select = "t.*, AVG(inventoryHistories.ave_cost_per_unit) as total_ave_cost_per_unit";
        $c->condition = "YEAR(t.created_date) = '" . $year . "' AND MONTH(t.created_date) = '" . $month . "' AND inventoryHistories.created_date = (SELECT MAX(z.created_date) FROM inventory_history z WHERE z.inventory_id = t.inventory_id)";
        $c->with = array("inventoryHistories");
        $c->group = "YEAR(t.created_date), MONTH(t.created_date)";
        $inventory = Inventory::model()->find($c);

        return $inventory;
    }

    public function getTotalCountInventoryByMonthAndByBrand($year, $month, $brand_category_id, $brand_id) {

        $qry = array();

        if ($brand_category_id != "") {
            $qry[] = "brand_category.brand_category_id = '" . $brand_category_id . "'";
        }
        if ($brand_id != "") {
            $qry[] = "brand.brand_id = '" . $brand_id . "'";
        }

        if (count($qry) > 0) {
            $criteria = "AND " . implode(" AND ", $qry);
        } else {
            $criteria = "";
        }

        $c = new CDbCriteria;
        $c->select = "t.*, AVG(inventoryHistories.ave_cost_per_unit) as total_ave_cost_per_unit";
        $c->condition = "YEAR(t.created_date) = '" . $year . "' AND MONTH(t.created_date) = '" . $month . "' AND inventoryHistories.created_date = (SELECT MAX(z.created_date) FROM inventory_history z WHERE z.inventory_id = t.inventory_id) $criteria";
        $c->with = array("inventoryHistories");
        $c->join = "LEFT JOIN sku ON sku.sku_id = t.sku_id";
        $c->join .= " LEFT JOIN brand ON brand.brand_id = sku.brand_id";
        $c->join .= " LEFT JOIN brand_category ON brand_category.brand_category_id = brand.brand_category_id";
        $c->group = "YEAR(t.created_date), MONTH(t.created_date)";
        $inventory = Inventory::model()->find($c);

        return $inventory;
    }

    public function getTotalInventoryOnHandByMonth($year, $month) {

        $c = new CDbCriteria;
        $c->select = "t.*, SUM(t.qty) as inventory_on_hand";
        $c->condition = "YEAR(t.created_date) = '" . $year . "' AND MONTH(t.created_date) = '" . $month . "'";
        $c->group = "YEAR(t.created_date), MONTH(t.created_date)";
        $inventory = Inventory::model()->find($c);

        return $inventory;
    }

    public function getTotalInventoryOnHandByMonthAndByBrand($year, $month, $brand_category_id, $brand_id) {

        $qry = array();

        if ($brand_category_id != "") {
            $qry[] = "brand_category.brand_category_id = '" . $brand_category_id . "'";
        }
        if ($brand_id != "") {
            $qry[] = "brand.brand_id = '" . $brand_id . "'";
        }

        if (count($qry) > 0) {
            $criteria = "AND " . implode(" AND ", $qry);
        } else {
            $criteria = "";
        }

        $c = new CDbCriteria;
        $c->select = "t.*, SUM(t.qty) as inventory_on_hand";
        $c->condition = "YEAR(t.created_date) = '" . $year . "' AND MONTH(t.created_date) = '" . $month . "' $criteria";
        $c->join = "LEFT JOIN sku ON sku.sku_id = t.sku_id";
        $c->join .= " LEFT JOIN brand ON brand.brand_id = sku.brand_id";
        $c->join .= " LEFT JOIN brand_category ON brand_category.brand_category_id = brand.brand_category_id";
        $c->group = "YEAR(t.created_date), MONTH(t.created_date)";
        $inventory = Inventory::model()->find($c);

        return $inventory;
    }

    public function status($status_value) {

        $status = "";
        switch ($status_value) {
            case OutgoingInventory::OUTGOING_PENDING_STATUS:
                $status = '<span class="label label-warning">' . OutgoingInventory::OUTGOING_PENDING_STATUS . '</span>';
                break;
            case OutgoingInventory::OUTGOING_COMPLETE_STATUS:
                $status = '<span class="label label-success">' . OutgoingInventory::OUTGOING_COMPLETE_STATUS . '</span>';
                break;
            case OutgoingInventory::OUTGOING_INCOMPLETE_STATUS:
                $status = '<span class="label label-danger">' . OutgoingInventory::OUTGOING_INCOMPLETE_STATUS . '</span>';
                break;
            case OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS:
                $status = '<span class="label label-primary">' . OutgoingInventory::OUTGOING_OVER_DELIVERY_STATUS . '</span>';
                break;
            default:
                break;
        }

        return $status;
    }

    public function requiredHeaders() {

        $headers = $this->attributeLabels();
        unset($headers['inventory_id']);
        unset($headers['company_id']);
        unset($headers['campaign_no']);
        unset($headers['revised_delivery_date']);
        unset($headers['created_date']);
        unset($headers['created_by']);
        unset($headers['updated_date']);
        unset($headers['updated_by']);

        return $headers;
    }

    public function generateTemplate() {

        header('Content-Type: application/excel');
        header('Content-Disposition: attachment; filename="inventory.csv"');

        $fp = fopen('php://output', 'w');
        $cols = "";

        $headers = $this->requiredHeaders();
        foreach ($headers as $k => $v) {
            $cols .= $v . ',';
        }

        fputcsv($fp, explode(',', $cols));
        fclose($fp);
        exit();
    }

    public function processBatchUpload($id, $company_id) {

        $BatchUploadModel = BatchUpload::model()->findByPk($id);

        if ($BatchUploadModel === null) {
            throw new CException('The requested model does not exist.');
        }

        $ret = array();

        $rows = Globals::parseCSV($BatchUploadModel->file, true, true, ',');

        $ret['success'] = 0;
        $ret['fail'] = 0;
        $ret['inserted'] = 0;
        $ret['updated'] = 0;
        $ret['message'] = "";
        $incomplete_field = 0;
        $message = "";

        $required_headers = Inventory::model()->requiredHeaders();

        if ($rows && count($rows) > 0) {

            foreach ($required_headers as $key => $value) {
                if (!isset($rows[0][$value])) {
                    $incomplete_field++;
                    $message .= $value . ',';
                }
            }

            if ($incomplete_field > 0) {

                $ret['message'] = "Could not find the following column(s): " . substr($message, 0, -1);
                $BatchUploadModel->error_message = $ret['message'];
                $BatchUploadModel->status = BatchUpload::STATUS_ERROR;
            } else {

                foreach ($rows as $key => $val) {

                    $sku = Sku::model()->find(array("condition" => "company_id = '" . $company_id . "' AND TRIM(sku_code) = '" . trim($val[$required_headers['sku_id']]) . "'"));
                    $uom = Uom::model()->find(array("condition" => "company_id = '" . $company_id . "' AND TRIM(uom_name) = '" . trim($val[$required_headers['uom_id']]) . "'"));
                    $zone = Zone::model()->find(array("condition" => "company_id = '" . $company_id . "' AND TRIM(zone_name) = '" . trim($val[$required_headers['zone_id']]) . "'"));
                    $sku_status = SkuStatus::model()->find(array("condition" => "company_id = '" . $company_id . "' AND TRIM(status_name) = '" . trim($val[$required_headers['sku_status_id']]) . "'"));
                    
                    $data = array(
                        'company_id' => $company_id,
                        'sku_id' => isset($sku->sku_id) ? $sku->sku_id : trim($val[$required_headers['sku_id']]),
                        'cost_per_unit' => trim($val[$required_headers['cost_per_unit']]),
                        'uom_id' => isset($uom->uom_id) ? $uom->uom_id : trim($val[$required_headers['uom_id']]),
                        'zone_id' => isset($zone->zone_id) ? $zone->zone_id : trim($val[$required_headers['zone_id']]),
                        'sku_status_id' => isset($sku_status->sku_status_id) ? $sku_status->sku_status_id : trim($val[$required_headers['sku_status_id']]),
                        'transaction_date' => date("Y-m-d"),
                        'expiration_date' => trim($val[$required_headers['expiration_date']]) != "" ? trim($val[$required_headers['expiration_date']]) : null,
                        'reference_no' => trim($val[$required_headers['reference_no']]),
                        'pr_no' => trim($val[$required_headers['pr_no']]),
                        'pr_date' => trim($val[$required_headers['pr_date']]) != "" ? trim($val[$required_headers['pr_date']]) : null,
                        'plan_arrival_date' => trim($val[$required_headers['plan_arrival_date']]) != "" ? trim($val[$required_headers['plan_arrival_date']]) : null,
                        'po_no' => trim($val[$required_headers['po_no']]),
                    );

                    $inventoryObj = Inventory::model()->findByAttributes(
                            array(
                                'company_id' => $company_id,
                                'sku_id' => isset($sku->sku_id) ? $sku->sku_id : null,
                                'uom_id' => isset($uom->uom_id) ? $uom->uom_id : null,
                                'zone_id' => isset($zone->zone_id) ? $zone->zone_id : null,
                                'sku_status_id' => isset($sku_status->sku_status_id) ? $sku_status->sku_status_id : null,
                                'expiration_date' => trim($val[$required_headers['expiration_date']]) != "" ? trim($val[$required_headers['expiration_date']]) : null,
                                'po_no' => trim($val[$required_headers['po_no']]),
                                'pr_no' => trim($val[$required_headers['pr_no']]),
                                'pr_date' => trim($val[$required_headers['pr_date']]) != "" ? trim($val[$required_headers['pr_date']]) : null,
                                'plan_arrival_date' => trim($val[$required_headers['plan_arrival_date']]) != "" ? trim($val[$required_headers['plan_arrival_date']]) : null,
                            )
                    );

                    if ($val[$required_headers['qty']] != "") {
                        $qty = trim($val[$required_headers['qty']]);
                    } else {
                        $qty = 0;
                    }

                    if ($inventoryObj) {

                        $increase = false;
                        $decrease = false;

                        if ($inventoryObj->qty > $qty) {
                            $new_qty = ($inventoryObj->qty - $qty);
                            $decrease = true;
                        } else if ($inventoryObj->qty < $qty) {
                            $new_qty = ($qty - $inventoryObj->qty);
                            $increase = true;
                        } else {
                            $new_qty = $inventoryObj->qty;
                        }

                        $model = $inventoryObj;

                        $model->qty = $qty;
                        $model->attributes = $data;
                        $model->updated_date = date('Y-m-d H:i:s');
                        $model->updated_by = $BatchUploadModel->created_by;

                        $model->validate();
                        if ($model->validate()) {
                            try {
                                if ($model->save(false)) {

                                    if ($increase === true) {
                                        InventoryHistory::model()->createHistory($model->company_id, $model->inventory_id, $model->transaction_date, $new_qty, $qty, Inventory::INVENTORY_ACTION_TYPE_INCREASE, $model->cost_per_unit, $model->created_by, $model->zone_id);
                                    } else if ($decrease === true) {
                                        InventoryHistory::model()->createHistory($model->company_id, $model->inventory_id, $model->transaction_date, "-" . $new_qty, $qty, Inventory::INVENTORY_ACTION_TYPE_DECREASE, $model->cost_per_unit, $model->created_by, $model->zone_id);
                                    } else {
                                        InventoryHistory::model()->createHistory($model->company_id, $model->inventory_id, $model->transaction_date, $new_qty, 0, Inventory::INVENTORY_ACTION_TYPE_INCREASE, $model->cost_per_unit, $model->created_by, $model->zone_id);
                                    }
                                }

                                $ret['success'] ++;
                                $ret['updated'] ++;
                            } catch (Exception $exc) {
                                $ret['fail'] ++;
                                $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $exc->errorInfo[2], $company_id);
                            }
                        } else {
                            $ret['fail'] ++;
                            $errors = Globals::getSingleLineErrorMessage($model->getErrors());

                            $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $errors, $company_id);
                        }
                    } else {

                        $data['created_by'] = $BatchUploadModel->created_by;

                        $model = new Inventory;
                        $model->qty = $qty;
                        $model->created_by = $BatchUploadModel->created_by;
                        $model->attributes = $data;

                        $model->validate();
                        if ($model->validate()) {
                            try {
                                if ($model->save(false)) {

                                    InventoryHistory::model()->createHistory($model->company_id, $model->inventory_id, $model->transaction_date, $model->qty, $qty, Inventory::INVENTORY_ACTION_TYPE_INCREASE, $model->cost_per_unit, $model->created_by, $model->zone_id);
                                }

                                $ret['success'] ++;
                                $ret['inserted'] ++;
                            } catch (Exception $exc) {
                                $ret['fail'] ++;
                                $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $exc->errorInfo[2], $company_id);
                            }
                        } else {
                            $ret['fail'] ++;
                            $errors = Globals::getSingleLineErrorMessage($model->getErrors());

                            $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $errors, $company_id);
                        }
                    }
                }

                if ($ret['fail'] > 0) {
                    $BatchUploadModel->status = BatchUpload::STATUS_WARNING;
                } else {
                    $BatchUploadModel->status = BatchUpload::STATUS_DONE;
                }
            }
        } else {
            $ret['message'] = "No data to process";
            $BatchUploadModel->error_message = $ret['message'];
            $BatchUploadModel->status = BatchUpload::STATUS_ERROR;
        }

        $BatchUploadModel->failed_rows = $ret['fail'];
        $BatchUploadModel->total_rows = bcadd($ret['success'], $ret['fail']);
        $BatchUploadModel->ended_date = date('Y-m-d H:i:s');
        return $BatchUploadModel->save();
    }

    public function saveBatchUploadDetail($batch_id, $message, $company_id) {

        $model = new BatchUploadDetail;
        $model->company_id = $company_id;
        $model->batch_upload_id = $batch_id;
        $model->message = $message;
        return $model->save();
    }

}
