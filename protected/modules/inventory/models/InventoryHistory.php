<?php

/**
 * This is the model class for table "inventory_history".
 *
 * The followings are the available columns in table 'inventory_history':
 * @property integer $inventory_history_id
 * @property string $company_id
 * @property integer $inventory_id
 * @property integer $quantity_change
 * @property integer $running_total
 * @property string $action
 * @property string $cost_unit
 * @property string $ave_cost_per_unit
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Inventory $inventory
 */
class InventoryHistory extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'inventory_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('inventory_id, quantity_change, running_total', 'numerical', 'integerOnly' => true),
            array('company_id, action, created_by, updated_by', 'length', 'max' => 50),
            array('cost_unit', 'length', 'max' => 18),
            array('ave_cost_per_unit', 'length', 'max' => 19),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('inventory_history_id, company_id, inventory_id, quantity_change, running_total, action, cost_unit, ave_cost_per_unit, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
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
            'inventory' => array(self::BELONGS_TO, 'Inventory', 'inventory_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'inventory_history_id' => 'Inventory History',
            'company_id' => 'Company',
            'inventory_id' => 'Inventory',
            'quantity_change' => 'Quantity Change',
            'running_total' => 'Running Total',
            'action' => 'Action',
            'cost_unit' => 'Cost Unit',
            'ave_cost_per_unit' => 'Ave Cost Per Unit',
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

        $criteria->compare('inventory_history_id', $this->inventory_history_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('quantity_change', $this->quantity_change);
        $criteria->compare('running_total', $this->running_total);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('cost_unit', $this->cost_unit, true);
        $criteria->compare('ave_cost_per_unit', $this->ave_cost_per_unit, true);
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
//                $sort_column = 'inventory_history_id';
//                break;

            case 0:
                $sort_column = 'inventory_id';
                break;

            case 1:
                $sort_column = 'quantity_change';
                break;

            case 2:
                $sort_column = 'running_total';
                break;

            case 3:
                $sort_column = 'action';
                break;

            case 4:
                $sort_column = 'cost_unit';
                break;

            case 5:
                $sort_column = 'ave_cost_per_unit';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
//        $criteria->compare('inventory_history_id', $columns[0]['search']['value']);
        $criteria->compare('inventory_id', $columns[0]['search']['value']);
        $criteria->compare('quantity_change', $columns[1]['search']['value']);
        $criteria->compare('running_total', $columns[2]['search']['value']);
        $criteria->compare('action', $columns[3]['search']['value'], true);
        $criteria->compare('cost_unit', $columns[4]['search']['value'], true);
        $criteria->compare('ave_cost_per_unit', $columns[5]['search']['value'], true);
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
     * @return InventoryHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
