<?php
/**
 * unit-test:/unit/form/action.php
 *
 * @creation  2018-05-15
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if( $_GET['sleep'] ?? 0 ){
	sleep($_GET['sleep']);
}

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
Nav::Set('Sleep(ON)' , ['sleep'=>1]);
Nav::Set('Sleep(OFF)', ['sleep'=>0]);
Nav::Set('Debug(ON)' , ['debug'=>1]);
Nav::Set('Debug(OFF)', ['debug'=>0]);
Nav::Out();

//	...
App::Template('index.phtml', ['form'=>$form]);

//	...
D( $form->Values(), $form->Test(), $form->Debug() );
