<?php
/**
 * unit-test:/unit/database/create/alter.php
 *
 * @creation  2019-01-16
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
	'field'    => 'varchar',
	'type'     => 'varchar',
	'length'   => '255',
	'comment'  => 'Free text area.',
	'after'    => 'ai',
	'charset'  => 'utf8mb4',
	'collate'  => 'utf8mb4_general_ci',
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
	$show = $db->Show(['column'=>true,'table'=>$config['table'], 'database'=>$config['database']]);

	//	...
	$database = $config['database'];
	$table    = $config['table'];
	$field    = $config['field'];

	//	...
	if( empty($show[$config['field']]) ){
		//	Create
		$sql = \OP\UNIT\SQL\Column::Create($database, $table, $field, $config, $db);
	}else{
		//	...
		if( $prod === 'sqlite' ){
			$result[$prod] = null;
			continue;
		};

		//	Change
		$sql = \OP\UNIT\SQL\Column::Change($database, $table, $field, $config, $db);
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
