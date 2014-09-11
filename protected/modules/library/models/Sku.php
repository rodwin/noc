<?php

/**
 * This is the model class for table "sku".
 *
 * The followings are the available columns in table 'sku':
 * @property string $sku_id
 * @property string $sku_code
 * @property string $company_id
 * @property string $brand_id
 * @property string $sku_name
 * @property string $description
 * @property string $default_uom_id
 * @property string $default_unit_price
 * @property string $type
 * @property string $default_zone_id
 * @property string $supplier
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property integer $low_qty_threshold
 * @property integer $high_qty_threshold
 *
 * The followings are the available model relations:
 * @property Inventory[] $inventories
 * @property Brand $brand
 * @property Company $company
 * @property Uom $defaultUom
 * @property Zone $defaultZone
 */
class Sku extends CActiveRecord {

    /**
     * @var string sku_id
     * @soap
     */
    public $sku_id;
    
    /**
     * @var string sku_code
     * @soap
     */
    public $sku_code;
    
    /**
     * @var string company_id
     * @soap
     */
    public $company_id;
    
    /**
     * @var Brand brandObj
     * @soap
     */
    public $brandObj;
    
    /**
     * @var string sku_name
     * @soap
     */
    public $sku_name;
    
    /**
     * @var string description
     * @soap
     */
    public $description;
    
    
    
    public $search_string;

