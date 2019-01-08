<?php
/**
 * unit-database:/SQL_PG.class.php
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

/** PGSQL
 *
 * @creation  2019-01-07
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class PGSQL
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
		if(!defined('\PDO::PGSQL_ATTR_DISABLE_PREPARES') ){
			$module = 'postgresql';
			include( ConvertPath('asset:/bootstrap/php/content.phtml') );
			throw new \Exception("php-{$module} is not installed.");
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
		return null;
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
			$option   = self::Option($config);
			$role     = $config['role'];
			$password = $config['password'];

			//	...
			return new \PDO($dsn, $role, $password, $option);

		}catch( \PDOException $e ){
			switch( $e->getCode() ){
				default:
					\Notice::Set($e);
			};
		}catch( \Exception $e ){
			\Notice::Set($e->getMessage() . " ($dsn, $role, $password)");
		};
	}
}
