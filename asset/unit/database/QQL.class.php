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

	static private function _ParseField($field, $_db)
	{
		//	...
		$join = [];

		//	...
		if( strpos($field, ',') ){
			//	Many fields.
			foreach( explode(',', $field) as $temp ){
				$join[] = self::_ParseFieldFunc($temp, $_db);
			}
		}else{
			//	Single field.
			$join[] = self::_ParseFieldFunc($field, $_db);
		}

		//	...
		return join(',', $join);
	}

	static private function _ParseFieldFunc($field, $_db)
	{
		//	...
		$match = NULL;

		//	...
		if( preg_match('|([_a-z0-9]+)\(([_a-z0-9]+)\)|i', $field, $match) ){
			$field = $match[1] .'('. $_db->Quote($match[2]) .')';
		}else{
			$field = $_db->Quote($field);
		}

		//	...
		return $field;
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
		$dbname = null;
		$table  = null;
		$where  = null;
		$limit  = null;
		$order  = null;
		$offset = null;
		$group  = null;

		//	field
		if( $pos = strpos($qql, '<-') ){
			list($field, $qql) = explode('<-', $qql);
			$field = self::_ParseField($field, $_db);
		}else{
			$field = '*';
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

				//	...
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
			'offset'   => $offset,
			'group'    => $group,
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
		$database = $table = $field = $where = $order = $limit = $offset = $group = null;

		//	...
		foreach( ['database','table','field','where','order','limit','offset', 'group'] as $key ){
			${$key} = $select[$key];
		}

		//	...
		$query = "SELECT $field FROM $database $table $where $group $order $limit $offset";

		//	"LIMIT 1" --> 1
		$limit = (int)substr($limit, strpos($limit, ' ')+1);

		//	...
		$record = $_db->Query($query, 'select');

		//	QQL is " name <- t_table.id = $id " and limit is 1.
		if( $limit === 1 ){
			//	In case of empty.
			if( count($record) === 0 ){
				//	Empty.
				$record = null;
			}else if( $field === '*' ){
				//	No adjust.
			}else{
				//	Has value.
				$record = array_shift($record);
			};
		};

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
