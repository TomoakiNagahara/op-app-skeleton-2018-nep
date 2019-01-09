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
	 * @return	 string		 $sql
	 */
	static function Database()
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
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $database_name
	 * @param	 string		 $table_name
	 * @return	 string		 $sql
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
	static function User($config, $DB)
	{
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				$sql = "SELECT host, user, password FROM mysql.user";
				break;

			case 'pgsql':
				$sql = "SELECT * FROM pg_user";
				break;

			default:
				$sql = false;
				\Notice::Set("This product has not been support yet. ($prod)");
		}
		return $sql;
	}

	/** Show user grant.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $user
	 * @param	 string		 $host
	 * @return	 string		 $query
	 */
	static function Grant($DB, $host, $user)
	{
		$user = $DB->PDO()->Quote($user);
		$host = $DB->PDO()->Quote($host);
		return "SHOW GRANTS FOR {$user}@{$host}";
	}
}
