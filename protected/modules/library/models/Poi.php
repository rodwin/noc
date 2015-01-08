<?php

/**
 * This is the model class for table "poi".
 *
 * The followings are the available columns in table 'poi':
 * @property string $poi_id
 * @property string $company_id
 * @property string $short_name
 * @property string $long_name
 * @property string $primary_code
 * @property string $secondary_code
 * @property integer $barangay_id
 * @property integer $municipal_id
 * @property integer $province_id
 * @property integer $region_id
 * @property integer $sales_region_id
 * @property string $latitude
 * @property string $longitude
 * @property string $address1
 * @property string $address2
 * @property string $zip
 * @property string $landline
 * @property string $mobile
 * @property string $poi_category_id
 * @property string $poi_sub_category_id
 * @property string $remarks
 * @property string $status
 * @property string $created_date
 * @property string $created_by
 * @property string $edited_date
 * @property string $edited_by
 * @property string $verified_by
 * @property string $verified_date
 *
 * The followings are the available model relations:
 * @property PoiCustomDataValue[] $poiCustomDataValues
 * @property PoiCategory $poiCategory
 * @property PoiSubCategory $poiSubCategory
 */
class Poi extends CActiveRecord {

    public $search_string;
    public $barangay_name;
    public $municipal_name;
    public $province_name;
    public $region_name;

