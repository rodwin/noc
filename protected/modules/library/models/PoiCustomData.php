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
class PoiCustomData extends CActiveRecord {

    public $search_string;
    public $category_name;
    public $poi_id;
    public $custom_data_value;

    // custom data types
    const TYPE_TEXT_NUMBERS = 'Text and Numbers';
    const TYPE_NUMBER_ONLY = 'Numbers Only';
    const TYPE_CHECKBOX = 'CheckBox';
    const TYPE_DROPDOWN = 'Drop Down List';
    // custom value length
    const CUSTOM_VALUE_LENGTH = 250;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'poi_custom_data';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('custom_data_id, company_id, name, type, data_type, required, sort_order', 'required'),
            array('sort_order', 'numerical', 'integerOnly' => true),
            array('custom_data_id, company_id, data_type, created_by, updated_by', 'length', 'max' => 50),
            array('name, description', 'length', 'max' => 250),
            array('required', 'length', 'max' => 1),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('custom_data_id, company_id, name, type, data_type, description, required, sort_order, attribute, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
            array('name', 'uniqueName'),
        );
    }

    public function uniqueName($attribute, $params) {

        $model = PoiCustomData::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'name' => $this->$attribute));

        if ($model && $model->custom_data_id != $this->custom_data_id) {
            $this->addError($attribute, 'Custom data name selected already taken.');
        }
        return;
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
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
    public function attributeLabels() {
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('custom_data_id', $this->custom_data_id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('data_type', $this->data_type, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('required', $this->required, true);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('attribute', $this->attribute, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

//            case 0:
//                $sort_column = 't.custom_data_id';
//                break;

            case 0:
                $sort_column = 't.name';
                break;

            case 1:
                $sort_column = 'category_name';
                break;

            case 2:
                $sort_column = 't.data_type';
                break;

            case 3:
                $sort_column = 't.description';
                break;

            case 4:
                $sort_column = 't.required';
                break;

            case 5:
                $sort_column = 't.sort_order';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->select = 't.*, poi_category.category_name as category_name';
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
//        $criteria->compare('t.custom_data_id', $columns[0]['search']['value'], true);
        $criteria->compare('t.name', $columns[0]['search']['value'], true);
        $criteria->compare('category_name', $columns[1]['search']['value']);
        $criteria->compare('t.data_type', $columns[2]['search']['value'], true);
        $criteria->compare('t.description', $columns[3]['search']['value'], true);
        $criteria->compare('t.required', $columns[4]['search']['value'], true);
        $criteria->compare('t.sort_order', $columns[5]['search']['value']);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->join = 'LEFT JOIN poi_category ON poi_category.poi_category_id = t.type';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PoiCustomData the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAttributeByDataType($attr_name, $data_type) {

        if ($data_type == PoiCustomData::TYPE_TEXT_NUMBERS) {

            return array(
                'max_character_length' => isset($_POST['max_character_length']) ? $_POST['max_character_length'] : null,
                'text_field' => isset($_POST['text_area']) ? $_POST['text_area'] : 0,
                'default_value' => isset($_POST['default_value']) ? $_POST['default_value'] : null,
            );
        } else if ($data_type == PoiCustomData::TYPE_NUMBER_ONLY) {

            return array(
                'min_value' => isset($_POST['minimum_value']) ? $_POST['minimum_value'] : null,
                'max_value' => isset($_POST['maximum_value']) ? $_POST['maximum_value'] : null,
                'default_value' => isset($_POST['default_value']) ? $_POST['default_value'] : null,
                'use_seperator' => isset($_POST['use_seperator']) ? $_POST['use_seperator'] : 0,
                'leading_zero' => isset($_POST['leading_zero']) ? $_POST['leading_zero'] : 0,
                'decimal_place' => isset($_POST['decimal_place']) ? $_POST['decimal_place'] : 0,
            );
        } else if ($data_type == PoiCustomData::TYPE_CHECKBOX) {

            return array(
                'default_value' => isset($_POST['default_value']) ? $_POST['default_value'] : 0,
            );
        } else if ($data_type == PoiCustomData::TYPE_DROPDOWN) {

            $multiple_options = array();
            $default_options = array();
            $default_options[] = "<option id='' value=''>Select " . ucwords($attr_name) . "</option>";
            $options_array = array();

            $ctr = 0;

            if (isset($_POST['dropDownList_multiple'])) {

                $array = array();
                $default_option = $_POST['dropDownList_default'];

                foreach ($_POST['dropDownList_multiple'] as $item) {
                    array_push($array, trim($item));
                }

                foreach ($array as $items => $val) {
                    $multiple_options[] = "<option id='{$items}' value='{$val}'>{$val}</option>";

                    $selected = ($val == $default_option[0]) ? " selected='selected'" : "";
                    $default_options[] = "<option id='{$items}' value='{$val}' $selected>{$val}</option>";

                    $options_array[$val] = $val;
                }
            }

            return array(
                'options_array' => $options_array,
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
            array('id' => PoiCustomData::TYPE_TEXT_NUMBERS, 'title' => " " . PoiCustomData::TYPE_TEXT_NUMBERS),
            array('id' => PoiCustomData::TYPE_NUMBER_ONLY, 'title' => " " . PoiCustomData::TYPE_NUMBER_ONLY),
            array('id' => PoiCustomData::TYPE_CHECKBOX, 'title' => " " . PoiCustomData::TYPE_CHECKBOX),
            array('id' => PoiCustomData::TYPE_DROPDOWN, 'title' => " " . PoiCustomData::TYPE_DROPDOWN),
        );
    }

    public function getPoiCustomData($poi_id, $poi_category_id) {

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, poi_category.category_name as category_name, poi_custom_data_value.value as custom_data_value, poi.poi_id';
        $criteria->join = 'INNER JOIN poi_category ON poi_category.poi_category_id = t.type AND poi_category.poi_category_id = "' . $poi_category_id . '"';
        $criteria->join .= ' LEFT JOIN poi ON poi.poi_category_id = poi_category.poi_category_id AND poi.poi_id = "' . $poi_id . '"';
        $criteria->join .= ' LEFT JOIN poi_custom_data_value ON poi_custom_data_value.custom_data_id = t.custom_data_id AND poi_custom_data_value.poi_id = poi.poi_id';
        $criteria->condition = 't.company_id = "' . Yii::app()->user->company_id . '"';
        $criteria->order = "t.sort_order ASC";

        return PoiCustomData::model()->findAll($criteria);
    }

    public function validateAllDatatypeRequiredField($poi_custom_data, $key) {

        if ($key == "max_character_length") {

            if ($_POST['max_character_length'] == "") {

                $poi_custom_data->addError("max_character_length", "Max character length cannot be blank.");
            } else if (isset($_POST['max_character_length']) && $_POST['max_character_length'] < 0 || $_POST['max_character_length'] > PoiCustomData::CUSTOM_VALUE_LENGTH) {

                $poi_custom_data->addError("max_character_length", "Max character must be greater than 0 and less than " . PoiCustomData::CUSTOM_VALUE_LENGTH . " character(s).");
            }
        } else if ($key == "min_value" || $key == "max_value") {

            if ($_POST['minimum_value'] == "") {

                $poi_custom_data->addError("minimum_value", "Minimum value cannot be blank.");
//            } else if (isset($_POST['minimum_value']) && $_POST['minimum_value'] < 0 || $_POST['minimum_value'] > PoiCustomData::CUSTOM_VALUE_LENGTH) {
//                $poi_custom_data->addError("minimum_value", "<font color='red'>Minimum value must be greater than 0 and less than " . PoiCustomData::CUSTOM_VALUE_LENGTH . ".</font>");
            } else if (isset($_POST['minimum_value']) != "" && isset($_POST['maximum_value']) != "") {

                if ($_POST['minimum_value'] > $_POST['maximum_value']) {

                    $poi_custom_data->addError("minimum_value", "Minimum value must be less than maximum value.");
                }
            }

            if ($_POST['maximum_value'] == "") {

                $poi_custom_data->addError("maximum_value", "Maximum value cannot be blank.");
//            } else if (isset($_POST['maximum_value']) && $_POST['maximum_value'] < 0 || $_POST['maximum_value'] > PoiCustomData::CUSTOM_VALUE_LENGTH) {
//                $poi_custom_data->addError("maximum_value", "<font color='red'>Maximum value must be greater than 0 and less than " . PoiCustomData::CUSTOM_VALUE_LENGTH . ".</font>");
            }
        } else if ($key == "dropDownList_multiple") {

            if (isset($_POST['dropDownList_multiple']) == "") {

                $poi_custom_data->addError("dropDownList_multiple", "Options cannot be blank.");
            }
        }
    }

    public function validateAllCustomDataValue($poi_custom_data, $company_id, $attr_name, $value) {

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, poi_category.category_name as category_name';
        $criteria->join = 'INNER JOIN poi_category ON poi_category.poi_category_id = t.type';
        $custom_data = PoiCustomData::model()->findByAttributes(array('name' => $attr_name, 'company_id' => $company_id), $criteria);

        $post_name = str_replace(' ', '_', strtolower($custom_data->category_name)) . "_" . str_replace(' ', '_', strtolower($custom_data->data_type)) . "_" . str_replace(' ', '_', strtolower($attr_name));

        $field_name = ucwords($attr_name);
        $attr = CJSON::decode($custom_data->attribute);

        if ($custom_data->required == 1 && $value == "") {

            $poi_custom_data->addError($post_name, $field_name . " cannot be blank.");
        } else if (strlen($value) > PoiCustomData::CUSTOM_VALUE_LENGTH) {

            $poi_custom_data->addError($post_name, $field_name . " value must be less than " . PoiCustomData::CUSTOM_VALUE_LENGTH . " character(s).");
        } else if ($custom_data->data_type == PoiCustomData::TYPE_NUMBER_ONLY && $value != "") {

            if (!is_numeric($value)) {

                $poi_custom_data->addError($post_name, $field_name . " must be a number.");
            } else if ($value < $attr['min_value']) {

                $poi_custom_data->addError($post_name, $field_name . " must be greater than " . $attr['min_value'] . ".");
            } else if ($value > $attr['max_value']) {

                $poi_custom_data->addError($post_name, $field_name . " must be less than " . $attr['max_value'] . ".");
            } else {

                $parse_value = explode(".", trim($value));

                if (isset($parse_value[1])) {

                    if (strlen($parse_value[1]) > $attr['decimal_place']) {

                        $poi_custom_data->addError($post_name, $field_name . " must be less than " . $attr['decimal_place'] . " decimal place(s).");
                    }
                }
            }
        } else if ($custom_data->data_type == PoiCustomData::TYPE_CHECKBOX) {

            if ($custom_data->required == 1 && $value != "yes") {

                if ($value == "no") {

                    $poi_custom_data->addError($post_name, $field_name . " is required.");
                } else {

                    $poi_custom_data->addError($post_name, $field_name . " value must be yes/no only.");
                }
            } else if ($custom_data->required == 0 && $value != "no") {

                if ($value != "yes") {

                    $poi_custom_data->addError($post_name, $field_name . " value must be yes/no only.");
                }
            }
        } else if ($custom_data->data_type == PoiCustomData::TYPE_DROPDOWN) {

            if ($custom_data->required == 1 && $value != "") {

                if (!in_array($value, $attr['options_array'])) {
                    $poi_custom_data->addError($post_name, $field_name . " value is not existing.");
                }
            } else if ($custom_data->required == 0 && $value != "") {

                if (!in_array($value, $attr['options_array'])) {
                    $poi_custom_data->addError($post_name, $field_name . " value is not existing.");
                }
            }
        }
    }

}
