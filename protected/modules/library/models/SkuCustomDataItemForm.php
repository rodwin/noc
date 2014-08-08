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
            array('customItemName', 'uniqueName'),
        );
    }

    public function attributeLabels() {
        return array(
            'customDataType' => 'What kind of data will the field contain?',
            'customItemName' => 'What is the name of this data?',
        );
    }
    
    public function uniqueName($attribute, $params) {
        
        $model = SkuCustomData::model()->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'name' => $this->$attribute));
        
        if ($model) {
            $this->addError($attribute, 'Custom data name selected already taken.');
        }
        return;
    }
}
