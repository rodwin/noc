<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $user_type_id
 * @property string $user_name
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $telephone
 * @property string $address
 * @property string $added_when
 * @property string $added_by
 * @property string $updated_when
 * @property string $updated_by
 * @property string $deleted_when
 * @property string $deleted_by
 * @property integer $deleted
 * @property integer $status
 */
class User extends CActiveRecord
{
        public $search_string;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

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
			array('user_type_id, user_name, password, first_name, last_name', 'required'),
			array('deleted, status', 'numerical', 'integerOnly'=>true),
			array('user_type_id, password, address', 'length', 'max'=>200),
			array('user_name, first_name, last_name, email', 'length', 'max'=>100),
			array('telephone, added_by, updated_by, deleted_by', 'length', 'max'=>45),
			array('updated_when, added_when,deleted_when', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_type_id, user_name, password, first_name, last_name, email, telephone, address, added_when, added_by, updated_when, updated_by, deleted_when, deleted_by, deleted, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_type_id' => 'User Type',
			'user_name' => 'User Name',
			'password' => 'Password',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'telephone' => 'Telephone',
			'address' => 'Address',
			'added_when' => 'Added When',
			'added_by' => 'Added By',
			'updated_when' => 'Updated When',
			'updated_by' => 'Updated By',
			'deleted_when' => 'Deleted When',
			'deleted_by' => 'Deleted By',
			'deleted' => 'Deleted',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_type_id',$this->user_type_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('added_when',$this->added_when,true);
		$criteria->compare('added_by',$this->added_by,true);
		$criteria->compare('updated_when',$this->updated_when,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('deleted_when',$this->deleted_when,true);
		$criteria->compare('deleted_by',$this->deleted_by,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                    case '1':
                      $sort_column = "user_type_id";
                      break;
                    case '2':
                      $sort_column = "user_name";
                      break;
                    case '3':
                        $sort_column = "first_name";
                      break;
                    case '4':
                        $sort_column = "last_name";
                      break;
                    case '5':
                        $sort_column = "status";
                      break;
                    case '0':
                        $sort_column = "id";
                      break;
                }

		$criteria=new CDbCriteria;
		$criteria->compare('id',$columns[0]['search']['value']);
		$criteria->compare('user_type_id',$columns[1]['search']['value'],true);
		$criteria->compare('user_name',$columns[2]['search']['value'],true);
		$criteria->compare('first_name',$columns[3]['search']['value'],true);
		$criteria->compare('last_name',$columns[4]['search']['value'],true);
		$criteria->compare('status',$columns[5]['search']['value']);
                $criteria->order = "$sort_column $order_dir";
                $criteria->limit = $limit;
                $criteria->offset = $offset;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
                
	}
}