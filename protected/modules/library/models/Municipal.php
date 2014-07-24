<?php

/**
 * This is the model class for table "municipal".
 *
 * The followings are the available columns in table 'municipal':
 * @property string $municipal_code
 * @property string $municipal_name
 * @property string $legislative_district
 * @property string $city_class
 * @property integer $income_class
 * @property string $province_code
 * @property integer $population
 * @property double $longitude
 * @property double $latitude
 */
class Municipal extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'municipal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('income_class, population', 'numerical', 'integerOnly' => true),
            array('longitude, latitude', 'numerical'),
            array('municipal_code, legislative_district, city_class, province_code', 'length', 'max' => 10),
            array('municipal_name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('municipal_code, municipal_name, legislative_district, city_class, income_class, province_code, population, longitude, latitude', 'safe', 'on' => 'search'),
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
            'municipal_code' => 'Municipal Code',
            'municipal_name' => 'Municipal Name',
            'legislative_district' => 'Legislative District',
            'city_class' => 'City Class',
            'income_class' => 'Income Class',
            'province_code' => 'Province Code',
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

        $criteria->compare('municipal_code', $this->municipal_code, true);
        $criteria->compare('municipal_name', $this->municipal_name, true);
        $criteria->compare('legislative_district', $this->legislative_district, true);
        $criteria->compare('city_class', $this->city_class, true);
        $criteria->compare('income_class', $this->income_class);
        $criteria->compare('province_code', $this->province_code, true);
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
                $sort_column = 'municipal_code';
                break;

            case 1:
                $sort_column = 'municipal_name';
                break;

            case 2:
                $sort_column = 'legislative_district';
                break;

            case 3:
                $sort_column = 'city_class';
                break;

            case 4:
                $sort_column = 'income_class';
                break;

            case 5:
                $sort_column = 'province_code';
                break;

            case 6:
                $sort_column = 'population';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('municipal_code', $columns[0]['search']['value'], true);
        $criteria->compare('municipal_name', $columns[1]['search']['value'], true);
        $criteria->compare('legislative_district', $columns[2]['search']['value'], true);
        $criteria->compare('city_class', $columns[3]['search']['value'], true);
        $criteria->compare('income_class', $columns[4]['search']['value']);
        $criteria->compare('province_code', $columns[5]['search']['value'], true);
        $criteria->compare('population', $columns[6]['search']['value']);
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
     * @return Municipal the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
