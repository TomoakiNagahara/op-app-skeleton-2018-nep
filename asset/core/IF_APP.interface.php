<?php
/**
 * IF_APP.interface.php
 *
 * @creation  2019-02-02
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_APP
 *
 * @creation  2019-02-02
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_APP
{
	/** Get URL argument.
	 *
	 */
	public function Args();

	/** Wrap template class.
	 *
	 */
	public function Template();

	/** Wrap title method.
	 *
	 */
	public function Title();
}
