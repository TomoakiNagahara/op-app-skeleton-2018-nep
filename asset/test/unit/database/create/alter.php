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
//$names[] = 'mysql';
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
	$show = [];

	//	...
	foreach( $db->SQL("SELECT * FROM information_schema.columns WHERE table_name = 't_testcase'", 'select') as $record ){
		$table = $record['table_name'];
		$field = $record['column_name'];
		//	...
		$show[$field] = $record;
	};

	//	...
	$database = $config['database'];
	$table    = $config['table'];
	$field   = $config['field'];

	//	...
	if( empty($show[$config['field']]) ){
		//	Create
		$sql = \OP\UNIT\SQL\Column::Create($database, $table, $field, $config, $db);
	}else{
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
