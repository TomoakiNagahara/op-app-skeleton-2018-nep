<?php
/**
 * unit-notfound:/Selftest.class.php
 *
 * @creation  2019-02-04
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-04
 */
namespace OP\UNIT\NOTFOUND;

/** Selftest
 *
 * @creation  2019-02-04
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Selftest implements \IF_UNIT
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Will execute automatically of Selftest.
	 *
	 */
	static function Auto()
	{
		//	...
		if(!\Unit::Load('selftest') ){
			return;
		};

		/* @var $selftest \OP\UNIT\Selftest */
		if( $io = $selftest = \Unit::Instantiate('Selftest') ){
			$io = $selftest->Auto(__DIR__.'/../selftest/config.php');
		};

		//	...
		if( ($io === false) or ($config = $_GET['debug'] ?? null) ){
			$selftest->Debug($config);
		};

		//	...
		return $io;
	}

	/** For developers.
	 *
	 *
	 * @see \IF_UNIT::Help()
	 * @param	 string		 $topic
	 */
	function Help($topic=null)
	{
		echo '<pre><code>';
		echo file_get_contents(__DIR__.'/README.md');
		echo '</code></pre>';
	}

	/** For developers.
	 *
	 * @see \IF_UNIT::Debug()
	 * @param	 string		 $topic
	 */
	function Debug($topic=null, $selftest=null)
	{

	}
}
