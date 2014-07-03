<?php

/**
 * This is the model class for table "sales_office".
 *
 * The followings are the available columns in table 'sales_office':
 * @property string $sales_office_id
 * @property string $distributor_id
 * @property string $company_id
 * @property string $sales_office_code
 * @property string $sales_office_name
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
 * @property Distributor $distributor
 * @property Zone[] $zones
 */
class SalesOffice extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sales_office';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sales_office_id, distributor_id, company_id, sales_office_code, sales_office_name', 'required'),
			array('barangay_id, municipal_id, province_id, region_id', 'numerical', 'integerOnly'=>true),
			array('sales_office_id, distributor_id, company_id, sales_office_code, created_by, updated_by', 'length', 'max'=>50),
			array('sales_office_name, address1, address2', 'length', 'max'=>200),
			array('latitude, longitude', 'length', 'max'=>9),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sales_office_id, distributor_id, company_id, sales_office_code, sales_office_name, address1, address2, barangay_id, municipal_id, province_id, region_id, latitude, longitude, created_date, created_by, updated_date, updated_by', 'safe', 'on'=>'search'),
		);
	}
        
        public function beforeValidate() {
            
            if($this->latitude == ""){
                $this->latitude = null;
            }
            if($this->longitude == ""){
                $this->longitude = null;
            }
            
            if ($this->scenario == 'create') {
            
                $this->company_id = Yii::app()->user->company_id;
                
                $this->sales_office_id = Globals::generateV4UUID();                
                unset($this->created_date);
                $this->created_by = Yii::app()->user->userObj->user_name;
            } else {
                $this->updated_date = date('Y-m-d H:i:s');
                $this->updated_by = Yii::app()->user->userObj->user_name;
            }
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'distributor' => array(self::BELONGS_TO, 'Distributor', 'distributor_id'),
			'zones' => array(self::HAS_MANY, 'Zone', 'sales_office_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sales_office_id' => 'Sales Office',
			'distributor_id' => 'Distributor',
			'company_id' => 'Company',
			'sales_office_code' => 'Sales Office Code',
			'sales_office_name' => 'Sales Office Name',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sales_office_id',$this->sales_office_id,true);
		$criteria->compare('distributor_id',$this->distributor_id,true);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('sales_office_code',$this->sales_office_code,true);
		$criteria->compare('sales_office_name',$this->sales_office_name,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('barangay_id',$this->barangay_id);
		$criteria->compare('municipal_id',$this->municipal_id);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'sales_office_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'distributor_id';
                        break;
                                        
                        case 2:
                        $sort_column = 'sales_office_code';
                        break;
                                        
                        case 3:
                        $sort_column = 'sales_office_name';
                        break;
                                        
                        case 4:
                        $sort_column = 'address1';
                        break;
                                        
                        case 5:
                        $sort_column = 'address2';
                        break;
                                        
                        case 6:
                        $sort_column = 'barangay_id';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('sales_office_id',$columns[0]['search']['value'],true);
		$criteria->compare('distributor_id',$columns[1]['search']['value'],true);
		$criteria->compare('sales_office_code',$columns[2]['search']['value'],true);
		$criteria->compare('sales_office_name',$columns[3]['search']['value'],true);
		$criteria->compare('address1',$columns[4]['search']['value'],true);
		$criteria->compare('address2',$columns[5]['search']['value'],true);
		$criteria->compare('barangay_id',$columns[6]['search']['value']);
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
	 * @return SalesOffice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}