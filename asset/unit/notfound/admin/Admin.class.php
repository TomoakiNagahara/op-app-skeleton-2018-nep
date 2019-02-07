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
	static function Selftest(\IF_DATABASE $db)
	{
		//	...
		if(!include(__DIR__.'/../selftest/Selftest.class.php') ){
			return false;
		}

		//	...
		return Selftest::Auto($db);
	}

	/** Get t_notfound record at host ai.
	 *
	 * @param	 string		 $host
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
		$config['field'][] = "sum(t_notfound.count) as count ";
		$config['field'][] = "t_notfound.timestamp  as timestamp ";
		$config['where'][] = "host = $ai";
		if( $date_st ){ $config['where'][] = "t_notfound.timestamp >= $date_st"; };
		if( $date_en ){ $config['where'][] = "t_notfound.timestamp <= $date_en"; };

		//	...
		if( \Env::isAdmin() ){
			self::$_debug['config'][] = $config;
		};

		//	...
		return $DB->Select($config);
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
