<?php
/**
 * IF_ORM.interface.php
 *
 * @creation  2018-06-29
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_ORM
 *
 * @creation  2018-06-29
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_ORM
{
	/** Find record at QQL.
	 *
	 * @param	 string	 $qql
	 * @return
	 */
	public function Find($qql);

	/** Save array of record to database.
	 *
	 * @param	 array	 $record
	 */
	public function Save($record);
}