    //types
    const TYPE_FIXED = 'fixed';
    const TYPE_CONSUMABLE = 'consumable';
    const INFRA = "infra";
    const SKU_LABEL = "MM";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sku';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sku_id, sku_code, company_id, sku_name', 'required'),
            array('low_qty_threshold, high_qty_threshold', 'numerical', 'integerOnly' => true, 'max' => 9999999, 'min' => 0),
            array('sku_id, sku_code, company_id, brand_id, default_uom_id, type, sub_type, default_zone_id, created_by, updated_by', 'length', 'max' => 50),
            array('sku_name, description', 'length', 'max' => 150),
            array('sku_code', 'uniqueCode'),
            array('type', 'isValidType'),
            array('sub_type', 'isValidSubType'),
            array('default_uom_id', 'isValidUOM'),
            array('default_zone_id', 'isValidZone'),
            array('brand_id', 'isValidBrand'),
            array('default_unit_price', 'length', 'max' => 18),
            array('supplier', 'length', 'max' => 250),
            array('default_unit_price', 'match', 'pattern' => '/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('sku_id, sku_code, company_id, brand_id, sku_name, description, default_uom_id, default_unit_price, type, sub_type, default_zone_id, supplier, created_date, created_by, updated_date, updated_by, low_qty_threshold, high_qty_threshold', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueCode($attribute, $params) {

        $model = Sku::model()->findByAttributes(array('company_id' => $this->company_id, 'sku_code' => $this->$attribute));
        if ($model && $model->sku_id != $this->sku_id) {
            $this->addError($attribute, 'Sku code selected already taken');
        }
        return;
    }

    public function isValidType($attribute) {
        $data = trim($this->$attribute);

        if ($data == null) {
            return;
        }

        $label = $this->attributeLabels();

        if (!Validator::InArrayKey($data, $this->getOptions($attribute))) {
            $this->addError($attribute, $label[$attribute] . ' ' . $this->$attribute . ' is invalid!');
        }

        return;
    }

    public function isValidSubType($attribute) {
        $data = trim($this->$attribute);

        if ($data == null && $this->type == null) {
            return;
        }

        $sub_types = $this->getOptions($attribute);
        $label = $this->attributeLabels();

        if (isset($sub_types[$this->type]) && count($sub_types[$this->type]) > 0) {

            if (!Validator::InArrayKey($data, $sub_types[$this->type])) {
                $this->addError($attribute, $label[$attribute] . ' ' . $this->$attribute . ' is invalid!');
            }
        } else {
            if ($data != null) {
                $this->addError($attribute, $label[$attribute] . ' ' . $this->$attribute . ' is invalid!');
            }
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

    public function isValidBrand($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = Brand::model()->findbypk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Brand ' . $this->$attribute . ' is invalid');
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

    public function beforeValidate() {
        if ($this->default_uom_id == "") {
            $this->default_uom_id = null;
        }
        if ($this->default_zone_id == "") {
            $this->default_zone_id = null;
        }
        if ($this->brand_id == "") {
            $this->brand_id = null;
        }
        if ($this->type == "") {
            $this->type = null;
        }
        if ($this->default_unit_price == "") {
            $this->default_unit_price = 0;
        }

        if (isset($this->default_uom_id)) {
            $uom_id_already_convert = SkuConvertion::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'sku_id' => $this->sku_id, 'uom_id' => $this->default_uom_id));

            if ($uom_id_already_convert) {
                $this->addError("default_uom_id", "UOM already used as Unit of Measure in Convertion.");
            }
        }

        if (isset($this->default_zone_id)) {
            $zone_id_already_restock = SkuLocationRestock::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'sku_id' => $this->sku_id, 'zone_id' => $this->default_zone_id));

            if ($zone_id_already_restock) {
                $this->addError("default_zone_id", "Zone already used in Location Restock Levels.");
            }
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
            'inventories' => array(self::HAS_MANY, 'Inventory', 'sku_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'defaultUom' => array(self::BELONGS_TO, 'Uom', 'default_uom_id'),
            'defaultZone' => array(self::BELONGS_TO, 'Zone', 'default_zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'sku_id' => Sku::SKU_LABEL,
            'sku_code' => Sku::SKU_LABEL . ' Code',
            'company_id' => 'Company',
            'sku_name' => Sku::SKU_LABEL . ' Name',
            'brand_id' => 'Brand',
            'description' => Sku::SKU_LABEL . ' Description',
            'default_uom_id' => 'Unit of Measure',
            'default_unit_price' => 'Default Unit Price',
            'type' => Sku::SKU_LABEL . ' Category',
            'sub_type' => Sku::SKU_LABEL . ' Sub Category',
            'default_zone_id' => 'Default Zone',
            'supplier' => 'Supplier',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'low_qty_threshold' => 'Low Qty Threshold',
            'high_qty_threshold' => 'High Qty Threshold',
        );
    }

    public function requiredHeaders($company_id) {

        $headers = $this->attributeLabels();
        unset($headers['sku_id']);
        unset($headers['company_id']);
        unset($headers['created_date']);
        unset($headers['created_by']);
        unset($headers['updated_date']);
        unset($headers['updated_by']);

        $criteria = new CDbCriteria();
        $criteria->order = "sort_order";
        $model = SkuCustomData::model()->findAllByAttributes(array('company_id' => $company_id), $criteria);

//        foreach ($model as $key => $val) {
//            $headers[str_replace(' ', '_', strtolower($val['name']))] = $val['name'];
//        }
//        
//        return $headers;

        return array(
            'headers' => $headers,
            'custom_data' => $model,
        );
    }

    public function allType() {
        return array(
            self::TYPE_CONSUMABLE,
            self::TYPE_FIXED,
        );
    }

    function getOptions($name, $parent = NULL) {
        if ($parent == NULL OR $parent == '') {
            return $this->_getOptions($name);
        } else {
            $retval = $this->_getOptions($name);
            if (isset($retval[$parent])) {
                return $retval[$parent];
            }
        }

        return FALSE;
    }

    public function _getOptions($name) {
        $retval = NULL;
        switch ($name) {
            case 'other_type':
                $retval = array(
                    self::TYPE_CONSUMABLE => 'Consumable',
                    self::TYPE_FIXED => 'Fixed',
                );
                break;
            case 'type':
                foreach ($this->skuAllTypes() as $val) {
                    $retval[$val] = ucwords($val);
                }
                break;
            case 'sub_type':
                foreach ($this->skuAllTypes() as $val) {
                    $sub_type = $this->skuAllSubTypes($val);
                    $retval[$val] = array();
                    if (isset($sub_type)) {
                        foreach ($this->skuAllSubTypes($val) as $v) {
                            $retval[$val][$v] = ucwords($v);
                        }
                    }
                }
                break;
        }

        return $retval;
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

        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('sku_code', $this->sku_code, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('sku_name', $this->sku_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('default_uom_id', $this->default_uom_id, true);
        $criteria->compare('default_unit_price', $this->default_unit_price, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('sub_type', $this->sub_type, true);
        $criteria->compare('default_zone_id', $this->default_zone_id, true);
        $criteria->compare('supplier', $this->supplier, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('low_qty_threshold', $this->low_qty_threshold);
        $criteria->compare('high_qty_threshold', $this->high_qty_threshold);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

//            case 0:
//                $sort_column = 't.sku_id';
//                break;

            case 0:
                $sort_column = 't.sku_code';
                break;

            case 1:
                $sort_column = 't.sku_name';
                break;

            case 2:
                $sort_column = 't.description';
                break;

            case 3:
                $sort_column = 'brand.brand_name';
                break;

            case 5:
                $sort_column = 't.type';
                break;

            case 6:
                $sort_column = 't.sub_type';
                break;

            case 7:
                $sort_column = 'defaultUom.uom_name';
                break;

            case 8:
                $sort_column = 't.supplier';
                break;

            case 9:
                $sort_column = 'defaultZone.zone_name';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.sku_code', $columns[0]['search']['value'], true);
        $criteria->compare('t.sku_name', $columns[1]['search']['value'], true);
        $criteria->compare('t.description', $columns[2]['search']['value'], true);
        $criteria->compare('brand.brand_name', $columns[3]['search']['value'], true);
        $criteria->compare('t.type', $columns[5]['search']['value'], true);
        $criteria->compare('t.sub_type', $columns[6]['search']['value'], true);
        $criteria->compare('defaultUom.uom_name', $columns[7]['search']['value'], true);
        $criteria->compare('t.supplier', $columns[8]['search']['value'], true);
        $criteria->compare('defaultZone.zone_name', $columns[9]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array('brand', 'company', 'defaultUom', 'defaultZone');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sku the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateTemplate() {

        header('Content-Type: application/excel');
        header('Content-Disposition: attachment; filename="' . Sku::SKU_LABEL . '.csv"');

        $fp = fopen('php://output', 'w');
        $cols = "";
//        foreach ( $this->requiredHeaders() as $line => $v) {
//            $cols .= $v.',';
//            
//        }        
        $headers = $this->requiredHeaders(Yii::app()->user->company_id);
        foreach ($headers['headers'] as $k => $v) {
            $cols .= $v . ',';
        }
        if (count($headers['custom_data']) > 0) {
            foreach ($headers['custom_data'] as $k => $v) {
                $cols .= ucwords($v['name']) . ',';
            }
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
//        $required_headers = Sku::model()->requiredHeaders();
        $headers = Sku::model()->requiredHeaders($company_id);

        $count_custom_data = count($headers['custom_data']);
        $custom_data_header = array();
        $required_headers = $headers['headers'];
        foreach ($headers['custom_data'] as $val) {
            $required_headers[str_replace(' ', '_', strtolower($val['name']))] = ucwords($val['name']);
            $custom_data_header[] = str_replace(' ', '_', strtolower($val['name']));
        }

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

                    $brand = Brand::model()->findByAttributes(array("brand_name" => trim($val[$required_headers['brand_id']]), 'company_id' => $company_id));
                    $uom = Uom::model()->findByAttributes(array("uom_name" => trim($val[$required_headers['default_uom_id']]), 'company_id' => $company_id));
                    $zone = Zone::model()->findByAttributes(array("zone_name" => trim($val[$required_headers['default_zone_id']]), 'company_id' => $company_id));

                    $data = array(
                        'company_id' => $company_id,
                        'sku_code' => $val[$required_headers['sku_code']],
                        'brand_id' => isset($brand->brand_id) ? $brand->brand_id : $val[$required_headers['brand_id']],
                        'sku_name' => $val[$required_headers['sku_name']],
                        'description' => $val[$required_headers['description']],
                        'default_uom_id' => isset($uom->uom_id) ? $uom->uom_id : $val[$required_headers['default_uom_id']],
                        'default_unit_price' => $val[$required_headers['default_unit_price']],
                        'type' => $val[$required_headers['type']],
                        'sub_type' => $val[$required_headers['sub_type']],
                        'default_zone_id' => isset($zone->zone_id) ? $zone->zone_id : $val[$required_headers['default_zone_id']],
                        'supplier' => $val[$required_headers['supplier']],
                        'low_qty_threshold' => $val[$required_headers['low_qty_threshold']],
                        'high_qty_threshold' => $val[$required_headers['high_qty_threshold']],
                    );

                    $custom_data = array();
                    $sku_custom_data = new SkuCustomDataValue;
                    if ($count_custom_data > 0) {
                        for ($i = 0; $i < $count_custom_data; $i++) {
                            $sku_custom_field = SkuCustomData::model()->findByAttributes(array('name' => $required_headers[$custom_data_header[$i]], 'company_id' => $company_id));

                            $custom_data[] = array(
                                'custom_data_id' => $sku_custom_field->custom_data_id,
                                'value' => $val[$required_headers[$custom_data_header[$i]]],
                            );

                            SkuCustomData::model()->validateAllCustomDataValue($sku_custom_data, $company_id, $required_headers[$custom_data_header[$i]], trim($val[$required_headers[$custom_data_header[$i]]]));
                        }
                    }

                    $model = Sku::model()->findByAttributes(array('sku_code' => $val[$required_headers['sku_code']], 'company_id' => $company_id));

                    if ($model) {//for update
                        $model->attributes = $data;
                        $model->updated_date = date('Y-m-d H:i:s');
                        $model->updated_by = $BatchUploadModel->created_by;

                        $model->validate();
                        if ($model->validate() && count($sku_custom_data->getErrors()) == 0) {
                            try {
                                $model->save();

                                // delete sku custom data value by sku_id
                                SkuCustomDataValue::model()->deleteSkuCustomDataValueBySkuID($model->sku_id);

                                if ($model->save() && $count_custom_data > 0) {
                                    for ($i = 0; $i < $count_custom_data; $i++) {
                                        $sku_custom_data_value = new SkuCustomDataValue;
                                        $sku_custom_data_value->sku_id = $model->sku_id;
                                        $sku_custom_data_value->attributes = $custom_data[$i];
                                        $sku_custom_data_value->save();
                                    }
                                }

                                $ret['success'] ++;
                                $ret['updated'] ++;
                            } catch (Exception $exc) {
                                $ret['fail'] ++;
                                $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $exc->errorInfo[2], $company_id);
//                                $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $exc->getMessage(), $company_id);
                            }
                        } else {
                            $ret['fail'] ++;
                            $errors = Globals::getSingleLineErrorMessage($model->getErrors());
                            $custom_data_errors = Globals::getSingleLineErrorMessage($sku_custom_data->getErrors());

                            $comma = "";
                            if (count($model->getErrors()) > 0 && count($sku_custom_data->getErrors()) > 0) {
                                $comma = " ,";
                            }

                            $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $errors . (count($sku_custom_data->getErrors()) > 0 ? $comma . $custom_data_errors : ""), $company_id);
                        }
                    } else {// for insert
                        $data['sku_id'] = Globals::generateV4UUID();
                        $data['created_by'] = $BatchUploadModel->created_by;

                        $model = new Sku;
                        $model->attributes = $data;

                        $model->validate();
                        if ($model->validate() && count($sku_custom_data->getErrors()) == 0) {
                            try {
                                $model->save();

                                if ($model->save() && $count_custom_data > 0) {
                                    for ($i = 0; $i < $count_custom_data; $i++) {
                                        $sku_custom_data_value = new SkuCustomDataValue;
                                        $sku_custom_data_value->sku_id = $model->sku_id;
                                        $sku_custom_data_value->attributes = $custom_data[$i];
                                        $sku_custom_data_value->save();
                                    }
                                }

                                $ret['success'] ++;
                                $ret['inserted'] ++;
                            } catch (Exception $exc) {
                                $ret['fail'] ++;
                                $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $exc->errorInfo[2], $company_id);
//                                $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $exc->getMessage(), $company_id);
                            }
                        } else {
                            $ret['fail'] ++;
                            $errors = Globals::getSingleLineErrorMessage($model->getErrors());
                            $custom_data_errors = Globals::getSingleLineErrorMessage($sku_custom_data->getErrors());

                            $comma = "";
                            if (count($model->getErrors()) > 0 && count($sku_custom_data->getErrors()) > 0) {
                                $comma = " ,";
                            }

                            $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $errors . (count($sku_custom_data->getErrors()) > 0 ? $comma . $custom_data_errors : ""), $company_id);
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

    public function skuAllTypeList() {
        $arr = array();

        foreach ($this->skuAllTypes() as $val) {
            $arr[$val] = ucwords($val);
        }

        return $arr;
    }

    public function skuAllSubTypeList() {
        $arr = array();

        foreach ($this->skuAllTypes() as $val) {
            $sub_type = $this->skuAllSubTypes($val);
            $arr[$val] = array();
            if (isset($sub_type)) {
                foreach ($this->skuAllSubTypes($val) as $v) {
                    $arr[$val][$v] = ucwords($v);
                }
            }
        }
        return $arr[Sku::INFRA];
    }

    public function skuAllTypes() {
        return array(
            'promo',
            'merchandising',
            Sku::INFRA,
        );
    }

    public function skuAllSubTypes($type) {
        $types = $this->skuAllTypes();

        if ($type == $types[2]) {
            return array(
                'infra assigned',
                'infra on loan',
            );
        }
    }
    
    public function retrieveSkusByCriteria(SkuCriteria $SkuCriteria){
        
        $cdbcriteria = new CDbCriteria();
        $cdbcriteria->together = true;
        $cdbcriteria->with = array('brand');
        $cdbcriteria->compare('t.company_id', $SkuCriteria->company_id);
        $cdbcriteria->compare('t.sku_name', $SkuCriteria->sku_name,true);
        $cdbcriteria->compare('t.type', $SkuCriteria->type);
        $cdbcriteria->compare('t.sub_type', $SkuCriteria->sub_type);
        $cdbcriteria->compare('brand.brand_id', $SkuCriteria->brand_id);
        
        return Sku::model()->findAll($cdbcriteria);
        
    }

}
