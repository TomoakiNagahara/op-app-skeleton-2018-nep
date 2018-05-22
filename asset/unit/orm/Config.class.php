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
	static function _Type($column)
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
			$name = $column['field'];
			$type = self::_Type($column);

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
		//	$input['session'] = false;
			$config['input'][$name] = $input;
		}

		//	...
		$config['name'] = self::FormName($database, $table, $record[$pkey] ?? 0);

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
	static function FormName($database, $table, $pval)
	{
		return Hasha1($database.' '.$table.' '.$pval);
	}

	/** Generate validate configuration.
	 *
	 */
	static function Validate($struct)
	{
		//	...
		$validate = [];

		//	...
		foreach( $struct as $column ){
			//	...
			$join = [];

			//	...
			if(!$column['null'] and $column['extra'] !== 'auto_increment' ){
				$join[] = 'required';
			}

			//	...
			switch( $type = $column['type'] ){
				case 'int':
					$join[] = 'integer';
					break;

				case 'char':
				case 'varchar':
					$join[] = "long({$column['length']})";
					break;

				case 'timestamp':
					$join = [];
					break;

				default:
			}

			//	...
			$validate[$column['field']] = join(', ', $join);
		}

		//	...
		return $validate;
	}
}
