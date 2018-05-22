<?php
/**
 * unit-database:/QQL.class.php
 *
 * @created   2017-01-24
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2017-12-18
 */
namespace OP\UNIT\DATABASE;

/** QQL
 *
 * @created   2017-01-24
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class QQL
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Parse option.
	 *
	 * @param  array  $options
	 * @return array  $result
	 */
	static private function _ParseOption($options=[])
	{
		//	...
		if( gettype($options) === 'string' ){
			$options = self::_ParseOptionString($options);
		}

		//	...
		$result = ['','',''];

		//	...
		foreach( $options as $key => $val ){
			switch( $key = trim($key) ){
				case 'limit':
					$result[0] = 'LIMIT '.(int)$val;
					break;

				case 'order':
					if( $pos = strpos($val, ' ') ){
						$field = substr($val, 0, $pos);
						$order = substr($val, $pos);
						$result[1] = "ORDER BY `{$field}` $order";
					}else{
						$result[1] = "ORDER BY `{$val}`";
					}
					break;

				case 'offset':
					$result[2] = 'OFFSET '.(int)$val;
					break;
			}
		}

		//	...
		return $result;
	}

	/** Parse option string.
	 *
	 * @param  string $options
	 * @return array  $result
	 */
	static private function _ParseOptionString($options)
	{
		//	...
		$result = null;

		//	...
		foreach( explode(',', $options) as $option ){
			//	...
			$option = trim($option);

			//	...
			if( $pos = strpos($option, '=') ){
				$key = substr($option, 0, $pos);
				$val = substr($option, $pos +1);
			}else{
				continue;
			}

			//	...
			$result[$key] = $val;
		}

		//	...
		return $result;
	}

	/** Convert to SQL from QQL.
	 *
	 * @param   string      $qql
	 * @param   string      $opt
	 * @param  \IF_DATABASE $_db
	 * @return  array       $sql
	 */
	static function Parse($qql, $opt, $_db)
	{
		$field  = '*';
		$dbname = '';
		$table  = '';
		$where  = '';
		$limit  = '';
		$order  = '';
		$offset = '';

		//	field
		if( $pos = strpos($qql, '<-') ){
			list($field, $qql) = explode('<-', $qql);
			if( strpos($field, ',') ){
				//	Many fields.
				$fields = explode(',', $field);
				$join   = [];
				foreach( $fields as $temp ){
					$join[] = $_db->Quote($temp);
				}
				$field = join(',', $join);
			}else
			if( $st = strpos($field, '(') and
				$en = strpos($field, ')') ){
				//	func(field) --> FUNC('field')
				$func  = substr($field, 0, $st);				// func( field ) --> func
				$field = substr($field, $st +1, $en - $st -1);	// func( field ) --> " field "
				$field = trim($field);							// " field "     --> "field"
				$field = $_db->Quote($field);					// field         --> 'field'
				$func  = strtoupper($func);						// func          --> FUNC
				$field = "$func($field)";						//               --> func('field')
			}else{
				//	Single field.
				$field = $_db->Quote($field);
			}
		}

		//	...
		if( $pos = strrpos($qql, ' = ') ){
		}else if( $pos = strrpos($qql, '>') ){
		}else if( $pos = strrpos($qql, '<') ){
		}else if( $pos = strrpos($qql, '>=') ){
		}else if( $pos = strrpos($qql, '<=') ){
		}else if( $pos = strrpos($qql, '!=') ){
		}else{    $pos = false; }

		//	QQL --> database.table, value
		if( $pos === false ){
			$db_table = trim($qql);
		}else{
			$where    = true;
			$db_table = trim(substr($qql, 0, $pos));
			$evalu    = trim(substr($qql, $pos, 2));
			$value    = trim(substr($qql, $pos +2));
		}

		//	database.table --> database, table
		$pos = strpos($db_table, '.');
		if( $pos === false ){
			$table = $db_table;
		}else{
			$temp = explode('.', $db_table);
			if( $where ){
				switch( count($temp) ){
					case 2:
						$table = $temp[0];
						$which = $temp[1];
						break;
					case 3:
						$dbname= $temp[0];
						$table = $temp[1];
						$which = $temp[2];
						break;
					default:
						d($temp);
				}

				//	...
				if( $value === 'null' ){
					$value  =  'NULL';
					$evalu  =  'IS';
				}else{
					$value = $_db->PDO()->quote($value);
				}
				$which = $_db->Quote($which);
				$where = "WHERE {$which} {$evalu} {$value}";
			}else{
				switch( count($temp) ){
					case 1:
						$table = trim($temp);
						break;
					case 2:
						$dbname= $temp[0];
						$table = $temp[1];
						break;
					default:
						d($temp);
				}
			}
		}

		//	...
		$dbname = $dbname ? $_db->Quote($dbname).'.': null;
		$table  = $_db->Quote($table);

		//	...
		list($limit, $order, $offset) = self::_ParseOption($opt);

		//	...
		return [
			'database' => $dbname,
			'table'    => $table,
			'field'    => $field,
			'where'    => $where,
			'order'    => $order,
			'limit'    => $limit,
			'offset'   => $offset
		];
	}

	/** Execute Select.
	 *
	 * @param   array       $select
	 * @param  \IF_DATABASE $_db
	 * @return  array       $record
	 */
	static function Select($select, $_db)
	{
		//	...
		foreach( ['database','table','field','where','order','limit','offset'] as $key ){
			${$key} = $select[$key];
		}

		//	...
		$query = "SELECT $field FROM $database $table $where $order $limit $offset";

		//	"LIMIT 1" --> 1
		$limit = (int)substr($limit, strpos($limit, ' ')+1);

		//	...
		$record = $_db->Query($query, 'select');

		//	QQL is " name <- t_table.id = $id " and limit is 1.
		if( $limit === 1 and count($record) === 1 ){
			return array_shift($record);
		}

		//	...
		return $record;
	}

	/** Execute QQL.
	 *
	 * @param   string       $qql
	 * @param   string|array $opt
	 * @param  \IF_DATABASE  $DB
	 * @return  array        $record
	 */
	static function Execute($qql, $opt, $DB)
	{
		//	...
		$select = self::Parse($qql, $opt, $DB);

		//	...
		return self::Select($select, $DB);
	}
}
