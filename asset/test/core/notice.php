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
		| <a href="<?= ConvertURL('testcase:/unit/notice') ?>">Unit of Notice</a> |
	</div>
	<hr/>
</section>
<?php
//	...
Notice::Set("This is just Notice test. (Not Unit of Notice)");

//	...
D(Notice::Get());
