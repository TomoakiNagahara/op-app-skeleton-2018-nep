<?php
/**
 * IF_SQL_DDL_DROP.interface.php
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_SQL_DDL_DROP
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DDL_DROP
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

	/** Generate Drop User SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function User(array $config);

	/** Generate Drop Database SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Database(array $config);

	/** Generate Drop Table SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Table(array $config);
}
