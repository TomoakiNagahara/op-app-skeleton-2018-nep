<?php
/**
 * unit-orm:/Record.class.php
 *
 * @created   2018-02-01
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-02-01
 */
namespace OP\UNIT\ORM;

/** ORM
 *
 * @created   2018-02-01
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Record
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** IF_FORM
	 *
	 * @var \OP\UNIT\Form
	 */
	private $_form;

	/** Configuration.
	 *
	 * @var array
	 */
	private $_config;

	/** Database of record.
	 *
	 * @var string
	 */
	private $_database;

	/** Table of record.
	 *
	 * @var string
	 */
	private $_table;

	/** Selected record.
	 *
	 * @var array
	 */
	private $_record;

	/** Table column structure.
	 *
	 * @var array
	 */
	private $_column;

	/** Changed values.
	 *
	 * @var array
	 */
	private $_change;

	/** Validation result.
	 *
	 * @var boolean
	 */
	private $_isValid;

	/** Constract.
	 *
	 * @param string $struct
	 * @param string $record
	 */
	function __construct($database, $table, $struct, $record=[], $config)
	{
		//	...
		$this->_database = $database;
		$this->_table  = $table;
		$this->_column = $struct;
		$this->_record = $record;
		$this->_config = $config;
	}

	/** Get record value.
	 *
	 * @param  string $name
	 * @return mixed  $value
	 */
	function __get($name)
	{
		//	Search for Change values.
		if( isset($this->_change[$name]) ){
			$value = $this->_change[$name];
		}else

		//	Search for Record values.
		if( isset($this->_record[$name]) ){
			$value = $this->_record[$name];
		}else{
			$value = null;

			//	Call from ORM->Save(), Nessarry pkey value.
			if( $name !== $this->Pkey() ){
				//	This field name has not been exists.
				\Notice::Set("This field name has not been exists. ($name)");
			}
		}

		//	...
		return $value;
	}

	/** Set record value.
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	function __set($name, $value)
	{
		//	Does not update timestamp.
		if( $this->_column[$name]['type'] === 'timestamp' ){
			return;
		}

		//	Empty string is convert to null.
		if( is_string($value) and strlen($value) === 0 ){
			$value = null;
		}

		//	Empty array is convert to null.
		if( is_array($value) ){
			if( strlen(trim(join(',',$value), ',')) === 0 ){
				$value = null;
			}
		}

		//	Already changed.
		if( isset($this->_change[$name]) ){
			//	Return if the values are the same.
			if( $this->_change[$name] === $value ){
				return;
			}
		}

		//	$this->_record is origin.
		if(($this->_record[$name] ?? null) === $value ){

			//	Recovered to original value.
			unset($this->_change[$name]);

			//	...
			return;
		}

		//	If null is okey.
		if( $this->_column[$name]['null'] ){
			//	If value is empty.
			if( (is_string($value) and strlen($value) === 0)
					or
				(is_array($value)  and count($value)   <= 1)
			){
				//	Database into null.
				$value = null;
			}
		}

		//	$this->_change is update values.
		$this->_change[$name] = $value;

		//	Change of instanciated Form input value.
		$this->Form()->Set($name, $value);
	}

	/** Is ready.
	 *
	 * @return boolean
	 */
	function isReady()
	{
		return $this->_column ? true: false;
	}

	/** Is found record.
	 *
	 * @return boolean
	 */
	function isFound()
	{
		return $this->_record ? true: false;
	}

	/** Validation result.
	 *
	 * @return boolean
	 */
	function isValid()
	{
		return $this->Validate();
	}

	/** Get/Set database name
	 *
	 * @param  string $database
	 * @return string $database
	 */
	function Database($database=null)
	{
		return $this->_database;
	}

	/** Get/Set table name.
	 *
	 * @param  string $table
	 * @return string $table
	 */
	function Table($table=null)
	{
		return $this->_table;
	}

	/** Get column structure.
	 *
	 * @return array $columns
	 */
	function Column()
	{
		return $this->_column;
	}

	/** Get Primary key field name.
	 *
	 * @return string $pkey
	 */
	function Pkey()
	{
		//	...
		static $_pkey;

		//	...
		if(!$_pkey ){
			foreach( $this->_column as $name => $column ){
				if( $column['key'] === 'pri' ){
					$_pkey = $name;
					break;
				}
			}
		}

		//	...
		return $_pkey;
	}

	/** To array of record value.
	 *
	 * @return array
	 */
	function Values()
	{
		return array_merge($this->_record ?? [], $this->_change ?? []);
	}

	/** Generate Form object.
	 *
	 * @param unknown $record
	 * @return \OP\UNIT\Form
	 */
	function &Form()
	{
		//	...
		if(!$this->_form ){
			$this->_form = \Unit::Instance('Form');

			//	...
			$config = Config::Form(
				$this->Database(),
				$this->Table(),
				$this->Column(),
				$this->Values(),
				$this->_config
			);

			//	...
			$this->_form->Config($config);
		}

		//	...
		return $this->_form;
	}

	/** Validation
	 *
	 * @return boolean
	 */
	function Validate()
	{
		//	...
		if( $this->_isValid === null ){
			//	...
			$this->_isValid = $this->Form()->Validate();
		}

		//	...
		return $this->_isValid;
	}

	/** Has field.
	 *
	 * @return	 boolean	$io
	 */
	function Has($field)
	{
		return isset($this->_column[$field]);
	}

	/** Get value.
	 *
	 * @param  string $field
	 * @return mixed|NULL
	 */
	function Get($field)
	{
		return $this->__get($field);
	}

	/** Set value.
	 *
	 * @param string $field
	 * @param mixed  $value
	 */
	function Set($field, $value)
	{
		$this->__set($field, $value);
	}

	/** Set many value.
	 *
	 * @param array $values
	 */
	function Sets($values)
	{
		foreach( $values as $field => $value ){
			$this->Set( $field, $value );
		}
	}

	/** Get changed values.
	 *
	 * @param  boolean $clear
	 * @return array
	 */
	function Changed($clear=false)
	{
		//	...
		if( $clear ){
			$this->_change = null;
		}

		//	...
		return $this->_change ?? [];
	}

	/** For developers
	 *
	 */
	function Debug()
	{
		$info['database']= $this->_database;
		$info['table']	 = $this->_table;
		$info['record']	 = $this->_record;
		$info['column']	 = $this->_column;
		$info['change']	 = $this->_change;
		$info['found']	 = $this->isFound();
		$info['valid']	 = $this->isValid();
		D($info);
	}
}
