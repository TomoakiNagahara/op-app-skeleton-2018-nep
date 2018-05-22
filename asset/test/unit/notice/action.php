<?php
/**
 * unit-test:/unit/notice/action.php
 *
 * @creation  2018-04-13
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	XSS from message.
Notice::Set('<h1>XSS(1)');

//	XSS from arguments.
XSS('<h1>XSS(2)', true, false, null, 0, 1, ['<h1>XSS'], ['xss'=>'<h1>XSS']);

//	...
if( ifset($_GET['mail']) ){
	if(!Env::isAdmin() ){
		echo '<p>Your not administrator.</p>';
		return;
	}

	//	...
	if( Unit::Load('notice') ){
		//	...
		$notice = Notice::Get();

		D($notice);

		//	...
		\OP\UNIT\Notice::_Mail($notice);
	}
}

//	...
function XSS($arg){
	Notice::Set($arg);
	return $arg;
}

?>
<div>
	<a href="?mail=1">Notice is receive by EMail.</a>
</div>
