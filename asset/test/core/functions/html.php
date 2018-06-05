<?php
/**
 * unit-test:/core/functions/html.php
 *
 * @creation  2018-06-05
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$attr = '';
Html( "test case (empty)", $attr );

//	...
$attr = 'div';
Html( "test case ($attr)", $attr );

//	...
$attr = '#id';
Html( "test case ($attr)", $attr );

//	...
$attr = '.class';
Html( "test case ($attr)", $attr );
?>
<style>

#id:after {
	margin-left: 0.5em;
	color: blue;
	content:'GOOD';
}

.class:after {
	margin-left: 0.5em;
	color: blue;
	content:'GOOD';
}

</style>