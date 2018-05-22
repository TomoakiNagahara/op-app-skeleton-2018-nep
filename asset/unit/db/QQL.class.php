<?php
/**
 * unit-db:/QQL.class.php
 *
 * @created   2017-01-24
 * @version   1.0
 * @package   unit-db
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2017-12-18
 */
namespace OP\UNIT\DB;

/**
 * QQL
 *
 * @created   2017-01-24
 * @version   1.0
 * @package   unit-db
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class QQL
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Configuration.
	 *
	 * @var array
	 */
	static private $_config;

	/** Parse option.
	 *
	 * @param string $options
	 */
	static private function _ParseOption($options=[])
	{
		//	...
		if( is_string($options) === 'string' ){
			foreach( explode(',', $options) as $option ){
				list($key, $val) = explode('=', $option);
				$options[trim($key)] = trim($val);
			}
		}

		//	...
		foreach(['limit','order','offset'] as $key){
			$result[$key]  = empty($options[$key]) ? null: $options[$key];
		}

		//	...
		return $result;
	}

	/** Convert to SQL from QQL.
	 *
	 * @param  string      $qql
	 * @param  string      $opt
	 * @param  \OP\UNIT\DB $_db
	 * @return array       $sql
	 */
	static private function _Parse($qql, $opt, $_db)
	{
		$field  = '*';
		$dbname = null;
		$table  = null;
		$where  = null;
		$limit  = null;
		$order  = null;
		$offset = null;

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
				$which = $_db->Quote($which);
				$value = $_db->GetPDO()->quote($value);
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
		foreach( $opt as $key => $val ){
			//	...
			if( empty($val) ){
				continue;
			}

			//	...
			switch( $key = trim($key) ){
				case 'limit':
					$limit = 'LIMIT '.(int)$val;
					break;

				case 'order':
					if( $pos   = strpos($val, ' ') ){
						$fiel_ = substr($val, 0, $pos);
						$order = substr($val, $pos);
						$order = "ORDER BY `{$fiel_}` $order";
					}else{
						$order = "ORDER BY `{$val}`";
					}
					break;

				case 'offset':
					$offset = 'OFFSET '.(int)$val;
					break;
			}
		}

		//	...
		return [
			'database' => $dbname,
			'table'    => $table,
			'field'    => $field,
			'where'    => $where,
			'limit'    => $limit,
			'order'    => $order,
			'offset'   => $offset,
		];
	}

	/** Execute Select.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DETABASE $DB
	 * @return	 array		 $record
	 */
	static private function _Build($select, $_db)
	{
		//	...
		foreach( ['database','table','field','where','order','limit','offset'] as $key ){
			${$key} = $select[$key];
		}

		//	...
		$query = "SELECT $field FROM $database $table $where $order $limit $offset";

		//	...
		return $query;
	}

	/** Return configuration.
	 *
	 * @return	 array		 $config
	 */
	static function Config()
	{
		return self::$_config;
	}

	/** Execute QQL.
	 *
	 * @param	 string		 $qql
	 * @param	 string		 $opt
	 * @param	\IF_DATABASE $_db
	 * @return	 array		 $record
	 */
	static function Execute($qql, $opt, $_db)
	{
		//	...
		$opt = self::_ParseOption($opt);

		//	...
		self::$_config = self::_Parse($qql, $opt, $_db);

		//	...
		$query = self::_Build(self::$_config, $_db);

		//	...
		if( $records = $_db->Query($query, 'select') ){
			//	Success
			$_db->Database(self::$_config['database']);
			$_db->Table(   self::$_config['table']   );
		}else{
			//	Failure
			return [];
		}

		//	QQL is " name <- t_table.id = $id " and limit is 1.
		if( ifset($opt['limit']) === 1 and count($records) === 1 ){
			$record = array_shift($records);
		}

		//	...
		if( self::$_config['field'] !== '*' and strpos(self::$_config['field'], ',') === false ){
			//	...
			$quote = self::$_config['field'][0];

			//	...
			$field = trim(self::$_config['field'], $quote);

			//	...
			foreach( $records as $temp ){
				$record[] = $temp[$field];
			}
		}

		//	...
		return $record ?? $records;
	}
}
