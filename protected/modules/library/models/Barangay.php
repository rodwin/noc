<?php

/**
 * This is the model class for table "barangay".
 *
 * The followings are the available columns in table 'barangay':
 * @property string $barangay_code
 * @property string $barangay_name
 * @property string $barangay_type
 * @property string $municipal_code
 * @property integer $population
 * @property double $longitude
 * @property double $latitude
 */
class Barangay extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'barangay';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('population', 'numerical', 'integerOnly'=>true),
			array('longitude, latitude', 'numerical'),
			array('barangay_code, municipal_code', 'length', 'max'=>10),
			array('barangay_name', 'length', 'max'=>50),
			array('barangay_type', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('barangay_code, barangay_name, barangay_type, municipal_code, population, longitude, latitude', 'safe', 'on'=>'search'),
		);
	}
        
        public function beforeValidate() {
            return parent::beforeValidate();
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'barangay_code' => 'Barangay Code',
			'barangay_name' => 'Barangay Name',
			'barangay_type' => 'Barangay Type',
			'municipal_code' => 'Municipal Code',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('barangay_code',$this->barangay_code,true);
		$criteria->compare('barangay_name',$this->barangay_name,true);
		$criteria->compare('barangay_type',$this->barangay_type,true);
		$criteria->compare('municipal_code',$this->municipal_code,true);
		$criteria->compare('population',$this->population);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('latitude',$this->latitude);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'barangay_code';
                        break;
                                        
                        case 1:
                        $sort_column = 'barangay_name';
                        break;
                                        
                        case 2:
                        $sort_column = 'barangay_type';
                        break;
                                        
                        case 3:
                        $sort_column = 'municipal_code';
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
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('barangay_code',$columns[0]['search']['value'],true);
		$criteria->compare('barangay_name',$columns[1]['search']['value'],true);
		$criteria->compare('barangay_type',$columns[2]['search']['value'],true);
		$criteria->compare('municipal_code',$columns[3]['search']['value'],true);
		$criteria->compare('population',$columns[4]['search']['value']);
		$criteria->compare('longitude',$columns[5]['search']['value']);
		$criteria->compare('latitude',$columns[6]['search']['value']);
                $criteria->order = "$sort_column $order_dir";
                $criteria->limit = $limit;
                $criteria->offset = $offset;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Barangay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}