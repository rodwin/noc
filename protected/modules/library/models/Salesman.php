<?php

/**
 * This is the model class for table "salesman".
 *
 * The followings are the available columns in table 'salesman':
 * @property string $salesman_id
 * @property string $team_leader_id
 * @property string $company_id
 * @property string $salesman_name
 * @property string $salesman_code
 * @property string $mobile_number
 * @property string $device_no
 * @property string $other_fields_1
 * @property string $other_fields_2
 * @property string $other_fields_3
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property string $is_team_leader
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class Salesman extends CActiveRecord {

    public $search_string;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'salesman';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('salesman_id, company_id, salesman_name, salesman_code', 'required'),
            array('salesman_id, team_leader_id, company_id, salesman_code, mobile_number, device_no, other_fields_1, other_fields_2, other_fields_3, created_by, updated_by', 'length', 'max' => 50),
            array('salesman_name', 'length', 'max' => 200),
            array('is_team_leader', 'length', 'max' => 1),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('salesman_id, team_leader_id, company_id, salesman_name, salesman_code, mobile_number, device_no, other_fields_1, other_fields_2, other_fields_3, created_date, created_by, updated_date, updated_by, is_team_leader', 'safe', 'on' => 'search'),
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
            'salesman_id' => 'Salesman',
            'team_leader_id' => 'Team Leader',
            'company_id' => 'Company',
            'salesman_name' => 'Salesman Name',
            'salesman_code' => 'Salesman Code',
            'mobile_number' => 'Mobile Number',
            'device_no' => 'Device No',
            'other_fields_1' => 'Other Fields 1',
            'other_fields_2' => 'Other Fields 2',
            'other_fields_3' => 'Other Fields 3',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'is_team_leader' => 'Is Team Leader',
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

        $criteria->compare('salesman_id', $this->salesman_id, true);
        $criteria->compare('team_leader_id', $this->team_leader_id, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('salesman_name', $this->salesman_name, true);
        $criteria->compare('salesman_code', $this->salesman_code, true);
        $criteria->compare('mobile_number', $this->mobile_number, true);
        $criteria->compare('device_no', $this->device_no, true);
        $criteria->compare('other_fields_1', $this->other_fields_1, true);
        $criteria->compare('other_fields_2', $this->other_fields_2, true);
        $criteria->compare('other_fields_3', $this->other_fields_3, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('is_team_leader', $this->is_team_leader, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

//            case 0:
//                $sort_column = 'salesman_id';
//                break;

            case 0:
                $sort_column = 'team_leader_id';
                break;

            case 1:
                $sort_column = 'salesman_name';
                break;

            case 2:
                $sort_column = 'salesman_code';
                break;

            case 3:
                $sort_column = 'mobile_number';
                break;

            case 4:
                $sort_column = 'device_no';
                break;

            case 5:
                $sort_column = 'other_fields_1';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
//        $criteria->compare('salesman_id', $columns[0]['search']['value'], true);
        $criteria->compare('team_leader_id', $columns[0]['search']['value'], true);
        $criteria->compare('salesman_name', $columns[1]['search']['value'], true);
        $criteria->compare('salesman_code', $columns[2]['search']['value'], true);
        $criteria->compare('mobile_number', $columns[3]['search']['value'], true);
        $criteria->compare('device_no', $columns[4]['search']['value'], true);
        $criteria->compare('other_fields_1', $columns[5]['search']['value'], true);
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
     * @return Salesman the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
