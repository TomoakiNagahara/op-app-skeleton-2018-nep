<?php
/**
 * IF_SQL_AS.interface.php
 *
 * @creation  2019-01-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_SQL_AS_DATABASE
 *
 * @creation  2019-01-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_AS_DATABASE
{
	/** IF_DATABASE
	 *
	 * @var \IF_DATABASE
	 */
	private $_DB;

	/** Construct.
	 *
	 * @creation  2019-01-17
	 * @param	\IF_DATABASE $_DB
	 */
	public function __construct(\IF_DATABASE $_DB);
	public function Analytics();
	public function Add();
	public function Change();
	public function Drop();
}

/** IF_SQL_AS_TABLE
 *
 * @creation  2019-01-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_AS_TABLE
{
	/** IF_DATABASE
	 *
	 * @var \IF_DATABASE
	 */
	private $_DB;

	/** Construct.
	 *
	 * @creation  2019-01-17
	 * @param	\IF_DATABASE $_DB
	 */
	public function __construct(\IF_DATABASE $_DB);
	public function Analytics();
	public function Add();
	public function Change();
	public function Drop();
}

/** IF_SQL_AS_COLUMN
 *
 * @creation  2019-01-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_AS_COLUMN
{
	/** IF_DATABASE
	 *
	 * @var \IF_DATABASE
	 */
	private $_DB;

	/** Construct.
	 *
	 * @creation  2019-01-17
	 * @param	\IF_DATABASE $_DB
	 */
	public function __construct(\IF_DATABASE $_DB);
	public function Analytics();
	public function Add();
	public function Change();
	public function Drop();
}

/** IF_SQL_AS_INDEX
 *
 * @creation  2019-01-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_AS_INDEX
{
	/** IF_DATABASE
	 *
	 * @var \IF_DATABASE
	 */
	private $_DB;

	/** Construct.
	 *
	 * @creation  2019-01-17
	 * @param	\IF_DATABASE $_DB
	 */
	public function __construct(\IF_DATABASE $_DB);
	public function Analytics();
	public function Add();
	public function Change();
	public function Drop();
}
