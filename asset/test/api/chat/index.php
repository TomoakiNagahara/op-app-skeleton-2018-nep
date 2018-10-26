<?php
/**
 * unit-test:/api/chat/index.php
 *
 * @creation  2018-10-10
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
try {
	//	...
	if(!Unit::Load('api')){
		throw new Exception('Load API-Unit was failed.');
	}

	/* @var $db \OP\UNIT\Database */
	if(!$db = Unit::Instance('Database') ){
		throw new Exception('Database instance was failed.');
	};

	/* @var $sql \OP\UNIT\SQL */
	if(!$sql = Unit::Instance('SQL') ){
		throw new Exception('SQL instance was failed.');
	};

	//	...
	$config = [
		'prod'	 => 'mysql',
		'host'	 => 'localhost',
		'port'	 => '3306',
		'user'	 => 'testcase',
		'password' => 'password',
		'database' => 'testcase',
	];

	//	...
	if(!$db->Connect($config) ){
		throw new Exception('Database connect was failed.');
	};

	//	...
	switch( $action = App::Args()[0] ?? null ){
		case 'load':
		case 'save':
			//	...
			$result = [];

			//	...
			$request = App::Request();

			//	...
			include("{$action}.php");
			break;

		default:
			$json['errors'][] = 'Has not been set action.';
	};

	//	Enter result.
	\OP\UNIT\Api::Result($result);

} catch ( Throwable $e ){
	//	Catch the exception.
	\OP\UNIT\Api::Error( $e->getMessage() );
};

//	...
\OP\UNIT\Api::Finish();
