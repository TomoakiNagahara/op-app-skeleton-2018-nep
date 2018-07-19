<?php
/**
 * unit-orm:/Config.class.php
 *
 * @created   2018-02-03
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-02-03
 */
namespace OP\UNIT\ORM;

/** ORM
 *
 * @created   2018-02-03
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Config
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Calc input type from database record's type.
	 *
	 * @param	 array	 $column
	 * @return	 string	 $type
	 */
	static private function _Type($column)
	{
		//	...
		if( $column['key'] === 'pri' ){
			return 'hidden';
		}

		//	...
		switch( $column['type'] ){
			case 'set':
				$type = 'radio';
				break;

			case 'enum':
				$type = 'checkbox';
				break;

			case 'text':
				$type = 'textarea';
				break;

			default:
				$type = 'text';
		}

		//	...
		return $type;
	}

	/** Generate validation rule.
	 *
	 * @param	 array	 $column
	 * @return	 string	 $rule
	 */
	static private function _Rule( array $column )
	{
		//	...
		$rule = [];

		//	Required
		if(!$column['null'] and $column['extra'] !== 'auto_increment' ){
			//	...
			if( $column['type'] === 'timestamp' ){
				//	...
			}else{
				$rule[] = 'required';
			}
		}

		//	...
		switch( $type = $column['type'] ){
			case 'int':
				$rule[] = 'integer';
				break;

			case 'float':
				$rule[] = 'number';
				break;

			case 'char':
			case 'varchar':
				$rule[] = "long({$column['length']})";
				break;

			default:
		}

		//	...
		if( $column['unsigned '] ?? null ){
			$rule[] = 'positive';
		}

		//	...
		if( $column['collation'] ?? null ){
			if( strpos($column['collation'], 'ascii') !== false ){
				$rule[] = 'ascii';
			}
		}

		//	...
		return join(', ', $rule);
	}

	/** Generate form config.
	 *
	 * @param  string $database
	 * @param  string $table
	 * @param  array  $columns
	 * @return array  $config
	 */
	static function Form($database, $table, $columns, $record)
	{
		//	...
		$config = [];

		//	...
		foreach( $columns as $column ){
			//	...
			if(!$type = self::_Type($column) ){
				continue;
			}

			//	...
			$name = $column['field'];

			//	...
			if( $column['key'] === 'pri' ){
				$pkey = $name;
			}

			//	...
			$input = [];
			$input['name']  = $name;
			$input['type']  = $type;
			$input['value'] = $record[$name];
			$input['label'] = $type === 'hidden' ? '': $name;
			$input['rule']  = self::_Rule($column);
		//	$input['session'] = false;
			$config['input'][$name] = $input;
		}

		//	...
		$config['name'] = self::GetFormName($database, $table, $record[$pkey] ?? null);

		//	...
		return $config;
	}

	/** Generate form name.
	 *
	 * @param  string $database
	 * @param  string $table
	 * @param  string $pval
	 * @return string $hash
	 */
	static function GetFormName( string $database, string $table, string $pval )
	{
		return Hasha1($database.' '.$table.' '.$pval);
	}
}
