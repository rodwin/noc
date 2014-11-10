<?php

/**
 * This is the model class for table "authitem".
 *
 * The followings are the available columns in table 'authitem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 * @property string $company_id
 *
 * The followings are the available model relations:
 * @property Authassignment[] $authassignments
 * @property Authitemchild[] $authitemchildren
 * @property Authitemchild[] $authitemchildren1
 */
class Authitem extends CActiveRecord {

    public $search_string;
    
    const AUTHITEM_LABEL = "Role";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'authitem';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type', 'required'),
//            array('name', 'unique'),
            array('type, id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('created_by, updated_by', 'length', 'max' => 50),
            array('name', 'uniqueName'),
            array('description, bizrule, data, created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name, type, id, description, bizrule, data, created_date, created_by, updated_date, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueName($attribute, $params) {

        $name = strtolower($this->$attribute);
        
        $model = Authitem::model()->findByAttributes(array('name' => $name));
        
        if ($model && $model->id != $this->id) {
            $this->addError($attribute, 'Role selected already taken');
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
            'authassignments' => array(self::HAS_MANY, 'Authassignment', 'itemname'),
            'authitemchildren' => array(self::HAS_MANY, 'Authitemchild', 'child'),
            'authitemchildren1' => array(self::HAS_MANY, 'Authitemchild', 'parent'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Role',
            'type' => 'Type',
            'description' => 'Description',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
//            'company_id' => 'Company',
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

        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);
//        $criteria->compare('company_id', Yii::app()->user->company_id);
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
                $sort_column = 'name';
                break;

//            case 1:
//                $sort_column = 'type';
//                break;

            case 1:
                $sort_column = 'description';
                break;

//            case 3:
//                $sort_column = 'bizrule';
//                break;
//
//            case 4:
//                $sort_column = 'data';
//                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('type', 2);
        $criteria->compare('bizrule', Yii::app()->user->auth_company_id);
        $criteria->compare('name', $columns[0]['search']['value'], true);
//        $criteria->compare('type', $columns[1]['search']['value']);
        $criteria->compare('description', $columns[1]['search']['value'], true);
//        $criteria->compare('bizrule', $columns[3]['search']['value'], true);
//        $criteria->compare('data', $columns[4]['search']['value'], true);
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
     * @return Authitem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getUserCountByRole($role) {

        $sql = "select count(*) as count FROM user WHERE user_type_id = :role";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':role', $role, PDO::PARAM_STR);
        return $command->queryScalar();
    }

}
