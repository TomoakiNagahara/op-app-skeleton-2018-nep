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
	 * @param	 string		 $column
	 * @param	\IF_DATABASE $db
	 * @return	 string		 $sql
	 */
	static function Create($database, $table, $column, $config, $db)
	{
		//	...
		if( 'auto_increment' === strtolower(ifset($config['extra'])) ){
			//	First, AI is must be exists PKEY. But, not create yet. (Contradiction of SQL)
			//	AI is to modify column after create column and PKEY index.
		//	unset($config['extra']);
		}

		//	...
		return self::Generate($database, $table, $column, $config, $db, 'ADD');
	}

	/** Change exists column
	 *
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	 string		 $column
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string		 $sql
	 */
	static function Change($database, $table, $column, $config, $DB)
	{
		return self::Generate($database, $table, $column, $config, $DB, 'MODIFY');
	}

	/** Generate Alter SQL.
	 *
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	 string		 $field
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $verb
	 * @return	 string
	 */
	static function Generate($database, $table, $field, $config, $DB, $verb)
	{
		//	...
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				return self::_Generate_MySQL($database, $table, $field, $config, $DB, $verb);

			case 'pgsql':
				return self::_Generate_PgSQL($database, $table, $field, $config, $DB, $verb);

			case 'sqlite':
				return self::_Generate_SQLite($database, $table, $field, $config, $DB, $verb);

			default:
				throw new \Exception("This product has not been support. ($prod)");
		};
	}

	/** Generate Alter MySQL.
	 *
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	 string		 $field
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $verb
	 * @return	 string
	 */
	static private function _Generate_MySQL($database, $table, $field, $config, $DB, $verb)
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
		$common = self::Field($config, $DB, $verb);
		$index  = self::Index($config, $DB, $verb);

		//	"PRIMARY KEY" can not been change.
		if( $verb === 'MODIFY' and strpos($index, 'PRIMARY KEY') === 0 ){
			$index = null;
		}

		//	...
		if( $verb === 'MODIFY' ){
			$index = null;
		}

		//	...
	//	$pkey  = ($config['key'] === 'pri') ? ", ADD PRIMARY KEY ({$field})": null;
		$extra = ($config['extra'] ?? null) ?   strtoupper($config['extra']): null;

		//	...
		return "ALTER TABLE $database.$table $verb $common $extra $first $after $index";
	}

	/** Generate Alter PostgreSQL.
	 *
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	 string		 $field
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $verb
	 * @return	 string
	 */
	static private function _Generate_PgSQL($database, $table, $field, $config, $DB, $verb)
	{
		//	...
		$database = $DB->Quote($database);
		$table    = $DB->Quote($table);
		$field    = $DB->Quote($field);

		//	...
		$common   = self::Field($config, $DB, $verb);

		//	...
		switch( $verb ){
			case 'ADD':
				break;

			case 'MODIFY':
				$verb = 'ALTER COLUMN';
				break;

			case 'RENAME':
				break;
		};

		/**
		 * Change:
		 * ALTER TABLE "t_testcase" ALTER COLUMN "text" INT
		 * ALTER TABLE テーブル名     ALTER COLUMN カラム名 TYPE データ型
		 * ALTER TABLE table_name ALTER COLUMN column_name TYPE numeric(10,2);
		 *
		 * Rename:
		 * ALTER TABLE table_name RENAME COLUMN old_name TO new_name;
		 */
		return "ALTER TABLE $table $verb $common";
	}

	/** Generate Alter SQLite.
	 *
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	 string		 $field
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $verb
	 * @return	 string
	 */
	static private function _Generate_SQLite($database, $table, $field, $config, $DB, $verb)
	{
		//	...
		$database = $DB->Quote($database);
		$table    = $DB->Quote($table);
		$field    = $DB->Quote($field);

		//	...
		$common   = self::Field($config, $DB, $verb);

		//	...
		switch( $verb ){
			case 'ADD':
				break;

			case 'MODIFY':
				throw new \Exception("SQLite can not change the definition of a column.");
				break;

			case 'RENAME':
				break;
		};

		//	...
		return "ALTER TABLE $table $verb $common";
	}

	/** Generate each field SQL.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $verb
	 * @throws	\Exception	 $e
	 * @return	 string		 $query
	 */
	static function Field($config, $DB, $verb)
	{
		switch( $prod = $DB->Config()['prod'] ){
			case 'mysql':
				return self::_Field_MySQL($config, $DB, $verb);

			case 'pgsql':
				return self::_Field_PgSQL($config, $DB, $verb);

			case 'sqlite':
				return self::_Field_SQLite($config, $DB, $verb);

			default:
				throw new \Exception("This product has not been support. ($prod)");
		};
	}

	/** Generate MySQL Field.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $verb
	 * @throws	\Exception	 $e
	 * @return	 string		 $query
	 */
	static private function _Field_MySQL($config, $DB, $verb)
	{
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
		$comment = $DB->PDO()->Quote($comment);
		$default = $default === null ? null: "DEFAULT ".$DB->PDO()->Quote($default);

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
						$join[] = $DB->PDO()->quote( trim($value) );
					}
					$length = join(',', $join);
				}
			break;

			case 'CHAR':
			case 'VARCHAR':
				if( $length ){
					$length = (int)$length;
				}else{
					throw new \Exception("Has not been set length. ($field, $type)");
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
					throw new \Exception("Has not been support this type. ($type)");
				}
			break;
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

	/** Generate PgSQL Field.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @throws	\Exception	 $e
	 * @return	 string		 $query
	 */
	static private function _Field_PgSQL($config, $DB, $verb)
	{
		//	...
		$field   = ifset($config['field']  );
		$type    = ifset($config['type']   );
		$length  = ifset($config['length'] );

		//	...
		$field   = $DB->Quote($field);
		$type    = strtoupper($type);
		$length  = (int)($length);

		//	...
		if( $length ){
			$type = "$type($length)";
		};

		/**
		 * @see https://qiita.com/seiro/items/ade4c220dfe4acb0ef4b
		 */
		if( $verb === 'MODIFY' ){
			$type = "TYPE $type";
		};

		//	...
		return "$field $type";
	}

	/** Generate SQLite Field.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @throws	\Exception	 $e
	 * @return	 string		 $query
	 */
	static private function _Field_SQLite($config, $DB, $verb)
	{
		//	...
		$field   = ifset($config['field']  );
		$type    = ifset($config['type']   );
		$length  = ifset($config['length'] );

		//	...
		if( $config['ai'] ?? null ){
			$type = 'ai';
		};

		//	...
		$field   = $DB->Quote($field);
		$type    = strtoupper($type);
		$length  = (int)($length);

		//	...
		if( $type === 'AI' ){
			$type   = 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL';
			$length = null;
		};

		//	...
		if( $config['created'] ?? null ){
			$type = "DATETIME DEFAULT CURRENT_TIMESTAMP";
		};

		//	...
		if( $length ){
			$type = "$type($length)";
		};

		//	...
		if( $verb === 'MODIFY' ){
			$type = "TYPE $type";
		};

		//	...
		return "$field $type";
	}

	/** Get column charset
	 *
	 * @param	 string		 $charset
	 * @param	 string		 $collate
	 * @return	 NULL|string $string
	 */
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

	/** Get index string.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $db
	 * @param	 string		 $verb
	 * @throws	\Exception
	 * @return	 NULL|string
	 */
	static function Index($config, $db, $verb)
	{
		//	...
		if( empty($config['key']) ){
			return null;
		};

		//	...
		if( empty($config['field']) ){
			throw new \Exception('Empty field name or index key type.');
		}

		//	...
		$field = $db->Quote($config['field']);

		//	...
		$key = Index::Type($config['key'], $config['type']);

		//	...
		if( $key === 'PRIMARY KEY' and $verb === 'ADD' ){
			$key = ", ADD PRIMARY KEY";
		};

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

			case 'float':
				$length = 0;
				break;

			default:
		}

		//	...
		if( $unsigned and $length ){
			$length--;
		}

		//	...
		return $length ?? null;
	}
}
