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
	static function Auto()
	{
		//	...
		if(!$db = Common::DB() ){
			//	Throw away connection error notice.
			$notice = \Notice::Pop();

			//	...
			D($notice['message']);
			D(\Env::Get('notfound'));

			//	...
			if( include(__DIR__.'/../selftest/Selftest.class.php') ){
				Selftest::Auto($db);
			};

			//	...
			return;
		};

		//	...
		if(!$io = \Cookie::Get(__METHOD__) ){
			if(!$io = self::Selftest($db) ){
				return $io;
			};
		};

		//	Save selftest result.
		\Cookie::Set(__METHOD__, true, 60*60*24);

		/* @var $form \IF_FORM */
		$form = self::Form();

		//	...
		return include(__DIR__.'/admin.phtml');
	}

	/** Form
	 *
	 */
	static function Form()
	{
		/* @var $form \IF_FORM */
		static $form;

		//	...
		if(!$form ){
			$form = \Unit::Instantiate('Form');
			$form->Config(__DIR__.'/config.form.php');

			//	...
			if( \Env::isAdmin() ){
				if(!$form->Test() ){
					D('$form->Test() was failed.');
				};
			};
		};

		//	...
		return $form;
	}

	/** Will execute automatically of Selftest.
	 *
	 * @return boolean
	 */
	static function Selftest()
	{
		//	...
		if(!include_once(__DIR__.'/../selftest/Selftest.class.php') ){
			return false;
		}

		//	...
		return Selftest::Auto();
	}

	/** Get t_notfound record at host.
	 *
	 * @return	 array		 $record
	 */
	static function GetRecordAtHost():array
	{
		//	...
		$form    = self::Form();
		$host    = $form->GetValue('host');
		$date_st = $form->GetValue('date-st');
		$date_en = $form->GetValue('date-en');
		$hash    = Common::Hash($host);
		$DB      = Common::DB();
		$ai      = $DB->Quick(" ai <- t_host.hash = $hash ", ['limit'=>1]);

		//	...
		if(!$ai ){
			return [];
		};

		//	...
		$config = [];
		$config['table'] = 't_notfound.uri <= t_uri.ai, t_notfound.ua <= t_ua.ai';
		$config['limit'] = 100;
		$config['order'] = 'count desc';
		$config['group'] = 't_notfound.uri';
		$config['field'][] = "t_notfound.ai  as ai     ";
		$config['field'][] = "t_notfound.uri as uri_ai ";
	//	$config['field'][] = "t_notfound.ua  as ua_ai  ";
		$config['field'][] = "t_uri.uri      as uri    ";
	//	$config['field'][] = "t_ua.ua        as ua     ";
		$config['field'][] = "sum(t_notfound.count) as count     ";
		$config['field'][] = "t_notfound.timestamp  as timestamp ";
		$config['where'][] = "host = $ai";
		if( $date_st ){ $config['where'][] = "t_notfound.timestamp >= $date_st 00:00:00"; };
		if( $date_en ){ $config['where'][] = "t_notfound.timestamp <= $date_en 23:59:60"; }; // 60 is Leap seconds.

		//	...
		if( \Env::isAdmin() ){
			self::$_debug['config'][] = $config;
		};

		//	...
		return $DB->Select($config);
	}

	/** Get t_uri record at uri.
	 *
	 * @return	 array		 $record
	 */
	static function GetRecordAtURI():array
	{
		//	...
		if(!$uri = $_GET['uri'] ?? null ){
			return [];
		};

		//	...
		$config = [];
		$config['limit'] = 100;
		$config['order'] = 'count desc';
		$config['where'][] = "t_notfound.uri = $uri";

		//	...
		$config['table'] = '  t_notfound.uri <= t_uri.ai'
						 . ', t_notfound.ua  <= t_ua.ai'
						 . ', t_ua.os        <= t_ua_os.ai'
						 . ', t_ua.browser   <= t_ua_browser.ai';
		//	...
		 $config['field'][] = 't_notfound.count     as count';
		 $config['field'][] = 't_ua_os.os           as os';
		 $config['field'][] = 't_ua_os.version      as os_version';
		 $config['field'][] = 't_ua_browser.browser as browser';
		 $config['field'][] = 't_ua_browser.version as browser_version';
		 $config['field'][] = 'concat(t_ua_os.os, " ", t_ua_os.version) as OS';
		 $config['field'][] = 'concat(t_ua_browser.browser, " ", t_ua_browser.version) as Browser';

		//	...
		return Common::DB()->Select($config);
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
