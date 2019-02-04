<?php
/**
 * unit-test:/webserver/nginx/javascript.php
 *
 * @creation  2018-11-08
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
var_dump( $_SERVER['REQUEST_URI'] );

//	...
$path = dirname(__FILE__).'/test.js';
?>
<script type="text/javascript" src="<?= $path ?>"></script>
