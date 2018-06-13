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
	private $_navs;

	/** Generate URL Query.
	 *
	 * @param  array  $param
	 * @return string $query
	 */
	private function _Query(array $param)
	{
		return http_build_query(array_merge($_GET, $param));
	}

	/** Set
	 *
	 * @param string $label
	 * @param array  $param
	 */
	function Set(string $label, array $param)
	{
		$navi['label'] = $label;
		$navi['param'] = $param;
		$this->_navs[] = $navi;
	}

	/** Get
	 *
	 * @return array
	 */
	function Get()
	{
		return $this->_navs;
	}

	/** Out is display.
	 *
	 */
	function Out()
	{
		echo '<nav class="testcase">'.PHP_EOL;
		foreach( $this->_navs as $navi ){
			$label = $navi['label'];
			$param = $navi['param'];
			printf('<span><a href="?%s">%s</a></span>', $this->_query($param), $label);
		}
		echo '</nav>'.PHP_EOL;
	}
}
