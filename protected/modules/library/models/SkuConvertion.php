<?php

/**
 * This is the model class for table "sku_convertion".
 *
 * The followings are the available columns in table 'sku_convertion':
 * @property string $id
 * @property string $company_id
 * @property integer $quantity
 * @property string $uom_id
 * @property integer $new_quantity
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Uom $uom
 */
class SkuConvertion extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sku_convertion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, company_id, sku_id, quantity, uom_id, new_quantity', 'required'),
            array('quantity, new_quantity', 'numerical', 'integerOnly' => true),
            array('id, company_id, sku_id, uom_id, created_by, updated_by', 'length', 'max' => 50),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, company_id, sku_id, quantity, uom_id, new_quantity, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
            'uom' => array(self::BELONGS_TO, 'Uom', 'uom_id'),
            'sku' => array(self::BELONGS_TO, 'Sku', 'sku_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'company_id' => 'Company',
            'sku_id' => 'Sku',
            'quantity' => 'Quantity',
            'uom_id' => 'Unit of Measure',
            'new_quantity' => 'New Quantity',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('uom_id', $this->uom_id, true);
        $criteria->compare('new_quantity', $this->new_quantity);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns, $sku_id) {

        switch ($col) {

            case 0:
                $sort_column = 't.quantity';
                break;

            case 1:
                $sort_column = 'uom.uom_name';
                break;

            case 3:
                $sort_column = 't.new_quantity';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->select = 't.*, "=" as equals';
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.sku_id', $sku_id);
        $criteria->compare('t.quantity', $columns[0]['search']['value']);
        $criteria->compare('uom.uom_name', $columns[1]['search']['value'], true);
        $criteria->compare('t.new_quantity', $columns[3]['search']['value']);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array('company', 'uom');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SkuConvertion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
