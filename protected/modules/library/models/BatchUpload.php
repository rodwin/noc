<?php

/**
 * This is the model class for table "batch_upload".
 *
 * The followings are the available columns in table 'batch_upload':
 * @property integer $id
 * @property string $company_id
 * @property string $file
 * @property string $file_name
 * @property string $status
 * @property integer $total_rows
 * @property integer $failed_rows
 * @property string $type
 * @property string $error_message
 * @property string $created_date
 * @property integer $created_by
 * @property string $ended_date
 * @property string $module
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property BatchUploadDetail[] $batchUploadDetails
 */
class BatchUpload extends CActiveRecord
{
        public $search_string;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'batch_upload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, file, file_name, status, type, module', 'required'),
			array('total_rows, failed_rows, created_by', 'numerical', 'integerOnly'=>true),
			array('company_id', 'length', 'max'=>50),
			array('file, file_name, error_message', 'length', 'max'=>200),
			array('status, type, module', 'length', 'max'=>45),
			array('created_date, ended_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, file, file_name, status, total_rows, failed_rows, type, error_message, created_date, created_by, ended_date, module', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'batchUploadDetails' => array(self::HAS_MANY, 'BatchUploadDetail', 'batch_upload_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company',
			'file' => 'File',
			'file_name' => 'File Name',
			'status' => 'Status',
			'total_rows' => 'Total Rows',
			'failed_rows' => 'Failed Rows',
			'type' => 'Type',
			'error_message' => 'Error Message',
			'created_date' => 'Created Date',
			'created_by' => 'Created By',
			'ended_date' => 'Ended Date',
			'module' => 'Module',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('company_id',Yii::app()->user->company_id);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('total_rows',$this->total_rows);
		$criteria->compare('failed_rows',$this->failed_rows);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('error_message',$this->error_message,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('ended_date',$this->ended_date,true);
		$criteria->compare('module',$this->module,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function data($col, $order_dir,$limit,$offset,$columns)
	{
                switch($col){
                                        
                        case 0:
                        $sort_column = 'id';
                        break;
                                        
                        case 1:
                        $sort_column = 'file';
                        break;
                                        
                        case 2:
                        $sort_column = 'file_name';
                        break;
                                        
                        case 3:
                        $sort_column = 'status';
                        break;
                                        
                        case 4:
                        $sort_column = 'total_rows';
                        break;
                                        
                        case 5:
                        $sort_column = 'failed_rows';
                        break;
                                        
                        case 6:
                        $sort_column = 'type';
                        break;
                                }
        

                $criteria=new CDbCriteria;
                $criteria->compare('company_id',Yii::app()->user->company_id);
                		$criteria->compare('id',$columns[0]['search']['value']);
		$criteria->compare('file',$columns[1]['search']['value'],true);
		$criteria->compare('file_name',$columns[2]['search']['value'],true);
		$criteria->compare('status',$columns[3]['search']['value'],true);
		$criteria->compare('total_rows',$columns[4]['search']['value']);
		$criteria->compare('failed_rows',$columns[5]['search']['value']);
		$criteria->compare('type',$columns[6]['search']['value'],true);
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
	 * @return BatchUpload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}