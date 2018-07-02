<?php
/**
 * IF_ORM_RECORD.interface.php
 *
 * @creation  2018-06-29
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_ORM_RECORD
 *
 * @creation  2018-06-29
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_ORM_RECORD
{
	/** Is this record matches conditions?
	 *
	 *  True: Found saved record.
	 * False: Empty record. (Do save is create new record.)
	 *
	 * @return	 boolean	 $io
	 */
	public function isFind();

	/** Is this record values was valid by rule?
	 *
	 *  True: Can save.
	 * False: Can not save.
	 *
	 * @return	 boolean	 $io
	 */
	public function isValid();

	/** Return already instantiated Form object. (So-call singleton)
	 *
	 * @return	 \IF_FORM	 $form
	 */
	public function Form();
}
