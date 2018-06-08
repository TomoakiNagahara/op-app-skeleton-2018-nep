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
	 * @param	 string				 $qql
	 * @return	\OP\UNIT\ORM\Record	 $record
	 */
	private function _Record($qql, $create)
	{
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

		//	...
		if(!$struct ){
			$result = null;
		//	return;
		}

		//	Create or Fetch.
		if( $create ){
			/*
			foreach( $struct as $column ){
				$result[$column['field']] = '';
			}
			*/
			$result = [];
		}else{
			//	Fetch record.
			$result = $classpath::Select($select, $this->DB());
		}

		/* @var $record ORM\Record */
		$record = new ORM\Record( $struct, $result );
		$record->Database( $database );
		$record->Table(    $table    );

		//	Return "Record" Object.
		return $record;
	}

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
	function Create($table)
	{
		return self::_Record($table, true);
	}

	/** Find single record.
	 *
	 * @param	 string				 $qql
	 * @return	\OP\UNIT\ORM\Record	 $record
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
	 * @param  ORM\Record $record
	 * @return mixed
	 */
	function Save($record)
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
			return;
		}

		//	...
		if( $pval ){
			//	Update
			$config['where'][$pkey] = $pval;
			$config['limit'] = 1;

			//	...
			$pval = $this->_Update($config) !== false ? true: false;
		}else{
			//	Insert
			//	Get new insert id.
			$pval = $this->_Insert($config);

			//	Set new insert id.
			$record->Set($pkey, $pval);

			//	...
			if( $form = $record->Form() ){
				$form->Clear();
			}
		}

		//	...
		return $pval;
	}

	/** Delete record.
	 *
	 */
	function Delete()
	{

	}

	function Debug()
	{
		D( $this->DB()->Queries() );
	}
}
