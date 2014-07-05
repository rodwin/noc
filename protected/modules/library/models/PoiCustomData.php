<?php

/**
 * This is the model class for table "poi_custom_data".
 *
 * The followings are the available columns in table 'poi_custom_data':
 * @property string $custom_data_id
 * @property string $company_id
 * @property string $name
 * @property integer $type
 * @property string $data_type
 * @property string $description
 * @property string $required
 * @property integer $sort_order
 * @property string $attribute
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property PoiCustomDataValue[] $poiCustomDataValues
 * @property Company $company
 */
class PoiCustomData extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poi_custom_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('custom_data_id, company_id, name, type, data_type, required, sort_order, attribute', 'required'),
			array('type, sort_order', 'numerical', 'integerOnly'=>true),
			array('custom_data_id, company_id, data_type, created_by, updated_by', 'length', 'max'=>50),
			array('name, description', 'length', 'max'=>250),
			array('required', 'length', 'max'=>1),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('custom_data_id, company_id, name, type, data_type, description, required, sort_order, attribute, created_date, created_by, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'poiCustomDataValues' => array(self::HAS_MANY, 'PoiCustomDataValue', 'custom_data_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'custom_data_id' => 'Custom Data',
			'company_id' => 'Company',
			'name' => 'Name',
			'type' => 'Type',
			'data_type' => 'Data Type',
			'description' => 'Description',
			'required' => 'Required',
			'sort_order' => 'Sort Order',
			'attribute' => 'Attribute',
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

		$criteria->compare('custom_data_id',$this->custom_data_id,true);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('data_type',$this->data_type,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('required',$this->required,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('attribute',$this->attribute,true);
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
                        $sort_column = 'custom_data_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'name';
                        break;
                                        
                        case 2:
                        $sort_column = 'type';
                        break;
                                        
                        case 3:
                        $sort_column = 'data_type';
                        break;
                                        
                        case 4:
                        $sort_column = 'description';
                        break;
                                        
                        case 5:
                        $sort_column = 'required';
                        break;
                                        
                        case 6:
                        $sort_column = 'sort_order';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('custom_data_id',$columns[0]['search']['value'],true);
		$criteria->compare('name',$columns[1]['search']['value'],true);
		$criteria->compare('type',$columns[2]['search']['value']);
		$criteria->compare('data_type',$columns[3]['search']['value'],true);
		$criteria->compare('description',$columns[4]['search']['value'],true);
		$criteria->compare('required',$columns[5]['search']['value'],true);
		$criteria->compare('sort_order',$columns[6]['search']['value']);
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
	 * @return PoiCustomData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}