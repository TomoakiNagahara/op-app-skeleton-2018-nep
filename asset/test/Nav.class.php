<?php
/**
 * unit-test:/Nav.class.php
 *
 * @creation  2018-06-13
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Nav
 *
 * @created   2017-01-25
 * @version   1.0
 * @package   unit-form
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Nav
{
	/** Trait
	 *
	 */
	use \OP_CORE;

	/** Store
	 *
	 * @var array
	 */
	static private $_navs;

	/** Generate URL Query.
	 *
	 * @param	 array		 $param
	 * @param	 boolean	 $merge
	 * @return	 string		 $query
	 */
	static private function _Query(array $param, $merge)
	{
		return http_build_query( $merge ? array_merge($_GET, $param) : $param );
	}

	/** Set
	 *
	 * <pre>
	 * Nav::Set('Debug(ON)', ['debug'=>1]);
	 * </pre>
	 *
	 * @param	 string		 $label
	 * @param	 array		 $param
	 * @param	 boolean	 $merge
	 */
	static function Set(string $label, array $param, $merge=true )
	{
		$navi['label'] = $label;
		$navi['param'] = $param;
		$navi['merge'] = $merge;
		self::$_navs[] = $navi;
	}

	/** Get
	 *
	 * @return array
	 */
	static function Get()
	{
		return $this->_navs;
	}

	/** Out is display.
	 *
	 */
	static function Out()
	{
		echo '<nav class="testcase">'.PHP_EOL;
		foreach( self::$_navs ?? [] as $navi ){
			$label = $navi['label'];
			$param = $navi['param'];
			$merge = $navi['merge'];
			printf('<span><a href="?%s">%s</a></span>', self::_Query($param, $merge), $label);
		}
		echo '</nav>'.PHP_EOL;
	}
}
