<?php
/**
 * unit-database:/Database.class.php
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-25
 */
namespace OP\UNIT;

/** Database
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Database implements \IF_DATABASE
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Connection configuration.
	 *
	 * @var array
	 */
	private $_config = [];

	/** Stack past queries.
	 *
	 * @var array
	 */
	private $_queries = [];

	/** PHP Data Objects.
	 *
	 * @var \PDO
	 */
	private $_PDO;

	/** SQL generator.
	 *
	 * @var \OP\UNIT\SQL
	 */
	private $_SQL;

	/** Construct
	 *
	 */
	function __construct()
	{
		$this->_SQL = \Unit::Instance('SQL');
	}

	/** Generate PDO options.
	 *
	 * @return	 array	 $options
	 */
	private function _Options()
	{
		//	...
		$options = [];

		//	...
		switch( strtolower($this->_config['prod']) ){
			case 'mysql':
				//	...
				if(!defined('\PDO::MYSQL_ATTR_INIT_COMMAND') ){
					throw new \Exception("Please install MySQL driver for PHP.");
				}

				//	Character set. (指定字符代码, 指定字符代碼)
				$options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES ".$this->_config['charset'];

				//	Multi statement. (多个指令, 多個指令)
				$options[\PDO::MYSQL_ATTR_MULTI_STATEMENTS] = false;

				//	Persistent connect. (持续连接, 持續連接)
				$options[\PDO::ATTR_PERSISTENT] = false;
			break;
		}

		//	...
		return $options;
	}

	/** If is connect.
	 *
	 * @return	 boolean
	 */
	function isConnect()
	{
		return $this->_PDO ? true: false;
	}

	/** Return instantiated PDO instance. (So-called singleton)
	 *
	 * @return \PDO
	 */
	function PDO()
	{
		return $this->_PDO;
	}

	/** Return connection configuration.
	 *
	 * @see		\IF_DATABASE::Config()
	 * @return	 array		 $config
	 */
	function Config()
	{
		return $this->_config;
	}

	/** Connect database server.
	 *
	 * <pre>
	 * //  Configuration.
	 * $config = [];
	 * $conifg['prod']     = 'mysql';
	 * $conifg['host']     = 'localhost';
	 * $conifg['port']     = '3306';
	 * $conifg['user']     = 'username';
	 * $conifg['password'] = 'password';
	 * $conifg['charset']  = 'utf8';
	 *
	 * //	Execute.
	 * $io = $db->Connect($config);
	 * </pre>
	 *
	 * @param	 array		 $config
	 * @return	 boolean	 $io
	 */
	function Connect($config)
	{
		//	...
		if( empty($config['prod']) ){
			//	...
			if( isset($config['driver']) ){
				$config['prod'] = $config['driver'];
			}
			//	...
			if( isset($config['scheme']) ){
				$config['prod'] = $config['scheme'];
			}
		}

		//	...
		if( empty($config['password']) and isset($config['pass']) ){
			$config['password'] = $config['pass'];
		}

		//	...
		if( empty($config['charset']) ){
			$config['charset'] = 'utf8';
		}

		//	...
		$prod = $host = $user = $password = $database = null;
		foreach( ['prod','host','port','user','password','database','charset'] as $key ){
			$this->_config[$key] = ${$key} = ifset($config[$key]);
		}

		//	...
		foreach( ['prod','host','user','password'] as $key ){
			if( empty(${$key}) ){
				\Notice::Set("This value has not been set. ($key)");
				return false;
			}
		}

		//	Data Source Name
		$dsn = "{$prod}:host={$host}";

		//	Database
		if( $database ){
			$dsn .= ";dbname={$database}";
		}

		//	...
		try{
			//	...
			$options = $this->_Options();

			//	...
			$this->_queries[] = $dsn;
			$this->_PDO = new \PDO($dsn, $user, $password, $options);
		}catch( \Throwable $e ){
			\Notice::Set($e->getMessage() . " ($dsn, $user, $password)");
		}

		//	...
		return $this->_PDO ? true: false;
	}

	/** Set/Get last time used database name.
	 *
	 * @param  string $database
	 * @return string $database
	 */
	function Database(string $database=null)
	{
		//	...
		if( $database ){
			//	...
			$this->_config['database'] = $database;

			//	...
			$database = $this->Quote($database);

			//	...
			$this->Query("use $database ", 'not');
		}

		//	...
		return $this->_config['database'];
	}

	/** Do SQL.
	 *
	 * @param	 array		 $config
	 * @param	 string		 $function
	 * @return	 mixed		 $result
	 */
	function _SQL($config, $function)
	{
		//	...
		if(!$this->_SQL ){
			return false;
		}

		//	...
		$query = $this->_SQL->{$function}($config, $this);

		//	...
		return $this->Query($query, $function);
	}

	/** Count number of record at conditions.
	 *
	 * @see		\IF_DATABASE::Count()
	 * @param	 array		 $config
	 * @return	 integer	 $count
	 */
	function Count($config)
	{
		$count = $this->_SQL($config, __FUNCTION__);
		return empty($count) ? 0: (int)$count;
	}

	/** Select record at conditions.
	 *
	 * <pre>
	 * //	Configuration.
	 * $config = [];
	 * $config['table'] = 't_table';
	 * $config['limit'] = 1;
	 * $config['where']['value'] = $value;
	 *
	 * //	Execute.
	 * $record = $db->Select($config);
	 * </pre>
	 *
	 * @see		\IF_DATABASE::Select()
	 * @param	 array		 $config
	 * @return	 array		 $record
	 */
	function Select($config)
	{
		return $this->_SQL($config, __FUNCTION__);
	}

	/** Insert new record.
	 *
	 * <pre>
	 * //	Configuration.
	 * $config = [];
	 * $config['table'] = 't_table';
	 * $config['set']['value'] = $value;
	 *
	 * //	Execute.
	 * $new_id = $db->Insert($config);
	 * </pre>
	 *
	 * @see		\IF_DATABASE::Insert()
	 * @param	 array		 $config
	 * @return	 integer	 $new_id
	 */
	function Insert($config)
	{
		return $this->_SQL($config, __FUNCTION__);
	}

	/** Update record at conditions.
	 *
	 * <pre>
	 * //	Configuration.
	 * $config = [];
	 * $config['table'] = 't_table';
	 * $config['limit'] = 1;
	 * $config['where']['id']  = $id;
	 * $config['set']['value'] = $value;
	 *
	 * //	Execute.
	 * $record = $db->Update($config);
	 * </pre>
	 *
	 * @see		\IF_DATABASE::Update()
	 * @param	 array		 $config
	 * @return	 integer	 $number
	 */
	function Update($config)
	{
		return $this->_SQL($config, __FUNCTION__);
	}

	/** Delete record at conditions.
	 *
	 * <pre>
	 * //	Configuration.
	 * $config = [];
	 * $config['table'] = 't_table';
	 * $config['limit'] = 1;
	 * $config['where']['id']  = $id;
	 *
	 * //	Execute.
	 * $record = $db->Delete($config);
	 * </pre>
	 *
	 * @see		\IF_DATABASE::Delete()
	 * @param	 array		 $config
	 * @return	 integer	 $number
	 */
	function Delete($config)
	{
		return $this->_SQL($config, __FUNCTION__);
	}

	/** Get database or table or user.
	 *
	 * @param	 array	 $config
	 * @return	 array	 $array
	 */
	function Show($config)
	{
		//	Generate SQL.
		$sql = $this->_SQL->Show($config, $this);

		//	Execute SQL.
		return $this->SQL($sql, 'show');
	}

	/** Get field name of primary key.
	 *
	 * @param	 string	 $database
	 * @param	 string	 $table
	 * @return	 string	 $pkey
	 */
	function PKey($database, $table)
	{
		$database = $this->Quote($database);
		$table    = $this->Quote($table);
		return $this->Query("SHOW INDEX FROM {$database}.{$table}", 'show')['PRIMARY'][1]['Column_name'] ?? null;
	}

	/** Do QQL.
	 *
	 * @see		\IF_DATABASE::Quick()
	 * @param	 string		 $qql
	 * @param	 array		 $options
	 * @return	 array		 $record
	 */
	function Quick($qql, $options=[])
	{
		include_once(__DIR__.'/QQL.class.php');
		return Database\QQL::Execute($qql, $options, $this);
	}

	/** Do Quote by each product.
	 *
	 * @see		\IF_DATABASE::Quote()
	 * @param	 string		$value
	 * @return	 string		$value
	 */
	function Quote($value)
	{
		//	...
		switch( $this->_config['prod'] ){
			case 'mysql':
				$l = '`';
				$r = '`';
				break;
			default:
		}

		//	...
		return $l.trim($value).$r;
	}

	/** SQL is execute.
	 *
	 * @see		\IF_DATABASE::SQL()
	 * @param	 string		 $query
	 * @param	 string		 $type
	 * @return	 array		 $record
	 */
	function SQL(string $sql, string $type)
	{
		return $this->Query($sql, $type);
	}

	/** Execute SQL statement.
	 *
	 * @param	 string		 $query
	 * @param	 string		 $type
	 * @return	 array		 $record
	 */
	function Query(string $query, string $type='')
	{
		//	...
		$type = strtolower($type);

		//	...
		if(!$query){
			return ($type === 'select') ? []: false;
		}

		//	Check of PDO instantiate.
		if(!$this->_PDO ){
			\Notice::Set("Has not been instantiate PDO.", debug_backtrace(false));
			return ($type === 'select') ? []: false;
		}

		//	Remove space.
		$query = trim($query);

		//	Stacking query for developers.
		$this->_queries[] = $query;

		//	Execute SQL statement.
		$statement = $this->_PDO->query($query);

		//	In case of empty.
		if(!$statement ){
			include_once(__DIR__.'/ErrorInfo.class.php');
			DATABASE\ErrorInfo::Set( $this->_PDO->errorInfo(), debug_backtrace(false) );
			return ($type === 'select') ? []: false;
		}

		//	Check of SQL type.
		if(!$type){
			$type = substr($query, 0, strpos($query, ' '));
		}

		//	Generate result value by type.
		switch( $type ){
			case 'select':
				$result = $statement->fetchAll(\PDO::FETCH_ASSOC);
				if( strpos($query.' ', ' LIMIT 1 ') and $result ){
					$result = $result[0];
				}
				break;

			case 'count':
				$result = $statement->fetchAll(\PDO::FETCH_ASSOC);
				$result = $result[0]['COUNT(*)'];
				break;

			case 'insert':
				if(!$result = $this->_PDO->lastInsertId(/* $name is necessary at PGSQL */) ){
					$result = true;
				}
				break;

			case 'update':
			case 'delete':
				$result = $statement->rowCount();
				break;

			case 'show':
				include_once(__DIR__.'/Show.class.php');
				$result = Database\Show::Get( $statement->fetchAll(\PDO::FETCH_ASSOC), $query );
				break;

			case 'set':
			case 'alter':
			case 'grant':
			case 'create':
			case 'drop':
				$result = true;
				break;

			case 'password':
				$result = array_shift($statement->fetchAll(\PDO::FETCH_ASSOC)[0]);
				break;

			case 'not':
				break;

			default:
				\Notice::Set("Has not been support this type. ($type)", debug_backtrace(false));
		}

		//	...
		return isset($result) ? $result: [];
	}

	/** Display debug information.
	 *
	 * @see \IF_DATABASE::Debug()
	 */
	function Debug()
	{
		D($this->_queries);
	}
}
