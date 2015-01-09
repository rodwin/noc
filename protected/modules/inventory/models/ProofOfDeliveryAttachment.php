<?php

/**
 * This is the model class for table "proof_of_delivery_attachment".
 *
 * The followings are the available columns in table 'proof_of_delivery_attachment':
 * @property integer $pod_attachment_id
 * @property string $company_id
 * @property integer $pod_id
 * @property integer $pod_detail_id
 * @property string $file_name
 * @property string $url
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property string $verified
 * @property string $verified_by
 *
 * The followings are the available model relations:
 * @property ProofOfDeliveryDetail $podDetail
 * @property ProofOfDelivery $pod
 */
class ProofOfDeliveryAttachment extends CActiveRecord {

    public $search_string;

    CONST POD_TRANSACTION_TYPE = "POD";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'proof_of_delivery_attachment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, pod_id, pod_detail_id, file_name, url', 'required'),
            array('pod_id, pod_detail_id', 'numerical', 'integerOnly' => true),
            array('company_id, created_by, updated_by, verified_by', 'length', 'max' => 50),
            array('file_name, url', 'length', 'max' => 200),
            array('verified', 'length', 'max' => 1),
            array('updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('pod_attachment_id, company_id, pod_id, pod_detail_id, file_name, url, created_date, created_by, updated_date, updated_by, verified, verified_by', 'safe', 'on' => 'search'),
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
            'podDetail' => array(self::BELONGS_TO, 'ProofOfDeliveryDetail', 'pod_detail_id'),
            'pod' => array(self::BELONGS_TO, 'ProofOfDelivery', 'pod_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pod_attachment_id' => 'Pod Attachment',
            'company_id' => 'Company',
            'pod_id' => 'Pod',
            'pod_detail_id' => 'Pod Detail',
            'file_name' => 'File Name',
            'url' => 'Url',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'verified' => 'Verified',
            'verified_by' => 'Verified By',
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

        $criteria->compare('pod_attachment_id', $this->pod_attachment_id);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('pod_id', $this->pod_id);
        $criteria->compare('pod_detail_id', $this->pod_detail_id);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('verified', $this->verified, true);
        $criteria->compare('verified_by', $this->verified_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

            case 0:
                $sort_column = 'pod_attachment_id';
                break;

            case 1:
                $sort_column = 'pod_id';
                break;

            case 2:
                $sort_column = 'pod_detail_id';
                break;

            case 3:
                $sort_column = 'file_name';
                break;

            case 4:
                $sort_column = 'url';
                break;

            case 5:
                $sort_column = 'created_date';
                break;

            case 6:
                $sort_column = 'created_by';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('pod_attachment_id', $columns[0]['search']['value']);
        $criteria->compare('pod_id', $columns[1]['search']['value']);
        $criteria->compare('pod_detail_id', $columns[2]['search']['value']);
        $criteria->compare('file_name', $columns[3]['search']['value'], true);
        $criteria->compare('url', $columns[4]['search']['value'], true);
        $criteria->compare('created_date', $columns[5]['search']['value'], true);
        $criteria->compare('created_by', $columns[6]['search']['value'], true);
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
     * @return ProofOfDeliveryAttachment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function deleteDetailAndAttachmentByPODID($company_id, $pod_id) {

        $pod_detail = ProofOfDeliveryDetail::model()->findAllByAttributes(array("company_id" => $company_id, "pod_id" => $pod_id));

        $pod_detail_ids = "'',";
        if ($pod_detail) {
            foreach ($pod_detail as $k => $v) {
                $pod_detail_ids .= "'" . $v->pod_detail_id . "',";
            }

            $c = new CDbCriteria;
            $c->condition = "company_id = '" . $company_id . "' AND pod_id = '" . $pod_id . "' AND pod_detail_id IN (" . substr($pod_detail_ids, 0, -1) . ")";
            ProofOfDeliveryAttachment::model()->deleteAll($c);

            $c1 = new CDbCriteria;
            $c1->condition = "company_id = '" . $company_id . "' AND pod_detail_id IN (" . substr($pod_detail_ids, 0, -1) . ")";
            ProofOfDeliveryDetail::model()->deleteAll($c1);
        }
    }

    public function deleteDetailAndAttachmentByCustomerItemDetailID($company_id, $customer_item_detail_id) {

        $pod_detail = ProofOfDeliveryDetail::model()->findAllByAttributes(array("company_id" => $company_id, "custome_item_detail_id" => $customer_item_detail_id));

        if ($pod_detail) {

            $c = new CDbCriteria;
            $c->condition = "company_id = '" . $company_id . "' AND pod_id = '" . $pod_detail->pod_id . "' AND pod_detail_id = '" . $pod_detail->pod_detail_id . "'";
            ProofOfDeliveryAttachment::model()->deleteAll($c);
            ProofOfDeliveryDetail::model()->deleteAll($c);
        }
    }

}
