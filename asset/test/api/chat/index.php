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
$request = App::Request();

//	...
$json = [
	'status' => true,
	'errors' => [],
	'result' => null,
];

//	...
try {
	//	...
	if(!Unit::Load('Database') ){
		throw new Exception('Database unit is load of failed.');
	};

	//	...
	if(!Unit::Load('SQL') ){
		throw new Exception('SQL unit is load of failed.');
	};

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
			include("{$action}.php");
			break;

		default:
			$json['errors'][] = 'Has not been set action.';
	};
} catch ( Throwable $e ){
	$json['errors'][] = $e->getMessage();
};

//	...
if( $result ){
	$json['result'] = $result;
}

//	...
if( empty($request['html']) ){
	//	...
	App::Layout(false);

	//	...
	Env::Mime('text/json');

	//	...
	echo json_encode($json);
}else{
	//	...
	D($json);
};
