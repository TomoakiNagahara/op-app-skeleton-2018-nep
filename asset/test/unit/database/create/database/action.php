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
	'name'    => 'testcase',
	'charset' => 'utf8mb4',
	'collate' => 'utf8mb4_general_ci',
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
	$show = $db->Show(['Database'=>true]);

	//	...
	$name = $config['name'];

	//	...
	if( array_search($name, $show) ?? null ){
		if( $prod === 'mysql' ){
			$config['if_not_exists'] = true;
		}else{
			$result[$prod] = true;
			continue;
		}
	};

	//	...
	$result[$prod] = $db->Create()->Database($config);
};

//	...
Html('','hr');
Html('Database: Create');
D($result);

//	...
foreach( $names as $prod ){
	if( ($result[$prod] ?? true) === false ){
		$dbs[$prod]->Debug();
	};
};
