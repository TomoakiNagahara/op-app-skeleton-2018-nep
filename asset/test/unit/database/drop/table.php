<?php
/**
 * unit-test:/unit/database/drop/table.php
 *
 * @creation  2019-01-24
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
];

//	...
$names = [];
//$names[] = 'mysql';
//$names[] = 'pgsql';
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
	$show = $db->Show(['table'=>true, 'database'=>$config['database']]);

	//	...
	$name = $config['table'];

	//	...
	if( array_search($name, $show) !== false ){
		$config['if_not_exists'] = true;
	};

	//	...
	$result[$prod] = $db->Drop()->Table($config);
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
