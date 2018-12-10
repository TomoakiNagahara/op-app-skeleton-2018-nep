<?php
/**
 * unit-i18n:/Selftest.class.php
 *
 * @creation  2018-12-04
 * @version   1.0
 * @package   unit-i18n
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-12-04
 */
namespace OP\UNIT\I18N;

/** Selftest
 *
 * @creation  2018-12-04
 * @version   1.0
 * @package   unit-i18n
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Selftest
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Automatically
	 *
	 */
	static function Auto()
	{
		//	Generate instance.
		$selftest = \Unit::Instantiate('Selftest');

		//	Automatically do self test by configuration file.
		$selftest->Auto(__DIR__.'/selftest.conf.php');
	}
}
