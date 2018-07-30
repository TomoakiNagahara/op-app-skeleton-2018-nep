<?php
/**
 * unit-japan:/Japan.class.php
 *
 * @creation  2018-07-30
 * @version   1.0
 * @package   unit-japan
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-07-30
 */
namespace OP\UNIT;

/** Japan
 *
 * @creation  2018-07-30
 * @version   1.0
 * @package   unit-japan
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Japan
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** imperial era name.
	 *
	 * @param	 string		 $date
	 */
	function EraName($date=null)
	{
		include_once('EraName.class.php');
		return JAPAN\EraName::Get($date);
	}

	/** Japanese consumption tax. (sales tax)
	 *
	 * @param	 string		 $date
	 */
	function Tax($date)
	{
		include_once('Tax.class.php');
		return JAPAN\Tax::Get($date);
	}
}
