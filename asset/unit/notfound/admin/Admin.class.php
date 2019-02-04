<?php
/**
 * unit-notfound:/Admin.class.php
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

/** Admin
 *
 * @creation  2019-02-04
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Admin implements \IF_UNIT
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Debug.
	 *
	 * @var array
	 */
	static private $_debug;

	/** Will execute automatically of Admin.
	 *
	 */
	static function Auto(\IF_DATABASE $db)
	{
		//	...
		if(!$io = \Cookie::Get(__METHOD__) ){
			if(!$io = self::Selftest() ){
				return $io;
			};
		};

		//	Save selftest result.
		\Cookie::Set(__METHOD__, true, 60*60*24);

		//	...
		include(__DIR__.'/admin.phtml');
	}

	/** Form
	 *
	 */
	static function Form()
	{
		return include(__DIR__.'/admin.form.php');
	}

	/** Will execute automatically of Selftest.
	 *
	 * @return boolean
	 */
	static function Selftest()
	{
		//	...
		if(!\Unit::Load('selftest') ){
			return;
		};

		/* @var $selftest \OP\UNIT\Selftest */
		if( $io = $selftest = \Unit::Instantiate('Selftest') ){
			$io = $selftest->Auto(__DIR__.'/config.selftest.php');
		};

		//	...
		if( false ){
			//	$selftest->Help();
			//	$selftest->Debug();
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
	function Debug($topic=null)
	{
		D( self::$_debug );
	}
}
