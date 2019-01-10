<?php
/**
 * unit-test:/app/security.php
 *
 * @creation  2010-01-10
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
include('menu.phtml');

//	...
$urls = [];
$urls[] = 'app:/asset/test/secret.txt';
$urls[] = 'testcase:/.dot';
$urls[] = 'testcase:/secret.txt';
$urls[] = 'testcase:/secret.csv';
$urls[] = 'testcase:/secret.log';

//	...
$git = rtrim( ConvertURL('app:/.git/HEAD'), '/');

?>
<hr>
<ul>
	<li><a href="<?= $git ?>"><?= $git ?></a></li>
	<?php foreach( $urls as $url ): ?>
	<li><a href="<?= ConvertURL($url) ?>"><?= $url ?></a></li>
	<?php endforeach; ?>
</ul>
