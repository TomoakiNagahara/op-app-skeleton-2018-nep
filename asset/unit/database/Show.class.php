<?php
/**
 * unit-db:/Show.class.php
 *
 * @created   2018-04-14
 * @version   1.0
 * @package   unit-db
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-05-14
 */
namespace OP\UNIT\Database;

/** Show
 *
 * @created   2018-04-14
 * @version   1.0
 * @package   unit-db
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Show
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Get show result.
	 *
	 * @param	 array	 $records
	 * @param	 string	 $query
	 * @return	 array	 $result
	 */
	static function Get($records, $query)
	{
		//	...
		$column = strpos($query, 'SHOW FULL COLUMNS FROM') === 0 ? true: false;
		$index  = strpos($query, 'SHOW INDEX FROM')        === 0 ? true: false;
		$user   = strpos($query, 'SELECT ')                === 0 ? true: false;

		//	...
		if( $column ){
			//	...
			return self::_Column($records);
		}else if( $index ){
			//	...
			return self::_Index($records);
		}else if( $user ){
			//	...
			return self::_User($records);
		}else{
			//	...
			return $records;
		}
	}
}
