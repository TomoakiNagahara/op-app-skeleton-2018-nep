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
	private $_columns;

	/** Changed values.
	 *
	 * @var array
	 */
	private $_change;

	/** Validation errors.
	 *
	 * @var array
	 */
	private $_validate;

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
	function __construct($struct, $record=null)
	{
		//	...
		$this->_columns = $struct;

		//	...
		if( $record ){
			//	...
			$this->_record = $record;

			//	...
			foreach( $record as $field => $value ){
				//	...
				$this->$field = $value;
			}
		}
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

			//	This field name has not been exists.
			\Notice::Set("This field name has not been exists. ($name)");
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
		//	...
		$type = gettype($value);

		//	...
		if(!isset($this->_change[$name]) ){
			//	...
		}else

		//	...
		if( $this->_change[$name] === $value ){
			return;
		}

		//	$this->_record is origin.
		if( $this->_record[$name] === $value ){

			//	Recovered to original value.
			unset($this->_change[$name]);

			//	...
			return;
		}

		//	$this->_change is update values.
		$this->_change[$name] = $value;
	}

	/** Get/Set database name
	 *
	 * @param  string $database
	 * @return string $database
	 */
	function Database($database=null)
	{
		if( $database ){
			if(!$this->_database ){
				$this->_database = $database;
			}else{
				\Notice::Set("Database name was already setted. ({$this->_database}, $database)");
			}
		}

		//	...
		return $this->_database;
	}

	/** Get/Set table name.
	 *
	 * @param  string $table
	 * @return string $table
	 */
	function Table($table=null)
	{
		if( $table ){
			if(!$this->_table ){
				$this->_table = $table;
			}else{
				\Notice::Set("Table name was already setted. ({$this->_table}, $table)");
			}
		}

		//	...
		return $this->_table;
	}

	/** Get column structure.
	 *
	 * @return array $columns
	 */
	function Column()
	{
		return $this->_columns;
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
			foreach( $this->_columns as $name => $column ){
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
	function Array()
	{
		//	...
		$result = $this->_record;

		//	...
		foreach( $this->Changed() as $key => $value ){
			$result[$key] = $value;
		}

		//	...
		return $result;
	}

	/** Generate Form object.
	 *
	 * @param unknown $record
	 * @return \OP\UNIT\Form
	 */
	function Form()
	{
		/* @var $form IF_FORM */
		/*
		$form = \Unit::Instance('Form');

		//	...
		$config = Config::Form(
			$this->Database(),
			$this->Table(),
			$this->Column(),
			$this->Array()
		);

		//	...
		$form->Config($config);

		//	...
		return $form;
		*/


		/* @var $_form IF_FORM */
		static $_form;

		//	...
		if(!$_form ){
			$_form = \Unit::Instance('Form');

			//	...
			$config = Config::Form(
				$this->Database(),
				$this->Table(),
				$this->Column(),
				$this->Array()
			);

			//	...
			$_form->Config($config);
		}

		//	...
		return $_form;
	}

	/** Validation
	 *
	 */
	function Validate()
	{
		//	...
		if( $this->_isValid !== null ){
			return $this->_validate;
		}

		//	...
		if(!\Unit::Load('validate')){
			return false;
		}

		//	...
		$rules  = Config::Validate($this->_columns);

		//	...
		$values = $this->Form()->Values();

		//	...
		$this->_isValid = \OP\UNIT\Validate::Evaluations($rules, $values, $this->_validate);

		//	...
		return $this->_isValid;
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
		return $this->_isValid;
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
	 * @return array
	 */
	function Changed()
	{
		//	...
		$result = [];

		//	...
		if( empty($this->_change) ){
			return $result;
		}

		//	...
		foreach( $this->_change as $name => $value ){
			$result[$name] = $value;
		}

		//	...
		return $result;
	}
}
