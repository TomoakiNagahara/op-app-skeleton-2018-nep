<?php
/**
 * unit-test:/unit/form/validation/action.php
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
	$form->Validate();
}

//	...
App::Template('index.phtml', ['form'=>$form]);

//	...
D( $form->Values(), $form->Test(), $form->Debug() );
