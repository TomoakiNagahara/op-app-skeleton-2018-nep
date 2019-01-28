<?php
/**
 * unit-orm:/ORM.class.php
 *
 * @creation  2017-03-16
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-02-01
 */
namespace OP\UNIT;

/** ORM
 *
 * @creation  2017-03-16
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class ORM
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** DSN
	 *
	 * @var string
	 */
	private $_dsn;

	/** Configuration.
	 *
	 * @var array
	 */
	private $_config;

	/** IF_DATABASE
	 *
	 * @var \OP\UNIT\Database
	 */
	private $_DB;

	/** Insert
	 *
	 * @param	 array	 $config
	 * @return	 integer $ai
	 */
	private function _Insert($config)
	{
		//	...
		$query = \OP\UNIT\SQL\Insert::Get($config, $this->DB());

		//	...
		return $this->DB()->Query($query, 'insert');
	}

	/** Update
	 *
	 * @param	 array	 $config
	 * @return	 integer $count
	 */
	private function _Update($config)
	{
		//	...
		$query = \OP\UNIT\SQL\Update::Get($config, $this->DB());

		//	...
		return $this->DB()->Query($query, 'update');
	}

	/** Delete
	 *
	 */
	private function _Delete()
	{

	}

	/** Generate "Record" object.
	 *
	 * @param	 string		 $qql
	 * @return	ORM\Record	 $record
	 */
	private function _Record($qql, $create)
	{
		//	...
		$option = [];

		//	Force single column record.
		$option['limit'] = 1;

		//	$select is select configuration array.
		$namespace = get_class($this->DB());
		$namespace = strtoupper($namespace);
		$classpath = "\\$namespace\QQL";

		//	Generate config from QQL.
		$select = $classpath::Parse($qql, $option, $this->DB());

		//	Fetch table struct.
		$database = $select['database'] ?? $this->DB()->Config()['database'];
		$table    = $select['table'];
		$table    = trim($table, '`');
		$query    = \OP\UNIT\SQL\Show::Column($this->DB(), $database, $table);
		$struct   = $this->DB()->Query( $query );

		//	Create or Fetch.
		if( $create ){
			$result = [];
		}else{
			//	Fetch record.
			$result = $classpath::Select($select, $this->DB());
		}

		/* @var $record ORM\Record */
		$record = new ORM\Record( $database, $table, $struct, $result, $this->_config[$this->_dsn][$database][$table] ?? [] );

		//	Return "Record" Object.
		return $record;
	}

	/** Connect to database.
	 *
	 * <pre>
	 * //	1. Connect at URL scheme.
	 * $orm->Connect('mysql://testcase:password@localhost:3306?charset=utf8');
	 *
	 * //	2. Connect at config array.
	 * $config = [
	 *   'driver'   => 'mysql',
	 *   'host'     => 'localhost',
	 *   'port'     => '3306',
	 *   'user'     => 'testcase',
	 *   'password' => 'password',
	 *   'charset'  => 'utf8',
	 * ];
	 * $orm->Connect($config);
	 * </pre>
	 *
	 * @param	 string|array	 $config
	 * @reutrn	 boolean		 $io
	 */
	function Connect($config)
	{
		//	...
		if( $this->_DB ){
			\Notice::Set('Already connected. (Instance had database object)');
			return;
		}

		//	Build DSN and save.
		if( is_array($config) ){
			//	...
		}

		//	Parse of DSN.
		if( is_string($config) ){
			//	...
			$this->_dsn = $config;

			//	...
			$config = parse_url($config);
			$config['prod']     = $config['scheme'];
			$config['password'] = $config['pass'];

			//	...
			if( isset($config['query']) ){
				$query = null;
				parse_str($config['query'], $query);
				$config = array_merge($config, $query);
			}
		}

		//	...
		return $this->DB()->Connect($config);
	}

	/** Configuration.
	 *
	 * @param null|string $config
	 */
	function Config($config=null)
	{
		//	...
		if(!$this->_config = include($config) ){
			return;
		}

		//	...
		return $this->_config;
	}

	/** Get/Set Unit of Database.
	 *
	 * @param	\OP\UNIT\Database|null	 $DB
	 * @return	\OP\UNIT\Database		 $DB
	 */
	function DB($DB=null)
	{
		if( $DB ){
			$this->_DB = $DB;
		}else
			if(!$this->_DB ){
				$this->_DB = \Unit::Instance('Database');
		}

		return $this->_DB;
	}

	/** New empty recrod.
	 *
	 * @param	 string		 $table_name
	 * @return	 ORM\Record	 $record
	 */
	function Create($table)
	{
		return self::_Record($table, true);
	}

	/** Find single record.
	 *
	 * @param	 string		 $qql
	 * @return	 ORM\Record	 $record
	 */
	function Find($qql)
	{
		return self::_Record($qql, false);
	}

	/** Find multiple records.
	 *
	 * @return	 ORM\Records
	 */
	function Finds($qql, $option=[])
	{

	}

	/** Save is Insert or auto Update.
	 *
	 * <pre>
	 * RETURN VALUE:
	 *   null:    Token unmatch or Validation failed or Not changed.
	 *   boolean: Updated result.
	 *   number:  Auto increment id.
	 *   string:  Unique primary id.
	 * </pre>
	 *
	 * @param	 ORM\Record $record
	 * @return	 mixed
	 */
	function Save(&$record)
	{
		//	...
		if( $form = $record->Form() ){
			//	...
			if(!$form->Token() ){
				return;
			}

			//	...
			if(!$form->Validate() ){
				return;
			}

			//	...
			$record->Sets( $form->Values() );
		}

		//	...
		$config = [];
		$config['database'] = $record->Database();
		$config['table']    = $record->Table();
		$config['set']      = $record->Changed();

		//	Get primary key and value.
		$pkey = $record->Pkey();
		$pval = $record->Get($pkey);

		//	...
		unset($config['set'][$pkey]);

		//	...
		if( empty($config['set']) ){
			return 0;
		}

		//	...
		if( strlen($pval) ){
			//	Update
			$config['where'][$pkey] = $pval;
			$config['limit'] = 1;

			//	...
			$result = $this->_Update($config);
		}else{
			//	Insert
			//	Get new insert id.
			$result = $this->_Insert($config);

			//	Set new insert id.
			$record->Set($pkey, $result);

			//	Clear form value.
			$record->Form()->Clear();
		}

		//	...
		if( $result ){
			$record->Changed(true);
		}

		//	...
		return $result;
	}

	/** Delete record.
	 *
	 */
	function Delete()
	{

	}

	/** Generate self-test configuration.
	 *
	 * @param	 string		 $file
	 */
	function Selftest($file)
	{
		ORM\Selftest::Auto($file);
	}

	/** For developers.
	 *
	 */
	function Debug()
	{
		D( $this->DB()->Queries() );
	}
}
