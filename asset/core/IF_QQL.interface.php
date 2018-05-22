<?php
/**
 * IF_QQL.interface.php
 *
 * @creation  2018-05-14
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_QQL
 *
 * @creation  2018-05-14
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL
{
	/** Parse from QQL and return assoc array.
	 *
	 * @param	 string		 $QQL
	 * @param	\IF_DATABASE $DB
	 * @return	 array		 $config
	 */
	static private function _Parse($QQL, $DB);

	/** Build SQL query from assoc array.
	 *
	 * @param	 array		 $config
	 * @param	\IF_DATABASE $DB
	 * @return	 string		 $SQL
	 */
	static private function _Build($config, $DB);

	/** Get configuration.
	 *
	 * @return	 array		 $config
	 */
	static public function Config();

	/** Execute SQL query and return fetch record.
	 *
	 * @param	 string		 $SQL
	 * @param	\IF_DATABASE $DB
	 * @return	 array		 $record
	 */
	static public function Execute($SQL, $DB);
}
