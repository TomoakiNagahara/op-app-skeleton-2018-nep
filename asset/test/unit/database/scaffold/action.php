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

//	Saved connection config.
$config = App::Session($session_key);

//	Has not been saved connection values.
if( empty($config) ){
	//	Initialize.
	$form->Config('form-login.conf.php');

	//	Validate.
	if( $form->Validate() ){
		//	Login values is save to session.
		$config = $form->Values();
		App::Session($session_key, $config);
	}
}

//	Try database connect.
if( $config ){
	//	In case of success, building database selector form.
	if( $db->Connect($config) ){
		//	...
		$form = Unit::Instance('Form');
		$form->Config('form-selector.conf.php');

		//	Get database name list.
		$option = [['label'=>null, 'value'=>null]];
		foreach( $db->Show([]) as $value ){
			$option[] = ['label' => $value, 'value' => $value];
		}
		$form->SetOption('database', $option);

		//	Get table name list at database name.
		$option = [['label'=>null, 'value'=>null]];
		if( $database = $form->GetValue('database') ){
			foreach( $db->Show(['database'=>$database]) as $value ){
				$option[] = ['label' => $value, 'value' => $value];
			}
		}
		$form->SetOption('table', $option);
	}else{
		//	Database connect was failed.
		App::Session($session_key, null);

		//	...
		$form->Config('form-login.conf.php');
	}
}

//	...
Nav::Set('Create', ['pval'=>'']);

//	...
Nav::Out();

//	...
App::Template('action.phtml',['form'=>$form, 'db'=>$db]);
