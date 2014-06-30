<?php

/**
 * This is the model class for table "sku".
 *
 * The followings are the available columns in table 'sku':
 * @property string $code
 * @property string $company_id
 * @property string $brand_code
 * @property string $name
 * @property string $description
 * @property string $uom
 * @property string $unit_price
 * @property string $type
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $deleted_date
 * @property integer $deleted_by
 * @property integer $deleted
 */
class Sku extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sku';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, company_id, brand_code, name', 'required'),
			array('created_by, updated_by, deleted_by, deleted', 'numerical', 'integerOnly'=>true),
			array('code, company_id, brand_code, uom, type', 'length', 'max'=>50),
			array('name, description', 'length', 'max'=>150),
			array('unit_price', 'length', 'max'=>18),
			array('created_date, updated_date, deleted_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('code, company_id, brand_code, name, description, uom, unit_price, type, created_date, created_by, updated_date, updated_by, deleted_date, deleted_by, deleted', 'safe', 'on'=>'search'),
		);
	}
        
        public function beforeValidate() {
            if ($this->scenario == 'create') {
            
                $this->company_id = Yii::app()->user->company_id;
            
                $this->created_date = date('Y-m-d H:i:s');
                $this->created_by = Yii::app()->user->userObj->user_name;
            } else {
                if ($this->deleted == 0) {
                    $this->updated_date = date('Y-m-d H:i:s');
                    $this->updated_by = Yii::app()->user->userObj->user_name;
                    $this->deleted_date = null;
                    $this->deleted_by = null;
                } else {
                    $this->deleted_date = date('Y-m-d H:i:s');
                    $this->deleted_by = Yii::app()->user->userObj->user_name;
                }
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'code' => 'Code',
			'company_id' => 'Company',
			'brand_code' => 'Brand Code',
			'name' => 'Name',
			'description' => 'Description',
			'uom' => 'Uom',
			'unit_price' => 'Unit Price',
			'type' => 'Type',
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

		$criteria->compare('code',$this->code,true);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('brand_code',$this->brand_code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('uom',$this->uom,true);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('type',$this->type,true);
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
                        $sort_column = 'code';
                        break;
                                        
                        case 1:
                        $sort_column = 'brand_code';
                        break;
                                        
                        case 2:
                        $sort_column = 'name';
                        break;
                                        
                        case 3:
                        $sort_column = 'description';
                        break;
                                        
                        case 4:
                        $sort_column = 'uom';
                        break;
                                        
                        case 5:
                        $sort_column = 'unit_price';
                        break;
                                        
                        case 6:
                        $sort_column = 'type';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('code',$columns[0]['search']['value'],true);
		$criteria->compare('brand_code',$columns[1]['search']['value'],true);
		$criteria->compare('name',$columns[2]['search']['value'],true);
		$criteria->compare('description',$columns[3]['search']['value'],true);
		$criteria->compare('uom',$columns[4]['search']['value'],true);
		$criteria->compare('unit_price',$columns[5]['search']['value'],true);
		$criteria->compare('type',$columns[6]['search']['value'],true);
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
	 * @return Sku the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
