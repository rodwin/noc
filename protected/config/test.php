<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
                        'db'=>array(
                            'connectionString' => 'sqlsrv:server=RODWIN-PC\MSSQLSERVER2012;database=noc',
                            'enableProfiling'=>true,
                            'enableParamLogging' => true,
                            'charset'=>'utf8'

                        ),
		),
	)
);
