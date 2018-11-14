<?php
/**
 * unit-sql:/Table.class.php
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\SQL;

/** Table
 *
 * @created   2017-12-13
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Table
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Create table
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 boolean|string
	 */
	static function Create($config, $DB)
	{
		//	...
		$database= ifset($config['database']);
		$table   = ifset($config['table']   );
		$engine  = ifset($config['engine']  , 'InnoDB'            );
		$charset = ifset($config['charset'] , 'utf8mb4'           );
		$collate = ifset($config['collate'] , 'utf8mb4_general_ci');

		//	...
		if( isset($config['fields']) ){
			$fields = $config['fields'];
		}else if( isset($config['columns']) ){
			$fields = $config['columns'];
		}else{
			\Notice::Set("Has not been set field. ($database, $table)");
			return false;
		}

		//	...
		$col = $ind = [];
		foreach( $fields as $name => $field ){
			//	...
			$field['field'] = $name;
			$col[] = Column::Field($field, $DB);

			//	...
			if( isset($field['key']) /* or isset($field['index']) */ ){
				$ind[] = Column::Index($field, $DB);
			}
		}
		$columns = join(', ', array_merge($col, $ind));

		//	...
		$database = $DB->Quote($database);
		$table    = $DB->Quote($table);
		$engine   = $DB->Quote($engine);
		$charset  = $DB->Quote($charset);
		$collate  = $DB->Quote($collate);

		//	...
		return "CREATE TABLE $database.$table ($columns) ENGINE=$engine DEFAULT CHARSET=$charset COLLATE $collate";
	}

	/** Change table
	 *
	 */
	static function Change()
	{
		//	ALTER DATABASE {DB名} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
		//	ALTER TABLE テーブル名 MODIFY カラム名 値 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
	}
}
