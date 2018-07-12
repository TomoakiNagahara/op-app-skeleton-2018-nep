<?php
/**
 * unit-i18n:/i18n.class.php
 *
 * @creation  2018-07-11
 * @version   1.0
 * @package   unit-i18n
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-07-11
 */
namespace OP\UNIT;

/** i18n
 *
 * @creation  2018-07-11
 * @version   1.0
 * @package   unit-i18n
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class i18n
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Database table name.
	 *
	 * @var string
	 */
	const _table_ = 't_i18n';

	/** Target
	 *
	 * @var string
	 */
	private $_to;

	/** Source
	 *
	 * @var string
	 */
	private $_from;

	/** Service
	 *
	 * @var string
	 */
	private $_service;

	/** Database object.
	 *
	 * @var \OP\UNIT\Database
	 */
	private $_DB;

	/** To hash
	 *
	 * @param	 string	 $str
	 * @return	 string	 $hash
	 */
	private function _Hash($str)
	{
		return substr(md5(join(', ', [$str, $this->_from, $this->_to])), 0, 10);
	}

	/** Construct
	 *
	 */
	function __construct()
	{
		//	...
		if(!$config = \Env::Get('i18n') ){
			\Notice::Set("Has not been set i18n config.");
		}

		//	...
		if(!$this->_DB = \Unit::Instance('Database') ){
			return;
		}

		//	...
		$this->_DB->Connect($config);
	}

	/** Set to locale.
	 *
	 * @param	 string	 $locale
	 * @return	 string
	 */
	function To($locale)
	{
		return $this->_to = $locale;
	}

	/** Set from locale.
	 *
	 * @param	 string	 $locale
	 * @return	 string
	 */
	function From($locale)
	{
		return $this->_from = $locale;
	}

	/** Set service.
	 *
	 * @param	 string	 $service
	 * @return	 string
	 */
	function Service($service)
	{
		return $this->_service = $service;
	}

	/** Translate
	 *
	 * @param	 string	 $string
	 * @return	 string	 $string
	 */
	function Translate($string)
	{
		//	...
		if(!$this->_DB){
			return;
		}

		//	...
		$id = $this->_Hash($string);

		//	...
		$table = self::_table_;

		//	...
		if(!$translated = $this->_DB->Quick(" translated <- {$table}.id = {$id} ", ['limit'=>1]) ){
			/* @var $google \OP\UNIT\Google */
			if(!$google = \Unit::Singleton('Google') ){
				return;
			}

			//	...
			list($from) = explode('-', $this->_from.'-');
			list($to  ) = explode('-', $this->_to  .'-');

			//	...
			if(!$translated = $google->Translate($to, $from, [$string])[0] ){
				return $string;
			}

			//	...
			$insert = [
				'table' => $table,
				'set' => [
					'id'         => $id,
					'from'       => $this->_from,
					'to'         => $this->_to,
					'original'   => $string,
					'translated' => $translated,
				]
			];
			$result = $this->_DB->Insert($insert);
		}

		//	...
		return $translated;
	}
}
