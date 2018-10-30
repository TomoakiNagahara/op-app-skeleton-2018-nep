<?php
/**
 * unit-reference:/unit/action.php
 *
 * @creation  2018-10-30
 * @version   1.0
 * @package   unit-reference
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$path = ConvertPath("app:/asset/unit/{$args[2]}/README.md");

//	...
if(!file_exists($path) ){
	D('Does not exists README file.');
	return;
}
?>
<div>
	<code>
		<pre>
<?php include($path) ?>
		</pre>
	</code>
</div>
