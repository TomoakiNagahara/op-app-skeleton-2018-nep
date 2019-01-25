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

	/** Data Definition Language.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	\IF_SQL_DDL	 $_DDL
	 */
	public function DDL(array $config);

	/** Data Manipulation Language.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	\IF_SQL_DML	 $_DML
	 */
	public function DML(array $config);

	/** Data Control Language
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 * @return	\IF_SQL_DCL	 $_DCL
	 */
	public function DCL(array $config);

	/** Class of abstracting at database relation.
	 *
	 * @creation 2019-01-17
	 * @param	 array		 $config
	 * @return	\IF_SQL_AS_DATABASE
	 */
	public function Database(array $config);

	/** Class of abstracting at table relation.
	 *
	 * @creation 2019-01-17
	 * @param	 array		 $config
	 * @return	\IF_SQL_AS_TABLE
	 */
	public function Table(array $config);

	/** Class of abstracting at column relation.
	 *
	 * @creation 2019-01-17
	 * @param	 array		 $config
	 * @return	\IF_SQL_AS_COLUMN
	 */
	public function Column(array $config);

	/** Class of abstracting at index relation.
	 *
	 * @creation 2019-01-17
	 * @param	 array		 $config
	 * @return	\IF_SQL_AS_INDEX
	 */
	public function Index(array $config);
}
