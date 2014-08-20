<?php

/**
 * This is the model class for table "sku_image".
 *
 * The followings are the available columns in table 'sku_image':
 * @property integer $id
 * @property string $company_id
 * @property string $sku_id
 * @property string $image_id
 * @property string $created_date
 * @property string $created_by
 */
class SkuImage extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sku_image';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id', 'required'),
            array('company_id, sku_id, image_id, created_by', 'length', 'max' => 50),
            array('created_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('sku_image_id, company_id, sku_id, image_id, created_date, created_by', 'safe', 'on' => 'search'),
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
            'sku_image_id' => 'Sku Image ID',
            'company_id' => 'Company',
            'sku_id' => 'Sku',
            'image_id' => 'Image',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
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

        $criteria->compare('sku_image_id', $this->sku_image_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('image_id', $this->image_id, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'sku_image_id';
                break;

            case 1:
                $sort_column = 'sku_id';
                break;

            case 2:
                $sort_column = 'image_id';
                break;

            case 3:
                $sort_column = 'created_date';
                break;

            case 4:
                $sort_column = 'created_by';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('sku_image_id', $columns[0]['search']['value']);
        $criteria->compare('sku_id', $columns[1]['search']['value'], true);
        $criteria->compare('image_id', $columns[2]['search']['value'], true);
        $criteria->compare('created_date', $columns[3]['search']['value'], true);
        $criteria->compare('created_by', $columns[4]['search']['value'], true);
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
     * @return SkuImage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
