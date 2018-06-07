<?php
/**
 * Notice.class.php
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-18
 */
namespace OP\UNIT;

/**
 * Notice
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Notice
{
	/** trait.
	 *
	 */
	use \OP_CORE, \OP_SESSION;

	/** Display to dump of notice.
	 *
	 * @param array $notice
	 */
	static public function _Dump( $notice )
	{
		switch( $mime = \Env::Mime() ?? 'text/html' ){
			case 'text/html':
				//	Escape is done with self::Shutdown().
				//	$notice = Escape($notice);
				Json($notice, 'OP_NOTICE');
				break;

			case 'text/css':
			case 'text/javascript':
				echo "/* {$notice['message']} */".PHP_EOL;
				break;

			default:
				echo PHP_EOL.$notice['message'].PHP_EOL;
		}
	}

	/** Send email of notice.
	 *
	 * @param array $notice
	 */
	static public function _Mail( $notice )
	{
		static $to, $from, $file_path;

		//	...
		if( !$to ){

			//	...
			if(!$to = \Env::Get(\Env::_ADMIN_MAIL_) ){
				echo '<p class="error">Has not been set admin mail address.</p>'.PHP_EOL;
				return;
			}

			//	...
			if(!$from = \Env::Get(\Env::_MAIL_FROM_) ){
				$from = $to;
			}

			//	...
			$file_path = __DIR__.'/mail/notice.phtml';

			//	...
			if( file_exists($file_path) === false ){
				print "<p class=\"error\">Does not file exists. ($file_path)</p>";
				return;
			}
		}

		//	...
		if(!ob_start()){
			echo '<p>"ob_start" was failed. (Notice::Shutdown)</p>'.PHP_EOL;
			return;
		}

		//	...
		include($file_path);

		//	...
		$content = ob_get_clean();

		//	...
		$subject = Decode($notice['message']);

		//	...
		$mail = new \EMail();
		$mail->From($from);
		$mail->To($to);
		$mail->Subject($subject);
		$mail->Content($content, 'text/html');
		if(!$io = $mail->Send() ){
			return;
		}
	}

	/** Callback of app shutdown.
	 *
	 */
	static function Shutdown()
	{
		//	...
		try {
			//	...
			$is_admin = \Env::isAdmin();

			//	...
			if( $is_admin and \Unit::Load('webpack') ){
				//	...
				\OP\UNIT\WebPack::Js(__DIR__.'/notice');

				//	...
				\OP\UNIT\WebPack::Css(__DIR__.'/notice');
			}

			//	...
			while( $notice = \Notice::Get() ){
				//	...
				if( $is_admin ){
					self::_Dump($notice);
				}else{
					self::_Mail($notice);
				}
			}
		} catch ( \Throwable $e ) {
			echo '<p>'.$e->GetMessage().'</p>'.PHP_EOL;
		}
	}
}
