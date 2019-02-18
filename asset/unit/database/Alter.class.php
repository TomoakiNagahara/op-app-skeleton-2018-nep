<?php
/**
 * unit-database:/Create.class.php
 *
 * @creation  2019-01-18
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\DATABASE;

/** Database
 *
 * @creation  2019-01-18
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Alter
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Database object.
	 *
	 * @var \OP\UNIT\Database
	 */
	private $_DB;

	/** Construct
	 *
	 * @param \OP\UNIT\Database $DB
	 */
	function __construct(\OP\UNIT\Database $DB)
	{
		$this->_DB = $DB;
	}
}
