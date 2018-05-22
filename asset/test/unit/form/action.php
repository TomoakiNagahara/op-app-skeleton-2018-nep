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
/* @var $form \OP\UNIT\Form */
if(!$form = Unit::Instance('Form') ){
	return;
}

//	...
$form->Config(__DIR__.'/config.inc.php');

//	...
if( $io = $_GET['clear'] ?? false ){
	$form->Clear();
}

//	...
App::Template('index.phtml', ['form'=>$form]);

//	...
D($form->Values());
