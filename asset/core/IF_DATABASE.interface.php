<?php
/**
 * IF_DATABASE.interface.php
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_DATABASE
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_DATABASE
{
	public function PDO();
	public function Config();
	public function Connect($config);
	public function Count($config);
	public function Select($config);
	public function Insert($config);
	public function Update($config);
	public function Delete($config);
	public function Quick($config, $options);
	public function Query($config, $type=null);
	public function Quote($config);
	public function Queries();
}
