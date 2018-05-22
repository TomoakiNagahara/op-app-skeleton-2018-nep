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

	static function Create($DB, $config)
	{
		//	...
		$database = ifset($config['database']);
		$table    = ifset($config['table']   );
		$name     = ifset($config['name']    );
		$column   = ifset($config['column']  );

		//	...
		if( $column ){
			$join[] = $column;
		}

		//	...
		$database = $DB->Quote($database);
		$table    = $DB->Quote($table);
		$name     = $DB->Quote($name);
		$type     = self::Type();

		//	...
		foreach( ifset($config['columns'], []) as $temp ){
			$join[] = $temp;
		}

		//	...
		$columns = join(', ', $join);

		//	...
		return "ALTER TABLE $database.$table ADD $type $name ($columns)";
	}

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
	 * @param  string $type
	 * @param  string $key
	 * @return string
	 */
	static function Type($type, $key)
	{
		switch( $key = strtoupper($key) ){
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
				switch( strtolower($type) ){
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

		return $key;
	}
}

/*
 ALTER TABLE `test`.`t_test` ADD PRIMARY KEY(`ai`);
 ALTER TABLE `test`.`t_test` ADD UNIQUE(`id`);
 ALTER TABLE `test`.`t_test` ADD UNIQUE `unique` (`id`);
 */
