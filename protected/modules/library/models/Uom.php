<?php

/**
 * This is the model class for table "uom".
 *
 * The followings are the available columns in table 'uom':
 * @property string $uom_id
 * @property string $company_id
 * @property string $uom_name
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Inventory[] $inventories
 * @property Sku[] $skus
 * @property SkuConvertion[] $skuConvertions
 */
class Uom extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'uom';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uom_id', 'required'),
            array('uom_id, company_id, uom_name, created_by, updated_by', 'length', 'max' => 50),
            array('uom_name', 'uniqueName'),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('uom_id, company_id, uom_name, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueName($attribute, $params) {

        $model = Uom::model()->findByAttributes(array('company_id' => $this->company_id, 'uom_name' => $this->$attribute));
        if ($model && $model->uom_id != $this->uom_id) {
            $this->addError($attribute, 'Uom name selected already taken.');
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
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'inventories' => array(self::HAS_MANY, 'Inventory', 'uom_id'),
            'skus' => array(self::HAS_MANY, 'Sku', 'default_uom_id'),
            'skuConvertions' => array(self::HAS_MANY, 'SkuConvertion', 'uom_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'uom_id' => 'Uom',
            'company_id' => 'Company',
            'uom_name' => 'Uom Name',
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

        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('uom_name', $this->uom_name, true);
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
//                $sort_column = 'uom_id';
//                break;

            case 0:
                $sort_column = 'uom_name';
                break;

            case 1:
                $sort_column = 'created_date';
                break;

            case 2:
                $sort_column = 'created_by';
                break;

            case 3:
                $sort_column = 'updated_date';
                break;

            case 4:
                $sort_column = 'updated_by';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
//        $criteria->compare('uom_id', $columns[0]['search']['value'], true);
        $criteria->compare('uom_name', $columns[0]['search']['value'], true);
        $criteria->compare('created_date', $columns[1]['search']['value'], true);
        $criteria->compare('created_by', $columns[2]['search']['value'], true);
        $criteria->compare('updated_date', $columns[3]['search']['value'], true);
        $criteria->compare('updated_by', $columns[4]['search']['value'], true);
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
     * @return Uom the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAllUOMNotInSkuConvertion() {

        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->condition = 't.company_id = "' . Yii::app()->user->company_id . '" AND t.uom_id NOT IN(SELECT uom_id FROM sku_convertion)';
        $criteria->order = "t.uom_name ASC";

        return Uom::model()->findAll($criteria);
    }

}
