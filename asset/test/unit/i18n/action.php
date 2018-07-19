<?php
/**
 * unit-test:/unit/i18n/action.php
 *
 * @creation  2018-07-11
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $i18n \OP\UNIT\i18n */
$i18n = Unit::Instance('i18n');

//	...
$i18n->To('ja-jp');
$i18n->From('en-us');
$i18n->Service('google');
echo $i18n->Translate('This is test.');
