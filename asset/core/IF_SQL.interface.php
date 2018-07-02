<?php
/**
 * IF_SQL.interface.php
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_SQL
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL
{
	/** Generate INSERT SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $_DB
	 */
	public function Insert($config, $_DB);

	/** Generate SELECT SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $_DB
	 */
	public function Select($config, $_DB);

	/** Generate UPDATE SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $_DB
	 */
	public function Update($config, $_DB);

	/** Generate DELETE SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $_DB
	 */
	public function Delete($config, $_DB);
}
