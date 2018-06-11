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
/* @var $db \OP\UNIT\Database */
if(!$db = Unit::Instance('Database') ){
	return;
}

/* @var $form \OP\UNIT\Form */
if(!$form = Unit::Instance('Form') ){
	return;
}

//	Session key
$session_key = Hasha1(__FILE__.__LINE__);

//	Logout
if( $_GET['logout'] ?? false ){
	App::Session($session_key, []);
}

//	Saved login values.
$values = App::Session($session_key);

//	Has not been saved login values.
if( empty($values) ){
	//	Initialize.
	$form->Config('login.form.php');

	//	Validate.
	if( $form->Validate() ){
		//	Login values is save to session.
		$values = $form->Values();
		App::Session($session_key, $values);
	}
}

//	Database connect.
if( $values ){
	$io = $db->Connect($values);
}

//	...
App::Template('action.phtml',['form'=>$form, 'db'=>$db]);
