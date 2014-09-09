<?php

/**
 * This is the model class for table "brand".
 *
 * The followings are the available columns in table 'brand':
 * @property string $brand_id
 * @property string $brand_category_id
 * @property string $brand_code
 * @property string $company_id
 * @property string $brand_name
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property BrandCategory $brandCategory
 * @property Company $company
 * @property Sku[] $skus
 */
class Brand extends CActiveRecord {
    
    /**
     * @var string brand_id
     * @soap
     */
    public $brand_id;
    
    /**
     * @var string brand_code
     * @soap
     */
    public $brand_code;
    
    /**
     * @var string brand_name
     * @soap
     */
    public $brand_name;
    
    /**
     * @var string company_id
     * @soap
     */
    public $company_id;
    
    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'brand';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('brand_category_id, brand_id, brand_code, company_id, brand_name', 'required'),
            array('brand_id, brand_category_id, brand_code, company_id, created_by, updated_by', 'length', 'max' => 50),
            array('brand_name', 'length', 'max' => 250),
            array('brand_code', 'uniqueCode'),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('brand_id, brand_category_id, brand_code, company_id, brand_name, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueCode($attribute, $params) {

        $model = Brand::model()->findByAttributes(array('company_id' => $this->company_id, 'brand_code' => $this->$attribute));
        if ($model && $model->brand_id != $this->brand_id) {
            $this->addError($attribute, 'Brand code selected already taken.');
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
            'brandCategory' => array(self::BELONGS_TO, 'BrandCategory', 'brand_category_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'skus' => array(self::HAS_MANY, 'Sku', 'brand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'brand_id' => 'Brand',
            'brand_category_id' => 'Brand Category',
            'brand_code' => 'Brand Code',
            'company_id' => 'Company',
            'brand_name' => 'Brand Name',
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

        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('brand_category_id', $this->brand_category_id, true);
        $criteria->compare('brand_code', $this->brand_code, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('brand_name', $this->brand_name, true);
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
//                $sort_column = 'brand_id';
//                break;

            case 0:
                $sort_column = 'brandCategory.category_name';
                break;

            case 1:
                $sort_column = 't.brand_code';
                break;

            case 2:
                $sort_column = 't.brand_name';
                break;

            case 3:
                $sort_column = 't.created_date';
                break;

            case 4:
                $sort_column = 't.created_by';
                break;

            case 5:
                $sort_column = 't.updated_date';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
//        $criteria->compare('t.brand_id', $columns[0]['search']['value'], true);
        $criteria->compare('brandCategory.category_name', $columns[0]['search']['value'], true);
        $criteria->compare('t.brand_code', $columns[1]['search']['value'], true);
        $criteria->compare('t.brand_name', $columns[2]['search']['value'], true);
        $criteria->compare('t.created_date', $columns[3]['search']['value'], true);
        $criteria->compare('t.created_by', $columns[4]['search']['value'], true);
        $criteria->compare('t.updated_date', $columns[5]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array('brandCategory', 'company', 'skus');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Brand the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
