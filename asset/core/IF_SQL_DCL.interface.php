<?php
/**
 * IF_SQL_DCL.interface.php
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_SQL_DCL
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DCL
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

	/** Generate Grant SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 */
	public function Grant(array $config);

	/** Generate Revoke SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 */
	public function Revoke(array $config);

	/** Generate Begin SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 */
	public function Begin(array $config);

	/** Generate Commit SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 */
	public function Commit(array $config);

	/** Generate Rollback SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 */
	public function Rollback(array $config);

	/** Generate Lock SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 */
	public function Lock(array $config);

	/** Generate Savepoint SQL.
	 *
	 * @creation 2019-01-08
	 * @param	 array		 $config
	 */
	public function Savepoint(array $config);
}
