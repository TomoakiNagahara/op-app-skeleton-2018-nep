<?php
/**
 * unit-test:/unit/database/orm/action.php
 *
 * @creation  2018-06-20
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $orm \OP\UNIT\ORM */
if(!$orm = Unit::Instance('ORM') ){
	return;
}

//	...
define('__DNS__', 'mysql://testcase:password@localhost:3306?charset=utf8');

//	...
if(!$orm->Connect(__DNS__) ){
	return;
}

//	...
if(!$orm->Config('config.inc.php') ){
	return;
}

//	...
$database = 'testcase';
$table    = 't_orm';
$pkey = $_GET['pkey'] ?? null;
$pval = $_GET['pval'] ?? null;

//	...
$orm->DB()->Database($database);

//	...
$record = $pkey ? $orm->Find("$table.$pkey = $pval"): $record = $orm->Create($table);

//	...
if( $valid = $record->Form()->Validate() ){
	//	...
	$gmt = Time::GMT();

	//	...
	if(!$record->isFound() ){
		$record->Set('created', $gmt);
	}

	//	...
	if( $saved = $orm->Save($record) ){
		//	...
		if( $record->isFound() ){
			$record->Set('updated', $gmt);
			$orm->Save($record);
		}
	}
}

// D( $orm->DB()->Queries() );

//	...
App::Template('form.inc.php',['record'=>$record,'valid'=>$valid,'saved'=>$saved ?? null]);
App::Template('pager.inc.php',['orm'=>$orm]);
