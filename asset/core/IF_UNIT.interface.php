<?php
/**
 * IF_UNIT.interface.php
 *
 * @creation  2019-01-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_UNIT
 *
 * @creation  2019-01-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_UNIT
{
	/** Display how to use.
	 *
	 * This feature is just for developers.
	 *
	 * @creation 2019-01-25
	 * @param	 array	 $config
	 */
	public function Help();

	/** Display debug information.
	 *
	 * This feature is just for developers.
	 *
	 * @creation 2019-01-25
	 * @param	 array	 $config
	 */
	public function Debug();
}
