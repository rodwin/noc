<?php

class ServiceController extends Controller
{
        public function actions()
        {
            return array(
                'quote'=>array(
                    'class'=>'CWebServiceAction',
                ),
            );
        }
    
	public function actionIndex()
	{
		
            $client=new SoapClient('http://203.76.174.107/dotnetservices/service1.asmx?wsdl');
            
            $data = $client->getDayDispatch(
                    array(
                    'userType'=>7,
                    'regionSalesID'=>1,
                    'dispatchDate'=>'08/08/2014',
                    'brandID'=>2,
                    )
                );
            
            pr($data);
            pr($data->getDayDispatchResult->DayDispatch[0]->ID);
            
            
	}
        
        /**
        * @param string the symbol of the stock
        * @return float the stock price
        * @soap
        */
       public function getPrice($symbol)
       {
           $prices=array('IBM'=>100, 'GOOGLE'=>350);
           return isset($prices[$symbol])?$prices[$symbol]:0;
           //...return stock price for $symbol
       }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}