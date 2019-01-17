<?php
/**
 * unit-database:/SQL_LITE.class.php
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

/** SQLITE
 *
 * @creation  2019-01-07
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class SQLITE
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
		if(!$path = $config['path'] ?? null ){
			throw new \Exception("Has not been set file path.");
		};

		//	...
		if( $path === ':memory:' ){
			//	OK
		}else{
			if( file_exists($path) ){
				/*
				//	Parent directory.
				$file = basename($path);
				$perm = substr(sprintf('%o', fileperms($file)), -4);
				if( '0777' !== $perm ){

				};

				//	Database file.
				$perm = substr(sprintf('%o', fileperms($path)), -4);
				if( '0666' !== $perm ){

				};
				*/
			}else{
				throw new \Exception("Database file has not been exists. ($path)");
			}
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
		$path = $config['path'];
		$dsn  = "{$prod}:{$path}";

		//	...
		return $dsn;
	}

	/** Connect
	 *
	 * @param	 array		 $config
	 * @throws	\Exception	 $e
	 * @return	\PDO		 $pdo
	 */
	static function Connect(array $config)
	{
		//	...
		try{
			//	...
			$dsn      = self::DSN($config);

			//	...
			return new \PDO($dsn);

		}catch( \PDOException $e ){
			require_once(__DIR__.'/SQL_PHP_PDO_Error.class.php');
			SQL_PHP_PDO_Error::Auto('mysql', $e);
		}catch( \Exception $e ){
			\Notice::Set($e->getMessage() . " ($dsn)");
		};
	}

	/** Create database
	 *
	 * @param	 array	 $config
	 * @return	 boolean
	 */
	static function Create(array $config)
	{
		//	...
		if(!$path = $config['path'] ?? null ){
			return false;
		};

		//	...
		if( $io = touch($path) ){
			$io = chmod($path, 0666);
		}

		//	...
		return $io;
	}
}
