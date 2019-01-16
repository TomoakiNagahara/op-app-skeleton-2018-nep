<?php
/**
 * unit-test:/unit/database/create/table.php
 *
 * @creation  2019-01-11
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
	'charset'  => 'utf8mb4',
	'collate'  => 'utf8mb4_general_ci',
	'field' => [
		'ai'        => ['type'=>'int'],
		'timestamp' => ['type'=>'timestamp'],
	],
];

//	...
$names = [];
$names[] = 'mysql';
$names[] = 'pgsql';

//	...
foreach( $names as $prod ){
	//	...
	if(!empty($_GET['prod']) and $_GET['prod'] !== $prod ){
		continue;
	};

	/* @var $db \OP\UNIT\Database */
	$db = $dbs[$prod];

	//	...
	$show = $db->Show($config);

	//	...
	$name = $config['table'];

	//	...
	if( array_search($name, $show) !== false ){
		$config['if_not_exists'] = true;
	};

	//	...
	$result[$prod] = $db->Create()->Table($config);
};

//	...
Html('','hr');
Html('Table: Create');
D($result);

//	...
foreach( $names as $prod ){
	if( ($result[$prod] ?? true) === false ){
		$dbs[$prod]->Debug();
	};
};
