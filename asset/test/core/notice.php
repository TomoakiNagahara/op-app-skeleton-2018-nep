<?php
/**
 * unit-test:/core/notice.php
 *
 * @creation  2018-04-18
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
?>
<section id="testcase">
	<h2>Notice of Core</h2>
	<div>
		<span><a href="?dump=1">Dump of Notice</a></span>
		<span><a href="<?= ConvertURL('testcase:/unit/notice') ?>">Unit of Notice</a></span>
	</div>
	<hr/>
</section>
<?php
//	...
if( $_GET['dump'] ?? 0 ){
	//	...
	Notice::Set("This is just Notice test. (Not Unit of Notice)");

	//	...
	D(Notice::Get());
}
