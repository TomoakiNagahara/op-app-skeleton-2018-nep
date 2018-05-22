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

	/** Form
	 *
	 */
	function Form()
	{
		include(__DIR__.'/form.phtml');
	}

	/** Inspector
	 *
	 * @param  array   $args
	 * @return boolean $io
	 */
	function Inspector($args)
	{
		return \OP\UNIT\SELFTEST\Inspector::Inspection($args);
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
