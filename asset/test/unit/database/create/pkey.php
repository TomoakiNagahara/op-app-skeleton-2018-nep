<?php
/**
 * unit-test:/unit/database/create/key.php
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
$names[] = 'mysql';
//$names[] = 'pgsql';
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
	$show = $db->Show(['index'=>true,'table'=>$config['table'], 'database'=>$config['database']]);

	//	...
	if( empty($show['PRIMARY']) ){
		$sql = \OP\UNIT\SQL\Alter::Index($config, $db);
	};

	//	...
	if( isset($show['PRIMARY']) ){
		$sql = \OP\UNIT\SQL\Alter::AutoIncrement($config, $db);
	};

	//	...
	$result[$prod] = $db->SQL($sql, 'alter');
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
