<?php

/**
 * This is the model class for table "batch_upload_detail".
 *
 * The followings are the available columns in table 'batch_upload_detail':
 * @property integer $id
 * @property string $company_id
 * @property integer $batch_upload_id
 * @property string $message
 *
 * The followings are the available model relations:
 * @property BatchUpload $batchUpload
 */
class BatchUploadDetail extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'batch_upload_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, batch_upload_id', 'required'),
            array('batch_upload_id', 'numerical', 'integerOnly' => true),
            array('company_id', 'length', 'max' => 50),
            array('message', 'length', 'max' => 250),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, company_id, batch_upload_id, message', 'safe', 'on' => 'search'),
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
            'batchUpload' => array(self::BELONGS_TO, 'BatchUpload', 'batch_upload_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'company_id' => 'Company',
            'batch_upload_id' => 'Batch Upload',
            'message' => 'Message',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('batch_upload_id', $this->batch_upload_id);
        $criteria->compare('message', $this->message, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'id';
                break;

            case 1:
                $sort_column = 'batch_upload_id';
                break;

            case 2:
                $sort_column = 'message';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('id', $columns[0]['search']['value']);
        $criteria->compare('batch_upload_id', $columns[1]['search']['value']);
        $criteria->compare('message', $columns[2]['search']['value'], true);
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
     * @return BatchUploadDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
