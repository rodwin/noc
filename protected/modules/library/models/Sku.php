<?php

/**
 * This is the model class for table "sku".
 *
 * The followings are the available columns in table 'sku':
 * @property string $sku_id
 * @property string $sku_code
 * @property string $company_id
 * @property string $brand_id
 * @property string $sku_name
 * @property string $description
 * @property string $default_uom_id
 * @property string $default_unit_price
 * @property string $type
 * @property string $default_zone_id
 * @property string $supplier
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 * @property integer $low_qty_threshold
 * @property integer $high_qty_threshold
 *
 * The followings are the available model relations:
 * @property Inventory[] $inventories
 * @property Brand $brand
 * @property Company $company
 * @property Uom $defaultUom
 * @property Zone $defaultZone
 */
class Sku extends CActiveRecord {

    public $search_string;
    
    //types
    const TYPE_FIXED = 'fixed';
    const TYPE_CONSUMABLE = 'consumable';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sku';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sku_id, sku_code, company_id, sku_name', 'required'),
            array('low_qty_threshold, high_qty_threshold', 'numerical', 'integerOnly' => true,'max'=>9999999,'min'=> 0),
            array('sku_id, sku_code, company_id, brand_id, default_uom_id, type, default_zone_id, created_by, updated_by', 'length', 'max' => 50),
            array('sku_name, description', 'length', 'max' => 150),
            array('sku_code', 'uniqueCode'),
            array('type', 'isValidType'),
            array('default_uom_id', 'isValidUOM'),
            array('default_zone_id', 'isValidZone'),
            array('brand_id', 'isValidBrand'),
            array('default_unit_price', 'length', 'max' => 18),
            array('supplier', 'length', 'max' => 250),
            array('default_unit_price', 'match', 'pattern'=>'/^[0-9]{1,9}(\.[0-9]{0,3})?$/'),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('sku_id, sku_code, company_id, brand_id, sku_name, description, default_uom_id, default_unit_price, type, default_zone_id, supplier, created_date, created_by, updated_date, updated_by, low_qty_threshold, high_qty_threshold', 'safe', 'on' => 'search'),
        );
    }
    
    public function uniqueCode($attribute, $params) {
        
        $model = Sku::model()->findByAttributes(array('company_id' => $this->company_id, 'sku_code' => $this->$attribute));
        if ($model && $model->sku_id != $this->sku_id) {
            $this->addError($attribute, 'Sku code selected already taken');
        }
        return;
    }
    
    public function isValidType($attribute)
    {
        $data = trim($this->$attribute);
        
        if($data == ""){
            return;
        }
        
        $label = $this->attributeLabels();

        if (! Validator::InArrayKey($data,$this->getOptions($attribute))) {
            $this->addError($attribute, $label[$attribute].' is invalid!');
        }

        return;
    }
    
    public function isValidUOM($attribute)
    {
        if($this->$attribute == null){
            return;
        }
        $model = Uom::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'UOM is invalid');
        }
        
        return;
    }
    
    public function isValidBrand($attribute)
    {
        if($this->$attribute == null){
            return;
        }
        $model = Brand::model()->findbypk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'UOM is invalid');
        }
        
        return;
    }
    
    public function isValidZone($attribute)
    {
        if($this->$attribute == null){
            return;
        }
        
        $model = Zone::model()->findByPk($this->$attribute);

        if (!Validator::isResultSetWithRows($model)) {
            $this->addError($attribute, 'Zone is invalid');
        }
        
        return;
    }

    public function beforeValidate() {
        if($this->default_uom_id == ""){
            $this->default_uom_id = null;
        }
        if($this->default_zone_id == ""){
            $this->default_zone_id = null;
        }
        if($this->brand_id == ""){
            $this->brand_id = null;
        }
        if($this->type == ""){
            $this->type = null;
        }
        
        return parent::beforeValidate();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'inventories' => array(self::HAS_MANY, 'Inventory', 'sku_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'defaultUom' => array(self::BELONGS_TO, 'Uom', 'default_uom_id'),
            'defaultZone' => array(self::BELONGS_TO, 'Zone', 'default_zone_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'sku_id' => 'Sku',
            'sku_code' => 'Sku Code',
            'company_id' => 'Company',
            'sku_name' => 'Sku Name',
            'brand_id' => 'Brand',
            'description' => 'Description',
            'default_uom_id' => 'Default Uom',
            'default_unit_price' => 'Default Unit Price',
            'type' => 'Type',
            'default_zone_id' => 'Default Zone',
            'supplier' => 'Supplier',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'low_qty_threshold' => 'Low Qty Threshold',
            'high_qty_threshold' => 'High Qty Threshold',
        );
    }
    
    public function requiredHeaders(){
        $headers = $this->attributeLabels();
        unset($headers['sku_id']);
        unset($headers['company_id']);
        unset($headers['created_date']);
        unset($headers['created_by']);
        unset($headers['updated_date']);
        unset($headers['updated_by']);
        
        return $headers;
    }
    
    public function allType() {
        return array(
            self::TYPE_CONSUMABLE,
            self::TYPE_FIXED,
        );
    }
    
    function getOptions($name, $parent = NULL) {
            if ( $parent == NULL OR $parent == '') {
                    return $this->_getOptions( $name );
            } else {
                    $retval = $this->_getOptions( $name );
                    if ( isset($retval[$parent]) ){
                            return $retval[$parent];
                    }
            }

            return FALSE;
    }
    
    public function _getOptions( $name ) {
            $retval = NULL;
            switch( $name ) {
                    case 'type':
                            $retval = array(
                                self::TYPE_CONSUMABLE => 'Consumable',
                                self::TYPE_FIXED => 'Fixed',
                            );
                            break;

            }

            return $retval;
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

        $criteria->compare('sku_id', $this->sku_id, true);
        $criteria->compare('sku_code', $this->sku_code, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('sku_name', $this->sku_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('default_uom_id', $this->default_uom_id, true);
        $criteria->compare('default_unit_price', $this->default_unit_price, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('default_zone_id', $this->default_zone_id, true);
        $criteria->compare('supplier', $this->supplier, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('low_qty_threshold', $this->low_qty_threshold);
        $criteria->compare('high_qty_threshold', $this->high_qty_threshold);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function data($col, $order_dir, $limit, $offset, $columns) {
        switch ($col) {

//            case 0:
//                $sort_column = 't.sku_id';
//                break;

            case 0:
                $sort_column = 't.sku_code';
                break;

            case 1:
                $sort_column = 't.sku_name';
                break;

            case 2:
                $sort_column = 't.description';
                break;

            case 3:
                $sort_column = 'brand.brand_name';
                break;

            case 4:
                $sort_column = 'defaultUom.uom_name';
                break;

            case 5:
                $sort_column = 't.supplier';
                break;

            case 6:
                $sort_column = 'defaultZone.zone_name';
                break;
        }


        $criteria = new CDbCriteria;
        $criteria->compare('t.company_id', Yii::app()->user->company_id);
        $criteria->compare('t.sku_code', $columns[0]['search']['value'], true);
        $criteria->compare('t.sku_name', $columns[1]['search']['value'], true);
        $criteria->compare('t.description', $columns[2]['search']['value'], true);
        $criteria->compare('brand.brand_name', $columns[3]['search']['value'], true);
        $criteria->compare('defaultUom.uom_name', $columns[4]['search']['value'], true);
        $criteria->compare('t.supplier', $columns[5]['search']['value'], true);
        $criteria->compare('defaultZone.zone_name', $columns[6]['search']['value'], true);
        $criteria->order = "$sort_column $order_dir";
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->with = array('brand', 'company', 'defaultUom', 'defaultZone');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sku the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function generateTemplate(){
        
        header('Content-Type: application/excel');
        header('Content-Disposition: attachment; filename="sku.csv"');

        $fp = fopen('php://output', 'w');
        $cols = "";
        foreach ( $this->requiredHeaders() as $line => $v) {
            $cols .= $v.',';
            
        }
        fputcsv($fp, explode(',',$cols));
        fclose($fp);
        exit();
    }
    
    public function parseCsv($file){
        
        $ret = array();
        
        $file = "C:\\inetpub\\wwwroot\\noc\\protected\\data\\ItemSample.csv";
        
        $rows = Globals::parseCSV($file,true,true,',');
        
        $ret['success'] = 0;
        $ret['fail'] = 0;
        $ret['inserted'] = 0;
        $ret['updated'] = 0;
        $ret['message'] = "";
        $incomplete_field = 0;
        
        $required_headers = Sku::model()->requiredHeaders();
        
        if($rows && count($rows)>0){
            
            /*
             * check the first row if all columns are complete
             * else do not continue
             */
            
            foreach ($required_headers as $key => $value) {
                
                if(!isset($rows[0][$value])){
                    $incomplete_field++;
                    $message .= $value.',';
                }
                
            }
            
            if($incomplete_field > 0){
                $ret['message'] = "Could not find the following column(s): ". substr($message, 0,-1);
                return $ret;
            }
            
            foreach($rows as $key => $val){
                
                $data = array(
                    'company_id'=>Yii::app()->user->company_id,
                    'sku_code'=>$val[$required_headers['sku_code']],
                    'brand_id'=>$val[$required_headers['brand_id']],
                    'sku_name'=>$val[$required_headers['sku_name']],
                    'description'=>$val[$required_headers['description']],
                    'default_uom_id'=>$val[$required_headers['default_uom_id']],
                    'default_unit_price'=>$val[$required_headers['default_unit_price']],
                    'type'=>$val[$required_headers['type']],
                    'default_zone_id'=>$val[$required_headers['default_zone_id']],
                    'supplier'=>$val[$required_headers['supplier']],
                    'low_qty_threshold'=>$val[$required_headers['low_qty_threshold']],
                    'high_qty_threshold'=>$val[$required_headers['high_qty_threshold']],
                );
                
                $model = Sku::model()->findByAttributes(array('sku_code' => $val[$required_headers['sku_code']], 'company_id' => Yii::app()->user->company_id));
                
                if($model){//for update
                    
                    $model->attributes = $data;
                    $model->updated_date = date('Y-m-d H:i:s');
                    $model->updated_by = Yii::app()->user->name;
                    $model->validate();
                    if($model->validate()){
                        try {
                            $model->save();
                            $ret['success']++;
                            $ret['updated']++;
                        } catch (Exception $exc) {
                            $ret['fail']++;
                        }

                    }else{
                        $ret['fail']++;
                    }
                    
                }else{// for insert
                    
                    $data['sku_id'] = Globals::generateV4UUID();
                    $data['created_by'] = Yii::app()->user->name;
                    $model = new Sku;
                    $model->attributes = $data;
                    $model->validate();
                    if($model->validate()){
                        try {
                            $model->save();
                            $ret['success']++;
                            $ret['inserted']++;
                        } catch (Exception $exc) {
                            $ret['fail']++;
                        }

                    }else{
                        $ret['fail']++;
                    }
                    
                }
            }
        }
        pr($ret);
        exit;
    }

}
