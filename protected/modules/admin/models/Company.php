<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $company_id
 * @property integer $status_id
 * @property string $name
 * @property string $short_name
 * @property string $address1
 * @property string $address2
 * @property string $barangay_id
 * @property string $municipal_id
 * @property string $province_id
 * @property string $region_id
 * @property string $country
 * @property string $phone
 * @property string $fax
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $deleted_date
 * @property integer $deleted_by
 * @property integer $deleted
 */
class Company extends CActiveRecord
{
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
			array('status_id, name, short_name', 'required'),
			array('status_id, created_by, updated_by, deleted_by, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('short_name, barangay_id, municipal_id, province_id, region_id, country, phone, fax', 'length', 'max'=>50),
			array('address1, address2', 'length', 'max'=>250),
			array('created_date, updated_date, deleted_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('company_id, status_id, name, short_name, address1, address2, barangay_id, municipal_id, province_id, region_id, country, phone, fax, created_date, created_by, updated_date, updated_by, deleted_date, deleted_by, deleted', 'safe', 'on'=>'search'),
		);
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
			'name' => 'Name',
			'short_name' => 'Short Name',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'barangay_id' => 'Barangay',
			'municipal_id' => 'Municipal',
			'province_id' => 'Province',
			'region_id' => 'Region',
			'country' => 'Country',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'deleted_date' => 'Deleted Date',
			'deleted_by' => 'Deleted By',
			'deleted' => 'Deleted',
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

		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('barangay_id',$this->barangay_id,true);
		$criteria->compare('municipal_id',$this->municipal_id,true);
		$criteria->compare('province_id',$this->province_id,true);
		$criteria->compare('region_id',$this->region_id,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('deleted_date',$this->deleted_date,true);
		$criteria->compare('deleted_by',$this->deleted_by);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'company_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'status_id';
                        break;
                                        
                        case 2:
                        $sort_column = 'name';
                        break;
                                        
                        case 3:
                        $sort_column = 'short_name';
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
                $criteria->compare('company_id',$columns[0]['search']['value']);
		$criteria->compare('status_id',$columns[1]['search']['value']);
		$criteria->compare('name',$columns[2]['search']['value'],true);
		$criteria->compare('short_name',$columns[3]['search']['value'],true);
		$criteria->compare('address1',$columns[4]['search']['value'],true);
		$criteria->compare('address2',$columns[5]['search']['value'],true);
		$criteria->compare('barangay_id',$columns[6]['search']['value'],true);
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
