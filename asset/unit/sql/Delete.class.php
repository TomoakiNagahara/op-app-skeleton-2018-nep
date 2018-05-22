<?php
/**
 * unit-sql:/Delete.class.php
 *
 * @created   2016-12-01
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

/** Delete
 *
 * @created   2016-12-01
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Delete
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Get delete sql statement.
	 *
	 * @param   array       $config
	 * @param  \IF_DATABASE $DB
	 * @return  string      $SQL
	 */
	static function Get($args, $db=null)
	{
		//	...
		if(!$db){
			\Notice::Set("Has not been set database object.");
			return false;
		}

		//	TABLE
		if(!$table = DML::table($args, $db) ){
			return false;
		}

		//	WHERE
		if(!$where = DML::where($args, $db) ){
			return false;
		}

		//	LIMIT
		if(!$limit = DML::limit($args, $db)){
			return false;
		}

		//	ORDER
		$order = null;
		if( isset($args['order']) ){
			if( $db->Config()['prod'] === 'mysql' ){
				$order = DML::Order($args,  $db);
			}else{
				\Notice::Set("Could not used ORDER for DELETE SQL. (Except MYSQL)");
			}
		}

		//	OFFSET
		if( isset($args['offset']) ){
			\Notice::Set("Could not used OFFSET for DELETE SQL. ($table)");
			return false;
		}

		return "DELETE FROM {$table} WHERE {$where} {$order} {$limit}";
	}
}