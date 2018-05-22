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

	/** Wrapper method.
	 *
	 * @return \PDO
	 */
	function GetPDO()
	{
		return $this->PDO();
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
	 * @see    IF_DATABASE::Config()
	 * @return array $config
	 */
	function Config()
	{
		return $this->_config;
	}

	/** Connect database server.
	 *
	 * @param  array   $config
	 * @return boolean $io
	 */
	function Connect($config)
	{
		//	...
		foreach( ['driver','prod','host','port','user','password','database'] as $key ){
			$this->_config[$key] = ${$key} = ifset($config[$key]);
		}

		//	...
		if(!$prod ){
			$this->_config['prod'] = $prod = $driver;
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
			$this->_queries[] = $dsn;
			$this->_PDO = new \PDO($dsn, $user, $password);
		}catch( \Throwable $e ){
			\Notice::Set($e->getMessage() . " ($dsn, $user, $password)");
		}

		//	...
		return true;
	}

	function Count($config)
	{
		//	...
		if(!$this->_SQL ){
			return false;
		}

		//	...
		$query = $this->_SQL->Count($config, $this);

		//	...
		return $this->Query($query, __FUNCTION__);
	}

	function Select($config)
	{
		//	...
		if(!$this->_SQL ){
			return [];
		}

		//	...
		$query = $this->_SQL->Select($config, $this);

		//	...
		return $this->Query($query, __FUNCTION__);
	}

	function Insert($config)
	{
		//	...
		if(!$this->_SQL ){
			return false;
		}

		//	...
		$query = $this->_SQL->Insert($config, $this);

		//	...
		return $this->Query($query, __FUNCTION__);
	}

	function Update($config)
	{
		//	...
		if(!$this->_SQL ){
			return false;
		}

		//	...
		$query = $this->_SQL->Update($config, $this);

		//	...
		return $this->Query($query, __FUNCTION__);
	}

	function Delete($config)
	{
		//	...
		if(!$this->_SQL ){
			return false;
		}

		//	...
		$query = $this->_SQL->Delete($config, $this);

		//	...
		return $this->Query($query, __FUNCTION__);
	}

	function Quick($qql, $options=[])
	{
		include_once(__DIR__.'/QQL.class.php');
		return Database\QQL::Execute($qql, $options, $this);
	}

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

	/** Execute SQL statement.
	 *
	 * @see    IF_DATABASE::Query()
	 * @param  string $query
	 * @param  string $type
	 * @return array  $record
	 */
	function Query($query, $type=null)
	{
		//	...
		if(!$query){
			return $type==='Select' ? []: false;
		}

		//	Check of PDO instantiate.
		if(!$this->_PDO ){
			\Notice::Set("Has not been instantiate PDO.", debug_backtrace(false));
			return $type==='Select' ? []: false;
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
			return [];
		}

		//	Check of SQL type.
		if(!$type){
			$type = substr($query, 0, strpos($query, ' '));
		}

		//	Generate result value by type.
		switch( strtolower($type) ){
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
				$result = $this->_PDO->lastInsertId(/* $name is necessary at PGSQL */);
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
				$result = true;
				break;

			case 'password':
				$result = array_shift($statement->fetchAll(\PDO::FETCH_ASSOC)[0]);
				break;

			default:
				\Notice::Set("Has not been support this type. ($type)", debug_backtrace(false));
		}

		//	...
		return isset($result) ? $result: [];
	}

	/** Get past stacked queries.
	 *
	 * @see    IF_DATABASE::Queries()
	 * @return array $queries
	 */
	function Queries()
	{
		return $this->_queries;
	}
}
