<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property string $company_id
 * @property integer $status_id
 * @property string $industry
 * @property string $code
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property integer $province
 * @property string $country
 * @property string $phone
 * @property string $fax
 * @property string $zip_code
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 */

class Company extends CActiveRecord
{
        const STATUS_ACTIVE = 1;
        const STATUS_INACTIVE = 0;
    
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, status_id, code, name', 'required'),
			array('status_id, province', 'numerical', 'integerOnly'=>true),
			array('company_id, country, phone, fax, zip_code, created_by, updated_by', 'length', 'max'=>50),
			array('industry, code', 'length', 'max'=>200),
			array('name', 'length', 'max'=>150),
			array('code', 'unique'),
			array('address1, address2, city', 'length', 'max'=>250),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('company_id, status_id, industry, code, name, address1, address2, city, province, country, phone, fax, zip_code, created_date, created_by, updated_date, updated_by, deleted_date, deleted_by, deleted', 'safe', 'on'=>'search'),
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
			'company_id' => 'Company',
			'status_id' => 'Status',
			'industry' => 'Industry',
			'code' => 'Code',
			'name' => 'Company Name',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'city' => 'City',
			'province' => 'Province',
			'country' => 'Country',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'zip_code' => 'Zip Code',
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

		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('industry',$this->industry,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province',$this->province);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('zip_code',$this->zip_code,true);
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
                        $sort_column = 'status_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'industry';
                        break;
                                        
                        case 2:
                        $sort_column = 'code';
                        break;
                                        
                        case 3:
                        $sort_column = 'name';
                        break;
                                        
                        case 4:
                        $sort_column = 'address1';
                        break;
                                        
                        case 5:
                        $sort_column = 'address2';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('status_id',$columns[0]['search']['value']);
		$criteria->compare('industry',$columns[1]['search']['value'],true);
		$criteria->compare('code',$columns[2]['search']['value'],true);
		$criteria->compare('name',$columns[3]['search']['value'],true);
		$criteria->compare('address1',$columns[4]['search']['value'],true);
		$criteria->compare('address2',$columns[5]['search']['value'],true);
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
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
