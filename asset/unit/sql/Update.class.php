<?php
/**
 * unit-sql:/Update.class.php
 *
 * @created   2016-11-30
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

/** Update
 *
 * @created   2016-11-30
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Update
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Get update sql statement.
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
		};

		//	TABLE
		if(!$table = DML::Table($args, $db) ){
			return false;
		};

		//	SET
		if(!$set = DML::Set($args, $db)){
			return false;
		};

		//	WHERE
		if(!$where = DML::Where($args, $db) ){
			return false;
		};

		//	OFFSET
		if( isset($args['offset']) ){
			\Notice::Set("OFFSET can not be used in UPDATE.");
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

		//	...
		return "UPDATE {$table} {$set} WHERE {$where} {$order} {$limit}";
	}
}
