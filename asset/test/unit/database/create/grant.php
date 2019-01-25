<?php
/**
 * unit-test:/unit/database/create/grant.php
 *
 * @creation  2019-01-18
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$result = [];

//	...
$dbs = include(ConvertPath('asset:/test/unit/database/connect/action.php'));

//	...
$config = [
	'database' => 'testcase',
	'table'    => 't_testcase',
	'type'     => 'pkey',
	'name'     => 'pkey',
	'column'   => 'ai',
];

//	...
$names = [];
//$names[] = 'mysql';
$names[] = 'pgsql';
//$names[] = 'sqlite';

//	...
foreach( $names as $prod ){
	//	...
	if(!empty($_GET['prod']) and $_GET['prod'] !== $prod ){
		continue;
	};

	/* @var $db \OP\UNIT\Database */
	$db = $dbs[$prod];

	//	...
	$show = $db->Show(['table'=>true, 'database'=>$config['database']]);

	D($show);
	continue;

	//	...
	$table_name = 't_testcase';
	$role_name  = 'testcase';
	$sql = "GRANT SELECT, UPDATE, INSERT ON {$table_name} TO ${role_name}";

	//	...
	$result[$prod] = $db->SQL($sql, 'grant');
};

//	...
Html('','hr');
Html('Grant:');
D($result);

//	...
foreach( $names as $prod ){
	if( ($result[$prod] ?? true) === false ){
		$dbs[$prod]->Debug();
	};
};
