<?php
/**
 * unit-database:/SQL_MY.class.php
 *
 * @creation  2019-01-07
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-01-07
 */
namespace OP\UNIT\DATABASE;

/** MYSQL
 *
 * @creation  2019-01-07
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class MYSQL
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Config
	 *
	 * @param	 array		 $config
	 * @throws	\Exception	 $e
	 * @return	 array		 $config
	 */
	static function Config(array $config)
	{
		//	...
		if(!defined('\PDO::MYSQL_ATTR_INIT_COMMAND') ){
			$module = 'mysql';
			include( ConvertPath('asset:/bootstrap/php/content.phtml') );
			throw new \Exception("php-{$module} is not installed.");
		};

		//	...
		if( empty($config['charset']) ){
			$config['charset'] = 'utf8';
		};

		//	...
		return $config;
	}

	/** Data Source Name
	 *
	 * @param	 array		 $config
	 * @throws	\Exception	 $e
	 * @return	 string		 $dsn
	 */
	static function DSN(array $config)
	{
		//	...
		$prod = $config['prod'];

		//	...
		if(!$host = $config['host'] ?? null ){
			throw new \Exception("Has not been set host.");
		};

		//	Data Source Name
		$dsn = "{$prod}:host={$host}";

		//	Database
		if( $database = $config['database'] ?? null ){
			$dsn .= ";dbname={$database}";
		}

		//	...
		return $dsn;
	}

	/** Option
	 *
	 * @param	 array		 $config
	 * @throws	\Exception	 $e
	 * @return	 array		 $option
	 */
	static function Option(array $config)
	{
		//	...
		$charset = empty($config['charset']) ? 'utf8': $config['charset'];

		//	...
		$option = [];

		//	Character set. (指定字符代码, 指定字符代碼)
		$option[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES {$charset}";

		//	Multi statement. (多个指令, 多個指令)
		$option[\PDO::MYSQL_ATTR_MULTI_STATEMENTS] = false;

		//	Persistent connect. (持续连接, 持續連接)
		$option[\PDO::ATTR_PERSISTENT] = false;

		//	...
		return $option;
	}

	/** Connect
	 *
	 * @param	 array		 $config
	 * @throws	\Exception	 $e
	 * @return	\PDO		 $pdo
	 */
	static function Connect($config)
	{
		//	...
		try{
			//	...
			$dsn      = self::DSN($config);
			$option  = self::Option($config);
			$user     = $config['user'];
			$password = $config['password'];

			//	...
			return new \PDO($dsn, $user, $password, $option);

		}catch( \PDOException $e ){
			switch( $e->getCode() ){
				case '2002':
					$key = 'pdo_mysql.default_socket';
					$ini = ini_get($key);
					$str = $e->getMessage();
					if( $ini ){
						\Notice::Set("{$str} ({$ini})");
					}else{
						\Notice::Set("Has not been set '{$key}'.");
					};
					break;
				default:
					\Notice::Set($e);
			};
		}catch( \Exception $e ){
			\Notice::Set($e->getMessage() . " ($dsn, $user, $password)");
		};
	}
}
