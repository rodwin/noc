<?php

class ApiController extends Controller {

    public function actions() {
        return array(
            'webservice' => array(
                'class' => 'CWebServiceAction',
                'classMap' => array(
                    'Sku' => 'Sku', // or simply 'Post'
                    'SkuCriteria' => 'SkuCriteria', // or simply 'Post'
                    'CreateInventoryForm' => 'CreateInventoryForm', // or simply 'Post'
                ),
            ),
        );
    }

    public function actionIndex() {

        pr("Webservice is operational");
        
    }

    /**
     * @param string the company_id
     * @param string the username
     * @param string the password
     * @return bool
     * @soap
     */
    public function login($company_id, $name, $password) {
        
        Yii::log('API call login entered', 'info', 'webservice');
        
        $model = new LoginForm();
        $model->company = $company_id;
        $model->username = $name;
        $model->password = $password;
        
        if ($model->validate() && $model->login()) {
            
            return true;
            
        } else {
            
            $error = "";
            foreach($model->getErrors() as $k => $err){
                $error .= $err[0];
            }
            throw new SoapFault("login error", $error);
        }
    }
    
    /**
     * @param CreateInventoryForm object
     * @soap
     */
    public function createInventory(CreateInventoryForm $CreateInventoryForm){
        
        Yii::log('API call createInventory entered', 'info', 'webservice');
        
        $model = new CreateInventoryForm();
        $model->attributes = $CreateInventoryForm->attributes;
        if (!$model->create()) {
            
            $error = "";
            foreach($model->getErrors() as $k => $err){
                $error .= $err[0];
            }
            
            Yii::log('createInventory failed: '.$error, 'warning', 'webservice');
            
            throw new SoapFault("createInventory error", $error);
        }
        
        Yii::log('API call createInventory completed', 'info', 'webservice');
        
    }

    /**
     * @param SkuCriteria object
     * @return Sku[] a list of sku
     * @soap
     */
    public function retrieveSkusByCriteria(SkuCriteria $SkuCriteria) {
        
        Yii::log('API call retrieveSkusByCriteria entered', 'info', 'webservice');
        
        $data = Sku::model()->retrieveSkusByCriteria($SkuCriteria);
        
        $ret = array();
        
        foreach($data as $key => $val){
            
            $sku = new Sku;
            $sku->attributes = $val->attributes;
            //$sku->brandObj = $val->brand->attributes;
            $sku->brandObj = isset($val->brand) ?  $val->brand->attributes: null;
            $ret[] = $sku;
        }
        
        Yii::log('API call retrieveSkusByCriteria completed', 'info', 'webservice');
        return $ret;
    }
}
