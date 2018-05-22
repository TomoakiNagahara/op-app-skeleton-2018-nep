<?php
/**
 * unit-selftest:/Configer.class.php
 *
 * @created   2018-03-24
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-03-24
 */
namespace OP\UNIT\SELFTEST;

/** Configer
 *
 * @created   2018-03-24
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Configer
{
	/** trait
	 *
	 */
	use \OP_CORE;

	static private $_config;

	static function Get()
	{
		return self::$_config;
	}

	static function Host($host=null, $product=null, $port=null)
	{
		static $_host = 'localhost', $_product = 'mysql', $_port = '3306';

		//	...
		if( $host ){
			$_host = $host;
		}
		if( $product ){
			$_product = $product;
		}
		if( $port ){
			$_port = $port;
		}

		//	...
		if(!$host ){
			$_host;
		}
		if(!$product ){
			$_product;
		}
		if(!$port ){
			$_port;
		}

		//	...
		return sprintf('%s://%s:%s', $_product, $_host, $_port);
	}

	static function User($user=null, $password=null, $hash=null, $charset=null)
	{
		//	...
		static $_user, $_charset='utf8';

		//	...
		if( $user ){
			$_user = $user;
			$host  = self::Host();
			self::$_config[$host]['users'][$_user]['name'] = $_user;
		}

		//	...
		if( $password ){
			self::Password($password, $hash);
		}

		if( $charset ){
			$_charset = $charset;
			self::$_config[$host]['users'][$_user]['charset'] = $_charset;
		}

		//	...
		return $_user;
	}

	static function Password($password=null, $hash=false)
	{
		static $_password;
		if( $password ){
			$_password = $hash ? Hasha1($password, 16): $password;

			//	...
			$host = self::Host();
			$user = self::User();
			self::$_config[$host]['users'][$user]['password'] = $_password;
		}
		return $_password;
	}

	static function Database($database=null, $charset='utf8')
	{
		static $_database;
		if( $database ){
			$_database = $database;
			$host      = self::Host();
			$collation = self::_Collate($charset);
			self::$_config[$host]['databases'][$database]['name']      = $_database;
			self::$_config[$host]['databases'][$database]['collation'] = $collation;
		}
		return $_database;
	}

	static function Table($table=null, $comment=null, $charset='utf8')
	{
		static $_table;
		if( $table ){
			$_table    = $table;
			$host      = self::Host();
			$database  = self::Database();
			$collation = self::_Collate($charset);
			self::$_config[$host]['databases'][$database]['tables'][$table]['name']      = $_table;
			self::$_config[$host]['databases'][$database]['tables'][$table]['collation'] = $collation;
			self::$_config[$host]['databases'][$database]['tables'][$table]['comment']   = $comment;
		}
		return $_table;
	}

	static function Column($name, $type, $length, $null, $default, $comment)
	{
		//	...
		$host     = self::Host();
		$database = self::Database();
		$table    = self::Table();

		//	...
		$column['name']    = $name;
		$column['type']    = $type;
		$column['length']  = $length;
		$column['null']    = $null ? true: false;
		$column['default'] = $default;
		$column['comment'] = $comment;

		//	...
		switch( $type ){
			case 'timestamp':
				$column['extra']   = 'on update CURRENT_TIMESTAMP';
				$column['default'] = 'CURRENT_TIMESTAMP';
				break;

			default:
		}

		//	...
		self::$_config[$host]['databases'][$database]['tables'][$table]['columns'][$name] = $column;
	}

	static function Index($name, $type, $column, $comment)
	{
		//	...
		$host     = self::Host();
		$database = self::Database();
		$table    = self::Table();

		//	...
		$index['name']    = $name;
		$index['type']    = $type;
		$index['column']  = $column;
		$index['comment'] = $comment;

		//	...
		switch( $type ){
			case 'ai':
			case 'pri':
			case 'pkey':
				self::$_config[$host]['databases'][$database]['tables'][$table]['columns'][$column]['key']   = 'pri';
				self::$_config[$host]['databases'][$database]['tables'][$table]['columns'][$column]['extra'] = 'auto_increment';
				break;
		}

		//	...
		self::$_config[$host]['databases'][$database]['tables'][$table]['indexes'][$name] = $index;
	}

	static function Charset($table=null, $charset=null)
	{
		if( $table and $charset ){
			self::Collate($table, $charset);
		}
		return self::Collate();
	}

	static function Collate($field=null, $collate=null)
	{
		if( $field and $collate ){
			$host     = self::Host();
			$database = self::Database();
			$table    = self::Table();
			$collate  = self::_Collate($collate);
			list($charset) = explode('_', $collate);
			self::$_config[$host]['databases'][$database]['tables'][$table]['columns'][$field]['charset']   = $charset;
			self::$_config[$host]['databases'][$database]['tables'][$table]['columns'][$field]['collate']   = $collate;
			self::$_config[$host]['databases'][$database]['tables'][$table]['columns'][$field]['collation'] = $collate;
		}
	}

	static private function _Collate($collate)
	{
		switch( $collate ){
			case 'ascii':
				$collate = 'ascii_general_ci';
				break;

			case 'utf8':
			case 'utf-8':
				$collate = 'utf8mb4_general_ci';
				break;
		}
		return $collate;
	}
}
