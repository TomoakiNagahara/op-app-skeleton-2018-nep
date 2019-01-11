<?php
/**
 * unit-database:/Create.class.php
 *
 * @creation  2018-12-19
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-12-19
 */
namespace OP\UNIT\DATABASE;

/** Database
 *
 * @creation  2018-12-19
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Create
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Database object.
	 *
	 * @var \IF_DATABASE
	 */
	private $_DB;

	/** Construct
	 *
	 * @param \IF_DATABASE $DB
	 */
	function __construct($DB)
	{
		$this->_DB = $DB;
	}

	/** Create user.
	 *
	 * @param  array       $config
	 */
	function User($config)
	{
		//	...
		$sql = \OP\UNIT\SQL\User::Create($config, $this->_DB);

		//	...
		$result = $this->_DB->Query($sql, 'create');

		//	...
		return empty($result) ? false: true;
	}

	/** Create database.
	 *
	 * @param  array       $config
	 */
	function Database($config)
	{
		//	...
		$sql = \OP\UNIT\SQL\Database::Create($config, $this->_DB);

		//	...
		$result = $this->_DB->Query($sql, 'create');

		//	...
		return empty($result) ? false: true;
	}

	/** Create table.
	 *
	 * @param  array       $config
	 */
	function Table($config)
	{
		//	...
		$sql = \OP\UNIT\SQL\Table::Create($config, $this->_DB);

		//	...
		$result = $this->_DB->Query($sql, 'create');

		D($sql, $result);

		//	...
		return empty($result) ? false: true;
	}
}
