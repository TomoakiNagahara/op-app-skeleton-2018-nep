<?php
/**
 * unit-sql:/SQL.class.php
 *
 * @created   2016-11-28
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-02-16
 */
namespace OP\UNIT;

/** SQL
 *
 * @created   2016-11-29
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class SQL
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Count
	 *
	 * @param   array       $config
	 * @param  \IF_DATABASE $DB
	 * @return  string      $query
	 */
	function Count($args, $DB)
	{
		$args['column']	 = ['COUNT'=>'*'];
		$args['limit']	 = 1;
		return SQL\Select::Get($args, $DB);
	}

	/** Generate delete sql statement.
	 *
	 * @param   array       $config
	 * @param  \IF_DATABASE $DB
	 * @return  string      $query
	 */
	function Delete($args, $DB)
	{
		return SQL\Delete::Get($args, $DB);
	}

	/** Generate insert sql statement.
	 *
	 * @param   array       $config
	 * @param  \IF_DATABASE $DB
	 * @return  string      $query
	 */
	function Insert($args, $DB)
	{
		return SQL\Insert::Get($args, $DB);
	}

	/** Generate select sql statement.
	 *
	 * @param   array       $config
	 * @param  \IF_DATABASE $DB
	 * @return  string      $query
	 */
	function Select($args, $DB)
	{
		return SQL\Select::Get($args, $DB);
	}

	/** Generate show sql statement.
	 *
	 * @param   array       $config
	 * @param  \IF_DATABASE $DB
	 * @return  string      $query
	 */
	function Show($args=null, $DB)
	{
		//	...
		if(!empty($args['user']) ){
			return SQL\Show::User($args, $DB);
		}

		//	...
		if(!empty($args['index']) ){
			return SQL\Show::Index($DB, $args['database'], $args['table']);
		}

		//	...
		if(!empty($args['field']) or !empty($args['column']) ){
			return SQL\Show::Column($DB, $args['database'], $args['table']);
		}

		//	...
		if(!empty($args['table']) ){
			return SQL\Show::Table($DB, $args['database']);
		}

		//	...
		return SQL\Show::Database($DB);
	}

	/** Generate update sql statement.
	 *
	 * @param   array       $config
	 * @param  \IF_DATABASE $DB
	 * @return  string      $query
	 */
	function Update($args, $DB)
	{
		return SQL\Update::Get($args, $DB);
	}
}
