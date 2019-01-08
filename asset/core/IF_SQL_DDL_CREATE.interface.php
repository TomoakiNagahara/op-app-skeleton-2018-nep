<?php
/**
 * IF_SQL_DDL_CREATE.interface.php
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_SQL_DDL_CREATE
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DDL_CREATE
{
	/** IF_DATABASE
	 *
	 * @var \IF_DATABASE
	 */
	private $_DB;

	/** Construct.
	 *
	 * @creation 2019-01-08
	 * @param	\IF_DATABASE $_DB
	 */
	public function __construct(\IF_DATABASE $_DB);

	/** Generate Create user SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function User(array $config);

	/** Generate Create database SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Database(array $config);

	/** Generate Create table SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Table(array $config);
}
