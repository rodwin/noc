<?php

/**
 * This is the model class for table "region".
 *
 * The followings are the available columns in table 'region':
 * @property string $region_code
 * @property string $region_name
 * @property integer $provinces
 * @property integer $cities
 * @property integer $municipals
 * @property integer $brgys
 * @property integer $population
 */
class Region extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'region';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('provinces, cities, municipals, brgys, population', 'numerical', 'integerOnly' => true),
            array('region_code', 'length', 'max' => 10),
            array('region_name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('region_code, region_name, provinces, cities, municipals, brgys, population', 'safe', 'on' => 'search'),
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
            'region_code' => 'Region Code',
            'region_name' => 'Region Name',
            'provinces' => 'Provinces',
            'cities' => 'Cities',
            'municipals' => 'Municipals',
            'brgys' => 'Brgys',
            'population' => 'Population',
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

        $criteria->compare('region_code', $this->region_code, true);
        $criteria->compare('region_name', $this->region_name, true);
        $criteria->compare('provinces', $this->provinces);
        $criteria->compare('cities', $this->cities);
        $criteria->compare('municipals', $this->municipals);
        $criteria->compare('brgys', $this->brgys);
        $criteria->compare('population', $this->population);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'region_code';
                break;

            case 1:
                $sort_column = 'region_name';
                break;

            case 2:
                $sort_column = 'provinces';
                break;

            case 3:
                $sort_column = 'cities';
                break;

            case 4:
                $sort_column = 'municipals';
                break;

            case 5:
                $sort_column = 'brgys';
                break;

            case 6:
                $sort_column = 'population';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('region_code', $columns[0]['search']['value'], true);
        $criteria->compare('region_name', $columns[1]['search']['value'], true);
        $criteria->compare('provinces', $columns[2]['search']['value']);
        $criteria->compare('cities', $columns[3]['search']['value']);
        $criteria->compare('municipals', $columns[4]['search']['value']);
        $criteria->compare('brgys', $columns[5]['search']['value']);
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
     * @return Region the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
