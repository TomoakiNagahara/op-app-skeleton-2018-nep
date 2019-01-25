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
		$prod    = $DB->Config()['prod'];
		$database= ifset($config['database']);
		$table   = ifset($config['table']   );
		$engine  = ifset($config['engine']  , 'InnoDB'            );
		$charset = ifset($config['charset'] , 'utf8mb4'           );
		$collate = ifset($config['collate'] , 'utf8mb4_general_ci');

		//	...
		if( isset($config['fields']) ){
			$fields = $config['fields'];
		}else if( isset($config['field']) ){
			$fields = $config['field'];
		}else if( isset($config['columns']) ){
			$fields = $config['columns'];
		}else if( isset($config['column']) ){
			$fields = $config['column'];
		}else{
			\Notice::Set("Has not been set field. ($database, $table)");
			return false;
		}

		//	...
		$col = $ind = [];
		foreach( $fields as $name => $field ){
			//	...
			$field['field'] = $name;
			$col[] = Column::Field($field, $DB, null);

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
		switch( $prod ){
			case 'mysql':
				//	...
				$table = "{$database}.{$table}";

				//	...
				$option = "ENGINE=$engine DEFAULT CHARSET=$charset COLLATE $collate";
				break;

			case 'pgsql':
				$option = null;
				break;

			default:
				$option = null;
		};

		//	...
		if( $config['if_not_exists'] ?? null ){
			$table = "IF NOT EXISTS {$table}";
		};

		//	...
		return "CREATE TABLE $table ($columns) $option";
	}

	/** Change table
	 *
	 */
	static function Change()
	{
		//	ALTER DATABASE {DB名} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
		//	ALTER TABLE テーブル名 MODIFY カラム名 値 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
	}

	/** Drop table
	 *
	 * @param	 array	 $config
	 * @return	 string	 $sql
	 */
	static function Drop($config)
	{
		//	...
		if(!$table = $config['table'] ?? null ){
			\Notice::Set("Has not been set table name.");
			return false;
		};

		//	...
		return "DROP TABLE {$table}";
	}
}
