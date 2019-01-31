<?php
/**
 * unit-notfound:/index.php
 *
 * @creation  2019-01-30
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $form IF_FORM */
$form = Unit::Instantiate('Form');

//	...
$form->Config(__DIR__.'/config.form.php');

//	...
if( Env::isAdmin() ){
	if(!$io = $form->Test() ){
		D($io);
	};
};

//	...
return $form;
