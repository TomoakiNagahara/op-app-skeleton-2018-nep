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
	/** Return PDO instance.
	 *
	 * <pre>
	 * $this->PDO()->Query();
	 * </pre>
	 *
	 * @addition 2018-04-20
	 * @return	\PDO
	 */
	public function PDO();

	/** Get configuration.
	 *
	 * <pre>
	 * //  Configuration.
	 * $config = [];
	 * $conifg['prod']     = 'mysql';
	 * $conifg['host']     = 'localhost';
	 * $conifg['port']     = '3306';
	 * $conifg['user']     = 'username';
	 * $conifg['password'] = 'password';
	 * $conifg['charset']  = 'utf8';
	 * $conifg['database'] = 'databasename';
	 * </pre>
	 *
	 * @addition 2018-11-13
	 * @return	 array		 $config
	 */
	public function Config();

	/** Connect to database. And instantiate PDO.
	 *
	 * @addition 2018-04-20
	 * @param	 array		 $config
	 * @return	\PDO
	 */
	public function Connect($config);

	/** Count number of records at SELECT conditions.
	 *
	 * @addition 2018-04-20
	 * @param	 array		 $config
	 * @return	 integer	 $count
	 */
	public function Count($config);

	/** Execute SELECT SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array	 $config
	 */
	public function Select($config);

	/** Execute INSERT SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array	 $config
	 */
	public function Insert($config);

	/** Execute UPDATE SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array	 $config
	 */
	public function Update($config);

	/** Execute DELETE SQL.
	 *
	 * @addition 2018-04-20
	 * @param	 array	 $config
	 */
	public function Delete($config);

	/** Execute Quick Query Language string.
	 *
	 * @addition 2018-04-20
	 * @param	 array	 $config
	 */
	public function Quick($config, $options);

	/** Quote to SQL at each product.
	 *
	 * @addition 2018-04-20
	 * @param	 array	 $config
	 */
	public function Quote($config);

	/** Execute to SQL query string. And return records array.
	 *
	 * @addition 2018-04-20
	 * @param	 string	 $SQL
	 * @param	 string	 $type
	 * @return	 array	 $record
	 */
	public function SQL(string $SQL, string $type);
}
