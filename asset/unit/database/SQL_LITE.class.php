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
		}else if(!file_exists($path) ){
			throw new \Exception("File has not been exists. ($path)");
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
	static function Connect($config)
	{
		//	...
		try{
			//	...
			$dsn      = self::DSN($config);

			//	...
			return new \PDO($dsn);

		}catch( \PDOException $e ){
			switch( $e->getCode() ){
				case 0:
					$module = 'sqlite';
					\Notice::Set("php-{$module} is not installed.");
					include( ConvertPath('asset:/bootstrap/php/content.phtml') );
					break;
				default:
					\Notice::Set($e);
			};
		}catch( \Exception $e ){
			\Notice::Set($e->getMessage() . " ($dsn)");
		};
	}
}
