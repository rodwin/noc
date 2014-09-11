<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class CustomDataItemForm extends CFormModel {

    public $customDataType;
    public $customItemName;
    public $type;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('customDataType, customItemName, type', 'required'),
            array('customItemName', 'uniqueName'),
        );
    }

    public function attributeLabels() {
        return array(
            'customDataType' => 'What kind of data will the field contain?',
            'customItemName' => 'What is the name of this data?',
            'type' => 'Poi Category Type',
        );
    }

    public function uniqueName($attribute, $params) {

        $model = PoiCustomData::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'name' => $this->$attribute));

        if ($model) {
            $this->addError($attribute, 'Custom data name selected already taken.');
        }
        return;
    }

}
