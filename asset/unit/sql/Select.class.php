<?php
/**
 * unit-sql:/Select.class.php
 *
 * @created   2016-11-28
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-27
 */
namespace OP\UNIT\SQL;

/** Select
 *
 * @created   2016-11-29
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Select
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Get select sql statement.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $db
	 * @return	 string		 $sql
	 */
	static function Get($args, $db=null)
	{
		//	...
		if(!$db){
			\Notice::Set("Has not been set database object.");
			return false;
		}

		//	TABLE
		if(!$table = DML::Table($args, $db) ){
			return false;
		}

		/*
		//	COLUMN
		if(!$column = self::_Column($args, $db)){
			return false;
		}
		*/

		//	Field
		if(!$field = self::_Field($args, $db) ){
			$field = '*';
		};


		//	WHERE
		if(!$where = DML::Where($args, $db) ){
			return false;
		}

		//	LIMIT
		if(!$limit = DML::Limit($args, $db)){
			return false;
		}

		//	ORDER
		$order  = isset($args['order'])  ? DML::Order($args,  $db): null;

		//	OFFSET
		$offset = isset($args['offset']) ? DML::Offset($args, $db): null;

		//	...
		return "SELECT {$field} FROM {$table} WHERE {$where} {$order} {$limit} {$offset}";
	}

	/** Get field condition.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $db
	 * @return	 string		 $sql
	 */
	static private function _Field(array $args, \IF_DATABASE $db)
	{
		//	...
		$join = null;

		//	...
		foreach( $args['field'] ?? [] as $field ){
			//	...
			list($field, $alias) = explode(' as ', $field . ' as ');

			//	Separate function.
			if( $pos1 = strpos($field, '(') and $pos2 = strpos($field, ')') ){
				$func = substr($field,       0,         $pos1);
				$field= substr($field, $pos1+1, $pos2-$pos1-1);
			};

			//	If has table name.
			if( strpos($field, '.') ){
				//	Has table name.
				list($table, $field) = explode('.', $field);
				$table = $db->Quote(trim($table));
				$field = $db->Quote(trim($field));
				$field = "{$table}.{$field}";
			}else{
				//	Field name only.
				$field = $db->Quote(trim($field));
			};

			//	If has function.
			if( isset($func) ){
				$func  = strtoupper($func);
				$field = "{$func}($field)";
			};

			//	If has alias name.
			if( $alias ){
				$alias = $db->Quote(trim($alias));
			};

			//	...
			$join[] = $alias ? "$field AS $alias": $field;
		};

		//	...
		return count($join) ? join(', ', $join): null;
	}

	/** Get column condition.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $db
	 * @return	 string		 $sql
	 */
	static private function _Column(array $args, \IF_DATABASE $db)
	{
		//	...
		if( $column = ifset($args['column']) ){
			//	...
			if( is_string($column) ){
				$column = explode(',', $column);
			}

			//	...
			foreach($column as $key => $val){
				//	...
				$val = trim($val);

				//	...
				$join = [];

				//	...
				if( $st = strpos($val, '(') and
					$en = strpos($val, ')') ){
					//	...
					$leng  = $en - $st;
					$func  = strtoupper( substr($val,     0, $st)  );
					$field = strtoupper( substr($val, $st+1, $leng));
					$field = $db->quote(trim($field));

					//	...
					$join[] = "$func($field)";
					continue;
				}

				//	...
				if( strpos($val, ' ') !== false ){
					\Notice::Set("Not secure. ($val)");
					continue;
				}

				//	...
				if( is_string($key) ){
					$join[] = strtoupper($key)."($val)";
				}else{
					$join[] = $pdo->quote(trim($val));
				}
			}

			//	...
			$result = join(', ', $join);
		}else{
			$result = '*';
		}

		//	...
		return $result;
	}

	/** Generate hashed password.
	 *
	 * @param	 string		 $password
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static function Password($password, $DB)
	{
		//	...
		$password = $DB->PDO()->Quote($password);
		return "SELECT PASSWORD({$password})";
	}
}
