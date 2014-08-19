<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $image_id
 * @property string $company_id
 * @property string $file_name
 * @property string $url
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class Images extends CActiveRecord {

    public $search_string;
    public $image;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'images';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image_id, file_name', 'required'),
            array('image_id, company_id, created_by, updated_by', 'length', 'max' => 50),
            array('file_name, url', 'length', 'max' => 200),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('image_id, company_id, file_name, url, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
            array('image', 'file', 'types' => 'jpg,jpeg,gif,png', 'on' => 'upload'),
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
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'image_id' => 'Image',
            'company_id' => 'Company',
            'file_name' => 'File Name',
            'url' => 'Url',
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

        $criteria->compare('image_id', $this->image_id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('url', $this->url, true);
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
                $sort_column = 'image_id';
                break;

            case 1:
                $sort_column = 'file_name';
                break;

//            case 2:
//                $sort_column = 'url';
//                break;

            case 2:
                $sort_column = 'created_date';
                break;

            case 3:
                $sort_column = 'created_by';
                break;
//
//            case 5:
//                $sort_column = 'updated_date';
//                break;
//
//            case 6:
//                $sort_column = 'updated_by';
//                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('image_id', $columns[0]['search']['value'], true);
        $criteria->compare('file_name', $columns[1]['search']['value'], true);
//        $criteria->compare('url', $columns[2]['search']['value'], true);
        $criteria->compare('created_date', $columns[2]['search']['value'], true);
        $criteria->compare('created_by', $columns[3]['search']['value'], true);
//        $criteria->compare('updated_date', $columns[5]['search']['value'], true);
//        $criteria->compare('updated_by', $columns[6]['search']['value'], true);
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
     * @return Images the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
