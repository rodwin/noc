<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SkuCriteria
 *
 * @author rodwin
 */
class SkuCriteria {
    
    /**
    * @var string company_id
    * @soap
    */
    public $company_id;
    
    /**
    * @var string brand_id
    * @soap
    */
    public $brand_id;
    
    /**
    * @var string sku_name
    * @soap
    */
    public $sku_name;
    
    /**
    * @var string type
    * @soap
    */
    public $type;
    
    /**
    * @var string sub+type
    * @soap
    */
    public $sub_type;
}
