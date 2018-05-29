<?php
/**
 * unit-test:/index.inc.php
 *
 * @creation  2018-05-31
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Display navigation links.
 *
 * @param array $navies
 */
function __navigation($navies){
	echo '<nav class="testcase">'.PHP_EOL;
	foreach( $navies as $navi ){
		$label = $navi['label'];
		$url   = $navi['url'];
		printf('<span><a href="%s">%s</a></span>', $url, $label);
	}
	echo '</nav>'.PHP_EOL;
}
