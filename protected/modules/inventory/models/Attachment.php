<?php

/**
 * This is the model class for table "attachment".
 *
 * The followings are the available columns in table 'attachment':
 * @property string $attachment_id
 * @property string $company_id
 * @property string $file_name
 * @property string $url
 * @property string $transaction_id
 * @property string $transaction_type
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property string $tag_category
 */
class Attachment extends CActiveRecord {

    public $search_string;
    public $file;

    const RECEIVING_TRANSACTION_TYPE = "INCOMING";
    CONST INCOMING_TRANSACTION_TYPE = "INBOUND";
    CONST OUTGOING_TRANSACTION_TYPE = "OUTBOUND";
    CONST CUSTOMER_ITEM_TRANSACTION_TYPE = "OUTGOING";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'attachment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('attachment_id, company_id, file_name, url, transaction_id, transaction_type', 'required'),
            array('attachment_id, company_id, transaction_id, transaction_type, created_by, updated_by', 'length', 'max' => 50),
            array('file_name, url', 'length', 'max' => 200),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('attachment_id, company_id, file_name, url, transaction_id, transaction_type, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'attachment_id' => 'Attachment',
            'company_id' => 'Company',
            'file_name' => 'File Name',
            'url' => 'Url',
            'transaction_id' => 'Transaction',
            'transaction_type' => 'Transaction Type',
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

        $criteria->compare('attachment_id', $this->attachment_id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('transaction_id', $this->transaction_id, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
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

            case 0:
                $sort_column = 'attachment_id';
                break;

            case 1:
                $sort_column = 'file_name';
                break;

            case 2:
                $sort_column = 'url';
                break;

            case 3:
                $sort_column = 'transaction_id';
                break;

            case 4:
                $sort_column = 'transaction_type';
                break;

            case 5:
                $sort_column = 'created_date';
                break;

            case 6:
                $sort_column = 'created_by';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('attachment_id', $columns[0]['search']['value'], true);
        $criteria->compare('file_name', $columns[1]['search']['value'], true);
        $criteria->compare('url', $columns[2]['search']['value'], true);
        $criteria->compare('transaction_id', $columns[3]['search']['value'], true);
        $criteria->compare('transaction_type', $columns[4]['search']['value'], true);
        $criteria->compare('created_date', $columns[5]['search']['value'], true);
        $criteria->compare('created_by', $columns[6]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Attachment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
