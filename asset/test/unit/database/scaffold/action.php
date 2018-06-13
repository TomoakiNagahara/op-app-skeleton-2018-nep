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
	$form->Config('form-login.conf.php');

	//	Validate.
	if( $form->Validate() ){
		//	Login values is save to session.
		$values = $form->Values();
		App::Session($session_key, $values);
	}
}

//	Database connect.
if( $values ){
	if( $db->Connect($values) ){

		//	...
		$form->Config(include('form-selector.conf.php'));

		//	Get database name list.
		$list['database'] = ['_'=>['label'=>null, 'value'=>null]];
		foreach( $db->Query($sql->Show([], $db), 'show') as $value ){
			$list['database'][$value]['label'] = $value;
			$list['database'][$value]['value'] = $value;
		}

		//	Get table name list at database name.
		$list['table'] = ['_'=>['label'=>null, 'value'=>null]];
		if( $database = $form->GetValue('database') ){
			foreach( $db->Query($sql->Show(['database'=>$database], $db), 'show') as $value ){
				$list['table'][$value]['label'] = $value;
				$list['table'][$value]['value'] = $value;
			}
		}
	}
}

//	...
App::Template('action.phtml',['form'=>$form, 'db'=>$db, 'list'=>$list]);
