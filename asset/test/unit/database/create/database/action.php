<?php
/**
 * unit-test:/unit/database/create/database/action.php
 *
 * @creation  2018-12-17
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
	'name'    => 'testcase_test',
	'charset' => 'utf8mb4',
	'collate' => 'utf8mb4_general_ci',
];

//	...
foreach( ['mysql','pgsql'] as $prod ){
	//	...
	if(!empty($_GET['prod']) and $_GET['prod'] !== $prod ){
		continue;
	};

	/* @var $db \OP\UNIT\Database */
	$db = $dbs[$prod];

	//	...
	$show = $db->Show(['Database'=>true]);

	//	...
	$name = $config['name'];

	//	...
	if( array_search($name, $show) ?? null ){
		$result[$prod]['drop'] = $db->Drop()->Database($config);
	};

	//	...
	$result[$prod]['create'] = $db->Create()->Database($config);
};

//	...
Html('','hr');
Html('Database: Create, Drop');
D($result);
