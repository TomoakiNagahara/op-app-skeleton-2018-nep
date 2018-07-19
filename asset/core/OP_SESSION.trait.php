<?php
/**
 * OP_SESSION.trait.php
 *
 * @creation  2017-02-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** OP_SESSION
 *
 * @creation  2017-02-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_SESSION
{
	/**
	 * Get/Set Session value.
	 *
	 * Separated from each class/object.
	 * Static class and instantiated object to do the same behavior.
	 *
	 * @param  string
	 * @param  mixed
	 * @return mixed
	 */
	static function Session($key, $value=null)
	{
		static $app_id;

		//	...
		if(!$app_id){
			if(!$app_id = Env::Get(_OP_APP_ID_) ){
				$app_id = Hasha1(ConvertPath('app:/'));
			}
		}

		//	...
		$class = get_called_class();

		//	...
		if( func_num_args() === 2 ){
			$_SESSION[_OP_NAME_SPACE_][$app_id][$class][$key] = Escape($value);
		}

		//	...
		if(!isset($_SESSION[_OP_NAME_SPACE_][$app_id][$class][$key]) ){
			      $_SESSION[_OP_NAME_SPACE_][$app_id][$class][$key] = null;
		}

		//	...
		return $_SESSION[_OP_NAME_SPACE_][$app_id][$class][$key];
	}
}
