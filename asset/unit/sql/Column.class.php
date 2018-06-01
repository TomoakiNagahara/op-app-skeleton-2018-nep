<?php
/**
 * unit-sql:/Column.class.php
 *
 * @created   2017-12-01
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\SQL;

/** Column
 *
 * @created   2017-12-01
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Column
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Create new column
	 *
	 * @param  string $column
	 * @param  \DB    $db
	 * @return string $sql
	 */
	static function Create($database, $table, $column, $config, $db)
	{
		//	...
		if( 'auto_increment' === strtolower(ifset($config['extra'])) ){
			//	First, AI is must be exists PKEY. But, not create yet. (Contradiction of SQL)
			//	AI is to modify column after create column and PKEY index.
			unset($config['extra']);
		}

		//	...
		return self::Generate($database, $table, $column, $config, $db, 'ADD');
	}

	/** Change exists column
	 *
	 * @param  string $database
	 * @param  string $table
	 * @param  string $column
	 * @param  array  $config
	 * @param  \DB    $DB
	 * @return string $sql
	 */
	static function Change($database, $table, $column, $config, $DB)
	{
		return self::Generate($database, $table, $column, $config, $DB, 'MODIFY');
	}

	static function Generate($database, $table, $field, $config, $DB, $verb)
	{
		//	...
		$database = $DB->Quote($database);
		$table    = $DB->Quote($table);
		$field    = $DB->Quote($field);

		//	...
		$first   = ifset($config['first']);
		$after   = ifset($config['after']);

		//	...
		if(!$first = $first ? 'FIRST': null ){
			$after = ifset($config['after']) ? "AFTER ".$DB->Quote($after): null;
		}

		//	...
		$common = self::Field($config, $DB);
		$index  = self::Index($config, $DB);

		//	"PRIMARY KEY" can not been change.
		if( $verb === 'MODIFY' and strpos($index, 'PRIMARY KEY') === 0 ){
			$index = null;
		}

		//	...
		if( $verb === 'MODIFY' ){
			$index = null;
		}

		//	...
		return "ALTER TABLE $database.$table $verb $common $first $after $index";
	}

	/** Generate each field SQL.
	 *
	 * @param   array      $config
	 * @param  \OP\UNIT\DB $DB
	 * @throws \Exception
	 * @return  string     $SQL
	 */
	static function Field($config, $DB)
	{
		//	...
		$field   = ifset($config['field']  );
		$type    = ifset($config['type']   );
		$unsigned= ifset($config['unsigned']);
		$length  = ifset($config['length'] );
		$default = ifset($config['default']);
		$extra   = ifset($config['extra']  );
		$null    = ifset($config['null']   );
		$comment = ifset($config['comment'], "''" );
		$charset = ifset($config['charset']);
		$collate = ifset($config['collate']);

		//	Escape
		$field   = $DB->Quote($field);
		$comment = $DB->GetPDO()->Quote($comment);
		$default = $default === null ? null: "DEFAULT ".$DB->GetPDO()->Quote($default);

		//	extra is use to auto increment only.
		switch( $extra = strtoupper($extra) ){
			case 'AUTO_INCREMENT':
				break;
			default:
				$extra = null;
		}

		//	set or enum
		$option  = ifset($config['option'] );
		$options = ifset($config['options'], $option);

		//	...
		if( $null !== null ){
			$null  = $null ? 'NULL': 'NOT NULL';
		}

		//	...
		switch( $type = strtoupper($type) ){
			case 'INT':
			case 'TINYINT':
			case 'SMALLINT':
			case 'MEDIUMINT':
			case 'BIGINT':
				$length = (int)$length;
				break;

			case 'SET':
			case 'ENUM':
				if( !$length ){ $length = $options; }
				if( $type !== 'INT' ){
					$join = [];
					foreach( explode(',', $length) as $value ){
						$join[] = $DB->GetPDO()->quote( trim($value) );
					}
					$length = join(',', $join);
				}
				break;

			case 'CHAR':
			case 'VARCHAR':
				if( $length ){
					throw new \Exception("Has not been set length. ($database, $table, $field, $type)");
				}else{
					$length = (int)$length;
				}
				break;

			case 'TIMESTAMP':
				$default = 'DEFAULT CURRENT_TIMESTAMP';
				$extra   = 'ON UPDATE CURRENT_TIMESTAMP';
				break;

			default:
				//	Why use regx?
				if( strpos($type, 'UNSIGNED') ){
					//	break
				}else
				if( preg_match('/[^A-Z]/', $type) ){
					\Notice::Set("Has not been support this type. ($type)");
				}
		}

		//	...
		if( $length ){
			$type = "$type($length)";
		}

		//	...
		if( $unsigned ){
			$type .= " UNSIGNED";
		}

		//	...
		$charset = self::Charset($charset, $collate);

		//	...
		return "$field $type $charset $default $extra $null COMMENT $comment";
	}

	static function Charset($charset, $collate)
	{
		//	...
		if( !$charset and !$collate ){
			return null;
		}

		//	...
		switch( $charset ){
			case 'ascii':
				if(!$collate ){
					$collate = 'ascii_general_ci';
				}
				break;

			case 'utf8':
			case 'utf-8':
				$charset = 'utf8mb4';
				$collate = 'utf8mb4_general_ci';
				break;

			default:
			if( $collate ){
				list($charset) = explode('_', $collate);
			}else{
				return null;
			}
		}

		//	...
		return "CHARACTER SET {$charset} COLLATE {$collate}";
	}

	static function Index($config, $db)
	{
		//	...
		if( empty($config['key']) ){
			return null;
		}

		//	...
		$field = $db->Quote($config['field']);

		//	...
		$key = Index::Type($config['type'], $config['key']);

		//	...
		return "$key($field)";
	}

	/** Calc integer length.
	 *
	 * @param	 string		 $type
	 * @param	 boolean	 $unsigned
	 * @param	 integer	 $length
	 * @return	 integer	 $length
	 */
	static function Length($type, $unsigned)
	{
		//	...
		switch( strtolower($type) ){
			case 'tinyint':
				$length = 4;
				break;

			case 'smallint':
				$length = 6;
				break;

			case 'mediumint':
				$length = 8;
				break;

			case 'int':
				$length = 11;
				break;

			case 'bigint':
				$length = 20;
				break;

			default:
		}

		//	...
		if( $unsigned ){
			$length--;
		}

		//	...
		return $length ?? null;
	}
}
