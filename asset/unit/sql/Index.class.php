<?php
/**
 * unit-sql:/Index.class.php
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2017-12-13
 */
namespace OP\UNIT\SQL;

/** Index
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Index
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Create index
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 array		 $config
	 * @return	 string
	 */
	static function Create($DB, $config)
	{
		//	...
		$database = $config['database'] ?? null;
		$table    = $config['table']    ?? null;
		$name     = $config['name']     ?? null;
		$type     = $config['type']     ?? null;
		$columns  = $config['column']   ?? $config['columns'] ?? null;
	//	$comment  = $config['comment']  ?? null;

		//	...
		$database = $DB->Quote($database);
		$table    = $DB->Quote($table);
		$name     = $DB->Quote($name);
		$type     = self::Type($type);

		//	...
		if( is_string($columns) ){
			$columns = explode(',', $columns);
		};

		//	...
		$join = [];
		foreach( $columns as $column ){
			$join[] = $DB->Quote($column);
		}
		$columns = join(',', $join);

		//	...
		return "ALTER TABLE $database.$table ADD $type $name ($columns)";
	}

	/** Drop index
	 *
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	 string		 $name
	 * @param	 string		 $type
	 * @param	\IF_DATABASE $DB
	 * @return	 string		 $sql
	 */
	static function Drop($database, $table, $name, $type, $db)
	{
		//	...
		$database = $db->Quote($database);
		$table    = $db->Quote($table);

		//	...
		switch( strtolower($type) ){
			case 'pri':
				$specify = 'PRIMARY KEY';
				break;
		}

		//	...
		return "ALTER TABLE $database.$table DROP $specify";
	}

	/** Get index type by filed type.
	 *
	 * @param  string $field_type
	 * @param  string $index_key_type
	 * @return string
	 */
	static function Type($index_key_type, $field_type=null)
	{
		//	...
		switch( $key = strtoupper($index_key_type) ){
			case 'AI':
			case 'PRI':
			case 'PKEY':
			case 'PRIMARY':
			case 'PRIMARY KEY':
				$key = 'PRIMARY KEY';
				break;

			case 'UNI':
			case 'UNIQUE':
				$key = 'UNIQUE';
				break;

			case 'MUL':
				switch( strtolower($field_type) ){
					case 'char':
					case 'varchar':
					case 'text':
						$key = 'FULLTEXT';
						break;
					default:
						$key = 'INDEX';
				}
				break;

			case 'INDEX':
			case 'SPATIAL':
			case 'FULLTEXT':
				break;

			default:
				throw new \Exception("Has not been support this key. ($key)");
		}

		//	...
		return $key;
	}
}

/*
 ALTER TABLE `test`.`t_test` ADD PRIMARY KEY(`ai`);
 ALTER TABLE `test`.`t_test` ADD UNIQUE(`id`);
 ALTER TABLE `test`.`t_test` ADD UNIQUE `unique` (`id`);
 */
