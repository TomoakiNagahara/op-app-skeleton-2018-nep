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
	static function Table(array $args, \IF_DATABASE $db)
	{
		//	...
		if( empty($args['table']) ){
			\Notice::Set("Has not been set table name.");
			return false;
		};

		//	...
		if( strpos($args['table'], '=') ){
			return self::_TableJoins($args, $db);
		}else{
			return self::_Table($args, $db);
		};
	}

	static private function _Table(array $args, \IF_DATABASE $db)
	{
		//	...
		$table = $args['table'];

		//	database_name.table_name
		if( $pos = strpos($table, '.') ){
			//	database_name.table_name --> database_name, table_name
			$database = substr($table, 0, $pos);
			$table    = substr($table, $pos+1);
		};

		//	...
		$table = $db->Quote($table);

		//	...
		if( $db->Config()['prod'] === 'mysql' and empty($database) ){
			$database = $args['database'] ?? null;
		};

		//	...
		if(!empty($database) ){
			$table = $db->Quote($database).'.'.$table;
		};

		//	...
		return $table;
	}

	static private function _TableJoin(string $table, \IF_DATABASE $db, $flag)
	{
		//	...
		$join = $match = null;

		//	...
		preg_match("/([\w\.]+)\s*([<>=]+)\s*([\w\.]+)/", $table, $match);

		//	...
		$join['left']  = explode('.', $match[1]);
		$join['right'] = explode('.', $match[3]);

		//	...
		switch( $match[2] ){
			case '=':
			case '<=':
				$eval = 'LEFT';
				break;
			case '=>':
				$eval = 'RIGHT';
				break;
			case '>=<':
				$eval = 'INNER';
				break;
			case '<=>':
				$eval = 'OUTER';
				break;
		};

		//	...
		$table1 = $db->Quote($join['left'][0] );
		$field1 = $db->Quote($join['left'][1] );
		$table2 = $db->Quote($join['right'][0]);
		$field2 = $db->Quote($join['right'][1]);

		//	...
		$table0 = $flag ? null: $table1;

		//	...
		return "$table0 $eval JOIN $table2 ON $table1.$field1 = $table2.$field2";
	}

	static private function _TableJoins(array $args, \IF_DATABASE $db)
	{
		//	...
		$join = [];

		//	...
		foreach( explode(',', $args['table']) as $table ){
			$join[] = self::_TableJoin($table, $db, count($join));
		};

		//	...
		return join(' ', $join);
	}

	/** Get VALUES
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $db
	 * @return 	 array		 $sql
	 */
	static function Values(array $args, \IF_DATABASE $db): array
	{
		//	...
		if( empty($args['values']) ){
			\Notice::Set("Has not been set values. ({$args['table']})");
			return [];
		};

		//	...
		$fields = $values = [];

		//	...
		foreach( $args['values'] as $field => $value ){
			$fields[] = $db->Quote($field);
			$values[] = $db->PDO()->Quote($value);
		};

		//	...
		$fields =         '('.join(', ', $fields).')';
		$values = ' VALUES ('.join(', ', $values).')';

		//	...
		return [$fields, $values];
	}

	/** Get set condition.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $DB
	 * @return	 string		 $sql
	 */
	static function _Set($args, $db)
	{
		//	...
		if( isset($args['set'][0]) ){
			return self::_Set0($args, $db);
		};

		//	...
		$join = [];

		//	...
		foreach( $args['set'] as $column => $value ){
			//	...
			$column	 = $db->Quote($column);

			//	...
			if( is_null($value) ){
				//	...
				$value = 'NULL';
			}else{
				//	...
				if( is_array($value) ){
					$value = join(',',$value);
				}
				//	...
				$value = $db->PDO()->quote($value);
			}

			//	...
			$join[] = "{$column} = {$value}";
		}

		//	...
		return join(', ', $join);
	}

	/** Get set condition.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $DB
	 * @return	 string		 $sql
	 */
	static function _Set0($args, $db)
	{
		//	...
		$join  = [];
		$match = null;

		//	...
		foreach( $args['set'] as $str ){
			if( preg_match('/([_a-z0-9]+)\s*=\s*(.+)/i', ltrim($str), $match) ){
				$field  = $db->Quote($match[1]);
				$value  = $db->PDO()->quote($match[2]);
				$join[] = "{$field} = {$value}";
			}else{
				\Notice::Set("Unmatch format. ($str)");
			};
		};

		//	...
		return join(', ', $join);
	}

	/** Get set condition.
	 *
	 * @param	 array
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static function Set($args, $db)
	{
		//	...
		if( empty($args['set']) ){
			\Notice::Set("Has not been set SET condition. ({$args['table']})");
			return false;
		}

		//	...
		return 'SET ' . self::_Set($args, $db);
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
		if( isset($args['where'][0]) ){
			return self::Where2($args, $db);
		};

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
				$evalu = ($evalu === '=') ? 'IS NULL':'IS NOT NULL';
			}

			//	...
			$column	 = $db->Quote($column);
			$value	 = $db->PDO()->quote($value);

			//	...
			$join = [];

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
					$st = $db->PDO()->quote(trim($st));
					$en = $db->PDO()->quote(trim($en));
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
							$in[] = $db->PDO()->quote(trim($temp));
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

	/** Get where condition version 2.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $db
	 * @return	 string		 $where
	 */
	static function Where2(array $args, \IF_DATABASE $db)
	{
		//	...
		$join  = [];
		$match = null;

		//	...
		foreach($args['where'] as $str){
			//	...
			if(!preg_match('/(\w+)\s+([^\s]+)\s+(.+)/i', $str, $match) ){
				\Notice::Set("Does not match format. ($str)");
				continue;
			};

			//	...
			$field = $match[1];
			$evalu = $match[2];
			$value = $match[3];
			$crude = trim($value);

			//	...
			$field = $db->Quote($field);
			$value = $db->PDO()->quote($value);

			//	...
			switch( $evalu = strtoupper($evalu) ){
				//	NULL
				case '!IS':
				case 'NOT':
					$evalu = 'IS NOT';
				//	break;
				case 'IS':
					if( 'NULL' === strtoupper($crude) ){
						$value = 'NULL';
					};
					break;

				//	IN
				case '!IN':
				case 'NOTIN':
					$evalu = 'NOT IN';
					//	break;
				case 'IN':
					$j = [];
					foreach( explode(',', $value) as $v ){
						$v = $db->PDO()->quote(trim($v));
					};
					$value = '('.join(',', $j).')';
					break;

				//	LIKE
				case '!LIKE':
				case 'NOTLIKE':
					$evalu = 'NOT LIKE';
					//	break;
				case 'LIKE':
					break;

				//	BETWEEN
				case 'BETWEEN':
					break;

				//	...
				case '=':
				case '>':
				case '<':
				case '>=':
				case '<=':
					break;

				//	...
				default:
					\Notice::Set("This evaluation was not supported. ($evalu)");
					return false;
			};

			//	...
			$join[] = "{$field} {$evalu} {$value}";
		};

		//	...
		return '('.join(' AND ', $join).')';
	}

	/** Generate limit condition.
	 *
	 * @param	 array
	 * @param	\IF_DATABASE
	 * @return	 string
	 */
	static function Limit($args, $db)
	{
		//	...
		if(!isset($args['limit']) ){
			\Notice::Set("Has not been set limit. ({$args['table']})");
		};

		//	...
		$limit = (int)$args['limit'];

		//	...
		return "LIMIT {$limit}";
	}

	/** Generate offset condition.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $db
	 * @return	 string		 $sql
	 */
	static function Offset($args, $db)
	{
		//	...
		if(!isset($args['offset']) ){
			return null;
		};

		//	...
		$offset = (int)$args['offset'];

		//	...
		return "OFFSET {$offset}";
	}

	/** Generate order condition.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $db
	 * @return	 string		 $sql
	 */
	static function Order($args, $db)
	{
		//	...
		if(!isset($args['order']) ){
			return null;
		};

		//	...
		$join = [];
		foreach( explode(',', $args['order']) as $value ){
			list($field, $order) = explode(' ', $value.' ');
			$field  = $db->Quote($field);
			$field .= $order === 'desc' ? ' DESC':'';
			$join[] = $field;
		}

		//	...
		return "ORDER BY ".join(', ', $join);
	}
}
