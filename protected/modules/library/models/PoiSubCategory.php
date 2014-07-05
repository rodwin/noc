<?php

/**
 * This is the model class for table "poi_sub_category".
 *
 * The followings are the available columns in table 'poi_sub_category':
 * @property string $poi_sub_category_id
 * @property string $company_id
 * @property string $poi_category_id
 * @property string $sub_category_name
 * @property string $description
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Poi[] $pois
 * @property Company $company
 */
class PoiSubCategory extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poi_sub_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('poi_sub_category_id, company_id, poi_category_id, sub_category_name', 'required'),
			array('poi_sub_category_id, company_id, poi_category_id, created_by, updated_by', 'length', 'max'=>50),
			array('sub_category_name', 'length', 'max'=>100),
			array('description', 'length', 'max'=>250),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('poi_sub_category_id, company_id, poi_category_id, sub_category_name, description, created_date, created_by, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'pois' => array(self::HAS_MANY, 'Poi', 'poi_sub_category_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'poi_sub_category_id' => 'Poi Sub Category',
			'company_id' => 'Company',
			'poi_category_id' => 'Poi Category',
			'sub_category_name' => 'Sub Category Name',
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

		$criteria->compare('poi_sub_category_id',$this->poi_sub_category_id,true);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('poi_category_id',$this->poi_category_id,true);
		$criteria->compare('sub_category_name',$this->sub_category_name,true);
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
                        $sort_column = 'poi_sub_category_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'poi_category_id';
                        break;
                                        
                        case 2:
                        $sort_column = 'sub_category_name';
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
                		$criteria->compare('poi_sub_category_id',$columns[0]['search']['value'],true);
		$criteria->compare('poi_category_id',$columns[1]['search']['value'],true);
		$criteria->compare('sub_category_name',$columns[2]['search']['value'],true);
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
	 * @return PoiSubCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}