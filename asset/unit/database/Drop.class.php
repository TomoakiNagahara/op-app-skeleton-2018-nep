<?php
/**
 * unit-database:/Drop.class.php
 *
 * @creation  2019-01-07
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-01-07
 */
namespace OP\UNIT\DATABASE;

/** Drop
 *
 * @creation  2019-01-07
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Drop
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

	/** Drop user
	 *
	 * @param  array       $config
	 */
	function User($config)
	{
		//	...
		$sql = \OP\UNIT\SQL\User::Drop($config, $this->_DB);

		//	...
		$result = $this->_DB->Query($sql, 'drop');

		//	...
		return empty($result) ? false: true;
	}

	/** Drop database.
	 *
	 * @param  array       $config
	 */
	function Database($config)
	{
		//	...
		$sql = \OP\UNIT\SQL\Database::Drop($config, $this->_DB);

		//	...
		$result = $this->_DB->Query($sql, 'drop');

		//	...
		return empty($result) ? false: true;
	}

	/** Drop table.
	 *
	 * @param  array       $config
	 */
	function Table($config)
	{
		//	...
		$sql = \OP\UNIT\SQL\Table::Drop($config, $this->_DB);

		//	...
		$result = $this->_DB->Query($sql, 'drop');


		D($sql, $result);

		//	...
		return empty($result) ? false: true;
	}
}
