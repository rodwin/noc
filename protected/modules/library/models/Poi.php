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
            array('poi_id, company_id, short_name, primary_code, poi_category_id, poi_sub_category_id', 'required'),
            array('barangay_id, municipal_id, province_id, region_id, sales_region_id', 'numerical', 'integerOnly' => true),
            array('poi_id, company_id, zip, landline, mobile, poi_category_id, poi_sub_category_id, status', 'length', 'max' => 50),
            array('short_name, address1, address2', 'length', 'max' => 200),
            array('long_name, remarks', 'length', 'max' => 250),
            array('primary_code, secondary_code, created_by, edited_by, verified_by', 'length', 'max' => 100),
            array('latitude, longitude', 'length', 'max' => 9),
            array('latitude, longitude', 'type', 'type' => 'float', 'message' => '{attribute} must be number.'),
            array('created_date, edited_date, verified_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('poi_id, company_id, short_name, long_name, primary_code, secondary_code, barangay_id, municipal_id, province_id, region_id, sales_region_id, latitude, longitude, address1, address2, zip, landline, mobile, poi_category_id, poi_sub_category_id, remarks, status, created_date, created_by, edited_date, edited_by, verified_by, verified_date', 'safe', 'on' => 'search'),
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
            'poi_id' => 'Poi',
            'company_id' => 'Company',
            'short_name' => 'Short Name',
            'long_name' => 'Long Name',
            'primary_code' => 'Primary Code',
            'secondary_code' => 'Secondary Code',
            'barangay_id' => 'Barangay',
            'municipal_id' => 'Municipal',
            'province_id' => 'Province',
            'region_id' => 'Region',
            'sales_region_id' => 'Sales Region',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'zip' => 'Zip',
            'landline' => 'Landline',
            'mobile' => 'Mobile',
            'poi_category_id' => 'Poi Category',
            'poi_sub_category_id' => 'Poi Sub Category',
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

    public function catchError($attribute, $error) {

        $this->addError($attribute, $error);
    }

}
