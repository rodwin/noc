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
			array('custom_data_id, company_id, name, type, data_type, required, sort_order', 'required'),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('custom_data_id, company_id, data_type, created_by, updated_by', 'length', 'max'=>50),
			array('name, description', 'length', 'max'=>250),
			array('required', 'length', 'max'=>1),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('custom_data_id, company_id, name, type, data_type, description, required, sort_order, attribute, created_date, created_by, updated_date, updated_by', 'safe', 'on'=>'search'),
                        array('name', 'checkDuplicate'),
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
			'required' => 'Required Field',
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
        
        public function getAttributeByDataType($data_type) {

            if ($data_type == 'Text and Numbers') {

                return array(
                    'max_character_length' => isset($_POST['max_character_length']) ? $_POST['max_character_length'] : null,
                    'text_field' => isset($_POST['text_area']) ? $_POST['text_area'] : 0,
                    'default_value' => isset($_POST['default_value']) ? $_POST['default_value'] : null,
                );
            } else if ($data_type == 'Numbers Only') {

                return array(
                    'minimum_value' => isset($_POST['minimum_value']) ? $_POST['minimum_value'] : null,
                    'maximum_value' => isset($_POST['maximum_value']) ? $_POST['maximum_value'] : null,
                    'default_value' => isset($_POST['default_value']) ? $_POST['default_value'] : null,
                    'use_seperator' => isset($_POST['use_seperator']) ? $_POST['use_seperator'] : 0,
                    'leading_zero' => isset($_POST['leading_zero']) ? $_POST['leading_zero'] : 0,
                    'decimal_place' => isset($_POST['decimal_place']) ? $_POST['decimal_place'] : 0,
                );
            } else if ($data_type == 'CheckBox') {

                return array(
                    'default_value' => isset($_POST['default_value']) ? $_POST['default_value'] : 0,
                );
            } else if ($data_type == 'Drop Down List') {

                $multiple_options = array();
                $default_options = array();
                $default_options[] = "<option id='' value=''></option>";

                $ctr = 0;

                if (isset($_POST['dropDownList_multiple'])) {

                    $array = array();
                    $default_option = $_POST['dropDownList_default'];

                    foreach ($_POST['dropDownList_multiple'] as $item) {
                        array_push($array, $item);
                    }

                    foreach ($array as $items => $val) {
                        $multiple_options[] = "<option id='{$items}' value='{$val}'>{$val}</option>";
                    }

                    foreach ($array as $items => $val) {
                        $selected = ($val == $default_option[0]) ? " selected='selected'" : "";
                        $default_options[] = "<option id='{$items}' value='{$val}' $selected>{$val}</option>";
                    }
                }

                return array(
                    'dropDownList_multiple' => $multiple_options,
                    'dropDownList_default' => $default_options,
                );
            } else if ($data_type == 'Date') {

                return array(
                    'default_value' => isset($_POST['default_value']) ? $_POST['default_value'] : null,
                );
            }
        }
        
        private function _getCheck($name) {
            $ret_val = null;

            switch ($name) {
                case 'checked':
                    $ret_val = array(
                        0 => '',
                        1 => 'checked',
                    );
                    break;

                case 'required_field':
                    $ret_val = array(
                        0 => 'Not Required',
                        1 => 'Required',
                    );
                    break;

                case 'form_checked':
                    $ret_val = array(
                        0 => false,
                        1 => true,
                    );
                    break;
            }

            return $ret_val;
        }

        public function getValueByName($name, $value = null) {

            $retval = $this->_getCheck($name);

            if (isset($retval[$value])) {
                return $retval[$value];
            }

            return false;
        }
        
        public function getAllDataType() {
            return array(
                array('id' => 'Text and Numbers', 'title' => ' Text and Numbers'),
                array('id' => 'Numbers Only', 'title' => ' Numbers Only'),
                array('id' => 'CheckBox', 'title' => ' CheckBox'),
                array('id' => 'Drop Down List', 'title' => ' Drop Down List'),
                array('id' => 'Date', 'title' => ' Date')
            );
        }
        
        public function checkDuplicate($attribute) {
            $duplicate = PoiCustomData::model()->exists('name = :name', array(':name' => $this->name));

            $sql = "select custom_data_id, type from noc.poi_custom_data where name = :name";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue('name', $this->name);
            $data = $command->queryAll();

            if (isset($data) > 0) {

                $custom_data_id = 0;
                $type = 0;

                foreach ($data as $key => $val) {
                    $custom_data_id = $val['custom_data_id'];
                    $type = $val['type'];                
                }

                if (isset($duplicate) && $custom_data_id != '') {
                    if ($this->custom_data_id != $custom_data_id && $this->type == $type) {
                        $this->addError($attribute, 'Custom Data Name is already exist in this category.');
                    }
                }
            }
        }
        
}