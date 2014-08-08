<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class POIImportForm extends CFormModel {

    public $doc_file;
    public $notify;
    public $poi_category_id;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('doc_file', 'file', 'types' => 'csv', 'maxSize' => 1024 * 1024 * 10, 'tooLarge' => 'The file was larger than 10MB. Please upload a smaller file.'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'notify' => 'Notify me by email when upload is complete',
            'doc_file' => 'File Name',
        );
    }

}
