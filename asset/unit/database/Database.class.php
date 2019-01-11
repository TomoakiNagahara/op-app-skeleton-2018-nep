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
	 * @param	 array		 $config
	 * @return	 boolean	 $io
	 */
	function Connect($config)
	{
		//	...
		$config['prod'] = strtolower($config['prod']);

		//	...
		switch( $prod = $config['prod'] ){
			case 'mysql':
				include(__DIR__.'/SQL_MY.class.php');
				$this->_config = DATABASE\MYSQL::Config($config);
				$this->_PDO    = DATABASE\MYSQL::Connect($config);
				break;

			case 'pgsql':
				include(__DIR__.'/SQL_PG.class.php');
				$this->_config = DATABASE\PGSQL::Config($config);
				$this->_PDO    = DATABASE\PGSQL::Connect($config);
				break;

			case 'sqlite':
				include(__DIR__.'/SQL_LITE.class.php');
				$this->_config = DATABASE\SQLITE::Config($config);
				$this->_PDO    = DATABASE\SQLITE::Connect($config);
				break;

			default:
				\Notice::Set("Has not been this product. ($prod)");
		};

		//	...
		return $this->_PDO ? true: false;
	}

	/** Create
	 *
	 * @return \OP\UNIT\DATABASE\Create
	 */
	function Create()
	{
		//	...
		static $_create;

		//	...
		if(!$_create ){
			include('Create.class.php');
			$_create = new \OP\UNIT\DATABASE\Create($this);
		};

		//	...
		return $_create;
	}

	/** Drop
	 *
	 * @return \OP\UNIT\DATABASE\Drop
	 */
	function Drop()
	{
		//	...
		static $_drop;

		//	...
		if(!$_drop ){
			include('Drop.class.php');
			$_drop = new \OP\UNIT\DATABASE\Drop($this);
		};

		//	...
		return $_drop;
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
		switch( $prod = $this->_config['prod'] ){
			case 'mysql':
				$l = '`';
				$r = '`';
				break;

			case 'pgsql':
				$l = '"';
				$r = '"';
				break;

			default:
				throw new \Exception("Has not been support this product. ($prod)");
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
