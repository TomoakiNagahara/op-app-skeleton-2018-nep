<?php
/**
 * unit-sql:/Insert.class.php
 *
 * @created   2016-11-28
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2016-??-??
 * @changed   2018-01-02
 */
namespace OP\UNIT\SQL;

/** Insert
 *
 * @created   2016-11-29
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Insert
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Get insert sql statement.
	 *
	 * @param	 array
	 * @param	\IF_DATABASE
	 * @return	 string
	 */
	static function Get($args, $db=null)
	{
		//	...
		if(!$db){
			\Notice::Set("Has not been set database object.");
			return false;
		}

		//	TABLE
		if( $table = ifset($args['table']) ){
			$table = $db->Quote($table);
		}else{
			\Notice::Set("Has not been set table name.");
			return false;
		}

		//	SET
		if(!$set = DML::set($args, $db)){
			\Notice::Set("Has not been set condition. ($table)");
			return false;
		}

		//	ON DUPLICATE KEY UPDATE
		if( $update = ifset($args['update']) ){
			if(!is_string($update) ){
				\Notice::Set('The "ON DUPLICATE KEY UPDATE" is not string. (Please set of field name)');
				return false;
			}
			$dml = [];
			$dml['table'] = $args['table']; // For error message.
			foreach( explode(',', $update) as $key ){
				$key = trim($key);
				$dml['set'][$key] = $args['set'][$key];
			}
			$update = "ON DUPLICATE KEY UPDATE " . DML::Set($dml, $db);
		}

		//	...
		return "INSERT INTO {$table} SET {$set} {$update}";
	}
}
