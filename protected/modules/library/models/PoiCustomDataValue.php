<?php

/**
 * This is the model class for table "poi_custom_data_value".
 *
 * The followings are the available columns in table 'poi_custom_data_value':
 * @property integer $id
 * @property string $poi_id
 * @property string $custom_data_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property PoiCustomData $customData
 * @property Poi $poi
 */
class PoiCustomDataValue extends CActiveRecord
{
        public $search_string;
        public $custom_data_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poi_custom_data_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('poi_id, custom_data_id', 'required'),
			array('poi_id, custom_data_id', 'length', 'max'=>50),
			array('value', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, poi_id, custom_data_id, value', 'safe', 'on'=>'search'),
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
			'customData' => array(self::BELONGS_TO, 'PoiCustomData', 'custom_data_id'),
			'poi' => array(self::BELONGS_TO, 'Poi', 'poi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'poi_id' => 'Poi',
			'custom_data_id' => 'Custom Data',
			'value' => 'Value',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('poi_id',$this->poi_id,true);
		$criteria->compare('custom_data_id',$this->custom_data_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'id';
                        break;
                                        
                        case 1:
                        $sort_column = 'poi_id';
                        break;
                                        
                        case 2:
                        $sort_column = 'custom_data_id';
                        break;
                                        
                        case 3:
                        $sort_column = 'value';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('id',$columns[0]['search']['value']);
		$criteria->compare('poi_id',$columns[1]['search']['value'],true);
		$criteria->compare('custom_data_id',$columns[2]['search']['value'],true);
		$criteria->compare('value',$columns[3]['search']['value'],true);
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
	 * @return PoiCustomDataValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPoiCustomDataValue($poi_id, $poi_category_id) {

            $criteria = new CDbCriteria;
            $criteria->select = 't.*, poi_custom_data.name as custom_data_name';
            $criteria->join = 'INNER JOIN poi_custom_data ON poi_custom_data.custom_data_id = t.custom_data_id';
            $criteria->join .= ' INNER JOIN poi ON poi.poi_id = t.poi_id';
            $criteria->condition = 'poi_custom_data.company_id = "' . Yii::app()->user->company_id . '" AND poi.poi_id = "' . $poi_id . '" AND poi.poi_category_id = "' . $poi_category_id . '"';
            $criteria->order = "poi_custom_data.sort_order ASC";

            return PoiCustomDataValue::model()->findAll($criteria);
        }
        
        public function deletePoiCustomDataValueByPoiID($poi_id) {

            $sql = "DELETE FROM noc.poi_custom_data_value
                        WHERE poi_id = :poi_id";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(':poi_id', $poi_id, PDO::PARAM_STR);
            $command->execute();
        }
        
        public function deletePoiCustomDataValueByCustomDataID($custom_data_id) {

            $sql = "DELETE FROM noc.poi_custom_data_value
                        WHERE custom_data_id = :custom_data_id";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(':custom_data_id', $custom_data_id, PDO::PARAM_STR);
            $command->execute();
        }

}