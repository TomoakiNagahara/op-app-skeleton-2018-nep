<?php
/**
 * unit-sql:/Show.class.php
 *
 * @created   2016-12-07
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  ????
 * @changed   2017-12-12
 */
namespace OP\UNIT\SQL;

/** Show
 *
 * @created   2016-12-07
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Show
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Show database list.
	 *
	 * @param	\IF_DATABASE $DB
	 * @return	 string		 $sql
	 */
	static function Database($db)
	{
		return 'SHOW DATABASES';
	}

	/** Show table list.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $database
	 * @return	 string		 $sql
	 */
	static function Table($db, $database)
	{
		$database = $db->Quote($database);
		return "SHOW TABLES FROM {$database}";
	}

	/** Show column list
	 *
	 * @param  DB     $DB
	 * @param  string $database
	 * @param  string $table
	 * @return string $sql
	 */
	static function Column($DB, $database, $table)
	{
		//	...
		static $_cache;

		//	...
		if( isset( $_cache[$database][$table]) ){
			return $_cache[$database][$table];
		}

		//	...
		$database = $DB->Quote($database);
		$table    = $DB->Quote($table);

		//	...
		return $_cache[$database][$table] = "SHOW FULL COLUMNS FROM {$database}.{$table}";
	}

	/** Show index list.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @return	 string		 $sql
	 */
	static function Index($db, $database, $table)
	{
		$database = $db->Quote($database);
		$table    = $db->Quote($table);
		return "SHOW INDEX FROM {$database}.{$table}";
	}

	/** Show user list.
	 *
	 * @param	\IF_DATABASE $DB
	 */
	static function User($DB)
	{
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				$sql = "SELECT host, user, password FROM mysql.user";
				break;

			default:
				$sql = false;
		}
		return $sql;
	}
}
