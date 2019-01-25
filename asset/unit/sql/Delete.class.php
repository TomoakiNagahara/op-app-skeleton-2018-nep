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

		//	OFFSET
		if( isset($args['offset']) ){
			\Notice::Set("OFFSET can not be used in DELETE.");
			return false;
		};

		//	...
		if( 'mysql' === ($prod = $db->Config()['prod']) ){
			//	LIMIT
			if(($limit = DML::Limit($args, $db)) === false ){
				return false;
			};

			//	ORDER
			if(($order = DML::Order($args, $db)) === false ){
				return false;
			};
		}else{
			//	...
			if( isset($args['limit']) or isset($args['order']) ){
				\Notice::Set("This product has not been support LIMIT and ORDER. ({$prod})");
			};

			//	...
			$order = $limit = null;
		};

		return "DELETE FROM {$table} WHERE {$where} {$order} {$limit}";
	}
}