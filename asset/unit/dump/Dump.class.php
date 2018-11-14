<?php
/**
 * unit-dump:/Dump.class.php
 *
 * @creation  2018-04-13
 * @version   1.0
 * @package   unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-20
 */
namespace OP\UNIT;

/** Dump
 *
 * @creation  2018-04-13
 * @version   1.0
 * @package   unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Dump
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Escape variable.
	 *
	 * @param array &$args
	 */
	static function _Escape(&$args)
	{
		foreach( $args as &$arg ){
			switch( $type = gettype($arg) ){
				case 'array':
					self::_Escape($arg);
					break;

				case 'object':
					$name = get_class($arg);
					$arg  = "object($name)";
					break;

				case 'resource':
					$type = get_resource_type($arg);
					$arg  = "resource(type:$type)";
					break;

				case 'unknown type':
					$arg  = $type;
					break;

				default:
			}
		}
	}

	/** Mark
	 *
	 */
	static function Mark()
	{
		/**
		 * DEBUG_BACKTRACE_PROVIDE_OBJECT : Provide current object property.
		 * DEBUG_BACKTRACE_IGNORE_ARGS    : Ignore function or method arguments.
		 */
		$trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

		//	Arguments.
		$args = func_get_args()[0];

		//	...
		self::_Escape($args);

		//	...
		switch( \Env::Mime() ){
			case 'text/css':
				self::MarkCss($args, $trace);
				break;

			case 'text/javascript':
				self::MarkJS($args, $trace);
				break;

			case 'text/json':
			case 'text/jsonp':
				self::MarkJson($args, $trace);
				break;

			case 'text/plain':
				self::MarkPlain($args, $trace);
				break;

			case 'text/html':
			default:
				//	...
				if( \Unit::Load('webpack') ){
					//	Set to webpack list.
					static $is_webpack;
					if(!$is_webpack ){
						$is_webpack = true;
						//	..
						\OP\UNIT\WebPack::Js( [__DIR__.'/mark', __DIR__.'/dump']);
						\OP\UNIT\WebPack::Css([__DIR__.'/mark', __DIR__.'/dump']);
					}
				}
				//	...
				self::MarkHtml($args, $trace);
			break;
		}
	}

	/** MarkCss
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkCss($value, $trace)
	{
		print PHP_EOL;
		print "/* $value */".PHP_EOL;
	}

	/** MarkHtml
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkHtml($args, $trace)
	{
		//	...
		$later = [];

		//	$mark
		$mark = [];
		$mark['file'] = CompressPath($trace['file']);
		$mark['line'] = $trace['line'];
		$mark['args'] = [];

		//	$args
		foreach( $args as $value ){
			switch( $type = gettype($value) ){
				case 'array':
					//	Stack
					$later[] = $value;
					//	Look and feel to array.
					$count   = count($value);
					$value   = $type."($count)"; // --> array(1)
					break;

				case 'object':
					$later[] = $value;
					$value   = get_class($value);
					break;
			}

			$mark['args'][] = $value;
		}

		//	...
		Json($mark, 'OP_MARK');

		//	...
		foreach( $later as $value ){
			Json($value, 'OP_DUMP');
		}
	}

	/** MarkPlain
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkPlain($value, $trace)
	{
		echo CompressPath($trace['file']);
		echo ' #'.$trace['line'].PHP_EOL;
		print_r($value);
	//	var_dump($value);
	}

	/** MarkJS
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkJS($value, $trace)
	{
		print PHP_EOL;
		print "console.log($value);".PHP_EOL;
		print "console.dir($trace);".PHP_EOL;
	}

	/** MarkJson
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkJson($value, $trace)
	{
		global $_JSON; // Why used global variable?
		$mark = [];
		$mark['message']   = $value;
		$mark['backtrace'] = $trace;
		$_JSON['admin']['mark'][] = $mark;
	}
}
