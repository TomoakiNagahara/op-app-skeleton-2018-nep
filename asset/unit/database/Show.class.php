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
		$result = [];
		$column = strpos($query, 'SHOW FULL COLUMNS FROM') === 0 ? true: false;
		$index  = strpos($query, 'SHOW INDEX FROM')        === 0 ? true: false;

		//	...
		foreach( $records as $temp ){
			if( $column ){
				$name = $temp['Field'];
				foreach( $temp as $key => $val ){
					//	...
					$key = lcfirst($key);

					//	...
					if( $key === 'type' and $st = strpos($val, '(') and $en = strpos($val, ')') ){
						$type   = substr($val, 0, $st);
						$length = substr($val, $st+1, $en - $st -1 );

						//	...
						if( is_numeric($length) ){
							$length = (int)$length;
						}

						//	...
						$result[$name]['type']   = $type;
						$result[$name]['length'] = $length;
						continue;
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
			}else if( $index ){
				$name = $temp['Key_name'];
				$seq  = $temp['Seq_in_index'];
				$result[$name][$seq] = $temp;
			}else{
				foreach( $temp as $key => $val ){
					$result[] = $val;
				}
			}
		}

		//	...
		return $result;
	}
}
