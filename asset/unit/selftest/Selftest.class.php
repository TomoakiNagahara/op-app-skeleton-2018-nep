<?php
/**
 * unit-selftest:/Selftest.class.php
 *
 * @created   2018-01-05
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-03-19
 */
namespace OP\UNIT;

/** Selftest
 *
 * @created   2018-01-05
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Selftest implements \IF_UNIT
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Generate Configer instance.
	 *
	 * @return \OP\UNIT\SELFTEST\Configer
	 */
	static function Configer()
	{
		return new \OP\UNIT\SELFTEST\Configer();
	}

	/** Automatically do self test.
	 *
	 */
	function Auto($config)
	{
		//	...
		if(!$db = $this->Database() ){
			include(__DIR__.'/form.phtml');
			return;
		};

		//	...
		\OP\UNIT\SELFTEST\Inspector::Auto($config, $db);

		//	Internal notice.
		echo '<ol class="error">';
		foreach( self::Error() as $error ){
			Html($error, 'li');
		};
		echo '</ol>';

		//	...
		\OP\UNIT\SELFTEST\Inspector::Result();

		//	...
		return !\OP\UNIT\SELFTEST\Inspector::Failed();
	}

	/** Get the unit of Database.
	 *
	 * @return \OP\UNIT\Database $database
	 */
	function Database()
	{
		//	...
		if(!$config = $this->Form() ){
			return;
		};

		// @var $db \OP\UNIT\Database
		if(!$db = \Unit::Instantiate('database') ){
			return;
		};

		//	...
		if(!$config['prod'] ){
			return false;
		};

		//	...
		if(!$db->Connect($config) ){
			return false;
		};

		//	...
		return $db;
	}

	/** Form
	 *
	 */
	function Form()
	{
		//	...
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
			return;
		};

		//	...
		$config = [];

		//	...
		foreach(['prod','host','port','user','password','charset'] as $key){
			//	...
			if(!$val = $_POST[$key] ?? null ){
				/*
				return false;
				*/
			}

			//	...
			$config[$key] = Escape($val);
		};

		//	...
		return $config;
	}

	/** Inspector
	 *
	 * @param	 array				 $args
	 * @param	\OP\UNIT\Database	 $db
	 * @return	 boolean			 $io
	 */
	function Inspector($args, $db)
	{
		return \OP\UNIT\SELFTEST\Inspector::Inspection($args, $db);
	}

	/** Result
	 *
	 */
	function Result()
	{
		return \OP\UNIT\SELFTEST\Inspector::Result();
	}

	/** Error
	 *
	 */
	static function Error($error=null)
	{
		//	...
		static $_errors = [];

		//	...
		if( $error ){
			//	...
			$_errors[] = $error;
		}else{
			//	...
		//	D( \OP\UNIT\SELFTEST\Inspector::Error() );
			return $_errors;
		}
	}

	function Help($config=null)
	{
		$readme = file_get_contents(__DIR__.'/README.md');
		echo '<dir class="border">';
		echo nl2br($readme);
		echo '</dir>';
	}

	function Debug($config=null)
	{
		\OP\UNIT\SELFTEST\Inspector::Debug();
	}
}
