<?php
/**
 * unit-test:/unit/database/orm.php
 *
 * @creation  2018-05-17
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $nav Nav */
$nav = new Nav();
$nav->Set('Debug (ON)' , ['debug'=>1]);
$nav->Set('Debug (OFF)', ['debug'=>0]);
$nav->Out();

/* @var $db \OP\UNIT\Database */
include('connect.php');

/* @var $orm \OP\UNIT\ORM */
if(!$orm = Unit::Instance('ORM') ){
	return;
}

//	Join database object.
$orm->DB($db);

/* @var $record \OP\UNIT\ORM\Record */
if( $ai = $_GET['ai'] ?? null ){
	//	Find single record by QQL. (QQL is "Quick Query Language")
	$record = $orm->Find("t_orm.ai = $ai"); // 't_test.ai = MAX()'
}else{
	//	Generate Empty "Record" Object.
	$record = $orm->Create("t_orm");
}

//	...
if(!$record->isReady() ){
	D(false);
	return;
}

//	Generate form object.
$form = $record->Form();

//	Do validation.
$form->Validate();

//	Get result.
$found = $record->isFound();
$valid = $record->isValid();
$saved = null;

//	...
if( $valid ){
	//	...
	if(!$found ){
		$record->Set('created', Time::Datetime());
	}

	//	...
	if( $saved = $orm->Save($record) ){
		$record->Set('updated', Time::Datetime());
		$saved = $orm->Save($record);
	}
}

//	...
App::Template('_orm.phtml',['form'=>$form, 'found'=>$found, 'valid'=>$valid, 'saved'=>$saved]);

//	...
if( $_GET['debug'] ?? false ){
	D( $db->Queries(), $form->Config() );
}

//	...
foreach( $db->Quick('t_orm','order=timestamp desc, limit=10') as $temp ){
	printf('<a href="?ai=%s">Edit of ai is %s</a>', $temp['ai'], $temp['ai']);
	Json($temp, 'OP_DUMP');
}
