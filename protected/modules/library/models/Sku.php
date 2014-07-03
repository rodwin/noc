<?php

/**
 * This is the model class for table "sku".
 *
 * The followings are the available columns in table 'sku':
 * @property string $sku_id
 * @property string $sku_code
 * @property string $company_id
 * @property string $brand_id
 * @property string $sku_name
 * @property string $description
 * @property string $default_uom_id
 * @property string $default_unit_price
 * @property string $type
 * @property string $default_zone_id
 * @property string $supplier
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property integer $low_qty_threshold
 * @property integer $high_qty_threshold
 *
 * The followings are the available model relations:
 * @property Inventory[] $inventories
 * @property Brand $brand
 * @property Company $company
 * @property Uom $defaultUom
 * @property Zone $defaultZone
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
			array('sku_id, sku_code, company_id, brand_id, sku_name', 'required'),
			array('low_qty_threshold, high_qty_threshold', 'numerical', 'integerOnly'=>true),
			array('sku_id, sku_code, company_id, brand_id, default_uom_id, type, default_zone_id, created_by, updated_by', 'length', 'max'=>50),
			array('sku_name, description', 'length', 'max'=>150),
			array('default_unit_price', 'length', 'max'=>18),
			array('supplier', 'length', 'max'=>250),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sku_id, sku_code, company_id, brand_id, sku_name, description, default_uom_id, default_unit_price, type, default_zone_id, supplier, created_date, created_by, updated_date, updated_by, low_qty_threshold, high_qty_threshold', 'safe', 'on'=>'search'),
		);
	}
        
        public function beforeValidate() {
            if ($this->scenario == 'create') {
            
                $this->company_id = Yii::app()->user->company_id;
                
                $this->sku_id = Globals::generateV4UUID();                
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
			'inventories' => array(self::HAS_MANY, 'Inventory', 'sku_id'),
			'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'defaultUom' => array(self::BELONGS_TO, 'Uom', 'default_uom_id'),
			'defaultZone' => array(self::BELONGS_TO, 'Zone', 'default_zone_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sku_id' => 'Sku',
			'sku_code' => 'Sku Code',
			'company_id' => 'Company',
			'brand_id' => 'Brand',
			'sku_name' => 'Sku Name',
			'description' => 'Description',
			'default_uom_id' => 'Default Uom',
			'default_unit_price' => 'Default Unit Price',
			'type' => 'Type',
			'default_zone_id' => 'Default Zone',
			'supplier' => 'Supplier',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'low_qty_threshold' => 'Low Qty Threshold',
			'high_qty_threshold' => 'High Qty Threshold',
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

		$criteria->compare('sku_id',$this->sku_id,true);
		$criteria->compare('sku_code',$this->sku_code,true);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('brand_id',$this->brand_id,true);
		$criteria->compare('sku_name',$this->sku_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('default_uom_id',$this->default_uom_id,true);
		$criteria->compare('default_unit_price',$this->default_unit_price,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('default_zone_id',$this->default_zone_id,true);
		$criteria->compare('supplier',$this->supplier,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('low_qty_threshold',$this->low_qty_threshold);
		$criteria->compare('high_qty_threshold',$this->high_qty_threshold);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'sku_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'sku_code';
                        break;
                                        
                        case 2:
                        $sort_column = 'brand_id';
                        break;
                                        
                        case 3:
                        $sort_column = 'sku_name';
                        break;
                                        
                        case 4:
                        $sort_column = 'description';
                        break;
                                        
                        case 5:
                        $sort_column = 'default_uom_id';
                        break;
                                        
                        case 6:
                        $sort_column = 'default_unit_price';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('sku_id',$columns[0]['search']['value'],true);
		$criteria->compare('sku_code',$columns[1]['search']['value'],true);
		$criteria->compare('brand_id',$columns[2]['search']['value'],true);
		$criteria->compare('sku_name',$columns[3]['search']['value'],true);
		$criteria->compare('description',$columns[4]['search']['value'],true);
		$criteria->compare('default_uom_id',$columns[5]['search']['value'],true);
		$criteria->compare('default_unit_price',$columns[6]['search']['value'],true);
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