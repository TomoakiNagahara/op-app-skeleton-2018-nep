<?php
/**
 * unit-sql:/Alter.class.php
 *
 * @created   2019-01-18
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\SQL;

/** Alter
 *
 * @created   2019-01-18
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Alter
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Generate table name.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static private function _Table($config, $DB)
	{
		//	...
		if( isset($config['table']) ){
			$table_name = $DB->Quote($config['table']);
		};

		//	...
		if( isset($config['database']) ){
			$table_name = $DB->Quote($config['database']) . ".{$table_name}";
		};

		//	...
		return $table_name;
	}

	/** Index
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static function Index($config, $DB)
	{
		//	...
		$verb = $config['verb'] ?? 'ADD';

		//	...
		$table_name = self::_Table($config, $DB);

		//	...
		$key_type = $config['type'] ?? null;
		$key_name = $config['name'] ?? null;

		//	...
		if( $key_type === 'pkey' ){
			$key_type = 'PRIMARY KEY';
		};

		//	...
		if( $config['column'] ?? null ){
			//	...
			if( is_string($config['column']) ){
				$config['column'] = explode(',', $config['column']);
			};

			//	...
			$join = [];
			foreach( $config['column'] as $column ){
				$join[] = $DB->Quote(trim($column));
			};
			$column = '('.join(',', $join).')';
		};

		//	ALTER TABLE table_name ADD  key_type key_name(column_name[, column_name]);
		//	ALTER TABLE table_name DROP key_type key_name;
		return "ALTER TABLE {$table_name} {$verb} {$key_type} {$key_name}{$column}";
	}

	/** Auto increment.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string
	 */
	static function AutoIncrement($config, $DB)
	{
		//	...
		$table_name = self::_Table($config, $DB);

		//	...
		$field_name = $config['column'] ?? $config['field'] ?? null;

		//	...
		if( $field_name ){
			$field_name = $DB->Quote($field_name);
		}

		//	...
		return "ALTER TABLE {$table_name} MODIFY {$field_name} INT AUTO_INCREMENT";
	}
}
