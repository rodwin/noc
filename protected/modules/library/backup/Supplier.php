<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property string $supplier_id
 * @property string $company_id
 * @property string $supplier_code
 * @property string $supplier_name
 * @property string $contact_person1
 * @property string $contact_person2
 * @property string $telephone
 * @property string $cellphone
 * @property string $fax_number
 * @property string $address1
 * @property string $address2
 * @property integer $barangay_id
 * @property integer $municipal_id
 * @property integer $province_id
 * @property integer $region_id
 * @property string $latitude
 * @property string $longitude
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class Supplier extends CActiveRecord {

    public $search_string;
    public $barangay_name;
    public $municipal_name;
    public $province_name;
    public $region_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'supplier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('supplier_id, company_id, supplier_code, supplier_name', 'required'),
            array('barangay_id, municipal_id, province_id, region_id', 'numerical', 'integerOnly' => true),
            array('supplier_id, company_id, supplier_code, contact_person1, contact_person2, telephone, cellphone, fax_number', 'length', 'max' => 50),
            array('supplier_name, address1, address2', 'length', 'max' => 200),
            array('latitude, longitude', 'length', 'max' => 9),
            array('created_by, updated_by', 'length', 'max' => 100),
            array('latitude, longitude', 'numerical'),
            array('supplier_code', 'uniqueSupplierCode'),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('supplier_id, company_id, supplier_code, supplier_name, contact_person1, contact_person2, telephone, cellphone, fax_number, address1, address2, barangay_id, municipal_id, province_id, region_id, latitude, longitude, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueSupplierCode($attribute, $params) {

        $model = Supplier::model()->findByAttributes(array('company_id' => $this->company_id, 'supplier_code' => $this->$attribute));
        if ($model && $model->supplier_id != $this->supplier_id) {
            $this->addError($attribute, 'Supplier code selected already taken.');
        }
        return;
    }

    public function beforeValidate() {

        if ($this->latitude == "") {
            $this->latitude = 0;
        }
        if ($this->longitude == "") {
            $this->longitude = 0;
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'supplier_id' => 'Supplier',
            'company_id' => 'Company',
            'supplier_code' => 'Supplier Code',
            'supplier_name' => 'Supplier Name',
            'contact_person1' => 'Contact Person1',
            'contact_person2' => 'Contact Person2',
            'telephone' => 'Telephone',
            'cellphone' => 'Cellphone',
            'fax_number' => 'Fax Number',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'barangay_id' => 'Barangay',
            'municipal_id' => 'Municipal',
            'province_id' => 'Province',
            'region_id' => 'Region',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
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

        $criteria->compare('supplier_id', $this->supplier_id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('supplier_code', $this->supplier_code, true);
        $criteria->compare('supplier_name', $this->supplier_name, true);
        $criteria->compare('contact_person1', $this->contact_person1, true);
        $criteria->compare('contact_person2', $this->contact_person2, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('cellphone', $this->cellphone, true);
        $criteria->compare('fax_number', $this->fax_number, true);
        $criteria->compare('address1', $this->address1, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('barangay_id', $this->barangay_id);
        $criteria->compare('municipal_id', $this->municipal_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('region_id', $this->region_id);
        $criteria->compare('latitude', $this->latitude, true);
        $criteria->compare('longitude', $this->longitude, true);
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

//            case 0:
//                $sort_column = 'supplier_id';
//                break;

            case 0:
                $sort_column = 'supplier_code';
                break;

            case 1:
                $sort_column = 'supplier_name';
                break;

            case 2:
                $sort_column = 'contact_person1';
                break;

            case 3:
                $sort_column = 'telephone';
                break;

            case 4:
                $sort_column = 'address1';
                break;

            case 5:
                $sort_column = 'barangay_name';
                break;

            case 6:
                $sort_column = 'municipal_name';
                break;

            case 7:
                $sort_column = 'province_name';
                break;

            case 8:
                $sort_column = 'region_name';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->select = "t.*, barangay.barangay_name as barangay_name, municipal.municipal_name as municipal_name, "
                . "province.province_name as province_name, region.region_name as region_name";
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
//        $criteria->compare('supplier_id', $columns[0]['search']['value'], true);
        $criteria->compare('t.supplier_code', $columns[0]['search']['value'], true);
        $criteria->compare('t.supplier_name', $columns[1]['search']['value'], true);
        $criteria->compare('t.contact_person1', $columns[2]['search']['value'], true);
        $criteria->compare('t.telephone', $columns[3]['search']['value'], true);
        $criteria->compare('t.address1', $columns[4]['search']['value'], true);
        $criteria->compare('barangay_name', $columns[5]['search']['value'], true);
        $criteria->compare('municipal_name', $columns[6]['search']['value'], true);
        $criteria->compare('province_name', $columns[7]['search']['value'], true);
        $criteria->compare('region_name', $columns[8]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
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
     * @return Supplier the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
