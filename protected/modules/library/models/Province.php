<?php

/**
 * This is the model class for table "province".
 *
 * The followings are the available columns in table 'province':
 * @property string $province_code
 * @property string $province_name
 * @property string $region_code
 * @property string $income_class
 * @property integer $population
 * @property double $longitude
 * @property double $latitude
 */
class Province extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'province';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('population', 'numerical', 'integerOnly' => true),
            array('longitude, latitude', 'numerical'),
            array('province_code, region_code', 'length', 'max' => 10),
            array('province_name', 'length', 'max' => 50),
            array('income_class', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('province_code, province_name, region_code, income_class, population, longitude, latitude', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'province_code' => 'Province Code',
            'province_name' => 'Province Name',
            'region_code' => 'Region Code',
            'income_class' => 'Income Class',
            'population' => 'Population',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
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

        $criteria->compare('province_code', $this->province_code, true);
        $criteria->compare('province_name', $this->province_name, true);
        $criteria->compare('region_code', $this->region_code, true);
        $criteria->compare('income_class', $this->income_class, true);
        $criteria->compare('population', $this->population);
        $criteria->compare('longitude', $this->longitude);
        $criteria->compare('latitude', $this->latitude);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'province_code';
                break;

            case 1:
                $sort_column = 'province_name';
                break;

            case 2:
                $sort_column = 'region_code';
                break;

            case 3:
                $sort_column = 'income_class';
                break;

            case 4:
                $sort_column = 'population';
                break;

            case 5:
                $sort_column = 'longitude';
                break;

            case 6:
                $sort_column = 'latitude';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('province_code', $columns[0]['search']['value'], true);
        $criteria->compare('province_name', $columns[1]['search']['value'], true);
        $criteria->compare('region_code', $columns[2]['search']['value'], true);
        $criteria->compare('income_class', $columns[3]['search']['value'], true);
        $criteria->compare('population', $columns[4]['search']['value']);
        $criteria->compare('longitude', $columns[5]['search']['value']);
        $criteria->compare('latitude', $columns[6]['search']['value']);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Province the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
