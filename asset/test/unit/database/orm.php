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
/* @var $db \OP\UNIT\Dataase */
include('connect.php');

/* @var $orm \OP\UNIT\ORM */
if(!$orm = Unit::Instance('ORM') ){
	return;
}

//	Join database object.
$orm->DB($db);

/* @var $record \OP\UNIT\ORM\Record */
if( $ai = ifset($_GET['ai']) ){
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

//	In case of new record, Set create datetime.
if( $record->isFound() ){
	$record->Set('updated', Time::Datetime());
}else{
	$record->Set('created', Time::Datetime());
}

//	Generate form object.
$form = $record->Form();

//	Save to database by Record object.
$result = $form->Validate() ? $orm->Save($record): null;

//	...
$found = $record->isFound();
$valid = $record->isValid();

//	...
App::Template('orm.phtml',['form'=>$form, 'result'=>$result, 'found'=>$found, 'valid'=>$valid]);

//	...
if( $_GET['debug'] ?? false ){
	D( $db->Queries() );
}

//	...
foreach( $db->Quick('t_orm','order=timestamp desc, limit=10') as $temp ){
	printf('<a href="?ai=%s">Edit of ai is %s</a>', $temp['ai'], $temp['ai']);
	Json($temp, 'OP_DUMP');
}
