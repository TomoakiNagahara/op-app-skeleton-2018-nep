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
	static function Get(array $args, \IF_DATABASE $db=null)
	{
		//	...
		if(!$db){
			\Notice::Set("Has not been set database object.");
			return false;
		}

		//	TABLE
		if(!$table = DML::Table($args, $db) ){
			return false;
		}

		//	...
		$set = $fields = $values = null;

		//	...
		if( $db->Config()['prod'] === 'mysql' ){
			//	SET
			if(!$set = DML::Set($args, $db)){
				return false;
			};
		}else{
			//	...
			if( empty($args['values']) and isset($args['set']) ){
				$args['values'] = $args['set'];
				unset($args['set']);
			};

			//	VALUES
			list($fields, $values) = DML::Values($args, $db);

			//	...
			if( empty($fields) or empty($values) ){
				return false;
			};
		};

		//	ON DUPLICATE KEY UPDATE
		if( $update = $args['update'] ?? null ){
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
		return "INSERT INTO {$table}{$fields}{$values}{$set} {$update}";
	}
}
