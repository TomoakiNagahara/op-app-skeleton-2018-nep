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
Html( 'doc:'.ConvertURL('testcase:/') );
Html( ConvertPath('testcase:/core/functions/GetRootsPath') );
