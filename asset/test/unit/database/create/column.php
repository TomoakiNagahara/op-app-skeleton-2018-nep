<?php
/**
 * unit-test:/unit/database/create/column.php
 *
 * @creation  2019-01-23
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
	'field'    => [
		'ai'        => ['type'=>'int'],
		'text'      => ['type'=>'text'],
		'timestamp' => ['type'=>'timestamp'],
	],
];

//	...
$names = [];
$names[] = 'mysql';
$names[] = 'pgsql';
$names[] = 'sqlite';

//	...
foreach( $names as $prod ){
	//	...
	if(!empty($_GET['prod']) and $_GET['prod'] !== $prod ){
		continue;
	};

	/* @var $db \OP\UNIT\Database */
	$db = $dbs[$prod];

	//	...
	$show = $db->Show(['column'=>true, 'table'=>$config['table'], 'database'=>$config['database']]);
	D($show);

	//	...
	$result[$prod] = $db->Create()->Column($config);
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