    const POI_LABEL = "Outlet";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'poi';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('poi_id, company_id, short_name, primary_code', 'required'),
            array('sales_region_id', 'numerical', 'integerOnly' => true),
            array('poi_id, company_id, zip, landline, mobile, poi_category_id, poi_sub_category_id, status', 'length', 'max' => 50),
            array('short_name, address1, address2', 'length', 'max' => 200),
            array('long_name, remarks', 'length', 'max' => 250),
            array('primary_code, secondary_code, created_by, edited_by, verified_by', 'length', 'max' => 100),
//            array('latitude, longitude', 'length', 'max' => 9),
            array('latitude, longitude', 'numerical'),
            array('primary_code', 'uniquePrimaryCode'),
            array('poi_category_id', 'isValidPoiCategory'),
            array('poi_sub_category_id', 'isValidPoiSubCategory'),
            array('region_id', 'isValidRegionCode'),
            array('province_id', 'isValidProvinceCode'),
            array('municipal_id', 'isValidMunicipalCode'),
            array('barangay_id', 'isValidBarangayCode'),
            array('created_date, edited_date, verified_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('poi_id, company_id, short_name, long_name, primary_code, secondary_code, barangay_id, municipal_id, province_id, region_id, sales_region_id, latitude, longitude, address1, address2, zip, landline, mobile, poi_category_id, poi_sub_category_id, remarks, status, created_date, created_by, edited_date, edited_by, verified_by, verified_date', 'safe', 'on' => 'search'),
        );
    }

    public function uniquePrimaryCode($attribute, $params) {

        $model = Poi::model()->findByAttributes(array('company_id' => $this->company_id, 'primary_code' => $this->$attribute));
        if ($model && $model->poi_id != $this->poi_id) {
            $this->addError($attribute, 'Primary code selected already taken.');
        }
        return;
    }

    public function isValidPoiCategory($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = PoiCategory::model()->findByAttributes(array("poi_category_id" => $this->$attribute));

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Poi Category is invalid.');
        }

        return;
    }

    public function isValidPoiSubCategory($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = PoiSubCategory::model()->findByAttributes(array("poi_sub_category_id" => $this->$attribute, "poi_category_id" => $this->poi_category_id));

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Poi Sub Category is invalid.');
        }

        return;
    }

    public function isValidRegionCode($attribute) {
        if ($this->$attribute == null) {
            return;
        }
        $model = Region::model()->findByAttributes(array("region_code" => $this->$attribute));

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Region name is invalid.');
        }

        return;
    }

    public function isValidProvinceCode($attribute) {

        if ($this->$attribute == null) {
            return;
        }

        $model = Province::model()->findByAttributes(array("province_code" => $this->$attribute));

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Province name is invalid.');
        }

        return;
    }

    public function isValidMunicipalCode($attribute) {

        if ($this->$attribute == null) {
            return;
        }

        $model = Municipal::model()->findByAttributes(array("municipal_code" => $this->$attribute));

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Municpal name is invalid.');
        }

        return;
    }

    public function isValidBarangayCode($attribute) {

        if ($this->$attribute == null) {
            return;
        }

        $model = Barangay::model()->findByAttributes(array("barangay_code" => $this->$attribute));

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Barangay name is invalid.');
        }

        return;
    }

    public function beforeValidate() {
        if ($this->scenario == 'create') {

            unset($this->created_date);
            unset($this->edited_date);
            unset($this->verified_date);
        } else {
            $this->edited_date = date('Y-m-d H:i:s');
            unset($this->verified_date);
        }

        if ($this->latitude == "") {
            $this->latitude = 0;
        }
        if ($this->longitude == "") {
            $this->longitude = 0;
        }

        if ($this->poi_category_id == "") {
            $this->poi_category_id = null;
        }
        if ($this->poi_sub_category_id == "") {
            $this->poi_sub_category_id = null;
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
            'poiCustomDataValues' => array(self::HAS_MANY, 'PoiCustomDataValue', 'poi_id'),
            'poiCategory' => array(self::BELONGS_TO, 'PoiCategory', 'poi_category_id'),
            'poiSubCategory' => array(self::BELONGS_TO, 'PoiSubCategory', 'poi_sub_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'poi_id' => Poi::POI_LABEL,
            'company_id' => 'Company',
            'short_name' => 'Short Name',
            'long_name' => 'Long Name',
            'primary_code' => 'Primary Code',
            'secondary_code' => 'Secondary Code',
            'sales_region_id' => 'Sales Region',
            'region_id' => 'Region',
            'province_id' => 'Province',
            'municipal_id' => 'Municipal',
            'barangay_id' => 'Barangay',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'zip' => 'Zip',
            'landline' => 'Landline',
            'mobile' => 'Mobile',
            'poi_category_id' => Poi::POI_LABEL . ' Category',
            'poi_sub_category_id' => Poi::POI_LABEL . ' Sub Category',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'edited_date' => 'Edited Date',
            'edited_by' => 'Edited By',
            'verified_by' => 'Verified By',
            'verified_date' => 'Verified Date',
        );
    }

    public function requiredHeaders($company_id) {

        $headers = $this->attributeLabels();
        unset($headers['poi_id']);
        unset($headers['company_id']);
//        unset($headers['poi_category_id']);
        unset($headers['created_date']);
        unset($headers['created_by']);
        unset($headers['edited_date']);
        unset($headers['edited_by']);
        unset($headers['updated_date']);
        unset($headers['updated_by']);
        unset($headers['verified_date']);
        unset($headers['verified_by']);

        $poi_category = PoiCategory::model()->findAllByAttributes(array("company_id" => $company_id));

        $custom_fields = array();
        foreach ($poi_category as $key => $val) {

            $criteria = new CDbCriteria();
            $criteria->order = "sort_order";
            $model = PoiCustomData::model()->findAllByAttributes(array('company_id' => $company_id, "type" => $val['poi_category_id']), $criteria);

            foreach ($model as $v) {
                $custom_fields[$v['type']][str_replace(" ", "_", strtolower($v['name']))] = $v['name'];
            }
        }

        return array(
            'headers' => $headers,
            'custom_data' => $custom_fields,
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

        $criteria->compare('poi_id', $this->poi_id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('short_name', $this->short_name, true);
        $criteria->compare('long_name', $this->long_name, true);
        $criteria->compare('primary_code', $this->primary_code, true);
        $criteria->compare('secondary_code', $this->secondary_code, true);
        $criteria->compare('barangay_id', $this->barangay_id);
        $criteria->compare('municipal_id', $this->municipal_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('region_id', $this->region_id);
        $criteria->compare('sales_region_id', $this->sales_region_id);
        $criteria->compare('latitude', $this->latitude, true);
        $criteria->compare('longitude', $this->longitude, true);
        $criteria->compare('address1', $this->address1, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('landline', $this->landline, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('poi_category_id', $this->poi_category_id, true);
        $criteria->compare('poi_sub_category_id', $this->poi_sub_category_id, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('edited_date', $this->edited_date, true);
        $criteria->compare('edited_by', $this->edited_by, true);
        $criteria->compare('verified_by', $this->verified_by, true);
        $criteria->compare('verified_date', $this->verified_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

//            case 0:
//                $sort_column = 'poi_id';
//                break;

            case 0:
                $sort_column = 't.short_name';
                break;

//            case 1:
//                $sort_column = 't.long_name';
//                break;

            case 1:
                $sort_column = 't.primary_code';
                break;

            case 2:
                $sort_column = 't.address1';
                break;

            case 3:
                $sort_column = 't.address2';
                break;

//            case 3:
//                $sort_column = 't.secondary_code';
//                break;

//            case 4:
//                $sort_column = 'poiCategory.category_name';
//                break;
//
//            case 5:
//                $sort_column = 'poiSubCategory.sub_category_name';
//                break;
//
//            case 6:
//                $sort_column = 'barangay_name';
//                break;
//
//            case 7:
//                $sort_column = 'municipal_name';
//                break;
//
//            case 8:
//                $sort_column = 'province_name';
//                break;
//
//            case 9:
//                $sort_column = 'region_name';
//                break;
        }


        $criteria = new CDbCriteria;
//        $criteria->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
//                . "province.province_name as province_name, region.region_name as region_name";
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
//        $criteria->compare('poi_id', $columns[0]['search']['value'], true);
        $criteria->compare('t.short_name', $columns[0]['search']['value'], true);
//        $criteria->compare('t.long_name', $columns[1]['search']['value'], true);
        $criteria->compare('t.primary_code', $columns[1]['search']['value'], true);
        $criteria->compare('t.address1', $columns[2]['search']['value'], true);
        $criteria->compare('t.address2', $columns[3]['search']['value'], true);
//        $criteria->compare('t.secondary_code', $columns[3]['search']['value'], true);
//        $criteria->compare('poiCategory.category_name', $columns[4]['search']['value']);
//        $criteria->compare('poiSubCategory.sub_category_name', $columns[5]['search']['value']);
//        $criteria->compare('barangay_name', $columns[6]['search']['value']);
//        $criteria->compare('municipal_name', $columns[7]['search']['value']);
//        $criteria->compare('province_name', $columns[8]['search']['value']);
//        $criteria->compare('region_name', $columns[9]['search']['value']);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array('poiCategory', 'poiSubCategory');
//        $criteria->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
//        $criteria->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
//        $criteria->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
//        $criteria->join .= ' LEFT JOIN region ON region.region_code = t.region_id';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    public function poidata($col, $order_dir, $limit, $offset, $columns, $poi_ids) {
        switch ($col) {

//            case 0:
//                $sort_column = 'poi_id';
//                break;

            case 0:
                $sort_column = 't.short_name';
                break;

            case 1:
                $sort_column = 't.long_name';
                break;

            case 2:
                $sort_column = 't.primary_code';
                break;

            case 3:
                $sort_column = 't.secondary_code';
                break;

            case 4:
                $sort_column = 'poiCategory.category_name';
                break;

            case 5:
                $sort_column = 'poiSubCategory.sub_category_name';
                break;

            case 6:
                $sort_column = 'barangay_name';
                break;

            case 7:
                $sort_column = 'municipal_name';
                break;

            case 8:
                $sort_column = 'province_name';
                break;

            case 9:
                $sort_column = 'region_name';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
                . "province.province_name as province_name, region.region_name as region_name";
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
//        $criteria->compare('poi_id', $columns[0]['search']['value'], true);
        $criteria->compare('t.short_name', $columns[0]['search']['value'], true);
        $criteria->compare('t.long_name', $columns[1]['search']['value'], true);
        $criteria->compare('t.primary_code', $columns[2]['search']['value'], true);
        $criteria->compare('t.secondary_code', $columns[3]['search']['value'], true);
        $criteria->compare('poiCategory.category_name', $columns[4]['search']['value']);
        $criteria->compare('poiSubCategory.sub_category_name', $columns[5]['search']['value']);
        $criteria->compare('barangay_name', $columns[6]['search']['value']);
        $criteria->compare('municipal_name', $columns[7]['search']['value']);
        $criteria->compare('province_name', $columns[8]['search']['value']);
        $criteria->compare('region_name', $columns[9]['search']['value']);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->condition = "t.poi_id NOT IN (" . $poi_ids . ")";
        $criteria->with = array('poiCategory', 'poiSubCategory');
        $criteria->join = 'LEFT JOIN barangay ON barangay.barangay_code = t.barangay_id';
        $criteria->join .= ' LEFT JOIN municipal ON municipal.municipal_code = t.municipal_id';
        $criteria->join .= ' LEFT JOIN province ON province.province_code = t.province_id';
        $criteria->join .= ' LEFT JOIN region ON region.region_code = t.region_id';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Poi the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateTemplate($poi_category_id) {

        $poi_category = PoiCategory::model()->findByAttributes(array("company_id" => Yii::app()->user->company_id, "poi_category_id" => $poi_category_id));

        header('Content-Type: application/excel');
//        header('Content-Disposition: attachment; filename="poi_' . str_replace(" ", "_", strtolower($poi_category->category_name)) . '.csv"');
        header('Content-Disposition: attachment; filename="poi.csv"');

        $fp = fopen('php://output', 'w');
        $cols = "";

        $headers = $this->requiredHeaders(Yii::app()->user->company_id);

        foreach ($headers['headers'] as $k => $v) {
            $cols .= $v . ',';
        }

        if (count($headers['custom_data']) > 0) {

            foreach ($headers['custom_data'] as $key => $val) {

                if ($key == $poi_category->poi_category_id) {

                    foreach ($val as $field_name) {

                        $cols .= ucwords($field_name) . ',';
                    }
                }
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

        $headers = Poi::model()->requiredHeaders($company_id);

        $count_custom_data = 0;
        $category_id = "";
        $custom_data_header = array();
        $custom_fields = array();
        $arr_headers = array();
        $arr_custom_fields = array();
        $required_headers = $headers['headers'];

        if (count($headers['custom_data']) > 0) {
            foreach ($headers['custom_data'] as $key => $val) {

                $model = PoiCustomData::model()->findAllByAttributes(array('company_id' => $company_id, "type" => $key));

                foreach ($model as $v) {
                    $custom_fields[$v['type']][] = $v['name'];
                }

                if ($rows && count($rows) > 0) {

                    for ($x = 0; $x < count($custom_fields[$key]); $x++) {

                        $arr_headers[$key][str_replace(' ', '_', strtolower($custom_fields[$key][$x]))] = ucwords($custom_fields[$key][$x]);
                        $arr_custom_fields[$key][] = str_replace(' ', '_', strtolower($custom_fields[$key][$x]));

                        if (array_key_exists(ucwords($custom_fields[$key][$x]), $rows[0])) {
                            $category_id = $key;
                        }
                    }
                }
            }

            if ($category_id != "") {
                $required_headers = array_merge($required_headers, $arr_headers[$category_id]);
                $custom_data_header = $arr_custom_fields[$category_id];
            }
        }

        $count_custom_data = count($custom_data_header);

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

                    $region = Region::model()->findByAttributes(array(), $condition = 'trim(t.region_name) = "' . trim($val[$required_headers['region_id']]) . '"');
                    $province = Province::model()->findByAttributes(array(), $condition = 'trim(t.province_name) = "' . trim($val[$required_headers['province_id']]) . '"');
                    $municipal = Municipal::model()->findByAttributes(array(), $condition = 'trim(t.municipal_name) = "' . trim($val[$required_headers['municipal_id']]) . '"');
                    $barangay = Barangay::model()->findByAttributes(array(), $condition = 'trim(t.barangay_name) = "' . trim($val[$required_headers['barangay_id']]) . '"');
                    $poi_category = PoiCategory::model()->findByAttributes(array("category_name" => trim($val[$required_headers['poi_category_id']]), 'company_id' => $company_id));
                    $poi_sub_category = PoiSubCategory::model()->findByAttributes(array("sub_category_name" => trim($val[$required_headers['poi_sub_category_id']]), 'company_id' => $company_id));

                    $data = array(
                        'company_id' => $company_id,
                        'short_name' => $val[$required_headers['short_name']],
                        'long_name' => $val[$required_headers['long_name']],
                        'primary_code' => $val[$required_headers['primary_code']],
                        'secondary_code' => $val[$required_headers['secondary_code']],
                        'region_id' => isset($region->region_code) ? $region->region_code : $val[$required_headers['region_id']],
                        'province_id' => isset($province->province_code) ? $province->province_code : $val[$required_headers['province_id']],
                        'municipal_id' => isset($municipal->municipal_code) ? $municipal->municipal_code : $val[$required_headers['municipal_id']],
                        'barangay_id' => isset($barangay->barangay_code) ? $barangay->barangay_code : $val[$required_headers['barangay_id']],
                        'sales_region_id' => $val[$required_headers['sales_region_id']],
                        'latitude' => $val[$required_headers['latitude']],
                        'longitude' => $val[$required_headers['longitude']],
                        'address1' => $val[$required_headers['address1']],
                        'address2' => $val[$required_headers['address2']],
                        'zip' => $val[$required_headers['zip']],
                        'landline' => $val[$required_headers['landline']],
                        'mobile' => $val[$required_headers['mobile']],
//                        'poi_category_id' => $category_id,
                        'poi_category_id' => isset($poi_category->poi_category_id) ? $poi_category->poi_category_id : $val[$required_headers['poi_category_id']],
                        'poi_sub_category_id' => isset($poi_sub_category->poi_sub_category_id) ? $poi_sub_category->poi_sub_category_id : $val[$required_headers['poi_sub_category_id']],
                        'remarks' => $val[$required_headers['remarks']],
                        'status' => $val[$required_headers['status']],
                    );

                    $custom_data = array();
                    $poi_custom_data = new PoiCustomDataValue;
                    if ($count_custom_data > 0) {
                        for ($i = 0; $i < $count_custom_data; $i++) {
                            $poi_custom_field = PoiCustomData::model()->findByAttributes(array('name' => $required_headers[$custom_data_header[$i]], 'company_id' => $company_id));

                            $custom_data[] = array(
                                'custom_data_id' => $poi_custom_field->custom_data_id,
                                'value' => $val[$required_headers[$custom_data_header[$i]]],
                            );

                            PoiCustomData::model()->validateAllCustomDataValue($poi_custom_data, $company_id, $required_headers[$custom_data_header[$i]], trim($val[$required_headers[$custom_data_header[$i]]]));
                        }
                    }

                    $model = Poi::model()->findByAttributes(array('primary_code' => $val[$required_headers['primary_code']], 'company_id' => $company_id));

                    if ($model) {//for update
                        $model->attributes = $data;
                        $model->edited_date = date('Y-m-d H:i:s');
                        $model->edited_by = $BatchUploadModel->created_by;

                        $model->validate();
                        if ($model->validate() && count($poi_custom_data->getErrors()) == 0) {
                            try {
                                $model->save();

                                // delete poi custom data value by poi_id
                                PoiCustomDataValue::model()->deletePoiCustomDataValueByPoiID($model->poi_id);

                                if ($model->save() && $count_custom_data > 0) {
                                    for ($i = 0; $i < $count_custom_data; $i++) {
                                        $poi_custom_data_value = new PoiCustomDataValue;
                                        $poi_custom_data_value->poi_id = $model->poi_id;
                                        $poi_custom_data_value->attributes = $custom_data[$i];
                                        $poi_custom_data_value->save();
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
                            $custom_data_errors = Globals::getSingleLineErrorMessage($poi_custom_data->getErrors());

                            $comma = "";
                            if (count($model->getErrors()) > 0 && count($poi_custom_data->getErrors()) > 0) {
                                $comma = ",";
                            }

                            $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $errors . (count($poi_custom_data->getErrors()) > 0 ? $comma . $custom_data_errors : ""), $company_id);
                        }
                    } else {// for insert
                        $data['poi_id'] = Globals::generateV4UUID();
                        $data['created_by'] = $BatchUploadModel->created_by;

                        $model = new Poi;
                        $model->attributes = $data;

                        $model->validate();
                        if ($model->validate() && count($poi_custom_data->getErrors()) == 0) {
                            try {
                                $model->save();

                                if ($model->save() && $count_custom_data > 0) {
                                    for ($i = 0; $i < $count_custom_data; $i++) {
                                        $poi_custom_data_value = new PoiCustomDataValue;
                                        $poi_custom_data_value->poi_id = $model->poi_id;
                                        $poi_custom_data_value->attributes = $custom_data[$i];
                                        $poi_custom_data_value->validate();
                                        $poi_custom_data_value->save();
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
                            $custom_data_errors = Globals::getSingleLineErrorMessage($poi_custom_data->getErrors());

                            $comma = "";
                            if (count($model->getErrors()) > 0 && count($poi_custom_data->getErrors()) > 0) {
                                $comma = ",";
                            }

                            $this->saveBatchUploadDetail($BatchUploadModel->id, "Row " . ($key + 2) . ": " . $errors . (count($poi_custom_data->getErrors()) > 0 ? $comma . $custom_data_errors : ""), $company_id);
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
