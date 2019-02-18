<?php
/**
 * unit-selftest:/Builder.class.php
 *
 * @created   2017-12-11
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2017-12-11
 */
namespace OP\UNIT\SELFTEST;

/** Builder
 *
 * @created   2017-12-11
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Builder
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Automatically.
	 *
	 * @param array $config
	 * @param array $result
	 * @param \OP\UNIT\DB $DB
	 */
	static function Auto($configs, $results, $DB)
	{
		//	...
		$config = $DB->Config();
		$dsn    = "{$config['prod']}://{$config['host']}:{$config['port']}";

		//	...
		if(!$config = ifset($configs[$dsn]) ){
			D("empty", $dsn, $configs);
			return;
		}

		//	...
		if(!$result = ifset($results[$dsn]) ){
			D("This DNS has not been set. ($dsn)");
			return;
		}

		//	...
		try {
			//	...
			self::Database($config, $result, $DB);
			self::Table   ($config, $result, $DB);
			self::Field   ($config, $result, $DB);
			self::Column  ($config, $result, $DB);
			self::Index   ($config, $result, $DB);

			//	...
			self::User( $configs[$dsn]['users'], $result['users'], $DB);
			self::Grant($configs[$dsn]['users'], $result['users'], $DB);
		} catch ( \Throwable $e ){
			\Notice::Set($e);
		}
	}

	/** Build database.
	 *
	 * @param   array      $config
	 * @param   array      $result
	 * @param  \OP\UNIT\DB $DB
	 * @throws \Exception
	 * @return  null
	 */
	static function Database($config, $result, $DB)
	{
		foreach( $result['databases'] as $database => $temp ){
			if( $temp['result'] ){
				continue;
			}

			//	...
			if( $collation = ifset($config['databases'][$database]['collation']) ){
				//	...
				if( empty($config['databases'][$database]['collate']) ){
					$config['databases'][$database]['collate'] = $collation;
				}

				//	...
				if( empty($config['databases'][$database]['charset']) ){
					list( $config['databases'][$database]['charset']) = explode('_', $collation);
				}
			}

			//	...
			$charset = ifset($config['databases'][$database]['charset']) ?? null;
			$collate = ifset($config['databases'][$database]['collate']) ?? null;

			//	...
			$conf = [];
			$conf['database'] = $database;
			$conf['charset']  = $charset;
			$conf['collate']  = $collate;
			$sql = \OP\UNIT\SQL\Database::Create($conf, $DB);
			if(!$DB->Query($sql) ){

				D($database, $config['databases'][$database]);

				throw new \Exception(\Notice::Get()['message']);
			}

			//	Overwrite result. All table build. (Is this neccessary?)
			/*
			foreach( $config['databases'][$database]['tables'] as $table => $conf ){
				$result['tables'][$database][$table]['result'] = false;
			}
			*/
		}
	}

	/** Build tabel.
	 *
	 * @param   array      $config
	 * @param   array      $result
	 * @param  \OP\UNIT\DB $DB
	 * @return  null
	 */
	static function Table($configs, $result, $DB)
	{
		//	...
		if( empty($result['tables']) ){
			//	Adjust table result.
			foreach( $configs['databases'] as $database_name => $database ){
				//	...
				foreach( $database['tables'] as $table_name => $table ){
					/*
					//	...
					if( $result['databases'][$database_name]['result'] ){
						continue;
					};
					*/

					//	...
					$result['tables'][$database_name][$table_name]['result'] = false;
				};
			};
		};

		//	...
		foreach( $result['tables'] as $database => $tables ){
			foreach( $tables as $table => $temp ){
				if( $temp['result'] ?? null ){
					continue;
				}

				//	...
				if(!$args = $configs['databases'][$database]['tables'][$table] ?? null ){
					continue;
				};

				//	...
				$args['database'] = $database;
				$args['table']    = $table;

				//	...
				if(!$sql = \OP\UNIT\SQL\Table::Create($args, $DB) ){
					throw new \Exception("Failed: $sql");
				}

				//	...
				if(!$io  = $DB->Query($sql, 'create') ){
					throw new \Exception("Failed: $io");
				}
			}
		}
	}

	/** Build new field.
	 *
	 * @param array $config
	 * @param array $result
	 * @param \OP\UNIT\DB $DB
	 */
	static function Field($configs, &$results, $_db)
	{
		//	...
		foreach( ifset($results['fields'], []) as $database => $tables ){
			//	...
			foreach( $tables as $table => $columns ){
				//	...
				$first = true;
				$after = null;

				//	...
				foreach( $columns as $field => $column ){
					//	...
					$conf = $configs['databases'][$database]['tables'][$table]['columns'][$field];

					//	...
					if( $first ){
						$first = false;
						$conf['first'] = true;
					}else{
						$conf['after'] = $after;
					}

					//	...
					$after = $field;

					//	Create new column.
					if(!$column['result'] ){
						//	...
						$sql = \OP\UNIT\SQL\Column::Create($database, $table, $field, $conf, $_db);

						//	...
						if(!$_db->Query($sql, 'alter') ){
							continue;
						}

						//	...
						if( $conf['extra'] !== 'auto_increment' ){
							continue;
						};

						//	Touch primary key index result.
						$results['indexes'][$database][$table][$field]['result'] = true;
					};
				};
			};
		};
	}

	/** Modify exist column.
	 *
	 * @param	 array			  $config
	 * @param	 array			  $result
	 * @param	\OP\UNIT\Database $DB
	 */
	static function Column($config, &$result, $_db)
	{
		//	...
		foreach( $result['columns'] ?? [] as $database => $tables ){
			//	...
			foreach( $tables as $table => $columns ){

				//	...
				foreach( $columns as $name => $column ){
					//	Change each column.
					foreach( $column as $field => $value ){
						//	...
						if( $value['result'] ){
							continue;
						}

						//	Change is modify.
						$conf= $config['databases'][$database]['tables'][$table]['columns'][$name];
						$sql = \OP\UNIT\SQL\Column::Change($database, $table, $name, $conf, $_db);
						$io  = $_db->Query($sql, 'alter');

						//	...
						if( false ){
							D($field, $io);
						};

						//	...
						break;
					}
				}
			}
		}
	}

	/** Build index.
	 *
	 * @param array $config
	 * @param array $result
	 * @param \OP\UNIT\DB $DB
	 */
	static function Index($_configs, &$_results, $DB)
	{
		//	...
		foreach( $_configs['databases']    ?? [] as $database_name => $database ){
			//	...
			foreach( $database['tables']   ?? [] as $table_name => $table ){
				//	...
				foreach( $table['indexes'] ?? [] as $index_name => $config ){
					//	...
					if( $_results['indexes'][$database_name][$table_name][$index_name]['result'] ?? null ){
						continue;
					}

					//	...
					$config['database'] = $database_name;
					$config['table']    = $table_name;
					$sql = \OP\UNIT\SQL\Index::Create($DB, $config);
					$DB->Query($sql, 'alter');
				};
			};
		};
	}

	/** Build user.
	 *
	 * @param array $configs
	 * @param array $results
	 * @param \OP\UNIT\DB $DB
	 */
	static function User($configs, $results, $DB)
	{
		//	...
		foreach( $results as $user => $result ){
			//	...
			$host = $configs[$user]['host'];

			//	...
			$config = [];
			$config['host'] = $host;
			$config['user'] = $user;

			//	...
			if(!ifset($result['exist']) ){
				//	...
				if(!$qu = \OP\UNIT\SQL\User::Create($config, $DB) ){
					throw new \Exception("Failed: $qu");
				};

				//	...
				if(!$io = $DB->Query($qu) ){
					throw new \Exception("Failed: $qu");
				};
			};

			//	...
			if(!ifset($result['password']) ){
				//	...
				$config = [];
				$config['host'] = $host;
				$config['user'] = $user;
				$config['password'] = $configs[$user]['password'];

				//	...
				if(!$qu = \OP\UNIT\SQL\User::Password($config, $DB) ){
					throw new \Exception("Failed: $qu");
				};

				//	...
				if(!$io = $DB->Query($qu) ){
					throw new \Exception("Failed: $qu ($io)");
				};
			};

			//	...
			if(!ifset($result['privilege']) ){
				//	...
				$config['database']  = '*';
				$config['table']     = '*';
				$config['privileges']= 'USAGE';

				//	USAGE
				if(!$qu = \OP\UNIT\SQL\Grant::Privilege($config, $DB) ){
					throw new \Exception("Failed: $qu");
				};

				//	...
				if(!$io = $DB->Query($qu) ){
					throw new \Exception("Failed: $qu ($io)");
				};
			};

			/**
			 * CREATE USER 'user_name'@'localhost' IDENTIFIED WITH mysql_native_password;
			 * GRANT USAGE ON *.* TO 'user_name'@'localhost';
			 * SET PASSWORD FOR 'user_name'@'localhost' = PASSWORD('***');
			 */
		}
	}

	/** Add missing grant.
	 *
	 * @param	 array			 $result
	 * @param	\IF_DATABASE	 $DB
	 */
	static function Grant($configs, $results, $DB)
	{
		//	...
		foreach( $results as $user => $result ){
			//	...
			if( $result['privilege'] ?? null ){
				continue;
			};

			//	...
			$host = $configs[$user]['host'];

			//	...
			foreach( $configs[$user]['privilege'] as $database => $tables ){

				//	...
				$sql        = \OP\UNIT\SQL\Show::Table($DB, $database);
				$table_list = $DB->Query($sql);

				//	...
				foreach( $tables as $table_names => $privileges ){

					//	...
					foreach( explode(',', str_replace(' ', '', $table_names )) as $table_name ){

						//	...
						if( array_search($table_name, $table_list) === false ){
							continue;
						};

						//	...
						foreach( $privileges as $privilege => $column ){
							//	...
							$config = [];
							$config['host']      = $host;
							$config['user']      = $user;
							$config['database']  = $database;
							$config['table']     = $table_name;
							$config['privileges']= $privilege;
							$config['field']     = $column;

							//	...
							$qu = \OP\UNIT\SQL\Grant::Privilege($config, $DB);
							$DB->Query($qu);
						};
					}; // table names
				}; // privileges
			}; // tables
		}; // users
	}
}
