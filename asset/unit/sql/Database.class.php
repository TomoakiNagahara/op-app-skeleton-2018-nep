<?php
/**
 * unit-sql:/Database.class.php
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\SQL;

/** Database
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Database
{
	/** trait
	 *
	 */
	use \OP_CORE;

	static function Create($DB, $database, $charset='utf8mb4', $collate='utf8mb4_general_ci')
	{
		$database = $DB->Quote($database);
		$charset  = $DB->Quote($charset);
		$collate  = $DB->Quote($collate);

		//	...
		return "CREATE DATABASE $database DEFAULT CHARACTER SET $charset COLLATE $collate";
	}

	static function Change()
	{
		return "ALTER DATABASE {DB名} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
	}
}
