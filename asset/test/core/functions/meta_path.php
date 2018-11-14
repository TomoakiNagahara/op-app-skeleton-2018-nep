<?php
/**
 * unit-test:/core/functions/_GetRootsPath.php
 *
 * @creation  2018-04-23
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	...
D( _GetRootsPath() );

//	...
$source = 'app:/foo/bar';
$temp[$source] = ConvertURL($source);

//	...
$source = 'app:/foo/bar?foo=bar';
$temp[$source] = ConvertURL($source);

//	...
$source = 'app:/foo/bar/index.html';
$temp[$source] = ConvertURL($source);

//	...
$source = 'app:/foo/bar/index.html?foo=bar';
$temp[$source] = ConvertURL($source);

//	...
$source = 'app:/foo.bar';
$temp[$source] = ConvertURL($source);

//	...
$source = 'app:/foo.bar/hoge';
$temp[$source] = ConvertURL($source);

//	...
D($temp);
