<?php

/**
 * This is the model class for table "employee_type".
 *
 * The followings are the available columns in table 'employee_type':
 * @property string $employee_type_id
 * @property string $company_id
 * @property string $employee_type_code
 * @property string $description
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Employee[] $employees
 * @property Company $company
 */
class EmployeeType extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employee_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_type_id, company_id, employee_type_code', 'required'),
			array('employee_type_id, company_id, employee_type_code, description, created_by, updated_by', 'length', 'max'=>50),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('employee_type_id, company_id, employee_type_code, description, created_date, created_by, updated_date, updated_by', 'safe', 'on'=>'search'),
		);
	}
        
        public function beforeValidate() {
            return parent::beforeValidate();
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'employees' => array(self::HAS_MANY, 'Employee', 'employee_type'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employee_type_id' => 'Employee Type',
			'company_id' => 'Company',
			'employee_type_code' => 'Employee Type Code',
			'description' => 'Description',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('employee_type_id',$this->employee_type_id,true);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('employee_type_code',$this->employee_type_code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'employee_type_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'employee_type_code';
                        break;
                                        
                        case 2:
                        $sort_column = 'description';
                        break;
                                        
                        case 3:
                        $sort_column = 'created_date';
                        break;
                                        
                        case 4:
                        $sort_column = 'created_by';
                        break;
                                        
                        case 5:
                        $sort_column = 'updated_date';
                        break;
                                        
                        case 6:
                        $sort_column = 'updated_by';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('employee_type_id',$columns[0]['search']['value'],true);
		$criteria->compare('employee_type_code',$columns[1]['search']['value'],true);
		$criteria->compare('description',$columns[2]['search']['value'],true);
		$criteria->compare('created_date',$columns[3]['search']['value'],true);
		$criteria->compare('created_by',$columns[4]['search']['value'],true);
		$criteria->compare('updated_date',$columns[5]['search']['value'],true);
		$criteria->compare('updated_by',$columns[6]['search']['value'],true);
                $criteria->order = "$sort_column $order_dir";
                $criteria->limit = $limit;
                $criteria->offset = $offset;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmployeeType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}