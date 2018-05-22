<?php
/**
 * unit-sql:/DML.class.php
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

/** DML
 *
 * @created   2016-11-30
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class DML
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Get table condition.
	 *
	 * @param   array
	 * @param  \IF_DATABASE
	 * @return  string
	 */
	static function Table($args, $db)
	{
		//	...
		$database = ifset($args['database']);

		//	...
		if( $table = ifset($args['table']) ){
			//	test.t_test
			if( $pos = strpos($table, '.') ){
				//	test.t_test --> test, t_test
				$database = substr($table, 0, $pos);
				$table    = substr($table, $pos+1);
			}

			//	...
			$database = $database ? $db->Quote($database).'.': null;

			//	...
			$table = $db->Quote($table);
		}else{
			\Notice::Set("Has not been set table name.");
		}

		//	...
		return $database.$table;
	}

	/** Get set condition.
	 *
	 * @param  array
	 * @param  db
	 * @return string
	 */
	static function Set($args, $db)
	{
		//	...
		if( empty($args['set']) ){
			\Notice::Set("Has not been set SET condition. ({$args['table']})");
			return false;
		}

		//	...
		foreach( $args['set'] as $column => $value ){
			$column	 = $db->Quote($column);
			$value	 = $db->GetPDO()->quote($value);
			$join[] = "{$column} = {$value}";
		}

		//	...
		return join(', ', $join);
	}

	/** Get where condition.
	 *
	 * @param   array
	 * @param  \IF_DATABASE
	 * @return  string
	 */
	static function Where( array $args, \IF_DATABASE $db)
	{
		//	...
		if( empty($args['where']) ){
			\Notice::Set("Has not been set WHERE condition. ({$args['table']})");
			return false;
		}

		//	...
		if( 'array' !== $type = gettype($args['where']) ){
			\Notice::Set("WHERE condition is not assoc. ( type --> $type)");
			return false;
		}

		//	...
		foreach( $args['where'] as $column => $condition ){
			if( is_array($condition) ){
				$evalu = ifset($condition['evalu'], '=');
				$value = ifset($condition['value']);
			}else{
				$value = $condition;
				$evalu = '=';
			}

			//	...
			if( $value === null ){
				$evalu = $evalu === '=' ? 'IS NULL':'IS NOT NULL';
			}

			//	...
			$column	 = $db->Quote($column);
			$value	 = $db->GetPDO()->quote($value);

			//	...
			switch( $evalu = strtoupper($evalu) ){
				case 'IS NULL':
				case 'IS NOT NULL':
					$join[] = "{$column} {$evalu}";
					break;

				case 'BETWEEN':
					//	'1 TO 10' --> 1 TO 100
					$value = substr($value, 1, -1);
					list($st, $en) = explode('TO', $value);
					$st = $db->GetPDO()->quote(trim($st));
					$en = $db->GetPDO()->quote(trim($en));
					$join[] = "{$column} {$evalu} {$st} AND {$en}";
					break;

				case 'IN':
				case 'NOT IN':
					//	...
					if( is_string($value) ){
						//	'foo, bar' --> foo, bar
						$value = substr($value, 1, -1);
						$value = explode(',', $value.',');
					}else if( is_array($value) ){
						$value = $value;
					}else{
						$value = [];
					}

					//	...
					$in = [];
					foreach( $value as $temp ){
						if( strlen($temp) ){
							$in[] = $db->GetPDO()->quote(trim($temp));
						}
					}

					//	...
					$value  = join(',', $in);
					$join[] = "{$column} {$evalu} ({$value})";
					break;

				case '=':
				case '>':
				case '<':
				case '>=':
				case '<=':
					$join[] = "{$column} {$evalu} {$value}";
					break;

				default:
					$join[] = "{$column} = {$value}";
			}
		}
		return '('.join(' AND ', $join).')';
	}

	/** Get limit condition.
	 *
	 * @param  array
	 * @return string
	 */
	static function Limit($args)
	{
		if(!isset($args['limit']) ){
			\Notice::Set("Has not been set LIMIT condition. ({$args['table']})");
			return false;
		}
		return 'LIMIT '.(int)$args['limit'];
	}

	/** Get order condition.
	 *
	 * @param  array
	 * @param  db
	 * @return string
	 */
	static function Order($args, $db)
	{
		foreach( explode(',', $args['order']) as $value ){
			list($field, $value) = explode(' ', $value);
			$field  = $db->Quote($field);
			$field .= $value === 'desc' ? ' DESC': '';
			$join[] = $field;
		}

		//	...
		return "ORDER BY ".join(', ', $join);
	}
}