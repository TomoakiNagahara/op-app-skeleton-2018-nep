<?php
/**
 * OP_CORE.trait.php
 *
 * @creation  2017-02-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * OP_CORE
 *
 * @creation  2016-12-05
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_CORE
{
	/** Calling to has not been set method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __call($name, $args)
	{
		$join = [];
		foreach( $args as $val ){
			switch( $type = gettype($val) ){
				case 'array':
					$count  = count($val);
					$join[] = $type."($count)";
					break;

				case 'object':
					$join[] = $type;
					break;
				default:
					$join[] = $val;
			}
		}

		//	...
		$class   = get_class($this);
		$serial  = join(', ', $join);
		$message = "This method has not been exists. ({$class}->{$name}({$serial}))";

		//	...
		Notice::Set($message, debug_backtrace(false));
	}

	/** Calling to has not been set static method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	static function __callstatic($name, $args)
	{
		$message = "This method has not been exists. ($name)";
		Notice::Set($message, debug_backtrace(false));
	}

	/** Calling to has not been set property.
	 *
	 * @param string $name
	 */
	function __get($name)
	{
		$message = "This property has not been exists. ($name)";
		Notice::Set($message, debug_backtrace(false));
	}

	/** Calling to has not been set property.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __set($name, $args)
	{
		$message = "This property has not been exists. ($name)";
		Notice::Set($message, debug_backtrace(false));
	}

	/** Enumerate property names to serialize.
	 *
	 */
	function __sleep()
	{
		return [];
	}

	/** Process to restore from serialized character string.
	 *
	 */
	function __wakeup()
	{

	}

	/** Store to static variable.
	 *
	 * @param  string $key
	 * @param  mixed  $val
	 * @return mixed  $val
	 */
	static private function _Store($key, $val=null)
	{
		static $_store;
		if( $val !== null ){
			$_store[$key] = $val;
		}
		return $_store[$key] ?? null;
	}
}
