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
	static function Database(\IF_DATABASE $DB)
	{
		//	...
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				$sql = 'SHOW DATABASES';
				break;

			case 'pgsql':
				$sql = 'SELECT * FROM "pg_database"';
				break;

			default:
				throw new \Exception("Has not been support this product. ($prod)");
		};

		//	...
		return $sql;
	}

	/** Show table list.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $database
	 * @return	 string		 $sql
	 */
	static function Table(\IF_DATABASE $DB, $database)
	{
		//	...
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				$database = $DB->Quote($database);
				$sql = "SHOW TABLES FROM {$database}";
				break;

			case 'pgsql':
				$sql = 'SELECT * FROM "pg_stat_user_tables"';
				break;

			default:
				throw new \Exception("Has not been support this product. ($prod)");
		};

		//	...
		return $sql;
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
		return $_cache[$database][$table] = sprintf("SHOW FULL COLUMNS FROM %s.%s", $DB->Quote($database), $DB->Quote($table));
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
				$sql = "SELECT `host`, `user`, `password` FROM `mysql`.`user`";
				break;

			case 'pgsql':
				$sql = 'SELECT * FROM "pg_shadow"';
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
