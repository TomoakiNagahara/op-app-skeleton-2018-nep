<?php
/**
 * unit-database:/SQL_PHP_PDO_Error.class.php
 *
 * @creation  2019-01-09
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-01-09
 */
namespace OP\UNIT\DATABASE;

/** SQL_PHP_PDO_Error
 *
 * @creation  2019-01-09
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class SQL_PHP_PDO_Error
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** PHP PDO Error
	 *
	 * @param \PDOException $e
	 */
	static function Auto(string $prod, \PDOException $e)
	{
		//	...
		switch( $e->getCode() ){

			//	SQLite
			case 0:
				$module = 'sqlite';
				\Notice::Set("php-{$module} is not installed.");
				include( ConvertPath('asset:/bootstrap/php/content.phtml') );
				break;

			//	MySQL
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
	}
}
