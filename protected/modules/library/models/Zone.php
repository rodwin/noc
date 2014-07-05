<?php

/**
 * This is the model class for table "zone".
 *
 * The followings are the available columns in table 'zone':
 * @property string $zone_id
 * @property string $zone_name
 * @property string $company_id
 * @property string $sales_office_id
 * @property string $description
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property SkuLocationRestock[] $skuLocationRestocks
 * @property Inventory[] $inventories
 * @property Company $company
 * @property SalesOffice $salesOffice
 * @property Sku[] $skus
 */
class Zone extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zone_id, zone_name, company_id, sales_office_id', 'required'),
			array('zone_id, company_id, sales_office_id, created_by, updated_by', 'length', 'max'=>50),
			array('zone_name', 'length', 'max'=>200),
			array('description', 'length', 'max'=>250),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('zone_id, zone_name, company_id, sales_office_id, description, created_date, created_by, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'skuLocationRestocks' => array(self::HAS_MANY, 'SkuLocationRestock', 'zone_id'),
			'inventories' => array(self::HAS_MANY, 'Inventory', 'zone_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'salesOffice' => array(self::BELONGS_TO, 'SalesOffice', 'sales_office_id'),
			'skus' => array(self::HAS_MANY, 'Sku', 'default_zone_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'zone_id' => 'Zone',
			'zone_name' => 'Zone Name',
			'company_id' => 'Company',
			'sales_office_id' => 'Sales Office',
			'description' => 'Description',
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

		$criteria->compare('zone_id',$this->zone_id,true);
		$criteria->compare('zone_name',$this->zone_name,true);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('sales_office_id',$this->sales_office_id,true);
		$criteria->compare('description',$this->description,true);
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
                        $sort_column = 'zone_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'zone_name';
                        break;
                                        
                        case 2:
                        $sort_column = 'sales_office_id';
                        break;
                                        
                        case 3:
                        $sort_column = 'description';
                        break;
                                        
                        case 4:
                        $sort_column = 'created_date';
                        break;
                                        
                        case 5:
                        $sort_column = 'created_by';
                        break;
                                        
                        case 6:
                        $sort_column = 'updated_date';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('zone_id',$columns[0]['search']['value'],true);
		$criteria->compare('zone_name',$columns[1]['search']['value'],true);
		$criteria->compare('sales_office_id',$columns[2]['search']['value'],true);
		$criteria->compare('description',$columns[3]['search']['value'],true);
		$criteria->compare('created_date',$columns[4]['search']['value'],true);
		$criteria->compare('created_by',$columns[5]['search']['value'],true);
		$criteria->compare('updated_date',$columns[6]['search']['value'],true);
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
	 * @return Zone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}