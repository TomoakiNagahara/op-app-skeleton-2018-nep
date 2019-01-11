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
		$database = strpos($query, 'SHOW DATABASES')         === 0 ? true: false;
		$column   = strpos($query, 'SHOW FULL COLUMNS FROM') === 0 ? true: false;
		$column   = strpos($query, 'SHOW FULL COLUMNS FROM') === 0 ? true: false;
		$index    = strpos($query, 'SHOW INDEX FROM')        === 0 ? true: false;
		$select   = strpos($query, 'SELECT ')                === 0 ? true: false;
		$user     = null;

		//	...
		if( $select ){
			if( strpos($query, 'FROM `mysql`.`user`') or strpos($query, 'FROM "pg_shadow"') ){
				$user     = true;
			}else{
				$database = true;
			};
		}

		//	...
		if( $database ){
			//	...
			return self::_Database($records);
		}else if( $column ){
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

	/** Database
	 *
	 * @param  array $records
	 * @return array $result
	 */
	static private function _Database($records)
	{
		//	...
		$result = [];

		//	...
		foreach( $records as $record ){
			$result[] = $record['Database'] ?? $record['datname'] ?? 'empty database name';
		};

		//	...
		return $result;
	}

	/** Column
	 *
	 * @param  array $records
	 * @return array $result
	 */
	static private function _Column($records)
	{
		//	...
		$result = [];

		//	...
		foreach( $records as $record ){
			//	...
			$name = $record['Field'];

			//	...
			foreach( $record as $key => $val ){
				//	...
				if( $key === 'Collation' or $key === 'Default' ){
					if( $val === null ){
						continue;
					}
				}

				//	...
				$key = lcfirst($key);

				//	...
				if( $key === 'type' ){
					//	Parse --> type unsigned --> type, unsigned
					if( $pos = strpos($val, 'unsigned') ){
						$val = substr($val, 0, $pos-1);
						$result[$name]['unsigned'] = true;
					}

					//	Parse --> type(length) --> type, length
					if( $st = strpos($val, '(') and $en = strpos($val, ')') ){
						$type   = substr($val, 0, $st);
						$length = substr($val, $st+1, $en - $st -1 );

						//	...
						if( is_numeric($length) ){
							$length = (int)$length;
						}

						//	...
						$result[$name]['type']   = $type;
						$result[$name]['length'] = $length;

						//	...
						continue;
					}
				}

				//	...
				if( $key === 'null' ){
					$val = $val === 'YES' ? true: false;
				}

				//	...
				if( $key === 'key' ){
					$val = strtolower($val);
				}

				//	...
				$result[$name][$key] = $val;
			}
		}

		//	...
		return $result;
	}

	/** Index
	 *
	 * @param  array $records
	 * @return array $result
	 */
	static private function _Index(array $records)
	{
		//	...
		$result = [];

		//	...
		foreach( $records as $record ){
			//	...
			$name = $record['Key_name'];
			$seq  = $record['Seq_in_index'];
			$result[$name][$seq] = $record;
		}

		//	...
		return $result;
	}

	/** User
	 *
	 * @param  array $records
	 * @return array $result
	 */
	static private function _User(array $records)
	{
		//	...
		$result = [];

		//	...
		foreach( $records as $record ){
			//	...
			$host     = $record['host']     ?? 'localhost';
			$user     = $record['user']     ?? $record['usename'] ?? null;;
		//	$password = $record['password'] ?? null;

			//	...
			$result[$host][$user] = true;
		}

		//	...
		return $result;
	}
}
