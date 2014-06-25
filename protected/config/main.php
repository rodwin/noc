<?php
function pr($val){
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}

function pre($val){
    echo "<pre>";
    print_r($val);
    echo "</pre>";
    exit;
}
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'NOC',

	// preloading 'log' component
	'preload'=>array('log','booster'),
        'theme'=>'AdminLTE',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'winrod',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                        'generatorPaths' => array(
                            'booster.gii'
                         ),
		),
                'admin',
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
                'booster' => array(
                    'class' => 'ext.yiibooster.components.Booster',
                    'coreCss' => false,
                    'responsiveCss' => false,
                    'enableJS' => false,
                    'enableNotifierJS' => false,
                ),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
                    'connectionString' => 'sqlsrv:server=RODWIN-PC\MSSQLSERVER2012;database=noc',
//                    'connectionString' => 'mysql:host=localhost;dbname=noc',
                    'username' => 'rodwin',
                    'password' => 'winrod',
                    'enableProfiling'=>true,
                    'enableParamLogging' => true,

                ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);