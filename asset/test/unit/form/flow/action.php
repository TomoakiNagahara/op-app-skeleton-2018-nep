<?php
/**
 * unit-test:/unit/form/flow/action.php
 *
 * @creation  2018-05-23
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
$form->Config('./config.inc.php');

//	...
if( $_GET['clear'] ?? false ){
	$form->Clear();
}else{
	$valid = $form->Validate();
}

//	...
if( $valid !== true ){
	$file = 'form.phtml';
}else{
	if( $_SERVER['QUERY_STRING'] === 'confirm' ){
		$file = 'confirm.phtml';
	}else if( $_SERVER['QUERY_STRING'] === 'commit' ){
		$file = 'conversion.phtml';

		//	...
		include('commit.inc.php');

		//	...
		$form->Clear();
	}
}

//	...
if( $_GET['thanks'] ?? false ){
	$file = 'thanks.phtml';
}

//	...
App::Template($file, ['form'=>$form]);

//	...
D( $form->Values(), $form->Test(), $form->Debug() );
