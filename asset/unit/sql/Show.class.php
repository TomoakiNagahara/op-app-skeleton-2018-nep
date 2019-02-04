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

			case 'sqlite':
				$sql = "SELECT * FROM 'sqlite_master' WHERE type='table'";
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
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				$database = $DB->Quote($database);
				$table    = $DB->Quote($table);
				$sql = "SHOW FULL COLUMNS FROM {$database}.{$table}";
				break;

			case 'pgsql':
				$table    = $DB->PDO()->quote($table);
				$sql = "SELECT * FROM information_schema.columns WHERE table_name = {$table}";
				break;

			case 'sqlite':
				$table    = $DB->Quote($table);
				$sql = "PRAGMA TABLE_INFO({$table})";
				break;

			default:
				throw new \Exception("This product has not been support. ($prod)");
		};

		//	...
		return $sql;
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
		if( 1 ){
			$database = $db->Quote($database);
			$table    = $db->Quote($table);
			return "SHOW INDEX FROM {$database}.{$table}";
		}else{
			//	...
			if( $database ){
				$database = 'table_schema='.$db->PDO()->Quote($database);
			};

			//	...
			if( $table ){
				$database.= ' AND ';
				$database.= 'table_name='  .$db->PDO()->Quote($table);
			};

			//	...
			return "SELECT * FROM information_schema.statistics WHERE {$database}";
		};
	}

	/** Show user list.
	 *
	 * @param	\IF_DATABASE $DB
	 */
	static function User($config, $DB)
	{
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				//	MySQL 5.6
				$sql = "SELECT `host`, `user`, `password` FROM `mysql`.`user`";
				//	MySQL 5.7
			//	$sql = "SELECT `host`, `user`             FROM `mysql`.`user`";
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
