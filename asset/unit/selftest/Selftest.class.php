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
class Selftest
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
			return;
		};

		//	...
		$io = \OP\UNIT\SELFTEST\Inspector::Auto($config, $db);

		//	...
		if(!$io ){
			$this->Form();
		}

		//	...
		\OP\UNIT\SELFTEST\Inspector::Result();
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
		if(!$db->Connect($config) ){
			return;
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
		include(__DIR__.'/form.phtml');

		//	...
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
			return;
		};

		//	...
		$config = [];

		//	...
		foreach(['driver','host','port','user','password','charset'] as $key){
			//	...
			if(!$val = $_POST[$key] ?? null ){
				return false;
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
	function Error()
	{
		return \OP\UNIT\SELFTEST\Inspector::Error();
	}
}
