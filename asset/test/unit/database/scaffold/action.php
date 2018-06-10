<?php
/**
 * unit-test:/unit/database/scaffold/action.php
 *
 * @creation  2018-06-10
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $form \OP\UNIT\Form */
if(!$form = Unit::Instance('Form') ){
	return;
}

//	...
$form->Config('form.conf.php');

//	...
if( $config = $form->Validate() ){
	/* @var $db \OP\UNIT\Database */
	$db = Unit::Instance('Database');
	$db->Connect($form->Values());
}else{
	$form->Debug();
}

//	...
App::Template('action.phtml',['form'=>$form, 'db'=>$db]);
