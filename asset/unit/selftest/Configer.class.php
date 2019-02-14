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

	/** Save configuration.
	 *
	 * @var array
	 */
	static private $_config;

	/** Get saved configuration.
	 *
	 */
	static function Get()
	{
		return self::$_config;
	}

	/** Wrap method.
	 *
	 * @param	 string	 $method
	 * @param	 array	 $config
	 */
	static function Set($method, $config)
	{
		switch( strtolower($method) ){
			case 'table':
				//	...
				$table_name = $config['table'] ?? $config['name'] ?? null;

				//	...
				if(!$table_name ){
					\Notice::Set("Has not been set table name.");
					return;
				};

				//	...
				self::Table(
					$table_name,
					$config['comment']   ?? null,
					$config['charset']   ?? null,
					$config['collation'] ?? null
				);
				break;

			case 'column':
				//	...
				$option = [];
				$option['unsigned'] = $config['unsigned'] ?? null;

				//	...
				$column_name = $config['column'] ?? $config['field'] ?? $config['name'] ?? null;

				//	...
				if(!$column_name ){
					\Notice::Set("Has not been set column name.");
					return;
				};

				//	...
				if( $ai = $config['ai'] ?? null ){
					//	...
					$type = 'int';
					$option['unsigned'] = true;
				};

				//	...
				self::Column(
					$column_name,
					$config['type']    ?? $type,
					$config['length']  ?? null,
					$config['null']    ?? true,
					$config['default'] ?? null,
					$config['comment'] ?? null,
					$option
				);

				//	auto increment
				if( $ai ){
					self::Index(
						$column_name,
						'ai',
						$column_name,
						'auto incremant id'
					);
				};
				break;

			case 'index':
				self::Index(
					$config['name'],
					$config['type'],
					$config['column'],
					$config['comment']
				);
				break;
			default:
				\Notice::Set("Has not been support this method. ($method)");
				break;
		}
	}

	/** Get DSN
	 *
	 * @param	 array		 $config
	 * @return	 string		 $dsn
	 */
	static function DSN($config=null)
	{
		//	...
		static $_config = [
			'host'    => 'localhost',
			'product' => 'mysql',
			'port'    => '3306'
		];

		//	...
		foreach( array_keys($_config) as $key ){
			if( $val = $config[$key] ?? null ){
				$_config[$key] = $val;
			}
		}

		//	...
		return sprintf('%s://%s:%s', $_config['product'], $_config['host'], $_config['port']);
	}

	/** Set user.
	 *
	 * @param	 array		 $config
	 */
	static function User($config=null)
	{
		//	...
		$dsn = self::Dsn();

		//	...
		$host = $config['host'] ?? null;
		$user = $config['user'] ?? $config['name'] ?? null;

		//	...
		if( !$host or !$user ){
			throw new \Exception("Has not been set user name or host name. ({$user}@{$host})");
		}

		//	...
		self::$_config[$dsn]['users'][$user]['host']     = $host;
		self::$_config[$dsn]['users'][$user]['name']     = $user;
		self::$_config[$dsn]['users'][$user]['password'] = $config['password'] ?? null;
		self::$_config[$dsn]['users'][$user]['charset']  = $config['charset']  ?? 'utf8';
	}

	/** Set privilege.
	 *
	 * @param	 array		 $config
	 */
	static function Privilege($config)
	{
		//	...
		$user = $database = $table = $privilege = $column = null;

		//	...
		foreach(['user','database','table','privilege','column'] as $key ){
			//	...
			if( empty($config[$key]) ){
				throw new \Exception("Has not been set this value. ($key)");
			};

			//	...
			${$key} = $config[$key];
		};

		//	...
		$dsn = self::Dsn();

		//	...
		$table     = str_replace(' ', '', $table    );
		$privilege = str_replace(' ', '', $privilege);

	//	...
		self::$_config[$dsn]['users'][$user]['privilege'][$database][$table][$privilege] = $column;
	}

	/** Get/Set password.
	 *
	 * @param	 string		 $password
	 * @return	 string		 $password
	 */
	/*
	static function Password($password=null)
	{
		static $_password;
		if( $password ){
			$_password = $password;

			//	...
			$dsn  = self::Dsn();
			$user = self::User();
			self::$_config[$dsn]['users'][$user]['password'] = $_password;
		}
		return $_password;
	}
	*/

	/** Get/Set database config.
	 *
	 * @param	 array		 $config
	 * @return	 string		 $database
	 */
	static function Database($config=null)
	{
		static $_database;

		//	...
		if( $config ){
			//	...
			$_database = $config['name'];
			$charset   = $config['charset'] ?? 'utf8';

			//	...
			$dsn       = self::Dsn();
			$collation = self::_Collate($charset);

			//	...
			self::$_config[$dsn]['databases'][$_database]['name']      = $_database;
			self::$_config[$dsn]['databases'][$_database]['collation'] = $collation;
		}

		//	...
		return $_database;
	}

	/** Get/Set table config.
	 *
	 * @param	 string		 $table
	 * @param	 string		 $comment
	 * @param	 string		 $charset
	 * @return	 string		 $table is current table name.
	 */
	static function Table($table=null, $comment=null, $charset='utf8', $collation=null)
	{
		//	...
		static $_table;

		//	...
		if( $table ){
			$_table    = $table;
			$dsn       = self::Dsn();
			$database  = self::Database();
			$collation = self::_Collate($charset, $collation);
			self::$_config[$dsn]['databases'][$database]['tables'][$table]['name']      = $_table;
			self::$_config[$dsn]['databases'][$database]['tables'][$table]['collation'] = $collation;
			self::$_config[$dsn]['databases'][$database]['tables'][$table]['comment']   = $comment;
		}

		//	...
		return $_table;
	}

	/** Set column config.
	 *
	 * @param	 string		 $name
	 * @param	 string		 $type
	 * @param	 string|int	 $length
	 * @param	 boolean	 $null
	 * @param	 string|null $default
	 * @param	 string		 $comment
	 * @param	 array		 $option
	 */
	static function Column($name, $type, $length, $null, $default, $comment, $option=[])
	{
		//	...
		$dsn      = self::Dsn();
		$database = self::Database();
		$table    = self::Table();

		//	...
		$type     = strtolower($type);
		$length   = $option['length']   ?? $length;
		$unsigned = $option['unsigned'] ?? null;

		//	...
		$column = [];
		$column['field']    = $name;
		$column['name']     = $name;
		$column['type']     = $type;
		$column['unsigned'] = $unsigned;
		$column['length']   = $length ?? \OP\UNIT\SQL\Column::Length($type, $unsigned);
		$column['null']     = $null;
		$column['default']  = $default;
		$column['comment']  = $comment;

		//	...
		switch( $type ){
			case 'timestamp':
				$column['extra']   = 'on update CURRENT_TIMESTAMP';
				$column['default'] = 'CURRENT_TIMESTAMP';
				$column['null']    = false;
				break;

			default:
		}

		//	...
		self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$name] = $column;
	}

	/** Set index config.
	 *
	 * @param   string    $name
	 * @param   string    $type
	 * @param   string    $column
	 * @param   string    $comment
	 * @throws \Exception $e
	 */
	static function Index(string $name, string $type, string $column, string $comment)
	{
		//	...
		$dsn      = self::Dsn();
		$database = self::Database();
		$table    = self::Table();

		//	...
		$columns = [];
		foreach( explode(',', $column) as $field ){
			//	...
			$field = trim($field);

			//	...
			if( empty(self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$field]) ){
				self::Error("Set index was failed. Has not been set this field name. ($dsn, $database, $table, $field)");
				return;
			};

			//	...
			$columns[] = $field;
		}

		//	...
		$index = [];
		$index['name']    = $name;
		$index['type']    = $type;
		$index['column']  = $column;
		$index['comment'] = $comment;

		//	...
		switch( $type ){
			case 'ai':
			case 'pri':
			case 'pkey':
				//	...
				if( count($columns) !== 1 ){
					\Notice::Set("Primary key is just only one column. ($column)");
				};
				//	...
				self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$column]['key']   = 'pri';
				self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$column]['null']  = false;

				//	...
				if( $type === 'ai' or $type === 'auto_increment' ){
					self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$column]['extra'] = 'auto_increment';
				}
			break;
		}

		//	...
		self::$_config[$dsn]['databases'][$database]['tables'][$table]['indexes'][$name] = $index;
	}

	/** Set charset.
	 *
	 * @param	 string		 $field
	 * @param	 string		 $charset
	 */
	static function Charset($field, $charset)
	{
		self::Collate($field, $charset);
	}

	/** Set collate.
	 *
	 * @param	 string		 $field
	 * @param	 string		 $collate
	 */
	static function Collate($field, $collate)
	{
		//	...
		$dsn      = self::Dsn();
		$database = self::Database();
		$table    = self::Table();
		$collate  = self::_Collate($collate);
		list($charset) = explode('_', $collate);

		//	...
		if( empty(self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$field]) ){
			\Notice::Set("Set collate is failed. Has not been set this column. ($database, $table, $field)");
			return;
		}

		//	...
		self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$field]['charset']   = $charset;
		self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$field]['collate']   = $collate;
		self::$_config[$dsn]['databases'][$database]['tables'][$table]['columns'][$field]['collation'] = $collate;
	}

	/** Generate collate from charset.
	 *
	 * @param	 string		 $collate
	 * @return	 string		 $collate
	 */
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

	static function Error($error)
	{
		\OP\UNIT\Selftest::Error($error);
	}
}
