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

	/** IF_FORM
	 *
	 * @var \IF_FORM
	 */
	private $_form;

	/** Get/Set Unit of Database.
	 *
	 * @param	 array		 $DB
	 * @return	\IF_DATABASE $DB
	 */
	function DB($DB=null)
	{
		static $_DB;

		if( $DB ){
			$_DB = $DB;
		}else if(!$_DB ){
			$_DB = \Unit::Instance('Database');
		}

		return $_DB;
	}

	function Form()
	{

	}

	/** Connect to database.
	 *
	 * @param	 array	 $config
	 * @reutrn	 boolean $io
	 */
	function Connect($config)
	{
		return $this->DB()->Connect($config);
	}

	/** New empty recrod.
	 *
	 * @param	 string		 $table_name
	 * @return	 ORM\Record	 $record
	 */
	function Create($qql)
	{
		//	$select is select configuration array.
		$namespace = get_class($this->DB());
		$namespace = strtoupper($namespace);
		$classname = "\\$namespace\QQL";
		$select = $classname::Parse($qql, [], $this->DB());

		//	...
		$database = $select['database'] ?? $this->DB()->Config()['database'];
		$table    = $select['table'];
		$table    = trim($table, '`');

		//	...
		$query  = \OP\UNIT\SQL\Show::Column($this->DB(), $database, $table);
		$struct = $this->DB()->Query( $query );

		/* @var $record ORM\Record */
		$record = new ORM\Record($struct);
		$record->Database( $database );
		$record->Table(    $table    );

		//	...
		foreach( $struct as $column ){
			$record->Set( $column['field'], '' );
		}

		//	...
		return $record;
	}

	/** Find single record.
	 *
	 * @param	 string				 $qql
	 * @return	\OP\UNIT\ORM\Record	 $record
	 */
	function Find($qql)
	{
		//	Force single column record.
		$option['limit'] = 1;

		//	$select is select configuration array.
		$namespace = get_class($this->DB());
		$namespace = strtoupper($namespace);
		$classpath = "\\$namespace\QQL";

		//	Generate config from QQL.
		$select = $classpath::Parse($qql, $option, $this->DB());

		//	Fetch record.
		$result = $classpath::Select($select, $this->DB());

		//	Fetch table struct.
		$database = $select['database'] ?? $this->DB()->Config()['database'];
		$table    = $select['table'];
		$table    = trim($table, '`');
		$query    = \OP\UNIT\SQL\Show::Column($this->DB(), $database, $table);
		$struct   = $this->DB()->Query( $query );

		/* @var $record ORM\Record */
		$record = new ORM\Record( $struct, $result );
		$record->Database( $database );
		$record->Table(    $table    );

		//	Return "Record" Object.
		return $record;
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
	 * @param  ORM\Record $record
	 * @return mixed
	 */
	function Save($record, $validate=[])
	{
		//	...
		if( $form = $record->Form() ){
			//	...
			if(!$form->Token() ){
				return null;
			}

			//	...
			if(!$record->Validate() ){
				return null;
			}

			//	...
			$record->Sets( $form->Values() );
		}

		//	...
		if(!$record->Changed()){
			return null;
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
		if( $pval ){
			//	Update
			$config['where'][$pkey] = $pval;
			$config['limit'] = 1;

			//	...
			$pval  = $this->_Update($config) ? true: false;
		}else{
			//	Insert
			unset($config['set'][$pkey]);

			//	Get new insert id.
			$pval = $this->_Insert($config);

			//	Set new insert id.
			$record->Set($pkey, $pval);

			//	...
			if( $form = $record->Form() ){
				$vals = $form->Values();
				$conf = $form->Config();

				//	...
			//	$conf['name'] = ORM\Config::FormName($config['database'], $config['table'], $pval);
			//	$form->Config($conf);
			}
		}

		//	...
		$form->Clear();

		//	...
		return $pval;
	}

	function _Insert($config)
	{
		//	...
		$query = \OP\UNIT\SQL\Insert::Get($config, $this->DB());

		//	...
		return $this->DB()->Query($query, 'insert');
	}

	function _Select()
	{

	}

	function _Update($config)
	{
		//	...
		$query = \OP\UNIT\SQL\Update::Get($config, $this->DB());

		//	...
		return $this->DB()->Query($query, 'update');
	}

	function _Delete()
	{

	}

	function Debug()
	{
		D( $this->DB()->Queries() );
	}
}
