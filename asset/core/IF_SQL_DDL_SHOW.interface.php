<?php
/**
 * IF_SQL_DDL_SHOW.interface.php
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_SQL_DDL_SHOW
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DDL_SHOW
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

	/** Generate Show Database SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Database(array $config);

	/** Generate Show Table SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Table(array $config);

	/** Generate Show Column SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Column(array $config);

	/** Generate Show Index SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Index(array $config);

	/** Generate Show Variables SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Variables(array $config);

	/** Generate Show Status SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Status(array $config);

	/** Generate Show Grants SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	 string		 $sql
	 */
	public function Grants(array $config);
}
