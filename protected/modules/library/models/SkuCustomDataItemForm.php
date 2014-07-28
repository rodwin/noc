<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SkuCustomDataItemForm extends CFormModel {

    public $customDataType;
    public $customItemName;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('customDataType, customItemName', 'required'),
            array('customItemName', 'checkDuplicate'),
        );
    }

    public function attributeLabels() {
        return array(
            'customDataType' => 'What kind of data will the field contain?',
            'customItemName' => 'What is the name of this data?',
        );
    }

    public function checkDuplicate($attribute) {
        $duplicate = SkuCustomData::model()->exists('name = :name', array(':name' => $this->customItemName));

        $sql = "SELECT * FROM noc.sku_custom_data WHERE name = :name";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue('name', $this->customItemName);
        $data = $command->queryAll();

        if (isset($data) > 0) {

            $data_type = "";

            foreach ($data as $key => $val) {
                $data_type = $val['data_type'];
            }

            if (isset($duplicate) && $data_type != '') {
                if ($this->customDataType == $data_type) {
                    $this->addError($attribute, 'Custom Data Name is already exist in this data type.');
                }
            }
        }
    }

//    public function checkDuplicate($attribute) {
//        $result = CustomData::model()->exists('name = :name', array(':name' => $this->customItemName));
//
//        if ($result) {
//            $this->addError($attribute, 'Custom Data Name is already exist.');
//        }
//    }
}
