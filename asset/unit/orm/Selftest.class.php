<?php
/**
 * unit-orm:/Selftest.class.php
 *
 * @created   2018-06-21
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-06-21
 */
namespace OP\UNIT\ORM;

/** Selftest
 *
 * @created   2018-06-21
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Selftest
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Config
	 *
	 * @param	 string	 $file
	 * @return	 array	 $config
	 */
	static private function _Config($file)
	{
		//	...
		$config = include($file);

		//	...
		foreach( $config as $dsn => $databases ){
			//	...
			$dsn = parse_url($dsn);
			parse_str($dsn['query'], $temp);
			$dsn = array_merge($dsn, $temp);

			//	...
			\OP\UNIT\SELFTEST\Configer::DSN( $dsn['host'], $dsn['scheme'], $dsn['port']);
			\OP\UNIT\SELFTEST\Configer::User($dsn['user'], $dsn['pass']  , $dsn['charset'] ?? 'utf8');

			//	...
			foreach( $databases as $database => $tables ){
				//	...
				\OP\UNIT\SELFTEST\Configer::Database($database);

				//	...
				foreach( $tables as $table => $columns ){
					//	...
					\OP\UNIT\SELFTEST\Configer::Table($table);

					//	...
					foreach( $columns as $field => $column ){
						//	...
						foreach( ['field','type','comment'] as $key ){
							${$key} = $column[$key] ?? null;
						}

						//	...
						self::_length($column);

						//	...
						\OP\UNIT\SELFTEST\Configer::Column($field, $type, $comment, $column);

						//	...
						if( ($column['ai'] ?? false) ){
							\OP\UNIT\SELFTEST\Configer::Index($field, $field, $field, 'auto incrment');
						}
					}
				}
			}
		}

		//	...
		return \OP\UNIT\SELFTEST\Configer::Get();
	}

	/** Length
	 *
	 * @param	&array	 $column
	 */
	static private function _length(&$column)
	{
		//	...
		if( empty($column['values']) ){
			return;
		}

		//	...
		if( is_string($column['values']) ){
			return;
		}

		//	...
		$length = [];

		//	...
		foreach( $column['values'] as $index => $values ){
			//	...
			if( is_string($values) ){
				$length[] = $values;
				continue;
			}

			//	...
			if( is_string($values['value']) and strlen($values['value']) ){
				$length[] = $values['value'];
			}
		}

		//	...
		$column['length'] = join(',', $length);
	}

	/** Auto
	 *
	 * @param	 string	 $file
	 */
	static function Auto($file)
	{
		//	...
		if(!\Unit::Load('selftest') ){
			return;
		}

		//	...
		$config = self::_Config($file);

		//	Set configuration.
		\OP\UNIT\SELFTEST\Inspector::Auto( $config );

		//	Get result.
		$build  = \OP\UNIT\SELFTEST\Inspector::Build();
		$failed = \OP\UNIT\SELFTEST\Inspector::Failed();

		//	...
		while( $message = \OP\UNIT\SELFTEST\Inspector::Error() ){
			printf('<p class="testcase selftest bold error">%s</p>', $message);
		}

		//	...
		if( $failed !== false ){
			\OP\UNIT\SELFTEST\Inspector::Form();
		}

		//	...
		\OP\UNIT\SELFTEST\Inspector::Result();

		// ...
		if( ($_GET['debug'] ?? false) or \Notice::Has() ){
			\OP\UNIT\SELFTEST\Inspector::Debug();
		}
	}
}
