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
$valid = $form->Validate();

//	...
$action = App::Args()[3] ?? 'form';

//	...
switch( $action ){
	case 'form':
		$file = 'form.phtml';
		break;

	case 'confirm':
		$file = $valid ? 'confirm.phtml':'form.phtml';
		break;

	case 'commit':
		if( $valid ){
			include('commit.inc.php');
			$file = 'conversion.phtml';
		}else{
			$file = 'form.phtml';
		}
		break;

	case 'thanks':
		$file = 'thanks.phtml';
		break;

	case 'clear':
		$form->Clear();
		$file = 'form.phtml';
		break;

	default:
		D("Undefined action. ($action)");
		return;
}

//	...
App::Template($file, ['form'=>$form]);

//	...
D( $form->Values(), $form->Test(), $form->Debug() );
