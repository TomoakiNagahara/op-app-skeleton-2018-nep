<?php
/**
 * IF_SQL_DDL.interface.php
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_SQL_DDL
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DDL
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

	/** Generate Show Object.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	\IF_SQL_DDL_SHOW
	 */
	public function Show(array $config);

	/** Generate Create Object.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	\IF_SQL_DDL_CREATE
	 */
	public function Create(array $config);

	/** Generate Drop Object.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	\IF_SQL_DDL_CREATE
	 */
	public function Drop(array $config);

	/** Generate Alter Object.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	\IF_SQL_DDL_CREATE
	 */
	public function Alter(array $config);

	/** Generate Truncate SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Truncate(array $config);
}
