<?php
/**
 * unit-selftest:/Inspector.class.php
 *
 * @created   2017-12-09
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2017-12-09
 */
namespace OP\UNIT\SELFTEST;

/** Inspector
 *
 * @created   2017-12-09
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Inspector
{
	/** trait
	 *
	 */
	use \OP_CORE, \OP_SESSION;

	/** Build
	 *
	 * @var boolean
	 */
	static private $_build;

	/** Config
	 *
	 * @var boolean
	 */
	static private $_config;

	/** Store error messages.
	 *
	 * @var array
	 */
	static private $_errors = [];

	/** Failure
	 *
	 * @var boolean
	 */
	static private $_failure;

	/** Result
	 *
	 * @var array
	 */
	static private $_result;

	/** Get configuration array.
	 *
	 */
	static private function _Config($args)
	{
		//	Include configuration file.
		if( is_string($args) ){
			//	...
			if(!file_exists($args) ){
				throw new \Exception("Does not exists this file name. ($args)");
			};

			//	...
			$config = include($args);

			//	...
			if(!is_array($config) ){
				throw new \Exception("Empty return value. ($args)");
			};
		}else{
			$config = $args;
		}

		//	Adjust structure configuration.
		foreach( $config ?? [] as $dsn => &$structure ){
			//	...
			if(!preg_match('|([a-z]+)://([-_a-z0-9\.]+):([0-9]+)??(.+)?|', $dsn)){
				self::Error("The DSN format is wrong. ($dsn)");
				return false;
			}

			//	...
			if( empty($structure['databases']) ){
				self::Error('The "databases" key was empty in configuration array.');
				return false;
			}

			//	Adjust structure configuration.
			foreach( $structure['databases']   as $database_name => &$database ){

				//	...
				if( empty($database['tables']) ){
					self::Error('The "tables" key was empty in configuration array.');
					return false;
				}

				//	Adjust tables configuration.
				foreach( $database['tables']   as $table_name    => &$table    ){

					//	...
					if( empty($table['columns']) ){
						self::Error('The "columns" key was empty in configuration array.');
						return false;
					}

					//	Adjust columns configuration.
					foreach( $table['columns'] as $column_name   => &$define   ){
						//	...
						if( isset($define['name']) ){
							$column_name = $define['name'];
							unset($define['name']);
						}

						//	...
						$define['field'] = $column_name;

						//	...
						switch( $type = $define['type'] ?? null ){
							case null:
								D("type is null. ($database_name, $table_name, $column_name, $type)");
								break;

							case 'text':
								unset($define['length']);
								break;

							default:
						}

						//	$define['index'] -- copy --> $define['key']
						if( $key = isset($define['index']) ? $define['index']: null ){
							unset($define['index']);
							$define['key'] = $key;
						}

						//	...
						if( isset( $define['key']) ){
							switch( $define['key'] ){
								case 'pri':
								case 'pkey':
								case 'primary':
									$define['key'] = 'pri';
									break;

								case 'unique':
									$define['key'] = 'uni';
									break;

								default:
									$define['key'] = 'mul';
							}
						}
					}

					//	...
					if( $column_name = ifset($table['ai']) ){
						$table['columns'][$column_name]['extra'] = 'auto_increment';
						$table['columns'][$column_name]['key']   = 'pri';
					}
				}
			}
		}

		//	...
		self::$_config = $config;

		//	...
		return $config;
	}

	/** Get DSN
	 *
	 */
	static function _DSN($config)
	{
		return "{$config['prod']}://{$config['host']}:{$config['port']}";
	}

	/** Automatically do inspection and building.
	 *
	 * @param	 array		 $args
	 * @param	\IF_DATABASE $DB
	 */
	static function Auto($args, $DB=null)
	{
		//	...
		if(!$config = self::_Config($args) ){
			return;
		}

		//	...
		if( $DB === null ){
			//	...
			if(!$DB = \Unit::Instantiate('Database') ){
				self::$_failure = true;
				return !self::Failed();
			};

			//	...
			if(!empty($_POST) ){
				$conf = [];
				foreach( ['prod','host','port','user','password','charset',] as $key ){
					$conf[$key] = $_POST[$key] ?? null;
				};

				//	...
				$DB->Connect($conf);
			};

			//	...
			if(!$DB->isConnect() ){
				self::Form();
				self::$_failure = true;
				return !self::Failed();
			};
		};

		//	...
		self::Inspection($config, $DB);

		//	Check build value.
		$build = [];
		$build['request'] = $_POST['build'] ?? null;
		$build['session'] = self::Session('build');
		$build['result']  = $build['request'] === $build['session'];

		//	Change build value.
		self::Session('build', Hasha1(microtime()));

		//	...
		if( self::$_failure and $build['result'] ){
			//	...
			Builder::Auto($config, self::$_result, $DB);

			//	...
			self::$_build   = true;
			self::$_failure = false;
			self::$_result  = [];

			//	...
			self::Inspection($config, $DB);
		}

		//	...
		if( self::$_failure === null ){
			self::$_failure  =  false;
		}

		//	...
		if( self::$_failure ){
			self::Form();
		};

		//	...
		return !self::Failed();
	}

	/** Inspection.
	 *
	 * @param   array      $args
	 * @param  \OP\UNIT\DB $DB
	 */
	static function Inspection($config, $DB)
	{
		//	...
		if(!\Unit::Load('SQL') ){
			return false;
		}

		//	...
		$dsn = self::_DSN( $DB->Config() );

		//	...
		if(!isset($config[$dsn]) ){
			self::Error("Unmatch DSN. ($dsn)");
			return false;
		}

		//	...
		self::Users($config[$dsn], $DB);

		//	...
		self::Structures($config[$dsn], $DB);
	}

	/** Check connection of users.
	 *
	 * @param   array      $config
	 * @param  \OP\UNIT\DB $DB
	 */
	static function Users($configs, $DB)
	{
		//	...
		$host = $DB->Config()['host'];
		$dsn  = self::_DSN($DB->Config());
		$lists = [];

		//	...
		if(!$sql  = \OP\UNIT\SQL\Show::User([], $DB) ){
			return;
		}

		//	...
		foreach( $DB->Query($sql, 'select') as $record ){
			$host = $record['host'];
			$user = $record['user'];
			$lists["{$user}@{$host}"] = $record;
		}

		//	...
		foreach( $configs['users'] as $user_name => $user ){
			//	...
			$key = $user_name.'@'.$host;

			//	...
			$result = &self::$_result[$dsn]['users'][$user_name];

			//	Check user exist.
			if( $result['exist'] = isset($lists[$key]) ){
				//	Generate mysql hashed password.
				$sql = \OP\UNIT\SQL\Select::Password($user['password'], $DB);
				$password = $DB->Query($sql, 'password');

				//	Check password match.
				if(!$result['password'] = ($password === ($lists[$key]['password'] ?? null)) ){
					$result['modify']   = $user['password'];
				}
			}

			//	Check passowrd.
			if(!$result['result'] = ( $result['exist'] and $result['password'] ) ){
				self::$_failure = true;
			}

			//	Privilege
			if(!self::Privilege($DB, $host, $user_name, $configs, $result) ){
				self::$_failure = true;
				$result['result'] = false;
			}
		}
	}

	/** Check privilege.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $host
	 * @param	 string		 $user
	 * @param	 array		 $configs
	 * @param	 array		 $result
	 */
	static function Privilege($DB, $host, $user, $configs, &$result)
	{
		//	...
		$success = true;

		//	...
		if( $result['exist'] === false ){
			return;
		};

		//	...
		$sql  = \OP\UNIT\SQL\Show::Grant($DB, $host, $user);
		$real = $DB->Query($sql, 'show');

		//	...
		foreach( $real as $database => $tables ){
			//	...
			foreach( $tables as $table => $privileges ){
				//	...
				$config = [];

				//	...
				if( $database === '*' ){
					D("database={$database}");
				}else{
					//	...
					foreach( $configs['users'][$user]['privilege'][$database] as $keys => $vals ){
						//	...
						if( strpos($keys, ',') !== false ){
							//	...
							foreach( explode(',', str_replace(' ', '', $keys)) as $key ){
								$config[$key] = $vals;
							};
						}else{
							$config[$keys] = $vals;
						};
					};
				};

				//	...
				foreach( $privileges as $privilege ){
					//	...
				//	$success = false;
				//	$result['privilege'] = false;
					$result['privileges'][$database][$table][] = $privilege;
				};
			};
		};

		//	...
		D('config', $config);
		D($configs['users'][$user]['privilege']);
		D($result);

		//	...
		return $success;
	}

	/** Inspect structures.
	 *
	 * @param  array      $config
	 * @param \OP\UNIT\DB $DB
	 */
	static function Structures($config, $DB)
	{
		//	...
		$dsn  = self::_DSN($DB->Config());

		//	...
		self::Databases($DB, $config['databases'], self::$_result[$dsn]);
	}

	/** Inspect databases.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 array		 $databases
	 * @param	&array		 $_result
	 */
	static function Databases($DB, $databases, &$_result)
	{
		//	...
		$sql  = \OP\UNIT\SQL\Show::Database($DB);

		//	...
		if(!$list = $DB->Query($sql) ){
			return;
		}

		//	...
		foreach( $databases as $database_name => $database ){
			//	...
			$result = (array_search($database_name, $list) === false ? false: true);

			//	...
			$_result['databases'][$database_name]['result'] = $result;

			//	...
			if(!$result ){
				self::$_failure = true;
				continue;
			}

			//	...
			if( isset($database['name']) ){
				$database_name = $database['name'];
			}

			//	...
			if( empty($database_name) ){
				self::Error("Has not been set database name in the configuration.");
				return;
			}

			//	...
			self::tables($DB, $database_name, $database['tables'], $_result);
		}
	}

	/** Inspect each table.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	&array		 $_result
	 * @return	 boolean	 $result
	 */
	static function Tables($DB, $database, $tables, &$_result)
	{
		//	...
		$sql  = \OP\UNIT\SQL\Show::Table($DB, $database);
		$list = $DB->Query($sql);

		//	...
		foreach( $tables as $table_name => $table ){
			//	...
			if( isset($table['name']) ){
				$table_name = $table['name'];
			}

			//	...
			if( empty($table_name) ){
				self::Error("Has not been set table name in the configuration.");
				return;
			}

			//	...
			$io = array_search($table_name, $list) === false ? false: true;
			$_result['tables'][$database][$table_name]['result'] = $io;
			if(!$io ){
				self::$_failure = true;
				D($io);
				continue;
			}

			//	...
			self::Fields( $DB, $database, $table_name, ($table['columns'] ?? []), $_result);
			self::Indexes($DB, $database, $table_name, ($table['indexes'] ?? []), $_result);
		}

		//	...
		return $_result['tables'][$database][$table_name]['result'];
	}

	/** Inspect each fields.
	 *
	 * @param  \OP\UNIT\DB $DB
	 * @param   string     $database
	 * @param   string     $table
	 * @param   array      $columns
	 * @param  &array      $_result
	 * @return  boolean    $result
	 */
	static function Fields($DB, $database, $table, $columns, &$_result)
	{
		//	Get fields list.
		$sql  = \OP\UNIT\SQL\Show::Column($DB, $database, $table);
		$list = $DB->Query($sql, 'show');

		//	Each fields.
		foreach( $columns as $name => $details ){

			//	If field exist.
			$io = isset($list[$name]) ? true: false;
			$_result['fields'][$database][$table][$name]['result'] = $io;

			//	If not exist.
			if(!$io ){
				self::$_failure = true;
				continue;
			}

			//	Field is exist.
			self::Columns($DB, $database, $table, $name, $details, $list[$name], $_result);
		}

		//	...
		return $_result['fields'][$database][$table][$name]['result'];
	}

	/** Inspect each columns.
	 *
	 * @param  \OP\UNIT\DB $DB
	 * @param   string     $database
	 * @param   string     $table
	 * @param   string     $field
	 * @param   array      $column
	 * @param   array      $fact
	 * @param  &array      $_result
	 * @return  boolean    $result
	 */
	static function Columns($DB, $database, $table, $field, $column, $fact, &$_result)
	{
		//	...
		$success = true;

		//	...
		foreach( ['type','length','unsigned','null','default','extra',/*'key','privileges',*/'comment','collation'] as $key ){
			//	...
			$io = true;

			//	...
			switch( $key ){
				case 'unsigned':
					if( isset($fact[$key]) or isset($column[$key]) ){
						$io = (ifset($column[$key]) ? true: false) === (ifset($fact[$key])   ? true: false) ? true: false;
					}else{
						continue;
					}
					break;

				//	...
				case 'null':
					//	...
					if( isset($column[$key]) ){
						$io = ($column[$key] === $fact[$key]) ? true: false;
					}else{
						$io = $fact[$key] ? true: false;
					};
					break;

				case 'extra':
					$io = ifset($column[$key]) == ifset($fact[$key]) ? true: false;
					break;

				//	...
				case 'collation':
					if( ifset($column[$key]) ){
						$io = ifset($column[$key]) === ifset($fact[$key]) ? true: false;
					}else{
						$io = true;
					}
					break;

				//	...
				case 'default':
					switch( $column['type'] ){
						case 'int':
							if( $column['default'] !== null ){
								$column['default'] = (string)$column['default'];
							}
						break;
					}
					$io = ifset($column[$key]) === ifset($fact[$key]) ? true: false;
					break;

				//	...
				case 'length':
					switch( $column['type'] ){
						case 'float':
							continue 2;

						case 'set':
						case 'enum':
							$join = [];
							foreach( explode(',', $fact['length']) as $temp ){
								$join[] = trim($temp, "'");
							}
							$fact['length'] = join(',', $join);
						break;
					}
					$io = ifset($column[$key]) === ifset($fact[$key]) ? true: false;
					break;

				default:
					$io = ifset($column[$key]) === ifset($fact[$key]) ? true: false;
			}

			//	...
			$_result['columns'][$database][$table][$field][$key]['result'] = $io;

			//	...
			if(!$io ){
				$success = false;
				self::$_failure = true;
				$_result['columns'][$database][$table][$field][$key]['current'] = ifset($fact[$key]);
				$_result['columns'][$database][$table][$field][$key]['modify']  = ifset($column[$key]);
			}
		}

		//	...
		return $success;
	}

	/** Inspect index each table.
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $database
	 * @param	 string		 $table
	 * @param	 array		 $indexes
	 * @param	&array		 $_result
	 * @return	 boolean	 $result
	 */
	static function Indexes($DB, $database, $table, $indexes, &$_result)
	{
		//	...
		$sql  = \OP\UNIT\SQL\Show::Index($DB, $database, $table);
		$real = $DB->Query($sql);

		//	...
		foreach( $indexes as $index_name => $index ){
			//	Each index.
			$io = isset($real[$index_name]) ? true: false;
			$_result['indexes'][$database][$table][$index_name]['result'] = $io;
			if( false ){
				D($index);
			};
		};
	}

	/** Display default form.
	 *
	 */
	static function Form()
	{
		//	...
		$build = self::Session('build');

		//	...
		\OP\UNIT\WebPack::JS( __DIR__.'/form');
		\OP\UNIT\WebPack::Css(__DIR__.'/form');
		\App::Template(__DIR__.'/form.phtml', ['build'=>$build]);
	}

	/** Return one stacked error.
	 *
	 * <pre>
	 * # How to use
	 * ```
	 * while( $error = \OP\UNIT\SELFTEST\Inspector::Error() ){
	 *   D($error);
	 * }
	 * ```
	 *
	 * </pre>
	 *
	 * @param	 string		 $message
	 */
	static function Error($message=null)
	{
		if( $message ){
			self::$_errors[] = $message;
		}else{
			return array_shift(self::$_errors);
		}
	}

	/** Get is build.
	 *
	 * @return boolean
	 */
	static function Build()
	{
		return self::$_build;
	}

	/** Get Configuration.
	 *
	 * @return array
	 */
	static function Config()
	{
		return self::$_config;
	}

	/** Get is failed.
	 *
	 * @return boolean
	 */
	static function Failed()
	{
		return self::$_failure;
	}

	/** Get inspection result.
	 *
	 * @return array
	 */
	static function Result()
	{
		//	...
		Json(self::$_result, '#OP_SELFTEST');

		//	...
		\App::WebPack(__DIR__.'/result.js');
		\App::WebPack(__DIR__.'/result.css');
	}

	static function Help()
	{

	}

	/** For developers
	 *
	 */
	static function Debug()
	{
		D(self::$_result);
	}
}
