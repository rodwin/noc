<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $company_id
 * @property string $user_type_id
 * @property string $user_name
 * @property string $password
 * @property integer $status
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $position
 * @property string $telephone
 * @property string $address
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_by
 * @property string $updated_date
 * @property string $deleted_date
 * @property string $deleted_by
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class User extends CActiveRecord
{
        const KEY_VALUE = 'p@l@b0k';
        public $password2;
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, user_type_id, user_name, password, first_name, last_name, email', 'required'),
			array('status, deleted', 'numerical', 'integerOnly'=>true),
			array('company_id, user_type_id, user_name, first_name, last_name, email, position, telephone, created_by, updated_by, deleted_by', 'length', 'max'=>50),
                        array('password', 'length', 'max' => 64, 'min' => 5),
                        array('password', 'required','on' => 'create'),
                        array('password2','safe'),
                        array('password', 'compare', 'compareAttribute'=>'password2'),
			array('address', 'length', 'max'=>250),
                        array('email', 'email'),
			array('created_date, updated_date, deleted_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, company_id, user_type_id, user_name, password, status, first_name, last_name, email, position, telephone, address, created_date, created_by, updated_by, updated_date, deleted_date, deleted_by, deleted', 'safe', 'on'=>'search'),
		);
	}
        
        public function encryptPassword()
        {
            $this->password = CPasswordHelper::hashPassword($this->password);
        }
        
        public function beforeValidate() {
            
            if ($this->scenario == 'create') {
                $this->created_date = date('Y-m-d H:i:s');
                $this->created_by = Yii::app()->user->id;
            } else {
                if ($this->deleted == 0) {
                    $this->updated_date = date('Y-m-d H:i:s');
                    $this->updated_by = Yii::app()->user->id;
                    $this->deleted_date = null;
                    $this->deleted_by = null;
                } else {
                    $this->deleted_date = date('Y-m-d H:i:s');
                    $this->deleted_by = Yii::app()->user->id;
                }
            }
            return parent::beforeValidate();
        }
        
        public function beforeSave() {
            
            $this->encryptPassword();
            return parent::beforeSave();
            
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'company_id' => 'Company',
			'user_type_id' => 'User Type',
			'user_name' => 'User Name',
			'password' => 'Password',
			'password2' => 'Confirm Password',
			'status' => 'Status',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'position' => 'Position',
			'telephone' => 'Telephone',
			'address' => 'Address',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
			'updated_date' => 'Updated Date',
			'deleted_date' => 'Deleted Date',
			'deleted_by' => 'Deleted By',
			'deleted' => 'Deleted',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('user_type_id',$this->user_type_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('deleted_date',$this->deleted_date,true);
		$criteria->compare('deleted_by',$this->deleted_by,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'user_id';
                        break;
                                        
                        case 1:
                        $sort_column = 'company_id';
                        break;
                                        
                        case 2:
                        $sort_column = 'user_type_id';
                        break;
                                        
                        case 3:
                        $sort_column = 'user_name';
                        break;
                                        
                        case 4:
                        $sort_column = 'password';
                        break;
                                        
                        case 5:
                        $sort_column = 'status';
                        break;
                                        
                        case 6:
                        $sort_column = 'first_name';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                		$criteria->compare('user_id',$columns[0]['search']['value']);
		$criteria->compare('company_id',$columns[1]['search']['value'],true);
		$criteria->compare('user_type_id',$columns[2]['search']['value'],true);
		$criteria->compare('user_name',$columns[3]['search']['value'],true);
		$criteria->compare('password',$columns[4]['search']['value'],true);
		$criteria->compare('status',$columns[5]['search']['value']);
		$criteria->compare('first_name',$columns[6]['search']['value'],true);
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
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
